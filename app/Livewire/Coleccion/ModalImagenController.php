<?php

namespace App\Livewire\Coleccion;

use App\Models\cat_tipoimg;
use App\Models\imagenes;
use Illuminate\Session\SessionManager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class ModalImagenController extends Component
{
    use WithFileUploads;
    ###################################
    ###### En view: <livewire:coleccion.ImagenController/>
    ###### En controller:
    ######   $data[
    ######         'ImgId',      (img_id de tabla imagenes) para editar ó 0 para nuevo
    ######         'ImgModulo',  (cimg_modulo de tabla cat_tipoimgs)
    ######         'ImgTipo',    (cimg_tipo de tabla cat_tipoimgs)
    ######         'Clase',      [ej,es] indica si es para ejemplar o para especie
    ######         'IdClase',    (img_ejmid ó img_spid de tabla imagenes)
    ######   ];
    ######   $this->dispatch('abreModalDeImagen', $data);
    ######   $this->dispatch('cierraModalDeImagen');
    ###################################
    public $ImgId;      ###### valor de img_id de tabla imagen cuando hay que editar ó 0 cuando nuevo
    public $NvoArch, $ruta,$catego, $categoID, $modulo, $tipo1, $tipo2, $titulo, $ubica, $autor, $fecha, $explica, $lat, $lon, $inact, $del;
    public $media, $FileSize;

    #[On('abreModalDeImagen')]
    public function recibeValoresDeFuera($data){
        $this->ImgId=$data['ImgId'];
        // $this->ImgId='5';
        $this->modulo=$data['ImgModulo'];
        #$this->tipo1=$data['ImgTipo'];
        $this->catego=$data['Clase'];
        $this->categoID=$data['IdClase'];
        $this->mount();
    }

    public function mount(){
        $this->NvoArch='';

        // dd('alto',$this->ImgId);
        if($this->ImgId=='0'){
            $this->ruta='';

        }elseif($this->ImgId > '0'){
            ###### Identifica si es ejemplar o especie
            $ejemID=imagenes::where('img_id', $this->ImgId)->value('img_ejmid'); #first('img_ejmid');
            $spID = imagenes::where('img_id', $this->ImgId)->value('img_spid');
            if($ejemID != ''){$cateId=$ejemID;$cate="ej";}else{$cateId=$spID;$cate="es";}
            ##### Procesa tipo de archivo
            $this->ruta=imagenes::where('img_id',$this->ImgId)->value('img_ruta');
            if(preg_match('/jpg|png|jpeg|tiff|tif|svg/i',$this->ruta)){
                $this->media='img';
            }elseif(preg_match('/MP4|MOV|AVI|WMV|MKV|FLV/i',$this->ruta)){
                $this->media='vid';
            }elseif(preg_match('/mp3|wav|flac|aac|wma|m4a/i',$this->ruta)){
                $this->media='aud';
            }else{
                $this->media='unknow';
            }
            ###### Valida archivo:
            if (Storage::exists($this->ruta)) {
                $this->FileSize = round(Storage::size($this->ruta)*0.000001 ,2);

            } else {
                $this->FileSize ='No';
            }

            ###### Obtiene variables
            $this->NvoArch = '';
            $this->catego = $cate;
            $this->categoID = $cateId;
            $act=imagenes::where('img_id',$this->ImgId)->value('img_act');
            if($act=='1'){$this->inact=false;}else{$this->inact=true;}
            $this->del=imagenes::where('img_id',$this->ImgId)->value('img_del');
            $this->modulo=imagenes::where('img_id',$this->ImgId)->join('cat_tipoimgs','img_cimgtipo','=','cimg_tipo')->value('cimg_modulo');
            $this->tipo1=imagenes::where('img_id',$this->ImgId)->value('img_cimgtipo');
            $this->tipo2=imagenes::where('img_id',$this->ImgId)->value('img_tipo2');
            $this->titulo=imagenes::where('img_id',$this->ImgId)->value('img_titulo');
            $this->autor=imagenes::where('img_id',$this->ImgId)->value('img_autor');
            $this->fecha=imagenes::where('img_id',$this->ImgId)->value('img_fecha');
            $this->explica=imagenes::where('img_id',$this->ImgId)->value('img_explica');
            $this->ubica=imagenes::where('img_id',$this->ImgId)->value('img_ubica');
            $this->lat=imagenes::where('img_id',$this->ImgId)->value('img_y');
            $this->lon=imagenes::where('img_id',$this->ImgId)->value('img_x');

        }
    }

    public function CrearObjeto(){
        $this->validate([
            'NvoArch'=>'required',
            'catego'=>'required',
            'categoID'=>'required',
            'modulo'=>'required',
            'tipo1'=>'required',
        ]);

        ###### prepara variables numéricas
        if($this->catego=='ej'){
            $ejimd=$this->categoID;
            $spid=null;
        }elseif($this->catego=='es'){
            $ejimd=null;
            $spid=$this->categoID;
        }

        ###### Guarda nuevo registro
        $nvo=imagenes::create([
            'img_ejmid'=>$ejimd,
            'img_spid'=>$spid,
            'img_cimgtipo'=>$this->tipo1,
            'img_tipo2'=>$this->tipo2,
            'img_titulo'=>$this->titulo,
            'img_ubica'=>$this->ubica,
            'img_explica'=>$this->explica,
            'img_autor'=>$this->autor,
            'img_fecha'=>$this->fecha,
            'img_y'=>$this->lat,
            'img_x'=>$this->lon,
            'img_media'=>$this->media,
            'img_usrid'=>Auth::user()->id,
        ]);

        ###### NombreDeArchivo y lo actualiza en base de datos
        $RutaDeImagen='/img/';
        $nombre= 'obj'.str_pad($nvo->img_id,3,0,STR_PAD_LEFT).'_'.$this->tipo1.'_'.date('ymd-hmi').'.'.$this->NvoArch->getClientOriginalExtension();
        imagenes::where('img_id',$nvo->img_id)->update([
            'img_ruta'=>$RutaDeImagen.$nombre,
        ]);
        $this->NvoArch->storeAs(path:$RutaDeImagen,name:$nombre);

        ###### borra formulario y cierra _
        $this->borrarTodo();
    }

    public function borrarTodo(){
        $this->reset('NvoArch','media','modulo','tipo1','tipo2','titulo','ubica','explica','autor','fecha','lat','lon');
        $this->resetErrorBag();
        $this->dispatch('cierraModalDeImagen',reload:1);
        redirect()->back();
    }

    public function GuardarObjeto(){
        $this->validate([
            // 'NvoArch'=>'required',
            'catego'=>'required',
            'categoID'=>'required',
            'modulo'=>'required',
            'tipo1'=>'required',
        ]);
        ##### Verifica nombre de nuevoobjeto y lo guarda
        $RutaDeImagen='/img/';
        $ruta=imagenes::where('img_id',$this->ImgId)->value('img_ruta');
        if($this->NvoArch != ''){
            $nombre= 'obj'.str_pad($this->ImgId,3,0,STR_PAD_LEFT).'_'.$this->tipo1.'_'.date('ymd-hmi').'.'.$this->NvoArch->getClientOriginalExtension();
            $this->NvoArch->storeAs(path:$RutaDeImagen,name:$nombre);
            Storage::delete($ruta);
            $ruta=$RutaDeImagen.$nombre;
        }
        ##### Procesa datos
        if($this->catego=='ej'){$ejid=$this->categoID;$spid=null;}else{$ejid=null;$spid=$this->categoID;}
        if($this->inact==true){$act='0';}else{$act='1';}
        ##### Guarda en base
        imagenes::where('img_id',$this->ImgId)->update([
            'img_ejmid'=>$ejid,
            'img_spid'=>$spid,
            'img_act'=>$act,
            'img_cimgtipo'=>$this->tipo1,
            'img_tipo2'=>$this->tipo2,
            'img_titulo'=>$this->titulo,
            'img_ubica'=>$this->ubica,
            'img_explica'=>$this->explica,
            'img_autor'=>$this->autor,
            'img_fecha'=>$this->fecha,
            'img_y'=>$this->lon,
            'img_x'=>$this->lat,
            'img_media'=>$this->media,
            'img_ruta'=>$ruta,
            'img_usrid'=>Auth::user()->id,
        ]);
        $this->borrarTodo();
    }

    public function BorrarObjeto(){
        imagenes::where('img_id',$this->ImgId)->update([
            'img_del'=>'1',
        ]);
        $this->borrarTodo();
        $this->dispatch('alertaBorradoImagen');
    }




    public function render() {
        if($this->NvoArch != ''){
            ###### tipo de objeto
            $ext=$this->NvoArch->getClientOriginalExtension();
            if(preg_match('/jpg|png|jpeg|tiff|tif|svg/i',$ext)){
                $this->media='img';
            }elseif(preg_match('/MP4|MOV|AVI|WMV|MKV|FLV/i',$ext)){
                $this->media='vid';
            }elseif(preg_match('/mp3|wav|flac|aac|wma|m4a/i',$ext)){
                $this->media='aud';
            }
        }

        $modulos=cat_tipoimg::select('cimg_modulo')
            ->distinct()
            ->orderBy('cimg_modulo')
            ->get();
        $tipos=cat_tipoimg::where('cimg_modulo',$this->modulo)
            ->get();

        return view('livewire.coleccion.modal-imagen-controller',[
            'modulos'=>$modulos,
            'tipos'=>$tipos,
        ]);
    }
}
