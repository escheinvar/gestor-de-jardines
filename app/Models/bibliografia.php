<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class bibliografia extends Model
{
    // use HasFactory;
	protected $connection='pgsql';
	protected $table = 'bibliografias';
	protected $primaryKey = 'bib_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'bib_id',
        'bib_act',
        'bib_del',
        'bib_ccamsiglas',
        'bib_tipo',
        'bib_anio',
        'bib_nombre',
        'bib_titulo',
        'bib_numero',
        'bib_volumen',
        'bib_pp',
        'bib_editorial',
        'bib_pais',
        'bib_lengua',
        'bib_tags',
        'bib_notasubica',
        'bib_notapublica',

        'bib_doi',
        'bib_isbn',
        'bib_issn',
        'bib_url',
        'bib_pdf',
    ];
}
