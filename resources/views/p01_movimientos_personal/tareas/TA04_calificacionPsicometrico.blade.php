@extends('layouts.main')

@section('title', "MOVIMIENTOS DE PERSONAL - {$instanciaTarea->tarea->nombre}")

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
                'titulo' => "MOVIMIENTOS DE PERSONAL - {$instanciaTarea->tarea->nombre}"
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
    <form action="{{ route('movimiento.personal.altas.psicometrico.calificacion', [$movimientoPersonal, $instanciaTarea]) }}" method="POST" id="id_form_calificacion_psicometrico">
        @csrf
        <div class="card card-custom">
            <div class="card-body">
                @include("p01_movimientos_personal.tareas.partials.datos_general", [
                    "secciones" => [
                        "general" => ["tipo_movimiento", "fecha_Solicitud"],
                        "plaza" => [],
                        "candidato" => []
                    ]
                ])
            </div>
        </div>
        <div class="card card-custom mt-8">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Calificación</h3>
                </div>
            </div>
            <div class="card-body"> 
                <div class="row">
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato">Fecha de cita: </label>
                        <span class="valor-dato text-uppercase"> {{ convertirFechaFormatoMX($movimientoPersonal->calificacionPsicometrico->fecha) }} </span>
                    </div>
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato">Hora: </label>
                        <span class="valor-dato text-uppercase"> {{ $movimientoPersonal->calificacionPsicometrico->hora }} </span>
                    </div>
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato">Lugar: </label>
                        <span class="valor-dato text-uppercase"> {{ $movimientoPersonal->calificacionPsicometrico->lugar }} </span>
                    </div>
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato"><strong><span class="text-danger">* </span>Calificación</strong></label>
                        <select class="form-control" name="tipo_calificacion_psicometrico_id" id="tipo_calificacion_psicometrico_id" autocomplete="off" required>
                            <option value="">Seleccione una opción</option>
                            @foreach ($tiposCalificaciones as $tipoCalificacion)
                                <option value="{{ $tipoCalificacion->tipo_calificacion_psicometrico_id }}">{{ $tipoCalificacion->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="titulo-dato"><strong><span class="text-danger">* </span>Observaciones calificacion:</strong></label>
                        <textarea class="form-control normalizar-texto" name="observaciones_calificacion" id="observaciones_calificacion" autocomplete="off" required></textarea>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="text-center">
                    <button type="submit" class="btn btn-success"><i class="fas fa-check-square"></i> Finalizar tarea</button>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')	
	<script src="{{ asset('js/p01_movimientos_personal/tareas/TA04_calificacionPsicometrico.js?v=1.0')}}"></script>
@endpush