@php
    use Carbon\Carbon;
@endphp
<ul class="nav nav-tabs mt-4">
    @if (array_key_exists("general", $secciones))
    <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#kt_tab_datos_generales">
        <span class="nav-icon"><i class="fas fa-list"></i></span>
        <span class="nav-text">Datos generales</span>
        </a>
    </li>
    @endif
    @if (array_key_exists("plaza", $secciones))
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#kt_tab_datos_plaza">
        <span class="nav-icon"><i class="fas fa-user-cog"></i></span>
        <span class="nav-text">Datos de la plaza</span>
        </a>
    </li>
    @endif
    @if (array_key_exists("candidato", $secciones))
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#kt_tab_datos_candidato">
        <span class="nav-icon"><i class="fas fa-user"></i></span>
        <span class="nav-text">Datos del empleado</span>
        </a>
    </li>
    @endif
</ul>
<div class="tab-content">
    @if (array_key_exists("general", $secciones))
    <div class="tab-pane fade show active" id="kt_tab_datos_generales" role="tabpanel" aria-labelledby="kt_tab_datos_generales">
        <div class="row mt-8">
            <div class="col-md-3">
                <label class="titulo-dato"> Folio: </label>
                <span class="valor-dato"> <b> {{ $movimientoPersonal->folio }} </b> </span>
            </div>
            <div class="col-md-3">
                <label class="titulo-dato"> Unidad Administrativa: </label>
                <span class="valor-dato"> <b> {{ $movimientoPersonal->area->unidadAdministrativa->identificador }} - {{ $movimientoPersonal->area->unidadAdministrativa->nombre }}  </b> </span>
            </div>
            @if (in_array("tipo_movimiento", $secciones["general"]))
            <div class="col-md-3">
                <label class="titulo-dato"> Tipo de movimiento: </label>
                <span class="valor-dato"> <b> {{ $movimientoPersonal->tipoMovimiento->codigo }} - {{ $movimientoPersonal->tipoMovimiento->descripcion }} </b> </span>
            </div>
            <div class="col-md-3">
                <label class="titulo-dato"> Tipo de plaza: </label>
                <span class="valor-dato"> <b> {{ str_replace("_", " ", $movimientoPersonal->tipo_plaza) }} </b> </span>
            </div>
            @endif
            @if (in_array("fecha_solicitud", $secciones["general"]))
            <div class="col-md-3">
                <label class="titulo-dato">Fecha solicitud:</label>
                <span class="valor-dato"> <b> {{ convertirFechaFormatoMX($movimientoPersonal->fecha_solicitud) }} </b> </span>
            </div>
            @endif
            @if (in_array("procesamiento", $secciones["general"]))
            <div class="col-md-3">
                <label class="titulo-dato">Fecha de elaboración</label>
                <span class="valor-dato">  {{ convertirFechaFormatoMX($movimientoPersonal->fecha_elaboracion) }} </span>
            </div>
            <div class="col-md-3">
                <label class="titulo-dato">Año de procesado</label>
                <span class="valor-dato">  {{ $movimientoPersonal->anio_procesado }} </span>
            </div>
            <div class="col-md-3">
                <label class="titulo-dato">Quincena de procesado</label>
                <span class="valor-dato">  {{ $movimientoPersonal->qna_procesado }} </span>
            </div>
            @endif
        </div>
        @if (in_array("firmas", $secciones["general"]))
        <div class="separator separator-solid my-6"></div>
        <div class="row">
            
            <div class="col-md-12">
                <h5 class="text-dark font-weight-bold">Firmas movimiento</h5>
            </div>
            <div class="col-md-6">
                <label class="titulo-dato">Autorizador</label>
                <span class="valor-dato">  
                    {{ "{$movimientoPersonal->usuarioAutorizador->nombre} {$movimientoPersonal->usuarioAutorizador->apellido_paterno} {$movimientoPersonal->usuarioAutorizador->apellido_materno}" }} <br>
                    {{ $movimientoPersonal->usuarioAutorizador->puesto }} <br>
                    {{ $movimientoPersonal->usuarioAutorizador->area->unidadAdministrativa->nombre_unidad }}
                </span>
            </div>
            <div class="col-md-6">
                <label class="titulo-dato">Titular</label>
                <span class="valor-dato">  
                    {{ "{$movimientoPersonal->usuarioTitular->nombre} {$movimientoPersonal->usuarioTitular->apellido_paterno} {$movimientoPersonal->usuarioTitular->apellido_materno}" }} <br>
                    {{ $movimientoPersonal->usuarioTitular->puesto }} <br>
                    {{ $movimientoPersonal->usuarioTitular->area->unidadAdministrativa->nombre_unidad }}
                </span>
            </div>
        </div>
        @endif
    </div>
    @endif
    @if (array_key_exists("plaza", $secciones))
    <div class="tab-pane fade" id="kt_tab_datos_plaza" role="tabpanel" aria-labelledby="kt_tab_datos_plaza">
        <div class="row mt-8">
            <div class="col-md-3">
                <label class="titulo-dato">Número de plaza: </label>
                <span class="valor-dato">{{ $movimientoPersonal->numero_plaza }}</span>
            </div>
            <div class="col-md-3">
                <label class="titulo-dato">Situación de la plaza: </label>
                <span class="valor-dato">{{ $movimientoPersonal->codigo_situacion_empleado }}</span>
            </div>
            <div class="col-md-3">
                <label class="titulo-dato">Código de puesto: </label>
                <span class="valor-dato">{{ $movimientoPersonal->codigo_puesto }}</span>
            </div>
            <div class="col-md-3">
                <label class="titulo-dato">Nivel salarial: </label>
                <span class="valor-dato">{{ $movimientoPersonal->nivel_salarial }}</span>
            </div>
            <div class="col-md-3">
                <label class="titulo-dato">Universo: </label>
                <span class="valor-dato">{{ $movimientoPersonal->codigo_universo }}</span>
            </div>
            <div class="col-md-3">
                <label class="titulo-dato">Denominación Puesto: </label>
                <span class="valor-dato">{{ $movimientoPersonal->puesto }}</span>
            </div>
            <div class="col-md-3">
                <label class="titulo-dato">Observaciones plaza: </label>
                <span class="valor-dato">{!! $movimientoPersonal->observaciones_plaza ?? "<span class='badge badge-secondary'>N/A</span>" !!}</span>
            </div>
        </div>
    </div>
    @endif
    @if (array_key_exists("candidato", $secciones))
    <div class="tab-pane fade" id="kt_tab_datos_candidato" role="tabpanel" aria-labelledby="kt_tab_datos_candidato">
        <div class="row mt-8">
            <div class="col-md-3">
                <label class="titulo-dato">ID Sociedad:</label>
                <span class="valor-dato">  {{ $movimientoPersonal->sociedad_id }} </span>
            </div>
            <div class="col-md-3">
                <label class="titulo-dato">RFC:</label>
                <span class="valor-dato">  {{ $movimientoPersonal->rfc }} </span>
            </div>
            <div class="col-md-3">
                <label class="titulo-dato">Número de empleado:</label>
                <span class="valor-dato">  {{ $movimientoPersonal->numero_empleado }} </span>
            </div>
            <div class="col-md-3">
                <label class="titulo-dato">Nombre:</label>
                <span class="valor-dato">  {{ $movimientoPersonal->nombre_empleado }} {{ $movimientoPersonal->apellido_paterno }} {{ $movimientoPersonal->apellido_materno }} </span>
            </div>
            <div class="col-md-3">
                <label class="titulo-dato">Fecha inicio: </label>
                <span class="valor-dato text-uppercase">  {!! !is_null($movimientoPersonal->fecha_alta) ? convertirFechaFormatoMX($movimientoPersonal->fecha_alta) : "<span class='badge badge-secondary'>N/A</span>" !!} </span>
            </div>
            <div class="col-md-3">
                <label class="titulo-dato">Fecha fin: </label>
                <span class="valor-dato text-uppercase">  {!! !is_null($movimientoPersonal->fecha_fin) ? convertirFechaFormatoMX($movimientoPersonal->fecha_fin) : "<span class='badge badge-secondary'>N/A</span>" !!} </span>
            </div>
            <div class="col-md-3">
                <label class="titulo-dato">Correo electrónico: </label>
                <span class="valor-dato"> {{ $movimientoPersonal->email }} </span>
            </div>
            <div class="col-md-3">
                <label class="titulo-dato">Teléfono de casa: </label>
                <span class="valor-dato"> {!! $movimientoPersonal->telefono ?? "<span class='badge badge-secondary'>N/A</span>" !!} </span>
            </div>
            <div class="col-md-3">
                <label class="titulo-dato">Teléfono celular</label>
                <span class="valor-dato"> {!! $movimientoPersonal->telefono_celular ?? "<span class='badge badge-secondary'>N/A</span>" !!} </span>
            </div>
        </div>
        <div class="separator separator-solid my-6"></div>
        <div class="row">
            <div class="col-md-12">
                <h5 class="text-dark font-weight-bold">Domicilio</h5>
            </div>
            <div class="col-md-3">
                <label class="titulo-dato">Calle</label>
                <span class="valor-dato"> {{ $movimientoPersonal->calle }} </span>
            </div>
            <div class="col-md-3">
                <label class="titulo-dato">Número exterior</label>
                <span class="valor-dato"> {!! $movimientoPersonal->numero_exterior ?? "<span class='badge badge-secondary'>N/A</span>" !!} </span>
            </div>
            <div class="col-md-3">
                <label class="titulo-dato">Número interior</label>
                <span class="valor-dato"> {!! $movimientoPersonal->numero_interior ?? "<span class='badge badge-secondary'>N/A</span>" !!} </span>
            </div>
            <div class="col-md-3">
                <label class="titulo-dato">Código Postal</label>
                <span class="valor-dato"> {{ $movimientoPersonal->cp }} </span>
            </div>
            <div class="col-md-3">
                <label class="titulo-dato">Entidad</label>
                <span class="valor-dato"> {{ $movimientoPersonal->entidadFederativaDomicilio->nombre }} </span>
            </div>
            <div class="col-md-3">
                <label class="titulo-dato">Ciudad</label>
                <span class="valor-dato"> {{ $movimientoPersonal->ciudad }} </span>
            </div>
            <div class="col-md-3">
                <label class="titulo-dato">Alcaldía o Municipio</label>
                <span class="valor-dato"> {{ $movimientoPersonal->municipio_alcaldia }} </span>
            </div>
            <div class="col-md-3">
                <label class="titulo-dato">Colonia</label>
                <span class="valor-dato"> {{ $movimientoPersonal->colonia }} </span>
            </div>
        </div>
    </div>
    @endif
</div>