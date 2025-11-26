<?php

namespace App\Livewire\Coleccion;

use App\Models\cat_kew;
use App\Models\especies;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class ModalNuevaEspecieController extends Component
{
    public $spid;  ##### Viene de controlador base. sp_id ó 0.
    ##############3 Variables de formulario
    public $modsp_forzarcatalogo;
    public $modsp_reino, $modsp_generoBusca, $modsp_especieSelected, $modsp_genero, $modsp_especie;
    public $modsp_ssp, $modsp_name, $modsp_autor, $modsp_cita, $modsp_familia, $modsp_id;
    public $especies;

    public function mount(){
        $this->modsp_forzarcatalogo=TRUE;
        $this->modsp_reino='';
        $this->modsp_generoBusca='';
        $this->modsp_genero='';
        $this->especies=collect();
    }

    #####################################################
    ##### Recibe variables desde el controlador que invoca
    #[On('abreModalDeNuevaEspecie')]
    public function recibeVariables($datos){
        $this->spid=$datos['spid'];
    }


    #####################################################
    ##### Detecta los reinos que tienen catálogo
    public function seleccionaReino(){
        if($this->modsp_reino=='an'){
            $this->modsp_forzarcatalogo=FALSE;

        }elseif($this->modsp_reino=='pl'){
            $this->modsp_forzarcatalogo=TRUE;

        }else{
            $this->modsp_forzarcatalogo=FALSE;
        }
        $this->modsp_familia='';
        $this->modsp_genero='';
        $this->modsp_especie='';
        $this->modsp_ssp='';
        $this->modsp_name='';
        $this->modsp_autor='';
        $this->modsp_cita='';
        $this->resetValidation();
    }

    #####################################################
    ##### Carga la lista de especies del género indicado
    public function BuscarGenero(){
        $this->validate([
            'modsp_generoBusca'=>'required',
        ],['modsp_generoBusca'=>'Debes indicar una búsqueda']);

        if($this->modsp_reino=='pl'){
            ###### Genera lista de especies y obtiene campos renombrados:
            ######   id, familia, genero, sp, spp, autor, cita, name
            $this->especies=cat_kew::where('ckew_genus','ilike','%'.$this->modsp_generoBusca.'%')
                ->select('ckew_taxonid as id','ckew_genus as genero','ckew_specificepithet as sp','ckew_infraspecificepithet as ssp','ckew_family as familia', 'ckew_scientfiicnameauthorship as autor','ckew_namepublishedin as cita','ckew_scientfiicname as name')
                ->orderBy('ckew_family','asc')
                ->orderBy('ckew_genus','asc')
                ->orderBy('ckew_specificepithet','asc')
                ->get();
        }
    }

    #####################################################
    ##### Define los valores de la especie seleccionada
    public function DefineEspecie(){
        if($this->modsp_especieSelected=='NuevaEspecie'){
            $this->modsp_genero='';
            $this->modsp_especie='';
            $this->modsp_ssp='';
            $this->modsp_name='';
            $this->modsp_autor='';
            $this->modsp_cita='';
            $this->modsp_familia='';
            $this->modsp_id='';
            $this->modsp_forzarcatalogo='0';
        }else{
            if($this->modsp_reino=='pl'){
                $this->validate([
                    'modsp_especieSelected'=>'required',
                ]);
                $dato=cat_kew::where('ckew_taxonid',$this->modsp_especieSelected)
                    ->select('ckew_taxonid as id','ckew_genus as genero','ckew_specificepithet as sp','ckew_infraspecificepithet as ssp','ckew_family as familia', 'ckew_scientfiicnameauthorship as autor','ckew_namepublishedin as cita','ckew_scientfiicname as name')
                    ->first();
            }
            $this->modsp_genero=$dato->genero;
            $this->modsp_especie=$dato->sp;
            $this->modsp_ssp=$dato->ssp;
            $this->modsp_name=$dato->name;
            $this->modsp_autor=$dato->autor;
            $this->modsp_cita=$dato->cita;
            $this->modsp_familia=$dato->familia;
            $this->modsp_id=$dato->id;
        }
    }


    #####################################################
    ##### borra los datos del modal
    public function borrarTodo(){
        $this->modsp_reino='';
        $this->modsp_generoBusca='';
        $this->modsp_especieSelected='';
        $this->modsp_genero='';
        $this->modsp_especie='';
        $this->modsp_ssp='';
        $this->modsp_name='';
        $this->modsp_autor='';
        $this->modsp_cita='';
        $this->modsp_familia='';
        $this->modsp_id='';
        $this->resetValidation();
    }

    #####################################################
    ##### Guarda los datos de la nueva especie
    public function Guardar(){
        ##### Valida datos
        $this->validate([
            'modsp_familia'=>'required',
            'modsp_genero'=>'required',
            // 'modsp_especie'=>'required',
            'modsp_name'=>'required',
            'modsp_autor'=>'required',
            'modsp_cita'=>'required',
        ]);
        ##### Valida que no exista ya en el catálogo
        $buscar=especies::where('sp_reino',$this->modsp_reino)
            ->where('sp_familia',$this->modsp_familia)
            ->where('sp_genero',$this->modsp_genero)
            ->where('sp_sp',$this->modsp_especie)
            ->where('sp_ssp',$this->modsp_ssp)
            ->count();

        if($buscar > 0){
            $this->addError('modsp_name','Esta especie ya está en el catálogo');
            return;
        }
        #dd($buscar);

        ##### Define si hay catálogo
        if($this->modsp_reino=='pl' AND $this->modsp_especieSelected != 'NuevaEspecie'){
            $catalogo='kew';
            $catId=$this->modsp_id;
        }else{
            $catalogo='User';
            $catId=Auth::user()->id;
        }
        especies::create([
            'sp_reino'=>$this->modsp_reino,
            'sp_familia'=>$this->modsp_familia,
            'sp_genero'=>$this->modsp_genero,
            'sp_sp'=>$this->modsp_especie,
            'sp_ssp'=>$this->modsp_ssp,
            'sp_name'=>$this->modsp_name,
            'sp_autor'=>$this->modsp_autor,
            'sp_reference'=>$this->modsp_cita,
            'sp_catorigin'=>$catalogo,
            'sp_catid'=>$catId,
        ]);
        $this->borrarTodo();
        $this->dispatch('cierraModalDeNuevaEspecie');
        $this->render();
    }

    public function render() {
        return view('livewire.coleccion.modal-nueva-especie-controller');
    }
}
