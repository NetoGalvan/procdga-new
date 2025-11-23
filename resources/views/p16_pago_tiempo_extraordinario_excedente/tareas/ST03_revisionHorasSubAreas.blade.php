@extends('layouts.main')

@section('title', 'Revisión y autorización de horas por subárea')

@section('subheader')
    @include('layouts.partials.main.subheader', ["subheader" => [
        "titulo_subheader" => "PROCDGA",
        "icono_titulo_subheader" => "far fa-folder-open",
        "breadcrumbs" => [
            1 => [
                'activo' => false,
                'titulo' => 'Tareas Disponibles',
                'ruta' => Route('tareas')
            ],
            2 => [
                'activo' => true,
                'titulo' => 'Revisión y autorización de horas por subárea'
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

@push('styles')
	<link href="{{ asset('metronic/plugins/custom/bootstraptable/css/bootstrap-table.min.css') }}" type="text/css" rel="stylesheet"/>
@endpush

@section('contenido')
    <div class="mb-5 card card-custom">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">Detalle del proceso</h3>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 form-group">
                    <label class="titulo-dato"> Folio </label>
                    <span class="valor-dato">  {{ $subPago->folio }} </span>
                </div>
                <div class="col-md-3 form-group">
                    <label class="titulo-dato"> Quincena </label>
                    <span class="valor-dato">  {{ $subPago->pagoTiempoExtra->quincena }} </span>
                </div>
                <div class="col-md-3 form-group">
                    <label class="titulo-dato"> Fecha Límite </label>
                    <span class="valor-dato">  {{ $subPago->fecha_limite }} </span>
                </div>
                <div class="col-md-3 form-group">
                    <label class="titulo-dato"> Tipo </label>
                    <span class="valor-dato">  {{ $subPago->pagoTiempoExtra->tipo }} </span>
                </div>
                <div class="col-md-6 form-group">
                    <label class="titulo-dato"> Área </label>
                    <span class="valor-dato">  {{ $subPago->area->identificador }} - {{ $subPago->area->nombre }} </span>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-5 card card-custom">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label user-select-none">Revisión y autorización de las horas asignadas a los empleados por las subáreas.</h3>
            </div>
            @if ($pendientes === 0)
                <div class="card-toolbar">
                    <a type="button" id="reporte_general" href="{{ route('tiempo.extraordinario.excedente.descarga.reporte.general.subareas') }}" class="btn btn-success" data-toggle="tooltip" title="Descargar reporte general"> <i class="fas fa-file-excel"></i> Descargar reporte general </a>
                </div>
            @endif
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-custom alert-danger" role="alert">
                        <div class="alert-icon"><i class="flaticon-warning"></i></div>
                        <div class="alert-text">
                            <p>IMPORTANTE: La fecha limite que tienen las Subárea para agregar a sus empleados es hasta el día <b> {{$cadena_fecha}}</b></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row {{-- py-5 --}}">
                <div class="col-md-12 {{-- mx-auto --}}">

                    <table
                        id="table_tareas_activas"
                        data-unique-id="instancia_tarea_id"
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
                            <th data-field="instancia_tarea_id" data-visible="false">Id</th>
                            <th data-field="pertenece_al_area" data-formatter="areaFormatter" data-align="center"><label class="titulo-dato">Subárea</label></th>
                            <th data-field="estatus" data-formatter="estatusFormatter" data-align="center"><label class="titulo-dato">Estatus</label></label></th>
                            <th data-field="estatus" data-formatter="reporteFormatter" data-align="center"><label class="titulo-dato">Reporte</label></label></th>
                            <th data-field="estatus" data-formatter="rechazarFormatter" data-align="center"><label class="titulo-dato">Rechazar</label></th>

                        </thead>
                    </table>

                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-md-12 text-center">
                    <form action="{{ route('tiempo.extraordinario.excedente.revision.sub.areas', [$subPago, $instanciaTarea] ) }}" method="post" id="form_finalizar_tarea">
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
                    <form action="{{ route('tiempo.extraordinario.excedente.rechazar.tarea.subarea', [$subPago, $instanciaTarea] ) }}" method="post" id="form_rechazar_tarea">
                        @method('post') @csrf
                        <input type="hidden" name="instancia_tarea_id" id="instancia_tarea_id">
                        <input type="hidden" name="subarea_id" id="subarea_id">
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
<script>
    let subareas = @json($subareas);
    let subareas_general = @json($subareas_general);
    let urlDescargarReporteGeneralSubareas = "{{ route('tiempo.extraordinario.excedente.descarga.reporte.general.subareas') }}";
    let urlDescargarReporteIndividualSubareas = "{{ route('tiempo.extraordinario.excedente.descarga.reporte.subarea') }}";
    let mensajeError = @json($errors->has('mensaje_error') ? $errors->first('mensaje_error') : false);
</script>
<script src="{{ asset('js/p16_pago_tiempo_extraordinario_excedente/tareas/ST03_revisionHorasSubAreas.js?v=1.0') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
    <script src="{{ asset('js/componentes/busqueda_empleado.js') }}"></script>
@endpush
