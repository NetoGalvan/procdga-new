@extends('layouts.main')

@section('title', 'SERVICIO SOCIAL - REPORTES - REIMPRESIÓN DE CARTAS DE SERVICIO SOCIAL')

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
                'titulo' => 'SERVICIO SOCIAL - REPORTES - REIMPRESIÓN DE CARTAS DE SERVICIO SOCIAL'
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
    <div class="card card-custom">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">Reimpresión de cartas de inicio y/o termino.</h3>
            </div>
        </div>
        <div class="card-body">
            <div class="alert alert-custom alert-success" role="alert">
                <div class="alert-icon"><i class="flaticon-warning"></i></div>
                <div class="alert-text">
                      <strong>
                          <p class="mb-2">Instrucciones:</p>
                          <ul class="mb-0">
                              <li>Seleccione o escriba un periodo de tiempo para consultar los prestadores dentro de ese rango de fechas</li>
                          </ul>
                      </strong>
                </div>
            </div>

            <form method="POST" id="reimpresion_cartas_servicio_social">
            @method('post')
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <label for="rango_fechas" class="titulo-dato">Periodo (fecha inicio - fecha fin)</label>
                    <div class="input-daterange input-group">
                        <input type="text" class="form-control date-picker inputmk-fecha fecha-inicio" name="fecha_inicio" placeholder="FECHA DE INICIO" value=""  />
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="la la-ellipsis-h"></i></span>
                        </div>
                        <input type="text" class="form-control date-picker inputmk-fecha fecha-fin" name="fecha_fin" placeholder="FECHA DE FIN" value="" />
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="titulo-dato">&nbsp;&nbsp;&nbsp;</label>
                    <button type="button" id="btn_filtrar" name="btn_filtrar" class="btn btn-primary">
                        <i class="fas fa-search"></i> Buscar 
                    </button>
                    <button type="button" id="spinner_active" class="btn btn-primary spinner spinner-white spinner-right" disabled hidden>
                        <i class="fas fa-search"></i> Buscando... 
                    </button>
                </div>
            </div>
            
            <table class="table table-bordered table-general" id="tablaPrestadores" 
                data-ajax="datosPrestadores"
                data-toggle="table"
                data-toolbar="#toolbar"
                data-search="true"
                data-pagination="true"
                data-page-size="10"
                data-page-list="[10, 25, 50, 100]"
            >
                <thead>
                    <tr>
                        <th data-formatter="matriculaFormatter" class="text-center">
                            <label class="titulo-dato">Matrícula</label>
                        </th>
                        <th data-field="nombre_prestador_completo">
                            <label class="titulo-dato text-center">Nombre completo</label>
                        </th>
                        <th data-formatter="tipoServicioFormatter" class="text-center" >
                            <label class="titulo-dato">Tipo de servicio</label>
                        </th>
                        <th data-field="folio" class="text-center">
                            <label class="titulo-dato">Folio de servicio</label>
                        </th>
                        <th data-formatter="estatusServicioFormatter" class="text-center" >
                            <label class="titulo-dato">Estatus servicio</label>
                        </th>
                        <th data-formatter="descargarCartaInicioFormatter" class="text-center" >
                            <label class="titulo-dato"> Carta de inicio </label>
                        </th>
                        <th data-formatter="descargarCartaTerminoFormatter" class="text-center" >
                            <label class="titulo-dato"> Carta de termino </label>
                        </th>
                    </tr>
                </thead>
            </table>

            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        var URL_datosPrestadores = "{{ route('reimpresion.cartas') }}";
        var URL_descargarCartas = "{{ route('descargar.reimpresion.cartas') }}";
    </script>
    <script type="text/javascript">
        var date = new Date;
        $('.fecha-inicio').val(`01/01/${date.getFullYear()}`);
        $('.fecha-fin').val(`31/12/${date.getFullYear()}`);
    </script>
    <script src="{{ asset('js/p06_servicio_social/reportes/js_general_reportes.js') }}"></script>
    <script src="{{ asset('js/p06_servicio_social/reportes/reimpresionCartaServicioSocial.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
@endpush

@push('styles')
    <link href="{{ asset('metronic/plugins/custom/bootstraptable/css/bootstrap-table.min.css') }}" type="text/css" rel="stylesheet"/>
@endpush
