@php
    use Carbon\Carbon;
@endphp
@if (in_array("general", $secciones))
    <div class="row">
        @if (in_array("captura", $secciones))
            <div class="col-md-3">
                <label class="titulo-dato"> Tipo de captura: </label>
                <span class="valor-dato"> <b> 
                    @if ($tramiteIncidencia->tipoCaptura->identificador === "alta") 
                        <span class="badge badge-primary">ALTA<span>
                    @elseif ($tramiteIncidencia->tipoCaptura->identificador === "alta_nb") 
                        <span class="badge badge-success">ALTA NB<span>
                    @else
                        <span class="badge badge-danger">CANCELACION<span>
                    @endif
                </b> </span>
            </div>
        @endif
        <div class="col-md-3">
            <label class="titulo-dato"> Folio: </label>
            <span class="valor-dato"> <b> {{ $tramiteIncidencia->folio }} </b> </span>
        </div>
        <div class="col-md-3">
            <label class="titulo-dato"> Unidad Administrativa: </label>
            <span class="valor-dato"> <b> {{ $tramiteIncidencia->area->areaPrincipal->identificador }} - {{ $tramiteIncidencia->area->areaPrincipal->nombre }}</b> </span>
        </div>
        <div class="col-md-3">
            <label class="titulo-dato"> Tipo trámite: </label>
            <span class="valor-dato"> <b> {{ str_replace("_", " ", $tramiteIncidencia->tipo_tramite) }}  </b> </span>
        </div>
        @if (in_array("observaciones", $secciones))
            <div class="col-md-3">
                <label class="titulo-dato"> Número de documento: </label>
                <span class="valor-dato"> <b> {!! $tramiteIncidencia->numero_documento ?? "<span class='badge badge-secondary'>N/A</span>" !!} </b> </span>
            </div>
            @if (in_array($tramiteIncidencia->tipoCaptura->identificador, ["alta", "alta_nb"]))
                <div class="col-md-3">
                    <label class="titulo-dato"> Observaciones: </label>
                    <span class="valor-dato"> <b> {{ mb_strtoupper($tramiteIncidencia->observaciones) }} </b> </span>
                </div>
            @else
                <div class="col-md-9">
                    <label class="titulo-dato"> Motivos de cancelación: </label>
                    <span class="valor-dato"> <b> {{ mb_strtoupper($tramiteIncidencia->motivo_cancelacion) }} </b> </span>
                </div>
            @endif
        @endif
    </div>
@endif
@if (in_array("empleado", $secciones))
    <div class="separator separator-solid my-6"></div>
    <div class="row">
        <div class="col-md-3">
            <label class="titulo-dato"> Nombre empleado: </label>
            <span class="valor-dato"> <b> {{ $tramiteIncidencia->nombre }} {{ $tramiteIncidencia->apellido_paterno }} {{ $tramiteIncidencia->apellido_materno ?? "" }} </b> </span>
        </div>
        <div class="col-md-3">
            <label class="titulo-dato"> Número de empleado: </label>
            <span class="valor-dato"> <b> {{ $tramiteIncidencia->numero_empleado }} </b> </span>
        </div>
        <div class="col-md-3">
            <label class="titulo-dato"> RFC: </label>
            <span class="valor-dato"> <b> {{ $tramiteIncidencia->rfc }} </b> </span>
        </div>
        <div class="col-md-3">
            <label class="titulo-dato"> Unidad Administrativa: </label>
            <span class="valor-dato"> <b> {{ $tramiteIncidencia->unidad_administrativa }} - {{ $tramiteIncidencia->unidad_administrativa_nombre }} </b> </span>
        </div>
        <div class="col-md-3">
            <label class="titulo-dato"> Sexo: </label>
            <span class="valor-dato"> <b> {{ $tramiteIncidencia->sexo == "F" ? "FEMENINO" : ($tramiteIncidencia->sexo == "M" ? "MASCULINO" : "TODOS") }} </b> </span>
        </div>
        <div class="col-md-3">
            <label class="titulo-dato"> Tipo de empleado: </label>
            <span class="valor-dato"> <b> {{ $tramiteIncidencia->es_sindicalizado ? 'SINDICALIZADO' : 'NO SINDICALIZADO' }} </b> </span>
        </div>
        <div class="col-md-3">
            <label class="titulo-dato"> Sección Sindical: </label>
            <span class="valor-dato"> <b> {!! $tramiteIncidencia->seccion_sindical !!} </b> </span>
        </div>
        <div class="col-md-3">
            <label class="titulo-dato"> Fecha de alta: </label>
            <span class="valor-dato"> <b> {!! $tramiteIncidencia->fecha_alta_empleado ? Carbon::parse($tramiteIncidencia->fecha_alta_empleado)->format("d-m-Y") : "<span class='badge badge-secondary'>N/A</span>" !!} </b> </span>
        </div>
        <div class="col-md-3">
            <label class="titulo-dato"> Puesto: </label>
            <span class="valor-dato"> <b> {{ mb_strtoupper($tramiteIncidencia->codigo_puesto) }} </b> </span>
        </div>
        <div class="col-md-3">
            <label class="titulo-dato"> Zona pagadora: </label>
            <span class="valor-dato"> <b> {{ $tramiteIncidencia->zona_pagadora }} </b> </span>
        </div>
    </div>
@endif
@if (in_array("jefe", $secciones))
    <div class="separator separator-solid my-6"></div>
    <div class="row">
        <div class="col-md-3">
            <label class="titulo-dato"> Nombre del jefe: </label>
            <span class="valor-dato"> <b> {{ json_decode($tramiteIncidencia->firmas)->JEFE_INMEDIATO->nombre }} </b> </span>
        </div>
        <div class="col-md-3">
            <label class="titulo-dato"> Cargo del jefe: </label>
            <span class="valor-dato"> <b> {{ json_decode($tramiteIncidencia->firmas)->JEFE_INMEDIATO->puesto }} </b> </span>
        </div>
    </div>
@endif
@if (in_array("incidencia", $secciones))
    <div class="separator separator-solid my-6"></div>
    @if ($tramiteIncidencia->tipoCaptura->identificador == "alta")
        <label class="titulo-dato"> Incidencia a dar de alta: </label>
    @elseif ($tramiteIncidencia->tipoCaptura->identificador == "alta_nb")
        <label class="titulo-dato"> Aplicacion de notas buenas: </label>
    @elseif ($tramiteIncidencia->tipoCaptura->identificador == "cancelacion")
        <label class="titulo-dato"> Incidencia(s) a cancelar: </label>
    @endif
    <div class="row mt-4">
        <div class="col-12">
            <div class="table-responsive">
                <table
                    id="tabla_incidencias_empleado"
                    class="text-center text-uppercase"
                    data-toggle="table">
                    <thead>
                        <tr>
                            @if ($tramiteIncidencia->tipoCaptura->identificador == "cancelacion")
                                <th data-field="tipo_captura.identificador" data-formatter="tipoCapturaFormatter"><label class="titulo-dato">Tipo Captura</label></th>
                                <th data-field="folio_autorizacion"><label class="titulo-dato">Folio autorización</label></th> 
                            @endif 
                            @if ($incidenciasEmpleado->first()->tramiteIncidencia->tipoCaptura->identificador == "alta") 
                                <th data-field="fecha_inicio" data-formatter="fechaInicioFormatter"><label class="titulo-dato">Fecha inicio</label></th>
                                <th data-field="fecha_final" data-formatter="fechaFinalFormatter"><label class="titulo-dato">Fecha final</label></th>
                                <th data-field="total_dias" data-formatter="totalDiasFormatter"><label class="titulo-dato">Total días</label></th>
                                <th data-field="horario" data-formatter="horarioFormatter"><label class="titulo-dato">Horario</label></th>
                            @endif
                            @if ($incidenciasEmpleado->first()->tramiteIncidencia->tipoCaptura->identificador == "alta_nb")
                                <th data-field="fechas" data-formatter="fechasFormatter"><label class="titulo-dato">Fechas</label></th>
                                <th data-field="total_dias" data-formatter="totalDiasFormatter"><label class="titulo-dato">Total días</label></th>
                                <th data-field="notas_buenas" data-formatter="notasBuenasFormatter"><label class="titulo-dato">Notas Buenas</label></th>
                            @endif
                            <th data-field="tipo_incidencia.tipo_justificacion.nombre"><label class="titulo-dato">Tipo justificación</label></th>
                            <th data-field="tipo_incidencia.descripcion" data-formatter="descripcionFormatter"><label class="titulo-dato">Descripción</label></th>
                            <th data-field="tipo_incidencia.articulo" data-formatter="articuloFormatter"><label class="titulo-dato">Artículo</label></th>
                            <th data-field="tipo_incidencia.subarticulo" data-formatter="subarticuloFormatter"><label class="titulo-dato">Subartículo</label></th>
                            <th data-field="tipo_incidencia.intervalo_evaluacion" data-formatter="intervaloEvaluacionFormatter"><label class="titulo-dato">Intervalo</label></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endif
@if (in_array("respuesta", $secciones))
    <div class="separator separator-solid my-6"></div>
    <div class="row">
        @if ($tramiteIncidencia->estatus == "COMPLETADO")
            <div class="col-md-3">
                <label class="titulo-dato"> Estatus: </label>
                <span class='badge badge-success'>AUTORIZADO</span>
            </div>
            <div class="col-md-3 form-group">
                <label class="titulo-dato"> Creado por: </label>
                <span>{{ $tramiteIncidencia->creadoPor->nombre_completo }}</span>
            </div>
            @if ($tramiteIncidencia->aprobadoPor)
                <div class="col-md-3 form-group">
                    <label class="titulo-dato"> Aprobado por: </label>
                    <span>{{ $tramiteIncidencia->aprobadoPor->nombre_completo }}</span>
                </div>  
            @endif
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