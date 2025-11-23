@extends('layouts.main')

@section('title', 'Archivos para el ISSSTE')

@section('subheader')
    @include('layouts.partials.main.subheader', ["subheader" => [
        "titulo_subheader" => "Archivos para el ISSSTE",
        "icono_titulo_subheader" => "far fa-folder-open",
        "breadcrumbs" => [
            1 => [
                "activo" => false,
                "titulo" => 'Archivos externos',
                "ruta" => route("archivos.externos")
            ],
            2 => [
                "activo" => true,
                "titulo" => 'Archivos para el ISSSTE'
            ]
        ]
    ]])
@endsection

@section('aside_menu')
    @include('layouts.partials.main.aside_menu', ["asideMenu" =>
        [
            "item_seleccionado" => "archivos-externos",
        ]
    ])
@endsection

@push('styles')
    <link href="{{ asset('metronic/plugins/custom/bootstraptable/css/bootstrap-table.min.css') }}" type="text/css" rel="stylesheet"/>
@endpush

@section('contenido')
    @if (count($tramitesIsssteSeparados) == 0)
    <div class="row">
        <div class="col-md-6 col-xl-4 mb-8">
            <div class="card card-custom wave wave-animate-slower mb-0" style="height: 130px;">
                <div class="card-body">
                    <div class="row" style="height: 100%;">
                        <div class="col-3 d-flex justify-content-center align-items-center">
                            <i class="fas fa-times-circle icon-4x icon-finanzas"></i>
                        </div>
                        <div class="col-9 d-flex align-items-center">
                            <h5 class="text-dark font-weight-bold font-size-h6"> Por el momento no hay archivos para enviar al ISSSTE. </h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="card" >
        <div class="card-body">
            <div class="table-responsive">
                <table
                    id="tabla_archivos_issste"
                    class="table-general"
                    data-search="true"
                    data-unique-id="tramite_issste_id"
                    data-toggle="table"
                    data-pagination="true"
                    data-pagination-h-align="left"
                    data-pagination-detail-h-align="right"
                    data-page-size="5">
                    <thead>
                        <tr>
                            {{-- <th data-field="tramite_issste_id" class="text-center"><label class="titulo-dato">ID</label></th> --}}
                            <th data-field="instancia_id" class="text-center"><label class="titulo-dato">Instancia</label></th>
                            <th data-field="registros" class="text-center"><label class="titulo-dato">Total de Registros</label></th>
                            <th data-field="tipo_movimiento_issste" class="text-center" data-formatter="acccionesFormatterTipoDeMovimiento"><label class="titulo-dato">Tipo de Movimiento</label></th>
                            <th data-field="qna_issste" class="text-center"><label class="titulo-dato">Qna ISSSTE</label></th>
                            <th data-field="folio" class="text-center"><label class="titulo-dato">Folio</label></th>
                            <th data-field="acciones" class="text-center" data-formatter="acccionesFormatterDescargarExcelIssste"><label class="titulo-dato">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Acciones &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    @endif
@endsection

@push('scripts')
    <script>
        var archivosIssste = @json($tramitesIsssteSeparados);
        var urlDescargarArchivosIssste = @json( route('descargar.archivos.para.issste') );
    </script>
    <script src="{{ asset('js/p02_tramites_issste/archivos_issste/archivos_issste.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
@endpush
