<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vehiculo;
use Illuminate\Http\Request;

class VehiculoController extends Controller
{
    function create(User $cliente)
    {
        return view('vehiculo.create', compact('cliente'));
    }
    function store(User $cliente, Request $request)
    {
        $request->validate([
            'placa' => 'required',
        ]);

        Vehiculo::create([
            'placa' => $request->input('placa'),
            'user_id' => $request->input('user_id'),
        ]);

        return redirect()->route('cliente.show', compact('cliente'));
    }
}
