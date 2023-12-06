<?php

use App\Http\Controllers\CargaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\RecompensaController;
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

Route::get('/home', function () {
    return view('home');
});

Route::controller(ClienteController::class)->prefix('/cliente')->name('cliente')->group(function () {
    Route::get('/', "index")->name('.index');
    Route::get('/crear-cliente', "create")->name('.create');
    Route::post('/store-cliente', "store")->name('.store');
    Route::get('/ver-cliente/{cliente}', "show")->name('.show');
});

Route::controller(VehiculoController::class)->prefix('/cliente/vehiculo')->name('vehiculo')->group(function () {
    Route::get('/cliente/{cliente}/crear-vehiculo', "create")->name('.create');
    Route::post('/cliente/{cliente}/store-vehiculo', "store")->name('.store');
});


Route::controller(CargaController::class)->prefix('/carga')->name('carga')->group(function () {
    // Route::get('/', "index")->name('.index');
    Route::get('/fecha/{fecha}', "index")->name('.index');
    Route::get('/obtener-fecha/{fecha}', "getcargafecha")->name('.obtenerfecha');
    Route::get('/obtener-gargar-fecha', "getcarga")->name('.getcarga');
    Route::post('/obtener-gargar-fecha-url', "getcargafecharango")->name('.getcargafecha');
});

Route::controller(RecompensaController::class)->prefix('/recompensa')->name('recompensa')->group(function () {
    Route::get('/', "index")->name('.index');
    Route::get('/crear-recompensa', "create")->name('.create');
    Route::post('/store-recompensa', "store")->name('.store');

    Route::get('/historial/{recompensa}', "historial")->name('.historial');
    Route::get('/historial/{recompensa}/crear-historial', "historialcreate")->name('.historialcreate');
    Route::post('/historial/{recompensa}/store-historial', "historialstore")->name('.historialstore');
});
