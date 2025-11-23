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

@push('styles')
    <link href="{{ asset('metronic/plugins/custom/bootstraptable/css/bootstrap-table.min.css') }}" type="text/css" rel="stylesheet"/>
@endpush

@section('contenido')
    <div class="card card-custom">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">Detalle del proceso</h3>
            </div>
        </div>
        <div class="card-body">
            @include("p12_tramites_incidencias.partials.datos_general_incidencia_grupal", [
                "secciones" => ["general"]
            ])
        </div>
    </div>
    <form method="POST" id="form_finalizar_tarea" action="{{ route("tramite.incidencia.grupal.tipo.captura", [$tramiteIncidencia, $instanciaTarea]) }}">
        @csrf
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
                                <li>Seleccione el tipo de captura: Alta o cancelación.</li>
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
    <script>
        const rutaGetEmpleados = @json(route("tramite.incidencia.getEmpleadosCumplenCondicion", $tramiteIncidencia));    
    </script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
    <script src="{{ asset('js/p12_tramites_incidencias/partials/cancelar_proceso.js?v=1.0') }}"></script>
    <script src="{{ asset('js/p12_tramites_incidencias/tareas/incidencia_grupal/T01_seleccionarTipoCaptura.js?v=1.0') }}"></script>
@endpush
