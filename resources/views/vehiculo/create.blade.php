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
                <h3 class="block-title">Formulario de registro de vehiculo</h3>
            </div>
            <div class="block-content block-content-full">
                <form action="{{ route('vehiculo.store', [$cliente->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $cliente->id }}">
                    <div class="row push">
                        <div class="col-lg-4">
                            <p class="fs-sm text-muted">
                                Datos de vehiculo
                            </p>
                        </div>
                        <div class="col-lg-8 col-xl-5">
                            <div class="mb-4">
                                <label class="form-label" for="name">Placa</label>
                                <input type="text" class="form-control" id="placa" name="placa"
                                    placeholder="Placa">
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
