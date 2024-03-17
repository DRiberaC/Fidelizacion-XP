@extends('blank')

@section('content')
    <div class="px-2 py-2">
        <div class="max-w-7xl mx-auto">
            <div class="p-2 mb-1">
                <div class="mx-auto max-w-screen-xl p-2">
                    <div class="sm:flex sm:items-center sm:justify-between">
                        <div class="text-center sm:text-left">
                            <h1 class="text-2xl font-bold text-gray-900 sm:text-3xl">
                                Obtener Cargas
                            </h1>
                            @if ($errors->any())
                                <div role="alert">
                                    <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
                                        Errors
                                    </div>
                                    <div
                                        class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
                                        @foreach ($errors->all() as $error)
                                            <p>{{ $error }}</p>
                                        @endforeach

                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>

            </div>
            <div class="">

                <form action="{{ route('carga.getcargafecha') }}" method="POST">
                    @csrf
                    <div class="space-y-12">
                        <div class="border-b border-gray-900/10 pb-12">
                            <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                <div class="sm:col-span-2 sm:col-start-1">
                                    <label for="fecha_inicio" class="block text-sm font-medium leading-6 text-gray-900">
                                        Fecha de Inicio
                                    </label>
                                    <div class="mt-2">
                                        <input type="date" name="fecha_inicio" value="{{ date('Y-m-d') }}"
                                            class="block w-full rounded-md border-0 p-2  text-gray-600 shadow-sm ring-1 ring-inset ring-gray-300 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-2 sm:col-start-1">
                                    <label for="fecha_fin" class="block text-sm font-medium leading-6 text-gray-900">
                                        Fecha de Fin
                                    </label>
                                    <div class="mt-2">
                                        <input type="date" name="fecha_fin" value="{{ date('Y-m-d') }}"
                                            class="block w-full rounded-md border-0 p-2  text-gray-600 shadow-sm ring-1 ring-inset ring-gray-300 sm:text-sm sm:leading-6">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 flex items-center justify-end gap-x-6">
                            <button type="button" class="text-sm font-semibold leading-6 text-gray-900">Cancel</button>
                            <button type="submit"
                                class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Get</button>
                        </div>
                </form>

            </div>

        </div>
    </div>
@endsection
