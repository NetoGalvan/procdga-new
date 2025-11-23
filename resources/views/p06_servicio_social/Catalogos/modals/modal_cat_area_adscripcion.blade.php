<div class="modal fade" id="modalAreaAdscripcion" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
            </div>
            <div class="modal-body">
                <form method="POST" id="formAreaAdscripcion">
                    @csrf
                    @method('post')
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="titulo-dato"><strong><span class="requeridos">* </span>Nombre área adscripción</strong></label>
                                    <input type="text" class="form-control normalizar-texto nombre_area" name="nombre_area">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="titulo-dato"><strong><span class="requeridos">* </span>Dirección</strong></label>
                                    <input type="text" class="form-control normalizar-texto direccion_area" name="direccion_area">
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
                    <button type="button" class="btn btn-primary guardar-modificar-area-adscripcion">
                        <i class="fas fa-save"></i> Guardar
                    </button>
                </div>
            </div>
            <div class="bloquear-spinner"></div>
        </div>
    </div>
</div>