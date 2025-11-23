@extends('layouts.main')

@section('title', "MOVIMIENTOS DE PERSONAL - {$instanciaTarea->tarea->nombre}")

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
                'titulo' => "MOVIMIENTOS DE PERSONAL - {$instanciaTarea->tarea->nombre}"
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
    <link href="{{ asset('metronic/plugins/custom/bootstraptable/css/bootstrap-table.min.css') }}" rel="stylesheet" type="text/css"/>
@endpush

@section('contenido')
    @if ($instanciaTarea->estatus == 'EN_CORRECCION')
		<div class="alert alert-custom alert-danger mb-8" role="alert">
			<div class="alert-icon"><i class="flaticon-warning"></i></div>
    		<div class="alert-text">
				<h4 class="alert-heading">SOLICITUD RECHAZADA</h4>
				<p>{{ $movimientoPersonal->motivo_rechazo }}</p>
			</div>
		</div>
    @endif
	<form id="formAlimentarioReanudaciones" action="{{ route('movimiento.personal.reanudaciones.alimentario', [$movimientoPersonal, $instanciaTarea]) }}" method="POST">
		@csrf
        <div class="card card-custom">
            <div class="card-body">
                @include("p01_movimientos_personal.tareas.partials.datos_general_reanudaciones", [
                    "secciones" => [
                        "general" => ["datos_generales", "tipo_movimiento"]
                    ]
                ])
            </div>
        </div>
		<div class="card card-custom mt-8">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Búsqueda de empleado</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato"><strong><span class="text-danger">* </span>Fecha de solicitud:</strong></label>
                        <input type="text" name="fecha_solicitud" id="fecha_solicitud" class="form-control input-date" value="{{ $movimientoPersonal->fecha_solicitud }}" readonly required>
                    </div>
                </div>
                @include("componentes.busqueda_empleado", [
                    "existeEmpleado" => !is_null($movimientoPersonal->nombre_empleado),
                    "empleado" => "$movimientoPersonal->nombre_empleado $movimientoPersonal->apellido_paterno $movimientoPersonal->apellido_materno || $movimientoPersonal->rfc || $movimientoPersonal->numero_empleado"
                ])
            </div>
        </div>
        <div class="card card-custom mt-8">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Datos de la plaza</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label class="titulo-dato"><strong><span class="text-danger">* </span>Plaza:</strong></label>
                        <select class="form-control select2" id="numero_plaza" name="numero_plaza" autocomplete="off" required>
                            <option value>Seleccione una opción</option>
                            @foreach ($plazas as $plaza)
                                @if ($plaza->numero_plaza == $movimientoPersonal->numero_plaza)
                                    <option value="{{ $plaza->numero_plaza }}" selected>{{ $plaza->numero_plaza }} | {{ $plaza->codigo_puesto }} | {{ $plaza->puesto }}</option>
                                @else
                                    <option value="{{ $plaza->numero_plaza }}">{{ $plaza->numero_plaza }} | {{ $plaza->codigo_puesto }} | {{ $plaza->puesto }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato">Fecha de inicio</label>
                        <input type="text" name="fecha_alta" class="form-control input-date" value="{{ $movimientoPersonal->fecha_alta }}" autocomplete="off" readonly>
                    </div>
					<div class="col-md-3 form-group">
						<label class="titulo-dato"><strong><span class="text-danger">* </span>Fecha de fin</strong></label>
						<input type="text" name="fecha_fin" class="form-control input-date" value="{{ $movimientoPersonal->fecha_fin }}" autocomplete="off" readonly required>
					</div>
                    <div class="col-md-6 form-group">
                        <label class="titulo-dato"><strong><span class="text-danger">* </span>Observaciones</strong></label>
						<textarea name="observaciones_plaza" class="form-control normalizar-texto" autocomplete="off" required>{{ $movimientoPersonal->observaciones_plaza }}</textarea>
					</div>
                </div>
            </div>
        </div>
		<div class="card card-custom mt-8">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Datos adicionales del empleado</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="row contenedor-direccion">
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato"><strong><span class="text-danger">* </span>Correo electrónico:</strong></label>
                        <input type="text" name="email" class="form-control" autocomplete="off" value="{{ $movimientoPersonal->email ?? ""  }}" email="true" required/>
                    </div>
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato">Teléfono casa</label>
                        <input type="text" name="telefono" class="form-control" value="{{ $movimientoPersonal->telefono ?? "" }}" autocomplete="off" maxlength="10">
                    </div>
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato">Teléfono celular</label>
                        <input type="text" name="telefono_celular" class="form-control" value="{{ $movimientoPersonal->telefono_celular ?? "" }}" autocomplete="off" maxlength="10">
                    </div>
                    <div class="col-md-12 form-group">
                        <h5 class="text-dark font-weight-bold">Domicilio</h5>
                        <hr class="mb-0">
                    </div>
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato"><strong><span class="text-danger">* </span>Calle</strong></label>
                        <input type="text" name="calle" id="calle" class="form-control normalizar-texto" autocomplete="off" value="{{ $movimientoPersonal->calle ?? ""  }}" required>
                    </div>
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato">Número exterior</label>
                        <input type="text" name="numero_exterior" id="numero_exterior" class="form-control normalizar-texto" autocomplete="off" value="{{ $movimientoPersonal->numero_exterior ?? ""  }}">
                    </div>
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato">Número interior</label>
                        <input type="text" name="numero_interior" id="numero_interior" class="form-control normalizar-texto" autocomplete="off"  value="{{ $movimientoPersonal->numero_interior ?? ""  }}">
                    </div>
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato"><strong><span class="text-danger">* </span>Código Postal</strong></label>
                        <input type="text" name="cp" id="cp" class="form-control cp" autocomplete="off" placeholder="5 dígitos" maxlength="5" value="{{ $movimientoPersonal->cp ?? ""  }}" data-url="{{ route('catalogo.codigo.postal.v2') }}" required>
                    </div>
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato"><strong><span class="text-danger">* </span>Entidad</strong></label>
                        <select name="entidad_federativa_domicilio_id" id="entidad_federativa_domicilio_id" class="form-control entidad-federativa select2" required>
                            <option value>Seleccione una opción</option>
                            @foreach ($entidades as $entidad)
                                @if ($entidad->entidad_federativa_id == $movimientoPersonal->entidad_federativa_domicilio_id)
                                    <option value="{{ $entidad->entidad_federativa_id }}" selected>{{ $entidad->nombre }}</option>
                                @else
                                    <option value="{{ $entidad->entidad_federativa_id }}">{{ $entidad->nombre }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato"><strong><span class="text-danger">* </span>Ciudad</strong></label>
                        <input type="text" name="ciudad" id="ciudad" class="form-control ciudad normalizar-texto" autocomplete="off" value="{{ $movimientoPersonal->ciudad }}" required>
                    </div>
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato"><strong><span class="text-danger">* </span>Alcaldía o Municipio</strong></label>
                        <input type="text" name="municipio_alcaldia" id="municipio_alcaldia" class="form-control municipio-alcaldia normalizar-texto" autocomplete="off" value="{{ $movimientoPersonal->municipio_alcaldia }}" required>
                    </div>
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato"><strong><span class="text-danger">* </span>Colonia</strong></label>
                        <select name="colonia" id="colonia" class="form-control select2 colonia" required>
                            <option value> Seleccione una colonia </option>
                            @if ($movimientoPersonal->colonia)
                                <option value="{{$movimientoPersonal->colonia}}" selected> {{$movimientoPersonal->colonia}} </option>
                            @endif
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="card card-custom mt-8">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Firmas del movimiento</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <label class="titulo-dato"><strong><span class="text-danger">* </span>Autorizador</strong></label>
                        <select name="autorizador" class="form-control" autocomplete="off" required>
                            <option value="">Selecciona una opción</option>
                            @foreach ($usersDGA as $user)
                                @if ($user->id == $movimientoPersonal->autorizador)
                                    <option value="{{ $user->id }}" selected> {{ "{$user->nombre} {$user->apellido_paterno} {$user->apellido_materno} - {$user->puesto}" }} </option>
                                @else
                                    <option value="{{ $user->id }}"> {{ "{$user->nombre} {$user->apellido_paterno} {$user->apellido_materno} - {$user->puesto}" }} </option>
                                @endif
                            @endforeach    
                        </select>
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="titulo-dato"><strong><span class="text-danger">* </span>Titular</strong></label>
                        <select name="titular" class="form-control" autocomplete="off" required>
                            <option value="">Selecciona una opción</option>
                            @foreach ($usersTitulares as $user)
                                @if ($user->id == $movimientoPersonal->titular)
                                    <option value="{{ $user->id }}" selected> {{ "{$user->nombre} {$user->apellido_paterno} {$user->apellido_materno} - {$user->puesto}" }} </option>
                                @else
                                    <option value="{{ $user->id }}"> {{ "{$user->nombre} {$user->apellido_paterno} {$user->apellido_materno} - {$user->puesto}" }} </option>
                                @endif
                            @endforeach    
                        </select>
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
@endsection

@push('scripts')
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
	<script src="{{ asset('js/componentes/busqueda_empleado.js') }}"></script>
	<script src="{{ asset('js/componentes/codigo_postalv2.js') }}"></script>
    <script src="{{ asset('js/p01_movimientos_personal/tareas/TR02_alimentarioReanudaciones.js?v=1.0')}}"></script>
    @if (!is_null($movimientoPersonal->nombre_empleado))
    <script>
        var plaza = @json($movimientoPersonal);
        $("#tabla_plaza").bootstrapTable({data: [plaza]});
    </script>
    @endif
@endpush
