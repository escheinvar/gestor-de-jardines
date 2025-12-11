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
        $this->campus='';
        $this->camellones=collect();

        $cams=cat_camellones::where('cam_ccamid','1')->get();
        $puntos=ej_ubicaciones::where('sig_camid','1')->get();
                            #datos #stre #destacaId #ubica
        // $this->MapaCamellones('null','1', '3',     $puntos,'null');
        $this->MapaCamellones($cams,'0', '3',     $puntos,'null');
    }

    public function MapaCamellones($datos,$streetMap,$DestacaId, $Ubicaciones,$DestacaUbicaId){
        ##### Esta función requiere que se definan las siguientes variables:
        ##### $datos = cat_camellon::get() con la seleccion de camellones a mapear (no puede ser nulo)
        ##### $streetMap='1' como binario 0, 1 indicando si aparece fondo de StreeMap (1) o no (0)
        ##### $DestacaId contiene 'null' ó cam_id. Cuando null, muestra todo $datos,
        #####                     pero cuando cam_id, muestra $datos en gris y destaca y centra cam_id
        ##### $Ubicaciones= 'null' o ej_ubicaciones::join('cat_iconos','sig_icono','=','icon_name')->get() con
        #####               el listado de puntos a mostrar ó ''
        ##### $DestacaUbicaId= 'null' o sig_id; con el id del registro a destacar ó ''

        ##### Quita camellones sin coordenadas:
        ###### Calcula X y Y inicial (para visualizar el mapa)
        if($datos != 'null'){
            if($DestacaId=='null'){
                $centrar=$datos;
            }else{
                $centrar=$datos->where('cam_id',$DestacaId);
            }
            $xmin = $centrar->min('cam_xmin');
            $ymin = $centrar->min('cam_ymin');
            $xmax = $centrar->max('cam_xmax');
            $ymax = $centrar->max('cam_ymax');

        }else{
            if($DestacaUbicaId=='null'){
                $centrar=$Ubicaciones;
            }else{
                $centrar=$Ubicaciones->where('sig_id',$DestacaUbicaId);
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
        $this->temp=$zoom."-".$max;

        ##### Pasa lista de camellones a array y lo manda a java
        if($datos != 'null'){
            $mapas=$datos->toArray();
        }else{
            $mapas='null';
        }
        $this->dispatch('CierraMapa');
        $this->dispatch('IniciaMapaCamellones', mapas:$mapas, streetmap:$streetMap, zoom:$zoom, x:$x, y:$y, DestacaId:$DestacaId, Ubicaciones:$Ubicaciones, DestacaUbicaId:$DestacaUbicaId);
    }

    public function BuscaEnCampus(){
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
                ->leftJoin('ej_ubicaciones', function($j){
                    $j->on('ejm_id','=','sig_ejmid')
                    ->where('sig_act','1')
                    ->where('sig_del','0');
                })
                ->where('ejm_del','0')
                ->orderBy('ejm_id')
                ->get();
            #####################################################
            ######################################### Carga mapa
                                  #datos           #stre  #destacaId #ubica   #DestacaUbica
            $this->MapaCamellones($this->camellones,'1', 'null',     'null',  'null');

        }else{
            $this->camellones=collect();
            $this->ejemplares=collect();
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

if($this->campus != ''){
    $this->MapaCamellones($this->camellones,  '1', 'null',   'null',  'null');
}
        return view('livewire.coleccion.ejemplares-controller',[
            'campuses'=>$campuses,
        ]);
    }
}
