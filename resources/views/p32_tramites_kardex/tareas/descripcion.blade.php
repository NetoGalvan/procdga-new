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
                <h3 class="card-label">Trámites Kardex</h3>
            </div>
        </div>
        <div class="card-body">
            <p class="text-justify">
                Proceso para seleccionar y llevar a cabo la gestión de los <b> Trámites Kardex </b>
            </p>
        </div>
        <div class="card-footer">
            <div class="text-center">
                <form id="id_form_iniciar_proceso" action="{{ route('tramites.kardex.iniciar.proceso') }}" method="POST">
                    @csrf
                    <button id="id_btn_iniciar_proceso" type="button" class="btn btn-success"><i class="fas fa-check-square"></i> Iniciar proceso</button>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('js/p32_tramites_kardex/tareas/descripcion.js') }}"> </script>
@endpush
