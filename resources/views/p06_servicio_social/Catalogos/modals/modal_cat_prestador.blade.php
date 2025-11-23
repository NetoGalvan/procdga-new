<div class="modal fade" id="modalPrestador" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">

            <div class="card card-custom">
                <div class="card-header py-2">
                    <div class="card-title">
                        <h3 class="card-label"></h3>
                    </div>
                    <div class="mt-2">
                        <div class="alert alert-custom alert-success font-size-sm" role="alert">
                            <div class="alert-icon"><i class="flaticon-warning"></i></div>
                            <div class="alert-text">
                                <strong>
                                    NOTA: Si no aparece la institución, escuela o programa, deberá agregarse previamente en el catálogo correspondiente.<br>
                                </strong>
                            </div>
                        </div>
                    </div>
                    <div class="card-toolbar ml-auto">
                        <ul class="nav nav-bold nav-pills">
                            <li class="nav-item">
                                <a class="nav-link disabled active" data-toggle="tab" href="#datos_escolares">Datos escolares</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link disabled" data-toggle="tab" href="#prestacion">Datos de prestación</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link disabled" data-toggle="tab" href="#datos_prestador">Datos del prestador</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" id="formPrestador">
                    @csrf
                    @method('post')
                    {{-- BEGIN::DATOS ESCOLARES --}}
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="datos_escolares" role="tabpanel">
                            <div class="col-md-12">
                                <h4>Datos escolares</h4>
                                <div class="row">
                                    <div class="col-md-12 align-middle">
                                        <label class="titulo-dato"><strong><span class="requeridos">* </span>Institución</strong></label>
                                        <select class="form-control instituciones" name="institucion_id">
                                            <option val="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                            @foreach($instituciones as $inst)
                                                <option value="{{$inst->institucion_id}}">
                                                    <b>{{$inst->acronimo_institucion}} |</b> {{ $inst->nombre_institucion }} 
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="titulo-dato"><strong><span class="requeridos">* </span>Nombre escuela</strong></label>
                                        <select class="form-control escuelas" name="escuela_id">
                                            <option value="" disabled selected>SELECCIONE UNA OPCIÓN</option>
                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="titulo-dato"><strong>Programa escolar</strong></label>
                                        <select class="form-control programas" name="programa_id">
                                            <option value="" disabled selected>SELECCIONE UNA OPCIÓN</option>
                                        </select>
                                    </div>
                                    <div class="col-md-8">
                                        <label class="titulo-dato"><strong><span class="requeridos">* </span>Carrera</strong></label>
                                        <input type="text" class="form-control normalizar-texto carrera" name="carrera">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="titulo-dato"><strong><span class="requeridos">* </span>Matrícula</strong></label>
                                        <input type="text" class="form-control normalizar-texto matricula" name="matricula">
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- END::DATOS ESCOLARES --}}
                        {{-- BEGIN::DATOS DE PRESTACION --}}
                        <div class="tab-pane fade" id="prestacion" role="tabpanel">
                            <div class="col-md-12">
                                <h4>Datos de prestación</h4>
                                <div class="row">
                                    <div class="col-md-5">
                                        <label class="titulo-dato"><strong><span class="requeridos">* </span>Nombre funcionario</strong></label>
                                        <input type="text" class="form-control normalizar-texto nombre-func" name="nombre_funcionario">
                                    </div>
                                    <div class="col-md-4">
                                            <label class="titulo-dato"><strong><span class="requeridos">* </span>Puesto funcionario</strong></label>
                                            <input type="text" class="form-control normalizar-texto puesto-func" name="puesto_funcionario">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="titulo-dato"><strong><span class="requeridos">* </span>Teléfono funcionario</strong></label>
                                        <input type="text" class="form-control telefono-func" name="telefono_funcionario" placeholder="10 Dígitos">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="titulo-dato"><strong><span class="requeridos">* </span>Tipo de prestador</strong></label>
                                        <select class="form-control normalizar-texto tipo-prestador" name="tipo_prestador">
                                            <option value="" disabled selected>Seleccione una opción</option>
                                            @foreach($tipos as $tipo)
                                                <option value="{{$tipo}}"> {{ $tipo }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="titulo-dato"><strong><span class="requeridos">* </span>Total de horas</strong></label>
                                        <input type="text" class="form-control normalizar-texto total-hrs" name="total_horas">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="col-md-12">
                                <p><strong>HORARIO QUE PUEDE CUBRIR</strong></p>
                                <div class="row">
                                    <div class="col-md-5">

                                        <label class="titulo-dato"><strong><span class="requeridos">* </span>entrada</strong></label>
                                        <input type="text" class="form-control hr-entrada" name="hora_entrada" placeholder="HORA DE ENTRADA" readonly />
                                    </div>
                                    <div class="col-md-5">
                                        <label class="titulo-dato"><strong><span class="requeridos">* </span>salida</strong></label>
                                        <input type="text" class="form-control hr-salida" name="hora_salida" placeholder="HORA DE SALIDA" readonly />
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- END::DATOS DE PRESTACION --}}
                        {{-- BEGIN::DATOS DEL PRESTADOR --}}
                        <div class="tab-pane fade" id="datos_prestador" role="tabpanel">
                            <div class="col-md-12">
                                <h4>Datos del prestador</h4>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="titulo-dato"><strong><span class="requeridos">* </span>Nombre(s)</strong></label>
                                        <input class="form-control normalizar-texto nombre-prestador" type="text" name="nombre">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="titulo-dato"><strong><span class="requeridos">* </span>Primer apellido</strong></label>
                                        <input class="form-control normalizar-texto primer-ape" type="text" name="apePaterno">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="apeMaterno" class="titulo-dato"><strong><span class="requeridos">* </span>Segundo apellido</strong></label>
                                        <input class="form-control normalizar-texto segundo-ape" type="text" name="apeMaterno">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="titulo-dato"><strong><span class="requeridos">* </span>Correo electrónico</strong></label>
                                        <input type="email" class="form-control text-lowercase correo" name="correo">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="telefono" class="titulo-dato"><strong><span class="requeridos">* </span>Teléfono celular</strong></label>
                                        <input type="tel" class="form-control telefono" placeholder="10 dígitos" name="telefono">
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="titulo-dato"><strong><span class="requeridos">* </span>Código postal</strong></label>
                                        <input type="text" class="form-control cp" placeholder="5 Digitos" name="cp">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="titulo-dato"><strong><span class="requeridos">* </span>Entidad</strong></label>
                                        <select class="form-control entidades" name="entidad_id">
                                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                            @foreach($entidades as $entidad)
                                            <option value="{{ $entidad->entidad_federativa_id }}"> {{ $entidad->nombre }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="titulo-dato"><strong><span class="requeridos">* </span>Colonia</strong></label>
                                        <input type="text" class="form-control normalizar-texto colonia" name="colonia">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="titulo-dato"><strong><span class="requeridos">* </span>Ciudad</strong></label>
                                        <input type="text" class="form-control normalizar-texto ciudad" name="ciudad">
                                    </div>

                                    <div class="col-md-4">
                                        <label class="titulo-dato"><strong><span class="requeridos">* </span>Alcaldía o Municipio</strong></label>
                                        <select class="form-control alcaldias_municipios" name="municipio_id">
                                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="titulo-dato"><strong><span class="requeridos">* </span>Calle</strong></label>
                                        <input type="text" class="form-control normalizar-texto calle" name="calle">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="titulo-dato"><strong><span class="requeridos">* </span>No. exterior</strong></label>
                                        <input type="text" class="form-control no-ext" name="exterior">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="titulo-dato">No. interior</label>
                                        <input type="text" class="form-control no-int" name="interior">
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="titulo-dato"><strong>Observaciones</strong></label>
                                        <textarea class="form-control normalizar-texto observaciones" name="observaciones"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- END::DATOS DEL PRESTADOR --}}
                    </div>

                    </form>
                </div>
                <div class="card-footer">
                    <div class="col-md-12 text-center">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">
                            <i class="fas fa-times"></i> Cancelar
                        </button>
                        <button type="button" class="btn btn-secondary atras" hidden>
                            <i class="fas fa-arrow-left"></i> Atras
                        </button>
                        <button type="button" class="btn btn-secondary siguiente">
                            <i class="fas fa-arrow-right"></i> Siguiente
                        </button>
                        <button type="button" class="btn btn-primary guardar-modificar-prestador" hidden>
                            <i class="fas fa-save"></i> Guardar
                        </button>
                    </div>
                </div>
                <div class="bloquear-spinner"></div>
            </div>
        </div>
    </div>
</div>