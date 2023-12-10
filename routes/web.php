<?php

use App\Http\Controllers\CargaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\PremioController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\VehiculoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->to('/home');
    } else {
        return view('auth.login');
    }
});

Route::middleware(['auth'])->group(function () {

    Route::get('/home', function () {
        return view('home');
    });

    Route::controller(ClienteController::class)->prefix('/cliente')->name('cliente')->group(function () {
        Route::get('/', "index")->name('.index');
        Route::get('/crear-cliente', "create")->name('.create');
        Route::post('/store-cliente', "store")->name('.store');
        Route::get('/ver-cliente/{cliente}', "show")->name('.show');

        Route::post('/ver-cliente/{cliente}/sincronizar', "sincronizar")->name('.sincronizar');
    });

    Route::controller(VehiculoController::class)->prefix('/cliente/vehiculo')->name('vehiculo')->group(function () {
        Route::get('/cliente/{cliente}/crear-vehiculo', "create")->name('.create');
        Route::post('/cliente/{cliente}/store-vehiculo', "store")->name('.store');
        Route::post('/cliente/{cliente}/destroy-vehiculo', "destroy")->name('.destroy');
    });


    Route::controller(CargaController::class)->prefix('/carga')->name('carga')->group(function () {
        // Route::get('/', "index")->name('.index');
        Route::get('/fecha/{fecha}', "index")->name('.index');
        Route::get('/obtener-fecha/{fecha}', "getcargafecha")->name('.obtenerfecha');
        Route::get('/obtener-gargar-fecha', "getcarga")->name('.getcarga');
        Route::post('/obtener-gargar-fecha-url', "getcargafecharango")->name('.getcargafecha');
    });

    Route::controller(PremioController::class)->prefix('/premio')->name('premio')->group(function () {
        Route::get('/', "index")->name('.index');
        Route::get('/crear-premio', "create")->name('.create');
        Route::post('/store-premio', "store")->name('.store');

        Route::get('/historial/{premio}', "historial")->name('.historial');
        Route::get('/historial/{premio}/crear-historial', "historialcreate")->name('.historialcreate');
        Route::post('/historial/{premio}/store-historial', "historialstore")->name('.historialstore');
    });

    Route::controller(ProductoController::class)->prefix('/producto')->name('producto')->group(function () {
        Route::get('/', "index")->name('.index');
        Route::get('/crear-producto', "create")->name('.create');
        Route::post('/store-producto', "store")->name('.store');
    });
});
