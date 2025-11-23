<div class="modal fade" id="modalPrograma" tabindex="-1" data-backdrop="static" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
            </div>
            <div class="modal-body">
                <form method="POST" id="formPrograma">
                    @csrf
                    @method('post')
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="titulo-dato"><strong><span class="requeridos">* </span>Nombre del programa</strong></label>
                                    <input type="text" class="form-control normalizar-texto" name="nombre_programa" id="nombrePrograma">
                                </div>
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
                    <button type="button" class="btn btn-primary guardar-modificar-programa">
                        <i class="fas fa-save"></i> Guardar
                    </button>
                </div>
            </div>
            <div class="bloquear-spinner"></div>
        </div>
    </div>
</div>