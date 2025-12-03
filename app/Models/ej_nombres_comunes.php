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
        'con_edo',
        'con_nombre',
        'con_clencode',
        'con_clencode',
        'con_bibid',

        'con_estado',
        'con_mpio',
        'con_notas',

        'con_audio1',
        'con_audio2',
        'con_img1',
        'con_img2',
    ];
}
