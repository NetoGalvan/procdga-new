@extends('layouts.main')

@section('title', 'Revisar horas por empleado')

@section('subheader')
    @include('layouts.partials.main.subheader', ["subheader" => [
        "titulo_subheader" => "PROCDGA",
        "icono_titulo_subheader" => "far fa-folder-open",
        "breadcrumbs" => [
            1 => [
                'activo' => false,
                'titulo' => 'Tareas Disponibles',
                'ruta' => Route('tareas')
            ],
            2 => [
                'activo' => true,
                'titulo' => 'Revisar horas por empleado'
            ]
        ]
    ]])
@endsection

@section('aside_menu')
    @include('layouts.partials.main.aside_menu', ["asideMenu" =>
        [
            "item_seleccionado" => "tareas",
        ]
    ])
@endsection

@push('styles')
	<link href="{{ asset('metronic/plugins/custom/bootstraptable/css/bootstrap-table.min.css') }}" type="text/css" rel="stylesheet"/>
@endpush

@section('contenido')
    <div class="mb-5 card card-custom">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">Detalle del proceso</h3>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 form-group">
                    <label class="titulo-dato"> Folio </label>
                    <span class="valor-dato">  {{ $pago->folio }} </span>
                </div>
                <div class="col-md-3 form-group">
                    <label class="titulo-dato"> Quincena </label>
                    <span class="valor-dato">  {{ $pago->quincena }} </span>
                </div>
                <div class="col-md-3 form-group">
                    <label class="titulo-dato"> Fecha Límite </label>
                    <span class="valor-dato">  {{ $pago->fecha_limite }} </span>
                </div>
                <div class="col-md-3 form-group">
                    <label class="titulo-dato"> Tipo </label>
                    <span class="valor-dato">  {{ $pago->tipo }} </span>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-5 card card-custom">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label user-select-none">Revisión y Autorización de las horas asignadas a los empleados.</h3>
            </div>
             @if ($finalizado == 0)
                <div class="card-toolbar">
                    <a type="button" id="reporte_general" class="btn btn-success" data-toggle="tooltip" title="Descargar reporte general"> <i class="fas fa-file-excel"></i> Descargar reporte general </a>
                </div>
            @endif
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-custom alert-danger" role="alert">
                        <div class="alert-icon"><i class="flaticon-warning"></i></div>
                        <div class="alert-text">
                            <p>IMPORTANTE: La fecha limite que tienen las áreas para agregar a sus empleados es hasta el día <b>{{$cadena_fecha}}.</b></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row py-5">
                <div class="col-md-12 mx-auto">

                    <table
                        id="table_tareas_activas"
                        data-unique-id="instancia_id"
                        class="text-center"
                        data-toggle="table"
                        data-data-field="data"
                        data-total-field="total"
                        data-pagination="true"
                        data-page-size="10"
                        data-search="false"
                        data-pagination-h-align="left"
                        data-pagination-detail-h-align="right"
                        data-search-align="right">
                        <thead>
                            <th data-field="instancia_id" data-visible="false">Id</th>
                            <th data-field="area" data-formatter="areaFormatter" data-align="center"><label class="titulo-dato">Área</label></th>
                            <th data-field="folio" data-align="center"><label class="titulo-dato">Folio</label></label></th>
                            <th data-field="model.estatus" data-formatter="estatusFormatter" data-align="center"><label class="titulo-dato">Estatus</label></label></th>
                            <th data-field="model.estatus" data-formatter="reporteFormatter" data-align="center"><label class="titulo-dato">Reporte</label></label></th>
                        </thead>
                    </table>

                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-md-12 text-center">

                    <form action="{{ route('tiempo.extraordinario.excedente.revision.por.empleado', [$pago, $instanciaTarea] ) }}" method="post" id="form_finalizar_proceso">
                        @method('post') @csrf
                        <button id="btn_terminar_proceso" type="button" class="btn btn-success"><i class="fas fa-check-square"></i>Finalizar proceso </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/p16_pago_tiempo_extraordinario_excedente/tareas/T02_revisionHoras.js?v=1.0.2') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
    <script>
        var subInstancias = @json($subInstancias);
        var urlDescargarReporteGeneral = "{{ route('tiempo.extraordinario.excedente.descarga.reporte.general') }}";
        var urlDescargarReporteIndividual = "{{ route('tiempo.extraordinario.excedente.descarga.reporte') }}";
        var folios = @json($folios);
        let mensajeError = @json($errors->has('mensaje_error') ? $errors->first('mensaje_error') : false);
    </script>
@endpush
