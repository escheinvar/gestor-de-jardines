<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class estados extends Model
{
    // use HasFactory;
	protected $connection='pgsql';
	protected $table = 'cat_estados';
	protected $primaryKey = 'cedo_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'cedo_id',
        'cedo_nombre',
        'cedo_abrevia',
    ];
}
