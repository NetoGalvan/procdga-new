@extends('layouts.main')

@section('title', "Biométricos")

@section('subheader')
    @include('layouts.partials.main.subheader', ["subheader" => [
        "titulo_subheader" => "PROCDGA",
        "icono_titulo_subheader" => "far fa-folder-open",
        "breadcrumbs" => [
            1 => [
                'activo' => false,
                'titulo' => 'Cátalogos',
                'ruta' => Route('catalogos')
            ],
            2 => [
                'activo' => true,
                'titulo' => "Biométricos"
            ]
        ]
    ]])
@endsection

@section('aside_menu')
    @include('layouts.partials.main.aside_menu', ["asideMenu" =>
        [
            "item_seleccionado" => "catalogos",
        ]
    ])
@endsection

@push('styles')
    <link href="{{ asset('metronic/plugins/custom/bootstraptable/css/bootstrap-table.min.css') }}" type="text/css" rel="stylesheet"/>
@endpush

@section('contenido')
    <div class="card card-custom">
        <div class="card-header">
            <div class="card-title">
                <span class="card-icon">
                    <i class="fas fa-clock"></i>
                </span>
                <h3 class="card-label">
                    Biométricos
                </h3>
            </div>
            <div class="card-toolbar">
                <a href="{{ route("asistencia.catalogo.biometricos.create") }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Agregar biométrico
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table
                    id="tabla_biometricos"
                    data-toggle="table"
                    class="table text-center"
                    data-pagination="true"
                    data-page-size="20"
                    data-pagination-h-align="left"
                    data-pagination-detail-h-align="right">
                    <thead>
                        <tr>
                            <th data-field="nombre"><label class="titulo-dato">Nombre</label></th>
                            <th data-field="ip" data-formatter="ipFormatter"><label class="titulo-dato">IP</label></th>
                            <th data-field="acceso" data-formatter="accesoFormatter"><label class="titulo-dato">Acceso</label></th>
                            <th data-field="ubicacion" data-formatter="ubicacionFormatter"><label class="titulo-dato">Ubicación</label></th>
                            <th data-formatter="accionesFormatter"><label class="titulo-dato">Acciones</label></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const biometricos = @json($biometricos);
    </script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
    <script src="{{ asset('js/p15_asistencia/catalogos/biometricos/index.js') }}"></script>
@endpush
