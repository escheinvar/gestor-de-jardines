<?php

namespace App\Livewire\Coleccion;

use App\Http\Controllers\Api\camellones;
use App\Models\cat_camellones;
use App\Models\cat_campus;
use App\Models\cat_conceptos;
use App\Models\ej_nombres_cientificos;
use App\Models\ej_nombres_comunes;
use App\Models\ejemplares;
use App\Models\usr_roles;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UbicacionController extends Component
{
    public $HayUbica;       ##### Flag que indica (1) si hay ubicación del ejemplar o (0) no hay ubicación del ejemplar
    public $idEjem;                      ##### Variables recibidas desde URL (Id del ejemplar)
    public $MenuDeEjemplares='ubicacion', $ejemplar, $ejemplar_ScName, $ejemplar_CoName;  ##### Variables solicitadas por la plantilla del menú del ejemplar
    public $edit_curcient, $edit_adcolviva, $CampusAutorizados;     ##### Variable solicitadas por front-end para entrar en modo edición
    public $campus, $camellon, $latitud, $longitud, $restriccion, $notas, $tipocrecim, $cantidad, $icono;

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

        }
    }

    public $temp;
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
        dd('falta lógica de coordenadas');
    }


    public function render() {
        ###################################################################
        ##################################### Prepara autorizaciones
        $CampusDelEjemplar=$this->ejemplar->ejm_ccamsiglas;
        $CampusIdDelEjemplar=cat_campus::where('ccam_siglas',$this->ejemplar->ejm_ccamsiglas)->value('ccam_id');

        ##### Permisos curador-científico,
        $this->edit_curcient='0';
        if(array_intersect(['curador-cientifico'],session('rol'))){
            $CampusAutorizados1=usr_roles::where('rol_crolrol','curador-cientifico')
                ->where('rol_usrid',Auth::user()->id)
                ->where('rol_del','0')->where('rol_act','1')
                ->pluck('rol_ccamsiglas')
                ->toArray();
            if(in_array($CampusDelEjemplar, $CampusAutorizados1) OR  in_array('todos',$CampusAutorizados1) ){
                $this->edit_curcient='1';
            }
        }
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

        ########## Obtiene catálogos
        $camellones=cat_camellones::where('cam_ccamid',$CampusIdDelEjemplar)->get();
        $tiposcrecimiento=cat_conceptos::where('con_tema','tipo-crecimiento')->select('con_txt')->get();

        return view('livewire.coleccion.ubicacion-controller',[
            'camellones'=>$camellones,
            'tiposcrecimiento'=>$tiposcrecimiento,
        ]);
    }
}
