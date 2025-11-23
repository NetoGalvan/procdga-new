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
                'titulo' => 'Administración de premio de puntualidad y asistencia'
            ]
        ]
    ]])
@endsection

@section('contenido')

    <div class="card card-custom mb-5">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">Administración de premio de puntualidad y asistencia</h3>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <p>
                        Bienvenido a este proceso que está diseñado para facilitar y agilizar el trámite de pago de premio de puntualidad y asistencia.
                    </p>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="text-center">
                <form action="{{ route('premio.puntualidad.asistencia.iniciar.proceso') }}" method="POST" id="form_iniciar_proceso_p20">
                    @csrf @method('post')
                    <button id="btn_iniciar_proceso_p20" type="button" class="btn btn-success"> <i class="fas fa-arrow-alt-circle-right"></i> Iniciar proceso</button>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('js/p20_premio_puntualidad_asistencia/tareas/descripcion.js') }}"></script>
@endpush
