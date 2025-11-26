<?php

namespace App\Models;

use App\Models\ApiModel;
use Illuminate\Database\Eloquent\Model;

class cat_tipoimg extends ApiModel
{
    // use HasFactory;
	protected $connection='pgsql';
	protected $table = 'cat_tipoimgs';
	protected $primaryKey = 'cimg_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'cimg_id',
        'cimg_modulo',
        'cimg_tipo',
        'cimg_explica',
    ];
}
