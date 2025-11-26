<?php

use App\Http\Controllers\Api\camellones;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

######################################### Autenticación API
Route::post('/auth/login',[AuthController::class,'login']);
Route::post('/auth/logout',[AuthController::class,'logout']);
// Route::post('/auth/refresh',[AuthController::class,'refresh']);
Route::post('/auth/yo',[AuthController::class,'me']);

Route::get('/camellones',[camellones::class, 'index']);

Route::get('/prueba', function(){
    return auth('api')->user();
    // return "Hola Mundo";
});

