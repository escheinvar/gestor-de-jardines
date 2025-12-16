<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class cat_gridas extends Model
{
     // use HasFactory;
	protected $connection='pgsql';
	protected $table = 'cat_gridas';
	protected $primaryKey = 'gri_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'gri_id',
        'gri_del',
        'gri_act',
        'gri_name',
        'gri_explica',
        'gri_ccamsiglas',
        'gri_ccamsiglas',
        'gri_resx',
        'gri_resy',
        'gri_mapa',
    ];
}
