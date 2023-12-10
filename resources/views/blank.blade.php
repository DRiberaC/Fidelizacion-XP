<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @yield('styles')
    @vite('resources/css/app.css')
    <title>Fidelización ROES</title>
</head>

<body class="flex h-screen bg-gray-100">

    <aside class="bg-white w-60 border-r overflow-y-auto h-screen flex flex-col">
        <div>
            <!-- Contenido del menú -->
            <div class="px-4 py-6 text-center border-b">
                <h1 class="text-xl font-bold leading-none"><span class="text-indigo-600">Fidelización</span> ROES</h1>
            </div>
            <div class="p-4">
                <ul class="space-y-1">
                    <!-- Opciones del menú -->
                    <ul class="space-y-1">
                        <li>
                            <a href="{{ route('cliente.index') }}"
                                class="block rounded-lg px-4 py-3 text-sm font-medium {{ request()->is('cliente*') ? ' text-gray-900 bg-gray-100' : ' text-gray-500 hover:bg-gray-100 hover:text-gray-700' }} ">
                                Clientes
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('carga.index', [date('Y-m')]) }}"
                                class="block rounded-lg px-4 py-3 text-sm font-medium {{ request()->is('carga*') ? ' text-gray-900 bg-gray-100' : ' text-gray-500 hover:bg-gray-100 hover:text-gray-700' }} ">
                                Cargas
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('premio.index') }}"
                                class="block rounded-lg px-4 py-3 text-sm font-medium {{ request()->is('recompensa*') ? ' text-gray-900 bg-gray-100' : ' text-gray-500 hover:bg-gray-100 hover:text-gray-700' }} ">
                                Premios
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('producto.index') }}"
                                class="block rounded-lg px-4 py-3 text-sm font-medium {{ request()->is('recompensa*') ? ' text-gray-900 bg-gray-100' : ' text-gray-500 hover:bg-gray-100 hover:text-gray-700' }} ">
                                Productos
                            </a>
                        </li>
                        {{-- 
                        <li>
                            <details class="group [&_summary::-webkit-details-marker]:hidden">
                                <summary
                                    class="flex cursor-pointer items-center justify-between rounded-lg px-4 py-2 text-gray-500 hover:bg-gray-100 hover:text-gray-700">
                                    <span class="text-sm font-medium"> Menú </span>

                                    <span class="shrink-0 transition duration-300 group-open:-rotate-180">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                </summary>

                                <ul class="mt-2 space-y-1 px-4">
                                    <li>
                                        <a href="javascript:void(0)"
                                            class="block rounded-lg px-4 py-2 text-sm font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-700">
                                            Menú 1
                                        </a>
                                    </li>

                                    <li>
                                        <a href="javascript:void(0)"
                                            class="block rounded-lg px-4 py-2 text-sm font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-700">
                                            Menú 2
                                        </a>
                                </ul>
                            </details>
                        </li> --}}

                    </ul>
                </ul>
            </div>
        </div>

        <div class="mt-auto p-4">
            <!-- Formulario de logout -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="inline-flex items-center justify-center h-9 px-4 rounded-xl bg-gray-900 text-gray-300 hover:text-white text-sm font-semibold transition">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor"
                        class="" viewBox="0 0 16 16">
                        <path
                            d="M12 1a1 1 0 0 1 1 1v13h1.5a.5.5 0 0 1 0 1h-13a.5.5 0 0 1 0-1H3V2a1 1 0 0 1 1-1h8zm-2 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" />
                    </svg>
                </button>
                <span class="font-bold text-sm ml-2">Logout</span>
            </form>
        </div>

    </aside>

    <main class="bg-white flex-1 p-4 overflow-y-auto">
        @yield('content')
    </main>
</body>

</html>
@yield('scripts')
