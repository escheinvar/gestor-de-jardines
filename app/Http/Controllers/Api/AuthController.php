<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\usr_roles;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller implements HasMiddleware
{
   public static function middleware(): array {
        return [
            new Middleware('auth:api', except: ['login']),
        ];
    }

    public function mount(){
        $ja=session('rol');
    }
    ################################## login (MUESTRA $TOKEN)
    public function login() {
        $token='';
        $credentials = request(['email', 'password']);
        if (! $token = Auth::guard('api')->attempt($credentials)) {
            return response()->json(['error' => 'No autorizado'], 401);
        }
        return $this->respondWithToken($token);
    }

    ##################################### me (MUESTRA DATOS DEL USUARIO)
    public function me() {
        return response()->json(auth('api')->user());
    }

    ##################################### logout (CIERRA EL TOKEN)
    public function logout(){
        ####### Borra api de base de datos
        User::where('id',auth('api')->user()->id)->update(['api_token'=>null]);

        // auth('api')->logout();
        Auth::guard('api')->logout();

        return response()->json(['mensaje' => 'Cierre de sesión exitoso']);
    }

    ##################################### refresh  REINICIA TOKEN
    // public function refresh() {
    //     return $this->respondWithToken(auth('api')->refresh());
    // }


    protected function respondWithToken($token) {
        User::where('email',request('email'))->update(['api_token'=>$token]);
        return response()->json([
            'token' => $token,
            'tipo_de_token' => 'bearer',
            // 'expira_en' => auth('api')->factory()->getTTL() * 60,
            // 'expira_en' => Auth::guard('api')->factory()->getTTL() * 60,
        ]);
    }
}
