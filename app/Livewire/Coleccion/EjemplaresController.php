<?php

namespace App\Livewire\Coleccion;

use App\Models\cat_camellones;
use App\Models\cat_campus;
use App\Models\ejemplares;
use App\Models\usr_roles;
use App\Models\ej_alias;
use App\Models\ej_ubicaciones;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class EjemplaresController extends Component
{
    public $campus, $ejemplares, $camellones, $camellon;
    public $edit, $temp, $alias;

    public function mount(){
        // $this->campus='';
        $this->campus='';
        $this->camellones=collect();
    }

    public function MapaCamellones($camellones, $streetMap, $DestacaCamId, $Ejemplares, $DestacaEjemId, $etiquetas){
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
        $this->dispatch('IniciaMapaCamellones', etiquetas:$etiquetas, camellones:$camellones, DestacaCamId:$DestacaCamId, streetmap:$streetMap, zoom:$zoom, x:$x, y:$y,  Ejemplares:$Ejemplares, DestacaEjemId:$DestacaEjemId);
    }

    public function BuscaEnCampus(){
        $this->dispatch('CierraMapa');
        $this->camellon='';
        #####################################################
        ####################################  Genera listado de camellones
        if($this->campus != ''){
            $campusID=cat_campus::where('ccam_siglas',$this->campus)->value('ccam_id');
            $this->camellones=cat_camellones::where('cam_ccamid',$campusID)
                ->where('cam_del','0')
                ->where('cam_act','1')
                ->get();
            #####################################################
            #################################### Carga ejemplares
            $this->ejemplares=ejemplares::where('ejm_ccamsiglas',$this->campus)
                ->leftJoin('ej_ubicaciones', function($join){
                    $join->on('ejm_id','=','sig_ejmid')
                    ->where('sig_act','1')
                    ->where('sig_del','0');
                })
                ->leftJoin('ej_nombres_cientificos', function($join){
                    $join->on('ejm_id','=','scn_ejmid')
                        ->where('scn_act','1')
                        ->where('scn_del','0')
                        ->select('scn_familia','scn_name');
                })
                ->where('ejm_del','0')
                ->orderBy('ejm_id')
                ->get();
            #####################################################
            ######################################### Carga mapa
            $this->MapaCamellones($this->camellones,'0', 'null',   'null','null','1');

        }else{
            $this->camellones=collect();
            $this->ejemplares=collect();
        }
    }

    public function BuscaEnCamellon(){
        if($this->camellones->count() > '0' AND $this->camellon != ''){
            // dd('ja');
            #####################################################
            ################### Carga Id del camellon seleccionado
            $camellonID=cat_camellones::where('cam_camellon',$this->camellon)->value('cam_id');
            #####################################################
            #################################### Carga ejemplares
            $this->ejemplares=ejemplares::where('ejm_ccamsiglas',$this->campus)
                ->leftJoin('ej_ubicaciones', function($join) {
                    $join->on('ejm_id','=','sig_ejmid')
                    ->where('sig_act','1')
                    ->where('sig_del','0');
                })
                ->leftJoin('ej_nombres_cientificos', function($join){
                    $join->on('ejm_id','=','scn_ejmid')
                        ->where('scn_act','1')
                        ->where('scn_del','0')
                        ->select('scn_familia','scn_name');
                })
                ->where('ejm_del','0')
                ->orderBy('ejm_id')
                ->get();

            ################################################################
            #################################### if camellon=='ninguno'
            if($this->camellon=='Ninguno'){
                $this->ejemplares= $this->ejemplares->whereNull('sig_id');
                $ejmsMapa='null';

            }else{
                ###### Carga table de todos
                $this->ejemplares= $this->ejemplares->where('sig_camcamellon',$this->camellon);
                ##### Carga mapa
                $ejmsMapa=ej_ubicaciones::where('sig_camcamellon',$this->camellon)
                    ->where('sig_act','1')
                    ->where('sig_del','0')
                    ->get();
            }
            #####################################################
            ######################################### Carga mapa
            $this->MapaCamellones($this->camellones,'0', $camellonID,   $ejmsMapa,'null','1');
        }
    }


    public function render(){
        #####################################################
        ########################## Obtiene campus autorizados
        $campuses=usr_roles::where('rol_usrid',Auth::user()->id)
            ->leftJoin('cat_campus','rol_ccamsiglas','=','ccam_siglas')
            ->whereIn('rol_crolrol', session('rol'))
            ->select('ccam_id','ccam_siglas','ccam_name')
            ->orderBy('ccam_siglas')
            ->get();
        $cuentaTodos=usr_roles::where('rol_usrid',Auth::user()->id)->where('rol_ccamsiglas','todos')->count();
        if($cuentaTodos > '0'){
            $campuses=cat_campus::select('ccam_id','ccam_siglas','ccam_name')->orderBy('ccam_siglas')->get();
        }

    // if($this->campus != ''){
    //     $this->MapaCamellones($this->camellones,  '1', 'null',   'null',  'null','1');
    // }
        return view('livewire.coleccion.ejemplares-controller',[
            'campuses'=>$campuses,
        ]);
    }
}
