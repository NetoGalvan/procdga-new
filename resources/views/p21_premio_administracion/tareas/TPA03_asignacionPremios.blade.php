@extends('layouts.main')

@section('title', 'ASIGNACIÓN DE PREMIOS')

@section('aside_menu')
    @include('layouts.partials.main.aside_menu', ["asideMenu" =>
        [
            "item_seleccionado" => "tareas",
        ]
    ])
@endsection

@section('subheader')
    @include('layouts.partials.main.subheader', ["subheader" => [
        "titulo_subheader" => "PROCDGA",
        "icono_titulo_subheader" => "far fa-folder-open",
        "breadcrumbs" => [
            1 => [
                'activo' => false,
                'titulo' => 'Tareas',
                'ruta' => Route('tareas')
            ],
            2 => [
                'activo' => true,
                'titulo' => 'ASIGNACIÓN DE PREMIOS'
            ]
        ]
    ]])
@endsection

@section('contenido')

    <div class="card card-custom mb-5">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">Información</h3>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <label class="titulo-dato"> Área </label>
                    <span class="valor-dato">  {{ $premioAdministracion->area->identificador }} - {{ $premioAdministracion->area->nombre }} </span>
                </div>
                <div class="col-md-4">
                    <label class="titulo-dato"> Folio </label>
                    <span class="valor-dato">  {{ $premioAdministracion->folio }} </span>
                </div>
                <div class="col-md-4">
                    <label class="titulo-dato"> Convocatoria correspondiente a: </label>
                    <span class="valor-dato">  {{ $premioAdministracion->anio_convocatoria }} </span>
                </div>
                <div class="col-md-4">
                    <label class="titulo-dato"> Periodo de evaluación </label>
                    <span class="valor-dato">  {{ $premioAdministracion->fecha_inicio_evaluacion_pa }} <b> - </b> {{ $premioAdministracion->fecha_fin_evaluacion_pa }} </span>
                </div>
                <div class="col-md-4">
                    <label class="titulo-dato"> Comentarios del convocante </label>
                    <span class="valor-dato">  {{ $premioAdministracion->comentarios_admin_pa_21 }} </span>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-md-12">
                    <div class="alert alert-custom alert-success" role="alert">
                        <div class="alert-icon"><i class="flaticon-warning"></i></div>
                        <div class="alert-text">
                            <ul>
                                <li>1. Descargue y si lo considera necesario imprima los formatos correspondientes a la evaluación de desempeño, puntualidad y asistencia y cursos de capacitación de los empleados seleccionando las ligas que se muestran en el listado de empleados.</li>
                                <li>2. Con base a la información contenida en los reportes proceda a capturar el porcentaje de evaluación.</li>
                                <li>3. Selecciona el tipo de premio correspondiente a la evaluación del empleado.</li>
                                <li>4. Si desea agregar algún empleado que no este contemplado en el listado, capture el número de empleado y los comentarios correspondientes.</li>
                                <li>5. Imprima y publique el listado de los candidatos al premio de administracion.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('premio.administracion.asignacion.premios.guardar.candidatos', [$premioAdministracion]) }}"  method="POST" id="frm_asignar_pp">
        @method('post') @csrf

        <div class="card card-custom mb-5">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Candidatos</h3>
                </div>
            </div>
            <div class="card-body">
                @if ( $premioAdministracion->comite_previo != null )
                    <div class="alert alert-custom alert-success fade show mb-5" role="alert">
                        <div class="alert-icon"><i class="flaticon-warning"></i></div>
                        <div class="alert-text"><b>IMPORTANTE: </b>A partir de la 2da ocasión que se entra a esta tarea, tiene que verificar el puntaje y el premio y darle clic al botón de “Guardar”, esto es para que se actualice la información correctamente y no se presenten futuras fallas.</div>
                        <div class="alert-close">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true"><i class="ki ki-close"></i></span>
                            </button>
                        </div>
                    </div>
                @endif
                <table class="table table-bordered table-general"
                    id="tabla_listado_candidatos"
                    data-toggle="table"
                    data-toolbar="#toolbar"
                    data-unique-id="id">
                    <thead>
                        <tr>
                            <th class="text-center"><label class="titulo-dato"> Número de empleado </label></th>
                            <th class="text-center"><label class="titulo-dato"> Nombre </label></th>
                            <th class="text-center"><label class="titulo-dato"> Desempeño </label></th>
                            <th class="text-center"><label class="titulo-dato"> Cursos </label></th>
                            <th class="text-center"><label class="titulo-dato"> Puntualidad y asistencia </label></th>
                            <th class="text-center"><label class="titulo-dato"> Propuesta de candidato </label></th>
                            @if ( $premioAdministracion->comite_previo != null )
                                <th class="text-center"><label class="titulo-dato"> Estatus inconformidad </label></th>
                            @endif
                            @if ( $premioAdministracion->comite_previo != null )
                                <th class="text-center"><label class="titulo-dato"> Razón </label></th>
                            @endif
                            <th class="text-center"><label class="titulo-dato"><span class="requeridos">*</span> Puntuaje </label></th>
                            <th class="text-center"><label class="titulo-dato"><span class="requeridos">*</span> Premio </label></th>
                            <th class="text-center"><label class="titulo-dato"> Origen </label></th>
                            <th class="text-center"><label class="titulo-dato"> Estado de validación </label></th>
                            <th class="text-center"><label class="titulo-dato"> Observaciones </label></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($candidatos as $candidato)
                            <tr>
                                <td>{{ $candidato->numero_empleado }}</td>
                                <td>{{ $candidato->nombre_empleado }} {{ $candidato->apellido_paterno }} {{ $candidato->apellido_materno }}</td>
                                <td>
                                    @if ($candidato->estatus_origen != "PROCESO")
                                        {{ $candidato->comentarios_desempenio }}
                                    @else
                                        <a type="button"
                                            href="{{ route('descargar.pdf.cedula.desempeno.actualizada', [$candidato->rfc, $candidato->p21_premio_id] ) }}"
                                            class="btn btn-sm btn-danger btn-icon"
                                            data-toggle="tooltip"
                                            title="Cedula de desempeño">
                                            <i class="fas fa-file-pdf"></i>
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    @if ($candidato->estatus_origen != "PROCESO")
                                        {{ $candidato->comentarios_cursos }}
                                    @else
                                        <a type="button"
                                            href="{{ route('descargar.pdf.cedula.cursos.actualizada', [$candidato->rfc, $candidato->p21_premio_id] ) }}"
                                            class="btn btn-sm btn-danger btn-icon"
                                            data-toggle="tooltip"
                                            title="Cedula de desempeño">
                                            <i class="fas fa-file-pdf"></i>
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    <a type="button"
                                        href="{{ route('descargar.pdf.puntualidad.asistencia', $candidato->rfc ) }}"
                                        class="btn btn-sm btn-danger btn-icon"
                                        data-toggle="tooltip"
                                        title="Cedula de desempeño">
                                        <i class="fas fa-file-pdf"></i>
                                    </a>
                                </td>
                                <td>
                                    <a type="button"
                                        href="{{ route('descargar.pdf.propuesta.candidato', $candidato->rfc ) }}"
                                        class="btn btn-sm btn-danger btn-icon"
                                        data-toggle="tooltip"
                                        title="Cedula de desempeño">
                                        <i class="fas fa-file-pdf"></i>
                                    </a>
                                </td>
                                @if ( $premioAdministracion->comite_previo != null )
                                    <td>
                                        @if ( $candidato->estatus_inconformidad == 'INCONFORMIDAD' )
                                            <span class="badge badge-danger text-uppercase">{{ $candidato->estatus_inconformidad }}</span>
                                        @else
                                            {{ $candidato->estatus_inconformidad }}
                                        @endif
                                    </td>
                                @endif
                                @if ( $premioAdministracion->comite_previo != null )
                                    <td>{{ $candidato->comentarios_inconformidad }}</td>
                                @endif
                                <td>
                                    <select class="form-control  normalizar-texto puntaje" name="puntaje[]" id="puntaje">
                                        <option value="">%</option>
                                        @foreach ($puntajes as $puntaje)
                                                @if ( isset($candidato->puntaje_total_inicial) )
                                                    <option value="{{$puntaje}},{{ $candidato->numero_empleado }}"
                                                        {{ $candidato->puntaje_total_inicial == $puntaje ? 'selected' : ''}}> {{ $puntaje }}% </option>
                                                @else
                                                    <option value="{{$puntaje}},{{ $candidato->numero_empleado }}"> {{ $puntaje }} </option>
                                                @endif
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control  normalizar-texto premios" name="premios[]" id="premios">
                                        <option value="">{{-- <i class="fas fa-trophy"></i> --}}🏆</option>
                                        @foreach ($premios as $premio)
                                                @if ( isset($candidato->premio_inicial) )
                                                    <option value="{{$premio}}"
                                                        {{ $candidato->premio_inicial == $premio ? 'selected' : ''}}> {{ $premio }} </option>
                                                @else
                                                    <option value="{{$premio}}"> {{ $premio }} </option>
                                                @endif
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    @if ($candidato->estatus_origen == "PROCESO")
                                        <span class="badge badge-primary text-uppercase"><i class="fas fa-sync icon-nm text-white mr-1"></i>{{ $candidato->estatus_origen }}</span>
                                    @else
                                        <span class="badge badge-success text-uppercase"><i class="fas fa-users  icon-nm text-white mr-1"></i>{{ $candidato->estatus_origen }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($candidato->estatus_tiempo == "EN TIEMPO")
                                        <span class="badge badge-success text-uppercase"><i class="far fa-check-circle icon-nm text-white mr-1"></i>{{ $candidato->estatus_tiempo }}</span>
                                    @else
                                        <span class="badge badge-primary text-uppercase"><i class="far fas fa-times icon-nm text-white mr-1"></i>{{ $candidato->estatus_tiempo }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if ( isset($candidato->observaciones) )
                                        <input type="text" class="form-control normalizar-texto observaciones" name="observaciones[]" id="observaciones"
                                        value="{{ $candidato->observaciones ? $candidato->observaciones : '' }}">
                                    @else
                                        <input type="text" class="form-control normalizar-texto observaciones" name="observaciones[]" id="observaciones">
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>

                <div class="text-center mt-5 ">
                    <button type="button" id="btn_guardar_lista_candidatos" class="btn btn-success">Guardar <i class="far fa-save"></i></button>
                </div>
            </div>
        </div>
    </form>

    <form action="{{ route('premio.administracion.asignacion.premios', [$premioAdministracion, $instanciaTarea] ) }}"  method="POST" id="frm_busqueda_empleado">
        @method('post') @csrf
        <div class="card card-custom mb-5" id="agregar_candidatos_premio">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Agregar candidatos</h3>
                </div>
            </div>
            <div class="card-body">

                @include("componentes.busqueda_empleado", [
                    "existeEmpleado" => false,
                ])
                <div class="row mt-5">
                    <div class="col-md-12">
                        <button type="button" id="btn_buscar_empleado" name="btn_buscar_empleado" class="btn btn-success btn_buscar_empleado" ><i class="fas fa-search"></i> Buscar </button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered table-general"
                            id="tabla_datos_empleado"
                            data-toggle="table"
                            data-toolbar="#toolbar"
                            data-unique-id="id">
                            <thead>
                                <tr>
                                    <th data-field="nombre_completo" class="text-center"><label class="titulo-dato"> Nombre del empleado </label></th>
                                    <th data-field="numero_empleado" class="text-center"><label class="titulo-dato"> Número de empleado </label></th>
                                    <th data-field="rfc" class="text-center"><label class="titulo-dato"> RFC </label></th>
                                    <th data-field="seccion_sindical" class="text-center"><label class="titulo-dato"> Sección sindical </label></th>
                                    <th data-field="nivel_salarial" class="text-center"><label class="titulo-dato"> Nivel salarial </label></th>
                                    <th data-field="fecha_alta_empleado" class="text-center"><label class="titulo-dato"> Fecha de ingreso </label></th>
                                    <th data-field="puesto" class="text-center"><label class="titulo-dato"> Puesto </label></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="row mt-8" style="display:none;" id="tituloDatos">
                    <div class="col-md-12">
                        <h4 class="card-label">Datos de la solicitud</h4><hr>
                    </div>
                </div>

                <div class="row" style="display:none;" id="camposDatos">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="titulo-dato"><strong><span class="requeridos">*</span>Comentarios de desempeño</strong></label>
                            <textarea rows="3" class="form-control normalizar-texto" autocomplete="off" name="comentario_desem" id="comentario_desem"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="titulo-dato"><strong><span class="requeridos">*</span>Comentarios de cursos</strong></label>
                            <textarea rows="3" class="form-control normalizar-texto" autocomplete="off" name="comentario_cursos" id="comentario_cursos"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6 align-middle">
                        <div class="form-group">
                            <label class="titulo-dato" for=""><strong><span class="requeridos">*</span>Tipo de nombramiento</strong></label>
                            <select class="form-control  normalizar-texto" name="tipoNombramiento" id="tipoNombramiento" value="{{old('tipoNombramiento')}}">
                                <option value="-1">Seleccione una opción</option>
                                @foreach ($tipoNombramiento as $tipo)
                                    <option value="{{ $tipo }}">{{ $tipo }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="titulo-dato"><strong><span class="requeridos">*</span>Grupo</strong></label>
                            <input type="text" class="form-control normalizar-texto" name="grupo" id="grupo" autocomplete="off">
                        </div>
                    </div>
                </div>
                <div class="text-center mt-5" style="display:none;" id="guardarNuevoCandidato">
                    <button type="button" id="btn_guardar_nuevo_candidato" class="btn btn-success">Guardar <i class="far fa-save"></i></button>
                </div>

            </div>
        </div>
    </form>

    <form action="{{ route('premio.administracion.asignacion.premios', [$premioAdministracion, $instanciaTarea] ) }}"  method="POST" id="frm_finalizar">
        @method('post') @csrf
        <div class="card card-custom mb-5">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Listado de candidatos</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <i style="font-size: 2.5rem" data-toggle="kt-tooltip" data-placement="top" title="Listado de candidatos"><a type="button" id="listado_candidatos" role="link" class="btn btn-danger btn-sm"><i class="fas fa-file-pdf"></i></a></i>&nbsp;
                    </div>
                </div>
            </div>
            <input type="hidden" id="tipo_fin" name="tipo_fin">
            <div class="card-footer">
                <div class="text-center">
                    <button type="submit" id="cancelar_proceso"  class="btn btn-danger" ><i class="fas fa-trash"></i>Cancelar proceso</button>
                    <button type="submit" id="continuar_tarea" class="btn btn-success"><i class="fas fa-check-square"></i>Continuar con TPA04</button>
                    <button type="submit" id="finalizar_tarea" class="btn btn-success"><i class="fas fa-check-square"></i>Finalizar proceso</button>
                </div>
            </div>
        </div>
    </form>

@endsection

@push('scripts')
    <script src="{{ asset('js/p21_premio_administracion/tareas/TPA03_asignacionPremios.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
    <script src="{{ asset('js/componentes/busqueda_empleado.js') }}"></script>
    <script>
        const urlTablaCandidatos = "{{ route('candidatos.tabla.asignacion.premios', $premioAdministracion->p21_premio_id) }}"
        const data_premio = @json($premioAdministracion);
        const yaHuboComite = @json($premioAdministracion->comite_previo);
        const urlDescargarListadoCandidatos = "{{ route('descargar.pdf.listado.candidatos.finales') }}";
        const urlDescargarListadoCandidatosInconformidades = "{{ route('descargar.pdf.listado.candidatos.finales.inconformidades') }}";
        const premio_id = @json($premioAdministracion->p21_premio_id);
        const candidatos_premio = @json($candidatos);
        const tareas = "{{ route('tareas') }}";
        const urlValidarEmpleado = @Json( route('validar.empleado.premio.convocatoria') );
        const urlGuardarNuevoEmpleado = @Json( route('premio.administracion.asignacion.premios.guardar.nuevo.candidato', [$premioAdministracion]) );
    </script>
@endpush

@push('styles')
    <link href="{{ asset('metronic/plugins/custom/bootstraptable/css/bootstrap-table.min.css') }}" type="text/css" rel="stylesheet"/>
@endpush
