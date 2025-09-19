<?php

namespace App\Livewire\Sistema;

use App\Mail\solicitoPasswordMail;
use App\Models\cat_campus;
use App\Models\cat_roles;
use App\Models\User;
use App\Models\usr_roles;
use App\Models\usr_tokens;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class HomeConfigController extends Component
{
    use WithFileUploads;

    public  $usrId,$correo,$usrname,$nombre,$apellido,$nace;
    public  $avatar,$Inactiva,$mensajes,$NvoAvatar,$rolesUsr;
    public  $NvoRol, $NvoJardin;

    public function mount(){
        $this->usrId= Auth::user()->id;
        $this->correo=Auth::user()->email;
        $this->usrname=Auth::user()->usrname;
        $this->nombre=Auth::user()->nombre;
        $this->apellido=Auth::user()->apellido;
        $this->nace=Auth::user()->nace;
        $this->avatar=Auth::user()->avatar;
        $act=Auth::user()->act;
        if($act=='1'){$this->Inactiva=FALSE;}else{$this->Inactiva=TRUE;}
        $men=Auth::user()->mensajes;
        if($men=='1'){$this->mensajes=TRUE;}else{$this->mensajes=FALSE;}
        $msj1='0';
    }

    public function GuardarCambios(){
        $this->validate([
            'nombre'=>'required',
            'apellido'=>'required',
            'usrname'=>'required|unique:users,usrname,'.$this->usrId,
        ]);
        ##### Si hay rol pendiente de guardar, lo guarda
        if($this->NvoJardin !='' AND $this->NvoRol != ''){$this->AgregarRol();}
        ##### convierte variable checkbox
        if($this->Inactiva==TRUE){$act='0';}else{$act='1';}
        if($this->mensajes==TRUE){$mens='1';}else{$mens='0';}
        ##### guarda
        User::where('id',$this->usrId)->update([
            'act'=>$act,
            'usrname'=>$this->usrname,
            'nombre'=>$this->nombre,
            'apellido'=>$this->apellido,
            'mensajes'=>$mens,
        ]);
        ##### Si hay nuevo avatar, lo guarda
        if($this->NvoAvatar != ''){
            $nombre="usuario_".$this->usrId.".".$this->NvoAvatar->getClientOriginalExtension();
            $this->NvoAvatar->storeAs(path:'avatar', name: $nombre);
            User::where('id',$this->usrId)->update([
                'avatar'=>$nombre,
            ]);
        }
        redirect('/home');
    }

    public function PedirTokenPasswd(){
        ###### ELIMINA POSIBLES REGISTROS PREEXISTENTES
        usr_tokens::where('tok_mail',$this->correo)->update([
            'tok_act'=>'0',
        ]);

        ######## GENERA TOCKEN Y LO GUARDA EN BASE DE DATOS
        function GeneraTocken($n) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $randomString = '';
            for ($i = 0; $i < $n; $i++) {
                $index = rand(0, strlen($characters) - 1);
                $randomString .= $characters[$index];
            }
            return $randomString;
        }
        $token=GeneraTocken(70);
        $hoy=date('Y-m-d H:i:s');
        $fin=date('Y-m-d H:i:s',strtotime('+20 minutes', strtotime($hoy)));

        usr_tokens::create([
            'tok_mail'=>$this->correo,
            'tok_token'=>$token,
            'tok_ini'=>$hoy,
            'tok_fin'=>$fin,
        ]);
        redirect(url('/').'/recuperaContrasenia/'.$token);
    }

    public function render() {
        $this->rolesUsr= usr_roles::where('rol_usrid',Auth::user()->id)
            ->where('rol_del','0')
            ->where('rol_act','1')
            ->orderBy('rol_ccamsiglas')
            ->get();

        return view('livewire.sistema.home-config-controller',[
            #'catJards'=>cat_campus::join('cat_jardines','ccam_cjarid','=','cjar_id')->get(),
            'catRoles'=>cat_roles::all(),
        ]);
    }
}
