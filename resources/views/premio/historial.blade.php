@extends('blank')

@section('content')
    <div class="px-2 py-2">
        <div class="max-w-7xl mx-auto">
            <div class="p-2 mb-1">
                <div class="mx-auto max-w-screen-xl p-2">
                    <div class="sm:flex sm:items-center sm:justify-between">
                        <div class="text-center sm:text-left">
                            <h1 class="text-2xl font-bold text-gray-900 sm:text-3xl">
                                Historial de Premio {{ $premio->name }}
                            </h1>
                        </div>

                        <div class="mt-4 flex flex-col gap-4 sm:mt-0 sm:flex-row sm:items-center">
                            <a href="{{ route('premio.historialcreate', [$premio]) }}">
                                <button
                                    class="block rounded-lg bg-indigo-600 px-5 py-3 text-sm font-medium text-white transition hover:bg-indigo-700 focus:outline-none focus:ring"
                                    type="button">
                                    Adicionar Existencia
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
                                Cliente
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Tipo
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Cantidad
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Fecha
                            </th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($premio->historial as $historial)
                            <tr class="bg-white border-b">
                                <th scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap">
                                    {{ $historial->user->name }}
                                </th>
                                <td class="px-6 py-4">
                                    {{ $historial->tipo }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $historial->cantidad }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $historial->created_at }} : {{ $historial->created_at->diffForHumans() }}
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection
