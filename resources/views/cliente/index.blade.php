@extends('layouts.backend')
@section('content')
    <div class="content">
        <!-- Dynamic Table with Export Buttons -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Lista de clientes</h3>
                <div class="block-options">
                    <a href="{{ route('cliente.create') }}">
                        <button type="button" class="btn btn-primary">Registrar cliente</button>
                    </a>
                </div>
            </div>
            <div class="block-content block-content-full">
                <!-- DataTables init on table by adding .js-dataTable-buttons class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _js/pages/be_tables_datatables.js -->
                <table class="table table-bordered table-striped table-vcenter js-dataTable-full">

                    <thead>
                        <tr>
                            <th class="text-center" style="width: 100px;">
                                <i class="far fa-user"></i>
                                Cliente
                            </th>
                            <th style="width: 30%;">Apellido</th>
                            <th style="width: 15%;">NIT</th>
                            <th style="width: 15%;">Teléfono</th>
                            <th class="text-center" style="width: 100px;">Opción</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($clientes as $cliente)
                            <tr>
                                <td class="fw-semibold text-center">
                                    {{ $cliente->name }}
                                </td>
                                <td class="fs-sm">
                                    {{ $cliente->last_name }}
                                </td>
                                <td class="fs-sm">{{ $cliente->ci_nit }}</td>
                                <td class="fs-sm">{{ $cliente->telefono }}</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        {{-- <a href="{{ route('cliente.edit', [$cliente]) }}">
                                            <button type="button" class="btn btn-secondary">Editar</button>
                                        </a> --}}
                                        <a href="{{ route('cliente.show', $cliente) }}">
                                            <button type="button" class="btn btn-info">Ver Datos</button>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
                {{ $clientes->links() }}
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
            // (() => {
            //     jQuery(".js-dataTable-full").dataTable({
            //         pageLength: 5,
            //         lengthMenu: [
            //             [5, 10, 15, 20],
            //             [5, 10, 15, 20]
            //         ],
            //         autoWidth: !1
            //     })
            // })();
        </script>
    @endsection

    @section('css_before')
        <link rel="stylesheet" href="/js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css">
        <link rel="stylesheet" href="/js/plugins/datatables-buttons-bs5/css/buttons.bootstrap5.min.css">
        <link rel="stylesheet" href="/js/plugins/datatables-responsive-bs5/css/responsive.bootstrap5.min.css">
    @endsection
