@extends('layouts.simple')

@section('content')
    <!-- Hero -->
    <div class="content">
        <div class="row justify-content-center push">
            <div class="col-md-8 col-lg-6 col-xl-4">
                <!-- Sign In Block -->
                <div class="block block-rounded mb-0">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Login</h3>
                    </div>
                    <div class="block-content">
                        <div class="p-sm-3 px-lg-4 px-xxl-5 py-lg-5">
                            <h1 class="h2 mb-1">Fidelización ROES</h1>
                            <p class="fw-medium text-muted">
                                Ingresa tus datos de usuario.
                            </p>
                            @if ($errors->any())
                                <p class="text-danger">{{ implode('', $errors->all(':message')) }}</p>
                            @endif
                            <form class="js-validation-signin" action="{{ route('login') }}" method="POST">
                                @csrf
                                <div class="py-3">
                                    <div class="mb-4">
                                        <input type="email" class="form-control form-control-alt form-control-lg"
                                            id="email" name="email" placeholder="Email">
                                    </div>
                                    <div class="mb-4">
                                        <input type="password" class="form-control form-control-alt form-control-lg"
                                            id="password" name="password" placeholder="Password">
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-md-6 col-xl-5">
                                        <button type="submit" class="btn w-100 btn-alt-primary">
                                            <i class="fa fa-fw fa-sign-in-alt me-1 opacity-50"></i> Ingresar
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <!-- END Sign In Form -->
                        </div>
                    </div>
                </div>
                <!-- END Sign In Block -->
            </div>
        </div>
        <div class="fs-sm text-muted text-center">
            <strong>Sistema de Fidelización ROES</strong> &copy; <span data-toggle="year-copy"></span>
        </div>
    </div>
    <!-- END Hero -->
@endsection
