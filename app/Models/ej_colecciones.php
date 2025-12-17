<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ej_colecciones extends Model
{
        // use HasFactory;
	protected $connection='pgsql';
	protected $table = 'ej_subcolecciones';
	protected $primaryKey = 'col_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'col_id',
        'col_del',
        'col_act',
        'col_ejmid',
        'col_ccolcoleccion',
        'col_ccolcoleccion',
        'col_usrid',
    ];
}
