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



        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Formulario de registro de cliente</h3>
            </div>
            <div class="block-content block-content-full">
                <form action="{{ route('cliente.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row push">
                        <div class="col-lg-4">
                            <p class="fs-sm text-muted">
                                Datos personales
                            </p>
                        </div>
                        <div class="col-lg-8 col-xl-5">
                            <div class="mb-4">
                                <label class="form-label" for="name">Nombre</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Nombre">
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="last_name">Apellido</label>
                                <input type="text" class="form-control" id="last_name" name="last_name"
                                    placeholder="Apellido">
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="telefono">Teléfono</label>
                                <input type="text" class="form-control" id="telefono" name="telefono"
                                    placeholder="Teléfono">
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="ci_nit">CI/NIT</label>
                                <input type="text" class="form-control" id="ci_nit" name="ci_nit"
                                    placeholder="CI/NIT">
                            </div>
                        </div>
                    </div>

                    <div class="row push">
                        <div class="col-lg-4">
                            <p class="fs-sm text-muted">
                                Fecha de inicio
                                <br>
                                <small>Deste esta fecha se recibiran los puntos.</small>
                            </p>
                        </div>
                        <div class="col-lg-8 col-xl-5">
                            <div class="row mb-4">
                                <div class="col-xl-7">
                                    <label class="form-label" for="subscription_start">Fecha de inicio</label>
                                    <input type="text" class="js-flatpickr form-control" id="subscription_start"
                                        name="subscription_start" placeholder="Y-m-d">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row items-push">
                        <div class="col-lg-7 offset-lg-4">
                            <button type="submit" class="btn btn-alt-primary">Registrar</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection

@section('js_after')
    <!-- jQuery -->
    <script src="/js/lib/jquery.min.js"></script>

    <!-- Page JS Plugins -->
    <script src="/js/plugins/flatpickr/flatpickr.min.js"></script>

    <!-- Page JS Helpers (Flatpickr + BS Datepicker + BS Maxlength + Select2 + Masked Inputs + Ion Range Slider + BS Colorpicker plugins) -->
    <script>
        One.helpersOnLoad(['js-flatpickr']);
    </script>
@endsection

@section('css_before')
    <!-- Page JS Plugins CSS -->
    <link rel="stylesheet" href="/js/plugins/flatpickr/flatpickr.min.css">
@endsection
