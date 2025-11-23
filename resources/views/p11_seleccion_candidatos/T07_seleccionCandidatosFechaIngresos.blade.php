@extends('layouts.main')

@section('title', 'Asignar fecha de ingreso')

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
                'titulo' => 'Asignar fecha de ingreso'
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

<h1 class="mb-5 text-center titulo-tarea">Selección de Candidatos de
	Personal de Estructura: Asignación de fecha de ingreso</h1>
<div class="row titulo-tarea">
	<div class="col-md-12 formu">
		<div class="card shadow-sm p-3 mb-5 bg-white rounded sinMargen"
			style="padding: 0px !important;">
			<div class="card-body">
				<div class="alert alert-info" role="alert">
					<p class="card-text">
						<b>Folio :</b> {{$candidatoEstructura->folio}}
					</p>
					<p class="card-text">
						<b>Unidad Administrativa :</b> {{$usuarios->area->identificador}}
						{{$usuarios->area->nombre}}
					</p>
					<h5 class="card-text">
						<b>"El presente proceso no genera responsabilidad de contratación
							del candidato en proceso de selección".</b>
					</h5>
				</div>
			</div>
		</div>
	</div>
</div>
<form method="post" id="formFechaAltas"
	action="{{route('seleccion.candidatos.guardar.fecha.ingresos',[$candidatoEstructura,$candidatoSeleccionado])}}">
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
					<h2 class="titulo-formulario">Datos Generales del Candidato
						Seleccionado.</h2>
					<hr style="color: #0056b2;" />
					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								<label for="nombre"><span class="requeridos">* </span>Nombre</label>
								<p class="card-text">{{$candidatoSeleccionado->candidato->nombre_candidato}}</p>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label for="apePaterno"><span class="requeridos">* </span>Fecha
									de nacimiento</label>
								<p class="card-text">{{$candidatoSeleccionado->candidato->fecha_nacimiento}}</p>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label for="apePaterno"><span class="requeridos">* </span>RFC</label>
								<p class="card-text">{{$candidatoSeleccionado->candidato->rfc}}</p>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label for="apePaterno"><span class="requeridos">* </span>Edad</label>
								<p class="card-text">{{$candidatoSeleccionado->candidato->sexo_id}}</p>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								<label for="nombre"><span class="requeridos">* </span>Genero</label>
								<p class="card-text">{{$candidatoSeleccionado->candidato->sexo->sexo}}</p>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label for="apePaterno"><span class="requeridos">* </span>Estado
									Civil</label>
								<p class="card-text">{{$candidatoSeleccionado->candidato->estadoCivil->estado_civil}}</p>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label for="apePaterno"><span class="requeridos">* </span>Escolaridad</label>
								<p class="card-text">{{$candidatoSeleccionado->candidato->escolaridad}}</p>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label for="apePaterno"><span class="requeridos">* </span>Puesto
									Actual</label>
								<p class="card-text">{{$candidatoSeleccionado->puesto_actual}}</p>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								<label for="nombre"><span class="requeridos">* </span>Tipo de
									Movimiento:</label>
								<p class="card-text">{{$candidatoSeleccionado->tipo_movimiento}}</p>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label for="apePaterno"><span class="requeridos">* </span>Motivo
									de Evaluación:</label>
								<p class="card-text">{{$candidatoSeleccionado->motivo_evaluacion}}</p>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label for="apePaterno"><span class="requeridos">* </span>Folio
									de Contraloria:</label>
								<p class="card-text">{{$candidatoSeleccionado->folio_contraloria}}</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12 formu">
			<div class="card shadow-sm p-3 mb-5 bg-white rounded sinMargen"
				style="padding: 0px !important;">
				<div class="card-body">
					<h2 class="titulo-formulario">Resultados de la Evaluación.</h2>
					<hr style="color: #0056b2;" />
					<div class="row">
						<div class="col-md-12" style="text-align: center">
							<div class="alert alert-success" role="alert">{{$candidatoSeleccionado->aceptacion_eval}}
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12 formu">
			<div class="card shadow-sm p-3 mb-5 bg-white rounded sinMargen"
				style="padding: 0px !important;">
				<div class="card-body">
					<h2 class="titulo-formulario">Visto Bueno del Secretario de
						Finanzas</h2>
					<hr style="color: #0056b2;" />
					<div class="row">
						<div class="col-md-12" style="text-align: center">
							<div class="alert alert-success" role="alert">
								{{$candidatoEstructura->aceptacion_srio}}</div>
							<label for="apePaterno" style="color: aqua;"></label>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12 formu">
			<div class="card shadow-sm p-3 mb-5 bg-white rounded sinMargen"
				style="padding: 0px !important;">
				<div class="card-body">
					<h2 class="titulo-formulario">Asignación de fecha de Ingreso</h2>
					<hr style="color: #0056b2;" />
					<div class="row">
						<div class="col-md-5">
							<label for="fecha_alta"><span class="requeridos">* </span>Indique
								la fecha de ingreso del candidato</label> <input
								class="form-control form-control-sm date" type="text"
								name="fecha_alta" id="fecha_alta"> @error('fecha_alta')
							<div class="alert alert-danger">{{ $message }}</div>
							@enderror
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row ">
		<div class="col-md-12 d-flex justify-content-center mb-5">
			<button type="button" class="btn btn-success btn-lg"
				id="btnFechaAltas">
				<span>Continuar</span><i class="material-icons align-middle">
					forward </i>
			</button>
		</div>
	</div>
	<br> <input id="arregloTablaCandidatosSeleccionados"
		name="arregloTablaCandidatos" hidden /> {{ csrf_field()}}
</form>

<style>
.error {
	color: #E60035;
}

.valido {
	border-color: #6bd18e;
}

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
						                        </script>
@endsection @push('scripts')
<script
	src="{{ asset('js/p11_seleccion_candidatos/T07_seleccionCandidatosFechaIngresos.js') }}"></script>
@endpush
