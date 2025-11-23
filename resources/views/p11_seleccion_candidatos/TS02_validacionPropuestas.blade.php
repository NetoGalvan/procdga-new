@extends('layouts.main')

@section('title', 'TS02 Validación de propuestas')

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
                'titulo' => 'TS02 Validación de propuestas'
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

    <div class="card card-custom mb-5">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">Datos de la plaza de estructura a ocupar</h3>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">

                    <div class="row">
                        <div class="col-md-6">
                            <label for="apePaterno">Plaza </label>
                            <span class="valor-dato">  {{ $candidatoEstructura->plaza->numero_plaza }} </span>
                        </div>
                        <div class="col-md-6">
                            <label for="apePaterno">Nombre de Adscripción </label>
                            <span class="valor-dato">  {{ $candidatoEstructura->plaza->plazaUnidad->nombre_unidad }} </span>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="apePaterno">Denominacion </label>
                            <span class="valor-dato">  {{ $candidatoEstructura->plaza->denominacion_puesto }} </span>
                        </div>
                        <div class="col-md-6">
                            <label for="apePaterno">Código </label>
                            <span class="valor-dato">  {{ $candidatoEstructura->plaza->codigo_puesto }} </span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

	<form method="POST" id="formValidacionPropuestas" action="{{ route('seleccion.candidatos.guardar.validacion.propuestas', $candidatoEstructura) }}">
        @csrf
        @method('POST')

        <div class="card card-custom mb-5">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Datos de los candidatos</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-custom alert-outline-info" role="alert">
                                    <div class="alert-text">
                                        Elija la situación final de los candidatos de
                                        estructura, considerando que sólo se puede aceptar a uno de
                                        ellos
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-custom alert-outline-warning" role="alert">
                                    <div class="alert-icon"><i class="flaticon-warning"></i></div>
                                    <div class="alert-text">
                                        <b>Nota:</b> Si ambos son rechazados el proceso se dará por concluido automáticamente
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-5">
							<div class="col-md-12">
								<div class="form-group">
									<table
                                        class="table table-bordered table-general"
										id="tablaCandidatosSeleccionados"
                                        data-unique-id="id">
										<thead>
											<tr>
												<th class="text-center" data-field="seleccion_candidato_id" data-visible="false"></th>
												<th class="text-center" data-field="created_at" data-formatter="">Fecha de solicitud</th>
												<th class="text-center" data-field="tipo_movimiento" data-formatter="tipoMovimientoFormatter">Tipo de movimiento</th>
												<th class="text-center" data-field="nombre_candidato" data-formatter="nombreCandidatoFormatter">Nombre del candidato</th>
												<th class="text-center" data-field="rfc" data-formatter="">RFC</th>
												<th class="text-center" data-field="observaciones_titular" data-formatter="">Observaciones del titualar</th>
												<th class="text-center" data-field="candidato_id" data-formatter="validacionSecretarios">Validación del Secretario</th>
											</tr>
										</thead>
									</table>
								</div>
							</div>
						</div>

                        <div class="row">
                            <div class="col-md-12 d-flex justify-content-center mb-5">
                                @if ( $aceptacionSrio > 0 )
                                    <div class="alert alert-custom alert-outline-warning fade show mb-5" role="alert">
                                        <div class="alert-icon"><i class="flaticon-warning"></i></div>
                                        <div class="alert-text">¡Este folio ya fue validado, No puede realizar ningún cambio!</div>
                                    </div>
                                @else
                                    <button type="button" class="btn btn-success btn-lg" id="btnValidacionPropuestas"> Finalizar </button>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

		<input id="dataTableCandidatos" name="dataTableCandidatos" hidden />

	</form>



@push('styles')
    <link href="{{ asset('metronic/plugins/custom/bootstraptable/css/bootstrap-table.min.css') }}" type="text/css" rel="stylesheet"/>
@endpush

@endsection @push('scripts')
    <script>
        var candidatosSelecionados = @json($seleccionCandidatos);
        var urlTareas = @json( route('tareas') );
    </script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
    <script	src="{{ asset('js/p11_seleccion_candidatos/TS02_validacionPropuestas.js') }}"></script>
@endpush
