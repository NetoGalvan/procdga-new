@extends('layouts.main')

@section('title', 'Reportes detalle de solicitudes')

@section('subheader')
    @include('layouts.partials.main.subheader', ["subheader" => [
        "titulo_subheader" => "PROCDGA",
        "icono_titulo_subheader" => "far fa-folder-open",
        "breadcrumbs" => [
            1 => [
                'activo' => false,
                'titulo' => 'Reportes',
                'ruta' => Route('reportes')
            ],
            2 => [
                'activo' => true,
                'titulo' => 'Reportes detalle de solicitudes'
            ]
        ]
    ]])
@endsection

@section('aside_menu')
    @include('layouts.partials.main.aside_menu', ["asideMenu" =>
        [
            "item_seleccionado" => "reportes",
        ]
    ])
@endsection

@section('contenido')
<div class="card card-custom mb-5">
    <div class="card-header">
        <div class="card-title">
            <h3 class="card-label">Generación de reportes</h3>
        </div>
    </div>
    <div class="card-body">
        <div class="alert alert-custom alert-outline-success" role="alert">
            <div class="alert-icon"><i class="flaticon-warning"></i></div>
            <div class="alert-text">
                Filtra la información que necesitas para generar el reporte
            </div>
        </div>
        <form method="POST" id="form_filtro" action="{{ route('solicitud.servicio.reporte.filtrar') }}">
            @method('post')
            @csrf
            <div class="row">
                <div class="col-md-3 form-group">
                    <label for="anio" class="titulo-dato"><span class="requeridos">* </span>Año</label>
                    <input type="text" id="input_year" name="anio" class="form-control" readonly value="{{ date("Y") }}" autocomplete="off">
                </div>
                {{-- <div class="form-group col-md-3">
                    <label for="periodo" class="titulo-dato">Selecciona el período</label>
                        <div class="input-daterange input-group" id="rango_de_fecha">
                        <input type="text" class="form-control" name="fecha_de" autocomplete="off"/>
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                        </div>
                        <input type="text" class="form-control" name="fecha_a" autocomplete="off"/>
                        </div>
                </div> --}}
                <div class="col-md-3 form-group">
                    <label for="area_id" class="titulo-dato">Área</label>
                    <select class="form-control text-uppercase" name="area_id" id="area_id" autocomplete="off">
                        <option value=""> Seleccione una opción </option>
                        @foreach ($areas as $area)
                            <option class="text-uppercase" value="{{ $area->area_id }}" > {{ $area->identificador }}  -  {{ $area->nombre }} </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 form-group">
                    <label for="estatus" class="titulo-dato">Estatus</label>
                    <select class="form-control text-uppercase" name="estatus" id="estatus" autocomplete="off">
                        <option value=""> Seleccione una opción </option>
                        @foreach ($estatus as $key => $estatu)
                            <option class="text-uppercase" value="{{ $estatu }}" > {{ $estatu == 'EN_PROCESO' ? 'EN PROCESO' : $estatu }} </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 form-group">
                    <label for="especialidad" class="titulo-dato">Especialidad/Taller</label>
                    <select class="form-control text-uppercase" name="especialidad" id="especialidad" autocomplete="off">
                        <option value=""> Seleccione una opción </option>
                        @foreach ($servicios as $servicio)
                            <option class="text-uppercase" value="{{ $servicio->nombre_servicio }}" > {{ mb_strtoupper( $servicio->nombre_servicio ) }} </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <button type="button" id="btn_filtrar_reporte" name="btn_filtrar_reporte" class="btn btn-primary mr-2" data-toggle="tooltip" data-placement="top" title="Filtrar"><i class="fas fa-search"></i> Filtrar solicitudes </button>
                    <a href="" id="btn_generar_reporte" name="btn_generar_reporte" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Generar reporte"><i class="fas fa-file-excel"></i> Generar reporte </a>
                    <button type="button" id="btn_limpiar_filtro" name="btn_limpiar_filtro" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Limpira filtro"><i class="fas fa-brush"></i> Limpiar campos </button>
                </div>
            </div>
        </form>
        <div class="row mt-6">
            <div class="col-12 form-group">
                <table id="tablaServiciosSolicitados"
                    data-ajax="getServiciosSolicitados"
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
                            <th data-field="nombre_servicio_general" class="text-center text-uppercase"><label class="titulo-dato"><b>Tipo de Servicio</b></label></th>
                            <th data-field="folio" class="text-center text-uppercase"><label class="titulo-dato"><b>Folio</b></label></th>
                            <th data-field="estatus" class="text-center text-uppercase" data-formatter="estatusServicioFormatter"><label class="titulo-dato"><b>Estatus</b></label></th>
                            <th data-field="unidad" class="text-center text-uppercase" data-formatter="unidadServicioFormatter"><label class="titulo-dato"><b>Solicitado por</b></label></th>
                            <th data-field="fecha_solicitud" class="text-center text-uppercase"><label class="titulo-dato"><b>Fecha Solicitud</b></label></th>
                            <th data-field="acciones" class="text-center text-uppercase" data-formatter="accionesFormatterServiciosSolicitados"><label class="titulo-dato"><b>&nbsp;&nbsp;&nbsp; Acciones &nbsp;&nbsp;&nbsp;</b></label></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <div class="text-center">
            <a href="{{route('reportes')}}" type="button" class="btn btn-success"><i class="fas fa-arrow-left"></i> Volver a reportes </a>
        </div>
    </div>
    </div>

{{-- Finaliza Form del Filtro --}}

@include('p08_solicita_servicios.reportes.modales_reportes_solicita_servicios.modal_ss')

@endsection

@push('styles')
    <link href="{{ asset('metronic/plugins/custom/bootstraptable/css/bootstrap-table.min.css') }}" type="text/css" rel="stylesheet"/>
@endpush

@push('scripts')
    <script>
        var urlGetServiciosSolicitados = @json(route(Route::currentRouteName()));
        var tipoDeServicio = @json($servicioGeneral);
        var urlVerDetalleSolicitud = @json( route('solicitud.servicio.reporte.ver.detalle') );
        var urlImprimirDetalle = @json( route('solicitud.servicio.reporte.imprimir.detalle') );
        var urlLimpiarFiltro = @json( route('solicitud.servicio.reporte.limpiar.filtro') );
        var urlGenerarReporteExcel = @json( route('solicitud.servicio.reporte.generar.excel') );
    </script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
    <script src="{{ asset('js/p08_solicita_servicios/reportes/reporte_solicita_servicio.js') }}"></script>
@endpush

