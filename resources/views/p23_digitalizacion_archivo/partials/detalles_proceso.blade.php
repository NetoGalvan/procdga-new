<div class="card card-custom">
    <div class="card-header py-1">
        <div class="card-title py-1">
            <h3 class="card-label">Detalle del proceso</h3>
        </div>
    </div>
    <div class="card-body">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#kt_tab_datos_generales">
                <span class="nav-icon"><i class="fas fa-list"></i></span> 
                    Datos generales
                </a>
            </li>
        </ul>
    
        <div class="tab-content">
            <div class="tab-pane fade show active" id="kt_tab_datos_generales" role="tabpanel" aria-labelledby="kt_tab_datos_generales">
                <div class="row mt-5">
                    <div class="col-md-6">
                        <label class="titulo-dato" for="">Unidad administrativa</label>
                        <span class="valor-dato">  {{ $digitalizacion->area->identificador }} - {{ $digitalizacion->area->nombre }} </span>
                    </div>
                    <div class="col-md-6">
                        <label class="titulo-dato" for="">Folio</label>
                        <span class="valor-dato"> {{ $digitalizacion->instancia->folio }} </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
