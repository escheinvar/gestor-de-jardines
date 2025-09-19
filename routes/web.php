<?php

use App\Http\Controllers\inicioController;
use App\Http\Controllers\login\loginController;
use App\Http\Controllers\login\logoutController;
use App\Http\Middleware\rolAdminMiddleware;
use App\Http\Middleware\UsuarioAutenticadoConRolMiddleware;
use App\Livewire\Sistema\AdminUsuariosController;
use App\Livewire\Sistema\BuzonController;
use App\Livewire\Sistema\HomeConfigController;
use App\Livewire\Sistema\HomeController;
use App\Livewire\Sistema\Nuevousuario01Controller;
use App\Livewire\Sistema\NuevoUsuarioController;
use App\Livewire\Sistema\RecuperaPasswd01Controller;
use App\Livewire\Sistema\RecuperaPasswdController;
use Illuminate\Support\Facades\Route;




/* ---------------------------------------- LOGIN / LOGOUT ------------------------- */
// Route::get('/', [inicioController::class, 'index'])->name('inicio');
Route::get('/', [loginController::class, 'index'])->name('inicio');
Route::get('/ingreso', [loginController::class, 'index'])->name('login');
Route::post('/ingreso', [loginController::class, 'store']);
Route::get('/logout',[logoutController::class,'store'])->name('logout');
Route::post('/logout',[logoutController::class,'store']);
/* --------------------------------------- ACCESOS --------------------------------- */
Route::get('/recuperaAcceso',RecuperaPasswdController::class);
Route::get('/recuperaContrasenia/{token}',RecuperaPasswd01Controller::class);
Route::get('/nuevousr',NuevoUsuarioController::class)->name('nuevousr');
Route::get('/nuevousr01/{token}',Nuevousuario01Controller::class);
// Route::get('/erro{tipo}',ErrorComponent::class)->name('error');

/* ---------------------------------------- LOGEADOS CON ROL ------------------------- */
Route::middleware([UsuarioAutenticadoConRolMiddleware::class])->group(function(){
    Route::get('/home',HomeController::class)->name('home');
    Route::get('/buzon',BuzonController::class)->name('buzon');
    Route::get('/config',HomeConfigController::class)->name('config');
    Route::get('/usuarios',AdminUsuariosController::class)->name('usuarios')->middleware(rolAdminMiddleware::class);
});
