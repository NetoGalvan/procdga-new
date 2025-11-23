@extends('layouts.main')

@section('title', 'Descripción')

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
                'titulo' => 'Descripción'
            ]
        ]
    ]])
@endsection

@section('aside_menu')
    @include('layouts.partials.main.aside_menu', ["asideMenu" =>
        [
            "item_seleccionado" => "procesos",
        ]
    ])
@endsection

@section('contenido')

    <div class="card card-custom mb-5">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">Solicitud de Servicio</h3>
            </div>
        </div>
        <div class="card-body">
            <p class="text-justify">
                Proceso diseñado para facilitar el trámite y gestión de las solicitudes de <b> {{$servicio->nombre_servicio_general}} </b>
            </p>
        </div>
        <div class="card-footer">
            <div class="text-center">
                <form id="id_form_iniciar_proceso" action="{{ route('solicitud.servicio.inicializar.proceso', $servicio->clave) }}" method="POST">
                    @csrf
                    <button id="id_btn_iniciar_proceso" type="button" class="btn btn-success"><i class="fas fa-check-square"></i> Iniciar proceso</button>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('js/p08_solicita_servicios/tareas/descripcion.js') }}"> </script>
@endpush
