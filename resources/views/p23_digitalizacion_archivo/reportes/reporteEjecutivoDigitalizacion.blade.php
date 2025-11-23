@extends('layouts.main')

@section('title', 'REPORTE EJECUTIVO DETALLE DE DIGITALIZACIÓN')

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
                'titulo' => 'REPORTE EJECUTIVO DIGITALIZACIÓN'
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
                <h3 class="card-label">Reporte ejecutivo detalle de digitalización.</h3>
            </div>
        </div>
        <div class="card-body">
            <div class="alert alert-custom alert-success pb-0 pt-4" role="alert">
                <div class="alert-icon"><i class="flaticon-warning"></i></div>
                <div class="alert-text">
                    <p class="mb-2">Instrucciones:</p>
                    <ul class="mb-0">
                        <li>
                            Ingresar el periodo de tiempo deseado DD/MM/YYYY - DD/MM/YYYY
                        </li>
                        <li>
                            Podra realizar solo la consulta en caso de no requerir un reporte
                        </li>
                        <li>
                            Podra generar el reporte posteriormente al agregar el periodo de fecha deseado
                        </li>
                    </ul>
                    <p class="mt-5">Nota: Se mostraran todos los expedientes creados</p>
                </div>
            </div>
            <form id="formBuscar">
            <div class="row mb-5">
                <div class="col-md-4">
                    <label for="rango_fechas" class="titulo-dato">Periodo (fecha inicio - fecha fin)</label>
                    <div class="input-daterange input-group">
                        <input type="text" class="form-control date-picker inputmk-fecha fecha-inicio" name="fecha_inicio" placeholder="FECHA DE INICIO" value=""  />
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="la la-ellipsis-h"></i></span>
                        </div>
                        <input type="text" class="form-control date-picker inputmk-fecha fecha-fin" name="fecha_fin" placeholder="FECHA DE FIN" value="" />
                    </div>
                </div> 
            </div>
            </form>
            <div class="row my-2">
                <div class="col-md-2">
                    <button type="button" id="btn-filtrar" name="btn_filtrar" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i> Buscar 
                    </button>
                    <button type="button" id="btn-filtrar-spinner" class="btn btn-primary w-100 spinner spinner-white spinner-right d-none disabled">
                        <i class="fas fa-search"></i> Buscando... 
                    </button>
                </div>
                <div class="col-md-2">
                    <button type="button" id="btn-limpiar" name="btn_limpiar" class="btn btn-warning w-100">
                        <i class="fas fa-brush"></i> Limpiar 
                    </button>
                    <button type="button" id="btn-limpiar-spinner" class="btn btn-warning w-100 spinner spinner-white spinner-right d-none disabled">
                        <i class="fas fa-brush"></i> Limpiando... 
                    </button>
                </div>
                <div class="col-md-2">
                    <button type="button" id="btn-descargar-reporte" class="btn btn-danger w-100">
                        <i class="fas fa-file-pdf"></i> Dercargar reporte 
                    </button>
                </div>
            </div>
            <hr>
            <table class="table table-bordered table-general" id="tabla-expedientes"
                data-ajax="mostrarDatosExpedientes"
                data-toggle="table"
                data-toolbar="#toolbar"
                data-pagination="true"
                data-page-size="10"
                data-page-list="[10, 25, 50, 100]"
            >
                <thead>
                    <tr>
                        <th data-field="numero_expediente" class="text-center w-20">
                            <label class="titulo-dato">Número de expediente</label>
                        </th>
                        <th data-field="numero_empleado" class="text-center w-20">
                            <label class="titulo-dato">Número de empleado</label>
                        </th>
                        <th data-field="nombre_empleado_completo" class="w-20">
                            <label class="text-center titulo-dato">Nombre del Empleado</label>
                        </th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        URL_buscarExpedientes = "{{ route('reporte.ejecutivo.digitalizacion.archivo') }}";
        URL_descargarReporte = "{{ route('descargar.pdf.reporte.ejecutivo.digitalizacion.archivo') }}";
    </script>
    <script src="{{ asset('js/p23_digitalizacion_archivo/sweet_alert_general.js') }}"></script>
    <script src="{{ asset('js/p23_digitalizacion_archivo/reportes/reporteEjecutivoDigitalizacion.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
@endpush

@push('styles')
    <link href="{{ asset('metronic/plugins/custom/bootstraptable/css/bootstrap-table.min.css') }}" type="text/css" rel="stylesheet"/>
@endpush