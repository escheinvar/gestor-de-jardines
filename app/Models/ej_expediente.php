<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ej_expediente extends Model
{
    // use HasFactory;
	protected $connection='pgsql';
	protected $table = 'ej_expedientes';
	protected $primaryKey = 'exp_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'exp_id',
        'exp_ejmid',
        'exp_act',
        'exp_del',
        'exp_cexpname',
        'exp_cexpname',
        'exp_txt',
        'exp_file1',
        'exp_file2',
        'exp_file3',
        'exp_file4',
        'exp_file5',
        'exp_logmail',
        'exp_fecha',
        'exp_hora',
        'exp_usrid',
    ];
}
