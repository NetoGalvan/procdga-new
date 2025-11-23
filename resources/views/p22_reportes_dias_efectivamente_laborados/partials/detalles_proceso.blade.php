<div class="card card-custom">
    <div class="card-header">
        <div class="card-title">
            <h3 class="card-label">Detalle del proceso</h3>
        </div>
    </div>
    <div class="card-body">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#kt_tab_datos_generales">
                    <span class="nav-icon"><i class="fas fa-list"></i></span> Datos generales
                    </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="kt_tab_datos_generales" role="tabpanel" aria-labelledby="kt_tab_datos_generales">
                @if(in_array("general", $secciones))
                <div class="row mt-5">
                    <div class="col-md-6">
                        <label class="titulo-dato"> Unidad administrativa </label>
                        <span class="valor-dato">  {{ $reportes->area->identificador }} - {{ $reportes->area->nombre }} </span>
                    </div>
                    <div class="col-md-6">
                        <label class="titulo-dato"> Folio </label>
                        <span class="valor-dato">  {{ $reportes->instancia->folio }} </span>
                    </div>
                </div>
                @endif
                @if(in_array("datos_reporte", $secciones))
                <hr>
                <div class="row mt-5">
                    <div class="col-md-6">
                        <label class="titulo-dato"> Tipo de reporte </label>
                        <span class="valor-dato">  {{ $reportes->tipo_reporte }} </span>
                    </div>
                    <div class="col-md-6">
                        <label class="titulo-dato"> Periodo de evaluación </label>
                        <span class="valor-dato">  {{ $reportes->nombre_periodo_evaluacion }} </span>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
