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
            <div class="row mb-5">
                <div class="col-md-12">
                    <div class="alert alert-custom alert-success" role="alert">
                        <div class="alert-icon"><i class="flaticon-warning"></i></div>
                        <div class="alert-text">
                            <p>
                                Se ha lanzado el proceso de pago del premio de puntualidad y asistencia:
                                <ol>
                                    <li>Atienda a los comentarios del Jefe de Unidad Departamental de Nóminas.</li>
                                    <li>Dé indicaciones precisas a sus operadores de premio de puntualidad y asistencia.</li>
                                </ol>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <label class="titulo-dato"> Área </label>
                    <span class="valor-dato">  {{ $subproceso->area->identificador }} - {{ $subproceso->area->nombre }} </span>
                </div>
                <div class="col-md-4">
                    <label class="titulo-dato"> Folio </label>
                    <span class="valor-dato">  {{ $subproceso->folio }} </span>
                </div>
                <div class="col-md-4">
                    <label class="titulo-dato"> Quincena de pago </label>
                    <span class="valor-dato"> {{ $subproceso->quincena }} </span>
                </div>
                <div class="col-md-12">
                    <label class="titulo-dato"> Instrucciones </label>
                    <span class="valor-dato">  {{ $subproceso->premioPuntialidad->instrucciones }} </span>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('captura.instrucciones.proceso', [$subproceso, $instanciaTarea] ) }}" id="frm_captura_instrucciones" method="post">
        @method('post') @csrf
        <div class="card card-custom mb-5">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Áreas</h3>
                </div>
            </div>
            <input type="hidden" name="subareas" id="subareas"/>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 align-middle">
                        <div class="form-group">
                            <div class="col-md-12">
                                <table
                                    id="tabla_premio_puntualidad_subproceso"
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
                                        <th data-field="state" data-checkbox="true"></th>
                                        <th data-field="area_id" data-visible="false">Id</th>
                                        <th data-field="areas" data-formatter="areasFormatter" data-align="center"><label class="titulo-dato">Área</label></th>
                                    </thead>
                                </table>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="titulo-dato" for=""><span class="requeridos">* </span>Instrucciones</label>
                                    <textarea rows="5" class="form-control normalizar-texto" autocomplete="off" name="instrucciones" id="instrucciones" value="{{old('instrucciones')}}" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="text-center">
                    <button type="button" id="btn_finalizar_subtarea" class="btn btn-success"><i class="fas fa-check-square"></i>Finalizar tarea</button>
                </div>
            </div>
        </div>
    </form>

@endsection

@push('styles')
    <link href="{{ asset('metronic/plugins/custom/bootstraptable/css/bootstrap-table.min.css') }}" type="text/css" rel="stylesheet"/>
@endpush

@push('scripts')
    <script src="{{ asset('js/p20_premio_puntualidad_asistencia/tareas/STPPA01_capturaInstrucciones.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
    <script>
        let mensajeError = @json($errors->has('mensaje_error') ? $errors->first('mensaje_error') : false);
        let areasQueParticipan = @json($areasQueParticipan);
    </script>
@endpush
