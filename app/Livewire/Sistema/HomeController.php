<?php

namespace App\Livewire\Sistema;

use App\Models\imagenes;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class HomeController extends Component
{


    ###################################################################
    ###################################### Inicia Módulo de Bitácoras
    public $MyId, $ja, $textin;
    public function mount(){
        $this->MyId='0';
    }
    public function lanzador($id){
        redirect()->route('bitacora',[$this->MyId]);
    }
    ###################################### Termina Módulo de Bitácoras
    ###################################################################


    public function render(){
        if(Auth::user()){
            return view('livewire.sistema.home-controller');
        }else{
             redirect('/ingreso');
        }
    }
}
