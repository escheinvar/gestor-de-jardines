<?php

use App\Http\Controllers\login\loginController;
use App\Http\Controllers\login\logoutController;
use App\Http\Middleware\rolAdminCampusMiddleware;
use App\Http\Middleware\rolAdminMiddleware;
use App\Http\Middleware\UsuarioAutenticadoConRolMiddleware;
use App\Livewire\Admin\AdminImgsController;
use App\Livewire\Admin\CamellonController;
use App\Livewire\Admin\CamellonesController;
use App\Livewire\Admin\CampusYjardinesController;
use App\Livewire\Admin\CatAutoridadesController;
use App\Livewire\Admin\CatBitacorasController;
use App\Livewire\Admin\CatNombresCientificosController;
use App\Livewire\Coleccion\BibliografiaController;
use App\Livewire\Coleccion\BitcoraController;
use App\Livewire\Coleccion\EjemplaresController;
use App\Livewire\Coleccion\InicioController;
use App\Livewire\Coleccion\ModalImagenController;
use App\Livewire\Coleccion\NombresController;
use App\Livewire\Coleccion\Prueba;
use App\Livewire\Coleccion\UbicacionController;
use App\Livewire\Sistema\AdminUsuariosController;
use App\Livewire\Sistema\BuzonController;
use App\Livewire\Sistema\HomeConfigController;
use App\Livewire\Sistema\HomeController;
use App\Livewire\Sistema\Nuevousuario01Controller;
use App\Livewire\Sistema\NuevoUsuarioController;
use App\Livewire\Sistema\RecuperaPasswd01Controller;
use App\Livewire\Sistema\RecuperaPasswdController;
use App\Livewire\Web\ApiManual;
use App\Livewire\Web\ErrorController;
use App\Livewire\Web\NoauthController;
use App\Livewire\Web\SobreElSistema;
use App\Models\bibliografia;
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

/* ---------------------------------------- LOGEADOS CON algún ROL ------------------------- */
Route::middleware([UsuarioAutenticadoConRolMiddleware::class])->group(function(){
    Route::get('/home',HomeController::class)->name('home');
    Route::get('/buzon',BuzonController::class)->name('buzon');
    Route::get('/config',HomeConfigController::class)->name('config');
    Route::get('/img/{imgid}/{clase}',ModalImagenController::class)->name('img');

    /* ---------------- Logeados con Rol de Admin ------------------- */
    Route::middleware([rolAdminMiddleware::class])->group(function(){
        Route::get('/usuarios',AdminUsuariosController::class)->name('usuarios');
        Route::get('/campus',CampusYjardinesController::class)->name('campus');
    });

    /* ---------------- Logeados con Rol de Admin-Campus ------------------- */
    Route::middleware([rolAdminCampusMiddleware::class])->group(function(){
        Route::get('/camellones',CamellonesController::class)->name('camellones');
        Route::get('/camellon/{camID}',CamellonController::class)->name('camellon');
        Route::get('/imagAdmin', AdminImgsController::class)->name('imagAdmin');
        Route::get('/autsAdmin', CatAutoridadesController::class)->name('autsAdmin');
    });

    Route::get('/cat_bitacoras', CatBitacorasController::class)->name('cat_bitacoras');
    Route::get('/cat_nombres_científicos', CatNombresCientificosController::class)->name('cat_nombres_cient');

    /* ---------------------- Visualización de ejemplares y/o especies -------------- */
    Route::get('/ejemplares', EjemplaresController::class)->name('ejemplares');
    Route::get('/ejem_inicio/{id}', InicioController::class)->name('inicio');
    Route::get('/ejem_bitacora/{id}', BitcoraController::class)->name('bitacora');
    Route::get('/ejem_nombres/{id}', NombresController::class)->name('nombres');
    Route::get('/ejem_ubica/{id}', UbicacionController::class)->name('ubicaciones');

    /* ----------------------- biblioteca --------------------------------------------*/
    Route::get('/bibliografía', BibliografiaController::class)->name('bibliografía');
});



/* ---------------------------------------- WEB PÚBLICO  ------------------------- */
Route::get('/noauth/{msj}',NoauthController::class)->name('noauth');
Route::get('/error/{msj}',ErrorController::class)->name('error');
Route::get('/api_manual', ApiManual::class)->name('api_manual');
Route::get('/nosotros', SobreElSistema::class)->name('nosotros');


Route::get('/prueba', Prueba::class)->name('prueba');
