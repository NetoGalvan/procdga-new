@extends('layouts.main')

@section('title', 'DESCRIPCIÓN')

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

@section('aside_menu')
    @include('layouts.partials.main.aside_menu', ["asideMenu" =>
        [
            "item_seleccionado" => "procesos",
        ]
    ])
@endsection

@section('contenido')

    <div class="row">
        <div class="col-12">
            <div class="card card-custom mb-5">
                <div class="card-header">
                    <div class="card-title">
                        <h3 class="card-label">Nómina de servicio social</h3>
                    </div>
                </div>
                <div class="card-body">
                    <p class="text-justify">
                        Bienvenido a proceso de Nómina del servicio social y prácticas profesionales.
                    </p>
                    <p class="text-justify">
                        Usted podrá:
                        <ul>
                            <li>Asignar tareas a los Subdirectores de Enlace Administrativo para la validación de la nómina de servicio social.</li>
                            <li>Generar los archivos XLS para la solicitud de fondos a Recursos Financieros.</li>
                        </ul>
                    </p>
                </div>
                <div class="card-footer">
                    <div class="text-center">
                        <form action="{{ route('servicio.social.nomina.iniciar.proceso') }}" method="POST" id="id_form_iniciar_proceso_nomina">
                            @csrf
                            <button id="id_btn_iniciar_proceso_nomina" type="button" class="btn btn-success"> <i class="fas fa-arrow-alt-circle-right"></i> Iniciar proceso</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('scripts')
<script src="{{ asset('js/p06_servicio_social/general_swal_alert.js') }}"></script>
<script src="{{ asset('js/p06_servicio_social/sub_proceso/descripcion_nomina.js') }}"></script>
@endpush
