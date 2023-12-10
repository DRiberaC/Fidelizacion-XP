<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    function index()
    {
        $productos = Producto::all();
        return view('producto.index', compact('productos'));
    }

    function create()
    {
        return view('producto.create');
    }

    function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'precio' => 'required|integer',
            'factor' => 'required|integer',
        ]);

        $name = $request->input('name');
        $precio = $request->input('precio');
        $factor = $request->input('factor');

        Producto::create([
            'name' => $name,
            'precio' => $precio,
            'factor' => $factor,
        ]);

        return redirect()->route('producto.index');
    }
}
