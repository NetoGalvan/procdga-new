<div class="modal fade" id="createPresupuestoModal" tabindex="-1" role="dialog"
    aria-labelledby="createPresupuestoModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createPresupuestoModalLabel">Asignar Presupuesto a Unidad Administrativa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <form class="form" id="createForm" name='createForm' onsubmit="createCatalogoPresupuesto()" target="{{ route('tiempo.extraordinario.excedente.catalogo.anual.create') }}">
                    <div class="form-group row text-center">
                        <div class="col-lg-3 text-lg-right text-sm-center pt-3"><label for="unidadAdministrativa">Unidad Administrativa <span class="text-danger">*</span></label></div>
                        <div class="col-lg-9 text-lg-left text-sm-center">
                            <select class="form-control select2" id="unidadAdministrativa" name="unidadAdministrativa">
                                <option value="" selected></option>
                                @foreach ($unidadesAdministrativas as $unidadAdministrativa)
                                    <option value="{{ $unidadAdministrativa->unidad_administrativa_id }}">{{ $unidadAdministrativa->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                            <label for="presupuesto_asignado">Presupuesto <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="la la-usd"></i></span></div>
                                <input type="number" step="1" id="presupuesto_asignado" name="presupuesto_asignado" class="form-control" placeholder="100000" />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label for="anio_presupuesto">Año <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" id="anio_presupuesto" name="anio_presupuesto" class="form-control" readonly/>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-danger font-weight-bold" data-dismiss="modal">Cerrar</button>
                <button name="btnCreate" id="btnCreate" type="submit" form="createForm" class="btn btn-success font-weight-bold">Guardar</button>
            </div>
        </div>
    </div>
</div>
