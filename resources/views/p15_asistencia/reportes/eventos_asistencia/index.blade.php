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
    <form id="form_filtrar" action="{{ route('asistencia.reporte.eventos.buscar') }}">
        <div class="card card-custom">
            <div class="card-body">
                <div class="alert alert-custom alert-success" role="alert">
                    <div class="alert-icon mr-4"><i class="flaticon-warning"></i></div>
                    <div class="alert-text">
                        <strong>
                            <p class="mb-2">Instrucciones:</p>
                            <ul class="mb-2">
                                @unless (auth()->user()->hasRole("EMPLEADO_GRAL"))
                                <li>Ingrese el RFC o número de empleado de la persona que desea consultar.</li>
                                @endunless
                                <li>Seleccione el rango de fechas que desea consultar.</li>
                            </ul>
                        </strong>
                    </div>
                </div>
                @unless (auth()->user()->hasRole("EMPLEADO_GRAL"))
                <div class="row">
                    <div class="col-md-6 form-group">
                        @include("componentes.busqueda_empleado", [
                            "existeEmpleado" => false,
                        ])
                    </div>
                </div>
                @endunless
                <div class="row">
                    <div class="col-md-6">
                        <label class="titulo-dato"><strong><span class="text-danger">*</span> Rango de fechas: </strong></label>
                        <div class="input-daterange input-group input-date-range-current">
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
                <button type="button" data-accion="limpiar" class="btn btn-warning mr-2" data-toggle="tooltip" data-placement="top" title="Limpiar"><i class="fas fa-sync-alt"></i> Limpiar </button>
            </div>
        </div>
    </form>
    <div class="card card-custom mt-8">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">
                    Eventos de asistencia
                </h3>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table
                    id="tabla_fechas_eventos"
                    class="text-center"
                    data-toggle="table"
                    data-pagination="true"
                    data-pagination-h-align="left"
                    data-pagination-detail-h-align="right"
                    data-page-size="20">
                    <thead>
                        <tr>
                            <th data-field="fecha" data-formatter="fechaFormatter"><label class="titulo-dato">Fecha</label></th>
                            <th data-field="horario" data-formatter="horarioFormatter"><label class="titulo-dato">Horario</label></th>
                            <th data-field="eventos" data-formatter="eventosFormatter"><label class="titulo-dato">Eventos</label></th>
                            <th data-field="incidencias" data-formatter="foliosIncidenciasFormatter"><label class="titulo-dato">Folio Incidencia</label></th>
                            <th data-field="incidencias" data-formatter="tiposIncidenciasFormatter"><label class="titulo-dato">Tipo Incidencia</label></th>
                            <th data-field="evaluacion_final" data-formatter="evaluacionFormatter"><label class="titulo-dato">Evaluacion</label></th>
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
    <script src="{{ asset('js/componentes/busqueda_empleado.js') }}"></script>
    <script src="{{ asset('js/p15_asistencia/reportes/eventos_asistencia/index.js?v=1.1') }}"></script>
@endpush