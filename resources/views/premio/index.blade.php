@extends('layouts.backend')
@section('content')
    <div class="content">
        <!-- Dynamic Table with Export Buttons -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Premios</h3>
                <div class="block-options">
                    <a href="{{ route('premio.create') }}">
                        <button type="button" class="btn btn-primary">Agregar premio</button>
                    </a>
                </div>
            </div>
            <div class="block-content block-content-full">
                <!-- DataTables init on table by adding .js-dataTable-buttons class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _js/pages/be_tables_datatables.js -->
                <table class="table table-bordered table-striped table-vcenter js-dataTable-full">

                    <thead>
                        <tr>
                            <th class="text-center" style="width: 20px;">
                                Nombre
                            </th>
                            <th style="width: 15%;">Puntos</th>
                            <th style="width: 15%;">Cantidad</th>
                            <th style="width: 15%;">Reclamados</th>
                            <th style="width: 15%;">Saldo</th>
                            <th style="width: 15%;">Opción</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($premios as $premio)
                            @php
                                $adiciones = $premio->obtenerAdiciones();
                                // dd($adiciones);
                                $reclamos = $premio->obtenerReclamos();
                                $total = $adiciones - $reclamos;
                            @endphp
                            <tr class="bg-white border-b">
                                <th scope="row" class="fs-sm">
                                    {{ $premio->name }}
                                </th>
                                <th scope="row" class="fs-sm">
                                    {{ $premio->puntos }}
                                </th>
                                <td class="fs-sm">
                                    {{ $adiciones }}
                                </td>
                                <td class="fs-sm">
                                    {{ $reclamos }}
                                </td>
                                <td class="fs-sm">
                                    {{ $total }}
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="{{ route('premio.edit', [$premio]) }}">
                                            <button type="button" class="btn btn-secondary">Editar</button>
                                        </a>
                                        <a href="{{ route('premio.historial', [$premio]) }}">
                                            <button type="button" class="btn btn-info">Ver Datos</button>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>

            </div>
        </div>
        <!-- END Dynamic Table with Export Buttons -->
    @endsection

    @section('js_after')
        <!-- jQuery -->
        <script src="/js/lib/jquery.min.js"></script>

        <!-- Page JS Plugins -->
        <script src="/js/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="/js/plugins/datatables-bs5/js/dataTables.bootstrap5.min.js"></script>
        <script src="/js/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
        <script src="/js/plugins/datatables-responsive-bs5/js/responsive.bootstrap5.min.js"></script>
        <script src="/js/plugins/datatables-buttons/dataTables.buttons.min.js"></script>
        <script src="/js/plugins/datatables-buttons-bs5/js/buttons.bootstrap5.min.js"></script>
        <script src="/js/plugins/datatables-buttons-jszip/jszip.min.js"></script>
        <script src="/js/plugins/datatables-buttons-pdfmake/pdfmake.min.js"></script>
        <script src="/js/plugins/datatables-buttons-pdfmake/vfs_fonts.js"></script>
        <script src="/js/plugins/datatables-buttons/buttons.print.min.js"></script>
        <script src="/js/plugins/datatables-buttons/buttons.html5.min.js"></script>

        <script>
            (() => {
                jQuery(".js-dataTable-full").dataTable({
                    pageLength: 10,
                    lengthMenu: [
                        [5, 10, 15, 20],
                        [5, 10, 15, 20]
                    ],
                    autoWidth: !1
                })
            })();
        </script>
    @endsection

    @section('css_before')
        <link rel="stylesheet" href="/js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css">
        <link rel="stylesheet" href="/js/plugins/datatables-buttons-bs5/css/buttons.bootstrap5.min.css">
        <link rel="stylesheet" href="/js/plugins/datatables-responsive-bs5/css/responsive.bootstrap5.min.css">
    @endsection
