@extends('layouts.main')

@section('title', 'Logs')

@section('subheader')
    @include('layouts.partials.main.subheader', ["subheader" => [
        "titulo_subheader" => "PROCDGA",
        "icono_titulo_subheader" => "fas fa-exclamation-circle",
        "breadcrumbs" => [
            1 => [
                'activo' => true,
				'titulo' => 'Logs',
            ],
        ]
    ]])
@endsection

@section('aside_menu')
    @include('layouts.partials.main.aside_menu', ["asideMenu" =>
        [
            "item_seleccionado" => "admin.logs"
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
                    <i class="fas fa-exclamation-circle"></i>
                </span>
                <h3 class="card-label">
                    Logs
                </h3>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table 
                    id="tabla_logs" 
                    class="text-center"
                    data-toggle="table"
                    data-ajax="getLogs"
                    data-data-field="data"
                    data-total-field="total"
                    data-side-pagination="server"
                    data-pagination="true"
                    data-query-params="queryParams"
                    data-pagination-h-align="left"
                    data-pagination-detail-h-align="right">
                    <thead>
                        <th data-field="created_at" data-formatter="fechaFormatter"><label class="titulo-dato">Fecha</label></th>
                        <th data-field="tipo" data-formatter="tipoFormatter"><label class="titulo-dato">Tipo</label></th>
                        <th data-field="modulo"><label class="titulo-dato">Módulo</label></th>
                        <th data-field="mensaje"><label class="titulo-dato">Mensaje</label></th>
                        <th data-field="datos_extra" data-formatter="datosExtraFormatter"><label class="titulo-dato">Datos extra</label></th>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const urlGetLogs = @json(route("logs.getLogs"));
    </script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
	<script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
    <script src="{{ asset('js/administrador/logs/index.js?v=1.1') }}"></script>
@endpush