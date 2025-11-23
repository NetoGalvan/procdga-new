@extends('layouts.main')

@section('title', 'BUSQUEDA Y GENERACIÓN DE FORMATOS')

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
                'titulo' => 'BUSQUEDA Y GENERACIÓN DE FORMATOS'
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
                    <span class="valor-dato">  {{ $inscripcion->instancia->folio }} </span>
                </div>
                <div class="col-md-4">
                    <label class="titulo-dato"> Folio del premio </label>
                    <span class="valor-dato"> {{ $datosPremio->folio }} </span>
                </div>
                <div class="col-md-4">
                    <label class="titulo-dato"> Convocatoria correspondiente a: </label><a id="fecha_convocatoria"></a>
                    <span class="valor-dato"> @if ($datosPremio->anio_convocatoria != null){{ $datosPremio->anio_convocatoria }}@endif </span>
                </div>
                <div class="col-md-4">
                    <label class="titulo-dato"> Comentarios del administrador del premio (área de prestaciones) </label><a id="comentario_admin"></a>
                    <span class="valor-dato"> @if ($datosPremio->comentarios_admin_pa_21 != null){{ $datosPremio->comentarios_admin_pa_21 }}@endif </span>
                </div>
                <div class="col-md-4">
                    <label class="titulo-dato"> Periodo de evaluación de puntualidad y asistencia del </label><a id="fechas_evaluacion"></a>
                    <span class="valor-dato"> @if ($datosPremio->fecha_inicio_evaluacion_pa != null){{ $datosPremio->fecha_inicio_evaluacion_pa }} <b> al </b> {{ $inscripcion->fecha_fin_evaluacion_pa }} @endif </span>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-md-12">
                    <div class="alert alert-custom alert-success" role="alert">
                        <div class="alert-icon"><i class="flaticon-warning"></i></div>
                        <div class="alert-text">
                            <ul>
                                <li>1. Seleccione la convocatoria para la cual desea realizar la inscripción y guarde <b>¡SEA CUIDADOSO!</b> </li>
                                <li>2. Atienda a las indicaciones del administrador de premio en la Subdirección de Prestaciones y Capacitación.</li>
                                <li>3. Revise cuidadosamente la fecha y hora limites de recepción de solicitudes que se indican en la convocatoria.</li>
                                <li>4. Capture el número de empleado y búsquelo</li>
                                <li>5. Descargue, imprima y entregue al empleado los siguientes formatos para su llenado y firma de jefe inmediato:
                                    <ul>
                                        <li>Cédula de evaluación y desempeño</li>
                                        <li>Formato de cursos de capacitación tomados por el empleado</li>
                                        <li>Reporte de evaluación de puntualidad y asistencia (recuerde que la evaluación se congela en el instante de generación del reporte)</li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-custom mb-5" id="seleccion_convocatoria">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">Convocatoria</h3>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('inscripcion.premio.administracion.busqueda.generacion.formatos', [$inscripcion, $instanciaTarea] ) }}"  method="POST" id="form_guardar_convocatoria">
                @method('post') @csrf
                <div class="row">
                    <div class="col-md-4 align-middle">
                        <div class="form-group">
                            <label class="titulo-dato" for=""><strong><span class="requeridos">*</span>Por favor seleccione el premio para el cual desea realizar la inscripción<strong></label>
                            <input type="hidden" name="folio" id="folio" value="{{ $datosPremio->folio }}">
                            <select class="form-control  normalizar-texto" name="convocatoria" id="convocatoria" value="{{old('convocatoria')}}">
                                <option value="-1">Seleccione una opción</option>
                                <option value="{{ $datosPremio->anio_convocatoria }}">{{ $datosPremio->anio_convocatoria }}</option>
                            </select>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-footer">
            <div class="text-center">
                <button type="button" class="btn btn-danger" id="btn_cancelar_proceso"><i class="fas fa-trash"></i>Cancelar proceso</button>
                <button type="button" id="btn_guardar_convocatoria" class="btn btn-success"><i class="fas fa-save"></i>Guardar</button>
            </div>
        </div>
    </div>

    <div class="card card-custom mb-5" id="solicitud_premio" style="display: none">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">Solicitud del premio de administración </h3>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('evaluacion.adicion.empleados', [$inscripcion, $instanciaTarea] ) }}"  method="POST" id="frm_busqueda_empleado">
                @method('post') @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            @include("componentes.busqueda_empleado", [
                                "existeEmpleado" => false,
                            ])
                        </div>
                    </div>
                </div>
                <button type="button" id="btn_buscar_empleado" name="btn_buscar_empleado" class="btn btn-success btn_buscar_empleado" ><i class="fas fa-search"></i> Buscar </button>
            </form>
            <form action="{{ route('inscripcion.premio.administracion.busqueda.generacion.formatos', [$inscripcion, $instanciaTarea]) }}" method="POST" id="form_completar_tarea">
            @method('post') @csrf
                <div class="row mt-5">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="titulo-dato" for=""><strong><span class="requeridos">* </span>Comentarios</strong></label>
                            <textarea rows="3" class="form-control normalizar-texto" autocomplete="off" name="comentarios" id="comentarios"></textarea>
                        </div>
                    </div>
                </div>
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
                            <th data-field="acciones" class="text-center" data-formatter="accionesFormatterDescargarReportes"><label class="titulo-dato"> &nbsp;&nbsp;&nbsp; Descargar archivos &nbsp;&nbsp;&nbsp; </label></th>
                        </tr>
                    </thead>
                </table>
                <input type="text" id="arreglos" name="arreglos"hidden>
            </form>
        </div>
        <div class="card-footer">
            <div class="text-center">
                <button type="button" id="btn_finalizar_T01" class="btn btn-success"><i class="fas fa-check-square"></i>Finalizar Tarea</button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/p21_premio_administracion/p21_premio_administracion_inscripcion/tareas/T01_busquedaGeneracionFormatos.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
    <script src="{{ asset('js/componentes/busqueda_empleado.js') }}"></script>
    <script>
        var cancelarProceso = "{{ route('cancelar.proceso.inscripcion') }}";
        var instancia_id = @json($instancia->instancia_id);
        var p21_inscripcion_id = @json($inscripcion->p21_inscripcion_id);
        var yaTieneConvocatoria = @json($inscripcion->anio_convocatoria);
        var urlPdfPropuestaCandidato = @json( route('descargar.pdf.propuesta.candidato') );
        var urlPdfCedulaDesempeno = @json( route('descargar.pdf.cedula.desempeno') );
        var urlPdfCedulaCursos = @json( route('descargar.pdf.cedula.cursos') );
        var urlPdfPuntualidadAsistencia = @json( route('descargar.pdf.puntualidad.asistencia') );
        var urlValidarEmpleado = @Json( route('validar.empleado.premio.inscripcion') );
    </script>
@endpush

@push('styles')
    <link href="{{ asset('metronic/plugins/custom/bootstraptable/css/bootstrap-table.min.css') }}" type="text/css" rel="stylesheet"/>
@endpush
