@extends('layouts.main')

@section('title', 'Asignar presupuesto a subáreas')

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
                'titulo' => 'Asignar presupuesto a subáreas'
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
                    <span class="valor-dato">  {{ $subPago->folio }} </span>
                </div>
                <div class="col-md-3 form-group">
                    <label class="titulo-dato"> Quincena </label>
                    <span class="valor-dato">  {{ $subPago->pagoTiempoExtra->quincena }} </span>
                </div>
                <div class="col-md-3 form-group">
                    <label class="titulo-dato"> Fecha Límite </label>
                    <span class="valor-dato">  {{ $subPago->fecha_limite }} </span>
                </div>
                <div class="col-md-3 form-group">
                    <label class="titulo-dato"> Tipo </label>
                    <span class="valor-dato">  {{ $subPago->pagoTiempoExtra->tipo }} </span>
                </div>
                <div class="col-md-6 form-group">
                    <label class="titulo-dato"> Área </label>
                    <span class="valor-dato">  {{ $subPago->area->identificador }} - {{ $subPago->area->nombre }} </span>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-5 card card-custom">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">Asigna los presupuestos a las subáreas correspondientes</h3>
            </div>
        </div>
        <div class="card-body">
            <div class="row mb-5">
                <div class="col-md-12">
                    <label class="titulo-dato" for="presupuestoAsignado">Presupuesto asignado para esta área ({{ Auth::user()->area->nombre }})</label>
                    <span class="valor-dato"> ${{ $datosPresupuestoEstaUnidad->presupuesto }} </span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-custom alert-danger" role="alert">
                        <div class="alert-icon"><i class="flaticon-warning"></i></div>
                        <div class="alert-text">
                            <p>IMPORTANTE: Las áreas y subáreas que dejes sin capturar, no se les generará la tarea para asignar horas a los empleados y debes asignar presupuesto al menos a una subárea </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 form-group">

                    <table
                        id="tabla_presupuesto_areas"
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
                            <th data-field="presupuesto" data-formatter="presupuestoFormatter" data-align="center"><label class="titulo-dato">Presupuesto</label></th>
                        </thead>
                    </table>

                </div>
            </div>

        </div>
        <div class="card-footer">
            <div class="row text-center">
                <div class="col-lg-12">
                    <form action="{{ route('tiempo.extraordinario.excedente.asignacion.presupuesto.areas', [$subPago, $instanciaTarea] ) }}" method="post" id="form_finalizar_tarea">
                        @method('post') @csrf
                        <button id="finalizarTarea" type="button" class="btn btn-success"><i class="fas fa-check-square"></i>Finalizar tarea </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('scripts')
<script>
    let urlAsignarPresupuesto = "{{ route('tiempo.extraordinario.excedente.asignar.presupuesto.sub.areas') }}";
    var subProceso = @json($subPago);
    let mensajeError = @json($errors->has('mensaje_error') ? $errors->first('mensaje_error') : false);
    var subAreas = @json($subAreas);
    var presupuestoTotal = @json($datosPresupuestoEstaUnidad->presupuesto);
</script>
<script src="{{ asset('js/p16_pago_tiempo_extraordinario_excedente/tareas/ST01_asignarPresupuestoAreas.js?v=1.0.5') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
    <script src="{{ asset('js/componentes/busqueda_empleado.js') }}"></script>
@endpush
