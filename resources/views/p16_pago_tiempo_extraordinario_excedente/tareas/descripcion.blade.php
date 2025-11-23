@extends('layouts.main')

@section('title', 'Tiempo Extra/Excedente - Descripción')

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
                'titulo' => 'Pago de Tiempo Extaordinario y Excedente - Descripción'
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
    <div class="card card-custom">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label user-select-none">Pago de tiempo extra</h3>
            </div>
        </div>
        <div class="card-body">
            <p class="text-justify">
                Proceso que permite asignar el presupuesto anual designado para el pago de tiempos extraordinarios y excedentes a las diferentes Unidades Administrativas.
                La distribución del presupuesto se hace mediante horas efectivamente laboradas, las cuales deben ser revisadas y autorizadas para poder ser pagadas en su totalidad.
            </p>
        </div>
        <div class="card-footer">
            <div class="text-center">
                <form action="{{ route('tiempo.extraordinario.excedente.inicializar.proceso') }}" method="POST" id="form_iniciar_proceso_p16">
                    @csrf @method('post')
                    <button id="btn_iniciar_proceso_p16" type="button" class="btn btn-success"> <i class="fas fa-arrow-alt-circle-right"></i> Iniciar proceso</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/p16_pago_tiempo_extraordinario_excedente/tareas/descripcion.js?v=1.0.4') }}"></script>
@endpush
