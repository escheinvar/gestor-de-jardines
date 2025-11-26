<?php

namespace App\Livewire\Coleccion;

use App\Models\ejemplares;
use Livewire\Component;

class EjemplaresController extends Component
{
    public $edit;

    public function render(){
        $this->edit=TRUE;
        $ejemplares=ejemplares::where('ejm_del','0')
            ->orderBy('ejm_id')
            ->get();

        return view('livewire.coleccion.ejemplares-controller',[
            'ejemplares'=>$ejemplares,
        ]);
    }
}
