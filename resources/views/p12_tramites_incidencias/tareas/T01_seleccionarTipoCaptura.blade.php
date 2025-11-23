@extends("layouts.main")

@section("title", $instanciaTarea->tarea->nombre)

@section("subheader")
    @include("layouts.partials.main.subheader", ["subheader" => [
        "titulo_subheader" => "PROCDGA",
        "icono_titulo_subheader" => "far fa-folder-open",
        "breadcrumbs" => [
            1 => [
                "activo" => false,
                "titulo" => "Tareas disponibles",
                "ruta" => Route('tareas')
            ],
            2 => [
                "activo" => true,
                "titulo" => $instanciaTarea->tarea->nombre
            ]
        ]
    ]])
@endsection

@section('aside_menu')
    @include('layouts.partials.main.aside_menu', ["asideMenu" => ["item_seleccionado" => "tareas"]])
@endsection

@section('contenido')
    <form method="POST" id="form_finalizar_tarea" action="{{ route("tramite.incidencia.seleccionar.tipo.captura", [$tramiteIncidencia, $instanciaTarea]) }}">
        @csrf
        <div class="card card-custom">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Detalle del proceso</h3>
                </div>
            </div>
            <div class="card-body">
                @include("p12_tramites_incidencias.partials.datos_general", [
                    "secciones" => ["general"]
                ])
            </div>
        </div>
        <div class="card card-custom mt-8">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Seleccionar el tipo de captura</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="alert alert-custom alert-success" role="alert">
                    <div class="alert-icon mr-4"><i class="flaticon-warning"></i></div>
                    <div class="alert-text">
                        <strong>
                            <p class="mb-2">Instrucciones:</p>
                            <ul class="mb-0">
                                <li>Seleccione el tipo de captura: Alta, aplicación de notas buenas o cancelación.</li>
                                <li>Ingrese al empleado al que se aplicará la incidencia.</li>
                            </ul>
                        </strong>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="tipo_captura" class="titulo-dato"><span class="requeridos">* </span> <b> Tipos de captura </b> </label>
                        <select class="form-control text-uppercase" name="tipo_captura_id" autocomplete="off" required>
                            <option value=""> Seleccione una opción </option>
                            @foreach ($tiposCaptura as $tipoCaptura)
                                @if (old("tipo_captura_id") && old("tipo_captura_id") == $tipoCaptura->tipo_captura_id)
                                    <option class="text-uppercase" value="{{ $tipoCaptura->tipo_captura_id }}" selected> {{ $tipoCaptura->nombre }} </option>
                                @else
                                    <option class="text-uppercase" value="{{ $tipoCaptura->tipo_captura_id }}" > {{ $tipoCaptura->nombre }} </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 form-group">
                        @if (in_array($tramiteIncidencia->tipo_tramite, ["INCIDENCIA_INDIVIDUAL", "INCIDENCIA_INDIVIDUAL_ADMIN"]))
                            @include("componentes.busqueda_empleado", [
                                "existeEmpleado" => false,
                            ])
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="text-center">
                    <button type="submit" class="btn btn-success mr-2"><i class="fas fa-check-square"></i> Finalizar tarea </button>
                    <button type="button" class="btn btn-danger" id="btn_cancelar"><i class="fas fa-times"></i> Cancelar proceso </button>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script src="{{ asset('js/componentes/busqueda_empleado.js') }}"></script>
    <script src="{{ asset('js/p12_tramites_incidencias/partials/cancelar_proceso.js?v=1.0') }}"></script>
    <script src="{{ asset('js/p12_tramites_incidencias/tareas/T01_seleccionarTipoCaptura.js?v=1.0') }}"></script>
@endpush
