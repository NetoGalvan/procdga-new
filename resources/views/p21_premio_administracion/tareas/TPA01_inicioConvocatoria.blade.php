@extends('layouts.main')

@section('title', 'INICIO DE CONVOCATORIA')

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
                'titulo' => 'INICIO DE CONVOCATORIA'
            ]
        ]
    ]])
@endsection

@section('contenido')

    <div class="card card-custom mb-5">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">Inicio de la convocatoria</h3>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <label class="titulo-dato"> Folio </label>
                    <span class="valor-dato">  {{ $premioAdministracion->instancia->folio }} </span>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-md-12">
                    <div class="alert alert-custom alert-success" role="alert">
                        <div class="alert-icon"><i class="flaticon-warning"></i></div>
                        <div class="alert-text">
                            <ul>
                                <li>1. Seleccione el perdiodo de convocatoria.</li>
                                <li>2. Capture la fecha de inicio y fin de la evaluación del periodo de asistencia y puntualidad que corresponde al premio.</li>
                                <li>3. Seleccione la unidad administrativa para la cual desea iniciar la convocatoria.</li>
                                <li>4. Escriba en el área de comentarios las fechas limite para la captura y recepción de solicitudesdel premio de administración así como cualquier instrucción que requiera.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('premio.administracion.inicio.convocatoria', [$premioAdministracion, $instanciaTarea] ) }}"  method="POST" id="frm_inicio_convocatoria">
        @method('post') @csrf

        <div class="card card-custom mb-5">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Datos de la convocatoria</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 align-middle">
                        <div class="form-group">
                            <label class="titulo-dato" for=""><strong><span class="requeridos">*</span>Convocatoria correspondiente a</strong></label>
                            <select class="form-control  normalizar-texto" name="fecha_convocatoria" id="fecha_convocatoria" value="{{old('fecha_convocatoria')}}" required>
                                <option value="">Seleccione una fecha</option>
                                @foreach ($fechasDisponibles as $fechas)
                                    <option value="{{ $fechas }}">{{ $fechas }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 align-middle">
                        <div class="form-group">
                            <label class="titulo-dato" for=""><strong><span class="requeridos">*</span>Área</strong></label>
                            <select
                                    class="form-control text-uppercase"
                                name="area_id" id="area_id" value="{{old('area_id')}}" required>
                                <option value="">Seleccione una unidad</option>
                                @foreach ($areasQueParticipan as $area)
                                    <option value={{ $area->area_id }}> {{ $area->identificador }} - {{ $area->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 align-middle">
                        <p>
                            Recuerde que este proceso es <b>individual y único para la unidad administrativa que seleccione</b>, por lo que debe ser cuidadoso al llenar el mes de la convocatoria, el periodo de evaluación de puntualidad y asistencia, así como los <b>comentarios que serán exclusivos para la unidad administrativa.</b>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-custom mb-5">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Capture el periodo de evaluación de asistencia y puntualidad</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 align-middle">
                        <div class="form-group">
                            <label for="" class="titulo-dato"><strong><span class="requeridos">*</span>Fecha inicio</strong></label>
                            <input type="text" class="form-control normalizar-texto fecha_inicio" name="fecha_inicio" id="fecha_inicio" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="col-md-6 align-middle">
                        <div class="form-group">
                            <label for="" class="titulo-dato"><strong><span class="requeridos">*</span>Fecha fin</strong></label>
                            <input type="text" class="form-control normalizar-texto" name="fecha_fin" id="fecha_fin" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="titulo-dato" for=""><strong><span class="requeridos">*</span>Comentarios</strong></label>
                            <textarea rows="5" class="form-control normalizar-texto" autocomplete="off" name="comentarios" id="comentarios" required campoNoVacio="true"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="text-center">
                    <button type="submit" id="btn_finalizar_TPA01" class="btn btn-success"><i class="fas fa-check-square"></i>Finalizar Tarea</button>
                </div>
            </div>
        </div>
    </form>

@endsection

@push('scripts')
<script src="{{ asset('js/p21_premio_administracion/tareas/TPA01_inicioConvocatoria.js') }}"></script>
<script>
    var rutaCalcularFecha = "{{ route('calcular.fecha.fin') }}";
</script>
@endpush
