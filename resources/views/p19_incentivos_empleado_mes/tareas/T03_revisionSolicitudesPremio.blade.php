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

    <form method="POST" id="form_revision_solicitudes_premio" action="{{ route('incentivos.empleado.mes.revision.solicitudes.premio', [$incentivoEmpleadoMes->p19_incentivo_id, $instanciaTarea->instancia_tarea_id]) }}">
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
                                <p>Datos de las áreas:</p>
                                <ul>
                                    <ol>Se muestra el listado de las áreas incluídas en este proceso de pago de incentivo del mes</ol>
                                    <ol>Recuerde que aquellas áreas con estado <b>PENDIENTE</b> NO serán incluidas en la nómina para el pago de incentivo del mes</ol>
                                    <ol>Las áreas con estado <b>COMPLETADO</b> ya completaron sus capturas</ol>
                                </ul>
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

                <input type="hidden" id="arreglo_subprocesos" name="arreglo_subprocesos" value="">
                <div class="row">
                    <div class="col-12 form-group">
                        <table id="tabla_revision_solicitudes_premio"
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
                                    <th data-field="estatus" class="text-center text-uppercase cantidad" data-formatter="estadoFormatter"><label class="titulo-dato"><b>Estado</b></label></th>
                                    <th data-field="estatus" class="text-center text-uppercase cantidad" data-formatter="finalizoFormatter"><label class="titulo-dato"><b>Finalizó</b></label></th>
                                </tr>
                            </thead>
                        </table>
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
        const subprocesos          = @Json($subprocesos);
        const incentivoEmpleadoMes = @Json($incentivoEmpleadoMes);
        const urlTareas            = @Json( route('tareas') );
    </script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
    <script src="{{ asset('js/p19_incentivos_empleado_mes/tareas/T03_revisionSolicitudesPremio.js?v=1.0') }}"></script>
@endpush
