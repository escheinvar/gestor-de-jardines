<?php

namespace App\Livewire\Web;

use Livewire\Component;

class NoauthController extends Component
{
    public $msj;

    public function mount($msj){
        $this->msj=$msj;
    }

    public function render() {
        return view('livewire.web.noauth-controller');
    }
}
