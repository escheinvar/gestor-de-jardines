<?php

namespace App\Livewire\Sistema;

use App\Models\imagenes;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class HomeController extends Component
{


    ###################################################################
    ###################################### Inicia Módulo de Bitácoras
    public $MyId, $ja;
    public function mount(){
        $this->MyId='0';
    }
    public function lanzador($id){
        redirect()->route('bitacora',[$this->MyId]);
    }
    ###################################### Termina Módulo de Bitácoras
    ###################################################################

    ###################################################################
    ###################################### Inicia Módulo de Autoridades
    // public $ID;

    // public function AbreModalAutoridades($par1){
    //     $data=['autId'=>$par1];
    //     $this->dispatch('abreModalDeAutoridades',$data);
    // }


    // public function mount(){
    //     $this->ID='0';
    // }
    ##################################### Termina Módulo de Autoridades
    ###################################################################

    ###################################################################
    ######################################## Inicia Módulo de Imágenes
    // public $ImgId;
    // public function AbreModalObjeto($par1,$par2, $par3, $par4, $par5){
    //     ##### dispatch a coleccion.ImagenController
    //     $data=['ImgId'=>$par1, 'ImgModulo'=>$par2, 'ImgTipo'=>$par3, 'Clase'=>$par4, 'IdClase'=>$par5];
    //     $this->dispatch('abreModalDeImagen', $data);
    // }

    // public $objetos, $objeto2;
    // public function mount(){
    //     $this->ImgId='0';
    //     $this->objetos=imagenes::where('img_act','1')->where('img_del','0')->get();
    //     $this->objeto2=imagenes::where('img_cimgtipo','colecta_paisaje')->get();
    // }
    ######################################## Termina Módulo de Imágenes
    ####################################################################



    public function render(){
        if(Auth::user()){
            return view('livewire.sistema.home-controller');
        }else{
             redirect('/ingreso');
        }
    }
}
