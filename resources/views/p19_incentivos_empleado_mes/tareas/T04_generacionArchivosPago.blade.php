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

    <form method="POST" id="form_generacion_archivos_pago" action="{{ route('incentivos.empleado.mes.generar.archivos.pago', [$incentivoEmpleadoMes->p19_incentivo_id, $instanciaTarea->instancia_tarea_id]) }}">
        @method('POST')
        @csrf

        <div class="card card-custom mb-5">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Datos de las áreas</h3>
                </div>
            </div>
            <div class="card-body" >

                <div class="row mb-6">
                    <div class="col-md-4">
                        <label class="titulo-dato"> Folio: </label>
                        <span class="valor-dato"> <b> {{ $incentivoEmpleadoMes->folio }} </b> </span>
                    </div>
                    <div class="col-md-4">
                        <label class="titulo-dato"> Área creadora: </label>
                        <span class="valor-dato"> <b> {{ mb_strtoupper($incentivoEmpleadoMes->areaCreadora->identificador) }} - {{ mb_strtoupper($incentivoEmpleadoMes->areaCreadora->nombre) }}  </b> </span>
                    </div>
                    <div class="col-md-4">
                        <label class="titulo-dato"> Premios autorizados: </label>
                        <span class="valor-dato"> <b> {{ $incentivoEmpleadoMes->premios_aprobados }} </b> </span>
                    </div>
                    <div class="col-md-4">
                        <label class="titulo-dato"> Quincena de pago: </label>
                        <span class="valor-dato"> <b> {{ $incentivoEmpleadoMes->nombre_quincena }} </b> </span>
                    </div>
                    <div class="col-md-4">
                        <label class="titulo-dato"> Mes a evaluar: </label>
                        <span class="valor-dato"> <b> {{ $incentivoEmpleadoMes->nombre_mes_anio_evaluacion }} </b> </span>
                    </div>
                    <div class="col-md-4">
                        <label class="titulo-dato"> Documento: </label>
                        <span class="valor-dato"> <b> {{ $incentivoEmpleadoMes->numero_documento }} </b> </span>
                    </div>
                    <div class="col-md-12">
                        <label class="titulo-dato"> Instrucciones Áreas: </label>
                        <span class="valor-dato"> <b> {{ mb_strtoupper($incentivoEmpleadoMes->comentarios_opera_incen) }} </b> </span>
                    </div>
                </div>

                <br>
                <br>

                <div class="row">
                    <div class="col-12 form-group">
                        <table id="tabla_generacion_archivos_pago"
                            data-unique-id="p19_subproceso_id"
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
                                    <th data-field="area.identificador" class="text-center text-uppercase"><label class="titulo-dato"><b>Identificador</b></label></th>
                                    <th data-field="area.nombre" class="text-center text-uppercase"><label class="titulo-dato"><b>Áreas</b></label></th>
                                    <th data-field="premios_aplicados" class="text-center text-uppercase cantidad" data-formatter="premiosAplicadosFormatter"><label class="titulo-dato"><b>Premios aplicados</b></label></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2 form-group">
                        <a type="button" href="{{ route('incentivos.empleado.mes.formato.generacion.concentrado.incentivo.empleados.mes.excel', ['incentivoEmpleadoMes' => $incentivoEmpleadoMes->p19_incentivo_id]) }}" id="btn_generar_reporte" name="btn_generar_reporte" class="btn btn-success btn-default btn-block" data-toggle="tooltip" data-placement="top" title="Generar layout" onclick="descargarReporte(event, this.href)">
                            <i class="fas fa-file-excel"></i> Generar layout
                        </a>
                    </div>
                    <div class="col-md-2 form-group">
                        <a type="button" href="{{ route('incentivos.empleado.mes.formato.generacion.concentrado.incentivo.empleados.mes.pdf', ['incentivoEmpleadoMes' => $incentivoEmpleadoMes->p19_incentivo_id]) }}" id="btn_generar_reporte_pdf" name="btn_generar_reporte_pdf" class="btn btn-danger btn-default btn-block" data-toggle="tooltip" data-placement="top" title="Generar concentrado" onclick="descargarReportePDF(event, this.href)">
                            <i class="far fa-file-pdf"></i> Generar concentrado
                        </a>
                    </div>
                </div>

            </div>

            <div class="card-footer">
                <div class="text-center">
                    <button type="button" id="btn_continuar_proceso" class="btn btn-success"><i class="fas fa-check-square"></i> Finalizar proceso </button>
                    <button type="button" class="btn btn-danger" id="btn_cancelar"><i class="fas fa-times"></i> Cancelar proceso </button>
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
        const subprocesosFinales   = @Json($subprocesosFinales);
        const incentivoEmpleadoMes = @Json($incentivoEmpleadoMes);
        const urlTareas            = @Json( route('tareas') );
    </script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
    <script src="{{ asset('js/p19_incentivos_empleado_mes/tareas/T04_generacionArchivosPago.js?v=1.01') }}"></script>
@endpush

