@extends('layouts.backend')
@section('content')
    <div class="content">
        <!-- User Info -->
        <div class="block block-rounded">
            <div class="block-content text-center">
                <div class="py-4">
                    <h1 class="fs-lg mb-0">
                        <span>{{ $cliente->name }}&nbsp;{{ $cliente->last_name }}</span>
                    </h1>
                    {{-- <p class="fs-sm fw-medium text-muted">UI Designer</p> --}}
                </div>
            </div>

            @php
                $gnv = $cliente->getGNV();
                $gas = $cliente->getGAS();
                $dis = $cliente->getDIS();
                $ggd = $gnv + $gas + $dis;

                $reclamados = $cliente->puntosReclamados();

                $puntosrestantes = $ggd - $reclamados;
            @endphp

            <div class="block-content bg-body-light text-center">
                <div class="row items-push text-uppercase">
                    <div class="col-6 col-md-4">
                        <div class="fw-semibold text-dark mb-1">Puntos Obtenidos</div>
                        <a class="link-fx fs-3 text-primary" href="javascript:void(0)">{{ $ggd }}</a>
                    </div>
                    <div class="col-6 col-md-4">
                        <div class="fw-semibold text-dark mb-1">Puntos Reclamados</div>
                        <a class="link-fx fs-3 text-primary" href="javascript:void(0)">{{ $reclamados }}</a>
                    </div>
                    <div class="col-6 col-md-4">
                        <div class="fw-semibold text-dark mb-1">Puntos Restantes</div>
                        <a class="link-fx fs-3 text-primary" href="javascript:void(0)">{{ $puntosrestantes }}</a>
                    </div>
                    {{-- <div class="col-6 col-md-3">
                        <div class="fw-semibold text-dark mb-1">Referred</div>
                        <a class="link-fx fs-3 text-primary" href="javascript:void(0)">3</a>
                    </div> --}}
                </div>
            </div>
        </div>
        <!-- END User Info -->

        <!-- Preview Color Themes -->
        {{-- <h2 class="content-heading">Preview Color Theme</h2> --}}
        <div class="block block-rounded">
            <div class="block-content block-content-full">
                <!-- Toggle Themes functionality initialized in Template._uiHandleTheme() -->
                <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                <div class="row text-center">
                    <div class="col-6 col-xl-2 py-4">
                        <form action="{{ route('cliente.sincronizar', [$cliente->id]) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="item item-link-pop item-circle bg-sidebar-dark text-white mx-auto mb-3">
                                <i class="fa fa-gas-pump"></i>
                            </button>
                            <div class="fw-semibold">Sincronizar cargas</div>
                        </form>
                    </div>
                    <div class="col-6 col-xl-2 offset-xl-1 py-4">
                        <a class="item item-link-pop item-circle bg-amethyst text-white mx-auto mb-3"
                            href="{{ route('cliente.cargasCliente', [$cliente]) }}">
                            <i class="fa fa-gas-pump"></i>
                        </a>
                        <div class="fw-semibold">Ver cargas realizadas</div>
                    </div>
                    <div class="col-6 col-xl-2 py-4">
                        <a class="item item-link-pop item-circle bg-flat text-white mx-auto mb-3"
                            href="{{ route('cliente.listapremios', [$cliente]) }}">
                            <i class="fa fa-gift"></i>
                        </a>
                        <div class="fw-semibold">Premios recibidos</div>
                    </div>
                    <div class="col-6 col-xl-2 offset-xl-2 py-4">
                        <a class="item item-link-pop item-circle bg-modern text-white mx-auto mb-3"
                            href="{{ route('cliente.darPremio', [$cliente]) }}">
                            <i class="fa fa-boxes-packing"></i>
                        </a>
                        <div class="fw-semibold">Dar premio</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Preview Color Themes -->

        <!-- Addresses -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Cliente</h3>
                <div class="block-options">
                    <a href="{{ route('cliente.edit', [$cliente]) }}">
                        <button type="button" class="btn btn-primary">Editar cliente</button>
                    </a>
                </div>
            </div>
            <div class="block-content">
                <div class="row">
                    <div class="col-lg-6">
                        <!-- Billing Address -->
                        <div class="block block-rounded block-bordered">
                            <div class="block-header border-bottom">
                                <h3 class="block-title">Datos personales</h3>
                            </div>
                            <div class="block-content">
                                <div class="fs-4 mb-1">{{ $cliente->name }}&nbsp;{{ $cliente->last_name }}</div>
                                <address class="fs-sm">
                                    <strong>Teléfono:</strong> {{ $cliente->telefono }}<br>
                                    <strong>CI/NIT:</strong> {{ $cliente->ci_nit }}<br>
                                    <strong>Fecha de inicio:</strong> {{ $cliente->subscription_start }}<br><br>
                                </address>
                            </div>
                        </div>
                        <!-- END Billing Address -->
                    </div>
                    <div class="col-lg-6">
                        <!-- Billing Address -->
                        <div class="block block-rounded block-bordered">
                            <div class="block-header border-bottom">
                                <h3 class="block-title">Vehiculos asociados al cliente</h3>
                                <div class="block-options">
                                    <a href="{{ route('vehiculo.create', [$cliente]) }}">
                                        <button type="button" class="btn btn-info">Agregar vehiculo</button>
                                    </a>
                                </div>
                            </div>
                            <div class="block-content">
                                @foreach ($cliente->vehiculos as $vehiculo)
                                    <p>
                                    <form action="{{ route('vehiculo.destroy', [$cliente->id]) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $vehiculo->id }}">
                                        <i class="fa fa-car"></i>
                                        Vehiculo: <a href="javascript:void(0)">{{ $vehiculo->placa }}</a>
                                        <button type="submit"
                                            onclick="return confirm('¿Estás seguro de que deseas eliminar este vehículo?')"
                                            class="btn btn-sm btn-danger me-1">
                                            <i class="fa fa-fw fa-exclamation-circle"></i> Eliminar
                                        </button>
                                    </form>
                                    </p>
                                @endforeach
                            </div>
                        </div>
                        <!-- END Billing Address -->
                    </div>
                </div>
            </div>
        </div>
        <!-- END Addresses -->



    </div>
@endsection
