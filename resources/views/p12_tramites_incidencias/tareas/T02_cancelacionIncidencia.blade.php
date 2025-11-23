@extends("layouts.main")

@section("title", $instanciaTarea->tarea->nombre)

@section("subheader")
    @include("layouts.partials.main.subheader", ["subheader" => [
        "titulo_subheader" => "PROCDGA",
        "icono_titulo_subheader" => "far fa-folder-open",
        "breadcrumbs" => [
            1 => [
                "activo" => false,
                "titulo" => "Tareas disponibles",
                "ruta" => Route('tareas')
            ],
            2 => [
                "activo" => true,
                "titulo" => $instanciaTarea->tarea->nombre
            ]
        ]
    ]])
@endsection

@section('aside_menu')
    @include('layouts.partials.main.aside_menu', ["asideMenu" => ["item_seleccionado" => "tareas"]])
@endsection

@push('styles')
    <link href="{{ asset('metronic/plugins/custom/bootstraptable/css/bootstrap-table.min.css') }}" type="text/css" rel="stylesheet"/>
    <style>
        #tabla_tramites_incidencias > tbody tr {
            cursor: pointer;
        }
    </style>
@endpush

@section('contenido')
    <form method="POST" id="form_finalizar_tarea" action="{{ route("tramite.incidencia.cancelacion.incidencia", [$tramiteIncidencia, $instanciaTarea]) }}">
        @csrf
        <div class="card card-custom">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Detalle del proceso</h3>
                </div>
            </div>
            <div class="card-body">
                @include("p12_tramites_incidencias.partials.datos_general", [
                    "secciones" => ["general", "captura", "empleado"]
                ])
            </div>
        </div>
        <div class="card card-custom mt-8">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Seleccionar el folio a cancelar</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="alert alert-custom alert-success" role="alert">
                    <div class="alert-icon mr-4"><i class="flaticon-warning"></i></div>
                    <div class="alert-text">
                        <strong>
                            <p class="mb-2">Instrucciones:</p>
                            <ul class="mb-0">
                                <li>Agregue el nombre y cargo del jefe inmediato.</li>
                                <li>Explique los motivos de la cancelación.</li>
                                <li>Seleccione el folio que desea cancelar.</li>
                            </ul>
                        </strong>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label class="titulo-dato">Número documento</label>
                        <input type="text" class="form-control normalizar-texto" name="numero_documento" value="{{ old("numero_documento") ?? "" }}" autocomplete="off" />
                    </div>
                    <div class="col-md-4 form-group">
                        <label class="titulo-dato"><span class="requeridos">* </span> <b> Nombre del jefe inmediato </b> </label>
                        <input type="text" class="form-control normalizar-texto" name="nombre_jefe_inmediato" autocomplete="off" required/>
                    </div>
                    <div class="col-md-4 form-group">
                        <label class="titulo-dato"><span class="requeridos">* </span> <b> Cargo del jefe inmediato </b> </label>
                        <input type="text" class="form-control normalizar-texto" name="cargo_jefe_inmediato" autocomplete="off" required/>
                    </div>
                    <div class="col-md-12 form-group">
                        <label class="titulo-dato"><span class="requeridos">* </span> <b> Motivos </b> </label>
                        <textarea class="form-control normalizar-texto" name="motivo_cancelacion" autocomplete="off" required></textarea>
                    </div>
                    <div class="col-md-12 form-group">
                        <label class="titulo-dato"><span class="requeridos">* </span> <b> Seleccionar folio </b> </label>
                        <input type="hidden" name="tramite_incidencia">
                        <div class="table-responsive">
                            <table
                                id="tabla_tramites_incidencias"
                                class="text-center text-uppercase"
                                data-toggle="table"
                                data-search="true" 
                                data-pagination="true"
                                data-page-size="20"
                                data-pagination-h-align="left"
                                data-pagination-detail-h-align="right">
                                <thead>
                                    <tr>
                                        <th data-field="is_selected" data-radio="true"></th>
                                        <th data-field="folio" data-searchable="true"><label class="titulo-dato">Folio</label></th>
                                        <th data-field="tipo_captura.identificador" data-formatter="tipoCapturaFormatter" data-searchable="false"><label class="titulo-dato">Tipo captura</label></th>
                                        <th data-field="tipo_tramite" data-searchable="false" data-formatter="tipoTramiteFormatter"><label class="titulo-dato">Tipo trámite</label></th>
                                        <th data-field="acciones" data-searchable="false" data-formatter="accionesFormatter" data-events="accionesEvents"><label class="titulo-dato">Acciones</label></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="text-center">
                    <button type="submit" class="btn btn-success mr-2"><i class="fas fa-check-square"></i> Finalizar tarea </button>
                    <button type="button" class="btn btn-danger" id="btn_cancelar"><i class="fas fa-times"></i> Cancelar proceso </button>
                </div>
            </div>
        </div>
    </form>
    <div class="modal fade" id="modal_detalle_tramite_incidencia" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detalle</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive mt-4">
                        <table
                            id="tabla_incidencias_empleado"
                            class="text-center text-uppercase"
                            data-toggle="table"
                            data-pagination="true"
                            data-page-size="10"
                            data-pagination-h-align="left"
                            data-pagination-detail-h-align="right">
                            <thead>
                                <tr>
                                    <th data-field="fechas" data-formatter="fechasFormatter"><label class="titulo-dato">Fechas</label></th>
                                    <th data-field="total_dias" data-formatter="totalDiasFormatter"><label class="titulo-dato">Total días</label></th>
                                    <th data-field="horario" data-formatter="horarioFormatter"><label class="titulo-dato">Horario</label></th>
                                    <th data-field="notas_buenas" data-formatter="notasBuenasFormatter"><label class="titulo-dato">Notas Buenas</label></th>
                                    <th data-field="tipo_incidencia.tipo_justificacion.nombre"><label class="titulo-dato">Tipo justificación</label></th>
                                    <th data-field="tipo_incidencia.descripcion" data-formatter="descripcionFormatter"><label class="titulo-dato">Descripción</label></th>
                                    <th data-field="tipo_incidencia.articulo" data-formatter="articuloFormatter"><label class="titulo-dato">Artículo</label></th>
                                    <th data-field="tipo_incidencia.subarticulo" data-formatter="subarticuloFormatter"><label class="titulo-dato">Subartículo</label></th>
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
    <script>
        const tramitesIncidencias = @json($tramitesIncidencias);
    </script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
    <script src="{{ asset('js/p12_tramites_incidencias/partials/tabla_incidencias_empleado.js?v=1.8') }}"></script>
    <script src="{{ asset('js/p12_tramites_incidencias/partials/cancelar_proceso.js?v=1.0') }}"></script>
    <script src="{{ asset('js/p12_tramites_incidencias/tareas/T02_cancelacionIncidencia.js?v=1.8') }}"></script>
@endpush

