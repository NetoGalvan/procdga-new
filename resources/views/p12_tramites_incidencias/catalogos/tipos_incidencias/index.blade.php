@extends('layouts.main')

@section('title', 'CATÁLOGOS - TIPOS DE INCIDENCAS')

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
                'titulo' => 'Tipos de incidencias'
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
    <div class="card card-custom mb-5">
        <div class="card-header">
            <div class="card-title">
                <span class="card-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </span>
                <h3 class="card-label">
                    Tipos de incidencias
                </h3>
            </div>
            <div class="card-toolbar">
                <a href="{{ route("tramite.incidencia.catalogo.tipos.incidencias.create") }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Agregar nuevo
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table
                    id="tabla_tipos_incidencias"
                    class="text-center text-uppercase"
                    data-toggle="table"
                    data-search="true"
                    data-search-highlight="true"
                    data-pagination="true"
                    data-page-size="20">
                    <thead>
                        <tr>
                            <th data-field="tipo_justificacion.nombre"><label class="titulo-dato">Tipo de incidencia</label></th>
                            <th data-field="descripcion" data-formatter="descripcionFormatter"><label class="titulo-dato">Descripción</label></th>
                            <th data-field="articulo" data-formatter="articuloFormatter"><label class="titulo-dato">Artículo</label></th>
                            <th data-field="subarticulo" data-formatter="subarticuloFormatter"><label class="titulo-dato">Subartículo</label></th>
                            <th data-field="ley"><label class="titulo-dato">Ley</label></th>
                            <th data-field="intervalo_evaluacion" data-formatter="intervaloEvaluacionFormatter"><label class="titulo-dato">Intervalo</label></th>
                            <th data-field="tipo_empleado" data-formatter="tipoEmpleadoFormatter"><label class="titulo-dato">Tipo de empleado</label></th>
                            <th data-field="sexo"><label class="titulo-dato">Sexo</label></th>
                            <th data-field="tipo_dias" data-formatter="tipoEmpleadoFormatter"><label class="titulo-dato">Tipo dias</label></th>
                            <th data-field="aplica_autoincidencia" data-formatter="aplicaAutoincidenciasFormatter"><label class="titulo-dato">Autoincidencia</label></th>
                            <th data-field="activo" data-formatter="activoFormatter"><label class="titulo-dato">Estatus</label></th>
                            <th data-field="acciones" data-formatter="accionesFormatter"><label class="titulo-dato">Acciones</label></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        var tiposIncidencias = @json($tiposIncidencias);
    </script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
    <script src="{{ asset('js/p12_tramites_incidencias/catalogos/tipos_incidencias/index.js') }}"></script>
@endpush
