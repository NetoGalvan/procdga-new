@extends('layouts.main')

@section('title', $instanciaTarea->tarea->nombre)

@section('subheader')
    @include('layouts.partials.main.subheader', ["subheader" => [
        "titulo_subheader" => "PROCDGA",
        "icono_titulo_subheader" => "far fa-folder-open",
        "breadcrumbs" => [
            1 => [
                'activo' => false,
                'titulo' => 'Tareas disponibles',
                'ruta' => Route('tareas')
            ],
            2 => [
                'activo' => true,
                'titulo' => $instanciaTarea->tarea->nombre
            ]
        ]
    ]])
@endsection

@section('aside_menu')
    @include('layouts.partials.main.aside_menu', ["asideMenu" =>
        [
            "item_seleccionado" => "tareas",
        ]
    ])
@endsection

@section('contenido')

    <form method="POST" id="form_subproceso_asignacion_premios_empleado" action="{{ route('incentivos.empleado.mes.subproceso.asignacion.premios.empleado', [$subproceso->p19_subproceso_id, $instanciaTarea->instancia_tarea_id]) }}">
        @method('POST')
        @csrf

        <div class="card card-custom mb-5">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Incentivo empleado del mes</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-custom alert-success" role="alert">
                            <div class="alert-icon"><i class="flaticon-warning"></i></div>
                            <div class="alert-text">
                                <h5>Instruccciones:</h5>
                                <ol>
                                    <li>Avise a los empleados que estén interesados en recibir el premio de puntualidad en la quincena de pago indicada</li>
                                    <li>Atienda a las indicaciones del Subdirector de Enlace de su unidad administrativa</li>
                                    <li>Capture el número de empleado y búsquelo</li>
                                    <li>Si el empleado pertenece a su unidad administrativa podrá evaluarlo</li>
                                    <li>Seleccione el mes de inicio de evaluación:</li>
                                    <ul>
                                        <li>Si el resultado es <b>"OK CALIFICA"</b> puede agregarlo a la lista</li>
                                        <li>Si el resultado es <b>"NO CALIFICA"</b> puede seleccionar otro mes de inicio y volver a evaluar</li>
                                    </ul>
                                    <li>En caso de que desee eliminar algun empleado de la lista, seleccione el botón <b>Eliminar</b></li>
                                    <li><b>NO CONTINÚE LA TAREA HASTA QUE HAYA TERMINADO DE CAPTURAR A TODOS LOS EMPLEADOS QUE DEBERÁN SER INCLUÍDOS EN ESTE PROCESO</b>. Si avanza la tarea ya no podrá regresar a capturar más empleados</li>
                                    <li>Atienda a los calendarios de captura. Si se atrasa, es posible que el área central o su Subdirector de Enlace cierre el proceso de captura y los empleados que haya acumulado <b>NO SERÁN INCLUÍDOS EN LA NÓMINA</b></li>
                                </ol>
                            </div>
                        </div>
                        <p> <span class="requeridos">Campos obligatorios (*)</span> </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-custom mb-5">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Asignación de Premios por Empleado</h3>
                </div>
            </div>
            <div class="card-body" >
                <div class="row mb-4">
                    <div class="col-md-4">
                        <label class="titulo-dato"> Folio: </label>
                        <span class="valor-dato"> <b> {{ $subproceso->folio }} </b> </span>
                    </div>
                    <div class="col-md-4">
                        <label class="titulo-dato"> Área: </label>
                        <span class="valor-dato"> <b> {{ mb_strtoupper($subproceso->area->identificador) }} - {{ mb_strtoupper($subproceso->area->nombre) }}  </b> </span>
                    </div>
                    <div class="col-md-4">
                        <label class="titulo-dato"> Premios autorizados: </label>
                        <span class="valor-dato"> <b> {{ $premiosSubAreaAutorizados }} </b> </span>
                    </div>
                    <div class="col-md-4">
                        <label class="titulo-dato"> Quincena de pago: </label>
                        <span class="valor-dato"> <b> {{ $subproceso->nombre_quincena }} </b> </span>
                    </div>
                    <div class="col-md-4">
                        <label class="titulo-dato"> Mes a evaluar: </label>
                        <span class="valor-dato"> <b> {{ $subproceso->nombre_mes_anio_evaluacion }} </b> </span>
                    </div>
                    <div class="col-md-12">
                        <label class="titulo-dato"> Instrucciones áreas: </label>
                        <span class="valor-dato"> <b> {{ mb_strtoupper($subproceso->comentarios_sub_ea) }} </b> </span>
                    </div>
                </div>
            </div>


            <div class="card-body">
                @include("componentes.busqueda_empleado", [
                        "existeEmpleado" => false,
                    ])

                <div class="row">

                    <div class="col-md-6 form-group">
                        <label for="btn_agregar_empleado" class="titulo-dato"><span class="requeridos"></span>&nbsp;</label>
                        <button type="button" id="btn_agregar_empleado" name="btn_agregar_empleado" class="btn btn-success btn-default btn-block" onclick="agregarEmpleadoNomina()" disabled ><i class="flaticon2-plus"></i> Agregar empleado </button>
                    </div>

                </div>
                <br>
                <br>
                <div class="row" >
                    <div class="col-md-12 form-group">
                        <input type="hidden" id="data_empleado" name="data_empleado" value="">
                        <input type="hidden" id="fechas_evaluacion" name="fechas_evaluacion" value="">
                        <div class="row">
                            <div class="col-12 form-group">
                                <table id="tabla_empleados_nomina"
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
                                            <th data-field="p19_nomina_id" data-visible="false" class="text-center text-uppercase"><label class="titulo-dato"><b>ID</b></label></th>
                                            <th data-field="numero_empleado" class="text-center text-uppercase"><label class="titulo-dato"><b>No. empleado</b></label></th>
                                            <th data-field="nombre_empleado" class="text-center text-uppercase" data-formatter="nombreEmpleadoFormatter"><label class="titulo-dato"><b>Nombre</b></label></th>
                                            <th data-field="area" class="text-center text-uppercase"><label class="titulo-dato"><b>Área</b></label></th>
                                            <th data-field="id_sindicato" class="text-center text-uppercase"><label class="titulo-dato"><b>Sección</b></label></th>
                                            <th data-field="nivel_salarial" class="text-center text-uppercase"><label class="titulo-dato"><b>Nivel Salarial</b></label></th>
                                            <th data-field="nombre_mes" class="text-center text-uppercase"><label class="titulo-dato"><b>Periodo</b></label></th>
                                            <th data-field="falta" class="text-center text-uppercase" data-formatter="faltaFormatter"><label class="titulo-dato"><b>Faltas</b></label></th>
                                            <th data-field="justificaciones" class="text-center text-uppercase" data-formatter="justificacionesFormatter"><label class="titulo-dato"><b>Justificaciones</b></label></th>
                                            <th data-field="califica" class="text-center text-uppercase" data-formatter="calificaFormatter"><label class="titulo-dato"><b>Estatus</b></label></th>
                                            <th data-field="nombre" class="text-center text-uppercase" data-formatter="reporteFormatter"><label class="titulo-dato"><b>Reporte</b></label></th>
                                            <th data-field="acciones" class="text-center text-uppercase" data-formatter="accionesFormatter"><label class="titulo-dato"><b>Acciones</b></label></th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <div class="text-center">
                    <button type="button" id="btn_continuar_proceso" class="btn btn-success"><i class="fas fa-check-square"></i> Finalizar tarea </button>
                </div>
            </div>
        </div>

    </form>

@endsection

@push('styles')
    <link href="{{ asset('metronic/plugins/custom/bootstraptable/css/bootstrap-table.min.css') }}" type="text/css" rel="stylesheet"/>
    <style>
        .cantidad {
            width: 10%;
        }
    </style>
@endpush

@push('scripts')
    <script>
        const subproceso      = @Json($subproceso);
        const empleadosNomina = @Json($empleadosNomina);
        const premiosSubAreaAutorizados  = @Json($premiosSubAreaAutorizados);
        const instanciaTarea  = @Json($instanciaTarea);
        const urlTareas       = @Json( route('tareas') );
        const urlEvaluacionEmpleado = @Json( route('incentivos.empleado.mes.subproceso.asignacion.premios.empleado.evaluacion') );
        const urlAgregarEmpleado    = @Json( route('incentivos.empleado.mes.subproceso.asignacion.premios.empleado.agregra.empleado') );
        const urlEliminarEmpleado   = @Json( route('incentivos.empleado.mes.subproceso.asignacion.premios.empleado.eliminar.empleado') );
        const urlImprimirReporteEmpleado = @json( route('incentivos.empleado.mes.subproceso.asignacion.premios.empleado.reporte.empleado') );
    </script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
    <script src="{{ asset('js/componentes/busqueda_empleado.js') }}"></script>
    <script src="{{ asset('js/p19_incentivos_empleado_mes/tareas/ST02_subprocesoAsignacionPremiosEnmpleado.js?v=1.01') }}"></script>
@endpush
