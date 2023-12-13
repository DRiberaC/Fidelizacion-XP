<?php

namespace App\Http\Controllers;

use App\Models\Carga;
use App\Models\Producto;
use App\Models\User;
use App\Models\Vehiculo;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class ClienteController extends Controller
{
    function index()
    {
        $clienteRole = Role::where('name', 'Cliente')->first();

        if ($clienteRole) {
            $clientes = $clienteRole->users()->get();
        }
        return view('cliente.index', compact('clientes'));
    }

    function create()
    {
        return view('cliente.create');
    }

    function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'ci_nit' => 'required|unique:users',
            'subscription_start' => 'required|date',
        ]);

        $name = $request->input('name');
        $last_name = $request->input('last_name');
        $ci_nit = $request->input('ci_nit');
        $email = "$ci_nit@roes.com";
        $password = bcrypt('password');

        $user = User::create([
            'name' => $name,
            'last_name' => $last_name,
            'ci_nit' => $ci_nit,
            'subscription_start' => $request->input('subscription_start'),
            'email' => $email,
            'password' => $password,
        ]);

        return redirect()->route('cliente.index');
    }

    function show(User $cliente)
    {
        return view('cliente.show', compact('cliente'));
    }

    function sincronizar(Request $request, User $cliente)
    {
        $vehiculos = $cliente->vehiculos;
        foreach ($vehiculos as $vehiculo) {

            $cargas = Carga::where('observacion', $vehiculo->placa)->where('user_id', null)->get();
            foreach ($cargas as $carga) {

                if ($carga->fecha_venta >= $cliente->subscription_start) {

                    $producto = Producto::where('precio', $carga->precio)->first();
                    // echo "$carga <br>";
                    $carga->factor = $producto->factor;
                    $carga->puntos = $carga->cantidad * $producto->factor;
                    $carga->user_id = $cliente->id;
                    $carga->save();
                    // echo "$carga";
                    // return 0;
                }
            }
        }
        return redirect()->route('cliente.show', compact('cliente'));
    }

    function buscarCliente()
    {
        return view('cliente.buscar');
    }

    function buscarClientePlaca(Request $request)
    {
        $placa = $request->input('placa');
        $vehiculo = Vehiculo::where('placa', $placa)->first();

        if ($vehiculo) {
            $cliente = $vehiculo->user->id;
            return redirect()->route('cliente.show', compact('cliente'));
        }

        return back()->with('error', 'No se encontró la placa : ' . $placa);
        // return view('cliente.buscar');
    }
}
