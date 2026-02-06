<?php

namespace App\Livewire\Admin;

use App\Models\cat_gridas;
use Livewire\Component;
use Livewire\WithFileUploads;

class ModalGridasController extends Component
{
    use WithFileUploads;

    public $gri_tipo,$gri_nombre, $gri_x, $gri_y, $gri_exp, $gri_file;

    public function Cerrar(){
        $this->reset('gri_tipo','gri_nombre', 'gri_x', 'gri_y', 'gri_exp', 'gri_file');
        $this->resetValidation();
        $this->resetErrorBag();
        $this->dispatch('cerraModalDeGridas');
    }

    public function Guardar(){
        ##### Valida formulario
        $this->validate([
            'gri_nombre'=>'required',
            'gri_x'=>'required',
            'gri_y'=>'required',
            'gri_file'=>'required|file|mimes:json',
        ]);

        ##### Guarda en base de datos
        cat_gridas::create([
            'gri_name'=>$this->gri_nombre,
            'gri_explica'=>$this->gri_exp,
            'gri_ccamsiglas'=>'JebOax',
            'gri_resx'=>$this->gri_x,
            'gri_resy'=>$this->gri_y,
            'gri_mapa'=>$this->gri_file->get(),
        ]);
        $this->dispatch('cierraModalDeGridas', reload:1);

    }

    public function render() {
        return view('livewire.admin.modal-gridas-controller');
    }
}
