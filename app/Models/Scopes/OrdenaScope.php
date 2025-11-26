<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class OrdenaScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        if(empty(request('ordena'))){
            return;
        }

        ################ ordenar campos
        if(request('ordena')){
            $ordenarPor=explode(',',request('ordena'));
            foreach($ordenarPor as $i){
                if(substr($i,0,1)=='-'){
                    $orden='desc';
                    $i=substr($i,1);
                }else{
                    $orden='asc';
                }
                $builder->orderBy($i,$orden);
            }
        }
    }
}
