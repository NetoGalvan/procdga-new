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
                <div class="col-md-6">
                    <label class="titulo-dato"> Área </label>
                    <span class="valor-dato">  {{ $premioPuntualidad->area->identificador }} - {{ $premioPuntualidad->area->nombre }} </span>
                </div>
                <div class="col-md-6">
                    <label class="titulo-dato"> Folio </label>
                    <span class="valor-dato">  {{ $premioPuntualidad->instancia->folio }} </span>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-md-12">
                    <div class="alert alert-custom alert-success" role="alert">
                        <div class="alert-icon"><i class="flaticon-warning"></i></div>
                        <div class="alert-text">
                            <h5 class="card-label">Instrucciones</h5>
                            <p>
                                <ol>
                                    <li>Seleccione la quincena de pago del premio de puntualidad y asistencia.</li>
                                    <li>Elija las áreas que desea incluir en el proceso.</li>
                                    <li>Escriba en el área de instrucciones las fechas límite del cierre del proceso de premio de puntualidad y asistencia.</li>
                                </ol>
                            </p>
                            <b> NOTA: Las áreas que no cuenten con usuario con rol: ENLACE ADMINISTRATIVO no serán listadas.</b>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('seleccion.quincena.unidades.administrativas', [$premioPuntualidad, $instanciaTarea] ) }}"  method="POST" id="frm_seleccion_quincena">
        @method('post') @csrf
        <div class="card card-custom mb-5">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Áreas</h3>
                </div>
            </div>
            <input type="hidden" name="areas" id="areas"/>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 align-middle">
                        <div class="form-group">
                            <table
                                id="tabla_premio_puntualidad"
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
                                    <th data-field="areas" data-formatter="areasFormatter" data-align="center"><label class="titulo-dato">Áreas</label></th>
                                    {{-- <th data-field="presupuesto" data-formatter="presupuestoFormatter" data-align="center"><label class="titulo-dato">Premio</label></th> --}}
                                </thead>
                            </table>
                            <div class="row mt-5">
                                <div class="col-md-4 align-middle">
                                    <div class="form-group">
                                        <label class="titulo-dato" for=""><strong><span class="requeridos">*</span>Seleccione la quincena</strong></label>
                                        <select class="form-control normalizar-texto" name="fecha_quincena" id="fecha_quincena" value="{{old('fecha_quincena')}}" required>
                                            <option value="">Seleccione la quincena</option>
                                            @php
                                            use Carbon\Carbon;
                                            @endphp
                                            @foreach (traerQuincenasActual(Carbon::now()->subMonth(), Carbon::now()->addDays(45)) as $quincena)
                                                <option class="normalizar-texto" value="{{ $quincena }}">{{ $quincena }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label class="titulo-dato" for=""><strong><span class="requeridos">*</span>Instrucciones</strong></label>
                                        <textarea rows="5" class="form-control normalizar-texto" autocomplete="off" name="instrucciones" id="instrucciones" value="{{old('instrucciones')}}" required></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="text-center">
                    <button type="button" class="btn btn-danger mr-2" id="btn_cancelar_proceso"><i class="fas fa-trash"></i>Cancelar proceso</button>
                    <button type="button" class="btn btn-success" id="btn_finalizar" ><i class="fas fa-check-square"></i>Finalizar tarea</button>
                </div>
            </div>

        </div>

    </form>

@endsection

@push('styles')
	<link href="{{ asset('metronic/plugins/custom/bootstraptable/css/bootstrap-table.min.css') }}" type="text/css" rel="stylesheet"/>
@endpush

@push('scripts')
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
    <script src="{{ asset('js/p20_premio_puntualidad_asistencia/tareas/TPPA01_seleccionQuincena.js?v=1.0.5') }}"></script>
    <script>
        let areasQueParticipan = @json($areasQueParticipan);
        let mensajeError = @json($errors->has('mensaje_error') ? $errors->first('mensaje_error') : false);
    </script>
@endpush
