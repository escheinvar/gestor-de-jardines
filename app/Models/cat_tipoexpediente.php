<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class cat_tipoexpediente extends Model
{
    // use HasFactory;
	protected $connection='pgsql';
	protected $table = 'cat_tipoexpediente';
	protected $primaryKey = 'cexp_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'cexp_id',
        'cexp_name',
        'cexp_explica',
        'cexp_alarma',
        'cexp_asunto',
        'cexp_txt1',
        'cexp_txt2',
    ];
}
