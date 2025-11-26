<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class bitacora1 extends ApiModel
{
    // use HasFactory;
	protected $connection='pgsql';
	protected $table = 'ej_bitacora1';
	protected $primaryKey = 'bit_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'bit_id',
        'bit_del',
        'bit_ejmid_prop',
        'bit_colectadate',
        'bit_origen',
        'bit_origen_explica',
        'bit_forma_colecta',
        'bit_etiqueta_colecta',
        'bit_autid',
        'bit_edo',
        'bit_mpio',
        'bit_localidad',
        'bit_paraje',
        'bit_x',
        'bit_y',
        'bit_altitud',
        'bit_obs_colecta',
        'bit_usrid',
        'bit_alias',
    ];
}
