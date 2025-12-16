<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class kobo2 extends Model
{
    // use HasFactory;
	protected $connection='pgsql';
	protected $table = 'kobo2';
	protected $primaryKey = 'kobo2_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'kobo2_id',
        'kobo2_del',

        'kobo2_koboid',
        'kobo2_parentindex',

        'kobo2_nombreejemplar',
        'kobo2_clavo',
        'kobo2_tipoejem',
        'kobo2_numcols',
        'kobo2_numinds',
        'kobo2_numext',
        'kobo2_fotoejemplar',
        'kobo2_fotoejemplar2',
        'kobo2_fotoflor',
        'kobo2_fotohoja',
        'kobo2_fotofrutos',
        'kobo2_nombrecient',
        'kobo2_nombrecom',

        ####################################
        ###################### Datos de kobo1

        'kobo2_ccamsiglas',
        'kobo2_username',
        'kobo2_date',
        'kobo2_camellon',
        'kobo2_fotoubica',
        'kobo2_x',
        'kobo2_y',
        'kobo2_nombrecuadr',
        'kobo2_notasubica',

        'kobo2_saved',
    ];
}
