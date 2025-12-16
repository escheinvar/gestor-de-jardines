<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ej_conteos extends Model
{
    // use HasFactory;
	protected $connection='pgsql';
	protected $table = 'ej_conteos';
	protected $primaryKey = 'cant_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
    'cant_id',
    'cant_ejmid',
    'cant_ubicaid',
    'cant_act',
    'cant_del',

    'cant_tipo',
    'cant_ext',
    'cant_inds',
    'cant_fecha',
    'cant_usrid',
    ];
}
