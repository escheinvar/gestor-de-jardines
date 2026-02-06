<?php

namespace App\Livewire\Sistema;

use App\Models\cat_campus;
use App\Models\cat_jardines;
use App\Models\cat_roles;
use App\Models\User;
use App\Models\usr_roles;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class AdminUsuariosController extends Component
{
    use WithFileUploads;

    public $edit;
    public  $usrId,$correo,$usrname,$nombre,$apellido,$nace;
    public  $Inactiva,$mensajes,$avatar,$NvoAvatar,$rolesUsr,$orden,$sentido;
    public  $NvoRol, $NvoJardin;

    public function mount(){
        $this->rolesUsr=[];
        $this->orden='email';
        $this->sentido='asc';
    }

    public function ordenaTabla($ord){
        if($this->sentido=='asc'){
            $this->sentido='desc';
        }else{
            $this->sentido='asc';
        }
        $this->orden=$ord;
    }

    public function render() {
        ################################# Revisa permisos
        if(array_intersect(['admin','admin-campus'],session('rol'))){
            $this->edit='1';
        }else{
            $this->edit='0';
        }

        $usuarios=User::select(['id','act','email','usrname','nombre','apellido','nace','avatar'])
            ->orderBy($this->orden,$this->sentido)
            ->get();

        $roles=usr_roles::where('rol_act','1')
            ->orderBy('rol_crolrol','asc')
            ->orderBy('rol_tipo1','asc')
            ->orderBy('rol_tipo2','asc')
            ->get();
        ##### jardines autoirizados (de admin-campus)
        $JardsUsr=usr_roles::where('rol_usrid',Auth::user()->id)
            ->where('rol_crolrol','admin-campus')
            ->where('rol_del','0')
            ->where('rol_act','1')
            ->pluck('rol_ccamsiglas')
            ->toArray();
#dd($JardsUsr);
        if(in_array('admin',session('rol')) or in_array('todos',$JardsUsr)){
            $catJards=cat_campus::where('ccam_act','1')
                ->OrderBy('ccam_siglas')
                ->orderBy('ccam_name')
                ->get();
        }else{
            $catJards=cat_campus::where('ccam_act','1')
                ->OrderBy('ccam_siglas')
                ->orderBy('ccam_name')
                ->whereIn('ccam_siglas',$JardsUsr)
                ->get();
        }




        return view('livewire.sistema.admin-usuarios-controller',[
            'usuarios'=>$usuarios,
            'roles'=>$roles,
            'catJards'=>$catJards,
            'catRoles'=>cat_roles::select('crol_rol','crol_describe')->orderBy('crol_rol')->get(),
            'JardsDelUsr'=>$JardsUsr,
        ]);
    }

    ###################################################
    ###################  Iniciamos funciones de modal
    public function AbreModal($var){
        ##### Carga variables del usuario
        $this->usrId=$var;
        $this->correo=User::where('id',$var)->value('email');
        $this->usrname=User::where('id',$var)->value('usrname');
        $this->nombre=User::where('id',$var)->value('nombre');
        $this->apellido=User::where('id',$var)->value('apellido');
        $this->nace=User::where('id',$var)->value('nace');
        $this->avatar=User::where('id',$var)->value('avatar');
        $act=User::where('id',$var)->value('act');
        if($act=='1'){$this->Inactiva=FALSE;}else{$this->Inactiva=TRUE;}
        $men=User::where('id',$var)->value('mensajes');
        if($men=='1'){$this->mensajes=TRUE;}else{$this->mensajes=FALSE;}
        $this->rolesUsr=usr_roles::where('rol_usrid',$var)
            ->where('rol_del','0')
            ->where('rol_act','1')
            ->orderBy('rol_ccamsiglas')
            ->get();
        #### Abre modal
        $this->dispatch('AbreModal');
    }

    public function CierraModal(){
        $this->reset(['usrId','correo','usrname','nombre','apellido','nace','avatar','Inactiva','NvoAvatar','mensajes']);
        $this->rolesUsr=[];
        $this->dispatch('CierraModal');
    }

    public function InactivarRol($rolId){
        usr_roles::where('rol_id',$rolId)->update([
            'rol_act'=>'0',
        ]);
        $this->NvoRol='';
        $this->NvoJardin='';
        $this->AbreModal($this->usrId);
    }

    public function AgregarRol(){
        usr_roles::create([
            'rol_id'=>usr_roles::count()+1,
            'rol_usrid'=>$this->usrId,
            'rol_ccamsiglas'=>$this->NvoJardin,
            'rol_crolrol'=>$this->NvoRol,
        ]);
        $this->NvoRol='';
        $this->NvoJardin='';
        $this->AbreModal($this->usrId);
    }

    public function GuardaModal(){
        $this->validate([
            'nombre'=>'required',
            'apellido'=>'required',
            'usrname'=>'required|unique:users,usrname,'.$this->usrId,
        ]);
        ##### Si hay rol pendiente de guardar, lo guarda
        if($this->NvoJardin !='' AND $this->NvoRol != ''){$this->AgregarRol();}
        ##### convierte variable checkbox
        if($this->Inactiva==TRUE){$act='0';}else{$act='1';}
        ##### guarda
        User::where('id',$this->usrId)->update([
            'act'=>$act,
            'usrname'=>$this->usrname,
            'nombre'=>$this->nombre,
            'apellido'=>$this->apellido,
        ]);
        ##### Si hay nuevo avatar, lo guarda
        if($this->NvoAvatar != ''){
            $nombre="usuario_".$this->usrId.".".$this->NvoAvatar->getClientOriginalExtension();
            $this->NvoAvatar->storeAs(path:'avatar', name: $nombre);
            User::where('id',$this->usrId)->update([
                'avatar'=>$nombre,
            ]);
        }
        $this->CierraModal();
    }
}
