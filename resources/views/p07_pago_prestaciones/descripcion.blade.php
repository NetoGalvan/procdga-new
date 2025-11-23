@extends('layouts.main')

@section('title', 'Descripción')

@section('subheader')
    @include('layouts.partials.main.subheader', ["subheader" => [
        "titulo_subheader" => "PROCDGA",
        "icono_titulo_subheader" => "far fa-folder-open",
        "breadcrumbs" => [
            1 => [
                'activo' => false,
                'titulo' => 'Procesos',
                'ruta' => Route('procesos')
            ],
            2 => [
                'activo' => true,
                'titulo' => 'Descripción'
            ]
        ]
    ]])
@endsection

@section('aside_menu')
    @include('layouts.partials.main.aside_menu', ["asideMenu" => ["item_seleccionado" => "procesos"]])
@endsection

@section('contenido')
	<form id="form_finalizar_tarea" action="{{ route('pago.prestacion.inicializarProceso') }}" method="POST">
		@csrf
		<div class="card card-custom">
			<div class="card-header">
				<div class="card-title">
					<h3 class="card-label">Pago de prestaciones</h3>
				</div>
			</div>
			<div class="card-body">
				<p>
					Proceso diseñado para facilitar el trámite y gestión del pago de
					prestaciones a los trabajadores de la Secretaría del Gobierno del
					Distrito Federal, con base en el Capitulo XV De las Prestaciones
					Económicas y Sociales contenidas en las CGT.<br> A que se refieren
					el Artículo 150: Independientemente de lo establecido en la Ley y
					en estas Condiciones, el Gobierno otorgará a los trabajadores las
					siguientes prestaciones:
				</p>
				<ul>
					<li>Fracción IV. Apoyo económico de seis días de salario mínimo
						burocrático diario del tabulador de salarios del Gobierno Federal
						por concepto del día del niño, para el trabajador que demuestre
						tener algún hijo en un rango de edad de un día hasta 10 años.</li>
					<li>Fracción XIII. Por concepto de día de la madre y de día del
						padre, la cantidad de quinientos pesos, a las trabajadores y a los
						trabajadores que se encuentren en este supuesto.</li>
					<li>Fracción XIV. De la Ley Orgánica de la Administración Pública
						del D.f. Para el otorgamiento del Apoyo Económico para Útiles
						Escolares, consiste en apoyar al personal técnico operativo que se
						encuentre en servicio activo y que ostente dígito sindical.</li>
					<li>Generar el folio de aceptación para iniciar el proceso de
						Movimientos de Personal.</li>
				</ul>
			</div>
			<div class="card-footer">
				<div class="text-center">
					<button type="submit" class="btn btn-success"><i class="fas fa-arrow-alt-circle-right"></i> Iniciar proceso</button>
				</div>
			</div>
		</div>
	</form>
@endsection

@push('scripts')
	<script src="{{ asset('js/p07_pago_prestaciones/descripcion.js?v=1.1') }}"></script>
@endpush
