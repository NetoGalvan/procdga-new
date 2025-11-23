@if(in_array("general", $secciones))
    <div class="row">
        <div class="col-md-4">
            <label class="titulo-dato"> Folio: </label>
            <span class="valor-dato"> <b> {{ $tramiteIncidencia->folio }} </b> </span>
        </div>
        <div class="col-md-4">
            <label class="titulo-dato"> Unidad Administrativa: </label>
            <span class="valor-dato"> <b> {{ $tramiteIncidencia->instancia->area->unidadAdministrativa->identificador }} {{ $tramiteIncidencia->instancia->area->unidadAdministrativa->nombre }}  </b> </span>
        </div>
        <div class="col-md-4">
            <label class="titulo-dato"> Tipo trámite: </label>
            <span class="valor-dato"> <b> {{ str_replace("_", " ", $tramiteIncidencia->tipo_tramite) }}  </b> </span>
        </div>
    </div>
@endif
@if(in_array("tipo_captura", $secciones))
    <div class="row">
        <div class="col-md-4">
            <label class="titulo-dato"> Tipo de captura: </label>
            <span class="valor-dato"> <b> 
                @if ($tramiteIncidencia->tipoCaptura->identificador === "alta") 
                    <span class="badge badge-primary">ALTA<span>
                @else
                    <span class="badge badge-danger">CANCELACION<span>
                @endif
            </b> </span>
        </div>
    </div>
@endif
@if(in_array("incidencia", $secciones))
    <div class="separator separator-solid my-6"></div>
    @if ($tramiteIncidencia->tipoCaptura->identificador == "alta")
        <div class="row">
            <div class="col-md-4">
                <label class="titulo-dato"> Número documento: </label>
                <span class="valor-dato"> <b> {!! $tramiteIncidencia->numero_documento ?? "<span class='badge badge-secondary'>N/A</span>" !!}  </b> </span>
            </div>
            <div class="col-md-8">
                <label class="titulo-dato"> Observaciones: </label>
                <span class="valor-dato"> <b> {{ mb_strtoupper($tramiteIncidencia->observaciones) }} </b> </span>
            </div>
            <div class="col-md-4">
                <label class="titulo-dato"> Horario: </label>
                <span class="valor-dato">
                    <b>
                        @if ($tramiteIncidencia->incidenciasEmpleado()->first()->tipoIncidencia->tipoJustificacion->identificador == "cambio_horario")
                            Entrada:  {{ $tramiteIncidencia->incidenciasEmpleado()->first()->horario->entrada }} <br>
                            Salida: {!! $tramiteIncidencia->incidenciasEmpleado()->first()->horario->salida ?? "<span class='badge badge-secondary'>N/A</span>" !!} <br>
                            @foreach ($tramiteIncidencia->incidenciasEmpleado()->first()->horario->dias_formato_string as $dia)
                                {{ $dia }}    
                            @endforeach
                            @if ($tramiteIncidencia->incidenciasEmpleado()->first()->horario->dias_festivos_son_laborales)
                                <br> DIAS FESTIVOS
                            @endif
                            <br> {{ str_replace("_", " ", $tramiteIncidencia->incidenciasEmpleado()->first()->horario->tipo_empleado) }}
                        @else 
                            <span class="badge badge-secondary">N/A</span>
                        @endif
                    </b> 
                </span>
            </div>
            <div class="col-md-4">
                <label class="titulo-dato"> Fecha Inicio: </label>
                <span class="valor-dato"> <b> {!! $tramiteIncidencia->incidenciasEmpleado()->first()->fecha_inicio->format("d-m-Y") ?? "<span class='badge badge-secondary'>N/A</span>" !!}  </b> </span>
            </div>
            <div class="col-md-4">
                <label class="titulo-dato"> Fecha Final: </label>
                <span class="valor-dato"> <b> {!! $tramiteIncidencia->incidenciasEmpleado()->first()->fecha_final->format("d-m-Y") ?? "<span class='badge badge-secondary'>N/A</span>" !!}  </b> </span>
            </div>
            <div class="col-md-4">
                <label class="titulo-dato"> Total días: </label>
                <span class="valor-dato"> <b> {!! $tramiteIncidencia->incidenciasEmpleado()->first()->total_dias ?? "<span class='badge badge-secondary'>N/A</span>" !!}  </b> </span>
            </div>
            <div class="col-md-4">
                <label class="titulo-dato">Tipo justificación: </label>
                <span class="valor-dato"> <b> {!! $tramiteIncidencia->incidenciasEmpleado()->first()->tipoIncidencia->tipo_justificacion_nombre ?? "<span class='badge badge-secondary'>N/A</span>" !!}  </b> </span>
            </div>
            <div class="col-md-4">
                <label class="titulo-dato">Descripción: </label>
                <span class="valor-dato"> <b> {!! $tramiteIncidencia->incidenciasEmpleado()->first()->tipoIncidencia->descripcion ?? "<span class='badge badge-secondary'>N/A</span>" !!}  </b> </span>
            </div>
            <div class="col-md-4">
                <label class="titulo-dato">Artículo: </label>
                <span class="valor-dato"> <b> {!! $tramiteIncidencia->incidenciasEmpleado()->first()->tipoIncidencia->articulo ?? "<span class='badge badge-secondary'>N/A</span>" !!}  </b> </span>
            </div>
            <div class="col-md-4">
                <label class="titulo-dato">Subartículo: </label>
                <span class="valor-dato"> <b> {!! $tramiteIncidencia->incidenciasEmpleado()->first()->tipoIncidencia->subarticulo ?? "<span class='badge badge-secondary'>N/A</span>" !!}  </b> </span>
            </div>
            <div class="col-md-4">
                <label class="titulo-dato">Intervalo evaluación: </label>
                <span class="valor-dato"> <b> {!! str_replace("_", " ", $tramiteIncidencia->incidenciasEmpleado()->first()->tipoIncidencia->intervalo_evaluacion) ?? "<span class='badge badge-secondary'>N/A</span>" !!}  </b> </span>
            </div>
            <div class="col-md-4">
                <label class="titulo-dato">Tipo Empleado:</label>
                <span class="valor-dato"> <b> {!! str_replace("_", " ", $tramiteIncidencia->incidenciasEmpleado()->first()->tipoIncidencia->tipo_empleado) ?? "<span class='badge badge-secondary'>N/A</span>" !!}  </b> </span>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-md-4">
                <label class="titulo-dato"> Número documento: </label>
                <span class="valor-dato"> <b> {!! $tramiteIncidencia->numero_documento ?? "<span class='badge badge-secondary'>N/A</span>" !!}  </b> </span>
            </div>
            <div class="col-md-4">
                <label class="titulo-dato"> Folio a cancelar: </label>
                <span class="valor-dato"> <b> {{ str_replace("_", " ", $tramiteIncidencia->tramiteAsociado->folio) }}  </b> </span>
            </div>
            <div class="col-md-4">
                <label class="titulo-dato"> Motivos de cancelación: </label>
                <span class="valor-dato"> <b> {{ mb_strtoupper($tramiteIncidencia->motivo_cancelacion) }} </b> </span>
            </div>
            @if ($tramiteIncidencia->incidenciasEmpleadoCancelacion()->exists())
                <div class="col-md-4">
                    <label class="titulo-dato"> Horario: </label>
                    <span class="valor-dato">
                        <b>
                            @if ($tramiteIncidencia->incidenciasEmpleadoCancelacion()->first()->tipoIncidencia->tipoJustificacion->identificador == "cambio_horario")
                                Entrada:  {{ $tramiteIncidencia->incidenciasEmpleadoCancelacion()->first()->horario->entrada }} <br>
                                Salida: {!! $tramiteIncidencia->incidenciasEmpleadoCancelacion()->first()->horario->salida ?? "<span class='badge badge-secondary'>N/A</span>" !!} <br>
                                @foreach ($tramiteIncidencia->incidenciasEmpleadoCancelacion()->first()->horario->dias_formato_string as $dia)
                                    {{ $dia }}    
                                @endforeach
                                @if ($tramiteIncidencia->incidenciasEmpleadoCancelacion()->first()->horario->dias_festivos_son_laborales)
                                    <br> DIAS FESTIVOS
                                @endif
                                <br> {{ str_replace("_", " ", $tramiteIncidencia->incidenciasEmpleadoCancelacion()->first()->horario->tipo_empleado) }}
                            @else 
                                <span class="badge badge-secondary">N/A</span>
                            @endif
                        </b> 
                    </span>
                </div>
                <div class="col-md-4">
                    <label class="titulo-dato"> Fecha Inicio: </label>
                    <span class="valor-dato"> <b> {!! $tramiteIncidencia->incidenciasEmpleadoCancelacion()->first()->fecha_inicio->format("d-m-Y") ?? "<span class='badge badge-secondary'>N/A</span>" !!}  </b> </span>
                </div>
                <div class="col-md-4">
                    <label class="titulo-dato"> Fecha Final: </label>
                    <span class="valor-dato"> <b> {!! $tramiteIncidencia->incidenciasEmpleadoCancelacion()->first()->fecha_final->format("d-m-Y") ?? "<span class='badge badge-secondary'>N/A</span>" !!}  </b> </span>
                </div>
                <div class="col-md-4">
                    <label class="titulo-dato"> Total días: </label>
                    <span class="valor-dato"> <b> {!! $tramiteIncidencia->incidenciasEmpleadoCancelacion()->first()->total_dias ?? "<span class='badge badge-secondary'>N/A</span>" !!}  </b> </span>
                </div>
                <div class="col-md-4">
                    <label class="titulo-dato">Tipo justificación: </label>
                    <span class="valor-dato"> <b> {!! $tramiteIncidencia->incidenciasEmpleadoCancelacion()->first()->tipoIncidencia->tipo_justificacion_nombre ?? "<span class='badge badge-secondary'>N/A</span>" !!}  </b> </span>
                </div>
                <div class="col-md-4">
                    <label class="titulo-dato">Descripción: </label>
                    <span class="valor-dato"> <b> {!! $tramiteIncidencia->incidenciasEmpleadoCancelacion()->first()->tipoIncidencia->descripcion ?? "<span class='badge badge-secondary'>N/A</span>" !!}  </b> </span>
                </div>
                <div class="col-md-4">
                    <label class="titulo-dato">Artículo: </label>
                    <span class="valor-dato"> <b> {!! $tramiteIncidencia->incidenciasEmpleadoCancelacion()->first()->tipoIncidencia->articulo ?? "<span class='badge badge-secondary'>N/A</span>" !!}  </b> </span>
                </div>
                <div class="col-md-4">
                    <label class="titulo-dato">Subartículo: </label>
                    <span class="valor-dato"> <b> {!! $tramiteIncidencia->incidenciasEmpleadoCancelacion()->first()->tipoIncidencia->subarticulo ?? "<span class='badge badge-secondary'>N/A</span>" !!}  </b> </span>
                </div>
                <div class="col-md-4">
                    <label class="titulo-dato">Intervalo evaluación: </label>
                    <span class="valor-dato"> <b> {!! str_replace("_", " ", $tramiteIncidencia->incidenciasEmpleadoCancelacion()->first()->tipoIncidencia->intervalo_evaluacion) ?? "<span class='badge badge-secondary'>N/A</span>" !!}  </b> </span>
                </div>
            @endif
        </div>
    @endif
@endif
@if(in_array("empleados", $secciones))
    <div class="separator separator-solid my-6"></div>
    <div class="row">
        <div class="col-md-12">
            @if ($tramiteIncidencia->tipoCaptura->identificador == "alta")
                <label class="titulo-dato">Empleados:</label>
            @else
                <label class="titulo-dato">Empleados a cancelar:</label>
            @endif
            <div class="table-responsive mt-4">
                <table
                    id="tabla_incidencias_empleado"
                    class="text-center text-uppercase"
                    data-toggle="table"
                    data-ajax="getIncidenciasEmpleado"
                    data-data-field="data"
                    data-total-field="total"
                    data-side-pagination="server"
                    data-pagination="true"
                    data-query-params="queryParams"
                    data-pagination-h-align="left"
                    data-pagination-detail-h-align="right">
                    <thead>
                        <tr>
                            <th data-field="nombre_completo"><label class="titulo-dato">Nombre</label></th>
                            <th data-field="numero_empleado" data-searchable="true"><label class="titulo-dato">Número empleado</label></th>
                            <th data-field="rfc" data-searchable="true"><label class="titulo-dato">RFC</label></th>
                            <th data-field="unidad_administrativa" data-searchable="false" data-formatter="unidadAdministrativaFormatter"><label class="titulo-dato">Unidad administrativa</label></th>
                            <th data-field="sexo" data-searchable="true" data-formatter="sexoFormatter"><label class="titulo-dato">Sexo</label></th>
                            <th data-field="seccion_sindical" data-searchable="false"><label class="titulo-dato">Sección sindical</label></th>
                            <th data-field="nomina" data-searchable="false"><label class="titulo-dato">Nomina</label></th>
                            <th data-field="nivel_salarial" data-searchable="false"><label class="titulo-dato">Nivel salarial</label></th>
                            <th data-field="tipo_empleado" data-searchable="false" data-formatter="tipoEmpleadoFormatter"><label class="titulo-dato">Tipo empleado</label></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endif
@if(in_array("estatus", $secciones))
    <div class="separator separator-solid my-6"></div>
    <div class="row">
        @if ($tramiteIncidencia->estatus == "COMPLETADO")
            <div class="col-md-3 form-group">
                <label class="titulo-dato"> Estatus: </label>
                <span class='badge badge-success'>AUTORIZADO</span>
            </div>
            <div class="col-md-3 form-group">
                <label class="titulo-dato"> Creado por: </label>
                <span>{{ $tramiteIncidencia->creadoPor->nombre_completo }}</span>
            </div>
            <div class="col-md-3 form-group">
                <label class="titulo-dato"> Aprobado por: </label>
                <span>{{ $tramiteIncidencia->aprobadoPor->nombre_completo }}</span>
            </div>
            <div class="col-md-3 form-group">
                <label class="titulo-dato"> Autorizado por: </label>
                <span>{{ $tramiteIncidencia->autorizadoPor->nombre_completo }}</span>
            </div>
        @elseif ($tramiteIncidencia->estatus == "RECHAZADO")
            <div class="col-md-3 form-group">
                <label class="titulo-dato"> Estatus: </label>
                <span class='badge badge-danger'>RECHAZADO</span>
            </div>
            <div class="col-md-3 form-group">
                <label class="titulo-dato"> Rechazado por: </label>
                <span>{{ $tramiteIncidencia->rechazadoPor->nombre_completo }}</span>
            </div>
            <div class="col-md-12 form-group">
                <label class="titulo-dato"> Motivo rechazo: </label>
                <span>{{ $tramiteIncidencia->motivo_rechazo }}</span>
            </div>
        @endif
    </div>
@endif