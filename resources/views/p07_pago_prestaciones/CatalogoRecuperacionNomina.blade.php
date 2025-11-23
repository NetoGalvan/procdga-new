 @extends('layouts.main') @section('breadcrumbs')
@include('componentes.breadcrumbs', ['breadcrumbs' => [ [
'activo'=>false, 'titulo' => 'Tareas disponibles', 'ruta' =>
Route('tareas') ], [ 'activo' => true, 'titulo' => 'Recuperación de
nóminas de prestaciones generadas anteriormente '], ] ]) @endsection
@section('contenido') @push('styles')
<link rel="stylesheet"
	href="{{ asset('css/p07_pago_prestaciones/T03_aprobacionNominaPrestacion.css') }}" />
@endpush
<h1 class="my-5 text-center titulo-tarea">Recuperación de nóminas de
	prestaciones generadas anteriormente</h1>



<div class="row">
	<div class="col-md-12">
		<div class="card shadow-sm mb-5 px-5 py-4 bg-white rounded sinMargen">
			<h2 class="titulo-formulario">Estas son las nóminas de prestaciones
				que se han generado en el tiempo</h2>
			<hr style="color: #0056b2;" />
			<p class="texto-normal">Listado de nóminas de prestaciones en el
				sistema :</p>
			<div class="row">
				<div class="col-md-12">
					<table id="tablaCatalogosRecuperacionNomina"
						class="table table-bordered table-striped table-general"
						data-toggle="table" data-ajax="ajaxRequest"
						data-total-field="total" data-data-field="data"
						data-side-pagination="server" data-pagination="true"
						data-query-params="queryParams" data-search="true">
						<thead>
							<tr>
								<th data-field="nombre" data-align="center"><label
									for="" class="titulo-dato">Nombre Prestacion</label></th>
								<th data-field="created_at" data-align="center"><label for=""
									class="titulo-dato">Fecha de Inicio</label></th>
								<th data-field="estatus_trabajo" data-align="center"><label
									for="" class="titulo-dato">Estatus</label></th>
								<th data-field="folio" data-align="center"><label for=""
									class="titulo-dato">Folio</label></th>
								<th data-align="center" data-formatter="eliminarBoton"><label
									for="" class="titulo-dato">Acciones</label></th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
			<!-- 			<p class="texto-normal">Las tareas de llenado de datos están en este -->
			<!-- 				momento en el siguiente estado:</p> -->
			<!-- 			<div class="row"> -->
			<!-- 				<div class="col-md-12"> -->
			<!-- 					<div class="mb-4 mt-3"> -->
			<!-- 						<table class="table table-bordered table-general" -->
			<!-- 							id="tablaUsuarios" data-toggle="table" data-show-columns="false"> -->
			<!-- 							<thead> -->
			<!-- 								<tr> -->
			<!-- 									<th data-formatter="nombreUsuarios"><label for="" -->
			<!-- 										class="titulo-dato">Asignado a</label></th> -->

			<!-- 									<th data-formatter="estados"><label for="" class="titulo-dato">Estado</label></th> -->
			<!-- 								</tr> -->
			<!-- 							</thead> -->
			<!-- 						</table> -->
			<!-- 					</div> -->
			<!-- 				</div> -->
			<!-- 			</div> -->

			<!-- 			<div id="errorMensajes"></div> -->
		</div>
	</div>
</div>

<script>

var urlRecuperacionNominas= "{{route('pago.prestacion.catalogo.recuperacion.nomina')}}";

</script>
@endsection @push('scripts')
<script
	src="{{ asset('js/p07_pago_prestaciones/CatalogoRecuperacionNomina.js') }}"></script>
@endpush
