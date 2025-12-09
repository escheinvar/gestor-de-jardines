<?php

namespace App\Livewire\Coleccion;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use App\Models\ej_alias;
use App\Models\ejemplares;
use Livewire\Component;


class ModalAliasController extends Component
{

    public $modalias_ejmId, $modalias_tipoPredef, $modalias_tipoAlias;
    public $modalias_otroTipo, $modalias_nuevoAlias, $modalias_explica;

    #[On('abreModalDeAlias')]
    public function cargaDatos($datos){
        ##### Define variables
        $this->modalias_ejmId = $datos['ejmId'];
        if($datos['tipo'] !=''){
            $this->modalias_tipoAlias = $datos['tipo'];
            $this->modalias_tipoPredef='1';
        }else{
            $this->modalias_tipoAlias='';
            $this->modalias_tipoPredef='0';
        }
    }

    public function cerrarModal(){
        $this->borrarTodoModal();
        $this->dispatch('cierraModalDeAlias',reload:1);
    }

    public function borrarTodoModal(){
        $this->modalias_ejmId='';
        $this->modalias_tipoPredef='';
        $this->modalias_tipoAlias='';
        $this->modalias_otroTipo='';
        $this->modalias_nuevoAlias='';
        $this->modalias_explica='';
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function GuardarAlias(){
        ##### Valida campo
        $this->validate([
            'modalias_tipoAlias'=>'required',
            'modalias_nuevoAlias'=>'required',
        ]);
        ##### Valida no repetición
        $busca=ej_alias::where('alias_tipo',$this->modalias_tipoAlias)
            ->where('alias_nombre','ilike',$this->modalias_nuevoAlias)
            ->where('alias_act','1')->where('alias_del','0')
            ->count();
        if($busca > '0'){
            $this->addError('modalias_nuevoAlias','Este alias ya está en el sistema para este ejemplar');
            return;
        }
        ##### Obtiene id de bitácora
        // if($this->modalias_tipoAlias=='bitácora'){
            $dataBit=ejemplares::where('ejm_id',$this->modalias_ejmId)->value('ejm_bitid');
        // }else{
        //     $dataBit=null;
        // }
        ##### Si se indicó el tipo "otro", entonces toma nuevo valor
        if($this->modalias_tipoAlias=='otro'){$this->modalias_tipoAlias=$this->modalias_otroTipo;}
        ##### Guarda el nuevo alias
        ej_alias::create([
            'alias_ejmid'=>$this->modalias_ejmId,
            'alias_bitid'=>$dataBit,
            'alias_tipo'=>$this->modalias_tipoAlias,
            'alias_nombre'=>$this->modalias_nuevoAlias,
            'alias_explica'=>$this->modalias_explica,
            'alias_usrid'=>Auth::user()->id,
        ]);
        ##### da aviso
        $this->dispatch('AvisoExitoAlias',msj:'El alias se guardó correctamente');
        ##### Cierra modal
        $this->cerrarModal();
    }

    public function render(){
        return view('livewire.coleccion.modal-alias-controller');
    }
}
