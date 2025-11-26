<?php

namespace App\Livewire\Coleccion;

use App\Models\ej_nombres_cientificos;
use App\Models\ejemplares;
use App\Models\usr_roles;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NombresController extends Component
{

    public $idEjem;                      ##### Variables recibidas desde URL (Id del ejemplar)
    public $MenuDeEjemplares='nombres'; ##### Variable solicitadas por front-end para mostrar "Bictacora de ingreso" como activo
    public $edit_curcient,$CampusAutorizados;     ##### Variable solicitadas por front-end para entrar en modo edición
    public $ejemplar, $ejemplar_ScName;  ##### Colección con datos del ejemplar
    public $HayNomCien;                ##### Flag que vale 0 cuando no hay ni un nombre cient. y 1 cuando sí hay.



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

            ####################################################################
            ##################################### Carga los datos del ejemplar
            $ejemplar=ejemplares::where('ejm_id',$id)
                ->join('ej_bitacora1','ejm_bitid','=','bit_id')
                ->where('ejm_act','1')
                ->where('ejm_del','0')
                ->where('bit_del','0')
                ->first();
            $this->ejemplar=$ejemplar;
            $this->ejemplar_ScName=ej_nombres_cientificos::where('scn_ejmid',$this->idEjem)
                ->where('scn_act','1')
                ->where('scn_del','0')
                ->first();

        }
    }

    public function BorraNombre($id){
        ej_nombres_cientificos::where('scn_id',$id)->update([
            'scn_act'=>'0',
        ]);
        return redirect('/ejem_nombres/'.$this->idEjem);
    }

    public function abreModalDeNombreCientifico(){
        $this->dispatch('abreModalDeNombreCientifico',$this->idEjem);
    }

    public function render() {
        ##### Busca nombres científicos
        $nomcien=ej_nombres_cientificos::where('scn_ejmid',$this->idEjem)
            ->leftJoin('cat_autoridades','scn_colid','=','aut_id')
            ->where('scn_act','1')
            ->where('scn_del','0')
            ->first();

        ##### Determina flag $nomcien de si hay (1) o no (0) nombre científico
        if(isset($nomcien)){
            if($nomcien->count() >'0'){
                $this->HayNomCien='1';
            }else{
                $this->HayNomCien='0';
            }
        }else{
            $this->HayNomCien='0';
        }
        ##### Determina si hay permiso de edición

        ##### Genera array de campus permitidos para el usuario
        if(in_array('curador-cientifico',session('rol'))){
            $this->CampusAutorizados=usr_roles::where('rol_del','0')
                ->where('rol_act','1')
                ->where('rol_usrid',Auth::user()->id)
                ->where('rol_crolrol','curador-cientifico')
                ->pluck('rol_ccamsiglas')
                ->toArray();
        }elseif(in_array('admin-colviva',session('rol'))){
            $this->CampusAutorizados=usr_roles::where('rol_del','0')
                ->where('rol_act','1')
                ->where('rol_usrid',Auth::user()->id)
                ->where('rol_crolrol','admin-colviva')
                ->pluck('rol_ccamsiglas')
                ->toArray();
        }


        ##################### Asigna permisos de edición
        $this->edit_curcient=FALSE; #### Inicia sin permiso
        ##### Si tiene rol admin-colviva o curador-científico,
        ##### revisa que tenga acceso al jardín
        #dd($this->ejemplar->ejm_ccamsiglas, $this->CampusAutorizados);
        if(array_intersect(['curador-cientifico'],session('rol'))){
            if(array_intersect([$this->ejemplar->ejm_ccamsiglas], $this->CampusAutorizados)
            OR
            in_array('todos',$this->CampusAutorizados)){
                $this->edit_curcient=TRUE;
            }else{
                $this->edit_curcient=FALSE;
            }
        }else{
               redirect('/noauth/No cuentas con los privilegios correctos');
        }





        return view('livewire.coleccion.nombres-controller',[
            'nomcien'=>$nomcien,
        ]);
    }
}
