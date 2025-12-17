<?php

namespace App\Livewire\Admin;

use App\Models\cat_tipoimg;
use App\Models\imagenes;
use Livewire\Component;
use Livewire\WithPagination;

class AdminImgsController extends Component
{
    use WithPagination;

    public $tipoBusqueda, $imags, $modulo, $tipo, $Idejemplar, $Idespecie;
    public $IncluirVideo, $IncluirAudio, $IncluirImagen;

    public function mount(){
        $this->tipoBusqueda='';
        $this->modulo='';
        $this->tipo='';
        $this->Idejemplar='';
        $this->Idespecie='';
        $this->imags=collect();
        $this->IncluirAudio=FALSE;
        $this->IncluirVideo=FALSE;
        $this->IncluirImagen=TRUE;

        $this->modulo="colecta";
        // $this->tipo="colecta_ejemplar";
    }

    public function CambiaTipoBusqueda(){
        ###### Al seleccionar una nueva búsqueda, borra todas las anteriores.
        $this->modulo='';
        $this->tipo='';
        $this->Idejemplar='';
        $this->Idespecie="";
        $this->imags=collect();
    }


    public function NuevaImg($par1,$par2, $par3, $par4, $par5){
        ##### dispatch a coleccion.ImagenController
        $data=['ImgId'=>$par1, 'ImgModulo'=>$par2, 'ImgTipo'=>$par3, 'Clase'=>$par4, 'IdClase'=>$par5];
        $this->dispatch('abreModalDeImagen', $data);
    }


    public function buscarPorEjemplar(){
        ##### Valida
        $this->validate([
            'Idejemplar'=>'required|exists:imagenes,img_ejmid',
        ]);

        ##### Valida tipo de archivo
        $ganones=[];
        if($this->IncluirImagen=='imagen'){array_push($ganones,'img');}
        if($this->IncluirAudio=='audio'){ array_push($ganones, 'aud');}
        if($this->IncluirVideo=='video'){ array_push($ganones,'vid');}
        if(count($ganones)=='0'){
            $this->addError('IncluirElementos','Debes seleccionar cuando menos un elemento');
        }


        $this->imags=imagenes::where('img_del','0')
            ->where('img_ejmid',$this->Idejemplar)
            ->whereIn('img_media',$ganones)
            ->get();
    }


    public function buscarPorTipo(){
        $this->validate([
            'modulo'=>'required',
            'tipo'=>'required',
        ]);

        ##### Valida tipo de archivo
        $ganones=[];
        if($this->IncluirImagen=='imagen'){array_push($ganones,'img');}
        if($this->IncluirAudio=='audio'){ array_push($ganones, 'aud');}
        if($this->IncluirVideo=='video'){ array_push($ganones,'vid');}

        if(count($ganones)=='0'){
            $this->addError('IncluirElementos','Debes seleccionar cuando menos un elemento');
        }

        ##### Carga imágenes
        $this->imags=imagenes::where('img_del','0')
            ->where('img_cimgtipo',$this->tipo)
            ->whereIn('img_media',$ganones)
            ->orderBy('img_id')
            ->get();
    }

    public function cambiaModulo(){
        $this->tipo='';
    }

    public function cambiaTipo(){
        $this->imags=collect();
    }

    public function AbreModalObjeto($par1,$par2, $par3, $par4, $par5){
        ##### dispatch a coleccion.ImagenController
        $data=['ImgId'=>$par1
        , 'ImgModulo'=>$par2, 'ImgTipo'=>$par3, 'Clase'=>$par4, 'IdClase'=>$par5];
        $this->dispatch('abreModalDeImagen', $data);
    }

    public function render(){
        ##### Carga catálogo de módulos
        $modulos=cat_tipoimg::select('cimg_modulo')->distinct()->get();

        $totalesPortipo = imagenes::selectRaw('img_cimgtipo, COUNT(img_id) as total')
            ->groupBy('img_cimgtipo')
            ->get();

        ##### Carga catálogo de tipos de módulo
        if($this->modulo != ''){
            $tipos=cat_tipoimg::where('cimg_modulo',$this->modulo)->get();

        }else{
            $tipos=collect();
        }

        $Nimags=imagenes::where('img_act','1')->where('img_del','0')->count();
        return view('livewire.admin.admin-imgs-controller',[
            'modulos'=>$modulos,
            'tipos'=>$tipos,
            'totalesPorTipo'=>$totalesPortipo,
            'Nimags'=>$Nimags,
        ]);
    }
}
