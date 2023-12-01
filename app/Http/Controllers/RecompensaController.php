<?php

namespace App\Http\Controllers;

use App\Models\Recompensa;
use App\Models\RecompensaHistorial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\AuthManager;

class RecompensaController extends Controller
{
    function index()
    {
        $recompensas = Recompensa::all();
        return view('recompensa.index', compact('recompensas'));
    }

    function create()
    {
        return view('recompensa.create');
    }

    function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'puntos' => 'required|integer',
        ]);

        $name = $request->input('name');
        $detalle = $request->input('detalle');
        $puntos = $request->input('puntos');

        Recompensa::create([
            'name' => $name,
            'detalle' => $detalle,
            'puntos' => $puntos,
        ]);

        return redirect()->route('recompensa.index');
    }

    function historial(Recompensa $recompensa)
    {
        return view('recompensa.historial', compact('recompensa'));
    }

    function historialcreate(Recompensa $recompensa)
    {
        return view('recompensa.historialcreate', compact('recompensa'));
    }

    function historialstore(Request $request, Recompensa $recompensa)
    {
        $request->validate([
            'cantidad' => 'required|integer',
        ]);

        $tipo = 'incremento';
        $cantidad = $request->input('cantidad');
        $detalle = $request->input('detalle');
        $recompensa_id = $recompensa->id;
        $user_id = auth()->user()->id;

        RecompensaHistorial::create([
            'tipo' => $tipo,
            'cantidad' => $cantidad,
            'detalle' => $detalle,
            'recompensa_id' => $recompensa_id,
            'user_id' => $user_id,
        ]);

        return redirect()->route('recompensa.index');
    }
}
