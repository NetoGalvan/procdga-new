@extends('layouts.main')

@section('title', 'SERVICIO SOCIAL - REPORTES - REPORTE DE INSTITUCIONES, ESCUELAS Y PROGRAMAS')

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
                'titulo' => 'SERVICIO SOCIAL - REPORTES - REPORTE DE INSTITUCIONES, ESCUELAS Y PROGRAMAS'
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
    <form method="POST" id="instituciones_escuelas_programas_form">
    @method('post')
    @csrf
        <div class="card card-custom mb-5">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Reporte de Instituciones, Escuelas y Programas. </h3>
                </div>
            </div>
            <div class="card-body">
                <div class="alert alert-custom alert-success" role="alert">
                    <div class="alert-icon"><i class="flaticon-warning"></i></div>
                    <div class="alert-text">
                          <strong>
                              <p class="mb-2">Instrucciones:</p>
                              <ul class="mb-0">
                                  <li>Antes de generar el reporte verifique que la opción seleccionada se la correcta</li>
                              </ul>
                          </strong>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <label class="titulo-dato" for=""><span class="requeridos">* </span>Seleccione una opción</label>
                        <select class="form-control form-control-sm normalizar-texto opciones" id="opciones" name="opciones">
                            <option value="" disabled>Seleccione una opción</option>
                                @foreach ($opciones as $opc)
                                    <option value="{{ $opc }}" {{($opc == 'ESCUELAS') ? 'selected' : ''}}>{{ $opc }}</option>
                                @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="m-4 text-center">
                        <button type="button" id="btn_filtrar" name="btn_filtrar" class="btn btn-primary"><i class="fas fa-search"></i> Buscar </button>
                    </div>
                    <div class="m-4 text-center">
                        <button type="button" id="btn_reporte" name="btn_reporte" class="btn btn-danger"><i class="fas fa-file-pdf"></i> Generar reporte </button>
                    </div>
                </div>
                <hr>
                <table class="table table-bordered table-general" id="tabla_IEP"
                    data-ajax="tablaIEP"
                    data-toggle="table"
                    data-toolbar="#toolbar"
                    data-pagination="true"
                    data-page-size="10">
                    <thead>
                        <tr>
                            <th data-formatter="nombreIEPFormatter">
                                <label class="titulo-dato text-center">Nombre</label>
                            </th>
                            <th data-field="acronimo" data-formatter="acronimoIEPFormatter" class="text-center">
                                <label class="titulo-dato AON">Acronimo</label>
                            </th>
                            <th data-formatter="claveODirIEPFormatter" class="text-center">
                                <label class="titulo-dato COD">Dirección</label>
                            </th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script type="text/javascript">
        var URL_reporteIEP = "{{ route('reporte.instituciones.escuelas.programas') }}";
    </script>
    <script src="{{ asset('js/p06_servicio_social/reportes/institucionesEscuelasProgramas.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
@endpush

@push('styles')
    <link href="{{ asset('metronic/plugins/custom/bootstraptable/css/bootstrap-table.min.css') }}" type="text/css" rel="stylesheet"/>
@endpush
