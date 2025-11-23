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
@endpush

@section('contenido')
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
    <form id="seleccionar_notas_buenas">
        <div class="card card-custom mt-8">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">
                        Aplicar notas buenas
                    </h3>
                </div>
            </div>
            <div class="card-body">
                <div class="alert alert-custom alert-success" role="alert">
                    <div class="alert-icon mr-4"><i class="flaticon-warning"></i></div>
                    <div class="alert-text">
                        <strong>
                            <p class="mb-2">Instrucciones:</p>
                            <ul class="mb-2"> 
                                <li>Indique el tipo de aplicación que desea agregar.</li>
                                <li>Seleccione las fechas que desea justificar.</li>
                                <li>Seleccione los sellos de nota buena que va a utilizar:  
                                    <ul>
                                        <li>Utilice 1 sello para justificar 1 retardo leve o 1 retardo grave.</li>
                                        <li>Utilice 3 sellos para justificar 1 falta.</li>
                                    </ul>
                                </li>
                            </ul>
                            <p class="mb-0">
                                Nota: En un solo trámite, puede agregar varias aplicaciones.
                            </p>
                        </strong>
                    </div>
                </div>        
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label class="titulo-dato"><span class="text-danger">*</span> Tipo aplicación</label>
                        <select name="tipo_aplicacion" class="form-control" autocomplete="off" required>
                            <option value="">Seleccionar una opción</option>
                            @foreach ($tiposJustificaciones as $indice => $tipoJustificacion)
                                <option value="{{ $indice }}">{{ $tipoJustificacion }}</option>
                            @endforeach 
                        </select>
                    </div>
                </div>
                <div class="row" id="contenedor_general" style="display: none;">
                    <div class="col-md-6 form-group" id="contenedor_fechas">
                        <label class="titulo-dato"><strong><span class="requeridos">* </span>Seleccionar fecha</strong></label>
                        <div class="repeater">
                            <div class="row repeater-item">
                                <div class="col-10">
                                    <input type="text" name="fechas[0]" class="form-control input-date" placeholder="Seleccionar fecha..." autocomplete="off" readonly required>
                                </div>
                                <div class="col-2">
                                    {{-- <button type="button" class="btn btn-light-primary btn-agregar-fecha-checador mr-2">
                                        <i class="fas fa-calendar-plus pr-0"></i>
                                    </button> --}}
                                    <button type="button" class="btn btn-light-danger btn-eliminar-fecha d-none">
                                        <i class="fas fa-trash-alt pr-0"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        {{-- <button type="button" id="btn_agregar_fecha" class="btn btn-sm btn-light-success mt-4">
                            <i class="fas fa-plus"></i> Agregar fecha
                        </button>  --}}
                    </div>
                    <div class="col-md-6 form-group" id="contenedor_notas_buenas">
                        <label class="titulo-dato"><span class="text-danger">*</span> Seleccionar notas buenas</label>
                        <select name="notas_buenas" class="form-control" autocomplete="off" style="height: 300px;" multiple required>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 form-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Agregar aplicación
                        </button>
                    </div>
                    <div class="col-12">
                        <div class="table-responsive">
                            <table
                                id="tabla_notas_buenas"
                                class="text-center table-striped"
                                data-toggle="table"
                                data-unique-id="id">
                                <thead>
                                    <tr>
                                        <th data-field="tipo_aplicacion" data-formatter="nbTipoApliacionFormatter"><label class="titulo-dato">Tipo aplicación</label></th>
                                        <th data-field="fechas" data-formatter="nbFechasFormatter"><label class="titulo-dato">Fechas</label></th>
                                        <th data-field="notas_buenas" data-formatter="nbNotasBuenasFormatter"><label class="titulo-dato">Notas Buenas</label></th>
                                        <th data-field="acciones" data-formatter="nbAccionesFormatter" data-events="operateEventsAcciones"><label class="titulo-dato">Acciones</label></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <form method="POST" id="form_finalizar_tarea" action="{{ route("tramite.incidencia.aplicacion.notas.buenas", [$tramiteIncidencia, $instanciaTarea]) }}">
        @csrf
        <input type="hidden" name="aplicaciones_notas_buenas" />
        <div class="card card-custom mt-8">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">
                        Completar la información del trámite
                    </h3>
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
                                <li>Ingrese las observaciones.</li>
                            </ul>
                        </strong>
                    </div>
                </div>     
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label class="titulo-dato"><span class="requeridos">* </span> <b> Nombre del jefe inmediato </b> </label>
                        <input type="text" class="form-control normalizar-texto" name="nombre_jefe_inmediato" value="{{ old("nombre_jefe_inmediato") ?? "" }}" autocomplete="off" required/>
                    </div>
                    <div class="col-md-4 form-group">
                        <label class="titulo-dato"><span class="requeridos">* </span> <b> Cargo del jefe inmediato </b> </label>
                        <input type="text" class="form-control normalizar-texto" name="cargo_jefe_inmediato" value="{{ old("cargo_jefe_inmediato") ?? "" }}" autocomplete="off" required/>
                    </div>
                    <div class="col-md-12 form-group">
                        <label class="titulo-dato"><span class="requeridos">* </span> <b> Observaciones </b> </label>
                        <textarea class="form-control normalizar-texto" name="observaciones" autocomplete="off" required>{{ old("observaciones") ?? "" }}</textarea>
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

    <div class="card card-custom mt-8">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">Incidencias autorizadas del empleado</h3>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table
                    id="tabla_incidencias_empleado"
                    class="text-center text-uppercase"
                    data-toggle="table"
                    data-search="true"
                    data-ajax="getIncidenciasEmpleado"
                    data-pagination="true"
                    data-page-size="20"
                    data-pagination-h-align="left"
                    data-pagination-detail-h-align="right">
                    <thead>
                        <tr>
                            <th data-field="tipo_captura.identificador" data-formatter="tipoCapturaFormatter" data-searchable="false"><label class="titulo-dato">Tipo captura</label></th>
                            <th data-field="folio_autorizacion" data-searchable="true"><label class="titulo-dato">Folio autorización</label></th>
                            <th data-field="numero_documento" data-formatter="numeroDocumentoFormatter" data-searchable="false"><label class="titulo-dato">Número documento</label></th>
                            <th data-field="fechas" data-formatter="fechasFormatter" data-searchable="false"><label class="titulo-dato">Fechas</label></th>
                            <th data-field="total_dias" data-formatter="totalDiasFormatter" data-searchable="false"><label class="titulo-dato">Total días</label></th>
                            <th data-field="horario" data-formatter="horarioFormatter" data-searchable="false"><label class="titulo-dato">Horario</label></th>
                            <th data-field="notas_buenas" data-formatter="notasBuenasFormatter" data-searchable="false"><label class="titulo-dato">Notas Buenas</label></th>
                            <th data-field="tipo_incidencia.tipo_justificacion.nombre" data-searchable="true"><label class="titulo-dato">Tipo justificación</label></th>
                            <th data-field="tipo_incidencia.descripcion" data-formatter="descripcionFormatter" data-searchable="false"><label class="titulo-dato">Descripción</label></th>
                            <th data-field="tipo_incidencia.articulo" data-formatter="articuloFormatter" data-searchable="true"><label class="titulo-dato">Artículo</label></th>
                            <th data-field="tipo_incidencia.subarticulo" data-formatter="subarticuloFormatter" data-searchable="false"><label class="titulo-dato">Subartículo</label></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <form method="POST" id="form_agregar_fecha_checador" action="action">
        <div class="modal fade" id="modal_fechas_checador" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content" style="max-height: 600px;">
                    <div class="modal-header">
                        <h5 class="modal-title" id="titulo_modal_fechas_checador"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12" id="contenedor_fechas_retardos_faltas">
                                <select name="fechas_retardos_faltas" class="form-control" autocomplete="off" required>
                                    <option value="">Seleccionar una opción</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary font-weight-bold">Agregar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        var rutaGetNotasBuenas = @json(route("tramite.incidencia.getNotasBuenas", $tramiteIncidencia));
        var urlGetIncidenciasEmpleado = @json(route("tramite.incidencia.getIncidenciasEmpleado", $tramiteIncidencia));
    </script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
    <script src="{{ asset('js/p12_tramites_incidencias/partials/tabla_incidencias_empleado.js?v=1.7') }}"></script>
    <script src="{{ asset('js/p12_tramites_incidencias/partials/cancelar_proceso.js?v=1.0') }}"></script>
    <script src="{{ asset('js/p12_tramites_incidencias/tareas/T02_aplicacionNotasBuenas.js?v=1.12') }}"></script>
@endpush
