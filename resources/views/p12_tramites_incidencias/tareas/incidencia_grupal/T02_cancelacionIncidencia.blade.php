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
    <div class="card card-custom">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">Detalle del proceso</h3>
            </div>
        </div>
        <div class="card-body">
            @include("p12_tramites_incidencias.partials.datos_general_incidencia_grupal", [
                "secciones" => ["general", "tipo_captura"]
            ])
        </div>
    </div>
    
    <form method="POST" id="form_finalizar_tarea" action="{{ route("tramite.incidencia.grupal.cancelacion.incidencia", [$tramiteIncidencia, $instanciaTarea]) }}">
        @csrf
        <div class="card card-custom mt-8">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Seleccionar el folio de la incidencia grupal</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="alert alert-custom alert-success" role="alert">
                    <div class="alert-icon mr-4"><i class="flaticon-warning"></i></div>
                    <div class="alert-text">
                        <strong>
                            <p class="mb-2">Instrucciones:</p>
                            <ul class="mb-0">
                                <li>Opcional: Agregue un número de documento.</li>
                                <li>Seleccione el tipo de cancelación:
                                    <ul>
                                        <li><strong>Total:</strong> Para eliminar toda la incidencia grupal.</li>
                                        <li><strong>Parcial:</strong> Para remover solamente a uno o varios empleados.</li>
                                    </ul>
                                </li>                                
                                <li>Seleccione el folio del trámite de incidencia grupal.</li>
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
                        <label class="titulo-dato"><strong><span class="text-danger">*</span> Tipo cancelación</strong></label>
                        <select name="tipo_cancelacion" class="form-control" required>
                            <option value="">Seleccione una opción</option>
                            <option value="TOTAL">TOTAL</option>
                            <option value="PARCIAL">PARCIAL</option>
                        </select>
                    </div>
                    <div class="col-md-12 form-group">
                        <label class="titulo-dato"><span class="requeridos">* </span> <b> Motivos </b> </label>
                        <textarea class="form-control normalizar-texto" name="motivo_cancelacion" autocomplete="off" required></textarea>
                    </div>
                    <div class="col-md-12">
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
                                        <th data-field="tipo_captura.nombre" data-searchable="false"><label class="titulo-dato">Tipo captura</label></th>
                                        <th data-field="tipo_tramite" data-searchable="false" data-formatter="tipoTramiteFormatter"><label class="titulo-dato">Tipo trámite</label></th>
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
@endsection

@push('scripts')
    <script>
        const tramitesIncidencias = @json($tramitesIncidencias);
    </script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
    <script src="{{ asset('js/p12_tramites_incidencias/partials/cancelar_proceso.js?v=1.0') }}"></script>
    <script src="{{ asset('js/p12_tramites_incidencias/tareas/incidencia_grupal/T02_cancelacionIncidencia.js?v=1.0') }}"></script>
@endpush
