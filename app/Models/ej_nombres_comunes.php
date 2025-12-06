<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ej_nombres_comunes extends Model
{
    // use HasFactory;
	protected $connection='pgsql';
	protected $table = 'ej_nombres_comunes';
	protected $primaryKey = 'con_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'con_id',
        'con_ejmid',
        'con_act',
        'con_del',
        'con_origen',
        // 'con_edo',
        'con_nombre',
        'con_clencode',
        'con_clencode',
        'con_bibid',

        'con_ubica',
        // 'con_estado',
        // 'con_mpio',
        'con_notas',

        'con_file1',
        'con_file2',
        'con_file3',
        'con_file4',
    ];
}
