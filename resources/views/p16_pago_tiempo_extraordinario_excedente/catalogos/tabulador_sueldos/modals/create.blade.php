<div class="modal fade" id="createSueldoModal" tabindex="-1" role="dialog"
    aria-labelledby="createSueldoModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createSueldoModalLabel">Agregar tabulador</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <form class="form" id="createForm" name='createForm' action="{{ route('tiempo.extraordinario.excedente.catalogo.tabuladores.create') }}" method="post" >
                    @method('post') @csrf
                    <div class="form-group row">
                        <div class="col-sm-4">
                            <label for="tipo_empleado" class="titulo-dato"><strong><span class="requeridos">* </span>Tipo empleado</strong></label>
                            <select class="form-control custom-select" id="tipo" name="tipo" required>
                                <option value="" selected="true">Elegir...</option>
                                <option value="BASE_SINDICALIZADO">BASE SINDICALIZADO</option>
                                <option value="BASE_NO_SINDICALIZADO">BASE NO SINDICALIZADO</option>
                                <option value="CONFIANZA">CONFIANZA</option>
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <label for="nivel_salarial" class="titulo-dato"><strong><span class="requeridos">* </span>Nivel salarial</strong></label>
                            <div class="input-group">
                                <input type="number" min="0" id="nivel_salarial" name="nivel_salarial" class="form-control"
                                    placeholder="Nivel Salarial del Empelado" required/>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <label for="tabulador_autorizado" class="titulo-dato"><strong><span class="requeridos">* </span>Tabulador autorizado bruto</strong></label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="la la-usd"></i></span></div>
                                <input type="number" step="1" min="0" id="tabulador_autorizado" name="tabulador_autorizado" class="form-control"
                                    placeholder="100000" required/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-4">
                            <label for="reconocimiento_mensual" class="titulo-dato"><strong><span class="requeridos">* </span>Reconocimiento mensual bruto</strong></label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="la la-usd"></i></span></div>
                                <input type="number" step="1" min="0" id="reconocimiento_mensual" name="reconocimiento_mensual" class="form-control"
                                    placeholder="100000" required/>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <label for="cantidad_adicional" class="titulo-dato"><strong><span class="requeridos">* </span>Cantidad adicional bruto</strong></label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="la la-usd"></i></span></div>
                                <input type="number" step="1" min="0" id="cantidad_adicional" name="cantidad_adicional" class="form-control"
                                    placeholder="100000" required/>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <label for="asignacion_adicional" class="titulo-dato"><strong><span class="requeridos">* </span>Asignación adicional</strong></label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="la la-usd"></i></span></div>
                                <input type="number" step="1" min="0" id="asignacion_adicional" name="asignacion_adicional" class="form-control"
                                    placeholder="100000" required/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-4">
                            <label for="total_mensual" class="titulo-dato"><strong><span class="requeridos">* </span>Total mensual</strong></label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="la la-usd"></i></span></div>
                                <input type="number" step="1" min="0" id="total_mensual" name="total_mensual" class="form-control"
                                    placeholder="100000" required/>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <label for="anio_sueldo" class="titulo-dato"><strong><span class="requeridos">* </span>Año</strong></label>
                            <div class="input-group">
                                <input type="text" id="anio_sueldo" name="anio_sueldo" class="form-control" value="{{ date("Y") }}" readonly required/>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-danger font-weight-bold" data-dismiss="modal">Cerrar</button>
                <button id="btnCreate" type="button" class="btn btn-success font-weight-bold">Guardar</button>
            </div>
        </div>
    </div>
</div>
