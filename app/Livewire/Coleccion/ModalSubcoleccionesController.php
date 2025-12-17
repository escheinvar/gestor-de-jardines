<?php

namespace App\Livewire\Coleccion;

use App\Models\cat_subcolecciones;
use App\Models\ej_subcolecciones;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class ModalSubcoleccionesController extends Component
{
    public $modsubcol_coleccion;
    public $modsubcol_ejmid;


    #[On('abreModalDeSubcolecciones')]
    public function recibeVariables($datos){
        $this->modsubcol_ejmid=$datos['ejmId'];
    }

    public function borrarTodoModal(){
        $this->modsubcol_coleccion='';
    }

    public function AsignarAcoleccion(){
        ##### valida
        $this->validate([
            'modsubcol_coleccion'=>'required',
        ],['modsubcol_coleccion'=>'Debes indicar una subcolección']);

        ##### revisa que no esté en la colcción
        $YaExiste=ej_subcolecciones::where('col_ejmid',$this->modsubcol_ejmid)
            ->where('col_ccolcoleccion',$this->modsubcol_coleccion)
            ->count();
        if($YaExiste > '0'){
            $this->addError('modsubcol_coleccion','El ejemplar ya pertenece a esta colección');
            return;
        }

        ej_subcolecciones::create([
            'col_ejmid'=>$this->modsubcol_ejmid,
            'col_ccolcoleccion'=>$this->modsubcol_coleccion,
            'col_usrid'=>Auth::user()->id,
        ]);
        $this->borrarTodoModal();
        $this->dispatch('AvisoExitoSubcolecciones',msj:'El ejemplar se agregó correctmente a la colección');
        $this->dispatch('cierraModalDeSubcolecciones',reload:1);
    }

    public function render(){
        $colecciones=cat_subcolecciones::where('ccol_act','1')
            ->where('ccol_del','0')
            ->orderBy('ccol_coleccion')
            ->get();

        return view('livewire.coleccion.modal-subcolecciones-controller',[
            'colecciones'=>$colecciones,
        ]);
    }
}
