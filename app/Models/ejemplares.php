<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ejemplares extends Model
{
     // use HasFactory;
	protected $connection='pgsql';
	protected $table = 'ejemplares';
	protected $primaryKey = 'ejm_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'ejm_id',
        'ejm_act',
        'ejm_del',

        'ejm_edo_ubica',
        'ejm_edo_scname',
        'ejm_edo_name',
        'ejm_edo_uso',

        'ejm_ccamsiglas',
        'ejm_bitid',
        'ejm_madreid',
        'ejm_padreid',
        'ejm_loteid',

        'ejm_ripdate',
        'ejm_ripcausa',
        'ejm_notasingreso',
    ];
}
