@php
    use Carbon\Carbon;
@endphp
<ul class="nav nav-tabs mt-4">
    @if (array_key_exists("general", $secciones))
    <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#datosGenerales">
        <span class="nav-icon"><i class="fas fa-list"></i></span>
        <span class="nav-text">Datos generales</span>
        </a>
    </li>
    @endif
    @if (array_key_exists("comision", $secciones))
    <li class="nav-item" role="presentation">
        <a class="nav-link" data-toggle="tab" href="#datosComision">
            <span class="nav-icon"><i class="fas fa-file-pdf"></i></span>
            <span class="nav-text">Datos de la comisión</span>
        </a>
    </li>
    @endif
    @if (array_key_exists("soporte", $secciones))
    <li class="nav-item" role="presentation">
        <a class="nav-link" data-toggle="tab" href="#documentosSoporte">
            <span class="nav-icon"><i class="fas fa-file-pdf"></i></span>
            <span class="nav-text">Documentos soporte</span>
        </a>
    </li>
    @endif
    @if (array_key_exists("comisionados", $secciones))
    <li class="nav-item" role="presentation">
        <a class="nav-link" data-toggle="tab" href="#comisionados">
            <span class="nav-icon"><i class="fas fa-users"></i></span>
            <span class="nav-text">Comisionados</span>
        </a>
    </li>
    @endif
</ul>
<div class="tab-content">
    @if (array_key_exists("general", $secciones))
    <div class="tab-pane fade show active" id="datosGenerales" role="tabpanel" aria-labelledby="datosGenerales">
        <div class="row mt-8">
            <div class="col-md-4">
                <label class="titulo-dato"> Folio: </label>
                <span class="valor-dato"> <b> {{ $solicitudViatico->folio }} </b> </span>
            </div>
            <div class="col-md-4">
                <label class="titulo-dato"> Unidad Administrativa: </label>
                <span class="valor-dato"> <b> {{ $solicitudViatico->area->unidadAdministrativa->identificador }} - {{ $solicitudViatico->area->unidadAdministrativa->nombre }}  </b> </span>
            </div>
        </div>
    </div>
    @endif
    @if (array_key_exists("comision", $secciones))
    <div class="tab-pane fade" id="datosComision" role="tabpanel" aria-labelledby="datosComision">
        <div class="row mt-8">
            <div class="col-md-3">
                <label class="titulo-dato">Lugar:</label>
                <span class="valor-dato">
                    {{ $solicitudViatico->lugarZonaTarifaria->tipoZonaTarifaria->nombre }} - {{  $solicitudViatico->lugarZonaTarifaria->model->nombre }}
                </span>
            </div>
            <div class="col-md-3">
                <label class="titulo-dato">Días:</label>
                <span class="valor-dato">
                    {{ $solicitudViatico->dias }}
                </span>
            </div>
            <div class="col-md-3">
                <label class="titulo-dato">Fecha inicio:</label>
                <span class="valor-dato">
                    {{ $solicitudViatico->fecha_inicio }}
                </span>
            </div>
            <div class="col-md-3">
                <label class="titulo-dato">Fecha final:</label>
                <span class="valor-dato">
                    {{ $solicitudViatico->fecha_final }}
                </span>
            </div>
            <div class="col-md-3">
                <label class="titulo-dato">Motivo:</label>
                <span class="valor-dato">
                    {{ $solicitudViatico->motivo_comision }}
                </span>
            </div>
        </div>
    </div>
    @endif
    @if (array_key_exists("soporte", $secciones))
    <div class="tab-pane fade" id="documentosSoporte" role="tabpanel" aria-labelledby="documentosSoporte">
        <div class="row mt-8">
            <div class="table-responsive">
                <table
                    id="tabla_documentos_soporte"
                    data-toggle="table"
                    data-unique-id="documento_id">
                    <thead>
                        <tr>
                            <th data-field="nombre_original"><label class="titulo-dato">Nombre original</label></th>
                            <th data-field="nombre"><label class="titulo-dato">Nombre</label></th>
                            <th data-field="fecha_subida"><label class="titulo-dato">Fecha de carga</label></th>
                            <th data-field="tipo_documento.nombre"><label class="titulo-dato">Tipo de documento</label></th>
                            <th data-field="acciones" data-formatter="acccionesFormatterDocumentos"><label class="titulo-dato">Acciones a realizar</label></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    @endif
    @if (array_key_exists("comisionados", $secciones))
    <div class="tab-pane fade" id="comisionados" role="tabpanel" aria-labelledby="comisionados">
        <div class="table-responsive mt-8">
            <table
                id="tabla_comisionados"
                data-toggle="table"
                data-unique-id="comisionado_id">
                <thead>
                    <tr>
                        <th data-field="numero_empleado"><label class="titulo-dato">Número de empleado</label></th>
                        <th data-field="nombre" data-formatter="nombreFormatter"><label class="titulo-dato">Nombre completo</label></th>
                        <th data-field="rfc"><label class="titulo-dato">RFC</label></th>
                        <th data-field="puesto"><label class="titulo-dato">Puesto</label></th>
                        <th data-field="nivel_salarial"><label class="titulo-dato">Nivel salarial</label></th>
                        <th data-field="tipo_partida_terreste" data-formatter="tipoPartidaTerrestreFormatter"><label class="titulo-dato">Viáticos terrestres</label></th>
                        <th data-field="tipo_partida_aereo" data-formatter="tipoPartidaAereoFormatter"><label class="titulo-dato">Viáticos aereos</label></th>
                        <th data-field="tipo_partida_integral" data-formatter="tipoPartidaIntegralFormatter"><label class="titulo-dato">Viáticos integrales</label></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    @endif
</div>