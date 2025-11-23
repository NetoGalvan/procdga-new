<div class="modal fade" id="modal_ss" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detalles del Servicio</h5>
            </div>
            <div class="modal-body">

                    <div class="row">
                        <div class="col-md-3">
                            <label class="titulo-dato"> Área que requiere el servicio </label>
                            <span id="modal_area" class="valor-dato text-uppercase"></span>
                        </div>
                        <div class="col-md-3">
                            <label class="titulo-dato"> Nombre del contacto </label>
                            <span id="modal_nombre_contacto" class="valor-dato text-uppercase"></span>
                        </div>
                        <div class="col-md-3">
                            <label class="titulo-dato"> Teléfono </label>
                            <span id="modal_telefono" class="valor-dato text-uppercase"></span>
                        </div>
                        <div class="col-md-3">
                            <label class="titulo-dato"> Dirección </label>
                            <span id="modal_direccion" class="valor-dato text-uppercase"></span>
                        </div>

                        <div class="col-md-12 form-group">
                            <label for="texto_solicitud" class="titulo-dato"> Descripción de la solicitud de servicio </label>
                            <div id="modal_descripcion">Descripcion</div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 form-group">

                            <table class="table table-bordered table-general"
                                id="tablaDetalleServiciosSolicitados"
                                data-toggle="table"
                                data-toolbar="#toolbar"
                                data-unique-id="id">
                                <thead>
                                    <tr>
                                        <th data-field="nombre_servicio" class="text-center" data-formatter="especialidadDetalleServicioFormatter">Taller/Especialidad</th>
                                        <th data-field="descripcion_servicio" class="text-center">Descripción</th>
                                        <th data-field="estatus_detalle" class="text-center" data-formatter="estatusDetalleServicioFormatter">Estatus</th>
                                        <th data-field="fecha_estimada" class="text-center">Fecha estimada</th>
                                        <th data-field="fecha_entrega" class="text-center">Fecha realizada</th>
                                        <th data-field="unidad" class="text-center" >Unidades entregadas</th>
                                    </tr>
                                </thead>
                            </table>

                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary font-weight-bold" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
