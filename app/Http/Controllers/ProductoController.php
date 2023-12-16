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
            'precio' => 'required|numeric',
            'factor' => 'required|numeric',
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

    function edit(Producto $producto)
    {
        return view('producto.edit', compact('producto'));
    }

    function update(Request $request, Producto $producto)
    {
        $request->validate([
            'name' => 'required',
            'precio' => 'required|numeric',
            'factor' => 'required|numeric',
        ]);

        $id = $request->input('id');
        $name = $request->input('name');
        $precio = $request->input('precio');
        $factor = $request->input('factor');

        Producto::where('id', $id)->update([
            'name' => $name,
            'precio' => $precio,
            'factor' => $factor,
        ]);

        return redirect()->route('producto.index');
    }
}
