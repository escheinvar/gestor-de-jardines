<?php

namespace App\Models;

use App\Models\Scopes\FiltroScope;
use App\Models\Scopes\OrdenaScope;
use App\Models\Scopes\PaginacionScope;
use App\Models\Scopes\SeleccionaScope;
use Illuminate\Database\Eloquent\Model;

class cat_camellones extends ApiModel
{


    // use HasFactory;
	protected $connection='pgsql';
	protected $table = 'cat_camellones';
	protected $primaryKey = 'cam_id';
	public $incrementing = true;
	#protected $keyType = 'string';

    protected $fillable = [
        'cam_id',
        'cam_del',
        'cam_act',
        'cam_ccamid',
        'cam_camellon',
        'cam_camellonname',
        'cam_zona',
        'cam_zonaname',
        'cam_color',
        'cam_notas',
        'cam_mapa',
        // 'cam_ctrox',
        // 'cam_ctroy',
        'cam_xmin',
        'cam_xmax',
        'cam_ymin',
        'cam_ymax',
    ];
    // protected $casts = [
    //     'cam_mapa' => 'json',
    // ];

    public function campus(){
        return $this->belongsTo(cat_campus::class, 'cam_ccamid');
    }

}
