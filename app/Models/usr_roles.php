<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class usr_roles extends Model
{
    // use HasFactory;
	protected $connection='pgsql';
	protected $table = 'usr_roles';
	protected $primaryKey = 'rol_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'rol_id',
        'rol_del',
        'rol_act',
        'rol_usrid',
        'rol_ccamsiglas',
        'rol_crolrol',
        'rol_tipo1',
        'rol_tipo2',

        'rol_describe',
    ];
}
