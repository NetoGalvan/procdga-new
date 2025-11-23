@extends('layouts.main')

@section('title', 'Listado de solicitantes para incentivo empleado del mes')

@section('subheader')
    @include('layouts.partials.main.subheader', ["subheader" => [
        "titulo_subheader" => "PROCDGA",
        "icono_titulo_subheader" => "far fa-folder-open",
        "breadcrumbs" => [
            1 => [
                'activo' => false,
                'titulo' => 'Notificaciones disponibles',
                'ruta' => Route('notificaciones')
            ],
            2 => [
                'activo' => true,
                'titulo' => 'Listado de solicitantes para incentivo empleado del mes'
            ]
        ]
    ]])
@endsection

@section('aside_menu')
    @include('layouts.partials.main.aside_menu', ["asideMenu" =>
        [
            "item_seleccionado" => "notificaciones",
        ]
    ])
@endsection

@section('contenido')

    <form method="post" id="form_notificacion" action="{{ route('incentivos.empleado.mes.notificacion.listado.solicitantes.premio.incentivo.subea', [$incentivoEmpleadoMes->p19_incentivo_id, $instanciaTarea->instancia_tarea_id]) }}" >
        @method('post')
        @csrf

        <div class="card card-custom mb-5">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Datos de la solicitud de servicio solicitada</h3>
                </div>
            </div>
            <div class="card-body" >

                <div class="row mb-6">
                    <div class="col-md-4">
                        <label class="titulo-dato"> Folio: </label>
                        <span class="valor-dato"> <b> {{ $incentivoEmpleadoMes->folio }} </b> </span>
                    </div>
                    <div class="col-md-4">
                        <label class="titulo-dato"> Área: </label>
                        <span class="valor-dato"> <b> {{ mb_strtoupper($subProcesoNomina->area->identificador) }} - {{ mb_strtoupper($subProcesoNomina->area->nombre) }}  </b> </span>
                    </div>
                    <div class="col-md-12">
                        <label class="titulo-dato"> Quincena de pago: </label>
                        <span class="valor-dato"> Listado de solicitantes del incentivo de empleado del mes para la quincena: <b> {{ $incentivoEmpleadoMes->nombre_quincena }} </b> </span>
                    </div>
                </div>

                <br>
                <br>

                <div class="row">
                    <div class="col-12 form-group">
                        <table id="tabla_notificacion_listado_empleados"
                            data-unique-id="p19_nomina_id"
                            data-total-field="total"
                            data-data-field="data"
                            data-side-pagination="server"
                            data-pagination="true"
                            data-query-params="queryParams"
                            data-search="false"
                            data-search-align="right"
                            data-pagination-h-align="left"
                            data-pagination-detail-h-align="right"
                            data-cache="false">
                            <thead>
                                <tr>
                                    <th data-field="numero_empleado" class="text-center">No. Empleado</th>
                                    <th data-field="nombre_completo" class="text-center" data-formatter="nombreEmpleadoFormatter">Nombre del empleado</th>
                                    <th data-field="area" class="text-center" data-formatter="subAreaFormatter">Sub Área</th>
                                    <th data-field="id_sindicato" class="text-center">Sección sindical</th>
                                    <th data-field="nivel_salarial" class="text-center" data-formatter="nivelSalarialFormatter">Nivel salarial</th>
                                    <th data-field="nombre_mes" class="text-center">Peridodo</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="text-center">
                    <button type="button" id="btn_finalizar_notificacion" class="btn btn-success"><i class="fas fa-check-square"></i> Enterado, eliminar notificación </button>
                </div>
            </div>
        </div>

    </form>

@endsection

@push('styles')
    <link href="{{ asset('metronic/plugins/custom/bootstraptable/css/bootstrap-table.min.css') }}" type="text/css" rel="stylesheet"/>
@endpush

@push('scripts')
    <script>
        const incentivoEmpleadoMes = @Json($incentivoEmpleadoMes);
        const subProcesoNomina     = @Json($subProcesoNomina);
        const urlTareas            = @Json( route('tareas') );
    </script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
    <script src="{{ asset('js/p19_incentivos_empleado_mes/notificaciones/TNOTA01_notificacionListadoSolicitantesPremioIncentivoSubea.js?v=1.0') }}"></script>
@endpush
