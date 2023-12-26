@extends('blank')

@section('content')
    <div class="px-2 py-2">
        <div class="max-w-7xl mx-auto">
            <div class="p-2 mb-1">
                <div class="mx-auto max-w-screen-xl p-2">
                    <div class="sm:flex sm:items-center sm:justify-between">
                        <div class="text-center sm:text-left">
                            <h1 class="text-2xl font-bold text-gray-900 sm:text-3xl">
                                Lista de Premios Recibidos
                            </h1>
                        </div>

                        {{-- <div class="mt-4 flex flex-col gap-4 sm:mt-0 sm:flex-row sm:items-center">
                            <a href="#">
                                <button
                                    class="block rounded-lg bg-indigo-600 px-5 py-3 text-sm font-medium text-white transition hover:bg-indigo-700 focus:outline-none focus:ring"
                                    type="button">
                                    Button
                                </button>
                            </a>
                        </div> --}}
                    </div>
                </div>

            </div>
            <div class="p-8 mb-5">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                    <thead class="text-xs text-black uppercase bg-gray-100 ">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Numero
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Fecha
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Detalle
                            </th>

                            <th scope="col" class="px-6 py-3">
                                Opción
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($premios as $premio)
                            <tr class="bg-white border-b">
                                <th scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap">
                                    {{ $loop->iteration }}
                                </th>
                                <td class="px-6 py-4">
                                    {{ $premio->created_at }} : {{ $premio->created_at->diffForHumans() }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $premio->detalle }}
                                </td>
                                {{-- <td class="px-6 py-4">
                                    <a href="{{ route('cliente.show', $cliente) }}">
                                        <button
                                            class="block rounded-lg bg-indigo-600 px-5 py-3 text-sm font-medium text-white transition hover:bg-indigo-700 focus:outline-none focus:ring"
                                            type="button" value="Ver">
                                            <span class="text-sm font-medium"> Ver Datos </span>
                                        </button>
                                    </a>
                                </td> --}}
                                <td class="px-6 py-4">
                                    <div class="flex space-x-4">
                                        <a href="{{ route('cliente.ticket', [$cliente->id, $premio->id]) }}">
                                            <button
                                                class="rounded-lg bg-violet-600 px-5 py-3 text-sm font-medium text-white transition hover:bg-violet-700 focus:outline-none focus:ring"
                                                type="button" value="Ver">
                                                <span class="text-sm font-medium"> Imprimir </span>
                                            </button>
                                        </a>

                                        {{-- <a href="#">
                                            <button
                                                class="block rounded-lg bg-indigo-600 px-5 py-3 text-sm font-medium text-white transition hover:bg-indigo-700 focus:outline-none focus:ring"
                                                type="button" value="Ver">
                                                <span class="text-sm font-medium"> PDF </span>
                                            </button>
                                        </a> --}}
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection
