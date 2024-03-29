@extends('blank')

@section('content')
    <div class="px-2 py-2">
        <div class="max-w-7xl mx-auto">
            <div class="p-2 mb-1">
                <div class="mx-auto max-w-screen-xl p-2">
                    <div class="sm:flex sm:items-center sm:justify-between">
                        <div class="text-center sm:text-left">
                            <h1 class="text-2xl font-bold text-gray-900 sm:text-3xl">
                                Cliente
                            </h1>
                        </div>

                        <div class="mt-4 flex flex-col gap-4 sm:mt-0 sm:flex-row sm:items-center">
                            @if (Auth::user()->hasRole('Super Admin'))
                                <form action="{{ route('cliente.sincronizar', [$cliente->id]) }}" method="POST">
                                    @csrf
                                    <!-- Botón para enviar el formulario -->
                                    <button type="submit"
                                        onclick="return confirm('¿Estás seguro de que deseas sincronizar las cargas?')"
                                        class="block rounded-lg bg-indigo-600 px-5 py-3 text-sm font-medium text-white transition hover:bg-indigo-700 focus:outline-none focus:ring">
                                        Sincronizar Cargas
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>

            </div>

            <div class="p-8 mb-5">
                <div>
                    <div class="px-4 sm:px-0">
                        <h3 class="text-base font-semibold leading-7 text-gray-900">Información Personal</h3>
                        <a href="{{ route('cliente.edit', [$cliente]) }}">
                            <button
                                class="bg-violet-600 hover:bg-violet-500 text-white font-bold py-2 px-4 rounded text-xs">
                                Editar
                            </button>
                        </a>
                    </div>
                    <div class="mt-6 border-t border-gray-100">
                        <dl class="divide-y divide-gray-100">
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-gray-900">Nombre Completo</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                                    {{ $cliente->name }}&nbsp;{{ $cliente->last_name }}
                                </dd>
                                <dt class="text-sm font-medium leading-6 text-gray-900">CI/NIT</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                                    {{ $cliente->ci_nit }}
                                </dd>
                                <dt class="text-sm font-medium leading-6 text-gray-900">Telefono</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                                    {{ $cliente->telefono }}
                                </dd>
                            </div>
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-gray-900">Fecha de Inicio</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                                    {{ strftime('%e de %B del %Y', strtotime($cliente->subscription_start)) }}
                                </dd>
                            </div>
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-gray-900">Usuario</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                                    {{ $cliente->email }}</dd>
                            </div>

                            @php
                                $gnv = $cliente->getGNV();
                                $gas = $cliente->getGAS();
                                $dis = $cliente->getDIS();
                                $ggd = $gnv + $gas + $dis;

                                $reclamados = $cliente->puntosReclamados();

                                $puntosrestantes = $ggd - $reclamados;
                            @endphp
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-gray-900">Puntos Obtenidos</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                                    {{ $ggd }}
                                </dd>
                                <dt class="text-sm font-medium leading-6 text-gray-900">Puntos Reclamados</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ $reclamados }}
                                </dd>
                                <dt class="text-sm font-medium leading-6 text-gray-900">Puntos Restantes</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                                    {{ $puntosrestantes }}</dd>
                            </div>
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-gray-900">Premio</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                                    <div class="flex space-x-4">

                                        <a href="{{ route('cliente.darPremio', [$cliente]) }}">
                                            <button
                                                class="bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-2 px-4 rounded">
                                                Dar Premio
                                            </button>
                                        </a>

                                        <a href="{{ route('cliente.listapremios', [$cliente]) }}">
                                            <button
                                                class="rounded-lg bg-violet-600 px-5 py-3 text-sm font-medium text-white transition hover:bg-violet-700 focus:outline-none focus:ring"
                                                type="button" value="Ver">
                                                <span class="text-sm font-medium"> Ver Premios Recibidos </span>
                                            </button>
                                        </a>

                                        <a href="{{ route('cliente.cargasCliente', [$cliente]) }}">
                                            <button
                                                class="rounded-lg bg-violet-600 px-5 py-3 text-sm font-medium text-white transition hover:bg-violet-700 focus:outline-none focus:ring"
                                                type="button" value="Ver">
                                                <span class="text-sm font-medium"> Ver Cargas </span>
                                            </button>
                                        </a>
                                    </div>
                                </dd>
                            </div>
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-gray-900">Vehiculos</dt>
                                <dd class="mt-2 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                    <ul role="list" class="divide-y divide-gray-100 rounded-md border border-gray-200">
                                        <li class="flex items-center justify-between py-4 pl-4 pr-5 text-sm leading-6">
                                            <div class="flex w-0 flex-1 items-center">

                                                <div class="ml-4 flex min-w-0 flex-1 gap-2">
                                                    <span class="truncate font-medium">Lista de vehiculos asociados al
                                                        cliente</span>
                                                </div>
                                            </div>
                                            <div class="ml-4 flex-shrink-0">
                                                @if (Auth::user()->hasRole('Super Admin'))
                                                    <a href="{{ route('vehiculo.create', [$cliente]) }}">
                                                        <button
                                                            class="bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-2 px-4 rounded">
                                                            Agregar Vehiculo
                                                        </button>
                                                    </a>
                                                @endif

                                            </div>
                                        </li>

                                        @foreach ($cliente->vehiculos as $vehiculo)
                                            <li class="flex items-center justify-between py-4 pl-4 pr-5 text-sm leading-6">
                                                <div class="flex w-0 flex-1 items-center">
                                                    <div class="ml-4 flex min-w-0 flex-1 gap-2">
                                                        <span class="truncate font-medium">vehiculo con placa:</span>
                                                        <span
                                                            class="flex-shrink-0 text-gray-400">{{ $vehiculo->placa }}</span>
                                                    </div>
                                                </div>
                                                <div class="ml-4 flex-shrink-0">
                                                    {{-- <button
                                                        class="bg-red-600 hover:bg-red-500 text-white text-xs/[8px] font-bold py-2 px-4 rounded">
                                                        Eliminar
                                                    </button> --}}
                                                    @if (Auth::user()->hasRole('Super Admin'))
                                                        <form action="{{ route('vehiculo.destroy', [$cliente->id]) }}"
                                                            method="POST">
                                                            @csrf
                                                            <input type="hidden" name="id"
                                                                value="{{ $vehiculo->id }}">
                                                            <!-- Agregar más campos si es necesario -->

                                                            <!-- Botón para enviar el formulario -->
                                                            <button type="submit"
                                                                onclick="return confirm('¿Estás seguro de que deseas eliminar este vehículo?')"
                                                                class="bg-red-600 hover:bg-red-500 text-white text-xs/[8px] font-bold py-2 px-4 rounded">
                                                                Eliminar
                                                            </button>
                                                        </form>
                                                    @endif

                                                </div>
                                            </li>
                                        @endforeach

                                    </ul>
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection
