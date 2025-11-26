<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class bitacora1 extends ApiModel
{
     // use HasFactory;
	protected $connection='pgsql';
	protected $table = 'ej_bitacora2';
	protected $primaryKey = 'bit_bitid';
	public $incrementing = false;
	#protected $keyType = 'string';

    protected $fillable = [
        'bit_bitid',
        'bit_descrsitiocolecta',
        'bit_suelo_textura_arena',
        'bit_suelo_textura_arcilla',
        'bit_suelo_textura_limo',
        'bit_suelo_ph',
        'bit_suelo_peregosidad',
        'bit_suelo_pendiente',
        'bit_vegetacion',
        'bit_abundancia',
        'bit_iluminacion',
        'bit_plantasasociadas',
        'bit_ejemplar_tiporaiz',
        'bit_ejemplar_formabiologica',
        'bit_ejemplar_altura_cm',
        'bit_ejemplar_diam_altpecho_cm',
        'bit_ejemplar_diam_suelo_cm',
        'bit_ejemplar_cobertura_cm',
        'bit_notas_colecta',
    ];
}
