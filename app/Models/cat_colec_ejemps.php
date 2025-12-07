<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class cat_colec_ejemps extends Model
{
     // use HasFactory;
	protected $connection='pgsql';
	protected $table = 'cat_colec_ejemps';
	protected $primaryKey = 'colsej_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'colsej_id',
        'colsej_ccamsiglas',
        'colsej_name',
        'colsej_explica',
    ];
}
