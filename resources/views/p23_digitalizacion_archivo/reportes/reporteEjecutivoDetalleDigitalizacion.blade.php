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
                'titulo' => 'REPORTE EJECUTIVO DETALLE DE DIGITALIZACIÓN'
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
            <div class="alert alert-custom alert-success" role="alert">
                <div class="alert-icon"><i class="flaticon-warning"></i></div>
                <div class="alert-text">
                    <p class="mb-2">Instrucciones:</p>
                    <ul class="mb-0">
                        <li>
                            Buscar por medio del nombre empezando por apellidos o número de expediente
                        </li>
                    </ul>
                </div>
            </div>
            <form id="formBuscar">
            <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="titulo-dato">
                                <strong>
                                    Nombre del empleado
                                </strong>
                            </label>
                            <input type="text" class="form-control normalizar-texto" id="nombre-empleado" placeholder="Ej. SALAZAR HERNANDEZ MAURICIO">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="titulo-dato">
                                <strong>
                                    Número de expediente
                                </strong>
                            </label>
                            <input type="text" class="form-control normalizar-texto" id="numero-expediente" placeholder="Ej. 3594025">
                        </div>
                    </div>  
            </div>
            </form>
            <div class="row">
                <div class="col-md-3">
                    <button type="button" id="btn-filtrar" name="btn_filtrar" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i> Buscar 
                    </button>
                    <button type="button" id="btn-filtrar-spinner" class="btn btn-primary w-100 spinner spinner-white spinner-right d-none disabled">
                        <i class="fas fa-search"></i> Buscando... 
                    </button>
                </div>
                <div class="col-md-3">
                    <button type="button" id="btn-limpiar" name="btn_limpiar" class="btn btn-warning w-100">
                        <i class="fas fa-brush"></i> Limpiar 
                    </button>
                    <button type="button" id="btn-limpiar-spinner" class="btn btn-warning w-100 spinner spinner-white spinner-right d-none disabled">
                        <i class="fas fa-brush"></i> Limpiando... 
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
                        <th data-field="numero_empleado" class="text-center w-20">
                            <label class="titulo-dato">Número de empleado</label>
                        </th>
                        <th data-field="nombre_empleado_completo" class="w-20">
                            <label class="text-center titulo-dato">Nombre del Empleado</label>
                        </th>
                        <th data-field="rfc" class="text-center w-20">
                            <label class="titulo-dato">RFC</label>
                        </th>
                        <th data-field="numero_expediente" class="text-center w-20">
                            <label class="titulo-dato">Número de expediente</label>
                        </th>
                        <th data-formatter="descargarReporteFormatter" class="text-center w-20">
                            <label class="titulo-dato">Descargar reporte</label>
                        </th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
{{--
    <form action="{{ route('reporte.ejecutivo.detalle.digitalizacion') }}" method="POST" id="reporte_detalle_digitalizacion">
        @method('post')
        @csrf
        <div class="card card-custom mb-5">
            <div class="card-header card-header-tabs-line">
                <div class="card-toolbar">
                    <ul class="nav nav-tabs nav-bold nav-tabs-line">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#kt_tab_reporte_actual">
                            <span class="nav-icon"><i class="flaticon2-files-and-folders"></i></span>
                            <span class="nav-text">Reporte ejecutivo detalle digitalización (Actual)</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#kt_tab_reporte_historico">
                            <span class="nav-icon"><i class="flaticon2-files-and-folders"></i></span>
                            <span class="nav-text">Reporte ejecutivo detalle digitalización (Históricos)</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="kt_tab_reporte_actual" role="tabpanel" aria-labelledby="kt_tab_reporte_actual">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="numero_exp_act" class="titulo-dato"><strong><span class="requeridos">* </span>Número de expediente actual</strong></label>
                                <input type="number" class="form-control" name="numero_exp_act" id="numero_exp_act" placeholder="Número de expediente...">
                            </div>
                            <div class="col-md-2 mt-0">
                                <label for="btn_folio_actual" class="titulo-dato">&nbsp;&nbsp;&nbsp;</label>
                                <button type="button" id="btn_folio_actual" name="btn_folio_actual" class="btn btn-primary" onclick="buscarInformacionActual()"><i class="fas fa-cog"></i>Ejecutar reporte</button>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="kt_tab_reporte_historico" role="tabpanel" aria-labelledby="kt_tab_reporte_historico">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="numero_exp_his" class="titulo-dato"><strong><span class="requeridos">* </span>Número de expediente histórico</strong></label>
                                <input type="number" class="form-control" name="numero_exp_his" id="numero_exp_his" placeholder="Número de expediente...">
                            </div>
                            <div class="col-md-2 mt-0">
                                <label for="btn_folio_historico" class="titulo-dato">&nbsp;&nbsp;&nbsp;</label>
                                <button type="button" id="btn_folio_historico" name="btn_folio_historico" class="btn btn-primary" onclick="buscarInformacionHistorico()"><i class="fas fa-cog"></i>Ejecutar reporte</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
--}}
@endsection

@push('scripts')
    <script type="text/javascript">
        URL_buscarExpedientes = "{{ route('reporte.ejecutivo.detalle.digitalizacion') }}";
        URL_descargarReporte = "{{ route('descargar.pdf.reporte.ejecutivo.detalle.digitalizacion') }}";
    </script>

    <script type="text/javascript">
        
        //$('#tabla-expedientes')

        


{{--
        $('.date-picker').datepicker({
            changeYear: true,
            format: "yyyy",
            minViewMode: "years",
            language: 'es',
            autoclose: true,
            orientation: "bottom left"
        });

        $('.date-picker').change( function(e) {
            e.preventDefault();
            $('.datepicker .datepicker-years').find('span.focused').attr('class', 'year');
        });
--}}
    </script>
    <script src="{{ asset('js/p23_digitalizacion_archivo/reportes/reporteEjecutivoDetalleDigitalizacion.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
{{--    
    <script>
        var urlReporteDetalleDig = @json( route('descargar.pdf.reporte.ejecutivo.detalle.digitalizacion' ) );
    </script>
--}}
@endpush

@push('styles')
    <link href="{{ asset('metronic/plugins/custom/bootstraptable/css/bootstrap-table.min.css') }}" type="text/css" rel="stylesheet"/>
@endpush
