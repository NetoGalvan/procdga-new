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
                'titulo' => 'DIGITALIZACIÓN DE ARCHIVO - DESCRIPCIÓN'
            ]
        ]
    ]])
@endsection

@section('contenido')

    <div class="card card-custom mb-5">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">Digitalización de archivo</h3>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <p>
                        Bienvenido a este proceso que está diseñado para facilitar y agilizar la digitalización del archivo del empleado.
                    </p>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="text-center">
                <form action="{{ route('digitalizacion.archivo.iniciar.proceso') }}" method="POST" id="id_form_iniciar_proceso">
                    @csrf @method('post')
                    <button id="id_btn_iniciar_proceso" type="button" class="btn btn-success"> <i class="fas fa-arrow-alt-circle-right"></i> Iniciar proceso</button>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('js/p23_digitalizacion_archivo/tareas/descripcion.js') }}"></script>
    <script src="{{ asset('js/p23_digitalizacion_archivo/sweet_alert_general.js') }}"></script>
@endpush
