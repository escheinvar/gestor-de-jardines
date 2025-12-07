<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class cat_iconos extends Model
{
     // use HasFactory;
	protected $connection='pgsql';
	protected $table = 'cat_iconos';
	protected $primaryKey = 'icon_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'icon_id',
        'icon_name',
        'icon_file',
        'icon_ancho',
        'icon_largo',
        'icon_col',
        'icon_bgcol',
    ];
}
