<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class cat_roles extends Model
{
    // use HasFactory;
	protected $connection='pgsql';
	protected $table = 'cat_roles';
	protected $primaryKey = 'crol_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'crol_id',
        'crol_rol',
        'crol_gps',
        'crol_describe',
    ];
}
