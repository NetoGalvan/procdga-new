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
	<form id="formAlimentarioBajas" action="{{route('movimiento.personal.bajas.alimentario', [$movimientoPersonal, $instanciaTarea])}}" method="POST">
		@csrf
        <div class="card card-custom">
            <div class="card-body">
                @include("p01_movimientos_personal.tareas.partials.datos_general_bajas", [
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
                        <label for="fecha" class="titulo-dato"><strong><span class="text-danger">* </span>Fecha de solicitud:</strong></label>
                        <input type="text" class="form-control input-date-current" name="fecha_solicitud" value="{{ $movimientoPersonal->fecha_solicitud ?? "" }}" autocomplete="off" readonly required>
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
                    <div class="col-12 form-group">
                        <div class="table-responsive">
                            <table
                                id="tabla_plaza"
                                data-toggle="table">
                                <thead>
                                    <tr>
                                        <th data-field="numero_plaza"><label class="titulo-dato">Número plaza</label></th>
                                        <th data-field="codigo_puesto"><label class="titulo-dato">Código Puesto</label></th>
                                        <th data-field="puesto"><label class="titulo-dato">Puesto</label></th>
                                        <th data-field="codigo_universo"><label class="titulo-dato">Universo</label></th>
                                        <th data-field="codigo_situacion_empleado"><label class="titulo-dato">Situación empleado</label></th>
                                        <th data-field="nivel_salarial"><label class="titulo-dato">Nivel Salarial</label></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
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
    <script src="{{ asset('js/p01_movimientos_personal/tareas/TB02_alimentarioBajas.js?v=1.2')}}"></script>
    @if (!is_null($movimientoPersonal->nombre_empleado))
    <script>
        var plaza = @json($movimientoPersonal);
        $("#tabla_plaza").bootstrapTable({data: [plaza]});
    </script>
    @endif
@endpush
