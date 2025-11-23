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
    <form method="POST" id="form_finalizar_tarea" action="{{ route("tramite.incidencia.formato.solicitud", [$tramiteIncidencia, $instanciaTarea]) }}">
        @csrf
        <div class="card card-custom">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Detalle del proceso</h3>
                </div>
            </div>
            <div class="card-body">
                @include("p12_tramites_incidencias.partials.datos_general", [
                    "secciones" => ["general", "captura", "empleado", "jefe", "observaciones", "incidencia"]
                ])
            </div>
        </div>
        <div class="card card-custom mt-8">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Descargar e imprimir el formato de la incidencia</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="alert alert-custom alert-success mb-8" role="alert">
                    <div class="alert-icon mr-4"><i class="flaticon-warning"></i></div>
                    <div class="alert-text">
                        <strong>
                            <p class="mb-2">Instrucciones:</p>
                            <ul class="mb-2">
                                <li>Imprimir el formato que se relaciona con el trámite.</li>
                                <li>Llevar el formato impreso al jefe inmediato para su firma.</li>
                                <li>Entregar el formato firmado al enlace asignado.</li>
                            </ul>
                            <p class="mb-0">Una vez entregado el formato firmado al enlace, el trámite continuará.</p>
                        </strong>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <a href="{{ route("tramite.incidencia.descargarFormatoSolicitud", $tramiteIncidencia) }}" class="btn btn-primary" id="btn_descargar_formato"><i class="fas fa-download"></i> Descargar formato</a>
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
    
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
    <script src="{{ asset('js/p12_tramites_incidencias/partials/tabla_incidencias_empleado.js?v=1.7') }}"></script>
    <script src="{{ asset('js/p12_tramites_incidencias/partials/cancelar_proceso.js?v=1.0') }}"></script>
    <script src="{{ asset('js/p12_tramites_incidencias/tareas/T03_formatoSolicitud.js?v=1.1') }}"></script>
    <script>
        const incidenciasEmpleado = @json($incidenciasEmpleado);
        const tablaIncidenciasEmpleado = $("#tabla_incidencias_empleado");
        tablaIncidenciasEmpleado.bootstrapTable({data: incidenciasEmpleado});
    </script>
@endpush