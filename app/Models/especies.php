<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class especies extends Model
{
     // use HasFactory;
	protected $connection='pgsql';
	protected $table = 'especies';
	protected $primaryKey = 'sp_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'sp_id',
        'sp_reino',
        'sp_familia',
        'sp_genero',
        'sp_sp',
        'sp_ssp',
        'sp_name',
        'sp_autor',
        'sp_reference',
        'sp_catorigin',
        'sp_catid',
    ];
}
