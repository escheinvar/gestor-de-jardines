<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class SeleccionaScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        if(empty(request('selecciona'))){
            return;
        }

        ################ Selecccionar campos
        if(request('selecciona')){
            $select = explode(',', request('selecciona') );
            $builder->select($select);
        }
    }
}
