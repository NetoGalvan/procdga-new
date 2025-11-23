@extends('layouts.main')

@section('title', 'Procesos en curso')

@section('subheader')
    @include('layouts.partials.main.subheader', ["subheader" => [
        "titulo_subheader" => "Procesos en curso",
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
            "item_seleccionado" => "procesos-en-curso",
        ]
    ])
@endsection

@push('styles')
	<link href="{{ asset('metronic/plugins/custom/bootstraptable/css/bootstrap-table.min.css') }}" type="text/css" rel="stylesheet"/>
@endpush

@section('contenido')
    <div class="card card-custom">
        <div class="card-body">
            <div class="table-responsive">
                <table
                    id="tabla_procesos_en_curso"
                    class="table table-general"
                    data-toggle="table"
                    data-unique-id="instancia_id"
                    data-ajax="getProcesosEnCurso"
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
                            <th data-field="instancia.model.folio" class="text-center"><label class="titulo-dato">Folio</label></th>
                            <th data-field="instancia.proceso.nombre" class="text-center" data-formatter="nombreProcesoFormatter"><label class="titulo-dato">Proceso</label></th>
                            <th data-field="created_at" class="text-center" data-formatter="fechaInstanciaFormatter"><label class="titulo-dato">Fecha inicio trámite</label></th>
                            <th data-field="instancia.model.estatus" class="text-center" data-formatter="estatusInstanciaFormatter"><label class="titulo-dato">Estatus</label></th>
                            <th data-field="acciones" class="text-center" data-formatter="acccionesFormatterProcesosEnCurso"><label class="titulo-dato">Acciones</label></th>
                        </tr>
                    </thead>
                </table>
            </div>
		</div>
	</div>
    <div class="modal fade" id="modal_proceso_en_curso" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tareas realizadas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body" style="max-height: 500px;">
                    <div class="table-responsive">
                        <table
                            id="tabla_avance_tareas"
                            class="table text-center"
                            data-toggle="table">
                            <thead>
                                <tr>
                                    <th data-field="estatus" data-formatter="estatusFormatter"><label class="titulo-dato">Estatus</label></th>
                                    <th data-field="asignado_al_rol.label"><label class="titulo-dato">Asignado al rol</label></th>
                                    <th data-field="tarea.nombre"><label class="titulo-dato">Nombre tarea</label></th>
                                    <th data-field="creado_por_usuario" data-formatter="creadoPorUsuarioFormatter"><label class="titulo-dato">Creado por usuario</label></th>
                                    <th data-field="creado_por_area" data-formatter="creadoPorAreaFormatter"><label class="titulo-dato">Creado por área</label></th>
                                    <th data-field="autorizado_por_usuario" data-formatter="autorizadoPorUsuarioFormatter"><label class="titulo-dato">Finalizado por usuario</label></th>
                                    <th data-field="autorizado_por_area" data-formatter="autorizadoPorAreaFormatter"><label class="titulo-dato">Finalizado por área</label></th>
                                    <th data-field="created_at" data-formatter="fechaFormatter"><label class="titulo-dato">Fecha</label></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
	<script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/momentjs/moment.min.js') }}"></script>
    <script>
        var urlGetProcesosEnCurso = @json(route('getProcesosEnCurso'));
        var urlAvanceDelProceso = @json(route('proceso.en.curso.avance'));
	</script>
	<script src="{{ asset('js/general/procesos_en_curso.js?v=1.11') }}"></script>
@endpush

