<?php

namespace App\Http\Controllers;

use App\Models\PremioHistorial;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Contracts\Role;

class ReporteController extends Controller
{
    function cliente()
    {
        // $clienteRole = Role::where('name', 'Cliente')->first();

        // if ($clienteRole) {
        //     // $pag = env('PAGINATE', 10);
        //     $clientes = $clienteRole->users()->get();
        // }
        // dd($clientes);
        $clientes = User::role('cliente')->get();
        // dd($clientes);
        return view('reporte.cliente', compact('clientes'));
    }

    function premios()
    {
        $historial = PremioHistorial::where('tipo', 'decremento')->get();
        // dd($historial);
        return view('reporte.premios', compact('historial'));
    }
}
