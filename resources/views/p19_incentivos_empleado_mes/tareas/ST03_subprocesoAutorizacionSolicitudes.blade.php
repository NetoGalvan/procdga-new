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

    <form method="POST" id="form_subproceso_autorizacion_solicitudes" action="{{ route('incentivos.empleado.mes.subproceso.autorizacion.solicitudes', [$subproceso->p19_subproceso_id, $instanciaTarea->instancia_tarea_id]) }}">
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
                                <p>Datos de las áreas</p>
                                <ul>
                                    <ol>Se muestra el listado de las sub áreas incluídas en este proceso de pago de premio incentivo del mes</ol>
                                    <ol>Recuerde que aquellas sub áreas con estado <b>PENDIENTE</b> NO serán incluidas en la nómina para el pago de incentivo del mes</ol>
                                    <ol>Las sub áreas con estado <b>COMPLETADO</b> ya completaron sus capturas</ol>
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
                        <span class="valor-dato"> <b> {{ $subproceso->folio }} </b> </span>
                    </div>
                    <div class="col-md-4">
                        <label class="titulo-dato"> Área: </label>
                        <span class="valor-dato"> <b> {{ mb_strtoupper($subproceso->area->identificador) }} - {{ mb_strtoupper($subproceso->area->nombre) }}  </b> </span>
                    </div>
                    <div class="col-md-4">
                        <label class="titulo-dato"> Premios autorizados: </label>
                        <span class="valor-dato"> <b> {{ $subproceso->premios_aprobados }} </b> </span>
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
                        <label class="titulo-dato"> Instrucciones Áreas: </label>
                        <span class="valor-dato"> <b> {{ mb_strtoupper($subproceso->comentarios_opera_incen) }} </b> </span>
                    </div>
                </div>


                <input type="hidden" id="arreglo_sub_areas_tareas" name="arreglo_sub_areas" value="">
                <div class="row">
                    <div class="col-12 form-group">
                        <table id="tabla_subproceso_autorizacion_solicitudes"
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
                                    <th data-field="identificador" class="text-center text-uppercase"><label class="titulo-dato"><b> Identificador</b></label></th>
                                    <th data-field="nombre" class="text-center text-uppercase"><label class="titulo-dato"><b> Área</b></label></th>
                                    <th data-field="estatus" class="text-center text-uppercase cantidad" data-formatter="estadoFormatter"><label class="titulo-dato"><b> Estado</b></label></th>
                                    <th data-field="estatus" class="text-center text-uppercase cantidad" data-formatter="finalizoFormatter"><label class="titulo-dato"><b> Finalizo</b></label></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

            </div>

            <div class="card-footer">
                <div class="text-center">
                    <button type="button" id="btn_continuar_proceso" class="btn btn-success"><i class="fas fa-check-square"></i> Finalizar Subproceso </button>
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
        const subAreas        = @Json($subAreas);
        const urlTareas       = @Json( route('tareas') );
    </script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
    <script src="{{ asset('js/p19_incentivos_empleado_mes/tareas/ST03_subprocesoAutorizacionSolicitudes.js?v=1.0') }}"></script>
@endpush
