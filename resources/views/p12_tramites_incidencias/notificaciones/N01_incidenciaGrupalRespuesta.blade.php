@extends("layouts.main")

@section("title", $instanciaTarea->tarea->nombre)

@section("subheader")
    @include("layouts.partials.main.subheader", ["subheader" => [
        "titulo_subheader" => "PROCDGA",
        "icono_titulo_subheader" => "far fa-folder-open",
        "breadcrumbs" => [
            1 => [
                "activo" => false,
                "titulo" => "Notificaciones disponibles",
                "ruta" => Route('notificaciones')
            ],
            2 => [
                "activo" => true,
                "titulo" => $instanciaTarea->tarea->nombre
            ]
        ]
    ]])
@endsection

@section('aside_menu')
    @include('layouts.partials.main.aside_menu', ["asideMenu" => ["item_seleccionado" => "notificaciones"]])
@endsection

@push('styles')
    <link href="{{ asset('metronic/plugins/custom/bootstraptable/css/bootstrap-table.min.css') }}" type="text/css" rel="stylesheet"/>
@endpush

@section('contenido')
    <form method="POST" id="form_finalizar_tarea" action="{{ route("tramite.incidencia.grupal.respuesta", [$tramiteIncidencia, $instanciaTarea]) }}">
        @csrf
        <div class="card card-custom">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Detalle del proceso</h3>
                </div>
            </div>
            <div class="card-body">
                @include("p12_tramites_incidencias.partials.datos_general_incidencia_grupal", [
                    "secciones" => ["general", "tipo_captura", "incidencia", "empleados", "estatus"]
                ])
            </div>
            <div class="card-footer">
                <div class="text-center">
                    <button type="submit" class="btn btn-success"><i class="fas fa-check-square"></i> Enterado, eliminar notificación</button>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        const urlGetIncidenciasEmpleado = @json(route("tramite.incidencia.grupal.getIncidenciasEmpleados", $tramiteIncidencia));
    </script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
    <script src="{{ asset('js/p12_tramites_incidencias/partials/incidencia_grupal/tabla_incidencias_empleado.js?v=1.9') }}"></script>
    <script src="{{ asset('js/p12_tramites_incidencias/notificaciones/N01_incidenciaGrupalRespuesta.js?v=1.0') }}"></script>
@endpush