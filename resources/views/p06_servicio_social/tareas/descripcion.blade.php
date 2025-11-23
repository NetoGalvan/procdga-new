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
                <h3 class="card-label">Servicio Social</h3>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <p class="text-justify">
                        Proceso diseñado para facilitar el tramite y gestión de los prestadores en la Secretaria de Finanzas
                    </p>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="text-center">
                <form action="{{ route('servicio.social.iniciar.proceso') }}" method="POST" id="id_form_iniciar_proceso">
                    @csrf
                    <button id="id_btn_iniciar_proceso" type="button" class="btn btn-success"> <i class="fas fa-arrow-alt-circle-right"></i> Iniciar proceso</button>
                </form>
            </div>
        </div>
    </div>

@endsection
@push('scripts')
<script src="{{ asset('js/p06_servicio_social/general_swal_alert.js') }}"></script>
<script src="{{ asset('js/p06_servicio_social/tareas/descripcion.js?v=1.1') }}"></script>
@endpush
