@extends('layouts.main')

@section('title', 'ELIMINACIÓN DE SOLICITUDES')

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
                'titulo' => 'ELIMINACIÓN DE SOLICITUDES'
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
                    <span class="valor-dato">  {{ $premioAdministracion->fecha_inicio_evaluacion_pa }} <b> a </b> {{ $premioAdministracion->fecha_fin_evaluacion_pa }} </span>
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
                                <li>1. Revise e imprema el listado de solicitantes del premio.</li>
                                <li>2. Publique el listado perteneciente a su unidad administrativa de acuerdo a las fechas indicadas por el Jefe de la Subdirección de Prestaciones y Capacitación.</li>
                                <li>3. Los empleados inscritos que decidad <b>renunciar</b> a participar en la solicitud del premio, deberá cambiar su estado a <b>DECLINADO</b>.</li>
                                <li>4. Imprima y publique nuevamente el listado después de haber capturado las declaraciones. Esto con el fin de que los empleados tengan conocimiento de que ya pasaron a la siguiente etapa del concurso del premio de administracion.</li>
                                <li>5. Cuando tengan todo listo, seleccione el botón para continuar. </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('premio.administracion.eliminacion.solicitudes', [$premioAdministracion, $instanciaTarea] ) }}"  method="POST" id="frm_eliminacion_solicitudes">
        @method('post') @csrf

        <div class="card card-custom mb-5">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Lista de candidatos</h3>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-general" id="tabla_datos_candidatos" data-toggle="table" data-toolbar="#toolbar" data-unique-id="id">
                    <thead>
                        <tr>
                            <th class="text-center" width="35%"><label class="titulo-dato"> Número de empleado </label></th>
                            <th class="text-center" width="35%"><label class="titulo-dato"> Nombre </label></th>
                            <th class="text-center" width="15%"><label class="titulo-dato"> Estado </label></th>
                            <th class="text-center" width="15%"><label class="titulo-dato"> Razón </label></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($candidatos as $candidato)
                            <tr>
                                <td>{{ $candidato->numero_empleado }}</td>
                                <td>{{ $candidato->nombre_empleado }} {{ $candidato->apellido_paterno }} {{ $candidato->apellido_materno }}</td>
                                <td>
                                    <select class="form-control  normalizar-texto estado_candidatos" name="estado_candidatos[]" id="estado_candidatos" required>
                                        <option value="">Seleccione una opción</option>
                                        @foreach ($opcionesEstado as $estado)
                                                @if ( isset($candidato['candiPremio']->estatus_declinacion) )
                                                    <option value="{{$estado}},{{ $candidato->numero_empleado }}"
                                                        {{ $candidato['candiPremio']->estatus_declinacion == $estado ? 'selected' : ''}}> {{ $estado }} </option>
                                                @else
                                                    <option value="{{$estado}},{{ $candidato->numero_empleado }}"> {{ $estado }} </option>
                                                @endif
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    @if ( isset($candidato['candiPremio']->comentarios_declinacion) )
                                        <input type="text" class="form-control normalizar-texto razon" name="razon[]" id="razon"
                                        value="{{ $candidato['candiPremio']->comentarios_declinacion ? $candidato['candiPremio']->comentarios_declinacion : '' }}" required>
                                    @else
                                        <input type="text" class="form-control normalizar-texto razon" name="razon[]" id="razon" required>
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>

                <div class="text-right mt-5 mr-35">
                    <button type="button" id="btn_guardar_estado" class="btn btn-success">Guardar <i class="far fa-save"></i></button>
                </div>
            </div>
            <div class="card-footer">
                <div class="text-center">
                    <button type="submit" id="btn_finalizar_TPA02" class="btn btn-success"><i class="fas fa-check-square"></i>Finalizar Tarea</button>
                </div>
            </div>
        </div>
    </form>

@endsection

@push('scripts')
    <script src="{{ asset('js/p21_premio_administracion/tareas/TPA02_eliminacionSolicitudes.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
    <script>
        const rutaDescargarListaCandidatos = "{{ route('descargar.pdf.lista.candidatos') }}";
        const hayCandidatos = @json($candidatos);
        const urlGuardarAvance = @json( route('premio.administracion.guardar.avance.eliminacion.solicitudes', [$premioAdministracion]) );
        const inscripcionExiste = @json($inscripcionExiste);
    </script>
@endpush

@push('styles')
    <link href="{{ asset('metronic/plugins/custom/bootstraptable/css/bootstrap-table.min.css') }}" type="text/css" rel="stylesheet"/>
@endpush
