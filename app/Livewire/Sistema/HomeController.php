<?php

namespace App\Livewire\Sistema;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class HomeController extends Component
{
    public function render(){

        if(Auth::user()){
            return view('livewire.sistema.home-controller');
        }else{
             redirect('/ingreso');
        }
    }
}
