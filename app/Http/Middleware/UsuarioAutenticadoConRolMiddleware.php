<?php

namespace App\Http\Middleware;

use App\Models\buzon;
use App\Models\usr_roles;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class UsuarioAutenticadoConRolMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
         if(Auth::user()) {
            $roles=usr_roles::where('rol_act','1')
                ->where('rol_del','0')
                ->where('rol_usrid',Auth::id())
                ->select(DB::raw("rol_ccamsiglas as jardin,rol_crolrol as rol,rol_tipo1 as tipo1, rol_tipo2 as tipo2, CONCAT(rol_crolrol,'@',rol_ccamsiglas) as jarrol"))
                ->get();

            ######################### Revisa buzón y aportaciones
            ##### Recupera el número de mensajes sin leer
            $buzon= buzon::where('buz_act','1')
                ->where('buz_del','0')
                ->where('buz_to',Auth::user()->id)
                ->count();

            ##### Guarda variables de usuario,
            session([
                'jar'=>$roles->pluck('jardin')->toArray(),
                'rol'=>$roles->pluck('rol')->toArray(),
                'tipo1'=>$roles->pluck('tipo1')->toArray(),
                'tipo2'=>$roles->pluck('tipo2')->toArray(),
                'jarrol'=>$roles->pluck('jarrol')->toArray(),
                'buzon'=>$buzon,
            ]);

            return $next($request);
        }else{
            #### Redirecciona
            Auth::logout();
            return redirect()->route('login');
        }
    }
}
