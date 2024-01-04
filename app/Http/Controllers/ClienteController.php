<?php

namespace App\Http\Controllers;

use App\Models\CabeceraPremioHistorial;
use App\Models\Carga;
use App\Models\Premio;
use App\Models\PremioHistorial;
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
        $telefono = $request->input('telefono');
        $ci_nit = $request->input('ci_nit');
        $email = "$ci_nit@roes.com";
        $password = bcrypt('password');

        $cliente = User::create([
            'name' => $name,
            'last_name' => $last_name,
            'ci_nit' => $ci_nit,
            'telefono' => $telefono,
            'subscription_start' => $request->input('subscription_start'),
            'email' => $email,
            'password' => $password,
        ]);

        return redirect()->route('cliente.show', compact('cliente'));
        // return redirect()->route('cliente.index');
    }

    function show(User $cliente)
    {
        return view('cliente.show', compact('cliente'));
    }

    function edit(User $cliente)
    {
        return view('cliente.edit', compact('cliente'));
    }

    function update(Request $request, User $cliente)
    {
        $name = $request->input('name');
        $last_name = $request->input('last_name');
        $ci_nit = $request->input('ci_nit');
        $telefono = $request->input('telefono');

        $cliente->name = $name;
        $cliente->last_name = $last_name;
        $cliente->ci_nit = $ci_nit;
        $cliente->telefono = $telefono;
        $cliente->save();

        return redirect()->route('cliente.show', compact('cliente'));
    }

    function darPremio(User $cliente)
    {
        $premios = Premio::all();
        return view('cliente.premiar', compact('cliente', 'premios'));
    }

    function setPremio(Request $request, User $cliente)
    {

        $gnv = $cliente->getGNV();
        $gas = $cliente->getGAS();
        $dis = $cliente->getDIS();
        $ggd = $gnv + $gas + $dis;
        $reclamados = $cliente->puntosReclamados();

        $puntosD = $ggd - $reclamados;
        $premios = $request->input('premio');

        $puntosN = 0;

        foreach ($premios as $premio) {
            $cantidad = $premio['cantidad'];
            $premio_id = $premio['premio_id'];
            $pp = Premio::find($premio_id);
            $puntosN += $cantidad * $pp->puntos;
            $ad = $pp->obtenerAdiciones();
            $re = $pp->obtenerReclamos();
            $saldo = $ad - $re;

            if ($cantidad > $saldo) {
                return back()->with('error', "Existencias de $pp->name insuficientes.");
            }
        }

        if ($puntosD >= $puntosN) {
            foreach ($premios as $premio) {
                $tipo = 'decremento';
                $cantidad = $premio['cantidad'];
                $detalle = $request->input('detalle');
                $premio_id = $premio['premio_id'];
                $user_id = $cliente->id;
                $pp = Premio::find($premio_id);

                $cabecera = CabeceraPremioHistorial::create([
                    'detalle' => $detalle,
                    'user_id' => $user_id,
                ]);

                PremioHistorial::create([
                    'tipo' => $tipo,
                    'cantidad' => $cantidad,
                    'puntos' => $pp->puntos,
                    'detalle' => $detalle,
                    'premio_id' => $premio_id,
                    'user_id' => $user_id,
                    'cabecera_id' => $cabecera->id
                ]);
            }
        } else {
            return back()->with('error', 'Puntos insuficientes.');
        }

        return redirect()->route('cliente.show', compact('cliente'));
    }

    function listapremios(User $cliente)
    {
        $premios = CabeceraPremioHistorial::where('user_id', $cliente->id)->orderBy('created_at', 'desc')->get();
        return view('cliente.listapremios', compact('premios', 'cliente'));
    }

    function ticket(User $cliente, CabeceraPremioHistorial $premio)
    {
        return view('cliente.ticket', compact('premio', 'cliente'));
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
