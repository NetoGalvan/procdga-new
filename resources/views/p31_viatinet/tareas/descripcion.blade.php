@extends('layouts.main')

@section('title', 'VIATINET')

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
                'titulo' => 'VIATINET - DESCRIPCIÓN'
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
                <h3 class="card-label">VIATINET</h3>
            </div>
        </div>
        <div class="card-body">
            <p class="text-justify">
                Te damos la bienvenida a VIATINET, el sistema institucional de control de Viáticos y Pasajes de la Dirección General de Administración de Personal y Desarrollo Administrativo, de la Secretaría de Administración y Finanzas de la Ciudad de México, por medio del cual podrás realizar los trámites de Viáticos y Pasajes para Comisiones Oficiales de forma sencilla y rápida.
            </p>
            <p class="text-justify">
                Requieres:
            </p>
            <p class="text-justify">
                1. Contar con sufiencia presupuestal. <br>
                2. Contar con el oficio a través del cual se designa a la o las personas comisionadas. <br>
                3. Contar con la información del comisionado, para el caso del personal de honorarios contar con copia del contrato vigente, y del acuse del documento de comisión firmado por el Titular del Ente Público. <br>
                4. Contar con tu firma electrónica, la cual te permitirá firmar las solicitudes, y continuar con la gestión.
            </p>
        </div>
        <div class="card-footer">
            <div class="text-center">
                <form id="id_form_iniciar_proceso" action="{{ route("viatinet.inicializar.proceso") }}" method="POST">
                    @csrf
                    <button id="id_btn_iniciar_proceso" type="button" class="btn btn-success"> <i class="fas fa-arrow-alt-circle-right"></i> Iniciar proceso</button>
                </form>
            </div>
        </div>
    </div> 
@endsection

@push('scripts')
    <script>
        formIniciarProceso = $("#id_form_iniciar_proceso");
        btnIniciarProceso = $("#id_btn_iniciar_proceso");

        btnIniciarProceso.click(function() {
            Swal.fire({
                title: "¿Está seguro?",
                text: "Se inicializará el proceso",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Sí, continuar",
                cancelButtonText: "Cancelar",
                reverseButtons: true
            }).then(function(result) {
                if (result.value) {
                    formIniciarProceso.submit();
                }
            });
        });
    </script>
@endpush