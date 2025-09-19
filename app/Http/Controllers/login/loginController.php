<?php

namespace App\Http\Controllers\login;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserRolesModel;
use Illuminate\Support\Facades\Auth;

class loginController extends Controller
{
    public function index(){

        if(Auth::user()){
            return redirect('home');
        }else{
            return view('login/login',['mensaje'=>'']);
        }
    }

    public function store(Request $request){
        $request->session()->regenerate();
        ##### Valida cuestionario
        $request->validate([
            'correo'=>'required',
            'contrasenia'=> 'required',
        ]);

        $credentials = [
            'email' => $request->correo,
            'password' => $request->contrasenia,
        ];
        $remember= $request->dejarActiva;
        $usrActivo=User::where('email',$request->correo)->value('act');
        if($usrActivo=='0'){
            return view('login/login',['mensaje'=>'Usuario Inactivado.<br> Contacta al administrador','mensaje1'=>'']);
        }
        ##### Autentica contra directorio activo
        if($usrActivo=='1' & Auth::attempt($credentials, $remember)) {
            return redirect('/home');

        }else{
            return view('login/login',['mensaje'=>'Credenciales erróneas','mensaje1'=>'']);

        }
        return view('login/login',['mensaje'=>'Error','mensaje1'=>'']);

    }
}
