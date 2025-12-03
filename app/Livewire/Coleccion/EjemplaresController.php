<?php

namespace App\Livewire\Coleccion;

use App\Models\cat_campus;
use App\Models\ejemplares;
use App\Models\usr_roles;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class EjemplaresController extends Component
{
    public $edit;

    public function render(){
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
        ###### Carga ejemplares
        $ejemplares=ejemplares::where('ejm_del','0')
            ->orderBy('ejm_id')
            ->get();

        return view('livewire.coleccion.ejemplares-controller',[
            'ejemplares'=>$ejemplares,
        ]);
    }
}
