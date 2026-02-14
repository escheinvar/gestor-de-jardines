<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class cat_campus extends Model
{
    // use HasFactory;
	protected $connection='pgsql';
	protected $table = 'cat_campus';
	protected $primaryKey = 'ccam_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'ccam_id',
        'ccam_act',
        'ccam_cjarid',
        'ccam_siglas',
        'ccam_name',
        'ccam_nombre',
        'ccam_edo',
        'ccam_mpio',
        'ccam_direccion',
    ];

    public function jardin(){
        return $this->belongsTo(cat_jardines::class,'ccam_cjarid');
    } ##### en controller: ejemplares::with('jardin')->get()

    public function camellones(): HasMany{
        return $this->hasMany(cat_camellones::class, 'cam_ccamid');
    } ##### en controller: ejemplares::with('camellones')->get()
}
