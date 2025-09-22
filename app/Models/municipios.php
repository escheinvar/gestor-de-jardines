<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class municipios extends Model
{
    // use HasFactory;
	protected $connection='pgsql';
	protected $table = 'cat_municipios';
	protected $primaryKey = 'cmun_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'cmun_id',
        'cmun_cedoid',
        'cmun_edoname',
        'cmun_mpioid',
        'cmun_mpioname',
        'cmun_cabeceraid',
        'cmun_cabeceraname',
    ];
}
