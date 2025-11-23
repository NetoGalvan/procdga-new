@extends('layouts.main')

@section('title', 'SERVICIO SOCIAL - REPORTES - PRESTADORES POR UNIDAD ADMINISTRATIVA')

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
                'titulo' => 'SERVICIO SOCIAL - REPORTES - PRESTADORES POR UNIDAD ADMINISTRATIVA'
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
                <h3 class="card-label">Reporte de prestadores por unidad administrativa.</h3>
            </div>
        </div>
        <div class="card-body">
            <div class="alert alert-custom alert-success" role="alert">
                <div class="alert-icon"><i class="flaticon-warning"></i></div>
                <div class="alert-text">
                      <strong>
                          <p class="mb-2">Instrucciones:</p>
                          Antes de generar el reporte en caso de ser necesario verifique lo siguiente 
                          <ul class="mb-0">
                              <li>Seleccionar un área</li>
                              <li>Seleccionar el año, este hace referencia al año en que los prestadores iniciaron su servicio</li>
                              <li>Seleccionar el estatus en que se encuentran los prestadores</li>
                          </ul>
                      </strong>
                </div>
            </div>

            <form method="POST" id="prestadores_por_unidad_admin_form">
            @method('post')
            @csrf
                <div class="row">
                    <div class="col-md-5 form-group">
                        <label for="area_id" class="titulo-dato">Área</label>
                        <select class="form-control select-pk" name="area_id" id="area_id" autocomplete="off">
                            <option value=""> SELECCIONE UNA OPCIÓN</option>
                            @foreach ($areas as $area)
                                <option value="{{ $area->identificador }}" > {{ $area->identificador }}  -  {{ $area->nombre }} </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="anio_busqueda" class="titulo-dato">Año</label>
                        <input type="text" id="anio_busqueda" name="anio_busqueda" class="form-control year-picker cursor-pointer" readonly value="{{ date("Y") }}" autocomplete="off">
                    </div>

                    <div class="col-md-3">
                        <label class="titulo-dato" for="">Estatus</label>
                        <select class="form-control normalizar-texto selectpicker" id="estatus" name="estatus">
                            <option value="" selected disabled>Seleccione una opción</option>
                            @foreach ($estatus as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="ml-4 mr-4 text-center">
                        <button type="button" id="btn_filtrar" name="btn_filtrar" class="btn btn-primary">
                            <i class="fas fa-search"></i> Buscar 
                        </button>
                        <button type="button" id="spinner_active" class="btn btn-primary spinner spinner-white spinner-right" disabled hidden>
                            <i class="fas fa-search"></i> Buscando... 
                        </button>
                    </div>
                    <div class="ml-4 mr-4 text-center">
                        <button type="button" id="btn_limpiar" name="btn_limpiar" class="btn btn-warning">
                            <i class="fas fa-brush"></i> Limpiar 
                        </button>
                        <button type="button" id="spinner_active_02" class="btn btn-warning spinner spinner-white spinner-right" disabled hidden>
                            <i class="fas fa-brush"></i> Restableciendo... 
                        </button>
                    </div>
                    <div class="ml-4 mr-4 text-center">
                        <button type="button" id="btn_reporte" name="btn_reporte" class="btn btn-danger">
                            <i class="fas fa-file-pdf"></i> Generar reporte 
                        </button>
                    </div>
                </div>
                <hr>
                <table class="table table-bordered table-general" id="tablaPrestadoresPorUnidad" 
                    data-ajax="prestadoresPorUnidad"
                    data-toggle="table"
                    data-toolbar="#toolbar"
                    data-pagination="true"
                    data-page-size="10"
                    data-page-list="[10, 25, 50, 100]"
                >
                    <thead>
                        <tr>
                            <th data-field="nombre_unidad_administrativa">
                                <label class="titulo-dato text-center">Unidad administrativa</label>
                            </th>
                            <th data-field="folio" class="text-center">
                                <label class="titulo-dato">Folio de servicio</label>
                            </th>
                            <th data-field="nombre_prestador_completo">
                                <label class="titulo-dato text-center">Prestador</label>
                            </th>
                            <th data-formatter="tipoServicioFormatter" class="text-center" >
                                <label class="titulo-dato">Tipo de servicio</label>
                            </th>
                            <th data-formatter="estatusServicioFormatter" class="text-center" >
                                <label class="titulo-dato">Estatus servicio</label>
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
        var URL_prestadoresPorUdAdmin = "{{ route('reporte.prestadores.por.unidad.administrativa') }}";
    </script>
    <script src="{{ asset('js/p06_servicio_social/reportes/js_general_reportes.js') }}"></script>
    <script src="{{ asset('js/p06_servicio_social/reportes/prestadoresPorUnidadAdministrativa.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
@endpush

@push('styles')
    <link href="{{ asset('metronic/plugins/custom/bootstraptable/css/bootstrap-table.min.css') }}" type="text/css" rel="stylesheet"/>
@endpush
