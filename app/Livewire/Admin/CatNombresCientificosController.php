<?php

namespace App\Livewire\Admin;

use App\Models\especies;
use Livewire\Component;
use Livewire\WithPagination;

class CatNombresCientificosController extends Component
{
    use WithPagination;

    public $BuscaFam, $BuscaGen, $BuscaEsp;

    public function mount(){
        $BuscaFam='';
        $BuscaGen='';
        $BuscaEsp='';
        $OrderBy='sp_id';
        $OrderSent='asc';
    }

    public function LanzarModalDeNuevaEspecie($valor){
        $datos=['spid'=>$valor];
        $this->dispatch('abreModalDeNuevaEspecie', $datos);
    }


    public function Borrar($campo){
        if($campo=='familia'){
            $this->BuscaFam='';
        }elseif($campo=='genero'){
            $this->BuscaGen='';
        }elseif($campo=='especie'){
            $this->BuscaEsp='';
        }

    }

    public function render() {
        $especies=especies::where('sp_familia','ilike','%'.$this->BuscaFam.'%')
            ->where('sp_genero','ilike','%'.$this->BuscaGen.'%')
            ->where('sp_sp','ilike','%'.$this->BuscaEsp.'%')
            ->orderBy('sp_genero')
            ->orderBy('sp_sp')
            ->orderBy('sp_ssp')
            ->paginate('20');

        return view('livewire.admin.cat-nombres-cientificos-controller',[
            'especies'=>$especies,
        ]);
    }
}
