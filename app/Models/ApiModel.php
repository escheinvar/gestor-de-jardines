<?php

namespace App\Models;

use App\Models\Scopes\FiltroScope;
use App\Models\Scopes\OrdenaScope;
use App\Models\Scopes\SeleccionaScope;
use Illuminate\Database\Eloquent\Model;

class ApiModel extends Model
{
    protected static function booted():void{
        static::addGlobalScopes([
            FiltroScope::class,
            SeleccionaScope::class,
            OrdenaScope::class,
        ]);
    }
    // public function scopePaginacion($query){
    //     if(request('paginar')){
    //         return $query->paginate(request('paginar'));
    //     }else{
    //         return $query->get();
    //     }
    // }
}
