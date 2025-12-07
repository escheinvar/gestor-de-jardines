<?php

namespace App\Livewire\Coleccion;

use App\Http\Controllers\Api\camellones;
use App\Models\cat_campus;
use App\Models\ej_nombres_cientificos;
use App\Models\ej_nombres_comunes;
use App\Models\cat_camellones;
use App\Models\ej_ubicaciones;
use App\Models\ej_alias;
use App\Models\ejemplares;
use App\Models\imagenes;
use Livewire\Component;

class InicioController extends Component
{

    public $idEjem;                      ##### Variables recibidas desde URL (Id del ejemplar)
    public $MenuDeEjemplares='inicio', $ejemplar, $ejemplar_ScName, $ejemplar_CoName, $ejemplar_ubica;  ##### Variables solicitadas por la plantilla del menú del ejemplar
    public $JardinData, $Imagenes, $temp, $alias;


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
        }

        ######################################### Carga datos de jardín
        $this->JardinData=cat_campus::where('ccam_siglas',$this->ejemplar->ejm_ccamsiglas)
            ->leftJoin('cat_jardines','ccam_cjarid','=','cjar_id')
            ->first();
        $this->Imagenes=imagenes::whereIn('img_cimgtipo',['ejemplar_ejemplar','ejemplar_ubicacion'])
            ->where('img_ejmid',$this->idEjem)
            ->where('img_act','1')
            ->where('img_del','0')
            ->get();

        ######################################### Ejecuta mapa
        if($this->ejemplar_ubica){
            $datos=cat_camellones::where('cam_ccamid',$this->ejemplar_ubica->sig_camid)->get();
            $Ubicaciones=ej_ubicaciones::where('sig_camid',$this->ejemplar_ubica->sig_camid)->join('cat_iconos','sig_icono','=','icon_name')->get()->toArray();
            $DestacaUbicaId= $this->ejemplar_ubica->sig_id;
            // dd($this->ejemplar_ubica,$Ubicaciones);

            $this->MapaCamellones($datos,'0',$this->ejemplar_ubica->sig_camid, $Ubicaciones,$DestacaUbicaId);
        }
    }

    public function MapaCamellones($datos,$streetMap,$DestacaId, $Ubicaciones,$DestacaUbicaId){
        ##### Esta función requiere que se definan las siguientes variables:
        ##### $datos =cat_camellon::get() con la seleccion de camellones a mapear or ''
        ##### $streetMap=1 como binario 0, 1 indicando si aparece fondo de StreeMap (1) o no (0)
        ##### $DestacaId contiene null ó cam_id. Cuando null, muestra todo $datos,
        #####                     pero cuando cam_id, muestra $datos en gris y destaca y centra cam_id
        ##### $Ubicaciones= ej_ubicaciones::join('cat_iconos','sig_icono','=','icon_name')->get() con
        #####               el listado de puntos a mostrar ó ''
        ##### $DestacaUbicaId=sig_id; con el id del registro a destacar ó ''

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
        $this->dispatch('IniciaMapaCamellones', zoom:$zoom, streetmap:$streetMap, mapas:$mapas, x:$x, y:$y, DestacaId:$DestacaId, Ubicaciones:$Ubicaciones, DestacaUbicaId:$DestacaUbicaId);

        #######################################################
        ############# Carga Alias
        $this->alias=ej_alias::where('alias_ejmid',$this->idEjem)
            ->where('alias_del','0')
            ->where('alias_act','1')
            ->get();
    }


    public function render(){
        return view('livewire.coleccion.inicio-controller');
    }
}
