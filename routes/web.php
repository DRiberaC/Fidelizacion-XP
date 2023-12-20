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

Route::controller(CargaController::class)->prefix('/cargas')->name('cargas')->group(function () {
    Route::post('/recibirCarga', "recibirCarga")->name('.recibirCarga');
    Route::post('/lastCarga', "lastCarga")->name('.lastCarga');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/home', function () {
        return view('home');
    });

    Route::controller(ClienteController::class)->prefix('/cliente')->name('cliente')->group(function () {
        Route::get('/', "index")->name('.index')->middleware('PermisoAdmin');
        Route::get('/crear-cliente', "create")->name('.create')->middleware('PermisoAdmin');
        Route::post('/store-cliente', "store")->name('.store')->middleware('PermisoAdmin');
        Route::get('/ver-cliente/{cliente}', "show")->name('.show');
        Route::post('/ver-cliente/{cliente}/sincronizar', "sincronizar")->name('.sincronizar')->middleware('PermisoAdmin');
        Route::get('/dar-premio/{cliente}', "darPremio")->name('.darPremio');

        Route::post('/set-premio/{cliente}', "setPremio")->name('.setPremio');



        Route::get('/buscar-cliente', "buscarCliente")->name('.buscarCliente');
        Route::post('/buscar-cliente/placa', "buscarClientePlaca")->name('.buscarClientePlaca');
    });

    Route::controller(VehiculoController::class)->prefix('/cliente/vehiculo')->name('vehiculo')->middleware('PermisoAdmin')->group(function () {
        Route::get('/cliente/{cliente}/crear-vehiculo', "create")->name('.create');
        Route::post('/cliente/{cliente}/store-vehiculo', "store")->name('.store');
        Route::post('/cliente/{cliente}/destroy-vehiculo', "destroy")->name('.destroy');
    });


    Route::controller(CargaController::class)->prefix('/carga')->name('carga')->group(function () {
        Route::get('/fecha/{fecha}', "index")->name('.index')->middleware('PermisoAdmin');
    });

    Route::controller(PremioController::class)->prefix('/premio')->name('premio')->middleware('PermisoAdmin')->group(function () {
        Route::get('/', "index")->name('.index');
        Route::get('/crear-premio', "create")->name('.create');
        Route::post('/store-premio', "store")->name('.store');

        Route::post('/get-premio', "getPremio")->name('.getPremio');

        Route::get('/editar-premio/{premio}', "edit")->name('.edit');
        Route::post('/update-premio/{premio}', "update")->name('.update');



        Route::get('/historial/{premio}', "historial")->name('.historial');
        Route::get('/historial/{premio}/crear-historial', "historialcreate")->name('.historialcreate');
        Route::post('/historial/{premio}/store-historial', "historialstore")->name('.historialstore');
    });

    Route::controller(ProductoController::class)->prefix('/producto')->name('producto')->middleware('PermisoAdmin')->group(function () {
        Route::get('/', "index")->name('.index');
        Route::get('/crear-producto', "create")->name('.create');
        Route::post('/store-producto', "store")->name('.store');
        Route::get('/editar-producto/{producto}', "edit")->name('.edit');
        Route::post('/update-producto/{producto}', "update")->name('.update');
    });
});
