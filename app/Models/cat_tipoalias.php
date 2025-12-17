<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class cat_tipoalias extends Model
{
    // use HasFactory;
	protected $connection='pgsql';
	protected $table = 'cat_tipoalias';
	protected $primaryKey = 'calias_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'calias_id',
        'calias_name',
        'calias_explica',
    ];
}
