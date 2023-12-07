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

    function destroy(User $cliente, Request $request)
    {
        $id = $request->input('id'); // Obtener el ID enviado en la solicitud

        // Verificar si el modelo con ese ID existe
        $modelo = Vehiculo::find($id);

        if ($modelo) {
            $modelo->delete(); // Eliminar el modelo si se encuentra
        }

        return redirect()->route('cliente.show', compact('cliente'));
    }
}
