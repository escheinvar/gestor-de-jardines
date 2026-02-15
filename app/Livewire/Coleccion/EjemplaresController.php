<?php

namespace App\Livewire\Coleccion;

use App\Models\cat_camellones;
use App\Models\cat_campus;
use App\Models\cat_colec_ejemps;
use App\Models\cat_subcolecciones;
use App\Models\ej_alias;
use App\Models\ej_subcolecciones;
use App\Models\ej_ubicaciones;
use App\Models\ejemplares;
use App\Models\usr_roles;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class EjemplaresController extends Component
{
    public $campus, $ejemplares, $camellones, $camellon, $coleccion, $buscar, $buscarID;
    public $edit, $temp, $alias;
    /* =========================================================
    Este módulo trabaja sobre dos variables principales:
    $this ->ejemplares y $this->camellones, donde se guardan
    la tabla de ejemplares y la de camellones a mostrar.
    Cuando se selecciona un campus,
    ========================================================= */

    public function mount(){
        $this->campus='';
        $this->camellones=collect();
        $this->coleccion='';
        $this->buscar='';
        $this->buscarID='';
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

    public function EjemplaresBase($SiglasCampus){
        #####################################################
        ####################### Carga ejemplares de un campus
        $this->ejemplares=ejemplares::where('ejm_ccamsiglas',$SiglasCampus)
            ->leftJoin('ej_ubicaciones', function($join){
                $join->on('ejm_id','=','sig_ejmid')
                ->where('sig_act','1')
                ->where('sig_del','0');
            })
            ->where('ejm_del','0')
            ->where('ejm_act','1')
            ->orderBy('ejm_id')
            // ->with('alias')
            // ->with('imagenes')
            // ->with('nombreCientifico')
            // ->with('nombresComunes')
            // ->with('ubicacion')
            // ->with('colecciones')
            ->get();
    }

    public function BuscaEnCampus(){
        $this->dispatch('CierraMapa');
        $this->camellon='';
        ###################  Genera listado de camellones
        if($this->campus != ''){
            $campusID=cat_campus::where('ccam_siglas',$this->campus)->value('ccam_id');
            $this->camellones=cat_camellones::where('cam_ccamid',$campusID)
                ->where('cam_del','0')
                ->where('cam_act','1')
                ->get();
            $this->EjemplaresBase($this->campus);
            ############### Carga mapa
            $this->MapaCamellones($this->camellones,'0', 'null',   'null','null','1');

        }else{
            $this->camellones=collect();
            $this->ejemplares=collect();
        }
    }

    public function BuscaEnCamellon(){
        ###### Ejecuta la búsqueda en BD
        if($this->camellones->count() > '0' AND $this->camellon != ''){
            $busqueda=ejemplares::query()
                ->where('ejm_ccamsiglas',$this->campus)
                ->where('ejm_del','0')
                ->where('ejm_act','1')
                ->leftJoin('ej_ubicaciones', function($join){
                    $join->on('ejm_id','=','sig_ejmid')
                    ->where('sig_act','1')
                    ->where('sig_del','0');
                })
                ->orderBy('ejm_id')
                ->with('alias')
                ->with('imagenes')
                ->with('nombreCientifico')
                ->with('nombresComunes')
                ->with('ubicacion')
                ->with('colecciones');

            ####### Continúa busqueda en camellones

            if($this->camellon != '' and $this->camellon !="Todos" and  $this->camellon !='Ninguno'){
                $busqueda->whereHas('ubicacion',function($q){
                    $q->where('sig_camcamellon', $this->camellon);
                });
            }elseif($this->camellon == 'Ninguno'){
                $busqueda->whereNull('sig_id');
            }

            ###### Continúa búsqueda de Colecciones
            if($this->coleccion != '' and $this->coleccion != 'NingunaColeccion'){
                $busqueda->whereHas('colecciones',function($q){
                    $q->where('col_ccolcoleccion',$this->coleccion);
                });
            }elseif($this->coleccion == 'NingunaColeccion'){
                $busqueda->whereHas('colecciones',function($q){
                    $q-> whereNull('col_ccolcoleccion');
                });
            }

            ##### Continúa búsqueda por texto Familia, nombre científico
            ##### nombre común o alias.
            if($this->buscar != ''){
                $busqueda->where(function($b){
                    return $b
                    ->whereHas('nombreCientifico',function($q){
                        $q->where('scn_familia','ilike',$this->buscar)
                        ->orWhere('scn_name','ilike',$this->buscar);
                    })
                    ->orWhereHas('nombresComunes',function($q){
                        $q->where('con_nombre','ilike',$this->buscar);
                    })
                    ->orWhereHas('alias',function($q){
                        $q->where('alias_nombre','ilike',$this->buscar);
                    });
                });

            }

            ###### Ejecuta búsqueda
            $this->ejemplares=$busqueda->get();

            ############################################################
            ######################################## Carga el Mapa

            // $SigIdGanones=;

            $ejmsMapa=ej_ubicaciones::whereIn('sig_id',  $this->ejemplares->pluck('sig_id')->toArray() )
            ->where('sig_act','1')
                ->where('sig_del','0')
                ->leftJoin('imagenes', function($join){
                    $join->on('sig_ejmid','=','img_ejmid')
                        ->where('img_cimgtipo','ejemplar_portada')
                        ->where('img_act','1')
                        ->where('img_del','0')
                        ->limit(1);
                })
                ->get();
            // dd($ejmsMapa,$this->ejemplares, $this->camellones);
            ############### Carga mapa
            $this->MapaCamellones($this->camellones,'0', 'null',   $ejmsMapa,'null','1');
        }
    }

    public function BuscarID(){
        ###### Ejecuta la búsqueda en BD
        $busqueda=ejemplares::query()
            ->where('ejm_id',$this->buscarID)
            ->where('ejm_del','0')
            ->where('ejm_act','1')
            ->leftJoin('ej_ubicaciones', function($join){
                $join->on('ejm_id','=','sig_ejmid')
                ->where('sig_act','1')
                ->where('sig_del','0');
            })
            ->orderBy('ejm_id')
            ->with('alias')
            ->with('imagenes')
            ->with('nombreCientifico')
            ->with('nombresComunes')
            ->with('ubicacion')
            ->with('colecciones');

        ###### Ejecuta búsqueda
        $this->ejemplares=$busqueda->get();

        ############################################################
        ######################################## Carga el Mapa
        $ejmsMapa=ej_ubicaciones::whereIn('sig_id',  $this->ejemplares->pluck('sig_id')->toArray() )
        ->where('sig_act','1')
            ->where('sig_del','0')
            ->leftJoin('imagenes', function($join){
                $join->on('sig_ejmid','=','img_ejmid')
                    ->where('img_cimgtipo','ejemplar_portada')
                    ->where('img_act','1')
                    ->where('img_del','0')
                    ->limit(1);
            })
            ->get();

        $this->campus=$ejmsMapa->value('sig_ccamsiglas');

        $this->camellon=$ejmsMapa->value('sig_camcamellon');
// dd($this->campus, $this->camellon);
        $this->camellones=cat_camellones::where('cam_camellon',$this->camellon)
            ->where('cam_del','0')
            ->where('cam_act','1')
            ->get();


        ############### Carga mapa
        $this->MapaCamellones($this->camellones,'0', 'null',   $ejmsMapa,'null','1');

    }

    public function BorrarBuscarTexto(){
        $this->buscar='';
        $this->BuscaEnCamellon();
    }

    public function BorrarBuscarID(){
        $this->buscarID='';
        $this->BuscaEnCamellon();
    }

    public function render(){
        ################### Obtiene campus autorizados
        $campuses1=usr_roles::where('rol_usrid',Auth::user()->id)
            ->where('rol_del','0')
            ->where('rol_act','1')
            ->pluck('rol_ccamsiglas')
            ->unique('rol_ccamsiglas')
            ->toArray();
        if(in_array('todos',$campuses1)){
            $campuses=cat_campus::where('ccam_act','1')
                ->select('ccam_id','ccam_siglas','ccam_name')
                ->orderBy('ccam_siglas')
                ->get();
        }else{
            $campuses=cat_campus::where('ccam_act','1')
                ->whereIn('ccam_siglas',$campuses1)
                ->select('ccam_id','ccam_siglas','ccam_name')
                ->orderBy('ccam_siglas')
                ->get();
        }

        $colecciones=cat_subcolecciones::all();

        return view('livewire.coleccion.ejemplares-controller',[
            'campuses'=>$campuses,
            'colecciones'=>$colecciones,
        ]);
    }
}
