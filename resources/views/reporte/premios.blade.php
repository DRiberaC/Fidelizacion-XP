@extends('layouts.backend')
@section('content')
    <div class="content">
        <!-- Invoice -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">REPORTE DE PRODUCTOS ENTREGADOS</h3>
                <div class="block-options">
                    <!-- Print Page functionality is initialized in Helpers.onePrint() -->
                    <button type="button" class="btn-block-option" onclick="One.helpers('one-print');">
                        <i class="si si-printer me-1"></i> Imprimir
                    </button>
                </div>
            </div>
            <div class="block-content">
                <div class="p-sm-4 p-xl-7">

                    <!-- Table -->
                    <div class="table-responsive push">
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center"></th>
                                    <th>Cliente</th>
                                    <th class="text-center">Producto</th>
                                    <th class="text-end">Cantidad</th>
                                    <th class="text-end">Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($historial as $premio)
                                    <tr class="text-sm">
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>
                                            <p class="text-primary-darker mb-1">{{ $premio->user->name }}</p>
                                            {{-- <div class="text-muted">Design/Development of iOS and Android application</div> --}}
                                        </td>
                                        <td class="text-center">
                                            <p class="text-primary-darker mb-1">{{ $premio->recompensa->name }}</p>
                                        </td>
                                        <td class="text-primary-darker text-end">{{ $premio->cantidad }}</td>
                                        <td class="text-primary-darker text-end">{{ $premio->created_at->format('Y-m-d') }}
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    <!-- END Table -->

                    <!-- Footer -->
                    <p class="fs-sm text-muted text-center">
                        {{-- Thank you very much for doing business with us. We look forward to working with you again! --}}
                    </p>
                    <!-- END Footer -->
                </div>
            </div>
        </div>
        <!-- END Invoice -->
    </div>
@endsection
