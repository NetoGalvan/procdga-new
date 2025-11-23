@extends('layouts.main')

@section('title', 'RECEPCIÓN DE INCONFORMIDADES')

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
                'titulo' => 'RECEPCIÓN DE INCONFORMIDADES'
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
                    <span class="valor-dato">  {{ $premioAdministracion->instancia->folio }} </span>
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
                                <li>1. En caso de que exista una inconformidad para alguno de los empleados contenidos en el listado rankeado seleccione la opción "INCONFORMIDAD" de la columna correspondiente a inconformidad.</li>
                                <li>2. Capture las causas en caso de existir inconformidades en el apartado de comentarios.</li>
                                <li>3. Una vez que haya capturado el estatus de inconformidades procesa a descargar y publicar nuevamente el listado.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('premio.administracion.recepcion.inconformidades', [$premioAdministracion, $instanciaTarea]) }}"  method="POST" id="frm_inconformidades">
        @method('post') @csrf

        <div class="card card-custom mb-5">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Lista de candidatos</h3>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-general"
                    id="tabla_listado_candidatos_inconformidades"
                    data-toggle="table"
                    data-toolbar="#toolbar"
                    data-unique-id="id">
                    <thead>
                        <tr>
                            <th class="text-center"><label class="titulo-dato"> Número de empleado </label></th>
                            <th class="text-center"><label class="titulo-dato"> Nombre </label></th>
                            <th class="text-center"><label class="titulo-dato"> Puntuaje </label></th>
                            <th class="text-center"><label class="titulo-dato"> Premio </label></th>
                            <th class="text-center"><label class="titulo-dato"> Aceptación / Rechazo </label></th>
                            <th class="text-center"><label class="titulo-dato"> Comentarios </label></th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($candidatos as $candidato)
                            <tr>
                                <td>{{ $candidato->numero_empleado }}</td>
                                <td>{{ $candidato->nombre_empleado }} {{ $candidato->apellido_paterno }} {{ $candidato->apellido_materno }}</td>
                                <td>
                                    @if ( $premioAdministracion->comite_previo != null )
                                        {{ $candidato->puntaje_total_final }}%
                                    @else
                                        {{ $candidato->puntaje_total_inicial }}%
                                    @endif
                                </td>
                                <td>
                                    @if ( $premioAdministracion->comite_previo != null )
                                        {{ $candidato->premio_final }}
                                    @else
                                        {{ $candidato->premio_inicial }}
                                    @endif
                                </td>
                                <td>
                                    <select class="form-control  normalizar-texto estatus_inconformidad" name="estatus_inconformidad[]" id="estatus_inconformidad" required>
                                        <option value="">Seleccione una opción</option>
                                        @foreach ($opciones as $opcion)
                                            @if ( isset($candidato->estatus_inconformidad) )
                                                <option value="{{$opcion}},{{ $candidato->numero_empleado }}"
                                                    {{ $candidato->estatus_inconformidad == $opcion ? 'selected' : ''}}> {{ $opcion }} </option>
                                            @else
                                                <option value="{{$opcion}},{{ $candidato->numero_empleado }}"> {{ $opcion }} </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    @if ( isset($candidato->comentarios_inconformidad) )
                                        <input type="text" class="form-control normalizar-texto comentario_inconformidad" name="comentario_inconformidad[]" id="comentario_inconformidad"
                                        value="{{ $candidato->comentarios_inconformidad ? $candidato->comentarios_inconformidad : '' }}" required>
                                    @else
                                        <input type="text" class="form-control normalizar-texto comentario_inconformidad" name="comentario_inconformidad[]" id="comentario_inconformidad" required>
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>

                <div class="text-center mt-5 ">
                    <button type="button" id="btn_guardar_status_comentario" class="btn btn-success">Guardar <i class="far fa-save"></i></button>
                </div>
            </div>
        </div>
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
            <div class="card-footer">
                <div class="text-center">
                    <button type="submit" id="regresar_tarea_3" class="btn btn-success"><i class="fas fa-check-square"></i>Finalizar tarea</button>
                </div>
            </div>
        </div>
    </form>

@endsection

@push('scripts')
    <script src="{{ asset('js/p21_premio_administracion/tareas/TPA04_recepcionInconformidades.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
    <script>
        const data_premio = @json($premioAdministracion);
        const urlDescargarListadoCandidatosInconformidades = "{{ route('descargar.pdf.listado.candidatos.finales.inconformidades') }}";
        const premio_id = @json($premioAdministracion->p21_premio_id);
        const urlDescargarListadoCandidatos = "{{ route('descargar.pdf.listado.candidatos.finales') }}";
        const urlGuardarRecepcionInconformidades = @Json( route('premio.administracion.guardar.recepcion.inconformidades', [$premioAdministracion]) );
    </script>
@endpush

@push('styles')
    <link href="{{ asset('metronic/plugins/custom/bootstraptable/css/bootstrap-table.min.css') }}" type="text/css" rel="stylesheet"/>
@endpush
