@extends('layouts.main')

@section('title', 'Enviar a aprobación')

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
                'titulo' => 'Enviar a aprobación'
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
			<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
				<label class="titulo-dato"> Área: </label>
				<span><strong>{{ Auth::user()->area->identificador }} - {{Auth::user()->area->nombre }}</strong></span>
			</div>
			<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
				<label class="titulo-dato"> Folio: </label>
				<span> <strong>{{ $pagoPrestacion->folio }}</strong></span>
			</div>
			<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
				<label class="titulo-dato"> Tipo de prestación: </label>
				<span><strong>{{ $pagoPrestacion->tipoPrestacion->nombre }}</strong></span>
			</div>
			<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
				<label class="titulo-dato"> Fecha límite: </label>
				<span><strong>{{ $pagoPrestacion->fecha_limite }}</strong></span>
			</div>
		</div>
	</div>
</div>
<form method="POST" action="{{route('pago.prestacion.enviar.nomina', [$pagoPrestacion, $instanciaTarea])}}" id="form_finalizar_tarea">
	@csrf
	<div class="card card-custom mb-5">
		<div class="card-header">
			<div class="card-title">
				<h3 class="card-label">Usuarios y áreas</h3>
			</div>
		</div>
		<div class="card-body">
			<div class="alert alert-custom alert-success fade show mb-5" role="alert">
				<div class="alert-icon"><i class="flaticon-warning"></i></div>
				<div class="alert-text">Si ya está completa puede enviarla a aprobación por el JUD de Prestaciones.</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group" id="tablaGeneralAprobacion"></div>
				</div>
			</div>
			<p>Las tareas de llenado de datos están en este momento en el siguiente estado:</p>
			<div class="table-responsive">
				<table class="table table-bordered">
					<thead class="text-center">
						<tr>
							<th scope="col"><label class="titulo-dato">Asignado a</label></th>
							<th scope="col"><label class="titulo-dato">Estado</label></th>
						</tr>
					</thead>
						<tbody>
							@php
								use Illuminate\Database\Eloquent\Builder;
							@endphp
							@foreach ($subInstancias as $subInstancia)
								<tr>
									<td>
										{{ mb_strtoupper($subInstancia->area->nombre) }}
									</td>
									<td class="text-center">
										@if ($subInstancia->model->estatus == 'EN_PROCESO')
											<span class="label label-warning label-pill label-inline mr-2">EN PROGRESO</span>
										@elseif ($subInstancia->model->estatus == 'COMPLETADO')
											<span class="label label-success label-pill label-inline mr-2">TERMINADO</span>
										@endif
									</td>
								</tr>
							@endforeach
						</tbody>
				</table>
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
	<script src="{{ asset('js/p07_pago_prestaciones/T02_enviarAprobacion.js?v=1.0') }}"></script>
@endpush
