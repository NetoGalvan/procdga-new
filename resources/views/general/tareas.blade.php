@extends('layouts.main') 

@section('title', 'Tareas')

@section('subheader')
    @include('layouts.partials.main.subheader', ["subheader" => [
        "titulo_subheader" => "Tareas",
        "icono_titulo_subheader" => "far fa-folder-open",
        "breadcrumbs" => [
            1 => [
                "activo" => true,
                "titulo" => 'Inicio'
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
	<link href="{{ asset('metronic/plugins/custom/bootstraptable/css/bootstrap-table.min.css') }}" type="text/css" rel="stylesheet" />
@endpush

@section('contenido')
	<div class="card card-custom">
		<div class="card-body">
			<div class="table-responsive">
				<table 
					class="table text-center table-row-redirect" 
					id="tabla_tareas"
					data-toggle="table"
                    data-ajax="getTareas"
                    data-data-field="data"
                    data-total-field="total"
                    data-side-pagination="server"
                    data-query-params="queryParams"
                    data-pagination="true"
                    data-search="true"
                    data-pagination-h-align="left"
                    data-pagination-detail-h-align="right"
                    data-search-align="right">
					<thead>
						<tr>
							<th data-field="instancia.proceso.nombre" data-formatter="nombreProcesoFormatter"><label class="titulo-dato">Proceso</label></th>
							<th data-field="tarea.nombre"><label class="titulo-dato">Tarea</label></th>
							<th data-field="instancia.model.folio"><label class="titulo-dato">Folio</label></th>
							<th data-field="creado_por_usuario" data-formatter="creadoPorUsuarioFormatter"><label class="titulo-dato">Creado por usuario</label></th>
							<th data-field="creado_por_area" data-formatter="creadoPorAreaFormatter"><label class="titulo-dato">Creado por área</label></th> 
							<th data-field="estatus" data-formatter="estatusFormmatter"><label class="titulo-dato">Estatus</label></th>
							<th data-field="updated_at" data-formatter="fechaFormatter"><label class="titulo-dato">Fecha de creación</label></th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
@endsection 

@push('scripts')
    <script>
        const urlGetTareas = @json(route("getTareas", ["TAREA", "REGISTROS"]));
    </script>
	<script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/momentjs/moment.min.js') }}"></script>
	<script src="{{ asset('js/general/tareas.js?v=1.9') }}"></script>
@endpush

