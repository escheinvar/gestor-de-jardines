<?php

namespace App\Livewire\Coleccion;

use Livewire\Component;

class Prueba extends Component
{
    public $var1;


    public function mount(){
        $this->var1='Variable1';
    }


    public function render(){
        return view('livewire.coleccion.prueba');
    }
}
