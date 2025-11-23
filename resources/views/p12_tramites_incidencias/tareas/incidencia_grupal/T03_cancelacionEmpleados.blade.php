@extends("layouts.main")

@section("title", $instanciaTarea->tarea->nombre)

@section("subheader")
    @include("layouts.partials.main.subheader", ["subheader" => [
        "titulo_subheader" => "PROCDGA",
        "icono_titulo_subheader" => "far fa-folder-open",
        "breadcrumbs" => [
            1 => [
                "activo" => false,
                "titulo" => "Tareas disponibles",
                "ruta" => Route('tareas')
            ],
            2 => [
                "activo" => true,
                "titulo" => $instanciaTarea->tarea->nombre
            ]
        ]
    ]])
@endsection

@section('aside_menu')
    @include('layouts.partials.main.aside_menu', ["asideMenu" => ["item_seleccionado" => "tareas"]])
@endsection

@push('styles')
    <link href="{{ asset('metronic/plugins/custom/bootstraptable/css/bootstrap-table.min.css') }}" type="text/css" rel="stylesheet"/>
    <style>
        #tabla_incidencias_empleado > tbody tr {
            cursor: pointer;
        }
    </style>
@endpush

@section('contenido')
    <div class="card card-custom">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">Detalle del proceso</h3>
            </div>
        </div>
        <div class="card-body">
            @include("p12_tramites_incidencias.partials.datos_general_incidencia_grupal", [
                "secciones" => ["general", "tipo_captura", "incidencia"]
            ])
        </div>
    </div>
    
    <form method="POST" id="form_finalizar_tarea" action="{{ route("tramite.incidencia.grupal.cancelacion.empleados", [$tramiteIncidencia, $instanciaTarea]) }}">
        @csrf
        <input type="hidden" name="empleados_a_cancelar" />
        <div class="card card-custom mt-8">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Seleccionar a los empleados a cancelar</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="alert alert-custom alert-success" role="alert">
                    <div class="alert-icon mr-4"><i class="flaticon-warning"></i></div>
                    <div class="alert-text">
                        <strong>
                            <p class="mb-2">Instrucciones:</p>
                            <ul class="mb-0">
                                <li>Seleccione a los empleados a quienes se les va a retirar la incidencia. Puede optar por eliminarla para un empleado en especifico, varios empleados o a todos los empleados según sea necesario.</li>
                            </ul>
                        </strong>
                    </div>
                </div>
                <div class="table-responsive">
                    <table
                        id="tabla_incidencias_empleado"
                        class="text-center text-uppercase"
                        data-toggle="table"
                        data-search="true" 
                        data-pagination="true"
                        data-page-size="20"
                        data-pagination-h-align="left"
                        data-pagination-detail-h-align="right">
                        <thead>
                            <tr>
                                <th data-field="is_checked" data-checkbox="true"></th>
                                <th data-field="nombre_completo" data-searchable="true"><label class="titulo-dato">Nombre</label></th>
                                <th data-field="numero_empleado" data-searchable="true"><label class="titulo-dato">Número empleado</label></th>
                                <th data-field="rfc" data-searchable="true"><label class="titulo-dato">RFC</label></th>
                                <th data-field="seccion_sindical" data-searchable="false"><label class="titulo-dato">Sección sindical</label></th>
                                <th data-field="unidad_administrativa" data-searchable="false" data-formatter="unidadAdministrativaFormatter"><label class="titulo-dato">Unidad administrativa</label></th>
                                <th data-field="nomina" data-searchable="false"><label class="titulo-dato">Nomina</label></th>
                                <th data-field="nivel_salarial" data-searchable="false"><label class="titulo-dato">Nivel salarial</label></th>
                                <th data-field="tipo_empleado" data-searchable="false" data-formatter="tipoEmpleadoFormatter"><label class="titulo-dato">Tipo empleado</label></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <div class="text-center">
                    <button type="submit" class="btn btn-success mr-2"><i class="fas fa-check-square"></i> Finalizar tarea </button>
                    <button type="button" class="btn btn-danger" id="btn_cancelar"><i class="fas fa-times"></i> Cancelar proceso </button>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        const incidenciasEmpleado = @json($incidenciasEmpleado);
    </script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
    <script src="{{ asset('js/p12_tramites_incidencias/partials/tabla_incidencias_empleado.js?v=1.9') }}"></script>
    <script src="{{ asset('js/p12_tramites_incidencias/partials/cancelar_proceso.js?v=1.0') }}"></script>
    <script src="{{ asset('js/p12_tramites_incidencias/tareas/incidencia_grupal/T03_cancelacionEmpleados.js?v=1.0') }}"></script>
@endpush
