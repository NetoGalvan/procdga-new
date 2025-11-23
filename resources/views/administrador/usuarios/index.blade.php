@extends('layouts.main')

@section('title', 'Usuarios')

@section('subheader')
    @include('layouts.partials.main.subheader', ["subheader" => [
        "titulo_subheader" => "PROCDGA",
        "icono_titulo_subheader" => "fas fa-user",
        "breadcrumbs" => [
            1 => [
                'activo' => true,
				'titulo' => 'Usuarios',
            ],
        ]
    ]])
@endsection

@section('aside_menu')
    @include('layouts.partials.main.aside_menu', ["asideMenu" =>
        [
            "item_seleccionado" => "admin.usuarios",
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
                    <i class="fas fa-users"></i>
                </span>
                <h3 class="card-label">
                    Usuarios
                </h3>
            </div>
            <div class="card-toolbar">
                <a href="{{ Route('usuarios.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Agregar usuario
                </a> 
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table 
                    id="tabla_usuarios" 
                    class="text-center"
                    data-toggle="table"
                    data-ajax="getUsuarios"
                    data-data-field="data"
                    data-total-field="total"
                    data-side-pagination="server"
                    data-query-params="queryParams"
                    data-pagination="true"
                    data-search="true"
                    data-search-highlight="true"
                    data-pagination-h-align="left"
                    data-pagination-detail-h-align="right"
                    data-search-align="right">
                    <thead>
                        <th data-field="id" data-align="center" data-visible="false"><label class="titulo-dato">ID</label></th>
                        <th data-field="nombre_usuario" data-align="center" data-visible="false"><label class="titulo-dato">Usuario</label></th>
                        <th data-field="nombre_completo" data-align="center"><label class="titulo-dato">Nombre</label></th>
                        <th data-field="numero_empleado" data-align="center"><label class="titulo-dato">Número empleado</label></th>
                        <th data-field="rfc" data-align="center"><label class="titulo-dato">RFC</label></th>
                        <th data-field="curp" data-align="center"><label class="titulo-dato">CURP</label></th>
                        <th data-field="email" data-align="center"><label class="titulo-dato">Email</label></th>
                        <th data-field="area" data-align="center" data-formatter="areaFormatter"><label class="titulo-dato">Area</label></th>
                        <th data-field="roles" data-formatter="rolesFormatter" data-align="center"><label class="titulo-dato">Roles</label></th>
                        <th data-field="activo" data-formatter="activoFormatter" data-align="center"><label class="titulo-dato">Estatus</label></th>
                        <th data-field="acciones" data-formatter="accionesFormatter" data-align="center"><label class="titulo-dato">Acciones</label></th>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    
@endsection

@push('scripts')
    <script>
        const urlGetUsuarios = @json(route("usuarios.getUsuarios"));
    </script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
	<script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
    <script src="{{ asset('js/administrador/usuarios/index.js?v=1.0') }}"></script>
@endpush