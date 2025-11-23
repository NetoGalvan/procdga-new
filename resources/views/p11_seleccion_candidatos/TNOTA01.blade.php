@extends('layouts.main')

@section('contenido')
<h1 class="my-5 text-center titulo-tarea">Notificación Citas para examen
	psicométrico del Procedimiento de Selección de Candidatos de Personal
	de Estructura</h1>
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
				</div>
			</div>
		</div>
	</div>
</div>
<form method="post" id="form1"
	action="{{route('seleccion.candidatos.guardar.notificacion.citas',$candidatoEstructura)}}"
	onsubmit="guardarDatosTablas(event)">
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
					<h2 class="titulo-formulario">Datos de los Candidatos</h2>
					<hr style="color: #0056b2;" />
					<p class="card-text">Elija la situación final de los candidatos de
						estructura, considerando que sólo se puede aceptar a uno de ellos.</p>
					<p class="card-text">
						<b>Nota:</b> Si ambos son rechazados el proceso se dará por
						concluido automáticamente.
					</p>
					<br>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<table class="table table-bordered table-general"
									id="tablaCandidatosSeleccionadosFechaCitas" data-unique-id="id">
									<thead>
										<tr>
											<th data-field="nombre_candidato"
												data-formatter="nombreCandidatos">Nombre y RFC del Candidato</th>
											<th data-field="fecha_cita">Fecha de Evaluacion</th>
											<th data-field="hora_cita">Hora de Evaluación</th>
											<th data-field="lugar_cita">Lugar de Evaluación</th>
										</tr>
									</thead>
								</table>
							</div>
						</div>
					</div>
					<div class="row " style="margin-bottom: 10px;">
						<div class="col-md-12 d-flex justify-content-center">
							<button type="submit" class="btn btn-success btn-sm" id="borrar">Enetrado-
								Borrar Notificación</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<br> <input id="arregloTablaCandidatosSeleccionados"
		name="arregloTablaCandidatos" hidden /> {{ csrf_field()}}
</form>
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

.colorLetras {
	color: darkgray;
}
</style>
<script>
var datos1 = @json($seleccion);
</script>
@endsection

@push('scripts')
<script src="{{ asset('js/p11_seleccion_candidatos/TNOTA01.js') }}"></script>
@endpush
