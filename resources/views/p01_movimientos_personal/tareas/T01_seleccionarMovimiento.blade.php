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
	<form action="{{ route("movimiento.personal.seleccionar.movimiento", [$movimientoPersonal, $instanciaTarea]) }}" method="POST" id="id_form_seleccion_movimiento">
		@csrf
		<div class="card card-custom">
            <div class="card-body">
                @include("p01_movimientos_personal.tareas.partials.datos_general", [
                    "secciones" => [
                        "general" => ["datos_generales"]
                    ]
                ])
            </div>
        </div>
		<div class="card card-custom mt-8">
			<div class="card-header">
				<div class="card-title">
					<h3 class="card-label">Selección de movimiento</h3>
				</div>
			</div>
			<div class="card-body">
				<div class="alert alert-custom alert-outline-success" role="alert">
					<div class="alert-icon"><i class="flaticon-warning"></i></div>
					<div class="alert-text">
						Seleccione el tipo de movimiento de personal que
						desea realizar y el tipo de plaza. 
					</div>
				</div>
				<div class="row">
					<div class="col-md-4 form-group">
						<label class="titulo-dato"><strong><span class="text-danger">* </span>Tipo de movimiento</strong></label>
						<select class="form-control select2" id="tipo_movimiento_id" name="tipo_movimiento_id" autocomplete="off" required>
							<option value="">Selecciona una opción</option>
							@foreach ($tiposMovimientos as $tipoMovimiento => $movimientos) 
								<optgroup label="{{ $tipoMovimiento }}">
									@foreach ($movimientos as $movimiento)
										@if ($movimiento->tipo_movimiento_id == $movimientoPersonal->tipo_movimiento_id)
											<option value="{{ $movimiento->tipo_movimiento_id }}" selected>{{ $movimiento->codigo }} - {{ $movimiento->descripcion }}</option>
										@else
											<option value="{{ $movimiento->tipo_movimiento_id }}">{{ $movimiento->codigo }} - {{ $movimiento->descripcion }}</option>
										@endif
									@endforeach
								</optgroup>
							@endforeach
						</select>
					</div>
					<div class="col-md-4 col-lg-6 col-xl-4 form-group">
						<label class="titulo-dato"><strong><span class="text-danger">* </span>Tipo de plaza</strong></label>
						<div class="radio-inline">
							<label class="radio radio-success">
								<input type="radio" name="tipo_plaza" checked value="TECNICO_OPERATIVO" autocomplete="off"/>
								<span></span>
								Técnico operativo
							</label>
							<label class="radio radio-success">
								<input type="radio" name="tipo_plaza" value="ESTRUCTURA"/>
								<span></span>
								Estructura
							</label>
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
@endsection

@push('scripts')	
	<script src="{{ asset('js/p01_movimientos_personal/tareas/T01_seleccionarMovimiento.js')}}?v=1.1"></script>
@endpush



