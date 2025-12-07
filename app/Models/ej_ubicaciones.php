<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ej_ubicaciones extends Model
{
        // use HasFactory;
	protected $connection='pgsql';
	protected $table = 'ej_ubicaciones';
	protected $primaryKey = 'sig_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'sig_id',
        'sig_ejmid',
        'sig_act',
        'sig_del',

        'sig_ccamsiglas',

        'sig_camid',
        'sig_camcamellon',
        'sig_x',
        'sig_y',

        'sig_restriccion',
        'sig_tipocrecim',
        'sig_icono',
        'sig_usrid',
        'sig_notas',

        'flag1',
        'flag2',
        'flag3',
        'flag4',
        'flag5',
    ];
}
