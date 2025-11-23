@extends('layouts.main')

@section('title', 'Roles')

@section('subheader')
    @include('layouts.partials.main.subheader', ["subheader" => [
        "titulo_subheader" => "PROCDGA",
        "icono_titulo_subheader" => "fas fa-user",
        "breadcrumbs" => [
            1 => [
                'activo' => true,
				'titulo' => 'Roles',
            ],
        ]
    ]])
@endsection

@section('aside_menu')
    @include('layouts.partials.main.aside_menu', ["asideMenu" =>
        [
            "item_seleccionado" => "admin.roles",
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
                    <i class="fas fa-user-tag"></i>
                </span>
                <h3 class="card-label">
                    Roles
                </h3>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table  
                    id="tabla_roles" 
                    class="table text-center" 
                    data-toggle="table"
                    data-search="true"
                    data-search-highlight="true"
                    data-page-size="20"
                    data-pagination="true"
                    data-pagination-h-align="left"
                    data-pagination-detail-h-align="right"
                    data-search-align="right">
                    <thead class="text-center">
                        <th data-field="name" data-formatter="nameFormatter"><label class="titulo-dato">Nombre</label></th>
                        <th data-field="label" data-formatter="labelFormatter"><label class="titulo-dato">Etiqueta</label></th>
                        <th data-field="descripcion"><label class="titulo-dato">Descripción</label></th>
                        <th data-field="acciones" data-formatter="accionesFormatter"><label class="titulo-dato">Acciones</label></th>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        var roles = @json($roles);
    </script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
	<script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
    <script src="{{ asset('js/administrador/roles/index.js?v=1.0') }}"></script>
@endpush