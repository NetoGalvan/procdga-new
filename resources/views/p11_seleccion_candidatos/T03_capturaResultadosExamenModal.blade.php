

<div class="modal fade" id="modalDatosCandidatos" tabindex="-1" role="dialog"
	aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable modal-xl"
		role="document" style="max-width: 1200px !important">

        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Capturar información</h5>
            </div>

			<div class="modal-body">

                <form action="{{route('seleccion.candidatos.guardar.datos.empleados',$candidatoEstructura)}}" id="datosUsuarios">
                    @csrf
                    @method('POST')

                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="card-title">Datos del Empleado</h5>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="apePaterno"><span class="requeridos">* </span>Apellido Paterno</label>
                                    <input class="form-control form-control-sm" type="text" name="apePaterno" id="apePaterno" value="{{$seleccionCandidato->apellido_paterno_candidato}}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="apeMaterno"><span class="requeridos">* </span>Apellido
                                    Materno</label> <input class="form-control form-control-sm"
                                    type="text" name="apeMaterno" id="apeMaterno">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="nombre"><span class="requeridos">* </span>Nombre</label>
                                <input class="form-control form-control-sm" type="text"
                                    name="nombre" id="nombre">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="apePaterno"><span class="requeridos">* </span>Fecha
                                    de nacimiento</label> <input
                                    class="form-control form-control-sm date" type="text"
                                    name="fhNacimiento" id="fhNacimiento">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="apePaterno"><span class="requeridos">* </span>Edad</label>
                                <input class="form-control form-control-sm" type="text"
                                    name="edad" id="edad">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="apePaterno"><span class="requeridos">* </span>Sexo</label>
                                <select class="form-control form-control-sm" name="sexo"
                                    id="sexo"></select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="apePaterno"><span class="requeridos">* </span>Estado
                                    civil:</label> <select class="form-control form-control-sm"
                                    name="estadoCivil" id="estadoCivil">
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="escolaridad"><span class="requeridos">* </span>
                                    Escolaridad:</label> <select
                                    class="form-control form-control-sm"
                                    name="escolaridad" id="escolaridad">
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="puestoActual"><span class="requeridos">* </span>Puesto
                                    actual:</label> <input class="form-control form-control-sm"
                                    type="text" name="puestoActual" id="puestoActual">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="apePaterno"><span class="requeridos">* </span>Tipo
                                    de movimiento:</label> <input
                                    class="form-control form-control-sm" type="text"
                                    name="tipoMovimiento" id="tipoMovimiento">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="apePaterno">Motivo de evaluación:</label><input
                                    class="form-control form-control-sm" type="text"
                                    name="motivoEvaluacion" id="motivoEvaluacion">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="apePaterno"><span class="requeridos">* </span>Folio
                                    Contraloria</label> <input
                                    class="form-control form-control-sm" type="text"
                                    name="folioContraloria" id="folioContraloria">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="card-title">Diagnóstico</h5>
                            <hr style="color: #0056b2;" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="apePaterno">Elabora:</label> <input
                                    class="form-control form-control-sm" type="text"
                                    name="elabora" id="elabora">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="apeMaterno">Fecha de evaluación:</label> <input
                                    class="form-control form-control-sm date" type="text"
                                    name="fhEvaluacion" id="fhEvaluacion">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="nombre">Resultado de la Evaluación:</label><select
                                    class="form-control form-control-sm" id="aceptacion_eval"
                                    name="aceptacion_eval">
                                    <option value="RECOMENDABLE">RECOMENDABLE</option>
                                    <option value="RECOMENDABLE CON RESERVA">RECOMENDABLE CON
                                        RESERVA</option>
                                    <option value="NO RECOMENDABLE">NO RECOMENDABLE</option>
                                    <option value="INCONCLUSO">INCONCLUSO</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="nombre">Síntesis de evaluación:</label>
                                <textarea class="form-control form-control-sm" rows="4"
                                    name="sintesisEvaluacion" id="sintesisEvaluacion"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <button type="button" class="btn btn-primary btn-sm"
                                    id="datosCandidatosBoton">Guardar Datos del Candidato</button>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div id="mensajesDatosPersonales"></div>
                        </div>
                    </div>
                    <input name="candidato_id" hidden id="candidato_id" />
                </form>

                <form id="evaluaciones"
                    action="{{route('seleccion.candidatos.guardar.datos.eval',$candidatoEstructura)}}">
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="card-title">Integración de Resultados</h5>
                            <hr style="color: #0056b2;" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 d-flex justify-content-center">
                            <label for="nivel" class="tamanoLetras"
                                style="text-decoration: underline; text-decoration-color: #e5e5e5;">Personalidad</label>


                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="nivel" class="tamanoLetras">Disponibilidad:</label>
                                <select class="form-control form-control-sm tamanoSelects"
                                    id="disponibilidad" name="arregloPersonalidad[disponibilidad]">
                                    <option value="N.A.">N.A.</option>
                                    <option value="B">B</option>
                                    <option value="P">P</option>
                                    <option value="A">A</option>
                                    <option value="S">S</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="nivel" class="tamanoLetras">Estabilidad Emocional:
                                </label> <select
                                    class="form-control form-control-sm tamanoSelects"
                                    id="estabilidadEmocional"
                                    name="arregloPersonalidad[estabilidadEmocional]">
                                    <option value="N.A.">N.A.</option>
                                    <option value="B">B</option>
                                    <option value="P">P</option>
                                    <option value="A">A</option>
                                    <option value="S">S</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="nivel" class="tamanoLetras">Confianza en si mismo:</label>
                                <select class="form-control form-control-sm tamanoSelects"
                                    id="confianza" name="arregloPersonalidad[confianza]">
                                    <option value="N.A.">N.A.</option>
                                    <option value="B">B</option>
                                    <option value="P">P</option>
                                    <option value="A">A</option>
                                    <option value="S">S</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="nivel" class="tamanoLetras">Trabajo bajo presión:</label>
                                <select class="form-control form-control-sm tamanoSelects"
                                    id="tabajoPresion" name="arregloPersonalidad[trabajoPresion]">
                                    <option value="N.A.">N.A.</option>
                                    <option value="B">B</option>
                                    <option value="P">P</option>
                                    <option value="A">A</option>
                                    <option value="S">S</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="nivel" class="tamanoLetras">Perseverancia:</label>
                                <select class="form-control form-control-sm tamanoSelects"
                                    id="perseverancia" name="arregloPersonalidad[perseverancia]">
                                    <option value="N.A.">N.A.</option>
                                    <option value="B">B</option>
                                    <option value="P">P</option>
                                    <option value="A">A</option>
                                    <option value="S">S</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="nivel" class="tamanoLetras">Responsabilidad:</label>
                                <select class="form-control form-control-sm tamanoSelects"
                                    id="responsabilidad"
                                    name="arregloPersonalidad[responsabilida]">
                                    <option value="N.A.">N.A.</option>
                                    <option value="B">B</option>
                                    <option value="P">P</option>
                                    <option value="A">A</option>
                                    <option value="S">S</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="nivel" class="tamanoLetras">Autocontrol:</label> <select
                                    class="form-control form-control-sm tamanoSelects"
                                    id="autocontrol" name="arregloPersonalidad[autocontrol]">
                                    <option value="N.A.">N.A.</option>
                                    <option value="B">B</option>
                                    <option value="P">P</option>
                                    <option value="A">A</option>
                                    <option value="S">S</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="nivel" class="tamanoLetras">Liderazgo:</label> <select
                                    class="form-control form-control-sm tamanoSelects"
                                    id="liderazgo" name="arregloPersonalidad[liderezgo]">
                                    <option value="N.A.">N.A.</option>
                                    <option value="B">B</option>
                                    <option value="P">P</option>
                                    <option value="A">A</option>
                                    <option value="S">S</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="nivel" class="tamanoLetras">Control de impulsos:</label>
                                <select class="form-control form-control-sm tamanoSelects"
                                    id="controlImpulsos"
                                    name="arregloPersonalidad[controlImpulsos]">
                                    <option value="N.A.">N.A.</option>
                                    <option value="B">B</option>
                                    <option value="P">P</option>
                                    <option value="A">A</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="nivel" class="tamanoLetras">Tolerancia a la
                                    Frustración</label> <select
                                    class="form-control form-control-sm tamanoSelects"
                                    id="toleranciaFrustracion"
                                    name="arregloPersonalidad[toleranciaFrustracion]">
                                    <option value="N.A.">N.A.</option>
                                    <option value="B">B</option>
                                    <option value="P">P</option>
                                    <option value="A">A</option>
                                    <option value="S">S</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="nivel" class="tamanoLetras">Entrevista:</label> <select
                                    class="form-control form-control-sm tamanoSelects"
                                    id="entrevista" name="arregloPersonalidad[entrevista]">
                                    <option>SI</option>
                                    <option>NO</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 d-flex justify-content-center">
                            <label for="nivel" class="tamanoLetras"
                                style="text-decoration: underline; text-decoration-color: #e5e5e5;">Capacidades</label>


                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="nivel" class="tamanoLetras">Información:</label> <select
                                    class="form-control form-control-sm tamanoSelects"
                                    id="informacion" name="arregloCapacidades[informacion]">
                                    <option value="N.A.">N.A.</option>
                                    <option value="EXCELENTE">EXCELENTE</option>
                                    <option value="SUPERIOR">SUPERIOR</option>
                                    <option value="STM">STM</option>
                                    <option value="TM">TM</option>
                                    <option value="ITM">ITM</option>
                                    <option value="INFERIOR">INFERIOR</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="nivel" class="tamanoLetras">Juicio:</label> <select
                                    class="form-control form-control-sm tamanoSelects" id="juicio"
                                    name="arregloCapacidades[juicio]">
                                    <option value="N.A.">N.A.</option>
                                    <option value="EXCELENTE">EXCELENTE</option>
                                    <option value="SUPERIOR">SUPERIOR</option>
                                    <option value="STM">STM</option>
                                    <option value="TM">TM</option>
                                    <option value="ITM">ITM</option>
                                    <option value="INFERIOR">INFERIOR</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="nivel" class="tamanoLetras">Vocabulario:</label> <select
                                    class="form-control form-control-sm tamanoSelects"
                                    id="vocabularios" name="arregloCapacidades[vocabularios]">
                                    <option value="N.A.">N.A.</option>
                                    <option value="EXCELENTE">EXCELENTE</option>
                                    <option value="SUPERIOR">SUPERIOR</option>
                                    <option value="STM">STM</option>
                                    <option value="TM">TM</option>
                                    <option value="ITM">ITM</option>
                                    <option value="INFERIOR">INFERIOR</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="nivel" class="tamanoLetras">Sintesis:</label> <select
                                    class="form-control form-control-sm tamanoSelects"
                                    id="sintesis" name="arregloCapacidades[sintesis]">
                                    <option value="N.A.">N.A.</option>
                                    <option value="EXCELENTE">EXCELENTE</option>
                                    <option value="SUPERIOR">SUPERIOR</option>
                                    <option value="STM">STM</option>
                                    <option value="TM">TM</option>
                                    <option value="ITM">ITM</option>
                                    <option value="INFERIOR">INFERIOR</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="nivel" class="tamanoLetras">Concentracion:</label>
                                <select class="form-control form-control-sm tamanoSelects"
                                    id="concentracion" name="arregloCapacidades[concentracion]">
                                    <option value="N.A.">N.A.</option>
                                    <option value="EXCELENTE">EXCELENTE</option>
                                    <option value="SUPERIOR">SUPERIOR</option>
                                    <option value="STM">STM</option>
                                    <option value="TM">TM</option>
                                    <option value="ITM">ITM</option>
                                    <option value="INFERIOR">INFERIOR</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="nivel" class="tamanoLetras">Análisis:</label> <select
                                    class="form-control form-control-sm tamanoSelects"
                                    id="analisis" name="arregloCapacidades[analisis]">
                                    <option value="N.A.">N.A.</option>
                                    <option value="EXCELENTE">EXCELENTE</option>
                                    <option value="SUPERIOR">SUPERIOR</option>
                                    <option value="STM">STM</option>
                                    <option value="TM">TM</option>
                                    <option value="ITM">ITM</option>
                                    <option value="INFERIOR">INFERIOR</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="nivel" class="tamanoLetras">Abstracción:</label> <select
                                    class="form-control form-control-sm tamanoSelects"
                                    id="abstraccion" name="arregloCapacidades[abstraccion]">
                                    <option value="N.A.">N.A.</option>
                                    <option value="EXCELENTE">EXCELENTE</option>
                                    <option value="SUPERIOR">SUPERIOR</option>
                                    <option value="STM">STM</option>
                                    <option value="TM">TM</option>
                                    <option value="ITM">ITM</option>
                                    <option value="INFERIOR">INFERIOR</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="nivel" class="tamanoLetras">Planeación:</label> <select
                                    class="form-control form-control-sm tamanoSelects"
                                    id="planeacion" name="arregloCapacidades[planeacion]">
                                    <option value="N.A.">N.A.</option>
                                    <option value="B">B</option>
                                    <option value="P">P</option>
                                    <option value="A">A</option>
                                    <option value="S">S</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="nivel" class="tamanoLetras">Organización:</label> <select
                                    class="form-control form-control-sm tamanoSelects"
                                    id="organizacion" name="arregloCapacidades[organizacion]">
                                    <option value="N.A.">N.A.</option>
                                    <option value="B">B</option>
                                    <option value="P">P</option>
                                    <option value="A">A</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="nivel" class="tamanoLetras">Atención:</label> <select
                                    class="form-control form-control-sm tamanoSelects"
                                    id="atencion" name="arregloCapacidades[atencion]">
                                    <option value="N.A.">N.A.</option>
                                    <option value="B">B</option>
                                    <option value="P">P</option>
                                    <option value="A">A</option>
                                    <option value="S">S</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 d-flex justify-content-center">
                            <label for="nivel" class="tamanoLetras"
                                style="text-decoration: underline; text-decoration-color: #e5e5e5;">Habilidades</label>


                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="nivel" class="tamanoLetras">Pensamiento
                                    estratégico:</label> <select
                                    class="form-control form-control-sm tamanoSelects"
                                    id="pensamientoEstrategico"
                                    name="arregloHabilidades[pensamientoEstrategicos]">
                                    <option value="N.A.">N.A.</option>
                                    <option value="B">B</option>
                                    <option value="P">P</option>
                                    <option value="A">A</option>
                                    <option value="S">S</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="nivel" class="tamanoLetras">Toma de decisiones:</label>
                                <select class="form-control form-control-sm tamanoSelects"
                                    id="tomaDecisiones" name="arregloHabilidades[tomaDecisiones]">
                                    <option value="N.A.">N.A.</option>
                                    <option value="B">B</option>
                                    <option value="P">P</option>
                                    <option value="A">A</option>
                                    <option value="S">S</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="nivel" class="tamanoLetras">Motivación al logro:</label>
                                <select class="form-control form-control-sm tamanoSelects"
                                    id="motivacionLogros"
                                    name="arregloHabilidades[motivacionLogros]">
                                    <option value="N.A.">N.A.</option>
                                    <option value="B">B</option>
                                    <option value="P">P</option>
                                    <option value="A">A</option>
                                    <option value="S">S</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="nivel" class="tamanoLetras">Manejo de conflictos:</label>
                                <select class="form-control form-control-sm tamanoSelects"
                                    id="manejoConflictos"
                                    name="arregloHabilidades[manejoConflictos]">
                                    <option value="N.A.">N.A.</option>
                                    <option value="B">B</option>
                                    <option value="P">P</option>
                                    <option value="A">A</option>
                                    <option value="S">S</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="nivel" class="tamanoLetras">Asertividad:</label> <select
                                    class="form-control form-control-sm tamanoSelects"
                                    id="asertividad" name="arregloHabilidades[asertividad]">
                                    <option value="N.A.">N.A.</option>
                                    <option value="B">B</option>
                                    <option value="P">P</option>
                                    <option value="A">A</option>
                                    <option value="S">S</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="nivel" class="tamanoLetras">Efectividad:</label> <select
                                    class="form-control form-control-sm tamanoSelects"
                                    id="efectividad" name="arregloHabilidades[efectividad]">
                                    <option value="N.A.">N.A.</option>
                                    <option value="B">B</option>
                                    <option value="P">P</option>
                                    <option value="A">A</option>
                                    <option value="S">S</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="nivel" class="tamanoLetras">Trabajo en equipo:</label>
                                <select class="form-control form-control-sm tamanoSelects"
                                    id="trabajoEquipo" name="arregloHabilidades[trabajoEquipo]">
                                    <option value="N.A.">N.A.</option>
                                    <option value="B">B</option>
                                    <option value="P">P</option>
                                    <option value="A">A</option>
                                    <option value="S">S</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="nivel" class="tamanoLetras">Comunicación:</label> <select
                                    class="form-control form-control-sm tamanoSelects"
                                    id="comunicacion" name="arregloHabilidades[comunicacion]">
                                    <option value="N.A.">N.A.</option>
                                    <option value="B">B</option>
                                    <option value="P">P</option>
                                    <option value="A">A</option>
                                    <option value="S">S</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="nivel" class="tamanoLetras">Sentido común y tacto:</label>
                                <select class="form-control form-control-sm tamanoSelects"
                                    id="sentidoComun" name="arregloHabilidades[sentidoComun]">
                                    <option value="N.A.">N.A.</option>
                                    <option value="B">B</option>
                                    <option value="P">P</option>
                                    <option value="A">A</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="nivel" class="tamanoLetras">Constancia en el
                                    trabajo:</label> <select
                                    class="form-control form-control-sm tamanoSelects"
                                    id="constanciaTrabajo"
                                    name="arregloHabilidades[constanciaTrabajo]">
                                    <option value="N.A.">N.A.</option>
                                    <option value="B">B</option>
                                    <option value="P">P</option>
                                    <option value="A">A</option>
                                    <option value="S">S</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="nivel" class="tamanoLetras">Seguimiento de
                                    instrucciones:</label> <select
                                    class="form-control form-control-sm tamanoSelects"
                                    id="seguimientoInstrucciones"
                                    name="arregloHabilidades[seguimientoInstrucciones]">
                                    <option value="N.A.">N.A.</option>
                                    <option value="B">B</option>
                                    <option value="P">P</option>
                                    <option value="A">A</option>
                                    <option value="S">S</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="nivel" class="tamanoLetras">Ejecución de
                                    procedimientos de trabajo: </label> <select
                                    class="form-control form-control-sm tamanoSelects"
                                    id="procedimientosTrabajo"
                                    name="arregloHabilidades[procedimientosTrabajo]">
                                    <option value="N.A.">N.A.</option>
                                    <option value="B">B</option>
                                    <option value="P">P</option>
                                    <option value="A">A</option>
                                    <option value="S">S</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="nivel" class="tamanoLetras">Supervición</label> <select
                                    class="form-control form-control-sm tamanoSelects"
                                    id="supervision" name="arregloHabilidades[supervision]">
                                    <option value="N.A.">N.A.</option>
                                    <option value="B">B</option>
                                    <option value="P">P</option>
                                    <option value="A">A</option>
                                    <option value="S">S</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="nivel" class="tamanoLetras">Competitividad</label>
                                <select class="form-control form-control-sm tamanoSelects"
                                    id="competitividad" name="arregloHabilidades[competitividad]">
                                    <option value="N.A.">N.A.</option>
                                    <option value="B">B</option>
                                    <option value="P">P</option>
                                    <option value="A">A</option>
                                    <option value="S">S</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 d-flex justify-content-center">
                            <label for="nivel" class="tamanoLetras"
                                style="text-decoration: underline; text-decoration-color: #e5e5e5;">Integridad</label>


                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="nivel" class="tamanoLetras">Confiabilidad:</label>
                                <select class="form-control form-control-sm tamanoSelects"
                                    id="confiabilidad" name="arregloIntegridad[confiabilidad]">
                                    <option value="N.A.">N.A.</option>
                                    <option value="B">B</option>
                                    <option value="P">P</option>
                                    <option value="A">A</option>
                                    <option value="S">S</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="nivel" class="tamanoLetras">Apego a Normas:</label>
                                <select class="form-control form-control-sm tamanoSelects"
                                    id="apegoNormas" name="arregloIntegridad[apegoNormas]">
                                    <option value="N.A.">N.A.</option>
                                    <option value="B">B</option>
                                    <option value="P">P</option>
                                    <option value="A">A</option>
                                    <option value="S">S</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="card-title">Escalas de Validez</h5>
                            <hr style="color: #0056b2;" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 d-flex justify-content-center">
                            <label for="nivel" class="tamanoLetras"
                                style="text-decoration: underline; text-decoration-color: #e5e5e5;">Basicas</label>


                        </div>
                    </div>
                    <div id="validez">
                        <div class="row">
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="nivel" class="tamanoLetras">L:</label> <select
                                        class="form-control form-control-sm" id="L"
                                        name="arregloValidez[L]">
                                        <option value="N.A.">N.A.</option>
                                        <option value="B">B</option>
                                        <option value="P">P</option>
                                        <option value="A">A</option>
                                        <option value="S">S</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="nivel" class="tamanoLetras">F:</label> <select
                                        class="form-control form-control-sm" id="F"
                                        name="arregloValidez[F]">
                                        <option value="N.A.">N.A.</option>
                                        <option value="B">B</option>
                                        <option value="P">P</option>
                                        <option value="A">A</option>
                                        <option value="S">S</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="nivel" class="tamanoLetras">K:</label> <select
                                        class="form-control form-control-sm" id="K"
                                        name="arregloValidez[K]">
                                        <option value="N.A.">N.A.</option>
                                        <option value="B">B</option>
                                        <option value="P">P</option>
                                        <option value="A">A</option>
                                        <option value="S">S</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="nivel" class="tamanoLetras">HS:</label> <select
                                        class="form-control form-control-sm" id="HS"
                                        name="arregloValidez[HS]">
                                        <option value="N.A.">N.A.</option>
                                        <option value="B">B</option>
                                        <option value="P">P</option>
                                        <option value="A">A</option>
                                        <option value="S">S</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="nivel" class="tamanoLetras">D:</label> <select
                                        class="form-control form-control-sm" id="D"
                                        name="arregloValidez[D]">
                                        <option value="N.A.">N.A.</option>
                                        <option value="B">B</option>
                                        <option value="P">P</option>
                                        <option value="A">A</option>
                                        <option value="S">S</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="nivel" class="tamanoLetras">Hi:</label> <select
                                        class="form-control form-control-sm" id="HI"
                                        name="arregloValidez[HI]">
                                        <option value="N.A.">N.A.</option>
                                        <option value="B">B</option>
                                        <option value="P">P</option>
                                        <option value="A">A</option>
                                        <option value="S">S</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="nivel" class="tamanoLetras">Dp:</label> <select
                                        class="form-control form-control-sm" id="DP"
                                        name="arregloValidez[DP]">
                                        <option value="N.A.">N.A.</option>
                                        <option value="B">B</option>
                                        <option value="P">P</option>
                                        <option value="A">A</option>
                                        <option value="S">S</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="nivel" class="tamanoLetras">Mf:</label> <select
                                        class="form-control form-control-sm" id="MF"
                                        name="arregloValidez[MF]">
                                        <option value="N.A.">N.A.</option>
                                        <option value="B">B</option>
                                        <option value="P">P</option>
                                        <option value="A">A</option>
                                        <option value="S">S</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="nivel" class="tamanoLetras">Po:</label> <select
                                        class="form-control form-control-sm" id="PO"
                                        name="arregloValidez[PO]">
                                        <option value="N.A.">N.A.</option>
                                        <option value="B">B</option>
                                        <option value="P">P</option>
                                        <option value="A">A</option>
                                        <option value="S">S</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="nivel" class="tamanoLetras">Pt:</label> <select
                                        class="form-control form-control-sm" id="PT"
                                        name="arregloValidez[PT]">
                                        <option value="N.A.">N.A.</option>
                                        <option value="B">B</option>
                                        <option value="P">P</option>
                                        <option value="A">A</option>
                                        <option value="S">S</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="nivel" class="tamanoLetras">Es:</label> <select
                                        class="form-control form-control-sm" id="ES"
                                        name="arregloValidez[ES]">
                                        <option value="N.A.">N.A.</option>
                                        <option value="B">B</option>
                                        <option value="P">P</option>
                                        <option value="A">A</option>
                                        <option value="S">S</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="nivel" class="tamanoLetras">Ma:</label> <select
                                        class="form-control form-control-sm" id="MA"
                                        name="arregloValidez[MA]">
                                        <option value="N.A.">N.A.</option>
                                        <option value="B">B</option>
                                        <option value="P">P</option>
                                        <option value="A">A</option>
                                        <option value="S">S</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="nivel" class="tamanoLetras">Ls:</label> <select
                                        class="form-control form-control-sm" id="LS"
                                        name="arregloValidez[LS]">
                                        <option value="N.A.">N.A.</option>
                                        <option value="B">B</option>
                                        <option value="P">P</option>
                                        <option value="A">A</option>
                                        <option value="S">S</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 d-flex justify-content-center">
                                <label for="nivel" class="tamanoLetras"
                                    style="text-decoration: underline; text-decoration-color: #e5e5e5;">Contenido</label>


                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="nivel" class="tamanoLetras">ANs:</label> <select
                                        class="form-control form-control-sm" id="ANS"
                                        name="arregloValidez[ANS]">
                                        <option value="N.A.">N.A.</option>
                                        <option value="B">B</option>
                                        <option value="P">P</option>
                                        <option value="A">A</option>
                                        <option value="S">S</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="nivel" class="tamanoLetras">MIE:</label> <select
                                        class="form-control form-control-sm" id="MIE"
                                        name="arregloValidez[MIE]">
                                        <option value="N.A.">N.A.</option>
                                        <option value="B">B</option>
                                        <option value="P">P</option>
                                        <option value="A">A</option>
                                        <option value="S">S</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="nivel" class="tamanoLetras">OBS:</label> <select
                                        class="form-control form-control-sm" id="OBS"
                                        name="arregloValidez[OBS]">
                                        <option value="N.A.">N.A.</option>
                                        <option value="B">B</option>
                                        <option value="P">P</option>
                                        <option value="A">A</option>
                                        <option value="S">S</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="nivel" class="tamanoLetras">DEP:</label> <select
                                        class="form-control form-control-sm" id="DEP"
                                        name="arregloValidez[DEP]">
                                        <option value="N.A.">N.A.</option>
                                        <option value="B">B</option>
                                        <option value="P">P</option>
                                        <option value="A">A</option>
                                        <option value="S">S</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="nivel" class="tamanoLetras">SAU:</label> <select
                                        class="form-control form-control-sm" id="SAU"
                                        name="arregloValidez[SAU]">
                                        <option value="N.A.">N.A.</option>
                                        <option value="B">B</option>
                                        <option value="P">P</option>
                                        <option value="A">A</option>
                                        <option value="S">S</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="nivel" class="tamanoLetras">DEL:</label> <select
                                        class="form-control form-control-sm" id="DEL"
                                        name="arregloValidez[DEL]">
                                        <option value="N.A.">N.A.</option>
                                        <option value="B">B</option>
                                        <option value="P">P</option>
                                        <option value="A">A</option>
                                        <option value="S">S</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="nivel" class="tamanoLetras">Dp:</label> <select
                                        class="form-control form-control-sm" id="DP"
                                        name="arregloValidez[DP]">
                                        <option value="N.A.">N.A.</option>
                                        <option value="B">B</option>
                                        <option value="P">P</option>
                                        <option value="A">A</option>
                                        <option value="S">S</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="nivel" class="tamanoLetras">ENJ:</label> <select
                                        class="form-control form-control-sm" id="ENJ"
                                        name="arregloValidez[ENJ]">
                                        <option value="N.A.">N.A.</option>
                                        <option value="B">B</option>
                                        <option value="P">P</option>
                                        <option value="A">A</option>
                                        <option value="S">S</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="nivel" class="tamanoLetras">CIN:</label> <select
                                        class="form-control form-control-sm" id="CIN"
                                        name="arregloValidez[CIN]">
                                        <option value="N.A.">N.A.</option>
                                        <option value="B">B</option>
                                        <option value="P">P</option>
                                        <option value="A">A</option>
                                        <option value="S">S</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="nivel" class="tamanoLetras">PAS:</label> <select
                                        class="form-control form-control-sm" id="PAS"
                                        name="arregloValidez[PAS]">
                                        <option value="N.A.">N.A.</option>
                                        <option value="B">B</option>
                                        <option value="P">P</option>
                                        <option value="A">A</option>
                                        <option value="S">S</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="nivel" class="tamanoLetras">PTA:</label> <select
                                        class="form-control form-control-sm" id="PTA"
                                        name="arregloValidez[PTA]">
                                        <option value="N.A.">N.A.</option>
                                        <option value="B">B</option>
                                        <option value="P">P</option>
                                        <option value="A">A</option>
                                        <option value="S">S</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="nivel" class="tamanoLetras">BAE:</label> <select
                                        class="form-control form-control-sm" id="BAE"
                                        name="arregloValidez[BAE]">
                                        <option value="N.A.">N.A.</option>
                                        <option value="B">B</option>
                                        <option value="P">P</option>
                                        <option value="A">A</option>
                                        <option value="S">S</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="nivel" class="tamanoLetras">ISO:</label> <select
                                        class="form-control form-control-sm" id="ISO"
                                        name="arregloValidez[ISO]">
                                        <option value="N.A.">N.A.</option>
                                        <option value="B">B</option>
                                        <option value="P">P</option>
                                        <option value="A">A</option>
                                        <option value="S">S</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="nivel" class="tamanoLetras">FAM:</label> <select
                                        class="form-control form-control-sm" id="FAM"
                                        name="arregloValidez[FAM]">
                                        <option value="N.A.">N.A.</option>
                                        <option value="B">B</option>
                                        <option value="P">P</option>
                                        <option value="A">A</option>
                                        <option value="S">S</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="nivel" class="tamanoLetras">DTR:</label> <select
                                        class="form-control form-control-sm" id="DTR"
                                        name="arregloValidez[DTR]">
                                        <option value="N.A.">N.A.</option>
                                        <option value="B">B</option>
                                        <option value="P">P</option>
                                        <option value="A">A</option>
                                        <option value="S">S</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="nivel" class="tamanoLetras">RTR:</label> <select
                                        class="form-control form-control-sm" id="RTRl"
                                        name="arregloValidez[RTR]">
                                        <option value="N.A.">N.A.</option>
                                        <option value="B">B</option>
                                        <option value="P">P</option>
                                        <option value="A">A</option>
                                        <option value="S">S</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 d-flex justify-content-center">
                                <label for="nivel" class="tamanoLetras"
                                    style="text-decoration: underline; text-decoration-color: #e5e5e5;">Suplementarios</label>


                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="nivel" class="tamanoLetras">A:</label> <select
                                        class="form-control form-control-sm" name="arregloValidez[A]"
                                        id="A">
                                        <option value="N.A.">N.A.</option>
                                        <option value="B">B</option>
                                        <option value="P">P</option>
                                        <option value="A">A</option>
                                        <option value="S">S</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="nivel" class="tamanoLetras">R:</label> <select
                                        class="form-control form-control-sm" name="arregloValidez[R]"
                                        id="R">
                                        <option value="N.A.">N.A.</option>
                                        <option value="B">B</option>
                                        <option value="P">P</option>
                                        <option value="A">A</option>
                                        <option value="S">S</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="nivel" class="tamanoLetras">FYO:</label> <select
                                        class="form-control form-control-sm"
                                        name="arregloValidez[FYO]" id="FYO">
                                        <option value="N.A.">N.A.</option>
                                        <option value="B">B</option>
                                        <option value="P">P</option>
                                        <option value="A">A</option>
                                        <option value="S">S</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="nivel" class="tamanoLetras">A-MAC</label> <select
                                        class="form-control form-control-sm"
                                        name="arregloValidez[AMAC]" id="AMAC">
                                        <option value="N.A.">N.A.</option>
                                        <option value="B">B</option>
                                        <option value="P">P</option>
                                        <option value="A">A</option>
                                        <option value="S">S</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="nivel" class="tamanoLetras">HR:</label> <select
                                        class="form-control form-control-sm"
                                        name="arregloValidez[HR]" id="HR">
                                        <option value="N.A.">N.A.</option>
                                        <option value="B">B</option>
                                        <option value="P">P</option>
                                        <option value="A">A</option>
                                        <option value="S">S</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="nivel" class="tamanoLetras">DO:</label> <select
                                        class="form-control form-control-sm"
                                        name="arregloValidez[DO]" id="DO">
                                        <option value="N.A.">N.A.</option>
                                        <option value="B">B</option>
                                        <option value="P">P</option>
                                        <option value="A">A</option>
                                        <option value="S">S</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="nivel" class="tamanoLetras">DPR:</label> <select
                                        class="form-control form-control-sm" id="arregloValidez[DPR]"
                                        name="arregloValidez[DPR]">
                                        <option value="N.A.">N.A.</option>
                                        <option value="B">B</option>
                                        <option value="P">P</option>
                                        <option value="A">A</option>
                                        <option value="S">S</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="nivel" class="tamanoLetras">RS:</label> <select
                                        class="form-control form-control-sm" id="arregloValidez[RS]"
                                        name="arregloValidez[RS]">
                                        <option value="N.A.">N.A.</option>
                                        <option value="B">B</option>
                                        <option value="P">P</option>
                                        <option value="A">A</option>
                                        <option value="S">S</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input name="candidato_id_1" hidden id="candidato_id_1" />
                    {{csrf_field()}}
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <button type="button" class="btn btn-primary btn-sm"
                                    id="datosCandidatosEval">Guardar Datos de la Evaluación</button>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div id="mensajesEscalaz"></div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <button type="button" class="btn btn-primary btn-sm"
                                    id="graficar">Graficar</button>
                                <div id="graficarCargar" style="display: inline-block"></div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="row">
                    <div class="chart-container"
                        style="position: relative; height: 500px !important; width: 100% !important">
                        <canvas id="myChart"></canvas>
                    </div>
                </div>


			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary"
					onclick="cerrarModal();">Cerrar</button>
			</div>
		</div>

	</div>
</div>
