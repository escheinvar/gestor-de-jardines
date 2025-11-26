<?php

namespace App\Livewire\Coleccion;

use App\Models\bibliografia;
use Livewire\Component;

class BibliografiaController extends Component
{
    public function AbrirModalBibliografia($par1){
        $data=['bibId'=>$par1];  ### donde $par1 tiene el Id del registro bibliográfico a editar ó 0 para nuevo
        $this->dispatch('abreModalDeBibliogfafia',$data);
    }

    public function render() {
        $biblio=bibliografia::where('bib_act','1')
            ->where('bib_del','0')
            ->get();

        return view('livewire.coleccion.bibliografia-controller',[
            'biblio'=>$biblio,
        ]);
    }
}
