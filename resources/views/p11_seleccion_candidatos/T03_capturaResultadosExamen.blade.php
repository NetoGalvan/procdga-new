@extends('layouts.main')

@section('title', 'Captura de resultados de examenes')

@section('subheader')
    @include('layouts.partials.main.subheader', ["subheader" => [
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
                'titulo' => 'Captura de resultados de examenes'
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

    <div class="card card-custom mb-5">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">Selección de candidatos de personal de estructura</h3>
            </div>
        </div>
        <div class="card-body">
            <div class="alert alert-custom alert-outline-info" role="alert">
                <div class="alert-text">
                    <p>
                        <b>Folio :</b> {{$candidatoEstructura->instancia->folio}}
                    </p>
                    <p>
                        <b>Unidad Administrativa :</b> {{$usuario->area->identificador}}
                        {{$usuario->area->nombre}}
                    </p>
                    <h5>
                        <b>"El presente proceso no genera responsabilidad de contratación
                            del candidato en proceso de selección"</b>
                    </h5>
                </div>
            </div>
        </div>
    </div>
	<form method="post" id="capturaResultadosExamenes" action="{{route('seleccion.candidatos.guardar.datos.empleados.evaluacion', $candidatoEstructura)}}">
        @csrf
        @method('POST')

        <div class="card card-custom mb-5">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Seleccione al candidato y guarde los resultados del exámen psicométrico</h3>
                </div>
            </div>
            <div class="card-body">

                <div class="row">
                    <div class="col-md-12">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-custom alert-outline-warning" role="alert">
                                    <div class="alert-text">
                                        <p class="card-text">Seleccione la opción de editar al candidato y guarde los resultados del exámen psicométrico</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-5">
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{-- <table
                                        class="table table-bordered table-general"
                                        id="tablaCandidatosSeleccionadosFechaCitas"
                                        data-unique-id="id">
                                        <thead>
                                            <tr>
                                                <th class="text-center" data-field="seleccion_candidato_id" data-visible="false"></th>
                                                <th class="text-center" data-field="created_at">Fecha de Solicitud</th>
                                                <th class="text-center" data-field="tipo_movimiento" data-formatter="tipoMovimientoFormatter">Tipo de movimiento</th>
                                                <th class="text-center" data-field="nombre_candidato" data-formatter="nombreCandidatoFormatter">Nombre del candidato</th>
                                                <th class="text-center" data-field="rfc" data-formatter="">RFC</th>
                                                <th class="text-center" data-field="observaciones_titular" data-formatter="">Observaciones del titualar</th>
                                                <th data-field="candidato_id" data-formatter="fechaEvaluacionActual">Fecha de Evaluación</th>
                                                <th data-field="candidato_id" data-formatter="horaEvaluacionActual">Hora de Evaluación</th>
                                                <th data-field="candidato_id" data-formatter="lugarEvaluacionActual">Lugar de Evaluación</th>
                                            </tr>
                                        </thead>
                                    </table> --}}

                                    <table class="table table-bordered table-general"
										id="tablaCandidatosSeleccionados"
                                        data-unique-id="id">
										<thead>
											<tr>
												<th class="text-center" data-field="seleccion_candidato_id" data-visible="false"></th >
												<th class="text-center" data-field="candidato_id" data-visible="false"></th >
												<th class="text-center" data-field="info_candidato"	data-formatter="infoCandidatoFormatter">Datos del candidato</th>
												<th class="text-center" data-field="fecha_cita" data-formatter="infoEvaluacionFormatter">Evaluación</th>
												<th class="text-center" data-field="plaza" data-formatter="datosDeLaPlazasFormatter">Datos de la plaza a ocupar</th>
												<th class="text-center" data-field="editar" data-formatter="editarCandidatoFornatter">Editar al candidato</th>
												<th class="text-center" data-field="reportes" data-formatter="reportesFormatter">Ver reporte</th>
											</tr>
										</thead>
									</table>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="row ">
                    <div class="col-md-12 d-flex justify-content-center mb-5">
                        {{-- @if ( $fechaAsiganda > 0 || count($seleccionCandidato) <= 0 )
                            <div class="alert alert-custom alert-outline-warning fade show mb-5" role="alert">
                                <div class="alert-icon"><i class="flaticon-warning"></i></div>
                                <div class="alert-text">¡Este folio ya tiene fecha asignada, No puede realizar ningún cambio!</div>
                            </div>
                        @else
                        @endif --}}
                        <button type="button" class="btn btn-success btn-lg" id="btnCapturaResultados"> Finalizar </button>
                    </div>
                </div>

            </div>
        </div>

        {{-- <div class="row">
			<div class="col-md-12">
				<div class="card shadow-sm p-3 mb-5 bg-white rounded sinMargen">
					<div class="card-body" style="padding: 0px;">

						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<table class="table table-bordered table-general"
										id="tablaCandidatosSeleccionados" data-unique-id="id">
										<thead>
											<tr>
												<th data-field="seleccion_candidato_id" data-visible="false"></th>
												<th data-field="candidato_id" data-visible="false"></th>
												<th data-field="created_at"
													data-formatter="nombreCandidatos">Nombre del Candidato</th>
												<th data-field="tipo_movimiento" data-formatter="">Fecha de
													evaluacion</th>
												<th data-field="nombre_candidato"
													data-formatter="datosDeLaPlazas">Datos de la Plaza a Ocupar</th>
												<th data-field="observaciones_titular"
													data-formatter="editarCandidatos">Editar al Candidato</th>
												<th data-formatter="reportes">Ver Reporte</th>
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
					id="btnCapturaResultados">
					<span>Continuar</span><i class="material-icons align-middle">
						forward </i>
				</button>
			</div>
		</div>
		<br> --}}

        <input id="arregloTablaCandidatosSeleccionados" name="arregloTablaCandidatos" hidden />
        <input id="dataTableCandidatos" name="dataTableCandidatos" hidden />

	</form>
	<div class="bs-example"></div>


@include('p11_seleccion_candidatos.T03_capturaResultadosExamenModal')

@endsection

@push('styles')
    <link href="{{ asset('metronic/plugins/custom/bootstraptable/css/bootstrap-table.min.css') }}" type="text/css" rel="stylesheet"/>
@endpush

@push('scripts')
    <script>

        var candidatoSelecionado = @json($seleccionCandidato);

        var candidatos = "{{ url('/') }}";
        var datos1 = @json($seleccionCandidato);
        // var seleccionId = json();
        var estadoCivil = "{{route('catalogos.estado.civil')}}";
        var sexos = "{{route('catalogo.sexos')}}";
        var candidatosIds = @json($candidatoEstructura);
        var urlNivelesEstudios = "{{route('catalogo.niveles.estudios')}}";
        var urlSexos = "{{route('catalogo.sexos')}}";
    </script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
    <script src="{{ asset('js/p11_seleccion_candidatos/T03_capturaResultadosExamen.js') }}"></script>
    {{-- <script src="{{ asset('js/p11_seleccion_candidatos/T03_captura.js') }}"></script> --}}
@endpush
