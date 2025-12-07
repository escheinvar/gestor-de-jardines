<?php

namespace App\Livewire\Coleccion;

use App\Http\Controllers\Api\camellones;
use App\Models\cat_camellones;
use App\Models\cat_campus;
use App\Models\cat_conceptos;
use App\Models\cat_iconos;
use App\Models\ej_conteos;
use App\Models\ej_nombres_cientificos;
use App\Models\ej_nombres_comunes;
use App\Models\ej_ubicaciones;
use App\Models\ejemplares;
use App\Models\usr_roles;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UbicacionController extends Component
{
    public $ubica, $HayUbica;       ##### Ubica tiene datos de ubicacion (de tabla ej_ubicaciones) y HayUbica es Flag que indica (1) si hay ubicación del ejemplar o (0) no hay ubicación del ejemplar
    public $idEjem;                      ##### Variables recibidas desde URL (Id del ejemplar)
    public $MenuDeEjemplares='ubicacion', $ejemplar, $ejemplar_ScName, $ejemplar_CoName, $ejemplar_ubica;  ##### Variables solicitadas por la plantilla del menú del ejemplar
    public $edit_curcient, $edit_adcolviva, $CampusAutorizados;     ##### Variable solicitadas por front-end para entrar en modo edición
    public $campus, $camellon, $latitud, $longitud, $restriccion, $notas, $tipocrecim, $colonias, $cantidad, $icono;
    public $temp, $color1;

    public function mount($id){
        ######################################################
        ####################### Validaciones de permisos y URL
        ##### Revisa que el id sea sólo numérico
        if( !preg_match('/^\d+$/',$id)){
            return redirect()->route('error',["Error en el número de ejemplar"]);
        }

        ##### Confirma id correcto y carga datos
        if($id == '0'){
            $this->idEjem='0';
        }else{
            if(ejemplares::where('ejm_id',$id)->where('ejm_act','1')->where('ejm_del','0')->count() != '1'){
                return redirect()->route('error',["El número de ejemplar no existe"]);
            }
            $this->idEjem=$id;

            #############################################################
            ###### Carga los datos para la plantilla del menú de ejemplar
            $this->ejemplar=ejemplares::where('ejm_id',$this->idEjem)
                ->join('ej_bitacora1','ejm_bitid','=','bit_id')
                ->where('ejm_act','1')
                ->where('ejm_del','0')
                ->where('bit_del','0')
                ->first();
            $this->ejemplar_ScName=ej_nombres_cientificos::where('scn_ejmid',$this->idEjem)
                ->where('scn_act','1')
                ->where('scn_del','0')
                ->first();
            $this->ejemplar_CoName = ej_nombres_comunes::where('con_ejmid',$this->idEjem)
                ->where('con_act','1')
                ->where('con_del','0')
                ->orderBy('con_origen','desc')
                ->orderBy('con_bibid','asc')
                ->take(3)
                ->get();
            $this->ejemplar_ubica = ej_ubicaciones::where('sig_ejmid',$this->idEjem)
                ->where('sig_act','1')
                ->where('sig_del','0')
                ->first();

            #######################################################
            ############################## Revisa si hay ubicación previa
            $ubica=ej_ubicaciones::where('sig_ejmid',$this->idEjem)
                ->where('sig_act','1')
                ->where('sig_del','0')
                ->first();
            $this->ubica=$ubica;

            if($this->ubica){
                $this->HayUbica='1';
                ###################################
                ###### Carga los datos del ejemplar
                $this->campus=$ubica->sig_ccamsiglas;
                $this->camellon= $ubica->sig_camid;
                $this->latitud = $ubica->sig_x;
                $this->longitud = $ubica->sig_y;
                $this->restriccion = $ubica->sig_restriccion;
                $this->notas = $ubica->sig_notas;
                $this->tipocrecim = $ubica->sig_tipocrecim;
                $this->colonias = ej_conteos::where('cant_ejmid',$this->idEjem)->where('cant_act','1')->where('cant_del','0')->orderBy('cant_fecha')->first()->value('cant_cols');
                $this->cantidad = ej_conteos::where('cant_ejmid',$this->idEjem)->where('cant_act','1')->where('cant_del','0')->orderBy('cant_fecha')->first()->value('cant_inds');
                $this->icono = $ubica->sig_icono;
            }else{
                $this->HayUbica='0';
            }
            ########################### Monta valores iniciales
            $this->campus=$this->ejemplar->ejm_ccamsiglas;
            $this->restriccion='0';
            #######################################################
            ############################### Monta el mapa
            $CampusIdDelEjemplar=ejemplares::where('ejm_id',$this->idEjem)
                ->leftJoin('cat_campus','ejm_ccamsiglas','=','ccam_siglas')
                ->value('ccam_id');
            $camellones=cat_camellones::where('cam_ccamid',$CampusIdDelEjemplar)->get();

            // dd($CampusIdDelEjemplar,$camellones);
            if($this->HayUbica=='0'){
                $this->MapaCamellones($camellones,'0',null);
            }elseif($this->HayUbica=='1'){
                $this->MapaCamellones($camellones,'0',$this->ubica->sig_camid);
            }
            $this->color1="btn-secondary";
        }
    }

    public function MapaCamellones($datos,$streetMap,$DestacaId){
        ##### Esta función requiere $datos, con la seleccion de cat_camellon a mapear
        ##### $streetMap=1 como binario 0, 1 indicando si aparece fondo de StreeMap (1) o no (0)
        ##### $DestacaId contiene null ó cam_id. Cuando null, muestra todo $datos, pero cuando
        ##### es igial a cam_id, muestra $datos en gris y destaca y centra cam_id
        // $streetMap='1';
        // $datos=cat_camellones::join('cat_campus','cam_ccamid','=','ccam_id')
        //     ->where('ccam_siglas',$this->CampusSelected)
        //     ->get();
        // $DestacaId=30;

        ###### Calcula X y Y inicial (para visualizar el mapa)
        if($DestacaId==null){
            $centrar=$datos;
        }else{
            $centrar=$datos->where('cam_id',$DestacaId);
        }
        $xmin = $centrar->min('cam_xmin');
        $ymin = $centrar->min('cam_ymin');
        $xmax = $centrar->max('cam_xmax');
        $ymax = $centrar->max('cam_ymax');
        $x= ($xmax+$xmin)/2;
        $y= ($ymax+$ymin)/2;
        ######## Calcula zoom
        $difx= $xmax - $xmin;
        $dify= $ymax - $ymin;
        $max=max(abs($difx),abs($dify));
        ###### calcula nivel de zoom
        if($max < 0.0000018){
            $zoom=24;
        }elseif($max >= 0.0000018 AND $max < 0.000018){
            $zoom=23;
        }elseif($max >= 0.000018 AND $max < 0.00018){
            $zoom=22;
        }elseif($max >= 0.00018 AND $max < 0.0018){ #### 0.00089gr=100 mts, 0.0018=200mts
            $zoom=19;  ### 19=máximo zoom (bien cerca)
        }elseif($max >= 0.0018 AND $max < 0.0127){  #### 0.0018=200m, 0.127=300mts
            $zoom=18;
        }elseif($max >= 0.0127 AND $max < 0.054){  ### 300 a 600 mts
            $zoom=17;
        }else{
            $zoom=16;  ### Vista lejana de una colonia
        }
        $this->temp=$zoom."-".$max;
        ##### Pasa lista de camellones a array y lo manda a java
        $mapas=$datos->toArray();

        $this->dispatch('CierraMapa');
        $this->dispatch('IniciaMapaCamellones', zoom:$zoom, streetmap:$streetMap, mapas:$mapas, x:$x, y:$y, DestacaId:$DestacaId);
    }

    public function SeleccionaCoords(){
        $this->color1="btn-success";
        $this->dispatch('CapturaCoordenadas');
    }

    public function GuardaUbicacion(){
        $this->validate([
            'campus'=>'required',
            'camellon'=>'required',
            'latitud'=>'required',
            'longitud'=>'required',
            'restriccion'=>'required',
            'tipocrecim'=>'required',
        ]);
        if(in_array($this->tipocrecim,['individual distinguible','indistinguible'])){
            $this->validate([
                'cantidad'=>'required',
            ]);
        }elseif(in_array($this->tipocrecim,['colonial'])){
            $this->validate([
                'colonias'=>'required',
            ]);
        }elseif(in_array($this->tipocrecim,['individual en colonia'])){
            $this->validate([
                'colonias'=>'required',
                'cantidad'=>'required',
            ]);
        }


        ####### Prepara nuevos valores para ubicaicón
        $valores=[
            'sig_ejmid'=>$this->idEjem,
            'sig_ccamsiglas'=>$this->ejemplar->ejm_ccamsiglas,
            'sig_camid'=>$this->camellon,
            'sig_camcamellon'=>cat_camellones::where('cam_id',$this->camellon)->value('cam_camellon'),
            'sig_x'=>$this->latitud,
            'sig_y'=>$this->longitud,
            'sig_restriccion'=>$this->restriccion,
            'sig_tipocrecim'=>$this->tipocrecim,
            'sig_icono'=>$this->icono,
            'sig_notas'=>$this->notas,
            'sig_usrid'=>Auth::user()->id,
        ];

        ##### Inactiva ubicaciones previas
        if($this->HayUbica == '1'){
            ej_ubicaciones::where('sig_ejmid',$this->idEjem)->update([
                'sig_act'=>'0'
            ]);
        }
        ##### guarda nuevo registro de ubicación
        $nuevo=ej_ubicaciones::create($valores);

        ##### inactiva conteos previos
        ej_conteos::where('cant_ejmid',$this->idEjem)->update([
            'cant_act'=>'0'
        ]);

        ###### Guarda conteo
        ej_conteos::create([
            'cant_ejmid'=>$this->idEjem,
            'cant_ubicaid'=>$nuevo->sig_id,
            'cant_tipo'=>$this->tipocrecim,
            'cant_parcial'=>$this->cantidad,
            'cant_cols'=>$this->colonias,
            'cant_inds'=>$this->cantidad,
            'cant_fecha'=>date('Y-m-d'),
            'cant_usrid'=>Auth::user()->id,
        ]);

        ##### Redirecciona
        $this->dispatch('AvisoExito',msj:'Se guardaron los datos exitosamente');
        return redirect('ejem_ubica/'.$this->idEjem);
    }

    public function MuestraCamellon(){
        #######################################################
        ############################### Monta el mapa
        $CampusIdDelEjemplar=cat_campus::where('ccam_siglas',$this->ejemplar->ejm_ccamsiglas)->value('ccam_id');
        $camellones=cat_camellones::where('cam_ccamid',$CampusIdDelEjemplar)->get();
        $this->color1="btn-secondary";
        $this->MapaCamellones($camellones,'0',$this->camellon);
    }

    public function render() {
        ###################################################################
        ##################################### Prepara autorizaciones
        $CampusDelEjemplar=$this->ejemplar->ejm_ccamsiglas;
        $CampusIdDelEjemplar=cat_campus::where('ccam_siglas',$this->ejemplar->ejm_ccamsiglas)->value('ccam_id');
        ##### Permisos admin-colviva,
        $this->edit_adcolviva='0';
        if(array_intersect(['admin-colviva'],session('rol'))){
            $CampusAutorizados2=usr_roles::where('rol_crolrol','admin-colviva')
                ->where('rol_usrid',Auth::user()->id)
                ->where('rol_del','0')->where('rol_act','1')
                ->pluck('rol_ccamsiglas')
                ->toArray();
            if(in_array($CampusDelEjemplar, $CampusAutorizados2) OR  in_array('todos',$CampusAutorizados2) ){
                $this->edit_adcolviva='1';
            }
        }

        #################################################################
        ################### Carga ubicación
        $this->ubica=ej_ubicaciones::where('sig_ejmid',$this->idEjem)
            ->where('sig_act','1')
            ->where('sig_del','0')
            ->first();
        if($this->ubica){
            $this->HayUbica='1';
        }else{
            $this->HayUbica='0';
        }

        ########## Obtiene catálogos
        $camellones=cat_camellones::where('cam_ccamid',$CampusIdDelEjemplar)->get();
        $tiposcrecimiento=cat_conceptos::where('con_tema','tipo-crecimiento')->select('con_txt')->get();
        $iconos=cat_iconos::all();
        return view('livewire.coleccion.ubicacion-controller',[
            'camellones'=>$camellones,
            'tiposcrecimiento'=>$tiposcrecimiento,
            'iconos'=>$iconos,
        ]);
    }
}
