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
                <h3 class="block-title">Formulario de producto</h3>
            </div>
            <div class="block-content block-content-full">
                <form action="{{ route('producto.update', [$producto->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $producto->id }}">
                    <div class="row push">
                        <div class="col-lg-4">
                            <p class="fs-sm text-muted">
                                Información de producto
                            </p>
                        </div>
                        <div class="col-lg-8 col-xl-5">
                            <div class="mb-4">
                                <label class="form-label" for="name">Nombre</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ $producto->name }}" placeholder="Nombre">
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="precio">Precio</label>
                                <input type="number" class="form-control" id="precio" name="precio"
                                    value="{{ $producto->precio }}" placeholder="Precio">
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="factor">Factor</label>
                                <input type="number" class="form-control" id="factor" name="factor"
                                    value="{{ $producto->factor }}" placeholder="Factor">
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
