@extends('layouts.main')

@section('title', 'Exportación de datos para creación de la nómina de prestaciones')

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
                'titulo' => 'Exportación de datos para creación de la nómina de prestaciones'
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

<form method="POST" action="{{route('pago.prestacion.exportar.nomina', [$pagoPrestacion, $instanciaTarea])}}" id="form_finalizar_tarea">
	@csrf
	<div class="card card-custom mt-10">
		<div class="card-header">
			<div class="card-title">
				<h3 class="card-label">Generación de XLS</h3>
			</div>
		</div>
		<div class="card-body">
			<p>Genere la nómina en archivo tipo hoja de cálculo.</p>
			<p>Guarde la hoja de cálculo en un lugar seguro y oprima el botón "Terminar el proceso" para salir.</small>
			<div class="text-center">
				<a class="btn btn-primary btn-lg" href="{{route('pago.prestacion.descargar.nomina', $pagoPrestacion)}}">
					<i class="fas fa-download"></i> Crear hoja de cálculo (Excel)
				</a>
			</div>
		</div>
		<div class="card-footer">
			<div class="text-center">
				<button type="submit" class="btn btn-success"><i class="fas fa-check-square"></i> Finalizar proceso</button>
			</div>
		</div>
	</div>
</form>

@endsection

@push('scripts')
	<script src="{{ asset('js/p07_pago_prestaciones/T05_exportarNomina.js') }}"></script>
@endpush
