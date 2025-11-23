@extends('layouts.main')

@section('title', 'VALIDACIÓN DE CURSOS')

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
                'titulo' => 'VALIDACIÓN DE CURSOS'
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
                <div class="col-md-4">
                    <label class="titulo-dato"> Nombre del empleado </label>
                    <span class="valor-dato"> {{ $inscripcion->nombre_empleado }} {{ $inscripcion->apellido_paterno }} {{ $inscripcion->apellido_materno }} </span>
                </div>
                <div class="col-md-4">
                    <label class="titulo-dato"> Número del empleado </label>
                    <span class="valor-dato">  {{ $inscripcion->numero_empleado }} </span>
                </div>
                <div class="col-md-4">
                    <label class="titulo-dato"> RFC </label>
                    <span class="valor-dato">  {{ $inscripcion->rfc }} </span>
                </div>
                <div class="col-md-4">
                    <label class="titulo-dato"> Puesto </label>
                    <span class="valor-dato">  {{ $inscripcion->descripcion_puesto }} </span>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-md-12">
                    <div class="alert alert-custom alert-success" role="alert">
                        <div class="alert-icon"><i class="flaticon-warning"></i></div>
                        <div class="alert-text">
                            Revise los datos del empleado y proceda a validar los cursos que se muestran en pantalla.
                            <ul>
                                <li>Si la opción corresponde a <b> "NO" </b> Es necesario que capture las causas en el campo de comentarios. </li>
                                <li>Si usted cuenta con algún otro curso que no este registrado, favor de capturar los datos  en el campo de comentarios</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('inscripcion.premio.administracion.validacion.cursos', [$inscripcion, $instanciaTarea]) }}"  method="POST" id="form_validacion_cursos">
        @method('post') @csrf
        <input type="hidden" id="num_empleado" name="num_empleado" value="{{ $inscripcion->numero_empleado }}">
        <input type="hidden" id="folio_inscripcion" name="folio_inscripcion" value="{{ $inscripcion->folio }}">
        <div class="card card-custom mb-5">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Datos de la evaluación</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered table-general" id="tabla_cursos_validados" data-toggle="table" data-toolbar="#toolbar" data-unique-id="id">
                            <thead>
                                <tr>
                                    <th width="30%" data-field="nombre_curso" class="text-center"><label class="titulo-dato"> Nombre del curso </label></th>
                                    <th width="10%" data-field="aplicacion" class="text-center"><label class="titulo-dato"> Aplicación en labores diarias </label></th>
                                    <th width="20%" data-field="comentarios_oper_pa" class="text-center"><label class="titulo-dato"> Comentarios operador del premio </label></th>
                                    <th width="20%" data-field="estado_curso" class="text-center"><label class="titulo-dato"><span class="requeridos">* </span> Estado del curso </label></th>
                                    <th width="20%" data-field="comentarios_oper_cap" class="text-center"><label class="titulo-dato"><span class="requeridos">* </span> Comentarios operador de cursos </label></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($cursos_empleado != null)
                                    @foreach ($cursos_empleado as $curso)
                                        <tr>
                                            <td>{{ $curso->nombre_curso }}</td>
                                            <td>{{ $curso->aplicacion }}</td>
                                            <td>{{ $curso->comentarios_oper_pa }}</td>
                                            <td>
                                                <select class="form-control  normalizar-texto estado_curso" name="estado_curso[]" id="estado_curso" required>
                                                    <option value="">Seleccione una opción</option>
                                                    @foreach ($estadosValidacion as $validacion)
                                                        <option value="{{$validacion}}"> {{ $validacion }} </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td><input type="text" class="form-control normalizar-texto com_oper_cap" name="com_oper_cap[]" id="com_oper_cap" required campoNoVacio="true"></td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row mt-5">
                    <div class="col-md-12 align-middle">
                        <div class="form-group">
                            <label class="titulo-dato" for=""><strong><span class="requeridos">* </span>Comentarios</strong></label>
                            <textarea rows="5" class="form-control normalizar-texto comentarios_oper_cap_21" autocomplete="off" name="comentarios_oper_cap_21" id="comentarios_oper_cap_21" required campoNoVacio="true"></textarea>
                        </div>
                    </div>
                </div>

            </div>
            <div class="card-footer">
                <div class="text-center">
                    <button type="submit" id="btn_finalizar_T03" class="btn btn-success"><i class="fas fa-check-square"></i>Finalizar Tarea</button>
                </div>
            </div>
        </div>
    </form>

@endsection

@push('scripts')
    <script src="{{ asset('js/p21_premio_administracion/p21_premio_administracion_inscripcion/tareas/T03_validacionCursos.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
    <script>
        var cancelarProceso = "{{ route('cancelar.proceso.inscripcion') }}";
        var num_empleado = @json($inscripcion->numero_empleado);
        var tareas = "{{ route('tareas') }}";
    </script>
@endpush

@push('styles')
    <link href="{{ asset('metronic/plugins/custom/bootstraptable/css/bootstrap-table.min.css') }}" type="text/css" rel="stylesheet"/>
@endpush
