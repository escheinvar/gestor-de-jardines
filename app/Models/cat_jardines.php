<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class cat_jardines extends Model
{
    // use HasFactory;
	protected $connection='pgsql';
	protected $table = 'cat_jardines';
	protected $primaryKey = 'cjar_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'cjar_id',
        'cjar_siglas',
        'cjar_name',
        'cjar_nombre',
        'cjar_tipo',
        'cjar_direccion',
        'cjar_tel',
        'cjar_mail',
        'cjar_edo',
        'cjar_logo',
    ];
}
