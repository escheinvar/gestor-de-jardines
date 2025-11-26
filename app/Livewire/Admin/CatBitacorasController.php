<?php

namespace App\Livewire\Admin;

use App\Models\bitacora1;
use Livewire\Component;

class CatBitacorasController extends Component
{
    public function render() {
        $bitacoras=bitacora1::where('bit_del','0')->where('bit_id','!=','0')->get();

        return view('livewire.admin.cat-bitacoras-controller',[
            'bitacoras'=>$bitacoras,
        ]);
    }
}
