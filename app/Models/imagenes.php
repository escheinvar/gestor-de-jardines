<?php

namespace App\Models;

use App\Models\ApiModel;
use Illuminate\Database\Eloquent\Model;

class imagenes extends ApiModel
{
    // use HasFactory;
	protected $connection='pgsql';
	protected $table = 'imagenes';
	protected $primaryKey = 'img_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'img_id',

        'img_ejmid',
        'img_spid',

        'img_act',
        'img_del',
        'img_cimgtipo',
        'img_tipo2',

        'img_titulo',
        'img_ubica',
        'img_explica',
        'img_autor',
        'img_fecha',
        'img_modulo',
        'img_y',
        'img_x',
        'img_media',
        'img_ruta',
        'img_usrid',
    ];
}
