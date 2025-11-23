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
    <form id="form_buscar" action="{{ route('asistencia.reporte.faltas.buscar') }}">
        <div class="card card-custom">
            <div class="card-body">
                <div class="alert alert-custom alert-success" role="alert">
                    <div class="alert-icon mr-4"><i class="flaticon-warning"></i></div>
                    <div class="alert-text">
                        <strong>
                            <p class="mb-2">Instrucciones:</p>
                            <ul class="mb-2">
                                <li>Elija las evaluaciones que desea consultar. (FALTAS, RETARDOS LEVES Y GRAVES)</li>
                                <li>(Opcional) Seleccione la unidad administrativa que desea consultar.</li>
                                <li>(Opcional) Seleccione al empleado que desea consultar.</li>
                                <li>Seleccione el rango de fechas que desea consultar.</li>
                            </ul>
                        </strong>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label class="titulo-dato"><strong><span class="text-danger">*</span> Tipo evaluación:</label>
                        <select id="tipo_reporte" name="tipos_evaluaciones[]" class="form-control select2" autocomplete="off" required>
                            <option value="FALTA">FALTAS</option>
                            <option value="RETARDO LEVE">RETARDOS LEVES</option>
                            <option value="RETARDO GRAVE">RETARDOS GRAVES</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label class="titulo-dato">Unidad administrativa:</label>
                        <select name="unidad_administrativa_id" class="form-control select2" autocomplete="off">
                            <option value="">Seleccione una opción</option>
                            <option value="TODAS">TODAS LAS ÁREAS</option>
                            @foreach ($unidades as $unidad)
                                <option value="{{ $unidad->unidad_administrativa_id }}">{{ $unidad->nombre_completo }}</option>    
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 form-group">
                        @include("componentes.busqueda_empleado", [
                            "existeEmpleado" => false,
                            "noRequerido" => true
                        ])
                    </div>
                </div>
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
                <button type="submit" data-accion="descargar" class="btn btn-success mr-2" data-toggle="tooltip" data-placement="top" title="Descargar"><i class="fas fa-arrow-down"></i> Descargar </button>
                <button type="button" data-accion="limpiar" class="btn btn-warning mr-2" data-toggle="tooltip" data-placement="top" title="Limpiar"><i class="fas fa-sync-alt"></i> Limpiar </button>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
    <script src="{{ asset('js/componentes/busqueda_empleado.js') }}"></script>
    <script src="{{ asset('js/p15_asistencia/reportes/faltas/index.js?v=1.1') }}"></script>
@endpush