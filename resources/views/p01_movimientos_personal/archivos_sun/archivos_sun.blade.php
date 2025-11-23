@extends('layouts.main')

@section('title', 'Archivos para el SUN')

@section('subheader')
    @include('layouts.partials.main.subheader', ["subheader" => [
        "titulo_subheader" => "Archivos para el SUN",
        "icono_titulo_subheader" => "far fa-folder-open",
        "breadcrumbs" => [
            1 => [
                "activo" => false,
                "titulo" => 'Archivos externos',
                "ruta" => route("archivos.externos")
            ],
            2 => [
                "activo" => true,
                "titulo" => 'Archivos para el SUN'
            ]
        ]
    ]])
@endsection

@section('aside_menu')
    @include('layouts.partials.main.aside_menu', ["asideMenu" =>
        [
            "item_seleccionado" => "archivos-externos",
        ]
    ])
@endsection

@push('styles')
    <link href="{{ asset('metronic/plugins/custom/bootstraptable/css/bootstrap-table.min.css') }}" type="text/css" rel="stylesheet"/>
@endpush

@section('contenido')
    @if ($movimientos->count() == 0)
    <div class="row">
        <div class="col-md-6 col-xl-4 mb-8">
            <div class="card card-custom wave wave-animate-slower mb-0" style="height: 130px;">
                <div class="card-body">
                    <div class="row" style="height: 100%;">
                        <div class="col-3 d-flex justify-content-center align-items-center">
                            <i class="fas fa-times-circle icon-4x icon-finanzas"></i>
                        </div>
                        <div class="col-9 d-flex align-items-center">
                            <h5 class="text-dark font-weight-bold font-size-h6"> Por el momento no hay movimientos de personal listos para enviar al SUN. </h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr class="text-center">
                        <th>Tipo de movimiento</th>
                        <th>Total movimientos</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($movimientos as $tipoMovimiento => $movimiento)
                        <tr class="text-center">
                            <td class="align-middle">{{ $tipoMovimiento }}</td>
                            <td class="align-middle">{{ $movimiento->count() }}</td>
                            <td class="align-middle">
                                <a href="{{ route("movimiento.personal.descargar.archivos.sun", $tipoMovimiento) }}" class="btn btn-icon btn-success">
                                    <i class="fas fa-file-download"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
@endsection

@push('scripts')
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
@endpush
