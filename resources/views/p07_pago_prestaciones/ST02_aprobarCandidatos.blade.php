@extends('layouts.main')

@section('title', 'Aprobar candidatos')

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
                'titulo' => 'Aprobar candidatos'
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
<div class="card card-custom mb-5">
	<div class="card-header">
		<div class="card-title">
			<h3 class="card-label">Datos generales</h3>
		</div>
	</div>
	<div class="card-body">
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
		</div>
	</div>
</div>
<div class="card card-custom mb-5" id="busquedaLLenadoDatos">
	<div class="card-header">
		<div class="card-title">
			<h3 class="card-label">Nómina</h3>
		</div>
	</div>
	<div class="card-body">
		<p> Esta es la nómina generada para el pago de prestación <span class="text-uppercase"> {{ $subProcesoPrestacion->tipoPrestacion->nombre }}.</span> </p>
		<table
			class="table text-center"
			id="table_reg_candidatos"
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
				</tr>
			</thead>
		</table>
	</div>
</div>

<form method="POST" id="form_finalizar_tarea" action="{{route('pago.prestacion.aprobar.candidatos', [$subProcesoPrestacion, $instanciaTarea])}}">
	@csrf
	<div class="card card-custom">
		<div class="card-header">
			<div class="card-title">
				<h3 class="card-label">Aprobación</h3>
			</div>
		</div>
		<div class="card-body">
			<div class="alert alert-custom alert-success show mb-5" role="alert">
				<div class="alert-icon"><i class="flaticon-warning"></i></div>
				<div class="alert-text">
					Revise cuidadosamente los datos de las personas que
					serán incluídas en el pago de la prestación. Si los datos son
					correctos serán enviados a la Jefatura de Unidad Departamental de
					Prestaciones para su trámite.
				</div>
			</div>
			<div class="form-group row">
				@if (is_null($subProcesoPrestacion->estatus_aprobacion))
				<label class="col-2 col-form-label">Aprobar nómina</label>
				<div class="col-3">
					<span class="switch switch-outline switch-icon switch-success">
						<label>
							<input type="checkbox" checked="checked" name="estatus_aprobacion" id="estatus_aprobacion" autocomplete="off"/>
							<span></span>
						</label>
					</span>
				</div>
				@else
				<label class="col-2 col-form-label">Rechazar nómina</label>
				<div class="col-3">
					<span class="switch switch-danger">
						<label>
							<input type="checkbox" name="estatus_aprobacion" id="estatus_aprobacion" autocomplete="off"/>
							<span></span>
						</label>
					</span>
				</div>
				@endif
			</div>
			<div id="contenedor_rechazo" @if (is_null($subProcesoPrestacion->estatus_aprobacion)) style="display: none" @endif>
				<div class="alert alert-custom alert-danger fade show" role="alert">
					<div class="alert-icon"><i class="flaticon-warning"></i></div>
					<div class="alert-text">
						Rechazar con comentarios para el Jefe de Unidad Departamental de Recursos Humanos.
					</div>
				</div>
				<textarea id="comentarios_rechazo" name="comentarios_rechazo" tinyMCE="true">{!! $subProcesoPrestacion->comentarios_rechazo !!}</textarea>
			</div>
		</div>
		<div class="card-footer">
			<div class="text-center">
				<button type="submit" class="btn btn-success"><i class="fas fa-check-square"></i> Finalizar tarea</button>
			</div>
		</div>
	</div>
</form>


@endsection @push('scripts')
	<script>
		var candidatos = @json($subProcesoPrestacion->candidatos, JSON_PRETTY_PRINT);
		console.log(candidatos);
	</script>
	<script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
	<script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
	<script src="{{ asset('metronic/plugins/custom/tinymce/tinymce.bundle.js?v=7.0.4') }}"></script>
	<script src="{{ asset('metronic/js/pages/crud/forms/editors/tinymce.js?v=7.0.4') }}"></script>
	<script src="{{ asset('js/p07_pago_prestaciones/ST02_aprobarCandidatos.js') }}"></script>
@endpush
