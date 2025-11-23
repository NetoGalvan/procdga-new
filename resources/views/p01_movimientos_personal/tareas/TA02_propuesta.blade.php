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
    <form action="{{ route('movimiento.personal.altas.capturar.propuesta', [$movimientoPersonal, $instanciaTarea]) }}" method="POST" id="form_captura_propuesta">
        @csrf
        <div class="card card-custom">
            <div class="card-body">
                @include("p01_movimientos_personal.tareas.partials.datos_general", [
                    "secciones" => [
                        "general" => ["datos_generales", "tipo_movimiento"]
                    ]
                ])
            </div>
        </div>
        <div class="card card-custom mt-8">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Datos del candidato</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 form-group" >
                        <label for="fecha" class="titulo-dato"><strong><span class="text-danger">* </span>Fecha de solicitud:</strong></label>
                        <input type="text" class="form-control input-date-current" name="fecha_solicitud" value="{{ $movimientoPersonal->fecha_solicitud ?? "" }}" autocomplete="off" readonly required>
                    </div>
					<div class="col-md-3 form-group">
						<label class="titulo-dato"><strong><span class="text-danger">* </span>Nombre(s):</strong></label>
						<input class="form-control normalizar-texto" type="text" name="nombre_empleado" value="{{ $movimientoPersonal->nombre_empleado ?? "" }}" autocomplete="off" required>
					</div>
					<div class="col-md-3 form-group">
						<label class="titulo-dato"><strong><span class="text-danger">* </span>Primer apellido:</strong></label> 
						<input class="form-control normalizar-texto" type="text" name="apellido_paterno" value="{{ $movimientoPersonal->apellido_paterno ?? "" }}" autocomplete="off" required>
					</div>
					<div class="col-md-3 form-group">
						<label class="titulo-dato">Segundo apellido:</label> 
						<input class="form-control normalizar-texto" type="text" name="apellido_materno" value="{{ $movimientoPersonal->apellido_materno ?? "" }}" autocomplete="off">
					</div>
					<div class="col-md-3 form-group">
						<label class="titulo-dato"><strong><span class="text-danger">* </span>RFC:</strong></label> 
						<input class="form-control normalizar-texto" type="text" name="rfc" maxlength="13" rfc="true" value="{{ $movimientoPersonal->rfc ?? "" }}" autocomplete="off" required>
					</div>
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato"><strong><span class="text-danger">* </span>CURP:</strong></label>
                        <input type="text" class="form-control normalizar-texto" name="curp" maxlength="18" curp="true" value="{{ $movimientoPersonal->curp ?? "" }}" autocomplete="off" required>
                    </div>
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato"><strong><span class="text-danger">* </span>Nivel de estudios:</strong></label>
                        <select class="form-control" name="nivel_estudio_id" autocomplete="off" required>
                            <option value>Seleccione una opción</option>
                            @foreach ($nivelesEstudio as $nivelEstudio)
                                @if ($nivelEstudio->nivel_estudio_id == $movimientoPersonal->nivel_estudio_id)
                                    <option value="{{ $nivelEstudio->nivel_estudio_id }}" selected>{{ $nivelEstudio->nombre }}</option>
                                @else
                                    <option value="{{ $nivelEstudio->nivel_estudio_id }}">{{ $nivelEstudio->nombre }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato"><strong><span class="text-danger">* </span>Correo electrónico:</strong></label>
                        <input type="text" class="form-control" name="email" value="{{ $movimientoPersonal->email ?? "" }}" autocomplete="off" email="true" required/>
                    </div>
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato">Teléfono de casa:</label>
                        <input type="tel" class="form-control" name="telefono" value="{{ $movimientoPersonal->telefono ?? "" }}" autocomplete="off" number="true" maxlength="10">
                    </div>
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato">Teléfono celular:</label>
                        <input type="text" class="form-control" name="telefono_celular" value="{{ $movimientoPersonal->telefono_celular ?? "" }}" autocomplete="off" number="true" maxlength="10">
                    </div>
                </div>
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
                </div>
                <div class="row">
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato"><strong><span class="text-danger">* </span>Fecha propuesta para inicio de funciones:</strong></label>
                        <input type="text" class="form-control input-date-current" name="fecha_propuesta_inicio" value="{{ $movimientoPersonal->fecha_propuesta_inicio ?? "" }}" autocomplete="off" readonly required>
                    </div>
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato">@if ($movimientoPersonal->tipo_plaza == "TECNICO_OPERATIVO") Actividades plaza: @else <strong><span class="text-danger">* </span>Funciones plaza</strong> @endif</label>
                        <textarea class="form-control normalizar-texto" name="funciones_plaza">{{ $movimientoPersonal->funciones_plaza ?? "" }}</textarea>
                    </div>
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato">Observaciones plaza:</label>
                        <textarea class="form-control normalizar-texto" name="observaciones_plaza">{{ $movimientoPersonal->observaciones_plaza ?? "" }}</textarea>
                    </div>
                </div> 
            </div>
        </div>
        <div class="card card-custom mt-8">
            @if ($instanciaTarea->estatus == "NUEVO" && $movimientoPersonal->tipoMovimiento->codigo == "102")
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-3">
                        <label class="titulo-dato">Cita examen psicométrico</label>
                        <div>
                            <span class="switch switch-icon">
                                <label class="my-0">
                                    {{-- <input type="hidden" name="examen_psicometrico" value="0" /> --}}
                                    <input type="checkbox" name="examen_psicometrico" autocomplete="off" checked />
                                    <span class="my-0"></span>
                                </label>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            <div class="card-footer">
                <div class="text-center mt-2">
                    <button type="submit" class="btn btn-success"><i class="fas fa-check-square"></i> Finalizar tarea</button>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')	
	<script src="{{ asset('js/p01_movimientos_personal/tareas/TA02_propuesta.js?v=1.0')}}"></script>
@endpush
