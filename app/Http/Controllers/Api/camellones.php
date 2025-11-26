<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\cat_camellones;
use App\Models\cat_roles;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class camellones extends Controller implements HasMiddleware
{

      public static function middleware(): array {
        return [
            new Middleware('auth:api', except: ['']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request){
        $came=cat_camellones::query();
        $came=$came->where('cam_del','0')
            ->where('cam_act','1')
            ->leftJoin('cat_campus','cam_ccamid','=','ccam_id')
            ->leftJoin('cat_jardines','ccam_cjarid','=','cjar_id')
            ->select(
                'cjar_id','cjar_name','cjar_siglas',
                'ccam_id','ccam_name','ccam_siglas','ccam_nombre',
                'cam_id', 'cam_camellon','cam_camellonname','cam_zona',
                'cam_zonaname','cam_mapa','cam_xmin','cam_xmax','cam_ymin','cam_ymax','cam_zoom'
            );


        #$came= $came->with('campus');

        if(request('paginar')){
            $came=$came->paginate(request('paginar'));
        }else{
            $came=$came->get();
        }

        ################# Respuesta
        return response()->json([
            'dato'=>$came,
        ]);
    }

    /**
     * Display the specified resource.
     */
    // public function show(string $bla){
    //     $came=cat_camellones::where('cam_camellon','ilike',$bla)->get()->toJson();
    //     return response($came);
    // }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
