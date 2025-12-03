<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


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
        'bib_titulo',
        'bib_nombre',
        'bib_numero',
        'bib_volumen',
        'bib_pp',
        'bib_editorial',
        'bib_lengua',
        'bib_tags',
        'bib_notasubica',
        'bib_edo',
        'bib_mpio',
        'bib_localidad',
        'bib_notapublica',
        'bib_tipotesis',
        'bib_ocupa',
        'bib_edad',

        'bib_doi',
        'bib_isbn',
        'bib_issn',
        'bib_url',
        'bib_pdf',
        'bib_priv',
    ];

    public function autores(): HasMany {
        return $this->hasMany(bibliografia_autores::class,'bibaut_bibid','bib_id');
    }
}
