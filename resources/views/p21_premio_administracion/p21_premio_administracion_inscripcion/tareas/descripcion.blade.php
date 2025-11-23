@extends('layouts.main')

@section('title', 'DESCRIPCIÓN')

@section('aside_menu')
    @include('layouts.partials.main.aside_menu', ["asideMenu" =>
        [
            "item_seleccionado" => "procesos",
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
                'titulo' => 'Procesos',
                'ruta' => Route('procesos')
            ],
            2 => [
                'activo' => true,
                'titulo' => 'DESCRIPCIÓN'
            ]
        ]
    ]])
@endsection

@section('contenido')

    <div class="card card-custom mb-5">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">Proceso de Inscripción al premio de administración</h3>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <p>
                        En este proceso es posible la inscripción voluntaria de los empleados para competir por el Premio de Administración.
                    </p>
                </div>
                <div class="col-md-12">
                    <p>
                        Tenga en cuenta las siguientes reglas:
                        <ul>
                            <li>Solo podrá iniciar un proceso de inscripción a premio de administración si y solo si se encuentra alguna convocatoria activa y abierta a inscripciones para su unidad administrativa.</li>
                            <li>Pueden existir más de una convocatoria activa para su área. De ser así, sea cuidadoso al seleccionar en cual convocatoria será inscrito el empleado.</li>
                            <li>Cuando no exista ninguna convocatoria activa y abierta a inscripciones para su área presione el botón de <b> No deseo iniciar este proceso ahora.</b></li>
                            <li>Para dudas sobre el calendario de las convocatorias comuníquese con la Subdirección de Prestaciones y Capacitación.</li>
                        </ul>
                    </p>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="text-center">
                <form action="{{ route('premio.administracion.inscripcion.inicializar.proceso') }}" method="POST" id="form_iniciar_proceso_p21_inscripcion">
                    @csrf @method('post')
                    <button id="btn_iniciar_proceso_p21_inscripcion" type="button" class="btn btn-success"> <i class="fas fa-arrow-alt-circle-right"></i> Iniciar proceso</button>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('js/p21_premio_administracion/p21_premio_administracion_inscripcion/tareas/descripcion.js') }}"></script>
@endpush
