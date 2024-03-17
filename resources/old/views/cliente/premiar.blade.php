@extends('blank')

@section('content')
    <div class="px-2 py-2">
        <div class="max-w-7xl mx-auto">
            <div class="p-2 mb-1">
                <div class="mx-auto max-w-screen-xl p-2">
                    <div class="sm:flex sm:items-center sm:justify-between">
                        <div class="text-center sm:text-left">
                            <h1 class="text-2xl font-bold text-gray-900 sm:text-3xl">
                                Premiar Cliente <a href="{{ route('cliente.show', $cliente) }}"> {{ $cliente->name }}
                                    {{ $cliente->last_name }}</a>
                            </h1>
                        </div>

                        @if (session('error'))
                            <div role="alert">
                                <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
                                    Errors
                                </div>
                                <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
                                    <p> {{ session('error') }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
            <div class="p-8 mb-5">

                <form action="{{ route('cliente.setPremio', [$cliente->id]) }}" method="POST">
                    @csrf
                    <div class="space-y-12">
                        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

                            <div class="sm:col-span-2 sm:col-start-1">
                                <label for="premio" class="block text-sm font-medium leading-6 text-gray-900">
                                    Premios
                                </label>
                                <div class="mt-2">
                                    <input type="text" name="premio" list="lista" id="premio"
                                        class="block w-full rounded-md border-0 p-2  text-gray-600 shadow-sm ring-1 ring-inset ring-gray-300 sm:text-sm sm:leading-6">
                                </div>

                                <datalist id="lista">
                                    @foreach ($premios as $premio)
                                        <option value="{{ $premio->name }}">Puntos: {{ $premio->puntos }}</option>
                                    @endforeach
                                </datalist>

                                <div class="flex justify-end mt-2">
                                    <button type="button" onclick="AddProducto()"
                                        class="rounded-md bg-indigo-600 hover:bg-indigo-500 text-sm font-semibold text-white shadow-sm px-3 py-2">Agregar</button>
                                </div>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="detalle"
                                    class="block text-sm font-medium leading-6 text-gray-900">Detalle</label>
                                <div class="mt-2">
                                    <textarea name="detalle"
                                        class="block w-full rounded-md border-0 p-2  text-gray-600 shadow-sm ring-1 ring-inset ring-gray-300 sm:text-sm sm:leading-6"
                                        rows="4"></textarea>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="mt-4">

                        <div class="relative overflow-x-auto rounded-2xl ">
                            <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                                <thead class="text-xs text-black uppercase bg-gray-100 ">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            Premio
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Puntos
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Cantidad
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Total Puntos
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Opción
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="lista-premios">
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="mt-6 flex items-center justify-end gap-x-6">
                        <button type="button" class="text-sm font-semibold leading-6 text-gray-900">Cancel</button>
                        <button type="submit"
                            class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
                    </div>
                </form>

            </div>

        </div>
    </div>
    {{-- <input type="number"> --}}
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/axios@1.6.2/dist/axios.min.js"></script>
    <script>
        let url = '{{ route('premio.getPremio') }}';
        let productoIndex = 0;
        let AddProducto = () => {
            let nn = document.getElementById("premio").value;
            // let bodd = document.getElementById("lista-premios").innerHTML;
            axios.post(url, {
                    crf: '{{ csrf_token() }}',
                    name: nn,
                })
                .then(function(response) {
                    console.log(response.data);
                    let premio = response.data;
                    // Crear el elemento tr
                    var nuevoElemento = document.createElement('tr');
                    nuevoElemento.classList.add('bg-white', 'border-b');

                    // Construir el contenido del tr
                    var contenido =
                        '<input type="hidden" name="premio[' + productoIndex + '][premio_id]" value="' + premio.id +
                        '">' +
                        '<th scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap">' + premio
                        .name + '</th>' +
                        '<td class="px-6 py-4">' +
                        '<input type="text" readonly value="' + premio.puntos +
                        '" class="inppuntos block rounded-md border-0 p-2 text-gray-600 shadow-sm ring-1 ring-inset ring-gray-300 sm:text-sm sm:leading-6">' +
                        '</td>' +
                        '<td class="px-6 py-4">' +
                        '<div class="mt-2">' +
                        '<input type="number" min="1" name="premio[' + productoIndex +
                        '][cantidad]" value="1" class="inpcantidad block rounded-md border-0 p-2 text-gray-600 shadow-sm ring-1 ring-inset ring-gray-300 sm:text-sm sm:leading-6">' +
                        '</div>' +
                        '</td>' +
                        '<td class="px-6 py-4">' +
                        '<input type="text" readonly value="0" class="inptotal block rounded-md border-0 p-2 text-gray-600 shadow-sm ring-1 ring-inset ring-gray-300 sm:text-sm sm:leading-6">' +
                        '</td>' +
                        '<td class="px-6 py-4">' +
                        '<button type="submit" class="btnEliminar bg-red-600 hover:bg-red-500 text-white text-xs/[8px] font-bold py-2 px-4 rounded">Eliminar</button>' +
                        '</td>';

                    // Establecer el contenido en el elemento tr
                    nuevoElemento.innerHTML = contenido;

                    // Agregar el nuevo elemento al final de la lista
                    document.getElementById("lista-premios").appendChild(nuevoElemento);
                    CargarEventos();
                    productoIndex++;

                    document.getElementById("premio").value = "";
                })
                .catch(function(error) {
                    console.log(error);
                });
        };

        let CargarEventos = () => {
            // Obtener todos los elementos con la clase 'btnEliminar'
            var elementos = document.querySelectorAll('.btnEliminar');

            // Iterar sobre cada elemento y agregar un listener para el evento 'click'
            elementos.forEach(function(elemento) {
                elemento.addEventListener('click', function() {
                    // Obtener el elemento tr padre del botón
                    var tr = this.closest('tr');

                    // Eliminar el tr
                    tr.parentNode.removeChild(tr);
                });
            });

            const cantidadInputs = document.querySelectorAll('.inpcantidad');
            const puntosInputs = document.querySelectorAll('.inppuntos');
            const totalInputs = document.querySelectorAll('.inptotal');

            for (let i = 0; i < cantidadInputs.length; i++) {
                cantidadInputs[i].addEventListener('change', () => calcularTotal(i));
                calcularTotal(i);
            }

            function calcularTotal(index) {
                // Obtener los valores actuales de Precio y Cantidad en la fila correspondiente
                const puntos = parseFloat(puntosInputs[index].value);
                const cantidad = parseFloat(cantidadInputs[index].value);

                // Calcular el nuevo Total
                const total = isNaN(puntos) || isNaN(cantidad) ? 0 : puntos * cantidad;

                // Actualizar el valor del campo Total en la fila correspondiente
                totalInputs[index].value = total.toFixed(2); // Ajusta el formato según tus necesidades
            }
        };
    </script>
@endsection
{{--

     --}}
