@extends('layouts.main')

@section('title', 'Inicio de proceso - T01 Solicitud de cita')

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
                'titulo' => 'Inicio de proceso - T01 Solicitud de cita'
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


<div class="card card-custom mb-5">
    <div class="card-header">
        <div class="card-title">
            <h3 class="card-label">Selección de candidatos de personal de estructura</h3>
        </div>
    </div>
    <div class="card-body">
        <div class="alert alert-custom alert-outline-warning" role="alert">
            <div class="alert-text">
                INSTRUCCIONES:
                <ul>
                    <li>Seleccione la plaza.</li>
                    <li>Para cada candidato, indique el rfc y no. de empleado del
                        candidato a la plaza de estructrura. Si el candidato ya se
                        encuentra en el sistema aparecerán sus datos. De lo contrario,
                        llénelos.</li>
                </ul>
                NOTAS:
                <ul>
                    <li>Puede proponer de 1 hasta 2 por plaza.</li>
                    <li>No puede proponer al mismo candidato dos veces en el mismo
                        proceso.</li>
                    <li>Si no puede ver el número de plaza deseado quiere decir que
                        esa plaza ya está ocupada en otro proceso de selección de
                        candidatos. Seleccione otra plaza o termine este proceso.</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<form method="POST" action="{{route('seleccion.candidatos.guardar.candidatos', $candidatoEstructura->seleccion_candidato_id )}}"
	id="formCandidatos">
    @csrf
    @method('POST')

    <div class="card card-custom mb-5">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">Datos de la plaza y de los candidatos</h3>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="titulo-dato">  Folio </label>
                            <span class="valor-dato">  {{ $candidatoEstructura->instancia->folio }} </span>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="titulo-dato"> Unidad Administrativa </label>
                            <span class="valor-dato">  {{$usuarios->area->identificador}}
                                {{$usuarios->area->nombre}} </span>
                        </div>
                    </div>
                    <hr>

                    <p><b>Para continuar con el proceso, deberá de alinearse a la normativa establecida en el oficio SF/DGA/073/2010, de fecha 5 de	febrero del año 2010.</b></p>

                    <div class="row">

                        <div class="col-md-4 form-group">
                            <label for="numPlaza">Seleccione la plaza a ocupar</label>
                            <select class="form-control form-control-sm select2" id="numPlaza" name="numPlaza">
                                <option value="">Seleccione una opción</option>
                                @foreach ($plazas as $plaza)
                                <option value="{{$plaza->plaza_id}}">{{$plaza->numero_plaza}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 form-group">
                            <label for="rfc">RFC</label>
                            <input type="text" class="form-control form-control-sm @error('rfc') error @enderror" name="rfc"
                                id="rfc"  placeholder="Ingresar RFC del candidato"  maxlength="13"
                                onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" />
                        </div>

                        <div class="col-md-4 form-group">
                            <label for="numero_empleado">No. Empleado</label>
                            <input class="form-control form-control-sm @error('numero_empleado') error @enderror" type="text"
                                name="numero_empleado" id="numero_empleado" placeholder="Ingresar no. empleado"
                                onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" />
                        </div>

                        <div class="col-md-12 form-group d-flex justify-content-end">
                            <button type="button" class="btn btn-primary float-right"
                                id="candidatoRfc">Buscar</button>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-4 form-group">
                            <label for="tipo_movimiento">Tipo de movimiento</label>
                            <select class="form-control form-control-sm" id="tipo_movimiento" name="tipo_movimiento">
                                <option value="">Seleccione una opción</option>
                                <option value="PROMOCION">PROMOCIÓN</option>
                                <option value="NUEVO INGRESO">NUEVO INGRESO</option>
                                <option value="REINGRESO">REINGRESO</option>
                            </select>
                        </div>

                        <div class="col-md-4 form-group">
                            <label for="nombre_candidato">Nombre</label>
                            <input type="text" class="form-control form-control-sm @error('nombre_candidato') error @enderror"
                                name="nombre_candidato" id="nombre_candidato"  placeholder="Ingresar nombre del candidato"
                                onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" />
                        </div>

                        <div class="col-md-4 form-group">
                            <label for="apellido_paterno_cadidato">Primer apellido</label>
                            <input class="form-control form-control-sm @error('apellido_paterno_cadidato') error @enderror" type="text"
                                name="apellido_paterno_cadidato" id="apellido_paterno_cadidato" placeholder="Ingresar primer apellido"
                                onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" />
                        </div>

                        <div class="col-md-4 form-group">
                            <label for="apellido_materno_cadidato">Segundo apellido</label>
                            <input class="form-control form-control-sm @error('apellido_materno_cadidato') error @enderror" type="text"
                                name="apellido_materno_cadidato" id="apellido_materno_cadidato" placeholder="Ingresar segundo apellido"
                                onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" />
                        </div>

                        <div class="col-md-8 form-group">
                            <label for="observaciones_titular">Observaciones</label>
                            <textarea class="form-control form-control-sm @error('observaciones_titular') error @enderror"
                            name="observaciones_titular" id="observaciones_titular" rows="3"></textarea>
                        </div>

                        <div class="col-md-12 form-group d-flex justify-content-end">
                            <button type="button" class="btn btn-primary float-right"
                                id="btn_agregar_candidato">Agregar</button>
                        </div>

                    </div>

                    <div class="row">
						<div class="col-md-12 form-group">

                            <table class="table table-bordered table-general"
                                id="tablaCandidatos"
                                data-toggle="table"
                                data-toolbar="#toolbar"
                                data-unique-id="id"
                                data-show-columns="false">
                                <thead>
                                    <tr>
                                        <th data-field="tipoMovimiento" class="text-center" data-formatter="tipoMovimientoFormatter">Tipo de Movimiento</th>
                                        <th data-field="nombre" class="text-center" >Nombre candidato</th>
                                        <th data-field="apePaterno" class="text-center" >Primer apellido</th>
                                        <th data-field="apeMaterno" class="text-center" >Segundo apellido</th>
                                        <th data-field="rfc" class="text-center" >RFC</th>
                                        <th data-field="noEmpleado" class="text-center" >No. Empleado</th>
                                        <th data-field="observaciones" class="text-center" >Observaciones</th>
                                        <th data-field="acciones" class="text-center" data-formatter="accionesFormatterSolicitarCita"><label class="titulo-dato">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Acciones &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label></th>
                                    </tr>
                                </thead>
                            </table>

						</div>
					</div>

                    <div class="row">
						<div class="col-md-6 form-group">

								<label for="titularSolicitante">Seleccione al titular que solicita la
									contratación:</label>
                                <select
									class="form-control form-control-sm select2" id="titularSolicitante"
									name="titularSolicitante">
									<option value="">Seleccione una opción</option>
									<option value="1051829">ABIGAIL HERNANDEZ GONZALEZ - ENLACE DE
										CLASIFICACION B</option>
									<option value="1048922">ABRAHAM RODRIGUEZ HARO - JUD DE
										ATENCION A REQUERIMIENTOS</option>
									<option value="940274">ALEJANDRO SOTO PEREZ - JUD DE
										CLASIFICACION ESTRATEGICA</option>
									<option value="985370">ALLESHA JULIETA HERNANDEZ SOLANO -
										ENLACE DE APOYO DE PRESENCIA FISCAL H E</option>
									<option value="1051757">ALMA VERONICA MALDONADO MENA - ENLACE
										DE GENERACION DE CASOS DE METODOS SUSTANTIVOS EN COMERCIO</option>
									<option value="918624">ANABEL VELASCO SANTIAGO - SUBDIRECCION
										DE INVESTIGACION EN COMERCIO EXTERIOR</option>
									<option value="931793">ANADELI MELQUIADES SOTELO - LIDER
										COORDINADOR DE PROYECTOS A</option>
									<option value="1032269">ANAYANSI ABIGAIL DORANTES PIMENTEL -
										ENLACE A</option>
									<option value="1000556">ARMANDO CURIEL TREJO - JUD DE OPERACION
										DE RECURSOS DE PROCEDENCIA ILÍCITA Y EXTINCION DE DOMINIO</option>
									<option value="918586">ARTURO PEREZ DAVILA - SUBDIRECCIÓN DEL
										RECINTO FISCAL</option>
									<option value="909520">ARTURO BAEZA SANCHEZ - SUBDIRECCION DE
										PROCEDIMIENTOS LEGALES</option>
									<option value="931861">AURORA NAYELI CUEVAS REYES - JUD DE
										DESARROLLO DE LA INFORMACION DE INTELIGENCIA FINANCIERA</option>
									<option value="970838">BEATRIZ MENDOZA ZURITA - ENLACE DE APOYO
										DE METODOS SUSTANTIVOS D B</option>
									<option value="998859">BRANDO HUMBERTO SOTELO DIAZ - ENLACE DE
										APOYO DE PRESENCIA FISCAL G E</option>
									<option value="925776">BRUNO GUZMAN MARTINEZ - COORDINACION
										TECNICA</option>
									<option value="918639">CARLOS ALEJANDRO FRANCO MARTINEZ -
										ENLACE DE APOYO DE METODOS SUSTANTIVOS C A</option>
									<option value="934075">CAROLINA CANALES CASTREJON - LIDER
										COORDINADOR DE PROYECTOS DE EJECUCION DE METODOS SUSTANTIVOS F
										B</option>
									<option value="918703">CLAUDIA SACHIÑAS CONTRERAS - LIDER
										COORDINADOR DE PROYECTOS DE EJECUCION DE METODOS SUSTANTIVOS G
										B</option>
									<option value="1029474">CLAUDIA JIMENEZ CAMPECHANO - ENLACE A</option>
									<option value="834837">CUITLAHUAC ANIBAL SOTO VAZQUEZ -
										DIRECCION DE PROCEDIMIENTOS LEGALES</option>
									<option value="918642">DANIEL LOPEZ ROJO - LIDER COORDINADOR DE
										PROYECTOS DE EJECUCION DE PRESENCIA FISCAL A C</option>
									<option value="918603">DANIEL ALFREDO CORONEL PEÑA - LIDER
										COORDINADOR DE PROYECTOS DE EJECUCION DE PRESENCIA FISCAL D D</option>
									<option value="992524">DIANA LORENA URIBE GARCIA - LIDER
										COORDINADOR DE PROYECTOS A</option>
									<option value="918638">DIEGO ARMANDO RAMIREZ MONTERO - JUD DE
										RECUPERACION DE CREDITOS</option>
									<option value="1056015">EDGAR DAVID POZOS GARCIA - ENLACE A</option>
									<option value="918640">EDUARDO DANIEL GONZALEZ SOTO - JUD DE
										CLASIFICACION ARANCELARIA</option>
									<option value="918596">ELIZABETH ALEJANDRA MEDINA FLORES -
										SUBDIRECCION DE SEGUIMIENTO DE PROGRAMAS Y REMISION DE
										INFORMES</option>
									<option value="1031285">ELVA GUADALUPE CHAVEZ NAVARRETE -
										ENLACE DE APOYO PRESENCIA FISCAL A C</option>
									<option value="988066">ENRIQUE JULIAN LEMUS MORENO -
										SUBDIRECCCION DE ENLACE GUBERNAMENTAL</option>
									<option value="879693">EVA DOMINGUEZ CRUZ - JUD DE COMERCIO
										EXTERIOR B</option>
									<option value="1004380">EVELINE AMEZCUA GAMA - ENLACE DE APOYO
										PRESENCIA FISCAL D D</option>
									<option value="1056014">FERNANDO ACOSTA PEREZ - ENLACE A</option>
									<option value="936109">FIDELMAR DANIEL REYES MAGAÑA - LIDER
										COORDINADOR DE PROYECTOS DE EJECUCION DE METODOS SUSTANTIVOS E
										A</option>
									<option value="918602">FRANCISCO VALDES MEJIA - JUD DE
										PROGRAMACION Y ANALISIS DE METODOS SUSTANTIVOS EN COMERCIO</option>
									<option value="1015291">FRIDA AURORA CALVO BAEZA - ENLACE DE
										GENERACION DE CASOS DE PRESENCIA FISCAL EN COMERCIO EXTERIOR C</option>
									<option value="1048921">GERMAN HECTOR ALVAREZ GOMEZ - ENLACE DE
										APOYO EN EL CONTROL DEL ALMACEN D</option>
									<option value="1051755">GRETA DOLORES CARLY ARELLANO -</option>
									<option value="304810">GUILLERMO FRANCISCO GARZA ALVAREZ - JUD
										DE PROCEDIMIENTOS ADMINISTRATIVOS EN MATERIA ADUANERA C</option>
									<option value="1003369">GUSTAVO AZPILCUETA DE LA CRUZ - ENLACE
										DE GENERACION DE CASOS DE PRESENCIA FISCAL EN COMERCIO
										EXTERIOR</option>
									<option value="950092">HELIANE VICTORIA PEREZ CARRILLO -
										SUBDIRECCION DE ANALISIS ESTRATEGICO Y DESARROLLO DE PROYECTOS</option>
									<option value="918592">HILARIO AGUILAR SIERRA - LIDER
										COORDINADOR DE PROYECTOS DE EJECUCION DE PRESENCIA FISCAL C D</option>
									<option value="224932">HUMBERTO MAURO NAH PEREZ - LIDER
										COORDINADOR DE PROYECTOS DE ELABORACION DE INFORMES DE
										COMERCIO</option>
									<option value="736124">IGNACIO RUIZ VILLARAN - DIRECCION DE
										INFORMACION INTERINSTITUCIONAL</option>
									<option value="900917">INGRID GUIOVANINA HUERTA GONZALEZ -
										LIDER COORDINADOR DE PROYECTOS DE EJECUCION DE METODOS
										SUSTANTIVOS A A</option>
									<option value="834488">IRAD PLATAS CHAVEZ - DIRECCION DE
										ANALISIS PATRIMONIAL Y ECONOMICO</option>
									<option value="895475">IRIS IVONNE MERINO FRUTIS - JUD DE
										REVISION DE INFORMES DE COMERCIO EXTERIOR</option>
									<option value="1004322">ISAAC SANCHEZ TOLENTINO - ENLACE DE
										APOYO EN EL CONTROL DEL ALMACEN B</option>
									<option value="990760">ISAAC JACOB GARCIA ADAME - LIDER
										COORDINADOR DE PROYECTOS A</option>
									<option value="914514">IVAN ALCAZAR CORTES - ENLACE A</option>
									<option value="918614">IVAN MORENO JIMENEZ - JUD DE COMERCIO
										EXTERIOR C</option>
									<option value="1000127">JESUS RUIZ NAJERA - JUD DEANALISIS DE
										LA INFORMACION</option>
									<option value="919009">JESUS DURAN PACHECO - ENLACE DE APOYO
										PRESENCIA FISCAL B C</option>
									<option value="837417">JORGE ABRAHAM PLATAS CHAVEZ - DIRECCION
										DE NORMATIVIDAD, ASUNTOS LEGALES Y ENLACE GUBERNAMENTAL</option>
									<option value="879991">JORGE ANDRES CURIEL TREJO - DIRECCION DE
										COMERCIO EXTERIOR</option>
									<option value="1051701">JOSAFAT REYES JAIME -</option>
									<option value="815767">JOSE ALVAREZ PELAEZ - ENLACE DE APOYO EN
										EL CONTROL DEL ALMACEN A</option>
									<option value="970036">JOSE ALVARO ROCHA AMENEYRO - ENLACE A</option>
									<option value="918612">JOSE JAIME FLORES ALVAREZ - ENLACE DE
										APOYO DE PRESENCIA FISCAL E D</option>
									<option value="939963">JUAN CARLOS REYES CASTAÑEDA - ENLACE DE
										APOYO DE METODOS SUSTANTIVOS A A</option>
									<option value="229467">JULIETA GONZALEZ MENDEZ - SECRETARIA DE
										FINANZAS</option>
									<option value="1048924">KITZYA XAMAHI APARICIO ZARZA - ENLACE A</option>
									<option value="1031282">LEYDA DENISSE TORRES CEDILLO - ENLACE A</option>
									<option value="301973">LILIA GARCIA GALINDO - COORDINACION
										EJECUTIVA DE VERIFICACION DE COMERCIO EXTERIOR</option>
									<option value="918589">LILIANA RAMIREZ PICKETT - LIDER
										COORDINADOR DE PROYECTOS DE VIABILIDAD DE CASOS DE METODOS
										SUSTANTIVOS EN COMERCIO EXTERIOR</option>
									<option value="918634">LUIS SANDOVAL NOGUEZ - ENLACE DE APOYO
										PRESENCIA FISCAL C C</option>
									<option value="1051704">LUZ ELENA DE LA COLINA MEJIA -</option>
									<option value="1051702">LUZ ENEIDA VELASCO HERNANDEZ -</option>
									<option value="918627">MARCO ANTONIO HERVER DOMINGUEZ - LIDER
										COORDINADOR DE PROYECTOS DE EJECUCION DE CMETODOS SUSTANTIVOS
										B A</option>
									<option value="1015293">MARCO IVAN VAZQUEZ CANO -</option>
									<option value="984632">MARIA DEL CARMEN LIZETH LOPEZ DURAN -
										LIDER COORDINADOR DE PROYECTOS DE CONTROL E INFORMACION</option>
									<option value="918628">MARIA ELIZABETH GARCIA SANCHEZ - LIDER
										COORDINADOR DE PROYECTOS DE CLASIFICACION B</option>
									<option value="889727">MARIA GUADALUPE ESPINOSA GONZALEZ -
										ENLACE DE CLASIFICACION A</option>
									<option value="911682">MARIA TERESA VELAZQUEZ RODRIGUEZ - JUD
										DE CONTROL DE GESTION</option>
									<option value="934702">MIRIAM DURON PEREZ - LIDER COORDINADOR
										DE PROYECTOS DE CLASIFICACION A</option>
									<option value="986978">MONICA GABRIELA ROSAS LARA - LIDER
										COORDINADOR DE PROYECTOS DE EJECUCIÓN DE METODOS SUSTANTIVOS C
										A</option>
									<option value="1051698">MONSERRATH BERENICE PANTOJA GONZALEZ -
									</option>
									<option value="914065">MONTSERRAT ZAVALA HERNANDEZ - LIDER
										COORDINADOR DE PROYECTOS A</option>
									<option value="918636">NOE ROBERTO HUERTA SERRANO - LIDER
										COORDINADOR DE PROYECTOS DE EJECUCIÓN DE METODOS SUSTANTIVOS
										DA</option>
									<option value="1026468">OMAR IVAN MANCILLA PEREZ - ENLACE DE
										SOPORTE TECNICO Y COMPILACION DE LA INFORMACION A</option>
									<option value="1034557">OSCAR RAYMUNDO TOVAR GARCIA - ENLACE DE
										APOYO Y METODOS SUSTANTIVOS B A</option>
									<option value="918641">PATRICIA RUIZ CRUZ - ENLACE DE
										GENERACION DE CASOS DE METODOS SUSTANTIVOS EN COMERCIO</option>
									<option value="934525">PEDRO EMMANUEL JIMENEZ TERAN - JUD DE
										GESTION DE LA INFORMACION</option>
									<option value="918611">RAMON CISNEROS BEDOYA - ENLACE DE APOYO
										DE METODOS SUSTANTIVOS F B</option>
									<option value="862954">RICARDO RIOS GARZA - UNIDAD DE
										INTELIGENCIA FINANCIERA DE LA CIUDAD DE MEXICO</option>
									<option value="918598">RICARDO RODRIGUEZ POZOS - JUD DE
										COMERCIO EXTERIOR D</option>
									<option value="988079">ROMEO RIOS MARROQUIN - LIDER COORDINADOR
										DE PROYECTOS DE INVESTIGACION B</option>
									<option value="1015290">RUTH MAGALY GUEVARA LEDESMA - ENLACE A</option>
									<option value="1015288">SANDRA TERESA MENDOZA GAYOSSO - ENLACE
										A</option>
									<option value="962065">SERGIO ORLANDO ALVARADO VALENCIA -
										SUBDIRECCION DE NORMATIVIDAD</option>
									<option value="1021338">SHARON CHANTAL ALVAREZ HERNANDEZ -
										ENLACE DE APOYO DE METODOS SUSTANTIVOS E B</option>
									<option value="1051754">VERONICA VELASCO SANTIAGO - ENLACE A</option>
									<option value="908989">VICTOR GAYOSSO SALINAS - DIRECCION DE
										INVESTIGACION Y PROGRAMACION EN COMERCIO EXTERIOR</option>
									<option value="939212">VICTOR ALFONSO FRAUSTO SIERRA -</option>
									<option value="918645">VICTOR MANUEL FRAGA OSNAYA - JUD DE
										INVESTIGACION Y ANALISIS DE CASOS DE PRESENCIA FISCAL EN
										COMERCIO</option>
									<option value="915803">YAZMIN PINEDA ORTIZ - SUBDIRECCION DE
										INFORMACION PATRIMONIAL Y ECONOMICA</option>
									<option value="">- JUD EN CUMPLIMIENTOS DE SENTENCIAS EN
										COMERCIO EXTERIOR</option>
								</select>

						</div>
					</div>

                    <div class="row">
						<div class="col-md-12 form-group">
                            @if ( $existenCandidatos )
                                <div class="alert alert-custom alert-outline-warning fade show mb-5" role="alert">
                                    <div class="alert-icon"><i class="flaticon-warning"></i></div>
                                    <div class="alert-text">¡Este folio ya fue trabajado, No puede realizar ningún cambio!</div>
                                </div>
                            @else
                                <p for="idSociedad" class="text-muted">
                                    Si está seguro de sus datos presione el botón "Solicitar citas".
                                </p>
                                <button type="button" id="btn_finalizar_proceso" class="btn btn-danger" >Terminar sin solicitar cita</button>
                                <button type="button" id="btn_finalizar_solicitar_cita" class="btn btn-success">Solicitar citas</button>
                            @endif
						</div>
					</div>

                </div>
            </div>
        </div>
    </div>

	<input id="arregloTablaCandidatos" name="arregloTablaCandidatos" hidden />

</form>

@endsection

@push('styles')
    <link href="{{ asset('metronic/plugins/custom/bootstraptable/css/bootstrap-table.min.css') }}" type="text/css" rel="stylesheet"/>
@endpush

@push('scripts')
    <script>
        var urlEmpleadosCandidatos = @json ( route('seleccion.candidatos.consultar.empleados.candidatos') );
        var urlFinalizarProceso = @json( route('seleccion.candidatos.finalizar.proceso', $candidatoEstructura->seleccion_candidato_id) );
        var urlTareas = @json( route('tareas') );
        var seleccionCandidatos = @json($seleccionCandidatos);
    </script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
    {{-- <script	src="{{ asset('js/p11_seleccion_candidatos/T01_solicitudCitaExamenPsicometrico.js') }}"></script> --}}
    <script	src="{{ asset('js/p11_seleccion_candidatos/T01_solicitudCitaPsicometrico.js') }}"></script>
@endpush
