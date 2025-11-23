@extends('layouts.main')

@section('title', 'Asignación de horas')

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
                'titulo' => 'Asignación de horas'
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
                    <label class="titulo-dato"> Subárea </label>
                    <span class="valor-dato"> {{ $presuQuinceSubarea->area->identificador }} - {{ $presuQuinceSubarea->area->nombre }} </span>
                </div>
                <div class="col-md-6 form-group">
                    <label class="titulo-dato"> Presupuesto asignado </label>
                    <span class="valor-dato">  ${{ $presuQuinceSubarea->presupuesto_sub_area }} </span>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-5 card card-custom">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">Asignación de horas por empleado</h3>
            </div>
        </div>
        <div class="card-body">
            @if($instanciaTarea->estatus == 'EN_CORRECCION')
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-custom alert-danger" role="alert">
                            <div class="alert-icon"><i class="flaticon-warning"></i></div>
                            <div class="alert-text">
                                <h5 class="text-center"><b> La tarea ha sido rechazada </b></h5><br>
                                <h4 class="text-center"><b> Motivo: </b> {{$presuQuinceSubarea->motivo_rechazo}} </h4>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-custom alert-danger" role="alert">
                        <div class="alert-icon"><i class="flaticon-warning"></i></div>
                        <div class="alert-text">
                            <p>IMPORTANTE: Recuerda que tienes hasta el día <b>{{$cadena_fecha}}</b> para agregar a los empleados y asignarles sus horas extra</p>
                        </div>
                    </div>
                </div>
            </div>
            <form id="agregarEmpleadoForm" name="agregarEmpleadoForm" onsubmit="agregarEmpleado()" method="post">
                <input type="hidden" value="{{ $subPago->instancia->instanciasTareas->first()->pertenece_al_area }}" name="area_id">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="titulo-dato"><span class="requeridos">*</span> Tipo </label>
                            <select class="form-control custom-select" name="tipo" id="tipo">
                                <option value="EXTRAORDINARIO" selected>EXTRAORDINARIO</option>
                                <option value="EXCEDENTE">EXCEDENTE</option>
                            </select>
                        </div>
                    </div>
                </div>
            </form>
            <form action="{{ route('validar.empleado.premio.p16') }}"  method="POST" id="form_busqueda_empleado">
                @method('post') @csrf
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            @include("componentes.busqueda_empleado", [
                                "existeEmpleado" => false,
                            ])
                        </div>
                    </div>
                </div>
                <button type="button" id="btn_buscar_empleado" name="btn_buscar_empleado" class="btn btn-primary btn_buscar_empleado mb-5" ><i class="fas fa-plus"></i> Agregar </button>
            </form>

            <form action="" name="asignarHorasForm" id="asignarHorasForm" class="form" method="post">
                <input type="hidden" id="subproceso_id" name="subproceso_id" value="{{ $subPago->subproceso_pago_tiempo_extra_excedente_id }}" />
                <input type="hidden" id="presu_quince_subarea_id" name="presu_quince_subarea_id" value="{{ $presuQuinceSubarea->p16_presupuesto_quincenal_subareas_id }}" />
                <input type="hidden" id="folio" name="folio" class="form-control form-control-solid" value="{{ $subPago->folio }}" />
                <input type="hidden" id="pago_id" name="pago_id" class="form-control form-control-solid" value="{{ $procesoPago->pago_tiempo_extra_excedente_id }}" />
                @foreach ($empleadosAgregados as $empleado)
                    <input type="hidden" name="horas_empleado_id[]" value="{{ $empleado->horas_empleado_id }}">
                @endforeach

                <table
                    id="tabla_asignar_horas"
                    data-unique-id="horas_empleado_id"
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
                        <th data-field="horas_empleado_id" data-visible="false">Id</th>
                        <th data-field="unidad_administrativa_nombre" data-align="center"><label class="titulo-dato">Área</label></th>
                        <th data-field="rfc" data-align="center"><label class="titulo-dato">RFC</label></th>
                        <th data-field="nombre" data-formatter="nombreFormatter" data-align="center"><label class="titulo-dato">Nombre</label></th>
                        <th data-field="nivel_salarial" data-align="center"><label class="titulo-dato">Nivel Salarial</label></th>
                        <th data-field="sindicalizado" data-align="center"><label class="titulo-dato">Sindicalizado</label></th>
                        <th data-field="tipo" data-align="center"><label class="titulo-dato">Tipo Pago</label></th>
                        <th data-field="horas" data-formatter="horasFormatter" data-align="center"><label class="titulo-dato"><span class="requeridos">*</span> Horas </label></label></th>
                        <th data-field="monto" data-formatter="montoFormatter" data-align="center"><label class="titulo-dato"><span class="requeridos">*</span> Monto Bruto </label></label></th>
                        <th data-field="observaciones" data-formatter="observacionesFormatter" data-align="center"><label class="titulo-dato">Observaciones</label></th>
                        <th data-field="acciones" data-formatter="eliminarFormatter" data-align="center"><label class="titulo-dato">Acciones</label></th>

                    </thead>
                </table>

            </form>
        </div>
        <div class="card-footer">
            <div class="row text-center">
                <div class="col-lg-12">
                    <form action="{{ route('tiempo.extraordinario.excedente.horas.por.empleado', [$subPago, $instanciaTarea] ) }}" method="post" id="form_finalizar_tarea">
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
    let empleadosAgregados = @json($empleadosAgregados);
    let presuQuinceSubarea = @json($presuQuinceSubarea);
    let instanciaTarea = @json($instanciaTarea);
    let agregarEmpleadoRoute = "{{ route('tiempo.extraordinario.excedente.agregar.empleado') }}";
    let calcularMontoRoute = "{{ route('tiempo.extraordinario.excedente.calcular.monto.bruto') }}";
    var guardarDatosAutomaticamente = "{{ route('tiempo.extraordinario.excedente.guardar.empleado.automaticamente') }}";
    let guardarObservacionesAutomaticamente = "{{ route('tiempo.extraordinario.excedente.guardar.observaciones.automaticamente') }}";
    var borrarEmpleadoAreaRoute = "{{ route('tiempo.extraordinario.excedente.borrar.empleado') }}";
    var urlValidarEmpleadoP16 = @Json( route('validar.empleado.premio.p16') );
</script>
<script src="{{ asset('js/p16_pago_tiempo_extraordinario_excedente/tareas/ST02_asignarHorasEmpelados.js?v=1.0.5') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
    <script src="{{ asset('js/componentes/busqueda_empleado.js') }}"></script>
@endpush
