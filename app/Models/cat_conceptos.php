<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class cat_conceptos extends Model
{
    // use HasFactory;
	protected $connection='pgsql';
	protected $table = 'cat_conceptos';
	protected $primaryKey = 'con_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'con_id',
        'con_tema',
        'con_txt',
        'con_explica',
    ];
}
