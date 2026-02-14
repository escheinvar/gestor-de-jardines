<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ejemplares extends Model
{
     // use HasFactory;
	protected $connection='pgsql';
	protected $table = 'ejemplares';
	protected $primaryKey = 'ejm_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'ejm_id',
        'ejm_act',
        'ejm_del',

        'ejm_edo_ubica',
        'ejm_edo_scname',
        'ejm_edo_name',
        'ejm_edo_uso',

        'ejm_ccamsiglas',
        'ejm_bitid',
        'ejm_madreid',
        'ejm_padreid',
        'ejm_loteid',

        'ejm_ripdate',
        'ejm_ripcausa',
        'ejm_notasingreso',
    ];

    ################ Agrega los alias del ejemplar
    public function alias(): HasMany{
        return $this->hasMany(ej_alias::class,'alias_ejmid')
            ->where('alias_act','1')
            ->where('alias_del','0');
    } ##### en controller: ejemplares::with('alias')->get()


    ################ Agrega la(s) imagen(es) de portada del ejemplar
    public function imagenes(): HasMany{
        return $this->hasMany(imagenes::class,'img_ejmid')
            ->where('img_act','1')
            ->where('img_del','0');
    }
    ################ Agrega el nombre científico
    public function nombreCientifico(): HasOne{
        return $this->hasOne(ej_nombres_cientificos::class,'scn_ejmid')
            ->where('scn_act','1')
            ->where('scn_del','0')
            ->orderBy('scn_fecha_determina');
    }
    ################ Agrega el nombre comun
    public function nombresComunes(): HasMany{
        return $this->hasMany(ej_nombres_comunes::class,'con_ejmid')
            ->where('con_act','1')
            ->where('con_del','0');
    }

    ################ Agrega la ubicación del ejemplar
    public function ubicacion(): HasOne{
        return $this->hasOne(ej_ubicaciones::class,'sig_ejmid')
            ->where('sig_act','1')
            ->where('sig_del','0');
    }

    ################ Agrega la ubicación del ejemplar
    public function colecciones(): HasMany{
        return $this->hasMany(ej_subcolecciones::class,'col_ejmid')
            ->where('col_act','1')
            ->where('col_del','0');
    }



}
