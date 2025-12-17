<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class cat_subcolecciones extends Model
{
    // use HasFactory;
	protected $connection='pgsql';
	protected $table = 'cat_subcolecciones';
	protected $primaryKey = 'ccol_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'ccol_id',
        'ccol_del',
        'ccol_act',
        'ccol_coleccion',
        'ccol_explica',
        'ccol_icono',
    ];
}
