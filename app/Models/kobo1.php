<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class kobo1 extends Model
{
    // use HasFactory;
	protected $connection='pgsql';
	protected $table = 'kobo1';
	protected $primaryKey = 'kobo1_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'kobo1_id',
        'kobo1_del',
        'kobo1_ccamsiglas',

        'kobo1_koboid',
        'kobo1_index',
        'kobo1_username',
        'kobo1_date',

        'kobo1_camellon',
        'kobo1_fotoubica',
        'kobo1_x',
        'kobo1_y',
        'kobo1_nombrecuadr',
        'kobo1_notasubica',
    ];
}
