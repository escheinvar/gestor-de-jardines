<?php

namespace App\Livewire\Admin;

use App\Models\cat_autoridades;
use Livewire\Component;

class CatAutoridadesController extends Component
{

    public $tipoA, $nameA;
    public $orden, $sent;

    public function mount(){
        $this->orden="aut_id";
        $this->sent="asc";
        $this->tipoA = '';
        $this->nameA = '';
    }

    public function ordenar($campo){
        $this->orden=$campo;
        if($this->sent=='asc'){
            $this->sent='desc';
        }else{
            $this->sent='asc';
        }
    }
    public function AbrirModalAutoridades($par1){
        $data=['autId'=>$par1];
        $this->dispatch('abreModalDeAutoridades',$data);
    }

    public function render(){
        $tipos=cat_autoridades::distinct('aut_tipo')->get();
        if($this->tipoA ==''){$tipo='%';}else{$tipo=$this->tipoA;}

        $Autoridades=cat_autoridades::query();

        $Autoridades->where('aut_ap1','!=','Digitalizador')
            ->orderBy($this->orden,$this->sent);

        if($this->tipoA != '' ){
            $Autoridades->where('aut_tipo','like',$tipo);
        }

        if($this->nameA != '' ){
            $Autoridades=$Autoridades->where('aut_ap1','ilike','%'.$this->nameA.'%')
                ->orWhere('aut_ap2','ilike','%'.$this->nameA.'%')
                ->orWhere('aut_nombre','ilike','%'.$this->nameA.'%');
        }

        return view('livewire.admin.cat-autoridades-controller',[
            'tipos'=>$tipos,
            'Auts'=>$Autoridades->get(),
        ]);
    }
}
