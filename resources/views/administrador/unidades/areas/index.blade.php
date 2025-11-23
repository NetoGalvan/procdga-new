@extends('layouts.main')

@section('title', 'Áreas')

@section('subheader')
    @include('layouts.partials.main.subheader', ["subheader" => [
        "titulo_subheader" => "PROCDGA",
        "icono_titulo_subheader" => "fas fa-chalkboard-teacher",
        "breadcrumbs" => [
            1 => [
                'activo' => false,
				'titulo' => 'Unidades',
				'ruta' => route('unidades.index'),
            ],
            2 => [
                'activo' => true,
				'titulo' => 'Áreas',
            ],
        ]
    ]])
@endsection

@section('aside_menu')
    @include('layouts.partials.main.aside_menu', ["asideMenu" =>
        [
            "item_seleccionado" => "admin.unidades",
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
                    <i class="fas fa-chalkboard-teacher"></i>
                </span>
                <h3 class="card-label">
                    Áreas
                </h3>
            </div>
            <div class="card-toolbar">
                <a href="{{ Route("unidades.areas.create", [$unidad]) }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Agregar área
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table
                    id="tabla_registros"
                    class="text-center"
                    data-toggle="table"
                    data-search="true"
                    data-search-highlight="true"
                    data-page-size="20"
                    data-pagination="true"
                    data-pagination-h-align="left"
                    data-pagination-detail-h-align="right"
                    data-search-align="right">
                    <thead>
                        <th data-field="identificador" ><label class="titulo-dato">Identificador</label></th>
                        <th data-field="nombre" ><label class="titulo-dato">Nombre</label></th>
                        <th data-field="activo" data-formatter="activoFormatter"><label class="titulo-dato">Estatus</label></th>
                        <th data-field="acciones" data-formatter="accionesFormatter"><label class="titulo-dato">Acciones</label></th>
                    </thead>
                </table>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        const registros = @json($areas);
    </script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
	<script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
    <script src="{{ asset('js/administrador/unidades/areas/index.js?v=1.0') }}"></script>
@endpush
