@extends('layouts.main')

@section('title', $reporte->nombre)

@section('subheader')
    @include('layouts.partials.main.subheader', ["subheader" => [
        "titulo_subheader" => "PROCDGA",
        "icono_titulo_subheader" => "far fa-folder-open",
        "breadcrumbs" => [
            1 => [
                'activo' => false,
                'titulo' => 'Reportes',
                'ruta' => Route('reportes')
            ],
            2 => [
                'activo' => true,
                'titulo' => $reporte->nombre
            ]
        ]
    ]])
@endsection

@section('aside_menu')
    @include('layouts.partials.main.aside_menu', ["asideMenu" =>
        [
            "item_seleccionado" => "reportes",
        ]
    ])
@endsection

@push('styles')
    <link href="{{ asset('metronic/plugins/custom/bootstraptable/css/bootstrap-table.min.css') }}" type="text/css" rel="stylesheet"/>
@endpush

@section('contenido')
    <form method="GET" id="form_buscar" action="{{ route("tramite.incidencia.reporte.incidencias.empleado.buscar") }}">
        @csrf
        <div class="card card-custom">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">
                        Buscar o descargar las incidencias del empleado
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
                                @unless (auth()->user()->hasRole("EMPLEADO_GRAL"))       
                                <li>Ingrese el RFC o número de empleado de la persona que desea consultar.</li>
                                @endunless
                                <li>Seleccione el rango de fechas que desea consultar.</li>
                                <li>(Opcional) Especifique el estatus de las incidencias (autorizadas o canceladas) que desea incluir en el reporte.</li>
                                <li>(Opcional) Seleccione uno o varios tipos de incidencias para incluir en el reporte.</li>
                            </ul>
                        </strong>
                    </div>
                </div>
                @unless (auth()->user()->hasRole("EMPLEADO_GRAL"))                
                <div class="row">
                    <div class="col-md-6 form-group">
                        @include("componentes.busqueda_empleado", [
                            "existeEmpleado" => false,
                        ])
                    </div>
                </div>
                @endunless
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label class="titulo-dato"><strong><span class="text-danger">*</span> Rango de fechas: </strong></label>
                        <div class="input-daterange input-group input-rango-fecha" id="input_rango_fecha">
                            <input type="text" class="form-control" name="fecha_inicio" autocomplete="off" placeholder="SELECCIONE UNA FECHA DE INICIO" required/>
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="la la-ellipsis-h"></i></span>
                            </div>
                            <input type="text" class="form-control" name="fecha_final" autocomplete="off" placeholder="SELECCIONE UNA FECHA FINAL" required/>
                        </div>
                        <span class="form-text text-muted">Seleccione un rango de fechas</span>
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="titulo-dato">Estatus:</label>
                        <select class="form-control select2" id="estatus" name="estatus" autocomplete="off">
                            <option value=""> Seleccione una opción </option>
                            <option value="AUTORIZADO"> AUTORIZADO </option>
                            <option value="CANCELADO"> CANCELADO </option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label class="titulo-dato">Tipo de incidencia:</label>
                        <select class="form-control select2" id="tipos_incidencias" name="tipos_incidencias[]" multiple autocomplete="off">
                            <option value=""> Seleccione una opción </option>
                            @foreach ($tiposIncidencias as $tipoIncidencia)
                                <option value="{{ $tipoIncidencia->tipo_incidencia_id }}"> 
                                    {{ $tipoIncidencia->tipoJustificacion->nombre }} —
                                    Artículo: {{ $tipoIncidencia->articulo ?? "N/A" }} — 
                                    Subartículo: {{ $tipoIncidencia->subarticulo ?? "N/A" }} — 
                                    Intervalo: {{ str_replace("_", " ", $tipoIncidencia->intervalo_evaluacion) }} —
                                    Sexo: {{ $tipoIncidencia->sexo == "F" ? "FEMENINO" : $tipoIncidencia->sexo == "M" ? "MASCULINO" : "TODOS" }} —
                                    Tipo días: {{ str_replace("_", " ", $tipoIncidencia->tipo_dias) }} —
                                    Tipo de empleado: {{ str_replace("_", " ", $tipoIncidencia->tipo_empleado) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" data-accion="buscar" class="btn btn-primary mr-2" data-toggle="tooltip" data-placement="top" title="Buscar"><i class="fas fa-search"></i> Buscar </button>
                <button type="submit" data-accion="descargar" class="btn btn-success mr-2" data-toggle="tooltip" data-placement="top" title="Descargar"><i class="fas fa-arrow-down"></i> Descargar </button>
                <button type="button" data-accion="limpiar" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Limpiar"><i class="fas fa-sync-alt"></i> Limpiar </button>
            </div>
        </div>
    </form>

    <div class="card card-custom mt-8">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">
                    Resultado de la búsqueda
                </h3>
            </div>
            <div class="card-toolbar">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_campos_adicionales">
                    <i class="fas fa-list"></i> Campos adicionales
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="modal fade" id="modal_campos_adicionales" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Campos adicionales</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i aria-hidden="true" class="ki ki-close"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12 form-group">
                                    <div class="checkbox-list">
                                        @php
                                            $camposAdicionales = [
                                                "Número documento" => "numero_documento", 
                                                "Horario" => "horario", 
                                                "Notas buenas" => "notas_buenas", 
                                                "Intervalo" => "tipo_incidencia.intervalo_evaluacion", 
                                                "Folio cancelación" => "folio_cancelacion", 
                                            ];
                                        @endphp
                                        @foreach ($camposAdicionales as $indice => $campo)
                                            <label class="checkbox">
                                                <input type="checkbox" name="campos_adicionales[]" value="{{ $campo }}"/>
                                                <span></span>
                                                {{ $indice }}
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table
                    id="tabla_incidencias_empleado"
                    class="text-center text-uppercase"
                    data-toggle="table"
                    data-pagination="true"
                    data-pagination-h-align="left"
                    data-pagination-detail-h-align="right"
                    data-page-size="20">
                    <thead>
                        <tr>
                            <th data-field="tipo_captura.identificador" data-formatter="tipoCapturaFormatter"><label class="titulo-dato">Tipo Captura</label></th>
                            <th data-field="folio_autorizacion"><label class="titulo-dato">Folio autorización</label></th>
                            <th data-field="numero_documento" data-formatter="numeroDocumentoFormatter" data-visible="false"><label class="titulo-dato">Número Documento</label></th>
                            <th data-field="fechas" data-formatter="fechasFormatter"><label class="titulo-dato">Fechas</label></th>
                            <th data-field="total_dias" data-formatter="totalDiasFormatter"><label class="titulo-dato">Total días</label></th>
                            <th data-field="horario" data-formatter="horarioFormatter" data-visible="false"><label class="titulo-dato">Horario</label></th>
                            <th data-field="notas_buenas" data-formatter="notasBuenasFormatter" data-visible="false"><label class="titulo-dato">Notas Buenas</label></th>
                            <th data-field="tipo_incidencia.tipo_justificacion.nombre"><label class="titulo-dato">Tipo justificación</label></th>
                            <th data-field="tipo_incidencia.articulo" data-formatter="articuloFormatter"><label class="titulo-dato">Artículo</label></th>
                            <th data-field="tipo_incidencia.subarticulo" data-formatter="subarticuloFormatter"><label class="titulo-dato">Subartículo</label></th>
                            <th data-field="tipo_incidencia.descripcion" data-formatter="descripcionFormatter"><label class="titulo-dato">Descripción</label></th>
                            <th data-field="tipo_incidencia.intervalo_evaluacion" data-visible="false" data-formatter="intervaloEvaluacionFormatter"><label class="titulo-dato">Intervalo</label></th>
                            <th data-field="folio_cancelacion" data-formatter="folioCancelacionFormatter" data-visible="false"><label class="titulo-dato">Folio cancelación</label></th>
                            <th data-field="observaciones_reporte" data-formatter="observacionesReporteFormatter"><label class="titulo-dato">Observaciones</label></th>
                            <th data-field="estatus" data-formatter="estatusFormatter"><label class="titulo-dato">Estatus</label></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
    <script src="{{ asset('js/componentes/busqueda_empleado.js') }}"></script>
    <script src="{{ asset('js/p12_tramites_incidencias/partials/tabla_incidencias_empleado.js?v=1.7') }}"></script>
    <script src="{{ asset('js/p12_tramites_incidencias/reportes/incidencias_por_empleado/index.js?v=1.0') }}"></script>
@endpush
