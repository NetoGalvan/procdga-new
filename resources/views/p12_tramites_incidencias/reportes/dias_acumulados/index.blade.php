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
    <form method="GET" id="form_buscar" action="{{ route("tramite.incidencia.reporte.dias.acumulados.buscar") }}">
        @csrf
        <div class="card card-custom">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">
                        Buscar o descargar los días acumulados por tipo de incidencia
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
                                @unless (auth()->user()->hasRole("EMPLEADO_GRAL"))   
                                <li>Ingrese el RFC o número de empleado de la persona que desea consultar.</li>
                                @endunless
                                <li>Seleccione el rango de fechas que desea consultar.</li>
                                <li>(Opcional) Seleccione uno o varios tipos de incidencias para incluir en el reporte.</li>
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
                    <div class="col-md-6 form-group">
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
                    <div class="col-md-12">
                        <label class="titulo-dato">Tipo de incidencia:</label>
                        <select class="form-control select2" id="tipos_incidencias" name="tipos_incidencias[]" multiple autocomplete="off">
                            @foreach ($tiposIncidencias as $tipoIncidencia)
                                <option value="{{ $tipoIncidencia->tipo_incidencia_id }}"> 
                                    {{ $tipoIncidencia->tipoJustificacion->nombre }} —
                                    Artículo: {{ $tipoIncidencia->articulo ?? "N/A" }} — 
                                    Subartículo: {{ $tipoIncidencia->subarticulo ?? "N/A" }} — 
                                    Intervalo: {{ str_replace("_", " ", $tipoIncidencia->intervalo_evaluacion) }} —
                                    Sexo: {{ $tipoIncidencia->sexo == "F" ? "FEMENINO" : $tipoIncidencia->sexo == "M" ? "MASCULINO" : "TODOS" }} —
                                    Tipo días: {{ str_replace("_", " ", $tipoIncidencia->tipo_dias) }} —
                                    Tipo de empleado: {{ str_replace("_", " ", $tipoIncidencia->tipo_empleado) }}
                                </option>
                            @endforeach
                        </select>
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
                            <th data-field="tipo_justificacion"><label class="titulo-dato">Tipo justificación</label></th>
                            <th data-field="articulo" data-formatter="articuloFormatter"><label class="titulo-dato">Artículo</label></th>
                            <th data-field="subarticulo" data-formatter="subarticuloFormatter"><label class="titulo-dato">Subartículo</label></th>
                            <th data-field="descripcion" data-formatter="descripcionFormatter"><label class="titulo-dato">Descripción</label></th>
                            <th data-field="dias_acumulados"><label class="titulo-dato">Total días</label></th>
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
    <script src="{{ asset('js/p12_tramites_incidencias/partials/tabla_incidencias_empleado.js?v=1.7') }}"></script>
    <script src="{{ asset('js/p12_tramites_incidencias/reportes/dias_acumulados/index.js?v=1.0') }}"></script>
@endpush
