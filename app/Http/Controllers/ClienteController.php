<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

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
            'subscription_start' => 'required|date',
        ]);

        $name = $request->input('name');
        $last_name = $request->input('last_name');
        $email = Str::slug($name . '_' . $last_name) . '@roes.com';
        $password = bcrypt('password');

        $user = User::create([
            'name' => $name,
            'last_name' => $last_name,
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
}
