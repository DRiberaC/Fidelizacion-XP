<?php

namespace App\Http\Controllers;

use App\Models\Carga;
use Illuminate\Http\Request;

class CargaController extends Controller
{
    function index()
    {
        $cargas = Carga::all();
        return view('carga.index', compact('cargas'));
    }
}
