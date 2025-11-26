<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ej_nombres_cientificos extends Model
{
    // use HasFactory;
	protected $connection='pgsql';
	protected $table = 'ej_nombres_cientificos';
	protected $primaryKey = 'scn_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'scn_id',
        'scn_ejmid',
        'scn_spid',
        'scn_act',
        'scn_del',
        'scn_edo',
        'scn_reino',
        'scn_familia',
        'scn_genero',
        'scn_sp',
        'scn_ssp',
        'scn_name',

        'scn_colid',
        'scn_fecha_determina',
        'scn_usrid',
    ];
}
