<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="editPresupuestoModalLabel">Asignar Presupuesto a Unidad Administrativa</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i aria-hidden="true" class="ki ki-close"></i>
            </button>
        </div>
        <div class="modal-body">
            <form class="form" id="editForm" name='editForm' onsubmit="editCatalogoPresupuesto()" target="{{ route('tiempo.extraordinario.excedente.catalogo.anual.edit') }}">
                <input id="presupuesto_id" type="hidden" name="presupuesto_id" value="{{ $presupuesto->presupuesto_id }}">
                <div class="form-group row text-center">
                    <div class="col-lg-3 text-lg-right text-sm-center pt-3"><label for="unidadAdministrativa">Unidad Administrativa <span class="text-danger">*</span></label></div>
                    <div class="col-lg-9 text-lg-left text-sm-center">
                        <select class="form-control select2" id="unidadAdministrativaEdit" name="unidadAdministrativaEdit">
                            <option value="" selected></option>
                            @foreach ($unidadesAdministrativas as $unidadAdministrativa)
                                <option value="{{ $unidadAdministrativa->unidad_administrativa_id }}" @if ($unidadAdministrativa->unidad_administrativa_id==$presupuesto->unidad_administrativa_id) selected @endif>{{ $unidadAdministrativa->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-6">
                        <label for="presupuesto_asignado">Presupuesto <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text"><i class="la la-usd"></i></span></div>
                            <input type="number" step=".01" id="presupuesto_asignado" name="presupuesto_asignado" class="form-control" value="{{ $presupuesto->presupuesto_asignado }}" />
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <label for="anio_presupuesto_edit">Año <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" id="anio_presupuesto_edit" name="anio_presupuesto_edit" value="{{ $presupuesto->anio_presupuesto }}" class="form-control"/>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-light-danger font-weight-bold" data-dismiss="modal">Cerrar</button>
            <button type="submit" id="btnEdit" name="btnEdit" form="editForm" class="btn btn-success font-weight-bold">Editar</button>
        </div>
    </div>
</div>
