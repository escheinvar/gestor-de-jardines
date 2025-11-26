<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class FiltroScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        if(empty(request('filtro'))){
            return;
        }

        ################ Filtros de campo, ejemplo: filtro[campo][operador]
        if(request('filtro')){
            $Myfiltros= request('filtro');
            foreach($Myfiltros as $campo => $condicion){
                foreach($condicion as $operador => $valor){
                    if(in_array($operador,['=','>','<','>=','<=','!=']) ){
                        $builder->where($campo,$operador,$valor);
                    };
                    if($operador=='ilike'){
                        $builder->where($campo,'ilike','%'.$valor.'%');
                    };
                }
            }
        }

    }
}
