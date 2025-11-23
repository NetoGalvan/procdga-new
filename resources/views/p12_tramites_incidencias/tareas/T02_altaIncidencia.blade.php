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
    <form method="POST" id="form_finalizar_tarea" action="{{ route("tramite.incidencia.alta.incidencia", [$tramiteIncidencia, $instanciaTarea]) }}">
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
                    <h3 class="card-label">Ingresar los datos de la incidencia</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="alert alert-custom alert-success" role="alert">
                    <div class="alert-icon mr-4"><i class="flaticon-warning"></i></div>
                    <div class="alert-text">
                        <strong>
                            <p class="mb-2">Instrucciones:</p>
                            <ul class="mb-0">
                                <li>Seleccione el tipo de incidencia.</li>
                                <li>Proporcione el número de documento si aplica.</li>
                                <li>Agregue el nombre y cargo del jefe inmediato.</li>
                                <li>Establezca la fecha de inicio y la fecha final en la que va a aplicar la incidencia.</li>
                                <li>Ingrese las observaciones:
                                    <ul>
                                        <li>Incluya el año de las vacaciones si aplica.</li>
                                    </ul>
                                </li>
                            </ul>
                        </strong>
                    </div>
                </div>              
                <div class="row">
                    <div class="col-md-12 form-group">
                        <label class="titulo-dato"><span class="requeridos">* </span> <b> Tipo Incidencia </b> </label>
                        <select class="form-control text-uppercase select2" name="tipo_incidencia_id" autocomplete="off" required>
                            <option value=""> Seleccione una opción </option>
                        </select>
                        <div id="contenedor_detalle_tipo_incidencia" class="table-responsive mt-8 d-none">
                            <table
                                id="tabla_detalle_tipo_incidencia"
                                class="text-center text-uppercase"
                                data-toggle="table">
                                <thead>
                                    <tr>
                                        <th data-field="tipo_justificacion.nombre"><label class="titulo-dato">Tipo justificación</label></th>
                                        <th data-field="articulo" data-formatter="articuloFormatter"><label class="titulo-dato">Artículo</label></th>
                                        <th data-field="subarticulo" data-formatter="subarticuloFormatter"><label class="titulo-dato">Subartículo</label></th>
                                        <th data-field="descripcion" data-formatter="descripcionFormatter"><label class="titulo-dato">Descripción</label></th>
                                        <th data-field="ley"><label class="titulo-dato">Ley</label></th>
                                        <th data-field="intervalo_evaluacion" data-formatter="intervaloEvaluacionFormatter"><label class="titulo-dato">Intervalo</label></th>
                                        <th data-field="sexo" data-formatter="sexoFormatter"><label class="titulo-dato">Sexo</label></th>
                                        <th data-field="tipo_dias"><label class="titulo-dato">Tipo días</label></th>
                                        <th data-field="tipo_empleado" data-formatter="tipoEmpleadoFormatter"><label class="titulo-dato">Tipo de empleado</label></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row" id="contenedor_fechas" style="display: none">
                    <div class="col-md-6 form-group" id="contenedor_horario" style="display: none">
                        <label class="titulo-dato"><span class="requeridos">* </span> <b> Horario </b> </label>
                        <select class="form-control text-uppercase select2" name="horario_id" autocomplete="off" required>
                            <option value=""> Seleccione una opción </option>
                            @foreach ($horarios as $horario)
                                <option value="{{ $horario->horario_id }}" @if (old("horario_id") && old("horario_id") == $horario->horario_id) selected @endif> 
                                    {{ $horario->entrada }} @if (!is_null($horario->salida)) - {{ $horario->salida }} @endif ·
                                    @foreach ($horario->diasFormatoString as $dia)
                                        {{ $dia }}
                                    @endforeach 
                                    @if ($horario->dias_festivos_son_laborales) · <strong> DIAS FESTIVOS </strong> @endif
                                    · {{ str_replace("_", " ", $horario->tipo_empleado) }}
                                </option> 
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato"><span class="requeridos">* </span> <b> Fecha inicio y Fecha final </b> </label>
                        <input type="text" class="form-control" id="input_rango_fecha" placeholder="Selecciona un rango de fechas" autocomplete="off" readonly required/>
                        <input type="hidden" name="fecha_inicio" />
                        <input type="hidden" name="fecha_final" />
                    </div>
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato"><span class="requeridos">* </span> <b> Total días </b> </label>
                        <input type="text" class="form-control" name="total_dias" value="{{ old("total_dias") ?? "" }}" autocomplete="off" readonly required/>
                    </div>
                    <div class="col-md-12 form-group">
                        <input type="hidden" name="fechas" value="{{ old("fechas") ?? "" }}" />
                        <label class="titulo-dato"><strong><span class="requeridos">* </span>Fechas</strong></label>
                        <div class="table-responsive">
                            <table
                                id="tabla_fechas"
                                data-toggle="table"
                                data-pagination="true"
                                data-page-size="10"
                                data-pagination-h-align="left"
                                data-pagination-detail-h-align="right">
                                <thead>
                                    <tr>
                                        <th data-field="fecha" class="text-center text-uppercase" data-formatter="fechaFormatter"><label class="titulo-dato">Fecha</label></th>
                                        <th data-field="estatus" class="text-center text-uppercase" data-formatter="estatusFormatter"><label class="titulo-dato">Estatus</label></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label class="titulo-dato">Número documento</label>
                        <input type="text" class="form-control normalizar-texto" name="numero_documento" value="{{ old("numero_documento") ?? "" }}" autocomplete="off" />
                    </div>
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
    
    @include('p12_tramites_incidencias.tareas.modals.detalle_dias')
@endsection

@push('scripts')
    <script>
        const tiposIncidencias = @json($tiposIncidencias);
        const rutaCalcularDias = @json(route("tramite.incidencia.getFechasPorEstatusIncidencia", $tramiteIncidencia));
        const tipoIncidenciaId = @json(old("tipo_incidencia_id"));
        const urlGetIncidenciasEmpleado = @json(route("tramite.incidencia.getIncidenciasEmpleado", $tramiteIncidencia));
    </script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
    <script src="{{ asset('js/p12_tramites_incidencias/partials/tabla_incidencias_empleado.js?v=1.7') }}"></script>
    <script src="{{ asset('js/p12_tramites_incidencias/partials/cancelar_proceso.js?v=1.0') }}"></script>
    <script src="{{ asset('js/p12_tramites_incidencias/tareas/T02_altaIncidencia.js?v=1.1') }}"></script>
@endpush
