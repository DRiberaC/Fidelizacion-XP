@extends('blank')

@section('content')
    <div class="px-2 py-2">
        <div class="max-w-7xl mx-auto">

            <div class="p-8 mb-5">
                <div class="text-xs">
                    <p class="text-center font-bold">
                        Estación de Servicio ROES
                    </p>
                    <p class="text-center">
                        Fecha: {{ date('Y-m-d') }}
                    </p>
                    <p class="text-center">
                        Cliente: {{ $cliente->name }}
                    </p>

                    <hr class="my-2">

                    <table class="w-full">
                        <thead>
                            <tr>
                                <th class="w-1/3">Cant.</th>
                                <th class="w-1/3">Descrición</th>
                                <th class="w-1/3 text-right">Puntos</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $puntos = 0;
                            @endphp
                            @foreach ($premio->premioHistoriales as $item)
                                <tr>
                                    <td class="w-1/3 text-center">{{ $item->cantidad }}</td>
                                    <td class="w-1/3 text-center">{{ $item->recompensa->name }}</td>
                                    <td class="w-1/3 text-right">{{ $item->puntos }}</td>
                                </tr>
                                @php
                                    $puntos += $item->puntos * $item->cantidad;
                                @endphp
                            @endforeach
                            <tr>
                                <td class="w-1/3 text-right" colspan="2">Total puntos</td>
                                <td class="w-1/3 text-right">{{ $puntos }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <hr class="my-2">
                    @php
                        $gnv = $cliente->getGNV();
                        $gas = $cliente->getGAS();
                        $dis = $cliente->getDIS();
                        $ggd = $gnv + $gas + $dis;

                        $reclamados = $cliente->puntosReclamados();

                        $puntosrestantes = $ggd - $reclamados;
                    @endphp
                    <p class="text-center">
                        Puntos Acumulados: {{ $ggd }}
                    </p>
                    <p class="text-center">
                        Puntos Utilizados: {{ $reclamados }}
                    </p>
                    <p class="text-center">
                        Puntos Restantes: {{ $puntosrestantes }}
                    </p>

                    <hr class="my-2">

                    <p class="text-center">
                        Firma {{ $cliente->name }}
                    </p>
                </div>

            </div>

        </div>
    </div>
    <div class="flex justify-center mt-4 print:hidden">

        <a href="{{ route('cliente.listapremios', [$cliente]) }}">
            <button class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
                Volver
            </button>
        </a>
        {{-- <button id="btnImprimir" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Imprimir
        </button> --}}
    </div>

    <script>
        document.getElementById('btnImprimir').onclick = function() {
            window.print(); // Esta función imprime el contenido de la página actual
        };
    </script>
@endsection
