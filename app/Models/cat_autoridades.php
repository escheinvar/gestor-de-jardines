<?php

namespace App\Models;

use App\Models\ApiModel;
use Illuminate\Database\Eloquent\Model;

class cat_autoridades extends ApiModel
{
    // use HasFactory;
	protected $connection='pgsql';
	protected $table = 'cat_autoridades';
	protected $primaryKey = 'aut_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'aut_id',
        'aut_ap1',
        'aut_ap2',
        'aut_nombre',
        'aut_inst',
        'aut_mail',
        'aut_tel',
        'aut_tipo',
        'aut_tema',
        'aut_usrid',
    ];
}
