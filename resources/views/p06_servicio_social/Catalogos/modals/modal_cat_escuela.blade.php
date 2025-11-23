<div class="modal fade" id="modalEscuela" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
            </div>
            <div class="modal-body">
                <form method="POST" id="formEscuela">
                    @csrf
                    @method('post')
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="titulo-dato"><strong><span class="requeridos">* </span>Nombre de la escuela</strong></label>
                                    <input type="text" class="form-control normalizar-texto" name="nombre_escuela" id="nombreEscuela">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="titulo-dato"><span class="requeridos">* </span><strong>Acrónimo de la escuela</strong></label>
                                    <input type="text" class="form-control normalizar-texto" name="acronimo_escuela" id="acronimoEscuela">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label class="titulo-dato"><span class="requeridos">* </span><strong>dirección de la escuela</strong></label>
                                <textarea class="form-control normalizar-texto" name="direccion_escuela" id="direccionEscuela"></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer py-3">
                <div class="col-md-12 text-center">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                    <button type="button" class="btn btn-primary guardar-modificar-escuela">
                        <i class="fas fa-save"></i> Guardar
                    </button>
                </div>
            </div>
            <div class="bloquear-spinner"></div>
        </div>
    </div>
</div>