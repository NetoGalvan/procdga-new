@extends('layouts.main')

@section('title', $instanciaTarea->tarea->nombre)

@section('aside_menu')
    @include('layouts.partials.main.aside_menu', ["asideMenu" =>
        [
            "item_seleccionado" => "tareas",
        ]
    ])
@endsection

@section('subheader')
    @include('layouts.partials.main.subheader', ["subheader" => [
        "titulo_subheader" => "PROCDGA",
        "icono_titulo_subheader" => "far fa-folder-open",
        "breadcrumbs" => [
            1 => [
                'activo' => false,
                'titulo' => 'Tareas',
                'ruta' => Route('tareas')
            ],
            2 => [
                'activo' => true,
                'titulo' => $instanciaTarea->tarea->nombre
            ]
        ]
    ]])
@endsection

@section('contenido')

    <div class="card card-custom mb-5">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">Detalle del proceso</h3>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <label class="titulo-dato"> Área </label>
                    <span class="valor-dato">  {{ $premioPuntualidad->area->identificador }} - {{ $premioPuntualidad->area->nombre }} </span>
                </div>
                <div class="col-md-4">
                    <label class="titulo-dato"> Folio </label>
                    <span class="valor-dato">  {{ $premioPuntualidad->folio }} </span>
                </div>
                <div class="col-md-4">
                    <label class="titulo-dato"> Quincena de pago </label>
                    <span class="valor-dato"> {{ $premioPuntualidad->quincena }} </span>
                </div>
                <div class="col-md-12">
                    <label class="titulo-dato"> Instrucciones </label>
                    <span class="valor-dato">  {{ $premioPuntualidad->instrucciones }} </span>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-custom mb-5">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">Áreas</h3>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-custom alert-success" role="alert">
                        <div class="alert-icon"><i class="flaticon-warning"></i></div>
                        <div class="alert-text">
                            <p>
                                Se muestra el listado de las áreas incluídas en este proceso de pago de premio de puntualidad y asistencia. <br>
                                Recuerde que aquellas áreas con estado "EN PROCESO" <b> NO SERÁN INCLUIDAS </b> en la nómina para el pago de premio de puntualidad y asistencia. <br>
                                Las áreas con estado "COMPLETADO" ya completaron sus capturas.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">

                    <table
                        id="tabla_subproceso"
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
                            <th data-field="area_id" data-visible="false">Id</th>
                            <th data-field="areas" data-formatter="areasFormatter" data-align="center"><label class="titulo-dato">Áreas</label></th>
                            <th data-field="estatus" data-formatter="estatusFormatter" data-align="center"><label class="titulo-dato">Estatus</label></th>
                            <th data-field="estatus" data-formatter="reporteFormatter" data-align="center"><label class="titulo-dato">Reporte</label></th>
                        </thead>
                    </table>

                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="text-center">
                <form action="{{ route('concentrado.revision.solicitudes', [$premioPuntualidad, $instanciaTarea]) }}"  method="POST" id="form_concentrado_solicitudes">
                    @method('post') @csrf
                    <input type="hidden" name="avance_subprocesos" id="avance_subprocesos">
                    <button type="button" id="btn_finalizar" class="btn btn-success"><i class="fas fa-check-square"></i>Finalizar tarea</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/p20_premio_puntualidad_asistencia/tareas/TPPA02_concentradoRevision.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
    <script>
        let subprocesos = @json($subprocesos);
        let urlReporteArea = @json(route('premio.puntualidad.asistencia.descarga.reporte.area'));
    </script>
@endpush

@push('styles')
    <link href="{{ asset('metronic/plugins/custom/bootstraptable/css/bootstrap-table.min.css') }}" type="text/css" rel="stylesheet"/>
@endpush
