<div class="mt-5 card card-custom" id="cardAreas" style="display:none;" name="cardAreas">
    <div class="card-header">
        <div class="card-title">
            <h3 class="card-label user-select-none">Asigna los Presupuestos a las Áreas correspondientes</h3>
        </div>
    </div>
    <div class="card-body">
        <div class="row mb-5">
            <div class="col-md-6">
                <label class="titulo-dato" for="presupuestoAsignado">Presupuesto asignado para esta unidad administrativa</label>
                <span class="valor-dato"> ${{ $unidadPresupuesto->presupuesto_asignado }} </span>
            </div>
        </div>
        <div class="table-responsive table-bordered">
            <form action="" name="asignarPresupuestoForm" id="asignarPresupuestoForm" class="form" onsubmit="asignarPresupuesto()" method="post" novalidate>
                <input type="hidden" name="folio" id="folio" value="{{ $folio }}">
                <table id="table-presupuesto-area" name="table-presupuesto-area" class="table">
                    <thead>
                        <tr>
                            <th class="text-center user-select-none">Área</th>
                            <th class="text-center user-select-none">Presupuesto</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($areas as $area)
                            <tr>
                                <td class="text-center align-middle user-select-all">{{ $area->nombre }}</td>
                                <td class="text-center">
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="la la-usd"></i></span></div>
                                        <input type="number" id="{{ $area->area_id }}" name="{{ $area->area_id }}" class="form-control presupuesto"
                                            value="@isset($area->presupuesto_asignado){{ $area->presupuesto_asignado }}@endisset" placeholder=""/>
                                    </div>
                                </th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </form>
            <div class=" text-left">
                <div class="col-md-2 pb-3">
                    <button type="submit" form="asignarPresupuestoForm" class="btn btn-primary btn-block"> Asignar <i class="fas fa-hand-holding-usd"></i></button>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <div class="row text-center">
            <div class="col-lg-12">
                <button id="finalizarTarea" type="submit" class="btn btn-success" onclick="finalizarTarea()"><i class="fas fa-check-square"></i>Finalizar tarea </button>
            </div>
        </div>
    </div>
</div>
