<?php

namespace App\Livewire\Admin;

use App\Models\cat_camellones;
use App\Models\cat_campus;
use App\Models\ej_ubicaciones;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class CamellonController extends Component
{
    use WithFileUploads;

    public $camID, $campus, $came, $campusID;
    public $jardin, $campusName, $NombreCorto, $NombreLargo, $ZonaCorto, $ZonaLargo, $notas;
    public $NumEjsCame;
    public $geojson,$NvoGeoJson, $color, $xmin, $xmax, $ymin, $ymax;

    public $temp;

    public function MapaCamellones($datos,$streetMap,$DestacaId){
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

    public function mount(string $camID){
        ###### Carga de datos para caso nuevo camellón
        if(preg_match('/nuevo_.*/',$camID) ){
            $this->camID='nuevo';                   ##### IOndicador de nuevo o edición
            $this->came=[]; #$this->cam=collect();  ##### Nombre del camellón
            $this->campus=str_replace('nuevo_','',$camID);  ##### contiene siglas del campus
            $this->campusID=cat_campus::where('ccam_siglas',$this->campus)->value('ccam_id');  ##### id del campus
            ##### variables del formulario:
            $this->jardin=cat_campus::where('ccam_siglas',$this->campus)->join('cat_jardines','ccam_cjarid','=','cjar_id')->value('cjar_name'); ##### Nombre corto del campus
            $this->campusName=cat_campus::where('ccam_siglas',$this->campus)->value('ccam_name'); ##### Nombre completo del campus
            // $this->NombreCorto=$this->campus."_".cat_camellones::max('cam_id')+1;
            $this->NombreCorto='';
            $this->NombreLargo='';
            $this->ZonaCorto='';
            $this->ZonaLargo='';
            $this->notas='';
            $this->color="#F54927";
            // $this->reset(['NombreCorto','NombreLargo','ZonaCorto','ZonaLargo','notas','geojson','xmin','xmax','ymin','ymax']);

        ##### Carga de datos para caso de edición de camellón existente
        }else{
            ##### Carga variables de url
            $this->camID=$camID;  #### contiene el id del camellón
            $this->came=cat_camellones::where('cam_id',$camID)->value('cam_camellon');
            $this->campus=cat_campus::where('ccam_id',   cat_camellones::where('cam_id',$camID)->value('cam_ccamid') )->value('ccam_siglas');
            ##### prepara mapa
            $datos=cat_camellones::where('cam_id',$this->camID)->get();
            $this->MapaCamellones($datos,'0',$this->camID);
            ###### Variables del formulario:
            $this->jardin=cat_camellones::where('cam_id',$camID)->join('cat_campus','cam_ccamid','=','ccam_id')->join('cat_jardines','ccam_cjarid','=','cjar_id')->value('cjar_name');
            $this->campusName=cat_camellones::where('cam_id',$camID)->join('cat_campus','cam_ccamid','=','ccam_id')->value('ccam_name');
            $this->NombreCorto=cat_camellones::where('cam_id',$camID)->value('cam_camellon');
            $this->NombreLargo=cat_camellones::where('cam_id',$camID)->value('cam_camellonname');
            $this->ZonaCorto=cat_camellones::where('cam_id',$camID)->value('cam_zona');
            $this->ZonaLargo=cat_camellones::where('cam_id',$camID)->value('cam_zonaname');
            $this->notas=cat_camellones::where('cam_id',$camID)->value('cam_notas');
            $this->geojson=cat_camellones::where('cam_id',$camID)->value('cam_mapa');
            $this->color=cat_camellones::where('cam_id',$camID)->value('cam_color');
            $this->xmin=cat_camellones::where('cam_id',$camID)->value('cam_xmin');
            $this->xmax=cat_camellones::where('cam_id',$camID)->value('cam_xmin');
            $this->ymin=cat_camellones::where('cam_id',$camID)->value('cam_ymin');
            $this->ymax=cat_camellones::where('cam_id',$camID)->value('cam_ymax');
        }
    }

    public function BorrarPoligono($id){
        cat_camellones::where('cam_id',$id)->update([
            'cam_mapa'=>null,
            'cam_xmin'=>null,
            'cam_xmax'=>null,
            'cam_ymin'=>null,
            'cam_ymax'=>null,
        ]);
        redirect('/camellon/'.$id);
    }

    public function crearDatos(){
        ###### Verifica la construcción correcta del nombre del camellón
        ###### (debe incluir el prefijo del jardín y ser único.)
        if($this->NombreCorto==''){$this->NombreCorto=$this->campus."_".cat_camellones::max('cam_id')+1;}
        if(!preg_match('/^'.$this->campus.'_/', $this->NombreCorto)){$this->NombreCorto=$this->campus."_".$this->NombreCorto;}

        $this->validate([
            'NombreCorto'=>'required|unique:cat_camellones,cam_camellon',
            // 'NombreCorto'=>['required', ##### Validación de único indistinto a mayúsculas.
            //         Rule::unique('cat_camellones','cam_camellon')->where(function($query) {
            //             $query->whereRaw("LOWER(cam_camellon) = ?", strtolower($this->NombreCorto));
            //         }),
            //     ],
            ]);
        #dd('crea camellon',$this->NombreCorto, strtolower($this->NombreCorto));
        ##### Crea el nuevo camellón
        if($this->color==''){$this->color="#F54927";}
        $NvoReg=cat_camellones::create([
            'cam_id'=>cat_camellones::max('cam_id')+1,
            'cam_ccamid'=>$this->campusID,
            'cam_camellon'=>$this->NombreCorto,
            'cam_camellonname'=>$this->NombreLargo, #no
            'cam_zona'=>$this->ZonaCorto, #no
            'cam_zonaname'=>$this->ZonaLargo, #no
            'cam_color'=>$this->color,
            'cam_notas'=>$this->notas, #no
            // 'cam_mapa'=>$mapita,
            // 'cam_mapa'=>json_encode($geoJsonData),
            'cam_xmin'=>$this->xmin,
            'cam_xmax'=>$this->xmax,
            'cam_ymin'=>$this->ymin,
            'cam_ymax'=>$this->ymax,
        ]);
        ###### redirecciona para continuar EDITÁNDOLO
        redirect('/camellon/'.$NvoReg->cam_id);
    }

    public function guardarDatos(){
        ###### Verifica la construcción correcta del nombre del camellón
        ###### (debe incluir el prefijo del jardín y ser único.)
        if($this->NombreCorto==''){$this->NombreCorto=$this->campus."_".cat_camellones::max('cam_id')+1;}
        if(!preg_match('/^'.$this->campus.'_/', $this->NombreCorto)){$this->NombreCorto=$this->campus."_".$this->NombreCorto;}
        ##### Valida cuestionario
        $this->validate([
            'jardin'=>'required',
            'campusName'=>'required',
            'NombreCorto'=>'required|unique:cat_camellones,cam_camellon,'.$this->camID.',cam_id',
            'geojson'=>'required',
        ]);

        cat_camellones::where('cam_id',$this->camID)->update([
            'cam_camellon'=>$this->NombreCorto,
            'cam_camellonname'=>$this->NombreLargo,
            'cam_zona'=>$this->ZonaCorto,
            'cam_zonaname'=>$this->ZonaLargo,
            'cam_color'=>$this->color,
            'cam_notas'=>$this->notas,
            'cam_mapa'=>$this->geojson,
        ]);
        redirect()->route('camellones', ['CampusSelected'=>'JebOax']);
    }

    public function EliminarCamellon(){
        if($this->NumEjsCame > '0'){
            $this->dispatch('AvisoCamellon',msj:'No se puede eliminar el camellón hasta que reasignes los '.$this->NumEjsCame.' ejemplares que tiene. Se aborta la operación');
            return;
        }else{
            cat_camellones::where('cam_id',$this->camID)->update([
                'cam_camellon'=>$this->NombreCorto.'--Borrado'.date('Y-m-d_H:i'),
                'cam_del'=>'1',
            ]);
            redirect('/camellones');
        }
    }

    public function render(){
        ##### Verifica accesos correctos
        if(!array_intersect(['admin-campus'],session('rol'))){
            redirect('/noauth/Solo admin-cammpus');
        }
        ##### Si se carga un nuevo mapa geoJson, lo sube a la base:
        if($this->NvoGeoJson != ''){
            ##### Lee json
            $mapita=$this->NvoGeoJson->get();
            $geoJsonData= json_decode($mapita,true);
            $geoJsonData['features'][0]['properties']['SisGesJarId']=$this->camID;
            $geoJsonData['features'][0]['properties']['SisGesJarCamellon']=$this->NombreCorto;
            // dd($mapita,$geoJsonData,$this->camID,$this->NombreCorto);
            ######  Lee el mapa para calcular nuevo centro y guardarlo en base de datos
            if(isset($geoJsonData['features'][0]['geometry']['coordinates'][0])){
                $tipo=$geoJsonData['features'][0]['geometry']['type'];
                if($tipo=='Polygon'){
                    $coords=$geoJsonData['features'][0]['geometry']['coordinates'][0];
                }else{   #elseif($tipo=='MultiPolygon'){
                    $coords=$geoJsonData['features'][0]['geometry']['coordinates'][0][0];
                }
                foreach($coords as $i){
                    $x[]=$i[0];
                    $y[]=$i[1];
                    $this->xmin=min($x);
                    $this->xmax=max($x);
                    $this->ymin=min($y);
                    $this->ymax=max($y);
                }
            }
            ###### Guarda el nuevo centro en base de datos
            cat_camellones::where('cam_id',$this->camID)->update([
                'cam_camellon'=>$this->NombreCorto,
                'cam_camellonname'=>$this->NombreLargo,
                'cam_zona'=>$this->ZonaCorto,
                'cam_zonaname'=>$this->ZonaLargo,
                'cam_color'=>$this->color,
                'cam_notas'=>$this->notas,
                'cam_mapa'=>$geoJsonData,
                'cam_xmin'=>$this->xmin,
                'cam_xmax'=>$this->xmax,
                'cam_ymin'=>$this->ymin,
                'cam_ymax'=>$this->ymax,
            ]);
            ###### redirecciona para continuar EDITÁNDOLO
            $this->NvoGeoJson='';
            redirect('/camellon/'.$this->camID);
        }
        #### Construye mapa mapa
        if($this->camID != 'nuevo'){
            $campusID=cat_camellones::where('cam_id', $this->camID)->value('cam_ccamid');
            $datos=cat_camellones::where('cam_ccamid',$campusID)->get();
            $this->MapaCamellones($datos,'0',$this->camID);

            ##### Calcula número de ejemplares asignados al camellón
            $this->NumEjsCame=ej_ubicaciones::where('sig_camid',$this->camID)
                ->where('sig_act','1')
                ->where('sig_del','0')
                ->count();
        }else{
            $this->NumEjsCame='0';
        }



        return view('livewire.admin.camellon-controller');
    }
}
