<?php

namespace App\Livewire\Web;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class ApiManual extends Component
{

    public $token, $passwd,$mensaje;

    public function mount(){
        if(array_intersect(['api-read','api'],session('rol'))){
            $this->token=Auth::user()->api_token;
        }
        $this->mensaje='';

    }

    public function logoutToken(){
        $ApiResp = Request::create(
            '/api/auth/logout',
            'post',
            [],
            [],
            [],
            ['HTTP_ACCEPT'=>'application/json',
             'HTTP_AUTHORIZATION'=>'bearer '.Auth::user()->api_token,],
        );
        $respuesta= app()->handle($ApiResp);


        $this->redirect('/api_manual');
    }

    public function loginToken(){
        $this->validate(['passwd'=>'required']);
        $this->mensaje='entra';
        // $url=url('/api/auth/login');
        $url='http://127.0.0.1:8000/api/auth/login';

        $ApiResp = Request::create('/api/auth/login','post',[
            'email'=>Auth::user()->email,
            'password'=>$this->passwd,
        ]);
        $respuesta= app()->handle($ApiResp);
        $this->redirect('/api_manual');
    }



    public function render(){
        return view('livewire.web.api-manual');
    }
}
