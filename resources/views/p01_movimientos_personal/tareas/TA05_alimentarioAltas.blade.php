@extends('layouts.main')

@section('title', "MOVIMIENTOS DE PERSONAL - {$instanciaTarea->tarea->nombre}")

@section('subheader')
    @include('layouts.partials.main.subheader', ["subheader" => [
        "titulo_subheader" => "PROCDGA",
        "icono_titulo_subheader" => "far fa-folder-open",
        "breadcrumbs" => [
            1 => [
                'activo' => false,
                'titulo' => 'Tareas disponibles',
                'ruta' => Route('tareas')
            ],
            2 => [
                'activo' => true,
                'titulo' => "MOVIMIENTOS DE PERSONAL - {$instanciaTarea->tarea->nombre}"
            ]
        ]
    ]])
@endsection

@section('aside_menu')
    @include('layouts.partials.main.aside_menu', ["asideMenu" =>
        [
            "item_seleccionado" => "tareas",
        ]
    ])
@endsection

@section('contenido')
    @if ($instanciaTarea->estatus == 'EN_CORRECCION')
        <div class="alert alert-custom alert-danger mb-8" role="alert">
            <div class="alert-icon"><i class="flaticon-warning"></i></div>
            <div class="alert-text">
                <h4 class="alert-heading">SOLICITUD RECHAZADA</h4>
                <p>{{ $movimientoPersonal->motivo_rechazo }}</p>
            </div>
        </div>
    @endif
    <form method="POST" id="formAlimentarioAltas" action="{{ route("movimiento.personal.altas.alimentario", [$movimientoPersonal, $instanciaTarea]) }}">
        @csrf
        <div class="card card-custom">
            <div class="card-body">
                @include("p01_movimientos_personal.tareas.partials.datos_general", [
                    "secciones" => [
                        "general" => ["tipo_movimiento", "fecha_Solicitud"],
                        "plaza" => [],
                        "candidato" => ["datos_psicometrico"]
                    ]
                ])
            </div>
        </div>
        <div class="card card-custom mt-8">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Datos adicionales del candidato</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato"><strong><span class="text-danger">* </span>Fecha de nacimiento</strong></label>
                        <input type="text" class="form-control input-date" name="fecha_nacimiento" value="{{ $movimientoPersonal->fecha_nacimiento ?? "" }}" autocomplete="off" readonly required>
                    </div>
                    
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato"><strong><span class="text-danger">* </span>Entidad de Nacimiento</strong></label>
                        <select name="entidad_federativa_nacimiento_id" id="entidad_federativa_nacimiento_id" class="form-control select2" autocomplete="off" required>
                            <option value="">Seleccione una opción</option>
                            @foreach ($entidades as $entidad)
                                @if ($entidad->entidad_federativa_id == $movimientoPersonal->entidad_federativa_nacimiento_id)
                                    <option value="{{ $entidad->entidad_federativa_id }}" selected>{{ $entidad->nombre }}</option>
                                @else
                                    <option value="{{ $entidad->entidad_federativa_id }}">{{ $entidad->nombre }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato"><strong><span class="text-danger">* </span>Nacionalidad</strong></label>
                        <select name="nacionalidad" id="nacionalidad" class="form-control" autocomplete="off" required>
                            <option value="">Seleccione una opción</option>
                            <option value ="MEXICANA" @if(isset($movimientoPersonal->nacionalidad) and $movimientoPersonal->nacionalidad == "MEXICANA") selected @endif>MEXICANA</option>
                            <option value ="EXTRANJERA" @if(isset($movimientoPersonal->nacionalidad) and $movimientoPersonal->nacionalidad == "EXTRANJERA") selected @endif>EXTRANJERA</option>
                        </select>
                    </div>
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato"><strong><span class="text-danger">* </span>Estado civil</strong></label>
                        <select class="form-control" name="estado_civil_id" id="estado_civil_id" autocomplete="off" required>
                            <option value="">Seleccione una opción</option>
                            @foreach ($estadosCiviles as $estadoCivil)
                                @if ($estadoCivil->estado_civil_id == $movimientoPersonal->estado_civil_id)
                                    <option value="{{ $estadoCivil->estado_civil_id }}" selected>{{ $estadoCivil->nombre }}</option>
                                @else
                                    <option value="{{ $estadoCivil->estado_civil_id }}">{{ $estadoCivil->nombre }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 form-group mb-0">
                        <label class="titulo-dato"><strong><span class="text-danger">* </span>Sexo</strong></label>
                        <select class="form-control" name="sexo_id" id="sexo_id" autocomplete="off" required>
                            <option value="">Seleccione una opción</option>
                            @foreach ($sexos as $sexo)
                                @if ($sexo->sexo_id == $movimientoPersonal->sexo_id)
                                    <option value="{{ $sexo->sexo_id }}" selected>{{ $sexo->nombre }}</option>
                                @else
                                    <option value="{{ $sexo->sexo_id }}">{{ $sexo->nombre }}</option>
                                @endif
                            @endforeach
                        </select>                    
                    </div>
                    <div class="col-md-3 form-group mb-0">
                        <label class="titulo-dato">Número Seguro Social</label>
                        <input type="number" class="form-control" name="numero_seguridad_social" value="{{ $movimientoPersonal->numero_seguridad_social ?? ""}}" autocomplete="off" number="true">
                    </div>
                </div>
                <h5 class="text-dark font-weight-bold mt-8">Domicilio</h5>
                <hr class="mb-8">
                <div class="row contenedor-direccion">
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato"><strong><span class="text-danger">* </span>Calle</strong></label>
                        <input type="text" class="form-control normalizar-texto" name="calle" value="{{ $movimientoPersonal->calle ?? ""}}" autocomplete="off" required>
                    </div>
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato">Número exterior</label>
                        <input type="text" class="form-control normalizar-texto" name="numero_exterior" value="{{ $movimientoPersonal->numero_exterior ?? "" }}" autocomplete="off">
                    </div>
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato">Número interior</label>
                        <input type="text" class="form-control normalizar-texto" name="numero_interior" value="{{ $movimientoPersonal->numero_interior ?? "" }}" autocomplete="off">
                    </div>
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato"><strong><span class="text-danger">* </span>Código Postal</strong></label>
                        <input type="text" class="form-control cp" name="cp" value="{{ $movimientoPersonal->cp ?? "" }}" data-url="{{ route('catalogo.codigo.postal.v2') }}" placeholder="5 Digitos" autocomplete="off" maxlength="5" required>
                    </div>
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato"><strong><span class="text-danger">* </span>Entidad</strong></label>
                        <select name="entidad_federativa_domicilio_id" class="form-control entidad-federativa select2" autocomplete="off" required>
                            <option value="">Seleccione una opción</option>
                            @foreach ($entidades as $ent)
                                @if ($ent->entidad_federativa_id == $movimientoPersonal->entidad_federativa_domicilio_id)
                                    <option value="{{ $ent->entidad_federativa_id }}" selected>{{ $ent->nombre }}</option>
                                @else
                                    <option value="{{ $ent->entidad_federativa_id }}">{{ $ent->nombre }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato"><strong><span class="text-danger">* </span>Ciudad</strong></label>
                        <input type="text" class="form-control ciudad normalizar-texto" name="ciudad" value="{{ $movimientoPersonal->ciudad ?? "" }}" autocomplete="off" required>
                    </div>
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato"><strong><span class="text-danger">* </span>Alcaldía o Municipio</strong></label>
                        <input type="text" class="form-control municipio-alcaldia normalizar-texto" name="municipio_alcaldia" value="{{ $movimientoPersonal->municipio_alcaldia ?? "" }}" autocomplete="off" required>
                    </div>
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato"><strong><span class="text-danger">* </span>Colonia</strong></label>
                        <div id="id_contenedor_colonia">
                            <select class="form-control select2 colonia" name="colonia" autocomplete="off" required>
                                <option value=""> Seleccione una colonia </option>
                                @if ($movimientoPersonal->colonia)
                                    <option value="{{ $movimientoPersonal->colonia }}" selected> {{ $movimientoPersonal->colonia }} </option>
                                @endif
                            </select>
                        </div>
                    </div>
                </div>         
            </div>
        </div>
        <div class="card card-custom mt-8">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Datos fase de alta</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato">ID Sociedad:</label>
                        <span class="font-size-h6">  {{ $movimientoPersonal->sociedad_id }} </span>
                    </div>
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato">Empresa:</label>
                        <span class="font-size-h6"> {{$movimientoPersonal->empresa}} </span>
                    </div>
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato">Centro de trabajo:</label>
                        <span class="font-size-h6"> {{$movimientoPersonal->centro_trabajo}} </span>
                    </div>
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato">Tipo de salario:</label>
                        <span class="font-size-h6"> {{$movimientoPersonal->tipo_salario}} </span>
                    </div>
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato">Pagaduría:</label>
                        <span class="font-size-h6">  {{ $movimientoPersonal->pagaduria }} </span>
                    </div>
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato">Fecha propuesta inicio:</label>
                        <span class="font-size-h6 text-uppercase">  {{ convertirFechaFormatoMX($movimientoPersonal->fecha_propuesta_inicio) }} </span>
                    </div>
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato"><strong><span class="text-danger">* </span>Registra asistencia</strong></label>
                        <select name="asistencia" class="form-control" autocomplete="off" required>
                            <option value="">Seleccione una opción</option>
                            <option value="SI" @if(isset($movimientoPersonal->asistencia) and $movimientoPersonal->asistencia == "SI") selected @endif>SÍ</option>
                            <option value="NO" @if(isset($movimientoPersonal->asistencia) and $movimientoPersonal->asistencia == "NO") selected @endif>NO</option>
                        </select>
                    </div>
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato"><strong><span class="text-danger">* </span>Turno</strong></label>
                        <select class="form-control" name="turno_id" autocomplete="off" required>
                            <option value="">Seleccione una opción</option>
                            @foreach ($turnos as $turn)
                                @if ($turn->turno_id == $movimientoPersonal->turno_id)
                                    <option value="{{ $turn->turno_id }}" selected>{{ $turn->nombre }}</option>
                                @else
                                    <option value="{{ $turn->turno_id }}">{{ $turn->nombre }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>        
                    {{-- <div class="col-md-3 form-group">
                        <label class="titulo-dato"><strong><span class="text-danger">* </span>Situación de empleado</strong></label>
                        <select class="form-control" name="situacion_empleado_id" autocomplete="off" required>
                            <option value="">Seleccione una opción</option>
                            @foreach ($situacionEmpleado as $sitEmple)
                                @if ($sitEmple->situacion_empleado_id == $movimientoPersonal->situacion_empleado_id)
                                    <option value="{{ $sitEmple->situacion_empleado_id }}" selected>{{ $sitEmple->identificador }} - {{ $sitEmple->nombre }}</option>
                                @else
                                    <option value="{{ $sitEmple->situacion_empleado_id }}">{{ $sitEmple->identificador }} - {{ $sitEmple->nombre }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div> --}}
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato"><strong><span class="text-danger">* </span>Regimen ISSSTE</strong></label>
                        <select class="form-control" name="regimen_issste_id" autocomplete="off" required>
                            <option value="">Seleccione una opción</option>
                            @foreach ($regimen as $reg)
                                @if ($reg->regimen_issste_id == $movimientoPersonal->regimen_issste_id)
                                    <option value="{{ $reg->regimen_issste_id }}" selected>{{ $reg->identificador }} - {{ $reg->nombre }}</option>
                                @else
                                    <option value="{{ $reg->regimen_issste_id }}">{{ $reg->identificador }} - {{ $reg->nombre }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato"><strong><span class="text-danger">* </span>Zona pagadora</strong></label>
                        <select id="zona_pagadora_id" name="zona_pagadora_id" class="form-control select2" autocomplete="off" required>
                            <option value="">Selecciona una opción</option>
                            @foreach ($zonasPagadoras as $zonaPagadora)
                                @if ($zonaPagadora->zona_pagadora_id == $movimientoPersonal->zona_pagadora_id)
                                    <option value="{{ $zonaPagadora->zona_pagadora_id }}" selected>{{ "$zonaPagadora->identificador - $zonaPagadora->nombre" }}</option>
                                @else
                                    <option value="{{ $zonaPagadora->zona_pagadora_id }}">{{ "$zonaPagadora->identificador - $zonaPagadora->nombre" }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 form-group">
                        <label for="fecha_fin" class="titulo-dato">Fecha fin</label>
                        <input type="text" class="form-control input-date" name="fecha_fin" value="{{ $movimientoPersonal->fecha_fin ?? "" }}" autocomplete="off">
                    </div>
                    <div class="col-md-3 form-group">
                        <label for="fin_contrato" class="titulo-dato">Fin de contrato</label>
                        <input type="text" class="form-control input-date" name="fecha_fin_contrato" value="{{ $movimientoPersonal->fecha_fin_contrato ?? ""}} " autocomplete="off">
                    </div> 
                    <div class="col-md-3 form-group">
                        <label for="SAR" class="titulo-dato">Contrato SAR</label>
                        <input type="text" class="form-control normalizar-texto" name="contrato_sar" value="{{ $movimientoPersonal->contrato_sar ?? "" }}" autocomplete="off">
                    </div>
                    <div class="col-md-3 form-group">
                        <label for="contrato_interno" class="titulo-dato">Contrato interno</label>
                        <input type="text" class="form-control normalizar-texto" name="contrato_interno" value="{{ $movimientoPersonal->contrato_interno ?? "" }}" autocomplete="off">
                    </div>
                    <div class="col-md-3 form-group">
                        <label for="grado" class="titulo-dato">Grado</label>
                        <input type="text" class="form-control normalizar-texto" name="grado" value="{{ $movimientoPersonal->grado ?? ""}}" autocomplete="off">
                    </div>
                </div>
                <h5 class="text-dark font-weight-bold mt-8">Datos bancarios</h5>
                <hr class="mb-8">
                <div class="row">
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato">Tipo de pago</label>
                        <select class="form-control" name="tipo_pago_id" autocomplete="off">
                            <option value="">Seleccione una opción</option>
                            @foreach ($tipoPago as $tiPago)
                                @if ($tiPago->tipo_pago_id == $movimientoPersonal->tipo_pago_id)
                                    <option value="{{ $tiPago->tipo_pago_id }}" selected>{{ $tiPago->nombre }}</option>
                                @else
                                    <option value="{{ $tiPago->tipo_pago_id }}">{{ $tiPago->nombre }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato">Banco</label>
                        <select class="form-control" name="banco_id" autocomplete="off">
                            <option value="">Seleccione una opción</option>
                            @foreach ($bancos as $ban)
                                @if ($ban->banco_id == $movimientoPersonal->banco_id)
                                    <option value="{{ $ban->banco_id }}" selected>{{ $ban->nombre }}</option>
                                @else
                                    <option value="{{ $ban->banco_id }}">{{ $ban->nombre }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 form-group">
                        <label for="agencia" class="titulo-dato">Agencia</label>
                        <input type="text" class="form-control normalizar-texto" name="agencia" value="{{ $movimientoPersonal->agencia ?? "" }}" autocomplete="off">
                    </div>
                    <div class="col-md-3 form-group">
                        <label for="numero_cuenta_bancaria" class="titulo-dato">Número de cuenta</label>
                        <input type="text" class="form-control normalizar-texto" name="numero_cuenta_bancaria" value="{{ $movimientoPersonal->numero_cuenta_bancaria ?? "" }}"  maxlength="16" autocomplete="off">
                    </div>
                    <div class="col-md-3 form-group">
                        <label for="modo_deposito" class="titulo-dato">Modo de deposito</label>
                        <input type="text" class="form-control normalizar-texto" name="modo_deposito" value="{{ $movimientoPersonal->modo_deposito ?? "" }}" autocomplete="off">
                    </div>
                </div>
            </div>
        </div>
        <div class="card card-custom mt-8">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Firmas del movimiento</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <label class="titulo-dato"><strong><span class="text-danger">* </span>Autorizador</strong></label>
                        <select name="autorizador" class="form-control" autocomplete="off" required>
                            <option value="">Selecciona una opción</option>
                            @foreach ($usersDGA as $user)
                                @if ($user->id == $movimientoPersonal->autorizador)
                                    <option value="{{ $user->id }}" selected> {{ "{$user->nombre} {$user->apellido_paterno} {$user->apellido_materno} - {$user->puesto}" }} </option>
                                @else
                                    <option value="{{ $user->id }}"> {{ "{$user->nombre} {$user->apellido_paterno} {$user->apellido_materno} - {$user->puesto}" }} </option>
                                @endif
                            @endforeach    
                        </select>
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="titulo-dato"><strong><span class="text-danger">* </span>Titular</strong></label>
                        <select name="titular" class="form-control" autocomplete="off" required>
                            <option value="">Selecciona una opción</option>
                            @foreach ($usersTitulares as $user)
                                @if ($user->id == $movimientoPersonal->titular)
                                    <option value="{{ $user->id }}" selected> {{ "{$user->nombre} {$user->apellido_paterno} {$user->apellido_materno} - {$user->puesto}" }} </option>
                                @else
                                    <option value="{{ $user->id }}"> {{ "{$user->nombre} {$user->apellido_paterno} {$user->apellido_materno} - {$user->puesto}" }} </option>
                                @endif
                            @endforeach    
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="text-center">
                    {{-- <button type="button" class="btn btn-primary btn-lg mr-2" id="btn_guardar_avance"><i class="fas fa-save"></i> Guardar avance</button> --}}
                    <button type="submit" class="btn btn-success"><i class="fas fa-check-square"></i> Finalizar tarea</button>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script src="{{ asset('js/componentes/codigo_postalv2.js?v=1.0') }}"></script>
    <script src="{{ asset('js/p01_movimientos_personal/tareas/TA05_alimentarioAltas.js?v=1.0')}}"></script>
@endpush
