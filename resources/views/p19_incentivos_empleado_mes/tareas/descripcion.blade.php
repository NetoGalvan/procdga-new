@extends('layouts.main')

@section('title', 'INCIDENCIAS - DESCRIPCIÓN')

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
                'titulo' => 'INCIDENCIAS - DESCRIPCIÓN'
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
                <h3 class="card-label">Incentivo Empleado del mes</h3>
            </div>
        </div>
        <div class="card-body">
            <p class="text-justify">
                Bienvenido, este proceso está diseñado para facilitar y agilizar el trámite de "Pago de premio incentivo empleado del mes".
            </p>
        </div>
        <div class="card-footer">
            <div class="text-center">
                <form id="id_form_iniciar_proceso" action="{{ route('incentivos.empleado.mes.iniciar.proceso') }}" method="POST">
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
