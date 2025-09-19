<?php

namespace App\Livewire\Sistema;

use App\Models\User;
use Livewire\Component;
use App\Models\usr_tokens;
use App\Models\InstitucionesModel;
use App\Models\UserRolesModel;
use Illuminate\Support\Facades\Hash;

class Nuevousuario01Controller extends Component
{
    public $token,$correo,$nombre,$apellido,$usrname,$nace;
    public $org,$contrasenia,$contrasenia2;
    public $finalizado;


    public function mount(string $token){
        $this->token = $token;
        $this->correo=usr_tokens::where('tok_token',$token)->where('tok_act','1')->where('tok_fin','>',now() )->pluck('tok_mail');
        $this->org='1';
        $this->finalizado='0';
        if($this->correo->count() > 0){
            $revisaUser=User::where('email',$this->correo)->where('act','1')->count();
            if($revisaUser > 0){
                $this->finalizado='1';
            }
        }

    }

    public function enviar(){
        ##### Valida cuestionario
        $this->validate([
            'correo'=>'required',
            'nombre'=>'required',
            'apellido'=>'required',
            'usrname'=>'required|unique:users,usrname',
            'contrasenia'=>'required',
            'contrasenia2'=>'required|same:contrasenia',
        ]);


        ##### Genera registro de usuario
        $ja=User::firstOrCreate(['email'=>$this->correo],[
            'id'=>User::max('id') + 1,
            'email'=>$this->correo[0],
            'usrname'=>$this->usrname,
            'nombre'=>$this->nombre,
            'apellido'=>$this->apellido,
            'nace'=>$this->nace,
            'cinsid'=>$this->org,
            'avatar'=>'default.png',
            'password'=>Hash::make($this->contrasenia),

        ]);

        ##### Otorga rol básico
        // UserRolesModel::firstOrCreate(['rol_usrid'=>$ja->id,'rol_crolrol'=>'web'],[
        //     'rol_act'=>'1',
        //     'rol_usrid'=>$ja->id,
        //     'rol_crolrol'=>'usr',
        //     'rol_describe'=>'Usuario del sistama',
        // ]);

        ##### Elimina tockens
        usr_tokens::where('tok_mail',$this->correo[0])->where('tok_act','1')->update([
            'tok_act'=>'0',
        ]);

        $this->finalizado='1';
    }

    public function render(){
        $instituciones=[];#InstitucionesModel::all();
        return view('livewire.sistema.nuevousuario01-controller',[
            'instituciones'=>$instituciones,
        ]);
    }
}
