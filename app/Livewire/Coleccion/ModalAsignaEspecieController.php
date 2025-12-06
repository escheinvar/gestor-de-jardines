<?php

namespace App\Livewire\Coleccion;

use App\Models\cat_autoridades;
use App\Models\ej_nombres_cientificos;
use App\Models\ejemplares;
use App\Models\especies;
use App\Models\usr_roles;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class ModalAsignaEspecieController extends Component
{
    public $idEjem; ##### Recibe (desde el controlador que lo invoca) el Id del ejemplar al que se asigna nombre
    public $edit_curcient, $edit_adcolviva; ##### flag de permisos por rol
    public $modcient_reino, $modcient_especieSelected, $modcient_generoBusca, $modcient_especies;
    public $modcient_autoridades, $modcient_autoridad, $modcient_fecha;


    #[On('abreModalDeNombreCientifico')]
    public function recibeVariables($datos){
        $this->idEjem=$datos;
    }

    public function mount(){
        $this->modcient_reino='pl';
        $this->modcient_especieSelected='';
        $this->modcient_generoBusca='';
        $this->modcient_especies=collect();

        ############################################################
        ################################# Determina permisos por rol
        ##### Campus propietario del ejemplar
        $campusDelEjemplar=ejemplares::where('ejm_id',$this->idEjem)
            ->value('ejm_ccamsiglas');
        ##### Campus a los que accede el curador científico
        $campusDelCurCient=usr_roles::where('rol_usrid',Auth::user()->id)
            ->where('rol_crolrol','curador-cientifico')
            ->pluck('rol_ccamsiglas')
            ->toArray();
        ##### Permisos de curador-cientifico
        if(in_array('curador-cientifico',session('rol'))  AND array_intersect([$campusDelEjemplar,'todos'],$campusDelCurCient) ){
            $this->edit_curcient='1';
        }else{
            $this->edit_curcient='0';
        }
        ##### Campus a los que accede el admin-colviva
        $campusDelAdminColViva=usr_roles::where('rol_usrid',Auth::user()->id)
            ->where('rol_crolrol','admin-colviva')
            ->pluck('rol_ccamsiglas')
            ->toArray();

        ##### Permisos del admin-colviva
        if(in_array('admin-colviva',session('rol'))  AND array_intersect([$campusDelEjemplar,'todos'],$campusDelAdminColViva) ){
            $this->edit_adcolviva='1';
        }else{
            $this->edit_adcolviva='0';
        }



        if($this->edit_curcient=='1'){
            $this->modcient_autoridades=cat_autoridades::where('aut_id','!=','0')
                ->select('aut_id','aut_nombre','aut_ap1','aut_ap2')
                ->orderBy('aut_nombre')
                ->orderBy('aut_ap1')
                ->get();
        }elseif($this->edit_adcolviva=='1') {
            $this->modcient_autoridades=cat_autoridades::where('aut_id','!=','0')
                ->select('aut_id','aut_nombre','aut_ap1','aut_ap2')
                ->where('aut_tipo','colecta')
                ->orderBy('aut_nombre')
                ->orderBy('aut_ap1')
                ->get();
        }
    }

    public function borrarTodo(){
        // #$this->modcient_reino='';
        $this->modcient_especieSelected='';
        $this->modcient_especieSelected='';
        $this->modcient_generoBusca='';
        $this->modcient_especies=collect();
    }

    public function BuscarGenero(){
        ##### Valida campos
        $this->validate([
            'modcient_generoBusca'=>'required',
            'modcient_reino'=>'required',
        ]);

        ##### genera tabla de la búsqueda con reino seleccionado y genero escrito
        $this->modcient_especies=especies::where('sp_reino',$this->modcient_reino)
            ->where('sp_genero','ilike','%'.$this->modcient_generoBusca.'%')
            ->orderBy('sp_familia')
            ->orderBy('sp_name')
            ->get();
    }

    public function DefineEspecie(){
        ##### Valida campos
        $this->validate([
            'modcient_especieSelected'=>'required',
            'modcient_autoridad'=>'required',
            'modcient_fecha'=>'required|before_or_equal:today',
        ]);

        ##### Busca datos de la especie seleccionada
        $especie=especies::where('sp_id',$this->modcient_especieSelected)->first();
        ##### Busca datos de quien valida
        $autoridad=cat_autoridades::where('aut_id',$this->modcient_autoridad)->first();


        ##### Determina el estado o nivel de validez del nombre
        $edo='0';  ##### Nombre por admin-colviva y sin validar
        if($this->edit_curcient=='1'){
            if($autoridad->aut_tipo=='colecta'){
                $edo='1';  #### Nombre validado por un técnico
            }elseif($autoridad->aut_tipo=='taxonomia'){
                $edo='2'; ##### Nombre validado por una autoridad taxonómica
            }else{
                $edo='0';  ##### Nombre sin validar
            }
        }elseif($this->edit_adcolviva=='1'){
            $edo='0';
        }
        ###### Inactiva todo nombre preexistente
        ej_nombres_cientificos::where('scn_ejmid',$this->idEjem)->update([
            'scn_act'=>'0',
        ]);

        ###### Guarda en base de datos
        ej_nombres_cientificos::create([
            'scn_ejmid'=>$this->idEjem,
            'scn_spid'=>$this->modcient_especieSelected,
            'scn_edo'=>$edo,
            'scn_reino'=>$especie->sp_reino,
            'scn_familia'=>$especie->sp_familia,
            'scn_genero'=>$especie->sp_genero,
            'scn_sp'=>$especie->sp_sp,
            'scn_ssp'=>$especie->sp_ssp,
            'scn_name'=>$especie->sp_name,
            'scn_colid'=>$autoridad->aut_id,
            'scn_fecha_determina'=>$this->modcient_fecha,
            'scn_usrid'=>Auth::user()->id,
        ]);
        $this->dispatch('cierraModalDeNombreCientifico');
        $this->dispatch('AvisoExitoAsignaSp', msj:'La especie fue asignada al ejemplar correctamente');
        $this->borrarTodo();
        return redirect('/ejem_nombres/'.$this->idEjem);        #return redirect()->back();
    }

    public function abreModalParaNuevaEspecie(){
        $this->dispatch('cierraModalDeNombreCientifico');
        $data=['spid'=>'0'];
        $this->dispatch('abreModalDeNuevaEspecie',$data);
    }

    public function AbrirModalAutoridades($par1){
        $this->dispatch('cierraModalDeNombreCientifico');
        $data=['autId'=>$par1];
        $this->dispatch('abreModalDeAutoridades',$data);
    }


    public function render() {


        return view('livewire.coleccion.modal-asigna-especie-controller');
    }
}
