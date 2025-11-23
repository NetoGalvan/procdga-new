@extends('layouts.main')

@section('title', 'Creación esquema de datos')

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
                'titulo' => 'Creación esquema de datos'
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
				<div class="col-4">
					<label class="titulo-dato">Folio:</label>
                    <span class="valor-dato"> <b> {{ $pagoPrestacion->folio }} </b> </span>
				</div>
			</div>
		</div>
	</div>
	<form method="POST" action="{{route('pago.prestacion.esquema.datos', [$pagoPrestacion, $instanciaTarea] )}}" id="form_esquema_datos">
		@csrf
		<div class="card card-custom mb-5">
			<div class="card-header">
				<div class="card-title">
					<h3 class="card-label">Creación del esquema</h3>
				</div>
			</div>
			<div class="card-body">
				<div class="alert alert-custom alert-success">
					<div class="alert-icon"><i class="flaticon-warning"></i></div>
					<div class="alert-text">
						El esquema de datos es la "tabla" o matriz hecha de columnas y
						renglones que se debe apegar a los lineamientos que emite DGADP.
						Cada prestación puede diferir en cuanto a las columnas que pide
						DGADP, así que el primer paso es definir las columnas, con sus
						nombres y tamaños para cada una. Usted es responsable de que el
						esquema que se cree, sea EXACTAMENTE igual que el que solicita
						DGADP. Cuando se termine de definir, se le solicitará a los Jefes
						de Unidad Departamental de Recursos Humanos de las áreas, que
						llenen los datos que usted definió. Si tiene cualquier duda, no
						dude en contactar a la Subdirección de Organización y Métodos en
						los siguientes teléfonos: 5134-2500 EXTENSIÓN 1840, donde se le
						podrá brindar la ayuda necesaria.
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="titulo-dato"><strong><span class="text-danger">* </span>Tipo de prestación:</strong></label>
							<select class="form-control" id="tipo_prestacion_id" name="tipo_prestacion_id" onchange="esquemaPrestacion(this.value)" autocomplete="off" required>
								<option value="">Seleccione</option>
								@foreach ($tiposPrestaciones as $tipoPrestacion)
									<option value="{{ $tipoPrestacion->tipo_prestacion_id }}">{{ $tipoPrestacion->nombre }}</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>
				<div id="errorMensajes"></div>
				<div class="row">
					<div class="col-md-12">
						<div id="tablasEsquemas"></div>
					</div>
				</div>
			</div>
		</div>
		<div class="card card-custom mb-5">
			<div class="card-header">
				<div class="card-title">
					<h3 class="card-label">Usuarios y áreas</h3>
				</div>
			</div>
			<div class="card-body">
				<div class="alert alert-custom alert-success" role="alert">
					<div class="alert-icon"><i class="flaticon-warning"></i></div>
					<div class="alert-text"> Los usuarios que recibirán la tarea de llenado de este esquema son los siguientes: </div>
				</div>
				<div class="table-responsive mt-8">
					<table class="table table-bordered text-center">
						<thead>
							<tr>
								<th scope="col"><label class="titulo-dato">Usuario(s)</label></th>
								<th scope="col"><label class="titulo-dato">Puesto</label></th>
								<th scope="col"><label class="titulo-dato">Area</label></th>
							</tr>
						</thead>
                        <tbody>
                            @foreach ($areasRH as $area)
                                @php
                                    $usuariosArea = $area->users()->whereHas("roles", function($q) {
                                        $q->where("name", "JUD_RH");
                                    })
                                    ->get();
                                @endphp
                                @foreach ($usuariosArea as $indice => $usuario)
                                    <tr>
                                        <td> {{ $usuario->nombre }} {{ $usuario->apellido_paterno }} {{ $usuario->apellido_materno }} </td>
                                        <td> {{ mb_strtoupper($usuario->puesto) }} </td>
                                        <td> {{ mb_strtoupper($area->nombre) }} </td>
                                        {{-- @if ($indice == 0)
                                        <td rowspan="{{ count($usuariosArea) }}" class="align-middle"> {{ $area->unidadAdministrativa->nombre_unidad }} </td>
                                        @endif --}}
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
					</table>
				</div>
				<div class="row">
					<div class="col-md-12">
						<small id="emailHelp" class="text-muted">Revise este listado cuidadosamente y reporte a la SOM cualquier discrepancia u omisión.</small>
					</div>
				</div>
			</div>
		</div>
		<div class="card card-custom" id="fechasInstrucciones">
			<div class="card-header">
				<div class="card-title">
					<h3 class="card-label">Fechas e instrucciones finales</h3>
				</div>
			</div>
			<div class="card-body">
				<div class="alert alert-custom alert-success" role="alert">
					<div class="alert-icon"><i class="flaticon-warning"></i></div>
					<div class="alert-text">
						Indique la <b>FECHA LÍMITE</b> para la
						captura de los datos que solicita. En el campo de <b>OBSERVACIONES</b> describa instrucciones
						particulares que requieran tomar en cuenta los usuarios
					</div>
				</div>
				<div class="row">
					<input id="estructura_concurrente" name="estructura_concurrente" type="hidden" />
					<div class="col-md-3">
						<div class="form-group mb-0">
							<label class="titulo-dato"><strong><span class="text-danger">* </span>Fecha límite:</strong></label>
							<input class="form-control input-date-current" type="text" name="fecha_limite" required>
						</div>
					</div>
					<div class="col-md-9">
						<div class="form-group mb-0">
							<label class="titulo-dato"><strong><span class="text-danger">* </span>Observaciones:</strong></label>
							<textarea class="form-control normalizar-texto" rows="5" cols="4" name="observaciones" required></textarea>
						</div>
					</div>
				</div>
			</div>
			<div class="card-footer">
                <div class="text-center">
                    <button type="submit" class="btn btn-success"><i class="fas fa-check-square"></i> Finalizar tarea</button>
                </div>
            </div>
		</div>
	</form>
	<form id="formCamposNuevos">
		<div class="modal fade" id="modalAgregar">
			<div class="modal-dialog modal-dialog-centered modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Nuevo campo</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<i aria-hidden="true" class="ki ki-close"></i>
						</button>
					</div>
					<div class="modal-body">
						<input type="hidden" id="editar" name="editar" />
						<input type="hidden" id="id_row" name="id_row" />
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label class="titulo-dato"><strong><span class="text-danger">* </span>Nombre</strong></label>
									<input class="form-control" type="text" name="nombre" id="nombre">
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label class="titulo-dato"><strong><span class="text-danger">* </span>Descripción</strong></label>
									<input class="form-control" type="text" name="descripcion" id="descripcion">
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label class="titulo-dato"><strong><span class="text-danger">* </span>Tamaño</strong></label>
									<input class="form-control" type="text" name="tamanio" id="tamanio">
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Cerrar</button>
						<button type="button" class="btn btn-primary font-weight-bold" onclick="agregarFilas()">Guardar Esquema</button>
					</div>
				</div>
			</div>
		</div>
	</form>
@endsection

@push('scripts')
	<script>
		var urPrincipal = window.location.origin;
		var randomId = 100 + ~~(Math.random() * 100)
	</script>
	<script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
	<script src="{{ asset('js/p07_pago_prestaciones/T01_creacionEsquemaDatos.js') }}"></script>
@endpush
