@extends('layouts.main')

@section('title', 'Autorización de candidato')

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
                'titulo' => 'Autorización de candidato'
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
	<h1 class="mb-5 text-center titulo-tarea">Selección de Candidatos de
		Personal de Estructura: Autorización del candidato a ocupar la plaza.
	</h1>
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
						<p class="card-text">"El presente proceso no genera
							responsabilidad de contratación del candidato en proceso de
							selección".</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<form method="post" id="formCandidatosAutorizaciones"
		action="{{route('seleccion.candidatos.guardar.autorizaciones',$candidatoEstructura)}}">
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
						<div class="row">
							<div class="col-md-6">
								<label for="apePaterno">Descargue el reporte Reporte Ejecutivo
									de Examen Psicométrico.</label>
							</div>
							<div class="col-md-6">
								<a href="">Documento Alimentario de Personal - Bajas</a>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="alert alert-warning" role="alert">
									<p class="card-text">
										<b>NOTA:</b> En el se encuentran los resultados finales de la
										evaluación así como la gráfica. Si desea ver otros formatos o
										reportes acuda a la sección de reportes.
									</p>
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
						<h2 class="titulo-formulario">Comentarios del DGA</h2>
						<hr style="color: #0056b2;" />
						<div class="row">
							<div class="col-md-12" style="text-align: left">
								<div class="alert alert-secondary" role="alert">
									<p>{{$candidatoEstructura->comentarios_dga}}</p>
								</div>
								<label for="apePaterno" style="color: aqua;"></label>
							</div>
						</div>
						<div class="row">
							<div class="col-md-5">
								<label for="apePaterno">Coloque su Desicion final al Respecto
									del Candidato</label> <select
									class="form-control form-control-sm" id="aceptacion_srio"
									name="aceptacion_srio">
									<option value="-1">Seleccione una Opcion</option>
									<option value="ACEPTADO">Aceptado</option>
									<option value="RECHAZADO">Rechazado</option>
								</select> @error('aceptacion_srio')
								<div class="alert alert-danger">{{ $message }}</div>
								@enderror
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row " style="margin-bottom: 10px;">
			<div class="col-md-12 d-flex justify-content-center mb-5">
				<button type="button" class="btn btn-success btn-lg"
					id="btnCandidatosAutorizaciones">
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
</script>
@endsection @push('scripts')
<script
	src="{{ asset('js/p11_seleccion_candidatos/T06_seleccionCandidatosAutorizaciones.js') }}"></script>
@endpush
