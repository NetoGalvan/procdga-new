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
    <link href="{{ asset('metronic/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" type="text/css" rel="stylesheet"/>
    <style>
        .fc-unthemed th.fc-day-header, .fc-unthemed th.fc-day-header > a, .fc-unthemed th.fc-day-header > span {
            color: #212121 !important;
        }
        .fc-event-solid-success, .fc-event-solid-danger, .fc-event-solid-primary, .fc-event-solid-warning {
            cursor: pointer;
        }
        .fc-event-solid-secondary {
            cursor: default !important;
        }
    </style>
@endpush

@section('contenido')
    <form id="form_filtrar" action="{{ route('asistencia.reporte.calendario.buscar') }}">
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
                    Calendario de asistencia
                </h3>
            </div>
        </div>
        <div class="card-body">
            <div class="row mb-8">
                <div class="col-12">
                    <span class="label label-md label-rounded label-success mr-1" style="color: transparent;">1</span> <span class="mr-4"><strong>ASISTENCIA</strong></span>
                    <span class="label label-md label-rounded label-primary mr-1" style="color: transparent;">1</span> <span class="mr-4"><strong>RETARDO LEVE</strong></span>
                    <span class="label label-md label-rounded label-warning mr-1" style="color: transparent;">1</span> <span class="mr-4"><strong>RETARDO GRAVE</strong></span>
                    <span class="label label-md label-rounded label-danger mr-1" style="color: transparent;">1</span> <span class="mr-4"><strong>FALTA</strong></span>
                </div>
            </div>
            <div id='calendar'></div>
        </div>
    </div>
    @include("p15_asistencia.reportes.tarjeta_electronica_calendario.partials.modal_detalle_asistencia")
@endsection

@push('scripts')
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>
    <script src="{{ asset('js/componentes/busqueda_empleado.js') }}"></script>
    <script src="{{ asset('js/p12_tramites_incidencias/partials/tabla_incidencias_empleado.js?v=1.7') }}"></script>
    <script src="{{ asset('js/p15_asistencia/reportes/tarjeta_electronica_calendario/index.js?v=1.8') }}"></script>
@endpush