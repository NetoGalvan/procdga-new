@extends('layouts.main')

@section('title', 'Aprobar nómina de las unidades administrativas')

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
                'titulo' => 'Aprobar nómina de las unidades administrativas'
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
				<span> <strong>{{ $pagoPrestacion->folio }}</strong></span>
			</div>
			<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
				<label class="titulo-dato"> Tipo de prestación: </label>
				<span><strong>{{ $pagoPrestacion->tipoPrestacion->nombre }}</strong></span>
			</div>
			<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
				<label class="titulo-dato"> Fecha límite: </label>
				<span><strong>{{ $pagoPrestacion->fecha_limite }}</strong></span>
			</div>
		</div>
	</div>
</div>
<form method="POST" action="{{route('pago.prestacion.aprobar.nomina', [$pagoPrestacion, $instanciaTarea])}}" id="form_finalizar_tarea">
	@csrf
	<div class="card card-custom">
		<div class="card-header">
			<div class="card-title">
				<h3 class="card-label">Nómina de las unidades administrativas</h3>
			</div>
		</div>
		<div class="card-body">
			<table
				class="table text-center"
				id="table_reg_candidatos"
				data-unique-id="candidato_prestacion_id">
				<thead>
					<tr>
						{{-- <th data-field="acciones" data-formatter="accionesFormatter" data-events="operateEvents">Acciones</th> --}}
						<th data-field="identificador_unidad" data-formatter="unidadAdministrativaFormatter"><label class="titulo-dato">Unidad Administrativa</label></th>
						<th data-field="usuario_captura" data-formatter="usuarioCapturaFormatter"><label class="titulo-dato">&nbsp;Usuario Captura&nbsp;</label></th>
						<th data-field="usuario_autorizacion" data-formatter="usuarioAutorizacionFormatter"><label class="titulo-dato">&nbsp;Usuario Autorización&nbsp;</label></th>
						<th data-field="numero_empleado"><label class="titulo-dato">No. Empleado</label></th>
						<th data-field="nombre_empleado"><label class="titulo-dato">Nombre</label></th>
						<th data-field="apellido_paterno"><label class="titulo-dato">Apellido Paterno</label></th>
						<th data-field="apellido_materno"><label class="titulo-dato">Apellido Materno</label></th>
						<th data-field="rfc"><label class="titulo-dato">RFC</label></th>
						<th data-field="curp"><label class="titulo-dato">CURP</label></th>
						<th data-field="seccion_sindical"><label class="titulo-dato">Seccion Sindical</label></th>
						@foreach ($pagoPrestacion->estructura_concurrente as $field)
							<th data-field="campos_adicionales.{{ $field->name }}"><label class="titulo-dato"> {{ $field->desc }} </label></th>
						@endforeach
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
<div class="modal fade" id="modal_editar_candidato" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar candidato</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
				<form id="form_editar_candidato">
					<div class="row">
						<input hidden name="candidato_prestacion_id" id="candidato_prestacion_id" />
						<div class="col-md-6">
							<div class="form-group">
								<label for="id_empleado" class="titulo-dato"><span class="requeridos">* </span>No. Empleado: </label>
								<input class="form-control form-control-sm" type="text" name="numero_empleado" id="numero_empleado" disabled placeholder="Número Empleado">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="nombre" class="titulo-dato"><span class="requeridos">* </span>Nombre: </label>
								<input class="form-control form-control-sm" type="text" name="nombre_empleado" id="nombre_empleado" disabled placeholder="Nombre">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="apellido_paterno" class="titulo-dato"><span class="requeridos">* </span>Apellido Paterno</label>
								<input class="form-control form-control-sm" type="text" name="apellido_paterno" id="apellido_paterno" disabled placeholder="Apellido Paterno">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="apellido_materno" class="titulo-dato"><span class="requeridos">* </span>Apellido Materno </label>
								<input class="form-control form-control-sm" type="text" name="apellido_materno" id="apellido_materno" disabled placeholder="Apellido Materno">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="unidad" class="titulo-dato"><span class="requeridos">* </span>Unidad Aministrativa</label>
								<input class="form-control form-control-sm" type="text" name="nombre_unidad" id="nombre_unidad" disabled placeholder="Unidad Administrativa">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="rfc" class="titulo-dato"><span class="requeridos">* </span>RFC</label>
								<input class="form-control form-control-sm" name="rfc" id="rfc" disabled placeholder="RFC"></input>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="curp" class="titulo-dato"><span class="requeridos">* </span>Curp: </label>
								<input class="form-control form-control-sm" type="text" name="curp" id="curp" disabled placeholder="CURP">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="sindicato" class="titulo-dato"><span class="requeridos">* </span>Sección Sindical </label>
								<input class="form-control form-control-sm" type="text" name="seccion_sindical" id="seccion_sindical" disabled placeholder="Sección Sindical">
							</div>
						</div>
						<div id="contenedor_campos_adicionales" class="row m-0"></div>
					</div>
				</form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Cerrar</button>
                <button
					type="button"
					class="btn btn-primary font-weight-bold"
					id="btn_editar_candidato"
					data-url="{{ route('pago.prestacion.editar.candidato') }}">Editar</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
	<script>
		var candidatos = @json($arrayCandidatos, JSON_PRETTY_PRINT);
	</script>
	<script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
	<script src="{{ asset('js/p07_pago_prestaciones/T04_aprobarNominaUnidades.js') }}"></script>
@endpush
