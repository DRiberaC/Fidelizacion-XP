@extends('layouts.backend')
@section('content')
    <div class="content">

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="col-lg-4 alert alert-warning alert-dismissible" role="alert">
                    <p class="mb-0">
                        {{ $error }}
                    </p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endforeach
        @endif
        <form action="{{ route('cliente.setPremio', [$cliente->id]) }}" method="POST"enctype="multipart/form-data">
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Formulario de registro de clientess</h3>
                </div>
                <div class="block-content block-content-full">

                    @csrf
                    <div class="row push">
                        <div class="col-lg-4">
                            <div class="mb-4">
                                <label class="form-label" for="name">Premios</label>
                                <select class="js-select2 form-select" id="premio" name="premio" style="width: 100%;"
                                    data-placeholder="Selecciona uno...">
                                    <option></option>
                                    <!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                    @foreach ($premios as $premio)
                                        <option value="{{ $premio->name }}">{{ $premio->name }} - Puntos:
                                            {{ $premio->puntos }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="row items-push">
                                <div class="">
                                    <button type="button" class="btn btn-alt-info" onclick="AddProducto()">Agregar</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-xl-5">
                            <div class="mb-4">
                                <label class="form-label" for="detalle">Detalle</label>
                                <textarea class="form-control" id="detalle" name="detalle" rows="4" placeholder="Detalle..."></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row items-push">
                        <div class="col-lg-7 offset-lg-4">
                            <button type="submit" class="btn btn-alt-primary">Guardar</button>
                        </div>
                    </div>

                </div>
            </div>

            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Lista de premios</h3>
                </div>
                <div class="block-content">
                    <table class="table table-striped table-vcenter">
                        <thead>
                            <tr>
                                <th>Premio</th>
                                <th class="text-center">Puntos</th>
                                <th class="text-center">Cantidad</th>
                                <th class="text-center">Total Puntos</th>
                                <th class="text-center">Opción</th>
                            </tr>
                        </thead>
                        <tbody id="lista-premios">
                            {{-- <tr>
                            <td class="fw-semibold fs-sm">Scott Young</td>
                            <td class="fw-semibold fs-sm">Scott Young</td>
                            <td class="fw-semibold fs-sm">Scott Young</td>
                            <td class="fw-semibold fs-sm">Scott Young</td>
                            <td class="fw-semibold fs-sm">Scott Young</td>
                        </tr> --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </form>

    </div>
@endsection

@section('js_after')
    <!-- jQuery -->
    <script src="/js/lib/jquery.min.js"></script>

    <!-- Page JS Plugins -->
    {{-- <script src="/js/plugins/flatpickr/flatpickr.min.js"></script> --}}
    <script src="/js/plugins/select2/js/select2.full.min.js"></script>

    <!-- Page JS Helpers (Flatpickr + BS Datepicker + BS Maxlength + Select2 + Masked Inputs + Ion Range Slider + BS Colorpicker plugins) -->
    <script>
        One.helpersOnLoad(['jq-select2']);
    </script>
    {{-- @endsection @section('scripts') --}}
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
                    // console.log(premio);
                    // Crear el elemento tr
                    var nuevoElemento = document.createElement('tr');
                    nuevoElemento.classList.add('bg-white', 'border-b');

                    // Construir el contenido del tr
                    var contenido =
                        '<input type="hidden" name="premio[' + productoIndex + '][premio_id]" value="' + premio.id +
                        '">' +
                        '<th scope="row" class="fw-semibold fs-sm">' + premio.name + '</th>' +
                        '<td class="px-6 py-4">' +
                        '<input type="text" readonly value="' + premio.puntos +
                        '" class="inppuntos form-control form-control-sm">' +
                        '</td>' +
                        '<td class="px-6 py-4">' +
                        '<div class="mt-2">' +
                        '<input type="number" min="1" name="premio[' + productoIndex +
                        '][cantidad]" value="1" class="inpcantidad form-control form-control-sm">' +
                        '</div>' +
                        '</td>' +
                        '<td class="px-6 py-4">' +
                        '<input type="text" readonly value="0" class="inptotal form-control form-control-sm">' +
                        '</td>' +
                        '<td class="px-6 py-4">' +
                        '<div class="btn-group">' +
                        '<button type="button" class="btnEliminar btn btn-sm btn-alt-secondary js-bs-tooltip-enabled" data-bs-toggle="tooltip" title="" data-bs-original-title="Remove Client">' +
                        '<i class="fa fa-fw fa-times"></i>' +
                        '</button>' +
                        '</div>' +
                        '</td>';

                    // Establecer el contenido en el elemento tr
                    nuevoElemento.innerHTML = contenido;

                    // Agregar el nuevo elemento al final de la lista
                    document.getElementById("lista-premios").appendChild(nuevoElemento);
                    CargarEventos();
                    productoIndex++;
                    console.log(productoIndex);

                    // document.getElementById("premio").value = "";
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

@section('css_before')
    <!-- Page JS Plugins CSS -->
    {{-- <link rel="stylesheet" href="/js/plugins/flatpickr/flatpickr.min.css"> --}}
    <link rel="stylesheet" href="/js/plugins/select2/css/select2.min.css">
@endsection
