<?php

namespace App\Livewire\Coleccion;

use App\Http\Controllers\Api\camellones;
use App\Models\cat_camellones;
use App\Models\cat_campus;
use App\Models\cat_conceptos;
use App\Models\cat_gridas;
use App\Models\cat_iconos;
use App\Models\ej_alias;
use App\Models\ej_colecciones;
use App\Models\ej_conteos;
use App\Models\ej_nombres_cientificos;
use App\Models\ej_nombres_comunes;
use App\Models\ej_subcolecciones;
use App\Models\ej_ubicaciones;
use App\Models\ejemplares;
use App\Models\imagenes;
use App\Models\usr_roles;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UbicacionController extends Component
{
    public $ubica, $HayUbica;       ##### Ubica tiene datos de ubicacion (de tabla ej_ubicaciones) y HayUbica es Flag que indica (1) si hay ubicación del ejemplar o (0) no hay ubicación del ejemplar
    public $idEjem;                      ##### Variables recibidas desde URL (Id del ejemplar)
    public $MenuDeEjemplares='ubicacion', $ejemplar, $ejemplar_ScName, $ejemplar_CoName, $ejemplar_ubica;  ##### Variables solicitadas por la plantilla del menú del ejemplar
    public $edit_curcient, $edit_adcolviva, $CampusAutorizados;     ##### Variable solicitadas por front-end para entrar en modo edición
    public $MovimientoActivo; #### Flag que permite(1) o no (0) mover datos
    public $campus, $camellon, $latitud, $longitud, $restriccion, $notas, $tipocrecim, $colonias, $cantidad, $icono, $alias, $grida;
    public $temp, $color1;
    public $verBaja, $razonBaja, $fechaBaja, $explicaBaja;
    public $MapaConEtiquetas;

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
                $this->latitud = $ubica->sig_y;
                $this->longitud = $ubica->sig_x;
                $this->restriccion = $ubica->sig_restriccion;
                $this->notas = $ubica->sig_notas;
                // $this->tipocrecim = $ubica->sig_tipocrecim;
                $conteo=ej_conteos::where('cant_ejmid',$this->idEjem)->where('cant_act','1')->where('cant_del','0')->first();
                $this->colonias = $conteo->cant_ext;
                $this->cantidad = $conteo->cant_inds;
                $icono=preg_replace('/\/iconos\//','',$ubica->sig_icono);
                $icono=preg_replace('/\....$/','',$icono);
                // dd($ubica->sig_icono,$icono);
                $this->icono = $icono;
            }else{
                $this->HayUbica='0';
                $this->icono='PuntoVerde';
            }
            ########################### Monta valores iniciales
            $this->campus=$this->ejemplar->ejm_ccamsiglas;
            $this->restriccion='0';
            $this->MovimientoActivo='0';
            $this->verBaja='0';
            $this->MapaConEtiquetas='0';

            #######################################################
            ############################### Monta el mapa
            $CampusIdDelEjemplar=ejemplares::where('ejm_id',$this->idEjem)
                ->leftJoin('cat_campus','ejm_ccamsiglas','=','ccam_siglas')
                ->value('ccam_id');
            $camellones=cat_camellones::where('cam_ccamid',$CampusIdDelEjemplar)->get();

            // dd($CampusIdDelEjemplar,$camellones);

            if($this->HayUbica=='0'){
                $this->MapaCamellones($camellones,'0','null','null','null',$this->MapaConEtiquetas, 'null');

            }elseif($this->HayUbica=='1'){
                $Ubicaciones=ej_ubicaciones::leftJoin('cat_iconos','sig_icono','=','icon_name')
                    ->where('sig_camid',$this->ubica->sig_camid)
                    ->where('sig_act','1')->where('sig_del','0')
                    ->leftJoin('imagenes', function($join){
                        $join->on('sig_ejmid','=','img_ejmid')
                            ->where('img_cimgtipo','ejemplar_portada')
                            ->where('img_act','1')
                            ->where('img_del','0')
                            ->limit(1);
                    })
                    ->get()->toArray();
                $this->MapaCamellones($camellones,'0',$this->ubica->sig_camid, $Ubicaciones, $ubica->sig_id,$this->MapaConEtiquetas,'null');
            }
            $this->color1="btn-secondary";
        }
    }


    public function MapaCamellones($camellones, $streetMap, $DestacaCamId, $Ejemplares, $DestacaEjemId, $etiquetas, $Grida){
        ##### Esta función requiere que se definan las siguientes variables:
        ##### $camellones = cat_camellon::get() ó 'null' con la seleccion de camellones a mapear (si es 'null', solo muestra los ejemplares)
        ##### $streetMap='1' ó '0' Indica si se muestra fondo de StreeMap (1) o no (0)
        ##### $DestacaCamId= 'null' ó cam_id. Cuando cam_id, destaca y centra el camellón indicado.
        ##### $Ejemplares= 'null' o ej_ubicaciones::join('cat_iconos','sig_icono','=','icon_name')->get()
        #####               con el listado de puntos a mostrar (y sus íconos). Si no hay join de íconos,
        #####               solo muestra camellones
        ##### $DestacaEjemId= 'null' o sig_id; con el id del registro a destacar
        ##### $etiquetas='1' ó '0' Indica si semuestran popups con datos de ejemplares y camellones

        ##### Quita camellones sin coordenadas:
        ###### Calcula X y Y inicial (para visualizar el mapa)
        if($camellones != 'null'){
            if($DestacaCamId=='null'){
                $centrar=$camellones;
            }else{
                $centrar=$camellones->where('cam_id',$DestacaCamId);
            }
            $xmin = $centrar->min('cam_xmin');
            $ymin = $centrar->min('cam_ymin');
            $xmax = $centrar->max('cam_xmax');
            $ymax = $centrar->max('cam_ymax');

        }else{
            if($DestacaEjemId=='null'){
                $centrar=$Ejemplares;
            }else{
                $centrar=$Ejemplares->where('sig_id',$DestacaEjemId);
            }
            $xmin = $centrar->min('sig_x');
            $ymin = $centrar->min('sig_y');
            $xmax = $centrar->max('sig_x');
            $ymax = $centrar->max('sig_y');
        }
        $x= ($xmax+$xmin)/2;
        $y= ($ymax+$ymin)/2;

        // dd('coords:',$xmin,$xmax,$ymin,$ymax,  $x,$y);
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
        // $this->temp=$zoom."-".$max;

        ##### Pasa lista de camellones a array y lo manda a java
        if($camellones != 'null'){
            $camellones=$camellones->toArray();
        }else{
            $camellones='null';
        }
        $this->dispatch('CierraMapa');

        ##### Para capturar coordenadas, se requiere etiquetas=null
        $this->dispatch('IniciaMapaCamellones', etiquetas:$etiquetas, camellones:$camellones, DestacaCamId:$DestacaCamId, streetmap:$streetMap, zoom:$zoom, x:$x, y:$y,  Ejemplares:$Ejemplares, DestacaEjemId:$DestacaEjemId, Grida:$Grida);
    }

    public function SeleccionaGrida(){
        #######################################################
        ############################### Monta el mapa
        $CampusIdDelEjemplar=ejemplares::where('ejm_id',$this->idEjem)
            ->leftJoin('cat_campus','ejm_ccamsiglas','=','ccam_siglas')
            ->value('ccam_id');
        $camellones=cat_camellones::where('cam_ccamid',$CampusIdDelEjemplar)->get();

        if($this->HayUbica=='0'){
            $this->MapaCamellones($camellones,'0','null','null','null',$this->MapaConEtiquetas,'null');

        }elseif($this->HayUbica=='1'){
            $Ubicaciones=ej_ubicaciones::leftJoin('cat_iconos','sig_icono','=','icon_name')
                ->where('sig_camid',$this->ubica->sig_camid)
                ->where('sig_act','1')->where('sig_del','0')
                ->leftJoin('imagenes', function($join){
                    $join->on('sig_ejmid','=','img_ejmid')
                        ->where('img_cimgtipo','ejemplar_portada')
                        ->where('img_act','1')
                        ->where('img_del','0')
                        ->limit(1);
                })
                ->get()->toArray();
            if($this->grida != ''){
                $grida=cat_gridas::where('gri_id',$this->grida)->get();
                $this->MapaCamellones($camellones,'0',$this->ubica->sig_camid, $Ubicaciones, $this->ubica->sig_id,$this->MapaConEtiquetas, $grida);
            }else{
                $this->MapaCamellones($camellones,'0',$this->ubica->sig_camid, $Ubicaciones, $this->ubica->sig_id,$this->MapaConEtiquetas, 'null');
            }
        }
    }

    public function SeleccionaCoords(){
        $this->color1="btn-success";
        $this->MapaConEtiquetas='0';
        $this->dispatch('CapturaCoordenadas');
    }

    public function GuardaUbicacion(){
        $this->validate([
            'campus'=>'required',
            'camellon'=>'required',
            'latitud'=>'required',
            'longitud'=>'required',
            'restriccion'=>'required',
            'colonias'=>'required',
            'cantidad'=>'required'
        ]);

        ####### Prepara nuevos valores para ubicaicón
        $valores=[
            'sig_ejmid'=>$this->idEjem,
            'sig_ccamsiglas'=>$this->ejemplar->ejm_ccamsiglas,
            'sig_camid'=>$this->camellon,
            'sig_camcamellon'=>cat_camellones::where('cam_id',$this->camellon)->value('cam_camellon'),
            'sig_x'=>$this->longitud,
            'sig_y'=>$this->latitud,
            'sig_restriccion'=>$this->restriccion,
            'sig_icono'=>cat_iconos::where('icon_name',$this->icono)->value('icon_file'),
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
            // 'cant_tipo'=>$this->tipocrecim,
            'cant_parcial'=>$this->cantidad,
            'cant_cols'=>$this->colonias,
            'cant_inds'=>$this->cantidad,
            'cant_fecha'=>date('Y-m-d'),
            'cant_usrid'=>Auth::user()->id,
        ]);

        ##### Redirecciona
        $this->dispatch('AvisoExitoUbicacion',msj:'Se guardaron los datos exitosamente');
        return redirect('ejem_ubica/'.$this->idEjem);
    }

    public function MuestraCamellon(){
        #######################################################
        ############################### Monta el mapa
        if($this->camellon != ''){
            $CampusIdDelEjemplar=cat_campus::where('ccam_siglas',$this->ejemplar->ejm_ccamsiglas)->value('ccam_id');
            $camellones=cat_camellones::where('cam_ccamid',$CampusIdDelEjemplar)->get();
            $Ubicaciones=ej_ubicaciones::where('sig_camid',$this->camellon)
                ->where('sig_act','1')
                ->where('sig_del','0')
                ->leftJoin('imagenes', function($join){
                        $join->on('sig_ejmid','=','img_ejmid')
                            ->where('img_cimgtipo','ejemplar_portada')
                            ->where('img_act','1')
                            ->where('img_del','0')
                            ->limit(1);
                    })
                ->get()->toArray();
            ##### Cambia color del ícono
            $this->color1="btn-secondary";
            $this->grida='';
            ##### Ejecuta mapa
            $this->MapaCamellones($camellones,'0',$this->camellon,$Ubicaciones,'null',$this->MapaConEtiquetas,'null');
        }
    }

    public function ActivarDesactivarMovimientos(){
        if($this->MovimientoActivo=='0'){
            $this->MovimientoActivo='1';
        }else{
            $this->MovimientoActivo='0';
        }
    }

    public function VerNoVerBaja(){
        if($this->verBaja=='0'){
            $this->verBaja='1';
        }else{
            $this->verBaja='0';
        }
    }

    public function DarDeBaja(){
        $this->validate([
            'razonBaja'=>'required',
            'fechaBaja'=>'required',
            'explicaBaja'=>'required',
        ]);

        ejemplares::where('ejm_id',$this->idEjem)->update([
            'ejm_del'=>'1',
            'ejm_ripdate'=>$this->fechaBaja,
            'ejm_ripcausa'=>$this->razonBaja.": ".$this->explicaBaja,
        ]);
        $this->razonBaja='';
        $this->fechaBaja='';
        $this->explicaBaja='';
        $this->verBaja='0';
        $this->dispatch('AvisoExitoUbicacion', msj:'El ejemplar fue dado de baja definitiva de la colección.');
        redirect('/ejemplares');
    }

    public function abreModalAlias(){
        $data=['ejmId'=>$this->idEjem, 'tipo'=>'ubicación']; ##### ejmId=número Id del ejemplar; tipo=['ejemplar','bitácora','ubicación','otro']
        $this->dispatch('abreModalDeAlias',$data);
    }

    public function BorrarAlias($IDalias){
        ej_alias::where('alias_id',$IDalias)->update([
            'alias_del'=>'1',
        ]);
        // redirect('/ejem_ubica'.$this->idEjem);
    }

    public function AbreElModalDecolecciones(){
        $data=['ejmId'=>$this->idEjem];
        $this->dispatch('abreModalDeSubcolecciones',$data);
    }

    public function SacaDeColeccion($colId){
        ej_subcolecciones::where('col_id',$colId)->update([
            'col_del'=>'1',
        ]);
    }

    public function AbreModalObjeto($par1,$par2, $par3, $par4, $par5){
        $data=['ImgId'=>$par1, 'ImgModulo'=>$par2, 'ImgTipo'=>$par3, 'Clase'=>$par4, 'IdClase'=>$par5];
        $this->dispatch('abreModalDeImagen', $data);
    }

    public function render() {
        ######## Verifica que se tenga acceso al campus
        $jard=ejemplares::where('ejm_id',$this->idEjem)->value('ejm_ccamsiglas');
        if(!in_array($jard,session('jar'))){
            redirect('/noauth/Solicita acceso al campus '.$jard);
        }
        ###################################################################
        ##################################### Prepara autorizaciones
        $CampusDelEjemplar=$this->ejemplar->ejm_ccamsiglas;
        $CampusIdDelEjemplar=cat_campus::where('ccam_siglas',$this->ejemplar->ejm_ccamsiglas)->value('ccam_id');
        ##### Permisos admin-colviva,
        $this->edit_adcolviva='0';
        $CampusAutorizados2=[];
        if(array_intersect(['admin-colviva'],session('rol'))){
            $CampusAutorizados2=usr_roles::where('rol_crolrol','admin-colviva')
                ->where('rol_usrid',Auth::user()->id)
                ->where('rol_del','0')->where('rol_act','1')
                ->pluck('rol_ccamsiglas')
                ->toArray();
            if(in_array($CampusDelEjemplar, $CampusAutorizados2) OR  in_array('todos',$CampusAutorizados2) ){
                $this->edit_adcolviva='1';
            }

            if(in_array('todos',$CampusAutorizados2)){
                $CampusAutorizados2=cat_campus::where('ccam_act','1')->pluck('ccam_siglas')->toArray();
            }else{
                $CampusAutorizados2=[];
            }
        }
        ################################################################
        ################### Carga gridas
        $gridas=cat_gridas::whereIn('gri_ccamsiglas',$CampusAutorizados2)->get();

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

        #################################################################
        ################### Carga alias
        $this->alias=ej_alias::where('alias_ejmid',$this->idEjem)
            ->where('alias_tipo','ubicación')
            ->where('alias_act','1')
            ->where('alias_del','0')
            ->get();

        $subcolecciones=ej_colecciones::where('col_ejmid',$this->idEjem)
            ->where('col_act','1')
            ->where('col_del','0')
            ->get();

        #################################################################
        ################### Carga imágenes
        $imagenes=imagenes::where('img_ejmid',$this->idEjem)
            ->whereIn('img_cimgtipo',['ejemplar_ubicación','ejemplar_portada','ejemplar_ejemplar'])
            ->where('img_act','1')
            ->where('img_del','0')
            ->get();

        ########## Obtiene catálogos
        $camellones=cat_camellones::where('cam_ccamid',$CampusIdDelEjemplar)->get();
        $tiposcrecimiento=cat_conceptos::where('con_tema','tipo-crecimiento')->select('con_txt')->get();
        $iconos=cat_iconos::orderBy('icon_name')->get();
        return view('livewire.coleccion.ubicacion-controller',[
            'camellones'=>$camellones,
            'tiposcrecimiento'=>$tiposcrecimiento,
            'iconos'=>$iconos,
            'gridas'=>$gridas,
            'subcolecciones'=>$subcolecciones,
            'imagenes'=>$imagenes,
        ]);
    }
}
