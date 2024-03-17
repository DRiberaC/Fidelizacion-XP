@extends('layouts.backend')
@section('content')
    <div class="content">
        <div class="row items-push">

            <div class="col-sm-6 col-xxl-3">
                <!-- New Customers -->
                <div class="block block-rounded d-flex flex-column h-100 mb-0">
                    <div
                        class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                        <dl class="mb-0">
                            <dt class="fs-3 fw-bold">{{ count($users) }}</dt>
                            <dd class="fs-sm fw-medium fs-sm fw-medium text-muted mb-0">Clientes</dd>
                        </dl>
                        <div class="item item-rounded-lg bg-body-light">
                            <i class="far fa-user-circle fs-3 text-primary"></i>
                        </div>
                    </div>
                    <div class="bg-body-light rounded-bottom">
                        <a class="block-content block-content-full block-content-sm fs-sm fw-medium d-flex align-items-center justify-content-between"
                            href="{{ route('cliente.index') }}">
                            <span>Ver todos los Clientes</span>
                            <i class="fa fa-arrow-alt-circle-right ms-1 opacity-25 fs-base"></i>
                        </a>
                    </div>
                </div>
                <!-- END New Customers -->
            </div>

        </div>
    </div>
@endsection
