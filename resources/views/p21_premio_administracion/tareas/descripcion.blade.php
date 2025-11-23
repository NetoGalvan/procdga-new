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
                'titulo' => 'PREMIO DE ADMINISTRACIÓN - DESCRIPCIÓN'
            ]
        ]
    ]])
@endsection

@section('contenido')

    <div class="card card-custom mb-5">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">Proceso de convocatoria al Premio de Administración</h3>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <p>
                        El proceso Premio de Administración le permite:
                        <ul>
                            <li>Lanzar la convocatoria al Premio de Administración para una unidad administrativa.</li>
                            <li>Dar seguimiento de los empleados inscritos al Premio de Administración para la unidad administrativa dada.</li>
                            <li>Llenar los resultados de asignación de premios luego de la sesión del comité de evaluación de la unidad administrativa dada.</li>
                            <li>Avisar a la unidad administrativa los resultados de la asignación de premios.</li>
                            <li>Recibir controversias sobre el premio de administración en una unidad administrativa dada.</li>
                            <li>Capturar y notificar del resultado final de la asignaición de premios a la unidad adminsitrativa dada.</li>
                        </ul>
                    </p>
                </div>
                <div class="col-md-12">
                    <p>
                        <b>RECUERDE: Sólo puede ejecutarse un proceso de Premio de Administración por unidad administrativa a la vez. <br> ¡Gracias! </b>
                    </p>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="text-center">
                <form action="{{ route('premio.administracion.inicializar.proceso') }}" method="POST" id="form_iniciar_proceso_p21">
                    @csrf @method('post')
                    <button id="btn_iniciar_proceso_p21" type="button" class="btn btn-success"> <i class="fas fa-arrow-alt-circle-right"></i> Iniciar proceso</button>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('js/p21_premio_administracion/tareas/descripcion.js') }}"></script>
@endpush
