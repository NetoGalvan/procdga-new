@extends('layouts.main')

@section('title', $instanciaTarea->tarea->nombre)

@section('aside_menu')
    @include('layouts.partials.main.aside_menu', ["asideMenu" =>
        [
            "item_seleccionado" => "tareas",
        ]
    ])
@endsection

@section('subheader')
    @include('layouts.partials.main.subheader', ["subheader" => [
        "titulo_subheader" => "PROCDGA",
        "icono_titulo_subheader" => "far fa-folder-open",
        "breadcrumbs" => [
            1 => [
                'activo' => false,
                'titulo' => 'Tareas',
                'ruta' => Route('tareas')
            ],
            2 => [
                'activo' => true,
                'titulo' => $instanciaTarea->tarea->nombre
            ]
        ]
    ]])
@endsection

@section('contenido')

    <div class="card card-custom mb-5">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">Detalle del proceso</h3>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <label class="titulo-dato"> Área </label>
                    <span class="valor-dato">  {{ $subproceso->area->identificador }} - {{ $subproceso->area->nombre }} </span>
                </div>
                <div class="col-md-4">
                    <label class="titulo-dato"> Folio </label>
                    <span class="valor-dato">  {{ $subproceso->folio }} </span>
                </div>
                <div class="col-md-4">
                    <label class="titulo-dato"> Quincena de pago </label>
                    <span class="valor-dato"> {{ $subproceso->quincena }} </span>
                </div>
                <div class="col-md-12">
                    <label class="titulo-dato"> Instrucciones </label>
                    <span class="valor-dato">  {{ $subproceso->premioPuntialidad->instrucciones }} </span>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-custom mb-5">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">Áreas</h3>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">

                    <table
                        id="tabla_autorizacion_subproceso"
                        class="text-center"
                        data-toggle="table"
                        data-data-field="data"
                        data-total-field="total"
                        data-pagination="true"
                        data-page-size="10"
                        data-search="false"
                        data-pagination-h-align="left"
                        data-pagination-detail-h-align="right"
                        data-search-align="right">
                        <thead>
                            <th data-field="area_id" data-visible="false">Id</th>
                            <th data-field="pertenece_al_area" data-formatter="areasFormatter" data-align="center"><label class="titulo-dato">Área</label></th>
                            <th data-field="estatus" data-formatter="estatusFormatter" data-align="center"><label class="titulo-dato">Estatus</label></th>
                            <th data-field="estatus" data-formatter="reporteFormatter" data-align="center"><label class="titulo-dato">Reporte</label></th>
                            <th data-field="estatus" data-formatter="rechazarFormatter" data-align="center"><label class="titulo-dato">Rechazar</label></th>
                        </thead>
                    </table>

                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-md-12 text-center">

                    <form action="{{ route('autorizacion.solicitudes', [$subproceso, $instanciaTarea] ) }}" method="post" id="form_finalizar_tarea">
                        @method('post') @csrf
                        <input type="hidden" name="avance_subareas" id="avance_subareas">
                        <button id="finalizarTarea" type="button" class="btn btn-success"><i class="fas fa-check-square"></i>Finalizar subproceso </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <!-- Modal-->
    <div class="modal fade" id="modal_rechazo" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Rechazar tarea</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('premio.puntualidad.rechazar.tarea.subarea', [$subproceso, $instanciaTarea] ) }}" method="post" id="form_rechazar_tarea">
                        @method('post') @csrf
                        <input type="hidden" name="instancia_tarea_id" id="instancia_tarea_id">
                        <input type="hidden" name="premio_puntualidad_area_id" id="premio_puntualidad_area_id">
                        <div class="row">
                            <div class="col-md-12 align-middle">
                                <div class="form-group">
                                    <label id="label_motivo_rechazo" class="titulo-dato"><strong><span class="requeridos">* </span>Motivo del rechazo</strong></label>
                                    <textarea rows="5" class="form-control form-control-sm normalizar-texto" autocomplete="off" name="motivo_rechazo" id="motivo_rechazo" required></textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="rechazar_tarea"><i class="fas fa-window-close"></i>Rechazar</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/p20_premio_puntualidad_asistencia/tareas/STPPA03_autorizacionSolicitudes.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
    <script>
        let subAreas = @json($subAreas);
        let urlReporteArea = @json(route('premio.puntualidad.asistencia.descarga.reporte.subarea'));
        let mensajeError = @json($errors->has('mensaje_error') ? $errors->first('mensaje_error') : false);
    </script>
@endpush

@push('styles')
    <link href="{{ asset('metronic/plugins/custom/bootstraptable/css/bootstrap-table.min.css') }}" type="text/css" rel="stylesheet"/>
@endpush
