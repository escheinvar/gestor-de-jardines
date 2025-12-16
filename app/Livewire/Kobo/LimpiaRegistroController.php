<?php

namespace App\Livewire\Kobo;

use App\Livewire\Coleccion\ExpedienteController;
use App\Models\cat_camellones;
use App\Models\cat_campus;
use App\Models\cat_gridas;
use App\Models\ej_ubicaciones;
use App\Models\ejemplares;
use App\Models\ej_alias;
use App\Models\ej_conteos;
use App\Models\ej_expediente;
use App\Models\imagenes;
use App\Models\kobo2;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class LimpiaRegistroController extends Component
{

    public $koboid, $dato;
    public $campus, $autor, $fecha, $ubicaname, $ubicanotas, $camellon, $camellones, $latitud, $longitud;
    public $TomCors, $scname, $comname, $ejmname, $cantidad, $exten,$clavo, $prev, $next, $NuevoNombreComun, $NuevaEtiquetaejemplar;
    public $grida, $gridas;

    public function mount($id){
        ##### Reviso url
        $revisoUrl=kobo2::where('kobo2_id',$id)
            ->where('kobo2_del','0')
            ->get();
        if($revisoUrl->count() !='1'){
            $this->dispatch('AvisoExitoKobo2',msj:'El registro no existe en la base');
            redirect('/kobo');
        }
        $this->koboid=$id;

        ##### Cargo datos del ejemplar
        $dato=kobo2::where('kobo2_id',$this->koboid)
            ->where('kobo2_del','0')
            ->orderBy('kobo2_id')
            ->first();
        $this->dato=$dato;


        ##### carga los camellones del campus
        $this->campus=$this->dato->kobo2_ccamsiglas;
        $campusId=cat_campus::where('ccam_siglas',$this->campus)->value('ccam_id');
        $this->camellones=cat_camellones::where('cam_ccamid',$campusId)
            ->where('cam_act','1')
            ->where('cam_del','0')
            ->get();

        #### Carga valor de ejemplar
        $ejemplares=ej_ubicaciones::where('sig_camcamellon',$this->camellon)
            ->where('sig_act','1')
            ->where('sig_del','0')
            ->get();

        ##### Carga el camellón y genera el mapa
        $Confirma=cat_camellones::where('cam_camellon',$this->dato->kobo2_camellon)->first();
        if($Confirma){
            $this->camellon=$this->dato->kobo2_camellon;
            $camId=cat_camellones::where('cam_camellon',$this->camellon)->value('cam_id');
            $ejemplares=ej_ubicaciones::where('sig_camcamellon',$this->camellon)
                ->where('sig_act','1')
                ->where('sig_del','0')
                ->get();
            $ejemplares->push(
                collect([
                    'sig_ejmid'=>'90000',
                    'sig_id'=>'90000',
                    'sig_x'=>$this->dato->kobo2_x,
                    'sig_y'=>$this->dato->kobo2_y,
                ])
            );
            $this->MapaCamellones($this->camellones,'0', $camId, $ejemplares,'90000','0','null');
        }else{
            $this->camellon='';
        }

        ###### Carga otros valores
        $this->autor = $dato->kobo2_username;
        $this->fecha = $dato->kobo2_date;
        $this->ubicaname = $dato->kobo2_nombrecuadr;
        $this->ubicanotas = $dato->kobo2_notasubica;
        $this->longitud = $dato->kobo2_x;
        $this->latitud = $dato->kobo2_y;
        $this->TomCors = '0';
        $this->scname = $dato->kobo2_nombrecient;
        $this->cantidad = $dato->kobo2_numinds;
        $this->exten = $dato->kobo2_numext;
        $this->clavo = $dato->kobo2_clavo;
        $this->ejmname = explode(';',$dato->kobo2_nombreejemplar);
        $this->comname =explode(';',$dato->kobo2_nombrecom);
        $this->grida='';

        ###############################################
        ################### Descarga fotos de kobo
        {
            ####### Baja fotoubica
            $name='kobotmp/'.$this->dato->kobo2_id.'_ubica.jpg';
            if($this->dato->kobo2_fotoubica != '' AND !Storage::exists($name)){
                $response = Http::withHeaders([
                    'Authorization' => 'Token ' . session('tokenKobo'),
                ])->get($this->dato->kobo2_fotoubica);
                if($response->successful()){
                    Storage::put($name, $response->body());
                }
            }

            ####### Baja foto ejemplar
            $name='kobotmp/'.$this->dato->kobo2_id.'_ejemplar.jpg';
            if($this->dato->kobo2_fotoejemplar != '' AND !Storage::exists($name)){
                $response = Http::withHeaders([
                    'Authorization' => 'Token ' . session('tokenKobo'),
                ])->get($this->dato->kobo2_fotoejemplar);
                if($response->successful()){
                    Storage::put($name, $response->body());
                }
            }

            ####### Baja foto ejemplar 2
            $name='kobotmp/'.$this->dato->kobo2_id.'_ejemplar2.jpg';
            if($this->dato->kobo2_fotoejemplar2 != '' AND !Storage::exists($name)){
                $response = Http::withHeaders([
                    'Authorization' => 'Token ' . session('tokenKobo'),
                ])->get($this->dato->kobo2_fotoejemplar2);
                if($response->successful()){
                    Storage::put($name, $response->body());
                }
            }

            ####### Baja foto flor
            $name='kobotmp/'.$this->dato->kobo2_id.'_flor.jpg';
            if($this->dato->kobo2_fotoflor != '' AND !Storage::exists($name)){
                $response = Http::withHeaders([
                    'Authorization' => 'Token ' . session('tokenKobo'),
                ])->get($this->dato->kobo2_fotoflor);
                if($response->successful()){
                    Storage::put($name, $response->body());
                }
            }

            ####### Baja foto hoja
            $name='kobotmp/'.$this->dato->kobo2_id.'_hoja.jpg';
            if($this->dato->kobo2_fotohoja != '' AND !Storage::exists($name)){
                $response = Http::withHeaders([
                    'Authorization' => 'Token ' . session('tokenKobo'),
                ])->get($this->dato->kobo2_fotohoja);
                if($response->successful()){
                    Storage::put($name, $response->body());
                }
            }

            ####### Baja foto fruto
            $name='kobotmp/'.$this->dato->kobo2_id.'_fruto.jpg';
            if($this->dato->kobo2_fotofrutos != '' AND !Storage::exists($name)){
                $response = Http::withHeaders([
                    'Authorization' => 'Token ' . session('tokenKobo'),
                ])->get($this->dato->kobo2_fotofrutos);
                if($response->successful()){
                    Storage::put($name, $response->body());
                }
            }
        }

        ######## Carga Gridas
        $this->gridas=cat_gridas::where('gri_ccamsiglas',$dato->kobo2_ccamsiglas)
            ->where('gri_del','0')
            ->where('gri_act','1')
            ->get() ;
    }


    public function MapaConGrida(){
        ##### Carga grida
        if($this->grida > '0' ){
            $gridaSelected=cat_gridas::where('gri_id',$this->grida)->get();
        }else{
            $gridaSelected='null';
        }
        ##### Carga el camellón y genera el mapa
        $Confirma=cat_camellones::where('cam_camellon',$this->dato->kobo2_camellon)->first();
        if($Confirma){
            $this->camellon=$this->dato->kobo2_camellon;
            $camId=cat_camellones::where('cam_camellon',$this->camellon)->value('cam_id');
            $ejemplares=ej_ubicaciones::where('sig_camcamellon',$this->camellon)
                ->where('sig_act','1')
                ->where('sig_del','0')
                ->get();
            $ejemplares->push(
                collect([
                    'sig_ejmid'=>'90000',
                    'sig_id'=>'90000',
                    'sig_x'=>$this->dato->kobo2_x,
                    'sig_y'=>$this->dato->kobo2_y,
                ])
            );
            $this->MapaCamellones($this->camellones,'0', $camId, $ejemplares,'90000','0',$gridaSelected);
        }
    }

    public function Guardar(){
        $this->validate([
            'campus'=>'required',
            'camellon'=>'required',
            'latitud'=>'required',
            'longitud'=>'required',
            'autor'=>'required',
            'fecha'=>'required',
            'cantidad'=>'required',
            'exten'=>'required',
        ]);
        $this->resetErrorBag();

        ##### Cargo datos del ejemplar
        $dato=kobo2::where('kobo2_id',$this->koboid)
            ->where('kobo2_del','0')
            ->first();

        ##### Guarda base de datos 2
        kobo2::where('kobo2_id',$dato->kobo2_id)->update([
            'kobo2_nombreejemplar'=>implode(';',$this->ejmname),
            'kobo2_clavo'=>$this->clavo,
            'kobo2_numinds'=>$this->cantidad,
            'kobo2_numext'=>$this->exten,
            'kobo2_nombrecient'=>$this->scname,
            'kobo2_nombrecom'=>implode(';',$this->comname),

            'kobo2_ccamsiglas'=>$this->campus,
            'kobo2_username'=>$this->autor,
            'kobo2_date'=>$this->fecha,
            'kobo2_camellon'=>$this->camellon,
            'kobo2_x'=>$this->longitud,
            'kobo2_y'=>$this->latitud,
            'kobo2_nombrecuadr'=>$this->ubicaname,
            'kobo2_notasubica'=>$this->ubicanotas,

            'kobo2_saved'=>kobo2::where('kobo2_id',$dato->kobo2_id)->value('kobo2_saved')+1,
        ]);
        ##### Da aviso final
        $this->dispatch('AvisoExitoKobo2',msj:'Los datos se guardaron en la tabla temporal');
        $this->dispatch('RecargaPagina');

    }

    public function cambiaCampus(){
        $this->camellon='';
        $campusId=cat_campus::where('ccam_siglas',$this->campus)->value('ccam_id');
        $this->camellones=cat_camellones::where('cam_ccamid',$campusId)
            ->where('cam_del','0')
            ->where('cam_act','1')
            ->get();
        $this->dispatch('CierraMapa');
    }

    public function cambiaCamellon(){
        if($this->camellon != ''){
            ##### Carga grida
            if($this->grida > '0' ){
                $gridaSelected=cat_gridas::where('gri_id',$this->grida)->get();
            }else{
                $gridaSelected='null';
            }

            #### Carga valor de ejemplar
            $ejemplares=ej_ubicaciones::where('sig_camcamellon',$this->camellon)
                ->where('sig_act','1')
                ->where('sig_del','0')
                ->get();

            $ejemplares->push(
                collect([
                    'sig_ejmid'=>'90000',
                    'sig_id'=>'90000',
                    'sig_x'=>$this->dato->kobo2_x,
                    'sig_y'=>$this->dato->kobo2_y,
                ])
            );
            $camId=cat_camellones::where('cam_camellon',$this->camellon)->value('cam_id');

            $this->MapaCamellones($this->camellones, '0', $camId, $ejemplares, '90000', '0',$gridaSelected);
        }
    }

    public function tomarCoordenadas(){
        $this->TomCors='1';
        $this->dispatch('CapturaCoordenadas');
    }

    public function BorrarNombreComun($nombre){
        $key=array_search($nombre,$this->comname);
        unset($this->comname[$key]);
    }

    public function AgregarNombreComun() {
        $this->comname[]=$this->NuevoNombreComun;
        $this->NuevoNombreComun='';
    }

    public function BorrarEtiquetaEjemplar($nombre){
        $key=array_search($nombre,$this->ejmname);
        unset($this->ejmname[$key]);
        $this->NuevaEtiquetaejemplar='';
    }

    public function AgregarEtiquetaEjemplar() {
        $this->ejmname[]=$this->NuevaEtiquetaejemplar;
        $this->NuevaEtiquetaejemplar='';
    }

    public function MapaCamellones($camellones, $streetMap, $DestacaCamId, $Ejemplares, $DestacaEjemId, $etiquetas, $grida){
        ##### Esta función requiere que se definan las siguientes variables:
        ##### $camellones = cat_camellon::get() ó 'null' con la seleccion de camellones a mapear (si es 'null', solo muestra los ejemplares)
        ##### $streetMap='1' ó '0' Indica si se muestra fondo de StreeMap (1) o no (0)
        ##### $DestacaCamId= 'null' ó cam_id. Cuando cam_id, destaca y centra el camellón indicado.
        ##### $Ejemplares= 'null' o ej_ubicaciones::join('cat_iconos','sig_icono','=','icon_name')->get()
        #####               con el listado de puntos a mostrar (y sus íconos). Si no hay join de íconos,
        #####               solo muestra camellones
        ##### $DestacaEjemId= 'null' o sig_id; con el id del registro a destacar
        ##### $etiquetas='1' ó '0' Indica si semuestran popups con datos de ejemplares y camellones
        ##### $grida=cat_gridas::where()->get() con la grida a mostrar

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

        ###################### Agregado para kobo:
        $PuntosKobo=kobo2::where('kobo2_del','0')
            ->whereNot('kobo2_id',$this->dato->kobo2_id)
            ->get();

        ##### Para capturar coordenadas, se requiere etiquetas=null
        $this->dispatch('IniciaMapaCamellones', etiquetas:$etiquetas, camellones:$camellones, DestacaCamId:$DestacaCamId, streetmap:$streetMap, zoom:$zoom, x:$x, y:$y,  Ejemplares:$Ejemplares, DestacaEjemId:$DestacaEjemId, kobos:$PuntosKobo, Grida:$grida);
    }

    public function IngresarEjemplar(){
        ##### Valida
        $this->validate([
            'campus'=>'required',
            'camellon'=>'required',
            'longitud'=>'required',
            'latitud'=>'required',
            'autor'=>'required',
            'fecha'=>'required',
        ]);
        // dd('antes',$this->dato);
        #########################################
        ################ Crea el ejemplar
        $NvoEjemplar=$ejemplar=ejemplares::create([
                'ejm_id'=>ejemplares::max('ejm_id')+1,
                'ejm_ccamsiglas'=>$this->dato->kobo2_ccamsiglas,  ##### siglas del campus
                'ejm_bitid'=>'0',        ##### id de bitácora =0 (sin bitácora)
                'ejm_madreid'=>null,
                'ejm_padreid'=>null,
                'ejm_loteid'=>null,
                'ejm_ripdate'=>null,
                'ejm_ripcausa'=>null,
                'ejm_notasingreso'=>'Digitalizado  por usrId '.Auth::user()->id.' ('.date('Y-m-d'). ') desde koboId'.$this->dato->kobo2_koboid.' cargado por '.$this->dato->kobo2_username.' ('.$this->dato->kobo2_dato.')',
            ]);
        #########################################
        ################ Guarda nombre científico
        if($this->dato->kobo2_nombrecient != ''){
            ej_alias::create([
                'alias_ejmid'=>$NvoEjemplar->ejm_id,
                'alias_bitid'=>$NvoEjemplar->bitid,
                'alias_tipo'=>'nombre científico',
                'alias_nombre'=>$this->dato->kobo2_nombrecient,
                'alias_usrid'=>Auth::user()->id,
            ]);
        }
        #########################################
        ################ Guarda nombre común
        if($this->dato->kobo2_nombrecom != ''){
            foreach( explode(';', $this->dato->kobo2_nombrecom) as $n){
            ej_alias::create([
                'alias_ejmid'=>$NvoEjemplar->ejm_id,
                'alias_bitid'=>$NvoEjemplar->bitid,
                'alias_tipo'=>'nombre común',
                'alias_nombre'=>$n,
                'alias_usrid'=>Auth::user()->id,
            ]);
            }

        }
        #########################################
        ################ Guarda nombre del ejemplar
        if($this->dato->kobo2_nombreejemplar != ''){
            foreach( explode(';', $this->dato->kobo2_nombreejemplar) as $n){
                ej_alias::create([
                    'alias_ejmid'=>$NvoEjemplar->ejm_id,
                    'alias_bitid'=>$NvoEjemplar->bitid,
                    'alias_tipo'=>'ejemplar',
                    'alias_nombre'=>$n,
                    'alias_usrid'=>Auth::user()->id,
                ]);
            }
        }
        #########################################
        ################ Guarda nombre del clavo
        if($this->dato->kobo2_clavo != ''){
            ej_alias::create([
                'alias_ejmid'=>$NvoEjemplar->ejm_id,
                'alias_bitid'=>$NvoEjemplar->bitid,
                'alias_tipo'=>'clavo',
                'alias_nombre'=>$this->dato->kobo2_clavo,
                'alias_usrid'=>Auth::user()->id,
            ]);
        }
        #########################################
        ############# Guarda nombre de ubicación
        if($this->dato->kobo2_nombrecuadr != ''){
            ej_alias::create([
                'alias_ejmid'=>$NvoEjemplar->ejm_id,
                'alias_bitid'=>$NvoEjemplar->bitid,
                'alias_tipo'=>'ubicación',
                'alias_nombre'=>$this->dato->kobo2_nombrecuadr,
                'alias_usrid'=>Auth::user()->id,
            ]);
        }

        #########################################
        ################ Guarda ubicación:
        $NvaUbica= ej_ubicaciones::create([
            'sig_ejmid'=>$NvoEjemplar->ejm_id,
            'sig_ccamsiglas'=>$NvoEjemplar->ejm_ccamsiglas,
            'sig_camid'=>cat_camellones::where('cam_camellon',$this->dato->kobo2_camellon)->value('cam_id'),
            'sig_camcamellon'=>$this->dato->kobo2_camellon,
            'sig_x'=>$this->dato->kobo2_x,
            'sig_y'=>$this->dato->kobo2_y,
            'sig_restriccion'=>'0',
            'sig_usrid'=>Auth::user()->id,
            'sig_notas'=>'('.$this->dato->kobo2_nombrecuadr.') ',$this->dato->kobo2_notasubica,
        ]);

        #########################################
        ################ Guarda conteos
        $fecha=strtotime(preg_replace('/ .*/','', $this->dato->kobo2_date));
        // dd(date('Y-m-d',$fecha));
        ej_conteos::create([
            'cant_ejmid'=>$NvoEjemplar->ejm_id,
            'cant_ubicaid'=>$NvaUbica->sig_id,
            'cant_inds'=>$this->dato->kobo2_numinds,
            'cant_ext'=>$this->dato->kobo2_numext,
            'cant_fecha'=>date('Y-m-d',$fecha),
            'cant_usrid'=>Auth::user()->id,
        ]);



        #########################################
        ############## Guarda fotoejemplar portada
        $archivo='/kobotmp/'.$this->dato->kobo2_id.'_ejemplar.jpg';
        $tipo='ejemplar_portada'; ### tipo de imagen de cat_tipoimagen=ejemplar (ejemplar_ejemplar, ejemplar_flor, ejemplar_fruto, ejemplar_hoja, ejemplar_fruto)
        if (Storage::exists($archivo)) {
            $Idimg=imagenes::max('img_id')+1;
            $NvoFile='obj'.$Idimg.'_'.$tipo.'_'.date('Ymd-hmi').'.jpg';
            ##### Mueve foto
            Storage::move($archivo,'/img/'.$NvoFile);
            ##### Guarda en BD
            imagenes::create([
                'img_id'=>$Idimg,
                'img_ejmid'=>$NvoEjemplar->ejm_id,
                'img_cimgtipo'=>$tipo,
                'img_titulo'=>'Ejemplar en el Jardín',
                'img_ubica'=>'Camellón '.$this->dato->kobo2_camellon.' del '.$this->dato->kobo2_ccamsiglas,
                'img_explica'=>'Foto del ejemplar tomada en '.$this->dato->kobo2_ccamsiglas,
                'img_autor'=>$this->dato->kobo2_username,
                'img_fecha'=>date('Y-m-d',$fecha),
                'img_x'=>$this->dato->kobo2_x,
                'img_y'=>$this->dato->kobo2_y,
                'img_media'=>'img',
                'img_ruta'=>'/img/'.$NvoFile,
                'img_usrid'=>Auth::user()->id,
            ]);
        }

        #########################################
        ############## Guarda fotoejemplar portada
        $archivo='/kobotmp/'.$this->dato->kobo2_id.'_ejemplar2.jpg';
        $tipo='ejemplar_ejemplar'; ### tipo de imagen de cat_tipoimagen=ejemplar (ejemplar_ejemplar, ejemplar_flor, ejemplar_fruto, ejemplar_hoja, ejemplar_fruto)
        if (Storage::exists($archivo)) {
            $Idimg=imagenes::max('img_id')+1;
            $NvoFile='obj'.$Idimg.'_'.$tipo.'_'.date('Ymd-hmi').'.jpg';
            ##### Mueve foto
            Storage::move($archivo, '/img/'.$NvoFile);
            ##### Guarda en BD
            imagenes::create([
                'img_id'=>$Idimg,
                'img_ejmid'=>$NvoEjemplar->ejm_id,
                'img_cimgtipo'=>$tipo,
                'img_titulo'=>'Ejemplar en el Jardín',
                'img_ubica'=>'Camellón '.$this->dato->kobo2_camellon.' del '.$this->dato->kobo2_ccamsiglas,
                'img_explica'=>'Foto del ejemplar tomada en '.$this->dato->kobo2_ccamsiglas,
                'img_autor'=>$this->dato->kobo2_username,
                'img_fecha'=>date('Y-m-d',$fecha),
                'img_x'=>$this->dato->kobo2_x,
                'img_y'=>$this->dato->kobo2_y,
                'img_media'=>'img',
                'img_ruta'=>'/img/'.$NvoFile,
                'img_usrid'=>Auth::user()->id,
            ]);
        }

        #########################################
        ########### Guarda fotoejemplar ubicación
        $archivo='/kobotmp/'.$this->dato->kobo2_id.'_ubica.jpg';
        $tipo='ejemplar_ubicación'; ### tipo de imagen de cat_tipoimagen=ejemplar (ejemplar_ejemplar, ejemplar_flor, ejemplar_fruto, ejemplar_hoja, ejemplar_fruto)
        if (Storage::exists($archivo)) {
            $Idimg=imagenes::max('img_id')+1;
            $NvoFile='obj'.$Idimg.'_'.$tipo.'_'.date('Ymd-hmi').'.jpg';
            ##### Mueve foto
            Storage::move($archivo, '/img/'.$NvoFile);
            ##### Guarda en BD
            imagenes::create([
                'img_id'=>$Idimg,
                'img_ejmid'=>$NvoEjemplar->ejm_id,
                'img_cimgtipo'=>$tipo,
                'img_titulo'=>'Ubicación del ejemplar',
                'img_ubica'=>'Camellón '.$this->dato->kobo2_camellon.' del '.$this->dato->kobo2_ccamsiglas,
                'img_explica'=>'Foto que indica el sitio en el que se encuentra el ejemplar',
                'img_autor'=>$this->dato->kobo2_username,
                'img_fecha'=>date('Y-m-d',$fecha),
                'img_x'=>$this->dato->kobo2_x,
                'img_y'=>$this->dato->kobo2_y,
                'img_media'=>'img',
                'img_ruta'=>'/img/'.$NvoFile,
                'img_usrid'=>Auth::user()->id,
            ]);
        }



        #########################################
        ########### Guarda fotoejemplar flor
        $archivo='/kobotmp/'.$this->dato->kobo2_id.'_flor.jpg';
        $tipo='ejemplar_flor'; ### tipo de imagen de cat_tipoimagen=ejemplar (ejemplar_ejemplar, ejemplar_flor, ejemplar_fruto, ejemplar_hoja, ejemplar_fruto)
        if (Storage::exists($archivo)) {
            $Idimg=imagenes::max('img_id')+1;
            $NvoFile='obj'.$Idimg.'_'.$tipo.'_'.date('Ymd-hmi').'.jpg';
            ##### Mueve foto
            Storage::move($archivo, '/img/'.$NvoFile);
            ##### Guarda en BD
            imagenes::create([
                'img_id'=>$Idimg,
                'img_ejmid'=>$NvoEjemplar->ejm_id,
                'img_cimgtipo'=>$tipo,
                'img_titulo'=>'Estructura reproductiva',
                'img_ubica'=>'Camellón '.$this->dato->kobo2_camellon.' del '.$this->dato->kobo2_ccamsiglas,
                'img_explica'=>'Estructura reproductiva del ejemplar',
                'img_autor'=>$this->dato->kobo2_username,
                'img_fecha'=>date('Y-m-d',$fecha),
                'img_x'=>$this->dato->kobo2_x,
                'img_y'=>$this->dato->kobo2_y,
                'img_media'=>'img',
                'img_ruta'=>'/img/'.$NvoFile,
                'img_usrid'=>Auth::user()->id,
            ]);
        }

        #########################################
        ########### Guarda fotoejemplar Hojas
        $archivo='/kobotmp/'.$this->dato->kobo2_id.'_hoja.jpg';
        $tipo='ejemplar_hoja'; ### tipo de imagen de cat_tipoimagen=ejemplar (ejemplar_ejemplar, ejemplar_flor, ejemplar_fruto, ejemplar_hoja, ejemplar_fruto)
        if (Storage::exists($archivo)) {
            $Idimg=imagenes::max('img_id')+1;
            $NvoFile='obj'.$Idimg.'_'.$tipo.'_'.date('Ymd-hmi').'.jpg';
            ##### Mueve foto
            Storage::move($archivo, '/img/'.$NvoFile);
            ##### Guarda en BD
            imagenes::create([
                'img_id'=>$Idimg,
                'img_ejmid'=>$NvoEjemplar->ejm_id,
                'img_cimgtipo'=>$tipo,
                'img_titulo'=>'Hojas del ejemplar',
                'img_ubica'=>'Camellón '.$this->dato->kobo2_camellon.' del '.$this->dato->kobo2_ccamsiglas,
                'img_explica'=>'Hoja del ejemplar',
                'img_autor'=>$this->dato->kobo2_username,
                'img_fecha'=>date('Y-m-d',$fecha),
                'img_x'=>$this->dato->kobo2_x,
                'img_y'=>$this->dato->kobo2_y,
                'img_media'=>'img',
                'img_ruta'=>'/img/'.$NvoFile,
                'img_usrid'=>Auth::user()->id,
            ]);
        }

        #########################################
        ########### Guarda fotoejemplar frutos
        $archivo='/kobotmp/'.$this->dato->kobo2_id.'_fruto.jpg';
        $tipo='ejemplar_frutos'; ### tipo de imagen de cat_tipoimagen=ejemplar (ejemplar_ejemplar, ejemplar_flor, ejemplar_fruto, ejemplar_hoja, ejemplar_fruto)
        if (Storage::exists($archivo)) {
            $Idimg=imagenes::max('img_id')+1;
            $NvoFile='obj'.$Idimg.'_'.$tipo.'_'.date('Ymd-hmi').'.jpg';
            ##### Mueve foto
            Storage::move($archivo, '/img/'.$NvoFile);
            ##### Guarda en BD
            imagenes::create([
                'img_id'=>$Idimg,
                'img_ejmid'=>$NvoEjemplar->ejm_id,
                'img_cimgtipo'=>$tipo,
                'img_titulo'=>'Hojas del ejemplar',
                'img_ubica'=>'Camellón '.$this->dato->kobo2_camellon.' del '.$this->dato->kobo2_ccamsiglas,
                'img_explica'=>'Frutos del ejemplar',
                'img_autor'=>$this->dato->kobo2_username,
                'img_fecha'=>date('Y-m-d',$fecha),
                'img_x'=>$this->dato->kobo2_x,
                'img_y'=>$this->dato->kobo2_y,
                'img_media'=>'img',
                'img_ruta'=>'/img/'.$NvoFile,
                'img_usrid'=>Auth::user()->id,
            ]);
        }

        ####################################
        ################ Borra datos de kobo
        kobo2::where('kobo2_id',$this->dato->kobo2_id)->update([
            'kobo2_del'=>'1',
        ]);

        #########################################
        ########### Registro inicial en expediente
        ej_expediente::create([
            'exp_ejmid'=>$NvoEjemplar->ejm_id,
            'exp_cexpname'=>'sistema',
            'exp_txt'=>'Registro inicial del ejemplar por digitalización',
            'exp_fecha'=>date('Y-m-d'),
            'exp_hora'=>date('Y-m-d H:m:i'),
            'exp_usrid'=>Auth::user()->id,
        ]);

        redirect('/kobo');
        #####################################
        ############### Aviso de fin
        // $this->dispatch('AvisoExitoKobo2',msj:'El ejemplar se registró correctamente en el Sistema Gestor');

        // $this->dispatch('redirectTo',url:url('/kobo'));
    }

    public function render() {
        $campuses=cat_campus::where('ccam_act','1')->get();

        ##### Cargo datos del ejemplar
        $dato=kobo2::where('kobo2_id',$this->koboid)
            ->where('kobo2_del','0')
            ->first();
        $this->dato=$dato;

        $listaDeId=kobo2::where('kobo2_del','0')
            ->orderBy('kobo2_id','asc')
            ->pluck('kobo2_id')
            ->toArray();

        $keyGanon=array_search( $this->dato->kobo2_id, $listaDeId );

        if($keyGanon > '0'){
            $this->prev= $listaDeId[$keyGanon-1];
        }elseif($keyGanon=='0'){
            $this->prev= $this->dato->kobo2_id;
        }
        // dd($keyGanon, $listaDeId, count($listaDeId));

        if($keyGanon < count($listaDeId)-1){
            $this->next= $listaDeId[$keyGanon + 1];
        }elseif($keyGanon == count($listaDeId)-1){
            $this->next=$this->dato->kobo2_id;
        }


        return view('livewire.kobo.limpia-registro-controller',[
            'campuses'=>$campuses,
        ]);
    }
}
