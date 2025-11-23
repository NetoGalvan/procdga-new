@extends('layouts.main')

@section('title', $reporte->nombre)

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
                'titulo' => $reporte->nombre
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

@push('styles')
    <link href="{{ asset('metronic/plugins/custom/bootstraptable/css/bootstrap-table.min.css') }}" type="text/css" rel="stylesheet"/>
@endpush

@section('contenido')
    <form method="GET" id="form_buscar" action="{{ route("tramite.incidencia.reporte.incidencias.archivo.buscar") }}">
        @csrf
        <div class="card card-custom">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">
                        Buscar o descargar las incidencias para archivo
                    </h3>
                </div>
            </div>
            <div class="card-body">
                <div class="alert alert-custom alert-success" role="alert">
                    <div class="alert-icon mr-4"><i class="flaticon-warning"></i></div>
                    <div class="alert-text">
                        <strong>
                            <p class="mb-2">Instrucciones:</p>
                            <ul class="mb-2">
                                <li>Seleccione el rango de fechas que desea consultar.</li>
                            </ul>
                        </strong>
                    </div>
                </div>                
                <div class="row">
                    <div class="col-md-4">
                        <label class="titulo-dato"><strong><span class="text-danger">*</span> Rango de fechas: </strong></label>
                        <div class="input-daterange input-group input-rango-fecha" id="input_rango_fecha">
                            <input type="text" class="form-control" name="fecha_inicio" autocomplete="off" placeholder="SELECCIONE UNA FECHA DE INICIO" required/>
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="la la-ellipsis-h"></i></span>
                            </div>
                            <input type="text" class="form-control" name="fecha_final" autocomplete="off" placeholder="SELECCIONE UNA FECHA FINAL" required/>
                        </div>
                        <span class="form-text text-muted">Seleccione un rango de fechas</span>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" data-accion="buscar" class="btn btn-primary mr-2" data-toggle="tooltip" data-placement="top" title="Buscar"><i class="fas fa-search"></i> Buscar </button>
                <button type="submit" data-accion="descargar" class="btn btn-success mr-2" data-toggle="tooltip" data-placement="top" title="Descargar"><i class="fas fa-arrow-down"></i> Descargar </button>
                <button type="button" data-accion="limpiar" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Limpiar"><i class="fas fa-sync-alt"></i> Limpiar </button>
            </div>
        </div>
    </form>

    <div class="card card-custom mt-8">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">
                    Resultado de la búsqueda
                </h3>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table
                    id="tabla_incidencias_empleado"
                    class="text-center text-uppercase"
                    data-toggle="table"
                    data-pagination="true"
                    data-pagination-h-align="left"
                    data-pagination-detail-h-align="right"
                    data-page-size="20">
                    <thead>
                        <tr>
                            <th data-field="indice" data-formatter="indiceFormatter"><label class="titulo-dato">N° Prog</label></th>
                            <th data-field="folio_autorizacion"><label class="titulo-dato">Folio autorización</label></th>
                            <th data-field="nombre_completo"><label class="titulo-dato">Nombre</label></th>
                            <th data-field="numero_empleado"><label class="titulo-dato">Número empleado</label></th>
                            <th data-field="tipo_incidencia.tipo_justificacion.nombre"><label class="titulo-dato">Tipo justificación</label></th>
                            <th data-field="fechas" data-formatter="fechasFormatter"><label class="titulo-dato">Fechas</label></th>
                            <th data-field="folio_cancelacion" data-formatter="folioCancelacionFormatter"><label class="titulo-dato">Folio cancelación</label></th>
                            <th data-field="observaciones_reporte" data-formatter="observacionesReporteFormatter"><label class="titulo-dato">Observaciones</label></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
    <script src="{{ asset('js/p12_tramites_incidencias/partials/tabla_incidencias_empleado.js?v=1.7') }}"></script>
    <script src="{{ asset('js/p12_tramites_incidencias/reportes/incidencias_archivo/index.js?v=1.0') }}"></script>
@endpush
