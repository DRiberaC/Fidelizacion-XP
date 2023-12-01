@extends('blank')

@section('content')
    <div class="px-2 py-2">
        <div class="max-w-7xl mx-auto">
            <div class="p-2 mb-1">
                <div class="mx-auto max-w-screen-xl p-2">
                    <div class="sm:flex sm:items-center sm:justify-between">
                        <div class="text-center sm:text-left">
                            <h1 class="text-2xl font-bold text-gray-900 sm:text-3xl">
                                Lista de Recompensas
                            </h1>
                        </div>

                        <div class="mt-4 flex flex-col gap-4 sm:mt-0 sm:flex-row sm:items-center">
                            <a href="{{ route('recompensa.create') }}">
                                <button
                                    class="block rounded-lg bg-indigo-600 px-5 py-3 text-sm font-medium text-white transition hover:bg-indigo-700 focus:outline-none focus:ring"
                                    type="button">
                                    Agregar Recompensa
                                </button>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
            <div class="relative overflow-x-auto rounded-2xl ">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                    <thead class="text-xs text-black uppercase bg-gray-100 ">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Nombre
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Puntos
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Cantidad
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Reclamados
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Saldo
                            </th>
                            <th scope="col" class="px-6 py-3">
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($recompensas as $recompensa)
                            @php
                                $adiciones = $recompensa->obtenerAdiciones();
                                $reclamos = $recompensa->obtenerReclamos();
                                $total = $adiciones - $reclamos;
                            @endphp

                            <tr class="bg-white border-b">
                                <th scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap">
                                    {{ $recompensa->name }}
                                </th>
                                <td class="px-6 py-4">
                                    {{ $recompensa->puntos }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $adiciones }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $reclamos }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $total }}
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('recompensa.historial', [$recompensa]) }}">
                                        <button
                                            class="block rounded-lg bg-indigo-600 px-5 py-3 text-sm font-medium text-white transition hover:bg-indigo-700 focus:outline-none focus:ring"
                                            type="button" value="Ver">
                                            <span class="text-sm font-medium"> Ver Detalle </span>
                                        </button>
                                    </a>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection
