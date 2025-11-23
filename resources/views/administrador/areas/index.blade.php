@extends('layouts.main')

@section('title', 'Áreas')

@section('subheader')
    @include('layouts.partials.main.subheader', ["subheader" => [
        "titulo_subheader" => "PROCDGA",
        "icono_titulo_subheader" => "fas fa-chalkboard-teacher",
        "breadcrumbs" => [
            1 => [
                'activo' => true,
				'titulo' => 'Áreas',
            ],
        ]
    ]])
@endsection

@section('aside_menu')
    @include('layouts.partials.main.aside_menu', ["asideMenu" =>
        [
            "item_seleccionado" => "admin.areas",
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
                <a href="{{ Route('areas.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Agregar área
                </a> 
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table 
                    id="tabla_areas" 
                    class="text-center text-uppercase"
                    data-toggle="table"
                    data-ajax="getAreas"
                    data-data-field="data"
                    data-total-field="total"
                    data-side-pagination="server"
                    data-pagination="true"
                    data-query-params="queryParams"
                    data-search="true"
                    data-pagination-h-align="left"
                    data-pagination-detail-h-align="right"
                    data-search-align="right">
                    <thead>
                        <th data-field="nombre" data-formatter="nombreFormatter"><label class="titulo-dato">Nombre</label></th>
                        <th data-field="unidad_administrativa.nombre"><label class="titulo-dato">Unidad administrativa</label></th>
                        <th data-field="acciones" data-formatter="accionesFormatter"><label class="titulo-dato">Acciones</label></th>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    
@endsection

@push('scripts')
    <script>
        const urlGetAreas = @json(route("areas.getAreas"));
    </script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
	<script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
    <script src="{{ asset('js/administrador/areas/index.js?v=1.0') }}"></script>
@endpush