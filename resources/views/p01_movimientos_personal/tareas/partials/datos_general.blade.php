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
        <span class="nav-text">Datos del candidato</span>
        </a>
    </li>
    @endif
    @if (array_key_exists("movimiento", $secciones))
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#kt_tab_datos_movimiento">
        <span class="nav-icon"><i class="fas fa-arrow-alt-circle-up"></i></span>
        <span class="nav-text">Datos de fase de alta</span>
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
        @if (in_array("procesamiento", $secciones["general"]))
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
                <label class="titulo-dato">@if ($movimientoPersonal->tipo_plaza == "TECNICO_OPERATIVO") Actividades plaza: @else Funciones plaza: @endif </label>
                <span class="valor-dato">{!! $movimientoPersonal->funciones_plaza ?? "<span class='badge badge-secondary'>N/A</span>" !!}</span>
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
                <label class="titulo-dato">Nombre:</label>
                <span class="valor-dato"> {{ $movimientoPersonal->nombre_empleado }} {{ $movimientoPersonal->apellido_paterno }} {{ $movimientoPersonal->apellido_materno }} </span>
            </div>
            <div class="col-md-3">
                <label class="titulo-dato">RFC:</label>
                <span class="valor-dato"> {{ $movimientoPersonal->rfc }} </span>
            </div>
            <div class="col-md-3">
                <label class="titulo-dato">CURP:</label>
                <span class="valor-dato"> {{ $movimientoPersonal->curp }} </span>
            </div>
            <div class="col-md-3">
                <label class="titulo-dato">Nivel de estudios: </label>
                <span class="valor-dato"> {{ $movimientoPersonal->nivelEstudio->nombre }} </span>
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
            @if (in_array("datos_adicionales", $secciones["candidato"]))
            <div class="col-md-3">
                <label class="titulo-dato">Fecha de nacimiento</label>
                <span class="valor-dato">  {{ $movimientoPersonal->fecha_nacimiento }} </span>
            </div>
            <div class="col-md-3">
                <label class="titulo-dato">Entidad de Nacimiento</label>
                <span class="valor-dato">  {{ $movimientoPersonal->entidadFederativaNacimiento->nombre }} </span>
            </div>
            <div class="col-md-3">
                <label class="titulo-dato">Nacionalidad</label>
                <span class="valor-dato">  {{ $movimientoPersonal->nacionalidad }} </span>
            </div>
            <div class="col-md-3">
                <label class="titulo-dato">Estado civil</label>
                <span class="valor-dato">  {{ $movimientoPersonal->estadoCivil->nombre }} </span>
            </div>
            <div class="col-md-3">
                <label class="titulo-dato">Sexo</label>
                <span class="valor-dato">  {{ $movimientoPersonal->sexo->nombre }} </span>                   
            </div>
            <div class="col-md-3">
                <label class="titulo-dato">Número Seguro Social</label>
                <span class="valor-dato">  {!! $movimientoPersonal->numero_seguridad_social ?? "<span class='badge badge-secondary'>N/A</span>" !!} </span>
            </div>
            @endif
            <div class="col-md-3">
                <label class="titulo-dato">Fecha propuesta inicio: </label>
                <span class="valor-dato"> {{ convertirFechaFormatoMX($movimientoPersonal->fecha_propuesta_inicio) }} </span>
            </div>
        </div>
        @if (in_array("datos_direccion", $secciones["candidato"]))
        <div class="separator separator-solid my-6"></div>
        <div class="row">
            <div class="col-md-12">
                <h5 class="text-dark font-weight-bold">Domicilio</h5>
            </div>
            <div class="col-md-3">
                <label for="calle" class="titulo-dato">Calle</label>
                <span class="valor-dato">  {{ $movimientoPersonal->calle }} </span>
            </div>
            <div class="col-md-3">
                <label for="exterior" class="titulo-dato">Número exterior</label>
                <span class="valor-dato">  {!! $movimientoPersonal->numero_exterior ?? "<span class='badge badge-secondary'>N/A</span>" !!} </span>
            </div>
            <div class="col-md-3">
                <label for="interior" class="titulo-dato">Número interior</label>
                <span class="valor-dato">  {!! $movimientoPersonal->numero_interior ?? "<span class='badge badge-secondary'>N/A</span>" !!} </span>
            </div>
            <div class="col-md-3">
                <label for="tel" class="titulo-dato">Código Postal</label>
                <span class="valor-dato">  {{ $movimientoPersonal->cp }} </span>
            </div>
            <div class="col-md-3">
                <label for="entidad_federativa_domicilio_id" class="titulo-dato">Entidad</label>
                <span class="valor-dato">  {{ $movimientoPersonal->entidadFederativaDomicilio->nombre }} </span>
            </div>
            <div class="col-md-3">
                <label for="ciudad" class="titulo-dato">Ciudad</label>
                <span class="valor-dato">  {{ $movimientoPersonal->ciudad }} </span>
            </div>
            <div class="col-md-3">
                <label for="municipio_alcaldia" class="titulo-dato">Alcaldía o Municipio</label>
                <span class="valor-dato">  {{ $movimientoPersonal->municipio_alcaldia }} </span>
            </div>
            <div class="col-md-3">
                <label for="colonia" class="titulo-dato">Colonia</label>
                <span class="valor-dato">  {{ $movimientoPersonal->colonia }} </span>
            </div>
        </div>
        @endif
        @if (in_array("datos_psicometrico", $secciones["candidato"]))
        <div class="separator separator-solid my-6"></div>
        <div class="row">
            <div class="col-md-12">
                <h5 class="text-dark font-weight-bold">Psicométrico</h5>
            </div>
            @if (is_null($movimientoPersonal->calificacionPsicometrico))
            <div class="col-12">
                <div class="alert alert-custom alert-outline-danger fade show mb-5" role="alert">
                    <div class="alert-icon"><i class="flaticon-warning"></i></div>
                    <div class="alert-text">No se realizó examen psicométrico</div>
                </div>
            </div>
            @else 
            <div class="col-md-3">
                <label class="titulo-dato">Calificación psicométrico:</label>
                @if ($movimientoPersonal->calificacionPsicometrico->tipoCalificacionPsicometrico->nombre == "RECOMENDABLE")
                    <span class="label label-success label-inline mr-2 valor-dato text-uppercase">
                        {{ $movimientoPersonal->calificacionPsicometrico->tipoCalificacionPsicometrico->nombre }} 
                    </span>
                @else 
                    <span class="label label-danger label-inline mr-2 valor-dato text-uppercase">
                        {{ $movimientoPersonal->calificacionPsicometrico->tipoCalificacionPsicometrico->nombre }} 
                    </span>
                @endif
            </div>
            <div class="col-md-3">
                <label class="titulo-dato">Observaciones calificacion:</label>
                <span class="valor-dato"> {{ $movimientoPersonal->calificacionPsicometrico->observaciones_calificacion }} </span>
            </div>
            @endif
        </div>
        @endif
    </div>
    @endif
    @if (array_key_exists("movimiento", $secciones))
    <div class="tab-pane fade" id="kt_tab_datos_movimiento" role="tabpanel" aria-labelledby="kt_tab_datos_movimiento">
        <div class="row mt-8">
            <div class="col-md-3">
                <label class="titulo-dato">ID Sociedad:</label>
                <span class="valor-dato">  {{ $movimientoPersonal->sociedad_id }} </span>
            </div>
            <div class="col-md-3">
                <label class="titulo-dato">Empresa:</label>
                <span class="valor-dato"> {{$movimientoPersonal->empresa}} </span>
            </div>
            <div class="col-md-3">
                <label class="titulo-dato">Centro de trabajo:</label>
                <span class="valor-dato"> {{$movimientoPersonal->centro_trabajo}} </span>
            </div>
            <div class="col-md-3">
                <label class="titulo-dato">Tipo de salario:</label>
                <span class="valor-dato"> {{$movimientoPersonal->tipo_salario}} </span>
            </div>
            <div class="col-md-3">
                <label class="titulo-dato">Pagaduría:</label>
                <span class="valor-dato">  {{ $movimientoPersonal->pagaduria }} </span>
            </div>
            <div class="col-md-3">
                <label class="titulo-dato">Fecha propuesta inicio:</label>
                <span class="valor-dato">  {{ convertirFechaFormatoMX($movimientoPersonal->fecha_propuesta_inicio) }} </span>
            </div>
            <div class="col-md-3">
                <label class="titulo-dato">Registra asistencia</label>
                <span class="valor-dato">  {{ $movimientoPersonal->asistencia }} </span>
            </div>
            <div class="col-md-3">
                <label class="titulo-dato">Turno</label>
                <span class="valor-dato">  {{ $movimientoPersonal->turno->nombre }} </span>
            </div>        
            <div class="col-md-3">
                <label class="titulo-dato">Regimen ISSSTE</label>
                <span class="valor-dato">  {{ $movimientoPersonal->regimenIssste->nombre }} </span>
            </div>
            <div class="col-md-3">
                <label class="titulo-dato">Zona pagadora</label>
                <span class="valor-dato">  {{ $movimientoPersonal->zonaPagadora->nombre }} </span>
            </div>
            <div class="col-md-3">
                <label class="titulo-dato">Fecha fin</label>
                <span class="valor-dato">  {!! $movimientoPersonal->fecha_fin ?? "<span class='badge badge-secondary'>N/A</span>" !!} </span>
            </div>
            <div class="col-md-3">
                <label class="titulo-dato">Fin de contrato</label>
                <span class="valor-dato">  {!! $movimientoPersonal->fecha_fin_contrato ?? "<span class='badge badge-secondary'>N/A</span>" !!} </span>
            </div> 
            <div class="col-md-3">
                <label class="titulo-dato">Contrato SAR</label>
                <span class="valor-dato">  {!! $movimientoPersonal->contrato_sar ?? "<span class='badge badge-secondary'>N/A</span>" !!} </span>
            </div>
            <div class="col-md-3">
                <label class="titulo-dato">Contrato interno</label>
                <span class="valor-dato">  {!! $movimientoPersonal->contrato_interno ?? "<span class='badge badge-secondary'>N/A</span>" !!} </span>
            </div>
            <div class="col-md-3">
                <label class="titulo-dato">Grado</label>
                <span class="valor-dato">  {!! $movimientoPersonal->grado ?? "<span class='badge badge-secondary'>N/A</span>" !!} </span>
            </div>
        </div>
        <div class="separator separator-solid my-6"></div>
        <div class="row">
            <div class="col-md-12">
                <h5 class="text-dark font-weight-bold">Datos bancarios</h5>
            </div>
            <div class="col-md-3">
                <label class="titulo-dato">Tipo de pago</label>
                <span class="valor-dato">  {!! !is_null($movimientoPersonal->tipoPago) ? $movimientoPersonal->tipoPago->nombre : "<span class='badge badge-secondary'>N/A</span>" !!} </span>
            </div>
            <div class="col-md-3">
                <label class="titulo-dato">Banco</label>
                <span class="valor-dato">  {!! !is_null($movimientoPersonal->banco) ? $movimientoPersonal->banco->nombre : "<span class='badge badge-secondary'>N/A</span>" !!} </span>
            </div>
            <div class="col-md-3">
                <label class="titulo-dato">Agencia o Sucursal</label>
                <span class="valor-dato">  {!! $movimientoPersonal->agencia ?? "<span class='badge badge-secondary'>N/A</span>" !!} </span>
            </div>
            <div class="col-md-3">
                <label class="titulo-dato">Número de cuenta</label>
                <span class="valor-dato">  {!! $movimientoPersonal->numero_cuenta_bancaria ?? "<span class='badge badge-secondary'>N/A</span>" !!} </span>
            </div>
            <div class="col-md-3">
                <label class="titulo-dato">Modo de deposito</label>
                <span class="valor-dato">  {!! $movimientoPersonal->modo_deposito ?? "<span class='badge badge-secondary'>N/A</span>" !!} </span>
            </div>
        </div>
    </div>
    @endif
</div>