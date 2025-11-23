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
                <h3 class="card-label">REPORTES DÍAS EFECTIVAMENTE LABORADOS</h3>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <p>
                        Bienvenido a este proceso que está diseñado para ejecutar los siguientes reportes:
                    </p>
                    <p>
                        <ul>
                            <li>1. Reporte de multas federales</li>
                            <li>2. Reporte de multas locales</li>
                            <li>3. Reporte de escalafón</li>
                        </ul>
                    </p>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="text-center">
                <form action="{{ route('reportes.dias.efectivamente.laborados.iniciar.proceso') }}" method="POST" id="form_iniciar_proceso_p22_reportes">
                @csrf 
                @method('post')
                    <button id="btn_iniciar_proceso_p22_reportes" type="button" class="btn btn-success"> <i class="fas fa-arrow-alt-circle-right"></i> Iniciar proceso</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/p22_reportes_dias_efectivamente_laborados/general_swal_alert.js') }}"></script>
    <script src="{{ asset('js/p22_reportes_dias_efectivamente_laborados/tareas/descripcion.js') }}"></script>
@endpush
