<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class cat_lenguas extends Model
{
    // use HasFactory;
	protected $connection='pgsql';
	protected $table = 'cat_lenguas';
	protected $primaryKey = 'clen_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'clen_id',
        'clen_lengua',
        'clen_code',
        'clen_localidad',
        'clen_usuarios',
        'clen_status',
        'clen_altnames',
        'clen_autonimias',
        'clen_clasifica',
        'clen_originario',
    ];
}
