@extends('blank')

@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css"> --}}
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css"> --}}
@endsection

@section('content')
    <div class="px-2 py-2">
        <div class="max-w-7xl mx-auto">
            <div class="p-2 mb-1">
                <div class="mx-auto max-w-screen-xl p-2">
                    <div class="sm:flex sm:items-center sm:justify-between">
                        <div class="text-center sm:text-left">
                            <h1 class="text-2xl font-bold text-gray-900 sm:text-3xl">
                                Lista de Cargas {{ $fecha_act }}
                            </h1>
                        </div>

                        <div class="mt-4 flex flex-col gap-4 sm:mt-0 sm:flex-row sm:items-center">
                            <a href="{{ route('carga.getcarga') }}">
                                <button
                                    class="block rounded-lg bg-indigo-600 px-5 py-3 text-sm font-medium text-white transition hover:bg-indigo-700 focus:outline-none focus:ring"
                                    type="button">
                                    Obtener Cargas de Fecha
                                </button>
                            </a>
                        </div>
                    </div>
                </div>

                <hr class="py-2">

                <div class="grid grid-cols-3 pb-3">
                    <div class="flex justify-center">
                        <a href="{{ route('carga.index', [$fecha_ant]) }}">
                            <button
                                class="block rounded-lg bg-indigo-600 px-5 py-3 text-sm font-medium text-white transition hover:bg-indigo-700 focus:outline-none focus:ring"
                                type="button">
                                Ver Cargas de Fecha {{ $fecha_ant }}
                            </button>
                        </a>
                    </div>
                    <div class="flex justify-center">
                        <a href="{{ route('carga.obtenerfecha', [$fecha_act]) }}">
                            <button
                                class="block rounded-lg bg-indigo-600 px-5 py-3 text-sm font-medium text-white transition hover:bg-indigo-700 focus:outline-none focus:ring"
                                type="button">
                                Obtener Cargas de Fecha {{ $fecha_act }}
                            </button>
                        </a>
                    </div>
                    <div class="flex justify-center">
                        <a href="{{ route('carga.index', [$fecha_sig]) }}">
                            <button
                                class="block rounded-lg bg-indigo-600 px-5 py-3 text-sm font-medium text-white transition hover:bg-indigo-700 focus:outline-none focus:ring"
                                type="button">
                                Ver Cargas de Fecha {{ $fecha_sig }}
                            </button>
                        </a>

                    </div>
                </div>


                <div class="relative overflow-x-auto rounded-2xl ">
                    <table id="lista"
                        class="table compact stripe w-full text-sm text-left rtl:text-right text-gray-500">
                        <thead class="text-xs text-black uppercase bg-gray-100 ">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Cliente
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Placa
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Fecha Venta
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Nro Factura
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Cantidad
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Precio
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Total
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cargas as $cargas)
                                <tr class="bg-white border-b">
                                    <th scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap">
                                        @if ($cargas->user)
                                            {{ $cargas->user->name }}
                                        @endif
                                    </th>
                                    <th scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap">
                                        {{ $cargas->observacion }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ $cargas->fecha_venta }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $cargas->nro_factura }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $cargas->cantidad }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $cargas->precio }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $cargas->total }}
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    <script>
        // let dt = new DataTable('#lista');

        $('#lista').dataTable({
            aLengthMenu: [
                [25, 50, 100, 200, -1],
                [25, 50, 100, 200, "All"]
            ],
            iDisplayLength: 25
        });
    </script>
@endsection
