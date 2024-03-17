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
                <h3 class="block-title">Formulario de premio</h3>
            </div>
            <div class="block-content block-content-full">
                <form action="{{ route('premio.update', [$premio->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $premio->id }}">
                    <div class="row push">
                        <div class="col-lg-4">
                            <p class="fs-sm text-muted">
                                Información de premio
                            </p>
                        </div>
                        <div class="col-lg-8 col-xl-5">
                            <div class="mb-4">
                                <label class="form-label" for="name">Nombre</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ $premio->name }}" placeholder="Nombre">
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="detalle">Detalle</label>
                                <textarea class="form-control" id="detalle" name="detalle" rows="4" placeholder="Detalle...">{{ $premio->detalle }}</textarea>
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="puntos">Puntos</label>
                                <input type="text" class="form-control" id="puntos" name="puntos"
                                    value="{{ $premio->puntos }}" placeholder="Puntos">
                            </div>
                        </div>
                    </div>

                    <div class="row items-push">
                        <div class="col-lg-7 offset-lg-4">
                            <button type="submit" class="btn btn-alt-primary">Editar</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
