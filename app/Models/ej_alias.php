<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ej_alias extends Model
{
    // use HasFactory;
	protected $connection='pgsql';
	protected $table = 'ej_alias';
	protected $primaryKey = 'alias_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'alias_id',
        'alias_act',
        'alias_del',
        'alias_ejmid',
        'alias_bitid',
        'alias_tipo',
        'alias_nombre',
        'alias_explica',
        'alias_usrid',
    ];
}
