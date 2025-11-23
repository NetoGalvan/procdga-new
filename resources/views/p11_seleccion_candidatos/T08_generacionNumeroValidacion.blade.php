@extends('layouts.main')

@section('title', 'Número de validación del candidato')

@section('subheader')
    @include('layouts.partials.admin.subheader', ["subheader" => [
        "titulo_subheader" => "PROCDGA",
        "icono_titulo_subheader" => "far fa-folder-open",
        "breadcrumbs" => [
            1 => [
                'activo' => false,
                'titulo' => 'Tareas disponibles',
                'ruta' => Route('tareas')
            ],
            2 => [
                'activo' => true,
                'titulo' => 'Número de validación del candidato'
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

@section('contenido')
<div class="container-fluid">
	<h1 class="text-center titulo-tarea">Selección de Candidatos de
		Personal de Estructura: Generación del número de validación</h1>
	<div class="row titulo-tarea">
		<div class="col-md-12 formu">
			<div class="card shadow-sm p-3 mb-5 bg-white rounded sinMargen"
				style="padding: 0px !important;">
				<div class="card-body">
					<div class="alert alert-info" role="alert">
						<p class="card-text">
							<b>Unidad Administrativa :</b> {{$usuarios->area->identificador}}
							{{$usuarios->area->nombre}}
						</p>
						<p class="card-text">
							Anote bien el siguiente número de folio, con el que podrá iniciar
							el proceso de <b>MOVIMIENTOS DE PERSONAL</b> para el candidato
							selccionado:
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="alert alert-primary text-center" role="alert">
		<b>Folio de validación: {{$candidatoEstructura->folio}}</b>
	</div>
	<form method="post" id="formNumeroValidacion"
		action="{{route('seleccion.candidatos.guardar.numero.validacion',$candidatoEstructura)}}">
		<div class="row">
			<div class="col-md-12 formu">
				<div class="card shadow-sm p-3 mb-5 bg-white rounded sinMargen"
					style="padding: 0px !important;">
					<div class="card-body">
						<h2 class="titulo-formulario">Datos de la Plaza de Estructura a
							Ocupar</h2>
						<hr style="color: #0056b2;" />
						<div class="row">
							<div class="col-md-4">
								<label for="apePaterno">Plaza : </label>
								<p class="card-text">{{$candidatoEstructura->plaza->numero_plaza}}</p>
							</div>
							<div class="col-md-4">
								<label for="apePaterno">Nombre de Adscripción: </label>
								<p class="card-text">{{$candidatoEstructura->plaza->plazaUnidad->nombre_unidad}}</p>
							</div>
							<div class="col-md-4">
								<label for="apePaterno">Código : </label>
								<p class="card-text">{{$candidatoEstructura->plaza->codigo_puesto}}</p>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<label for="apePaterno">Denominacion:</label>
								<p class="card-text">{{$candidatoEstructura->plaza->denominacion_puesto}}</p>
							</div>
							<div class="col-md-6">
								<label for="apePaterno">Titular del área solicitante:</label>
								<p class="card-text">{{$candidatoEstructura->titulares}}</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="card shadow-sm p-3 mb-5 bg-white rounded sinMargen">
					<div class="card-body" style="padding: 0px;">
						<h2 class="titulo-formulario">Datos de Candidato Seleccionado</h2>
						<hr style="color: #0056b2;" />
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<table class="table table-bordered table-general"
										id="tablaCandidatosSeleccionados" data-unique-id="id">
										<thead>
											<tr>
												<th data-field="seleccion_candidato_id" data-visible="false"></th>
												<th data-field="candidato_id" data-visible="false"></th>
												<th data-field="created_at" data-formatter="">Fecha de
													Solicitud</th>
												<th data-field="tipo_movimiento" data-formatter="">Tipo de
													Movimiento</th>
												<th data-field="nombre_candidato" data-formatter="">Nombre y
													RFC del Candidato</th>
												<th data-field="aceptacion_srio" data-formatter="">Condicion
													final de Selección</th>
												<th data-field="fecha_alta">Fecha Ingreso</th>
											</tr>
										</thead>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row " style="margin-bottom: 10px;">
			<div class="col-md-12 d-flex justify-content-center mb-5">
				<button type="button" class="btn btn-success btn-lg"
					id="btnNumeroValidacion">
					<span>Continuar</span><i class="material-icons align-middle">
						forward </i>
				</button>
			</div>
		</div>
		<br> <input id="arregloTablaCandidatosSeleccionados"
			name="arregloTablaCandidatos" hidden /> {{ csrf_field()}}
	</form>
</div>
<style>
.panelPequenos {
	padding-top: 2px;
	padding-bottom: 2px;
	height: auto;
}
/* input { */
/* 	padding: 4px !important; */
/* 	height: 30px !important; */
/* } */
.requeridos {
	color: red;
}

label {
	font-weight: bold;
}
</style>
<script>
var datos1 = @json($seleccion);
</script>
@endsection @push('scripts')
<script
	src="{{ asset('js/p11_seleccion_candidatos/T08_generacionNumeroValidacion.js') }}"></script>
@endpush
