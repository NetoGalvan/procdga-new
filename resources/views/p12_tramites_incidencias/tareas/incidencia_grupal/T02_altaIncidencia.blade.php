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
            @include("p12_tramites_incidencias.partials.datos_general_incidencia_grupal", [
                "secciones" => ["general", "tipo_captura"]
            ])
        </div>
    </div>
    <div class="card card-custom mt-8">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">Seleccionar a los empleados</h3>
            </div>
        </div>
        <div class="card-body">
            <form method="POST" id="form_filtrar">
                <div class="row">
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato"><b> UNIDAD ADMINISTRATIVA: </b></label>
                        <select class="form-control select2" name="unidad_administrativa_id" autocomplete="off">
                            <option></option>
                            @foreach($unidadesAdministrativas as $unidadAdministrativa)
                                <option value="{{ $unidadAdministrativa->unidad_administrativa_id }}"> {{ $unidadAdministrativa->identificador }} - {{ $unidadAdministrativa->nombre }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato"><b> SEXO: </b></label>
                        <select class="form-control select2" name="sexo" autocomplete="off">
                            <option value=""></option>
                            <option value="M"> MASCULINO </option>
                            <option value="F"> FEMENINO </option>
                        </select>
                    </div>
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato"><b> TIPO EMPLEADO: </b></label>
                        <select class="form-control select2" name="tipo_empleado" autocomplete="off">
                            <option value=""></option>
                            <option value="SINDICALIZADO"> SINDICALIZADO </option>
                            <option value="NOMINA_8"> NÓMINA 8 </option>
                            <option value="ESTRUCTURA"> ESTRUCTURA </option>
                            <option value="NO_SINDICALIZADO"> NO SINDICALIZADO </option>
                        </select>
                    </div>
                    <div class="col-md-3 form-group" id="contenedor_seccion_sindical" style="display: none">
                        <label class="titulo-dato"><b>SECCIÓN SINDICAL:</b></label>
                        <select class="form-control select2" name="seccion_sindical" autocomplete="off">
                            <option value=""></option>
                            @foreach($seccionesSindicales as $seccionSindical)
                                <option value="{{ $seccionSindical->seccion_sindical }}"> {{ $seccionSindical->seccion_sindical }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12 form-group">
                        <label class="titulo-dato">NÚMEROS DE EMPLEADOS:</label>
                        <textarea class="form-control" id="numeros_empleados" name="numeros_empleados" autocomplete="off"></textarea>
                    </div>
                    <div class="col-md-12">
                        <button type="submit" data-accion="buscar" class="btn btn-primary mr-2"><i class="fas fa-search"></i> Buscar</button>
                        <button type="submit" data-accion="limpiar" class="btn btn-warning"><i class="fas fa-sync-alt"></i> Limpiar</button>
                    </div>
                    <div class="col-md-12 mt-8">
                        <label class="titulo-dato">EMPLEADOS:</label>
                        <div class="table-responsive">
                            <table 
                                id="tabla_empleados" 
                                class="text-center"
                                data-toggle="table"
                                data-pagination="true"
                                data-page-size="20"
                                data-page-list="[]"
                                data-pagination-h-align="left"
                                data-pagination-detail-h-align="right">
                                <thead>
                                    <th data-field="nombre_completo" data-searchable="false"><label class="titulo-dato">Nombre</label></th>
                                    <th data-field="numero_empleado" data-searchable="true"><label class="titulo-dato">Número empleado</label></th>
                                    <th data-field="rfc" data-searchable="true"><label class="titulo-dato">RFC</label></th>
                                    <th data-field="unidad_administrativa" data-searchable="false" data-formatter="unidadAdministrativaFormatter"><label class="titulo-dato">Unidad administrativa</label></th>
                                    <th data-field="sexo" data-searchable="true" data-formatter="sexoFormatter"><label class="titulo-dato">Sexo</label></th>
                                    <th data-field="seccion_sindical" data-searchable="false"><label class="titulo-dato">Sección sindical</label></th>
                                    <th data-field="nomina" data-searchable="false"><label class="titulo-dato">Nomina</label></th>
                                    <th data-field="nivel_salarial" data-searchable="false"><label class="titulo-dato">Nivel salarial</label></th>
                                    <th data-field="tipo_empleado" data-searchable="false" data-formatter="tipoEmpleadoFormatter"><label class="titulo-dato">Tipo empleado</label></th>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <form method="POST" id="form_finalizar_tarea" action="{{ route("tramite.incidencia.grupal.alta", [$tramiteIncidencia, $instanciaTarea]) }}">
        @csrf
        <input type="hidden" name="empleados" value="" />
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
                                <li>Opcional: Agregue un número de documento.</li>
                                <li>Agregue las observaciones para esta incidencia grupal.</li>
                                <li>Seleccione el tipo de incidencia.</li>
                                <li>Establezca la fecha de inicio y la fecha final en la que va a aplicar la incidencia.</li>
                            </ul>
                        </strong>
                    </div>
                </div>    
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label class="titulo-dato">Número documento</label>
                        <input type="text" class="form-control normalizar-texto" name="numero_documento" value="{{ old("numero_documento") ?? "" }}" autocomplete="off" />
                    </div>
                    <div class="col-md-8 form-group">
                        <label class="titulo-dato"><span class="requeridos">* </span> <b> Observaciones </b> </label>
                        <textarea class="form-control normalizar-texto" name="observaciones" autocomplete="off" required>{{ old("observaciones") ?? "" }}</textarea>
                    </div>
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
                                        <th data-field="tipo_justificacion.nombre"><label class="titulo-dato">Tipo de incidencia</label></th>
                                        <th data-field="descripcion" data-formatter="descripcionFormatter"><label class="titulo-dato">Descripción</label></th>
                                        <th data-field="articulo" data-formatter="articuloFormatter"><label class="titulo-dato">Artículo</label></th>
                                        <th data-field="subarticulo" data-formatter="subarticuloFormatter"><label class="titulo-dato">Subartículo</label></th>
                                        <th data-field="ley"><label class="titulo-dato">Ley</label></th>
                                        <th data-field="intervalo_evaluacion" data-formatter="intervaloEvaluacionFormatter"><label class="titulo-dato">Intervalo</label></th>
                                        <th data-field="sexo" data-formatter="sexoFormatter"><label class="titulo-dato">Sexo</label></th>
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
        const tiposIncidencias = @json($tiposIncidencias);
        const horarios = @json($horarios);
        const rutaGetEmpleados = @json(route("tramite.incidencia.getEmpleadosCumplenCondicion", $tramiteIncidencia));    
        const rutaCalcularDias = @json(route("tramite.incidencia.getFechasPorEstatusIncidencia", $tramiteIncidencia));
    </script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
    <script src="{{ asset('js/p12_tramites_incidencias/partials/tabla_incidencias_empleado.js?v=1.9') }}"></script>
    <script src="{{ asset('js/p12_tramites_incidencias/partials/cancelar_proceso.js?v=1.0') }}"></script>
    <script src="{{ asset('js/p12_tramites_incidencias/tareas/incidencia_grupal/T02_altaIncidencia.js?v=1.3') }}"></script>
@endpush
