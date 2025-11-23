@extends('layouts.main')

@section('title', 'REPORTE EJECUTIVO DE PROCESOS EJECUTADOS PARA PREMIO DE PUNTUALIDAD Y ASISTENCIA')

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
                'titulo' => 'REPORTE EJECUTIVO DE PROCESOS EJECUTADOS PARA PREMIO DE PUNTUALIDAD Y ASISTENCIA'
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

    <form action="{{ route('reporte.ejecutivo.premio.puntualidad.asistencia') }}" method="POST" id="reporte_ejecutivo_premio">
        @method('post')
        @csrf
        <div class="card card-custom mb-5">
            <div class="card-body">
                <div class="alert alert-custom alert-success" role="alert">
                    <div class="alert-icon mr-4"><i class="flaticon-warning"></i></div>
                    <div class="alert-text">
                        <strong>
                            <p class="mb-2">Instrucciones:</p>
                            <ul class="mb-2">
                                <li>Ingrese la fecha del premio de puntualidad y asistencia que desea consultar</li>
                            </ul>
                        </strong>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label class="titulo-dato"><strong><span class="text-danger">*</span> Rango de fechas: </strong></label>
                        <div class="input-daterange input-group input-date-range-current">
                            <input type="text" class="form-control" name="fecha_inicio" id="fecha_inicio" autocomplete="off" placeholder="SELECCIONE UNA FECHA DE INICIO" required/>
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="la la-ellipsis-h"></i></span>
                            </div>
                            <input type="text" class="form-control" name="fecha_final" id="fecha_final" autocomplete="off" placeholder="SELECCIONE UNA FECHA FINAL" required/>
                        </div>
                        <span class="form-text text-muted">Seleccione un rango de fechas</span>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="button" id="btn_buscar" name="btn_buscar" data-accion="buscar" class="btn btn-primary mr-2" data-toggle="tooltip" data-placement="top" title="Buscar"><i class="fas fa-search"></i> Buscar </button>
                <button type="button" id="btn_descargar" name="btn_descargar" data-accion="descargar" class="btn btn-success mr-2" data-toggle="tooltip" data-placement="top" title="Descargar"><i class="fas fa-arrow-down"></i> Descargar </button>
                <button type="button" data-accion="limpiar" class="btn btn-warning mr-2" data-toggle="tooltip" data-placement="top" title="Limpiar"><i class="fas fa-sync-alt"></i> Limpiar </button>
            </div>
        </div>
    </form>

    <div class="card card-custom mt-8">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">
                    Detalle de premio
                </h3>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table
                    id="tabla_premio_ejecutivo"
                    class="text-center"
                    data-toggle="table"
                    data-pagination="true"
                    data-pagination-h-align="left"
                    data-pagination-detail-h-align="right"
                    data-page-size="20">
                    <thead>
                        <tr>
                            <th data-field="folio"><label class="titulo-dato">Folio</label></th>
                            <th data-field="quincena"><label class="titulo-dato">Quincena</label></th>
                            <th data-field="estatus" data-formatter="estatusFormatter"><label class="titulo-dato">Estatus</label></th>
                            <th data-field="area" data-formatter="areaFormatter"><label class="titulo-dato">Área</label></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('js/p20_premio_puntualidad_asistencia/reportes/reporteEjecutivoPremio.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
    <script>
        let urlReporteEmpleadosEjecutivoBuscar = @json( route('reporte.ejecutivo.premio.puntualidad.asistencia.buscar') );
        let urlDescargarReporteEjecutivo = @json( route('descargar.pdf.reporte.ejecutivo.premio.puntualidad.asistencia') );
    </script>
@endpush

@push('styles')
    <link href="{{ asset('metronic/plugins/custom/bootstraptable/css/bootstrap-table.min.css') }}" type="text/css" rel="stylesheet"/>
@endpush
