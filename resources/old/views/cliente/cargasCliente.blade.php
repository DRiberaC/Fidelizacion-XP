@extends('blank')

@section('content')
    <div class="px-2 py-2">
        <div class="max-w-7xl mx-auto">
            <div class="p-2 mb-1">
                <div class="mx-auto max-w-screen-xl p-2">
                    <div class="sm:flex sm:items-center sm:justify-between">
                        <div class="text-center sm:text-left">
                            <h1 class="text-2xl font-bold text-gray-900 sm:text-3xl">
                                Sistema de Fidelización ROES
                            </h1>
                        </div>
                    </div>
                </div>

            </div>
            <div class="p-8 mb-5">
                <div class="relative overflow-x-auto">
                    <table class="table compact stripe w-full text-sm text-left text-gray-500">
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
                            @foreach ($cargas as $carga)
                                <tr class="bg-white border-b">
                                    <th scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap">
                                        @if ($carga->user)
                                            {{ $carga->user->name }}
                                        @endif
                                    </th>
                                    <th scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap">
                                        {{ $carga->observacion }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ $carga->fecha_venta }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $carga->nro_factura }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $carga->cantidad }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $carga->precio }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $carga->total }}
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                    <div class="mt-8">
                        {{ $cargas->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
