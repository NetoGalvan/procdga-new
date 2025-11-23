<div class="modal fade modal-block-body-scroll" data-backdrop="static" id="modal_detalle_asistencia">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalle</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body" style="max-height: 700px;">
                <div id="contendor_fecha" class="row">
                    <div class="col-md-4">
                        <label class="titulo-dato">Fecha:</label>
                        <span id="fecha" class="valor-dato"></span>
                    </div>
                    <div class="col-md-4">
                        <label class="titulo-dato">Evaluación:</label>
                        <span id="evaluacion" class="badge" style="white-space:nowrap;"></span>
                    </div> 
                    <div class="col-12 mt-4">
                        <div class="table-responsive">
                            <table id="tabla_eventos_evaluacion" class="text-center" data-toggle="table">
                                <thead>
                                    <tr>
                                        <th data-field="ENTRADA" data-formatter="eventoEvaluacionFormatter"><label class="titulo-dato">Entrada</label></th>
                                        <th data-field="RETARDO_LEVE" data-formatter="eventoEvaluacionFormatter"><label class="titulo-dato">Retardo Leve</label></th>
                                        <th data-field="RETARDO_GRAVE" data-formatter="eventoEvaluacionFormatter"><label class="titulo-dato">Retardo Grave</label></th>
                                        <th data-field="SALIDA" data-formatter="eventoEvaluacionFormatter"><label class="titulo-dato">Salida</label></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>       
                </div>
                <div class="separator separator-solid my-6"></div>
                <div class="row">
                    <div class="col-12">
                        <h5 class="text-dark font-weight-bold">Horario</h5>
                    </div>
                    <div class="col-12" id="contenedor_horario" style="display: none">
                        <div class="row">
                            <div class="col-md-4">
                                <label class="titulo-dato">Horario:</label>
                                <span id="horario" class="valor-dato"></span>
                            </div>
                            <div class="col-md-4">
                                <label class="titulo-dato">Horario entrada:</label>
                                <span id="horario_entrada" class="valor-dato"></span>
                            </div>
                            <div class="col-md-4">
                                <label class="titulo-dato">Retardo leve:</label>
                                <span id="horario_retardo_leve" class="valor-dato"><span class="badge badge-secondary">N/A</span></span>
                            </div>
                            <div class="col-md-4">
                                <label class="titulo-dato">Retardo grave:</label>
                                <span id="horario_retardo_grave" class="valor-dato"><span class="badge badge-secondary">N/A</span></span>
                            </div>
                            <div class="col-md-4">
                                <label class="titulo-dato">Horario de salida:</label>
                                <span id="horario_salida" class="valor-dato"><span class="badge badge-secondary">N/A</span></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12" id="contenedor_sin_horario" style="display: none">
                    </div>
                </div>
                <div class="separator separator-solid my-6"></div>
                <div id="contendor_eventos" class="row">
                    <div class="col-12">
                        <h5 class="text-dark font-weight-bold">Eventos</h5>
                    </div>
                    <div class="col-12 mt-4">
                        <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                            <table id="tabla_eventos" class="text-center" data-toggle="table">
                                <thead>
                                    <tr>
                                        <th data-field="fecha" data-formatter="fechaFormatter"><label class="titulo-dato">Evento</label></th>
                                        <th data-field="biometrico.nombre" data-formatter="biometricoFormatter"><label class="titulo-dato">Biométrico</label></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="separator separator-solid my-6"></div>
                <div id="contendor_incidencias" class="row">
                    <div class="col-12">
                        <h5 class="text-dark font-weight-bold">Incidencias</h5>
                    </div>
                    <div class="col-12 mt-4">
                        <div class="table-responsive">
                            <table id="tabla_incidencias" class="text-center" data-toggle="table">
                                <thead>
                                    <tr>
                                        <th data-field="folio_autorizacion"><label class="titulo-dato">Folio autorización</label></th>
                                        <th data-field="fechas" data-formatter="fechasFormatter"><label class="titulo-dato">Fechas</label></th>
                                        <th data-field="tipo_incidencia.tipo_justificacion.nombre"><label class="titulo-dato">Tipo justificación</label></th>
                                        <th data-field="tipo_incidencia.descripcion" data-formatter="descripcionFormatter"><label class="titulo-dato">Descripción</label></th>
                                        <th data-field="tipo_incidencia.articulo" data-formatter="articuloFormatter"><label class="titulo-dato">Artículo</label></th>
                                        <th data-field="tipo_incidencia.subarticulo" data-formatter="subarticuloFormatter"><label class="titulo-dato">Subartículo</label></th>
                                    </tr>
                                </thead>
                            </table>
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