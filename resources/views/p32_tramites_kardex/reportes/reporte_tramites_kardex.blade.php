@extends('layouts.main')

@section('title', 'Trámites kardex - Reportes')

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
                'titulo' => 'Trámites kardex - Reportes'
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
        <form method="POST" id="form_filtro" action="{{ route('tramites.kardex.reporte.filtrar') }}" enctype="multipart/form-data">
            @method('post')
            @csrf
            <div class="row">
                <div class="form-group col-md-2 ">
                    <label for="buscar_en" class="titulo-dato">Buscar registros en</label>
                    <div class="radio-inline mt-5">
                        <label class="radio radio-rounded">
                            <input type="radio" checked="checked" name="buscar_por" id="local" value="local"/>
                            <span></span>
                            <b>LOCAL</b>
                        </label>
                        {{-- <label class="radio radio-rounded">
                            <input type="radio" name="buscar_por" id="historico" value="historico"/>
                            <span></span>
                            <b>HISTÓRICO</b>
                        </label> --}}
                    </div>
                </div>
                <div class="form-group col-md-3">
                    <label for="periodo" class="titulo-dato">Selecciona el tipo de trámite</label>
                    <select class="form-control form-control  normalizar-texto" name="tipo_tramite" id="tipo_tramite" required>
                        <option value="">Seleccione ...</option>
                        @foreach ($tipo_tramite as $key => $tipo)
                            <option value="{{$key}}">{{$tipo}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="periodo" class="titulo-dato">Selecciona el período</label>
                    <div class="input-daterange input-group" id="rango_de_fecha">
                        <input type="text" class="form-control" name="fecha_de" id="fecha_de" autocomplete="off" required/>
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                        </div>
                        <input type="text" class="form-control" name="fecha_a" id="fecha_a" autocomplete="off" required/>
                    </div>
                </div>
                <div class="col-md-2 form-group">
                    <label for="folio" class="titulo-dato">Folio</label>
                    <input type="text" class="form-control" id="folio" name="folio" placeholder="Folio" value="{{ old('folio') }}">
                </div>
                <div class="form-group col-md-2" id="estatus_new">
                    <label for="periodo" class="titulo-dato">Selecciona el estatus</label>
                    <select class="form-control form-control normalizar-texto" name="estatus_local" id="estatus_local" required>
                        <option value="">Seleccione ...</option>
                        @foreach ($estatusL as $key => $tipo)
                            <option value="{{$key}}">{{$tipo}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-2" style="display: none" id="estatus_old">
                    <label for="periodo" class="titulo-dato">Selecciona el estatus</label>
                    <select class="form-control form-control normalizar-texto" name="estatus_historico" id="estatus_historico" required>
                        <option value="">Seleccione ...</option>
                        @foreach ($estatusH as $key => $tipo)
                            <option value="{{$key}}">{{$tipo}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 form-group text-right">
                    <button type="button" id="btn_filtrar_reporte" name="btn_filtrar_reporte" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Filtrar"><i class="fas fa-search"></i> Filtrar solicitudes </button>
                </div>
                <div class="col-md-3 form-group">
                    <button type="button" id="btn_limpiar_filtro" name="btn_limpiar_filtro" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Limpira filtro"><i class="fas fa-brush"></i> Limpiar campos </button>
                </div>
            </div>
        </form>
        <div class="row mt-5">
            <div class="col-12 form-group">
                <table class="table table-bordered table-general" id="tablaTramitesKardex" data-toggle="table" data-toolbar="#toolbar" data-unique-id="id" data-pagination="true">
                    <thead>
                        <tr>
                            <th data-field="tipo_tramite_kardex_id" class="text-center" data-formatter="hojasServicioFormatter"><label class="titulo-dato"><b>Tramite</b></label></th>
                            <th data-field="folio" class="text-center"><label class="titulo-dato"><b>Folio</b></label></th>
                            <th data-field="nombre" class="text-center" data-formatter="nombreEmpleadoFormatter"><label class="titulo-dato"><b>Nombre empleado</b></label></th>
                            <th data-field="rfc" class="text-center"><label class="titulo-dato"><b>RFC</b></label></th>
                            <th data-field="curp" class="text-center"><label class="titulo-dato"><b>CURP</b></label></th>
                            <th data-field="" class="text-center" data-formatter="accionesFormatterServiciosSolicitados"><label class="titulo-dato"><b>&nbsp;&nbsp;&nbsp; Acciones &nbsp;&nbsp;&nbsp;</b></label></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 form-group">
                <a type="button" href="" id="btn_generar_reporte" name="btn_generar_reporte" onclick="generarReporte()" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Generar reporte"><i class="fas fa-file-excel"></i> Generar reporte </a>
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

@endsection

@push('styles')
    <link href="{{ asset('metronic/plugins/custom/bootstraptable/css/bootstrap-table.min.css') }}" type="text/css" rel="stylesheet"/>
@endpush

@push('scripts')
    <script>
        var urlGetHojasServicio = @json(route('reporte.procesos.tramites.kardex'));
        var urlImprimirDetalles = @json( route('descargar.reporte.detalles') );
        var urlImprimirSeguimientos = @json( route('descargar.reporte.seguimientos') );
        var urlGenerarReporteExcel = @json( route('descargar.reporte.general.kardex.excel') );
    </script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
    <script src="{{ asset('js/p32_tramites_kardex/reportes/reportes_tramites_kardex.js?ver=1.0') }}"></script>
@endpush
