<?php

namespace App\Livewire\Coleccion;

use App\Models\ejemplares;
use App\Models\ej_nombres_cientificos;
use App\Models\ej_nombres_comunes;
use Livewire\Component;

class ExpedienteController extends Component
{

    public $idEjem;                      ##### Variables recibidas desde URL (Id del ejemplar)
    public $MenuDeEjemplares='expediente', $ejemplar, $ejemplar_ScName, $ejemplar_CoName;  ##### Variables solicitadas por la plantilla del menú del ejemplar

    public function mount($id){
        ######################################################
        ####################### Validaciones de permisos y URL
        ##### Revisa que el id sea sólo numérico
        if( !preg_match('/^\d+$/',$id)){
            return redirect()->route('error',["Error en el número de ejemplar"]);
        }

        ##### Confirma id correcto y carga datos
        if($id == '0'){
            $this->idEjem='0';
        }else{
            if(ejemplares::where('ejm_id',$id)->where('ejm_act','1')->where('ejm_del','0')->count() != '1'){
                return redirect()->route('error',["El número de ejemplar no existe"]);
            }
            $this->idEjem=$id;

        #############################################################
        ###### Carga los datos para la plantilla del menú de ejemplar
        $this->ejemplar=ejemplares::where('ejm_id',$this->idEjem)
            ->join('ej_bitacora1','ejm_bitid','=','bit_id')
            ->where('ejm_act','1')
            ->where('ejm_del','0')
            ->where('bit_del','0')
            ->first();

        $this->ejemplar_ScName=ej_nombres_cientificos::where('scn_ejmid',$this->idEjem)
            ->where('scn_act','1')
            ->where('scn_del','0')
            ->first();

        $this->ejemplar_CoName = ej_nombres_comunes::where('con_ejmid',$this->idEjem)
            ->where('con_act','1')
            ->where('con_del','0')
            ->orderBy('con_origen','desc')
            ->orderBy('con_bibid','asc')
            ->take(3)
            ->get();

        }
    }

    public function render(){
        return view('livewire.coleccion.expediente-controller');
    }
}
