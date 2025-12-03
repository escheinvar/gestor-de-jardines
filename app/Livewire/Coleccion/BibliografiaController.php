<?php

namespace App\Livewire\Coleccion;

use App\Models\bibliografia;
use App\Models\cat_campus;
use App\Models\usr_roles;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class BibliografiaController extends Component
{
    public $edit;   ##### Flag que permite (1) o no (0) editar
    public $ordenar, $sent;

    public function mount(){
        $this->ordenar='bib_id';
        $this->sent='asc';
    }

    public function AbrirModalBibliografia($par1){
        $data=['bibId'=>$par1];  ### donde $par1 tiene el Id del registro bibliográfico a editar ó 0 para nuevo
        $this->dispatch('abreModalDeBibliogfafia',$data);
    }

    public function ordenarTabla($campo){

    }

    public function render() {
        #####################################################
        #################################### Obtiene permisos
        ################################ y campus autorizados
        $autorizados=['admin-colviva','curador-cientifico'];
        if(array_intersect($autorizados,session('rol'))){
            $this->edit='1';
            $roles=array_intersect($autorizados,session('rol'));
            $bimodal_campuses=usr_roles::where('rol_usrid',Auth::user()->id)
                ->where('rol_del','0')
                ->where('rol_act','1')
                ->whereIn('rol_crolrol',$autorizados)
                ->select('rol_ccamsiglas as campus')
                ->get();
            if($bimodal_campuses->where('campus','todos')->count() > 0){
                $bimodal_campuses=cat_campus::where('ccam_act','1')
                    ->select('ccam_siglas as campus')
                    ->get();
            }
        }else{
            $this->edit='0';
            $bimodal_campuses= collect();
        }
        #####################################################
        ##### Obtiene lista de bibliografía
        $biblio=bibliografia::where('bib_act','1')
            ->where('bib_del','0')
            ->with('autores')
            ->orderBy($this->ordenar, $this->sent)
            ->get();


        return view('livewire.coleccion.bibliografia-controller',[
            'biblio'=>$biblio,
        ]);
    }
}
