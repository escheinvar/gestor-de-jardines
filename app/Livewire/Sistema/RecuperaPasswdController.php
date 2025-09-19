<?php

namespace App\Livewire\Sistema;

use DateTime;
use App\Models\User;
use Livewire\Component;
use App\Mail\solicitoPasswordMail;
use App\Models\usr_tokens;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Mail\Mailable;

class RecuperaPasswdController extends Component
{
    public $correo, $mensaje, $ver, $ver2;

    public function mount(){
        #MyRegistraVisita('web_login-RecuperaPassword');
        $this->ver='1';

    }

    public function validador(){
        ########## LEE EL CORREO ENVIADO
        $this->validate([
            'correo'=>'email|required',
        ]);

        $celda=User::where('email',$this->correo)->get();

        if($celda->count() == 0){
            $this->mensaje='0';
        }else{
            if($celda->where('act','1')->count() == 1 ){
                $this->mensaje='1';
                $this->ver='0';
            }elseif($celda->where('act','0')->count() == 1 ){
                $this->mensaje='2';
            }else{
                $this->ver='0';
            }
        }

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


        if ($this->mensaje =='1'){
            usr_tokens::create([
                'tok_mail'=>$this->correo,
                'tok_token'=>$token,
                'tok_ini'=>$hoy,
                'tok_fin'=>$fin,
            ]);

            ##### ENVÍA CORREO ELECTRÓNICO CON TOCKEN
            $Datos=['correo'=>$this->correo,'token'=>$token, 'fin'=>$fin];
            Mail::to($this->correo)->send(new solicitoPasswordMail($Datos));
        }
    }

    public function render()    {
        return view('livewire.sistema.recupera-passwd-controller');
    }
}
