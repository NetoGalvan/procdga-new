{{-- <div class="modal fade" id="editSueldoModal" tabindex="-1" role="dialog" aria-labelledby="editSueldoModal" aria-hidden="true"> --}}
<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="editSueldoModalLabel">Editar tabulador</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i aria-hidden="true" class="ki ki-close"></i>
            </button>
        </div>
        <div class="modal-body">
            <form class="form" id="editForm" name='editForm' action="{{ route('tiempo.extraordinario.excedente.catalogo.tabuladores.edit') }}" method="post">
                @method('post') @csrf
                <input type="hidden" name="sueldo_id" id="sueldo_id" value="{{ $sueldo->tabulador_calcular_tiempo_extra_id }}">
                <div class="form-group row">
                    <div class="col-sm-4">
                        <label for="tipo_empleado" class="titulo-dato"><strong><span class="requeridos">* </span>Tipo empleado</strong></label>
                        <select class="form-control custom-select" id="tipo" name="tipo" required>
                            <option value="" selected="true">Elegir...</option>
                            <option @if ($sueldo->tipo=='BASE_SINDICALIZADO') selected @endif value="BASE_SINDICALIZADO">BASE SINDICALIZADO</option>
                            <option @if ($sueldo->tipo=='BASE_NO_SINDICALIZADO') selected @endif value="BASE_NO_SINDICALIZADO">BASE NO SINDICALIZADO</option>
                            <option @if ($sueldo->tipo=='CONFIANZA') selected @endif value="CONFIANZA">CONFIANZA</option>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <label for="nivel_salarial" class="titulo-dato"><strong><span class="requeridos">* </span>Nivel salarial</strong></label>
                        <div class="input-group">
                            <input type="number" min="0" id="nivel_salarial" name="nivel_salarial" class="form-control" value="{{ $sueldo->nivel_salarial }}" required/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <label for="tabulador_autorizado" class="titulo-dato"><strong><span class="requeridos">* </span>Tabulador autorizado bruto</strong></label>
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text"><i class="la la-usd"></i></span></div>
                            <input type="number" min="0" id="tabulador_autorizado" name="tabulador_autorizado" class="form-control" value="{{ $sueldo->tabulador_autorizado_bruto }}" required/>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-4">
                        <label for="reconocimiento_mensual" class="titulo-dato"><strong><span class="requeridos">* </span>Reconocimiento mensual bruto</strong></label>
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text"><i class="la la-usd"></i></span></div>
                            <input type="number" min="0" id="reconocimiento_mensual" name="reconocimiento_mensual" class="form-control" value="{{ $sueldo->reconocimiento_mensual_bruto }}" required/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <label for="cantidad_adicional" class="titulo-dato"><strong><span class="requeridos">* </span>Cantidad adicional bruto</strong></label>
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text"><i class="la la-usd"></i></span></div>
                            <input type="number" min="0" id="cantidad_adicional" name="cantidad_adicional" class="form-control" value="{{ $sueldo->cantidad_adicional_bruto }}" required/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <label for="asignacion_adicional" class="titulo-dato"><strong><span class="requeridos">* </span>Asignación adicional</strong></label>
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text"><i class="la la-usd"></i></span></div>
                            <input type="number" min="0" id="asignacion_adicional" name="asignacion_adicional" class="form-control" value="{{ $sueldo->asignacion_adicional_bruto }}" required/>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-4">
                        <label for="total_mensual" class="titulo-dato"><strong><span class="requeridos">* </span>Total mensual</strong></label>
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text"><i class="la la-usd"></i></span></div>
                            <input type="number" min="0" id="total_mensual" name="total_mensual" class="form-control" value="{{ $sueldo->total_mensual_bruto }}" required/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <label for="anio_sueldo" class="titulo-dato"><strong><span class="requeridos">* </span>Año</strong></label>
                        <div class="input-group">
                            <input type="text" id="anio_sueldo" name="anio_sueldo" class="form-control" value="{{ $sueldo->anio }}" readonly required/>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-light-danger font-weight-bold" data-dismiss="modal">Cerrar</button>
            <button id="btnEdit" type="button" class="btn btn-success font-weight-bold">Editar</button>
        </div>
    </div>
</div>
{{-- </div> --}}
