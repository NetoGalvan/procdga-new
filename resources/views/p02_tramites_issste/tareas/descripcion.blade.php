@extends('layouts.main')

@section('title', 'Trámites ISSSTE - Descripción')

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
                'titulo' => 'Trámites ISSSTE - Descripción'
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
                <h3 class="card-label">Trámites ISSSTE</h3>
            </div>
        </div>
        <div class="card-body">
            <p class="text-justify">
                Proceso optimizado que permite agilizar los documentos requeridos por el ISSSTE
                con respecto a las altas, bajas y modificaciones de la plantilla de personal de la SecretarÍa de Finanzas.
            </p>
            @if ( count($foliosParaEnviar) > 0 )
                <p class="text-center">Existen <b> {{ count($foliosParaEnviar) }} </b> folios en espera de ser enviados al ISSSTE</p>
            @else
                <p class="text-center">Por el momento No hay folios en espera de ser enviados al ISSSTE.</p>
            @endif
        </div>
        @if ( count($foliosParaEnviar) > 0 )
            <div class="card-footer">
                <div class="text-center">
                    <form id="id_form_iniciar_proceso" action="{{ route('tramites.issste.inicializar.proceso') }}" method="POST">
                        @csrf
                        <button id="id_btn_iniciar_proceso" type="button" class="btn btn-success"> <i class="fas fa-arrow-alt-circle-right"></i> Iniciar proceso</button>
                    </form>
                </div>
            </div>
        @endif
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('js/p02_tramites_issste/tareas/descripcion.js') }}"></script>
@endpush
