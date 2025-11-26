<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class bibliografia_autores extends Model
{
    // use HasFactory;
	protected $connection='pgsql';
	protected $table = 'bibliografia_autores';
	protected $primaryKey = 'bibaut_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'bibaut_id',
        'bibaut_del',
        'bibaut_bibid',
        'bibaut_nombre',
        'bibaut_ap',
        'bibaut_orcid',
    ];
}
