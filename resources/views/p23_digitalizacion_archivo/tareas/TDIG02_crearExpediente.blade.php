@extends('layouts.main')

@section('title', 'CREACIÓN DE EXPEDIENTE')

@section('aside_menu')
    @include('layouts.partials.main.aside_menu', ["asideMenu" =>
        [
            "item_seleccionado" => "tareas",
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
                'titulo' => 'Tareas',
                'ruta' => Route('tareas')
            ],
            2 => [
                'activo' => true,
                'titulo' => 'CREACIÓN DE EXPEDIENTE'
            ]
        ]
    ]])
@endsection

@section('contenido')
    @include('p23_digitalizacion_archivo.partials.detalles_proceso')
        <div class="card card-custom mt-5">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Ficha de expediente</h3>
                </div>
            </div>
            <div class="card-body">
                <form method="POST" id="form_crear_expediente">
                @csrf
                @method('post')
                    <div class="alert alert-custom alert-success" role="alert">
                        <div class="alert-icon"><i class="flaticon-warning"></i>
                        </div>
                        <div class="alert-text">
                            <strong>
                                <p class="mb-2">Instrucciones:</p>
                                <ul class="mb-0">
                                    <li>Busque y seleccione al empleado que tendra el expediente.</li>
                                    <li>Asegúrese de verificar el número de expediente ya que no se podrá editar después.</li>
                                    <li>Capture notas o comentarios sobre la creación de la ficha.</li>
                                </ul>
                            </strong>
                        </div>
                    </div>
                    <div>
                        <hr>
                        <div class="row my-2">
                            <div class="col-md-12">
                                <h4 class="card-label">Buscar empleado</h4>
                                @include("componentes.busqueda_empleado", [
                                    "existeEmpleado" => false,
                                ])
                            </div>
                        </div>
                        <hr>
                        <div class="row my-2">
                            <div class="col-md-4 align-middle">
                                <div class="form-group">
                                    <label class="titulo-dato" for=""><strong><span class="requeridos">*</span>Apellido paterno</strong></label>
                                    <input type="text" class="form-control form-control-solid form-control-sm normalizar-texto" name="apellido_paterno" readonly>
                                </div>
                            </div>
                            <div class="col-md-4 align-middle">
                                <div class="form-group">
                                    <label class="titulo-dato" for=""><strong><span class="requeridos">*</span>Apellido materno</strong></label>
                                    <input type="text" class="form-control form-control-solid form-control-sm normalizar-texto" name="apellido_materno" readonly>
                                </div>
                            </div>
                            <div class="col-md-4 align-middle">
                                <div class="form-group">
                                    <label class="titulo-dato" for=""><strong><span class="requeridos">*</span>Nombre(s)</strong></label>
                                    <input type="text" class="form-control form-control-solid form-control-sm normalizar-texto" name="nombre" readonly>
                                </div>
                            </div>
                            <div class="col-md-4 align-middle">
                                <div class="form-group">
                                    <label class="titulo-dato" for=""><strong><span class="requeridos">*</span>RFC</strong></label>
                                    <input type="text" class="form-control form-control-solid form-control-sm normalizar-texto" name="rfc" readonly>
                                </div>
                            </div>
                            <div class="col-md-4 align-middle">
                                <div class="form-group">
                                    <label class="titulo-dato" for=""><strong><span class="requeridos">*</span>Número de empleado</strong></label>
                                    <input type="text" class="form-control form-control-solid form-control-sm normalizar-texto" name="numero_empleado" readonly>
                                </div>
                            </div>
                            <div class="col-md-4 align-middle">
                                <div class="form-group">
                                    <label class="titulo-dato" for=""><strong><span class="requeridos">*</span>Número de expediente</strong></label>
                                    <input type="text" class="form-control form-control-sm normalizar-texto number" name="numero_expediente">
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row my-2">
                        <div class="col-md-12 align-middle">
                            <h4 class="card-label">Notas</h4>
                        </div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label class="titulo-dato" for="">Añadir notas</label>
                                <textarea rows="3" class="form-control form-control-sm normalizar-texto" name="notas"></textarea>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="titulo-dato text-white">a</label>
                                <button type="button" id="agregarNota" class="btn btn-primary w-100"><i class="fas fa-plus"></i>Agregar</button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="table-responsive">
                            <table width="100%" class="table table-bordered" id="tabla_notas"
                                data-toggle='table'
                                data-pagination="true"
                                data-page-size="5"
                                data-page-number="1"
                                data-page-list="[5,10,all]"
                                data-cache="false"
                            >
                                <thead>
                                    <tr>
                                        <th data-field="nota">
                                            <label class="titulo-dato text-center">Notas</label>
                                        </th>
                                        <th data-field="fecha" class="text-center">
                                            <label class="titulo-dato">Fecha</label>
                                        </th>
                                        <th data-field="accion" class="text-center">
                                            <label class="titulo-dato">Acción</label>
                                        </th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-footer">
                <div class="text-center">
                    <button id="finalizarTarea" name="seleccionar" class="btn btn-success" type="button">
                        <i class="fas fa-check-square"></i>Finalizar tarea
                    </button>
                    <button id="btn_cancelar_proceso" name="finalizar" class="btn btn-danger" type="button">
                        <i class="fas fa-times"></i>Cancelar proceso
                    </button>
                </div>
            </div>
        </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        var URL_crearExpediente = "{{ route('digitalizacion.archivos.creacion.expediente', [$digitalizacion, $instanciaTarea]) }}";
        var URL_cancelarProceso = "{{ route('cancelar.proceso.digitalizacion.archivo', [$digitalizacion, $instanciaTarea]) }}";
        var dataNotas = [];
    </script>
    <script src="{{ asset('js/p23_digitalizacion_archivo/sweet_alert_general.js') }}"></script>
    <script src="{{ asset('js/p23_digitalizacion_archivo/p23_general.js') }}"></script>
    <script src="{{ asset('js/p23_digitalizacion_archivo/tareas/TDIG02_crearExpediente.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
    <script src="{{ asset('js/componentes/busqueda_empleado.js') }}"></script>
@endpush

@push('styles')
    <link href="{{ asset('metronic/plugins/custom/bootstraptable/css/bootstrap-table.min.css') }}" type="text/css" rel="stylesheet"/>
@endpush