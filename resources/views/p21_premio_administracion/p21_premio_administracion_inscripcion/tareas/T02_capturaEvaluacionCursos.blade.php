@extends('layouts.main')

@section('title', 'CAPTURA Y EVALUACIÓN DE CURSOS')

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
                'ruta' => Route('procesos')
            ],
            2 => [
                'activo' => true,
                'titulo' => 'CAPTURA Y EVALUACIÓN DE CURSOS'
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
                    <span class="valor-dato"> {{ $inscripcion->area->identificador }} - {{ $inscripcion->area->nombre }} </span>
                </div>
                <div class="col-md-4">
                    <label class="titulo-dato"> Folio </label>
                    <span class="valor-dato">  {{ $inscripcion->folio }} </span>
                </div>
                <div class="col-md-4">
                    <label class="titulo-dato"> Folio del premio </label>
                    <span class="valor-dato">  {{ $datosPremio->folio }} </span>
                </div>
                <div class="col-md-4">
                    <label class="titulo-dato"> Convocatoria correspondiente a  </label>
                    <span class="valor-dato">  {{ $inscripcion->anio_convocatoria }} </span>
                </div>
                <div class="col-md-4">
                    <label class="titulo-dato"> Comentarios del administrador del premio (área de prestaciones) </label>
                    <span class="valor-dato">  {{ $inscripcion->comentarios_admin_pa_21 }} </span>
                </div>
                <div class="col-md-4">
                    <label class="titulo-dato"> Comentarios del operador del premio </label>
                    <span class="valor-dato">  {{ $inscripcion->comentarios_oper_pa_21 }} </span>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-md-12">
                    <div class="alert alert-custom alert-success" role="alert">
                        <div class="alert-icon"><i class="flaticon-warning"></i></div>
                        <div class="alert-text">
                            <p>Un empleado esta participando para obtener el Premio de Administración.</p>
                            <p>Revisa con cuidado los formatos de evaluación autorizados por el jefe inmediato y proceda a capturar la evaluación de desempeño y los cursos de capacitación.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('inscripcion.premio.administracion.captura.evaluacion.cursos', [$inscripcion, $instanciaTarea]) }}" method="POST" id="form_agregar_curso">
        @method('post') @csrf
        <div class="card card-custom mb-5">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Cursos y capacitaciones </h3>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <p>Por favor, captura los cursos tomados en el año</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" class="titulo-dato"><strong><span class="requeridos">*</span>Nombre del curso</strong></label>
                            <input type="text" class="form-control normalizar-texto" name="nombreCurso" id="nombreCurso" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="" class="titulo-dato"><strong><span class="requeridos">*</span>Aplicación en labores diarias</strong></label>
                            <select class="form-control  normalizar-texto" name="aplicacionDiario" id="aplicacionDiario" value="{{old('aplicacionDiario')}}">
                                <option value="">Seleccione una opción</option>
                                @foreach ($aplicacionDiaria as $aplicacion)
                                    <option value="{{ $aplicacion }}">{{ $aplicacion }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="" class="titulo-dato"><strong><span class="requeridos">*</span>Comentarios</strong></label>
                            <textarea rows="3" class="form-control normalizar-texto" autocomplete="off" name="comentariosAplicacion" id="comentariosAplicacion"></textarea>
                        </div>
                    </div>
                    <div class="col-md-12 text-center">
                        <button type="button" id="guardarCurso" class="btn btn-success"><i class="fas fa-plus"></i>Agregar</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered table-general"
                        id="tabla_cursos"
                        data-toggle="table"
                        data-toolbar="#toolbar"
                        data-unique-id="id">
                        <thead>
                            <tr>
                                <th data-field="nombre_curso" class="text-center">Nombre del curso</th>
                                <th data-field="aplicacion" class="text-center">Aplicación en labores diarias</th>
                                <th data-field="comentarios_oper_pa" class="text-center" >Comentarios</th>
                            </tr>
                        </thead>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form action="{{ route('inscripcion.premio.administracion.captura.evaluacion.cursos', [$inscripcion, $instanciaTarea]) }}"  method="POST" id="form_completar_tarea_02">
        @method('post') @csrf

        <div class="card card-custom mb-5">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Datos del empleado </h3>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <label class="titulo-dato"> Nombre del empleado </label>
                        <span class="valor-dato"> {{ $inscripcion->nombre_empleado }} {{ $inscripcion->apellido_paterno }} {{ $inscripcion->apellido_materno }} </span>
                    </div>
                    <div class="col-md-3">
                        <label class="titulo-dato"> Número del empleado </label>
                        <span class="valor-dato">  {{ $inscripcion->numero_empleado }} </span>
                    </div>
                    <div class="col-md-3">
                        <label class="titulo-dato"> RFC </label>
                        <span class="valor-dato">  {{ $inscripcion->rfc }} </span>
                    </div>
                    <div class="col-md-3">
                        <label class="titulo-dato"> Puesto </label>
                        <span class="valor-dato">  {{ $inscripcion->descripcion_puesto }} </span>
                    </div>
                </div>

                <div class="row mt-5">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" class="titulo-dato"><strong><span class="requeridos">*</span>Antigüedad en el puesto</strong></label>
                            <input type="text" class="form-control normalizar-texto" name="antiguedad" id="antiguedad" autocomplete="off" required campoNoVacio="true">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" class="titulo-dato"><strong><span class="requeridos">*</span>Denominación del puesto</strong></label>
                            <input type="text" class="form-control normalizar-texto" name="denominacionPuesto" id="denominacionPuesto" autocomplete="off" required campoNoVacio="true">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" class="titulo-dato"><strong><span class="requeridos">*</span>Domicilio del centro de trabajo</strong></label>
                            <input type="text" class="form-control normalizar-texto" name="domicilioTrabajo" id="domicilioTrabajo" autocomplete="off" required campoNoVacio="true">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" class="titulo-dato"><strong><span class="requeridos">*</span>Teléfono del trabajo</strong></label>
                            <input type="text" class="form-control normalizar-texto" name="telefonoTrabajo" id="telefonoTrabajo" autocomplete="off" pattern="[0-9]{10}" placeholder="10 Dígitos" maxlength="10" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" class="titulo-dato">Ext</label>
                            <input type="text" class="form-control normalizar-texto" name="extension" id="extension" autocomplete="off" pattern="[0-9]{3,4}" placeholder="3 o 4 Dígitos" maxlength="4" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" class="titulo-dato"><strong><span class="requeridos">*</span>Nombre del jefe inmediato</strong></label>
                            <input type="text" class="form-control normalizar-texto" name="nombreJefe" id="nombreJefe" autocomplete="off" required campoNoVacio="true" soloLetras="true">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" class="titulo-dato"><strong><span class="requeridos">*</span>Cargo del jefe inmediato</strong></label>
                            <input type="text" class="form-control normalizar-texto" name="cargoJefe" id="cargoJefe" autocomplete="off" required campoNoVacio="true" >
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" class="titulo-dato">Descripción de actividades</label>
                            <input type="text" class="form-control normalizar-texto" name="descripcionActividades" id="descripcionActividades" autocomplete="off" required campoNoVacio="true">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" class="titulo-dato">Grupo</label>
                            <input type="text" class="form-control normalizar-texto" name="grupo" id="grupo" autocomplete="off" required campoNoVacio="true" >
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="card-label">Datos de la solicitud</h4><hr>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 align-middle">
                        <div class="form-group">
                            <label class="titulo-dato" for=""><strong><span class="requeridos">*</span>Tipo de nombramiento</strong></label>
                            <select class="form-control  normalizar-texto" name="tipoNombramiento" id="tipoNombramiento" value="{{old('tipoNombramiento')}}" required>
                                <option value="">Seleccione una opción</option>
                                @foreach ($tipoNombramiento as $tipo)
                                    <option value="{{ $tipo }}">{{ $tipo }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 align-middle">
                        <div class="form-group">
                            <label class="titulo-dato" for=""><strong><span class="requeridos">*</span>Propuesto por</strong></label>
                            <select class="form-control  normalizar-texto" name="propuestoPor" id="propuestoPor" value="{{old('propuestoPor')}}" required>
                                <option value="">Seleccione una opción</option>
                                @foreach ($propuestoPor as $propuesto)
                                    <option value="{{ $propuesto }}">{{ $propuesto }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="card card-custom mb-5">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Evaluación de desempeño</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="titulo-dato" for=""><strong><span class="requeridos">*</span>Fecha de evaluación</strong></label>
                            <input type="text" class="form-control normalizar-texto" name="fechaEvaluacion" id="fechaEvaluacion" autocomplete="off" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="titulo-dato" for=""><strong><span class="requeridos">*</span>Productividad</strong></label>
                            <select class="form-control  normalizar-texto calcular" name="productividad" id="productividad" value="{{old('productividad')}}" required>
                                <option value="">Seleccione una opción</option>
                                @foreach ($evaluaciones as $key => $evaluacion)
                                    <option value="{{ $key }}">{{ $evaluacion }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="titulo-dato" for=""><strong><span class="requeridos">*</span>Alcance de objetivos</strong></label>
                            <select class="form-control  normalizar-texto calcular" name="alcanceObjetivos" id="alcanceObjetivos" value="{{old('alcanceObjetivos')}}" required>
                                <option value="">Seleccione una opción</option>
                                @foreach ($evaluaciones as $key => $evaluacion)
                                    <option value="{{ $key }}">{{ $evaluacion }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="titulo-dato" for=""><strong><span class="requeridos">*</span>Trabajo bajo presión</strong></label>
                            <select class="form-control  normalizar-texto calcular" name="trabajoBajoPresion" id="trabajoBajoPresion" value="{{old('trabajoBajoPresion')}}" required>
                                <option value="">Seleccione una opción</option>
                                @foreach ($evaluaciones as $key => $evaluacion)
                                    <option value="{{ $key }}">{{ $evaluacion }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="titulo-dato" for=""><strong><span class="requeridos">*</span>Calidad</strong></label>
                            <select class="form-control  normalizar-texto calcular" name="calidad" id="calidad" value="{{old('calidad')}}" required>
                                <option value="">Seleccione una opción</option>
                                @foreach ($evaluaciones as $key => $evaluacion)
                                    <option value="{{ $key }}">{{ $evaluacion }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="titulo-dato" for=""><strong><span class="requeridos">*</span>Responsabilidad</strong></label>
                            <select class="form-control  normalizar-texto calcular" name="responsabilidad" id="responsabilidad" value="{{old('responsabilidad')}}" required>
                                <option value="">Seleccione una opción</option>
                                @foreach ($evaluaciones as $key => $evaluacion)
                                    <option value="{{ $key }}">{{ $evaluacion }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="titulo-dato" for=""><strong><span class="requeridos">*</span>Planeación</strong></label>
                            <select class="form-control  normalizar-texto calcular" name="planeacion" id="planeacion" value="{{old('planeacion')}}" required>
                                <option value="">Seleccione una opción</option>
                                @foreach ($evaluaciones as $key => $evaluacion)
                                    <option value="{{ $key }}">{{ $evaluacion }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="titulo-dato" for=""><strong><span class="requeridos">*</span>Conocimientos</strong></label>
                            <select class="form-control  normalizar-texto calcular" name="conocimiento" id="conocimiento" value="{{old('conocimiento')}}" required>
                                <option value="">Seleccione una opción</option>
                                @foreach ($evaluaciones as $key => $evaluacion)
                                    <option value="{{ $key }}">{{ $evaluacion }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="titulo-dato" for=""><strong><span class="requeridos">*</span>Organización</strong></label>
                            <select class="form-control  normalizar-texto calcular" name="organizacion" id="organizacion" value="{{old('organizacion')}}" required>
                                <option value="">Seleccione una opción</option>
                                @foreach ($evaluaciones as $key => $evaluacion)
                                    <option value="{{ $key }}">{{ $evaluacion }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="titulo-dato" for=""><strong><span class="requeridos">*</span>Previsión</strong></label>
                            <select class="form-control  normalizar-texto calcular" name="prevision" id="prevision" value="{{old('prevision')}}" required>
                                <option value="">Seleccione una opción</option>
                                @foreach ($evaluaciones as $key => $evaluacion)
                                    <option value="{{ $key }}">{{ $evaluacion }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="titulo-dato" for=""><strong><span class="requeridos">*</span>Iniciativa</strong></label>
                            <select class="form-control  normalizar-texto calcular" name="iniciativa" id="iniciativa" value="{{old('iniciativa')}}" required>
                                <option value="">Seleccione una opción</option>
                                @foreach ($evaluaciones as $key => $evaluacion)
                                    <option value="{{ $key }}">{{ $evaluacion }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="titulo-dato" for=""><strong><span class="requeridos">*</span>Trabajo independiente</strong></label>
                            <select class="form-control  normalizar-texto calcular" name="trabajoIndependiente" id="trabajoIndependiente" value="{{old('trabajoIndependiente')}}" required>
                                <option value="">Seleccione una opción</option>
                                @foreach ($evaluaciones as $key => $evaluacion)
                                    <option value="{{ $key }}">{{ $evaluacion }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="titulo-dato" for=""><strong><span class="requeridos">*</span>Rapidez</strong></label>
                            <select class="form-control  normalizar-texto calcular" name="rapidez" id="rapidez" value="{{old('rapidez')}}" required>
                                <option value="">Seleccione una opción</option>
                                @foreach ($evaluaciones as $key => $evaluacion)
                                    <option value="{{ $key }}">{{ $evaluacion }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="titulo-dato" for=""><strong><span class="requeridos">*</span>Cooperación</strong></label>
                            <select class="form-control  normalizar-texto calcular" name="cooperacion" id="cooperacion" value="{{old('cooperacion')}}" required>
                                <option value="">Seleccione una opción</option>
                                @foreach ($evaluaciones as $key => $evaluacion)
                                    <option value="{{ $key }}">{{ $evaluacion }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="titulo-dato" for=""><strong><span class="requeridos">*</span>Relaciones interpersonales</strong></label>
                            <select class="form-control  normalizar-texto calcular" name="relacionesInterpersonales" id="relacionesInterpersonales" value="{{old('relacionesInterpersonales')}}" required>
                                <option value="">Seleccione una opción</option>
                                @foreach ($evaluaciones as $key => $evaluacion)
                                    <option value="{{ $key }}">{{ $evaluacion }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="titulo-dato" for=""><strong><span class="requeridos">*</span>Confiabilidad y discreción</strong></label>
                            <select class="form-control  normalizar-texto calcular" name="confiabilidadDiscrecion" id="confiabilidadDiscrecion" value="{{old('confiabilidadDiscrecion')}}" required>
                                <option value="">Seleccione una opción</option>
                                @foreach ($evaluaciones as $key => $evaluacion)
                                    <option value="{{ $key }}">{{ $evaluacion }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="titulo-dato" for=""><strong><span class="requeridos">*</span>Criterio</strong></label>
                            <select class="form-control  normalizar-texto calcular" name="criterio" id="criterio" value="{{old('criterio')}}" required>
                                <option value="">Seleccione una opción</option>
                                @foreach ($evaluaciones as $key => $evaluacion)
                                    <option value="{{ $key }}">{{ $evaluacion }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" id="data_tabla_cursos" name="data_tabla_cursos">
            <div class="card-footer">
                <div class="text-center">
                    <button type="submit" id="btn_finalizar_T02" class="btn btn-success"><i class="fas fa-check-square"></i>Finalizar Tarea</button>
                </div>
            </div>
        </div>
    </form>



@endsection

@push('scripts')
    <script src="{{ asset('js/p21_premio_administracion/p21_premio_administracion_inscripcion/tareas/T02_capturaEvaluacionCursos.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
    <script>

    </script>
@endpush

@push('styles')
    <link href="{{ asset('metronic/plugins/custom/bootstraptable/css/bootstrap-table.min.css') }}" type="text/css" rel="stylesheet"/>
@endpush
