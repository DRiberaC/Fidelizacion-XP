<?php

namespace App\Http\Controllers;

use App\Models\Premio;
use App\Models\PremioHistorial;
use Illuminate\Http\Request;

class PremioController extends Controller
{
    function index()
    {
        $pag = env('PAGINATE', 10);
        $premios = Premio::paginate($pag);
        return view('premio.index', compact('premios'));
    }

    function create()
    {
        return view('premio.create');
    }

    function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'puntos' => 'required|numeric',
        ]);

        $name = $request->input('name');
        $detalle = $request->input('detalle');
        $puntos = $request->input('puntos');

        Premio::create([
            'name' => $name,
            'detalle' => $detalle,
            'puntos' => $puntos,
        ]);

        return redirect()->route('premio.index');
    }

    function edit(Premio $premio)
    {
        return view('premio.edit', compact('premio'));
    }

    function update(Request $request, Premio $premio)
    {
        // dd($request);
        $request->validate([
            'name' => 'required',
            'puntos' => 'required|numeric',
        ]);

        $id = $request->input('id');
        $name = $request->input('name');
        $detalle = $request->input('detalle');
        $puntos = $request->input('puntos');

        Premio::where('id', $id)->update([
            'name' => $name,
            'detalle' => $detalle,
            'puntos' => $puntos,
        ]);

        return redirect()->route('premio.index');
    }

    function getPremio(Request $request)
    {
        $name = $request->input('name');
        $premio = Premio::where('name', $name)->first();
        return response()->json($premio);
    }

    function historial(Premio $premio)
    {
        $pag = env('PAGINATE', 10);
        $historials = PremioHistorial::where('premio_id', $premio->id)->paginate($pag);
        return view('premio.historial', compact('premio', 'historials'));
    }

    function historialcreate(Premio $premio)
    {
        return view('premio.historialcreate', compact('premio'));
    }

    function historialstore(Request $request, Premio $premio)
    {
        $request->validate([
            'cantidad' => 'required|integer',
        ]);

        $tipo = 'incremento';
        $cantidad = $request->input('cantidad');
        $detalle = $request->input('detalle');
        $premio_id = $premio->id;
        $user_id = auth()->user()->id;

        PremioHistorial::create([
            'tipo' => $tipo,
            'cantidad' => $cantidad,
            'puntos' => $premio->puntos,
            'detalle' => $detalle,
            'premio_id' => $premio_id,
            'user_id' => $user_id,
        ]);

        return view('premio.historial', compact('premio'));
        // return redirect()->route('premio.index');
    }
}
