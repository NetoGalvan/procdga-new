@extends('layouts.main')

@section('title', 'Captura de datos')

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
                'titulo' => 'Captura de datos'
            ]
        ]
    ]])
@endsection

@section('aside_menu')
    @include('layouts.partials.main.aside_menu', ["asideMenu" => ["item_seleccionado" => "tareas"]])
@endsection

@push('styles')
	<link href="{{ asset('metronic/plugins/custom/bootstraptable/css/bootstrap-table.min.css') }}" type="text/css" rel="stylesheet"/>
@endpush

@section('contenido')
	<div class="card card-custom mb-5">
		<div class="card-header">
			<div class="card-title">
				<h3 class="card-label">Captura de datos de nómina de prestación</h3>
			</div>
		</div>
		<div class="card-body">
			<div class="alert alert-custom alert-success fade show mb-5" role="alert">
				<div class="alert-icon"><i class="flaticon-warning"></i></div>
				<div class="alert-text">
					Capture los datos para la prestación: <b>{{$subProcesoPrestacion->tipoPrestacion->nombre}}</b> <br>
					Si ya está completa puede enviarla a aprobación por el Subdirector de Enlace Administrativo.
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
					<label class="titulo-dato"> Área: </label>
					<span><strong>{{ Auth::user()->area->identificador }} - {{Auth::user()->area->nombre }}</strong></span>
				</div>
				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
					<label class="titulo-dato"> Folio: </label>
					<span> <strong>{{ $subProcesoPrestacion->folio }}</strong></span>
				</div>
				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
					<label class="titulo-dato"> Tipo de prestación: </label>
					<span><strong>{{ $subProcesoPrestacion->tipoPrestacion->nombre }}</strong></span>
				</div>
				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
					<label class="titulo-dato"> Fecha límite: </label>
					<span><strong>{{ $subProcesoPrestacion->pagoPrestacion->fecha_limite }}</strong></span>
				</div>
				@if ($instanciaTarea->estatus == "RECHAZADO")
				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
					<label class="titulo-dato"> Estatus: </label>
					<span>RECHAZADO</span>
				</div>
				@endif
			</div>
			@if ($instanciaTarea->estatus == "RECHAZADO")
			<div class="row">
				<div class="col-12">
					<label class="titulo-dato"> Mensaje de rechazo: </label>
					<div class="alert alert-custom alert-danger" role="alert">
						{!! $subProcesoPrestacion->comentarios_rechazo !!}
					</div>
				</div>
			</div>
			@endif
		</div>
	</div>

	<div class="card card-custom mb-5">
		<div class="card-header">
			<div class="card-title">
				<h3 class="card-label">Instrucciones de la Jefatura de Prestaciones</h3>
			</div>
		</div>
		<div class="card-body">
			<div class="alert alert-custom alert-success fade show mb-5" role="alert">
				<div class="alert-icon"><i class="flaticon-warning"></i></div>
				<div class="alert-text">
					{{ $subProcesoPrestacion->pagoPrestacion->observaciones }}
				</div>
			</div>
		</div>
	</div>


	<form id="form_agregar_candidato">
		<div class="card card-custom mb-5">
			<div class="card-header">
				<div class="card-title">
					<h3 class="card-label">Agregar empleados</h3>
				</div>
			</div>
			<div class="card-body">
				@include("componentes.busqueda_empleado", [
                    "existeEmpleado" => false,
                ])
				<div class="row" id="formularioDatos"></div>
				<div class="row">
					<div class="col-md-12">
						<button
							type="button"
							class="btn btn-primary"
							id="btn_agregar_candidato"
							data-url="{{ route('pago.prestacion.agregar.candidato', $subProcesoPrestacion) }}">
							<i class="fas fa-plus"></i> Agregar candidato
						</button>
					</div>
				</div>
			</div>
		</div>
	</form>
	<form method="POST" action="{{route('pago.prestacion.capturar.candidatos', [$subProcesoPrestacion, $instanciaTarea])}}" id="form_finalizar_tarea">
		@csrf
		<div class="card card-custom" id="busquedaLLenadoDatos">
			<div class="card-header">
				<div class="card-title">
					<h3 class="card-label">Instrucciones del enlace administrativo(*) y registros actuales </h3>
				</div>
			</div>
			<div class="card-body">
				<table
					class="table text-center"
					id="table_reg_candidatos"
                    data-unique-id="candidato_prestacion_id"
					data-toggle="table">
					<thead>
						<tr>
							<th data-field="numero_empleado"><label class="titulo-dato">No. Empleado</label></th>
							<th data-field="nombre_empleado"><label class="titulo-dato">Nombre</label></th>
							<th data-field="apellido_paterno"><label class="titulo-dato">Apellido Paterno</label></th>
							<th data-field="apellido_materno"><label class="titulo-dato">Apellido Materno</label></th>
							{{-- <th data-field="identificador_unidad"><label class="titulo-dato">Unidad Administrativa</label></th> --}}
							<th data-field="rfc"><label class="titulo-dato">RFC</label></th>
							<th data-field="curp"><label class="titulo-dato">CURP</label></th>
							<th data-field="seccion_sindical"><label class="titulo-dato">Seccion Sindical</label></th>
							@foreach ($subProcesoPrestacion->estructura_concurrente as $field)
								<th data-field="campos_adicionales.{{ $field->name }}"><label class="titulo-dato"> {{ $field->desc }} </label></th>
							@endforeach
                            <th data-formatter="eliminarFormatter"><label class="titulo-dato">Acciones</label></th>
						</tr>
					</thead>
				</table>
			</div>
			<div class="card-footer">
                <div class="text-center">
                    <button type="submit" class="btn btn-success"><i class="fas fa-check-square"></i> Finalizar tarea</button>
                </div>
            </div>
		</div>
	</form>
@endsection

@push('scripts')
	<script>
        const urlEliminar = @json( route('eliminar.registro.st01') );
		const fieldsPrestacion = @json($subProcesoPrestacion->estructura_concurrente);
		const candidatos = @json($subProcesoPrestacion->candidatos);
        const sexos = @json($sexos)
	</script>
	<script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
	<script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
	<script src="{{ asset('js/componentes/busqueda_empleado.js') }}"></script>
	<script src="{{ asset('js/p07_pago_prestaciones/ST01_capturarCandidatos.js') }}"></script>
@endpush
