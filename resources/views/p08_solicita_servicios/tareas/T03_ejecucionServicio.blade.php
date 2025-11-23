@extends('layouts.main')

@section('title', 'Ejecución')

@section('subheader')
    @include('layouts.partials.main.subheader', ["subheader" => [
        "titulo_subheader" => "PROCDGA",
        "icono_titulo_subheader" => "far fa-folder-open",
        "breadcrumbs" => [
            1 => [
                'activo' => false,
                'titulo' => 'Tareas disponibles',
                'ruta' => Route('tareas')
            ],
            2 => [
                'activo' => true,
                'titulo' => 'Ejecución'
            ]
        ]
    ]])
@endsection

@section('aside_menu')
    @include('layouts.partials.main.aside_menu', ["asideMenu" =>
        [
            "item_seleccionado" => "tareas",
        ]
    ])
@endsection

@section('contenido')

        <form method="POST" id="form_ejecucion_servicio" action="{{ route('solicitud.servicio.ejecucion.servicio', [$solicitaServicio->p08_solicita_servicio_id, $instanciaTarea->instancia_tarea_id]) }}">
            @method('post')
            @csrf
            <div class="card card-custom mb-5">
                <div class="card-header">
                    <div class="card-title">
                        <h3 class="card-label">Ejecución del servicio</h3>
                    </div>
                </div>
                <div class="card-body">
                    <div class="alert alert-custom alert-outline-success" role="alert">
                        <div class="alert-icon"><i class="flaticon-warning"></i></div>
                        <div class="alert-text">
                            Debes registrar los avances que a llevado a cabo de los servicios realizados
                        </div>
                    </div>
                    <p> <span class="requeridos">Campos obligatorios (*)</span> </p>
                </div>
            </div>

            {{-- Input recibe arreglo de datos de la tabla --}}
            <input type="hidden" id="arreglo_servicio" name="arreglo_servicio" value="">
            <div class="card card-custom mb-5">
                <div class="card-header card-header-tabs-line">
                    <div class="card-toolbar">
                        <ul class="nav nav-tabs nav-bold nav-tabs-line">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#kt_tab_datos_solicitud">
                                <span class="nav-icon"><i class="flaticon2-list-1"></i></span>
                                <span class="nav-text">Datos de la solicitud</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#kt_tab_datos_prestar_servicio">
                                <span class="nav-icon"><i class="flaticon2-map"></i></span>
                                <span class="nav-text">Detalle donde se prestará el servicio</span>
                                </a>
                            </li>
                            @if ( $solicitaServicio->servicioGeneral->clave == "mantenimiento" || $solicitaServicio->servicioGeneral->clave == "telefonia" )
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#kt_tab_datos_imagenes_servicio">
                                    <span class="nav-icon"><i class="flaticon2-photograph"></i></span>
                                    <span class="nav-text">Imagenes evidencia</span>
                                    </a>
                                </li>
                            @endif
                            @if ( $solicitaServicio->servicioGeneral->clave == "reproduccion" )
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#kt_tab_datos_pdf_servicio">
                                <span class="nav-icon"><i class="flaticon2-document"></i></span>
                                <span class="nav-text">Archivo</span>
                                </a>
                            </li>
                        @endif
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="kt_tab_datos_solicitud" role="tabpanel" aria-labelledby="kt_tab_datos_solicitud">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="titulo-dato"> Folio: </label>
                                    <span class="valor-dato"> <b> {{ $solicitaServicio->folio }} </b> </span>
                                </div>
                                <div class="col-md-4">
                                    <label class="titulo-dato"> Servicio solicitado: </label>
                                    <span class="valor-dato"> <b> {{ mb_strtoupper($solicitaServicio->servicioGeneral->nombre_servicio_general) }} </b> </span>
                                </div>
                                @if ($solicitaServicio->servicio_id)
                                <div class="col-md-4">
                                    <label class="titulo-dato"> Tipo de servicio: </label>
                                    <span class="valor-dato"> <b> {{ mb_strtoupper($solicitaServicio->servicio->nombre_servicio) }} </b> </span>
                                </div>
                                @endif
                                <div class="col-md-4">
                                    <label class="titulo-dato"> Área que solicitó el servicio: </label>
                                    <span class="valor-dato"> <b> {{ $solicitaServicio->area->identificador }} - {{ $solicitaServicio->area->nombre }} </b> </span>
                                </div>
                                <div class="col-md-4">
                                    <label class="titulo-dato"> Prioridad: </label>
                                    @if ( $solicitaServicio->urgente )
                                        <span class="badge badge-danger">URGENTE</span>
                                    @else
                                        <span class="badge badge-success">NORMAL</span>
                                    @endif
                                </div>
                                @if ( $solicitaServicio->cantidad_solicitud )
                                    <div class="col-md-4">
                                        <label class="titulo-dato"> Cantidad: </label>
                                        <span class="valor-dato"> <b> {{ $solicitaServicio->cantidad_solicitud }} </b> </span>
                                    </div>
                                @endif
                            </div>
                            <div class="row" >
                                <div class="col-md-12 form-group">
                                    <label for="texto_solicitud" class="titulo-dato"> Descripción de la solicitud de servicio: </label>
                                    <div>{!! isset($solicitaServicio->texto_solicitud) ? $solicitaServicio->texto_solicitud : '' !!}</div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="kt_tab_datos_prestar_servicio" role="tabpanel" aria-labelledby="kt_tab_datos_prestar_servicio">
                            <div class="row">

                                <div class="col-md-4">
                                    <label class="titulo-dato"> Nombre del contacto: </label>
                                    <span class="valor-dato"> <b> {{ mb_strtoupper($solicitaServicio->contacto_servicio) }} </b> </span>
                                </div>
                                <div class="col-md-4">
                                    <label class="titulo-dato"> Correo del contacto: </label>
                                    <span class="valor-dato"> <b> {{ $solicitaServicio->contacto_correo }} </b> </span>
                                </div>
                                <div class="col-md-4">
                                    <label class="titulo-dato"> Subárea: </label>
                                    <span class="valor-dato"> <b> {{ mb_strtoupper($solicitaServicio->sub_area) }} </b> </span>
                                </div>
                                <div class="col-md-4">
                                    <label class="titulo-dato"> Teléfono: </label>
                                    <span class="valor-dato"> <b> {{ $solicitaServicio->telefono_servicio }} </b> </span>
                                </div>
                                <div class="col-md-4">
                                    <label class="titulo-dato"> Ext: </label>
                                    <span class="valor-dato"> <b> {{ $solicitaServicio->ext_servicio }} </b> </span>
                                </div>
                                <div class="col-md-4">
                                    <label class="titulo-dato"> Creador de solicitud: </label>
                                    <span class="valor-dato"> <b> {{ mb_strtoupper($solicitaServicio->creado_por_nombre_completo) }} </b> </span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <label class="titulo-dato"> Dirección: </label>
                                    <span class="valor-dato"> <b> {{ $solicitaServicio->direccion_servicio }} </b> </span>
                                </div>
                            </div>

                        </div>

                        @if ( $solicitaServicio->servicioGeneral->clave == "mantenimiento" || $solicitaServicio->servicioGeneral->clave == "telefonia" )
                            <div class="tab-pane fade" id="kt_tab_datos_imagenes_servicio" role="tabpanel" aria-labelledby="kt_tab_datos_imagenes_servicio">
                                <div class="row">
                                    <div class="col-md-12 text-center">

                                        @if ( count($imagenes) > 0 )
                                            @foreach ($imagenes as $imagen)
                                                <a href="data:image/jpeg;base64,{{$imagen}}" data-lightbox="galeria">
                                                    <img src="data:image/jpeg;base64,{{$imagen}}" alt="Imagen" class="mr-5" alt="Imagen" width="250" height="auto" class="mr-5" alt="Imagen" width="250" height="200">
                                                </a>
                                            @endforeach
                                        @else
                                            <div class="alert alert-custom alert-outline-success" role="alert">
                                                <div class="alert-icon"><i class="flaticon-warning"></i></div>
                                                <div class="alert-text">
                                                    No hay imagenes capturadas para esta solicitud de servicio
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if ( $solicitaServicio->servicioGeneral->clave == "reproduccion" )
                            <div class="tab-pane fade" id="kt_tab_datos_pdf_servicio" role="tabpanel" aria-labelledby="kt_tab_datos_pdf_servicio">
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        @if ( count($imagenes) > 0 )
                                            @foreach ($imagenes as $imagen)
                                                <button type="button" class="btn btn-success" onclick="mostrarPDF('{{ $imagen }}')">Ver archivo</button>
                                            @endforeach
                                        @else
                                            <div class="alert alert-custom alert-outline-success" role="alert">
                                                <div class="alert-icon"><i class="flaticon-warning"></i></div>
                                                <div class="alert-text">
                                                    No hay archivo capturado para esta solicitud de servicio
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            @if ( $solicitaServicio->comentarios_rechazo )
                <div class="card card-custom mb-5">
                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="card-label">Comentarios de inconformidad del área que recibió el servicio</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <div>{!!$solicitaServicio->comentarios_rechazo!!}</div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif


            <div class="card card-custom mb-5">

                <div class="card-header">
                    <div class="card-title">
                        <h3 class="card-label">Captura de avances en: {{ $solicitaServicio->servicioGeneral->nombre_servicio_general }}</h3>
                    </div>
                </div>
                <div class="card-body">
                    <div id="mensajeGuardarAvance" ></div>
                    <div class="table-responsive mb-3">
                        <table id="table" data-toggle="table" data-toolbar="#toolbar" data-unique-id="id">
                            <thead>
                                <tr>
                                    {{-- <th data-field="servicio_id" class="text-center" data-sortable="true"><label class="titulo-dato">Id</label></th> --}}
                                    <th data-field="tipo_servicio" class="text-uppercase text-center"><label class="titulo-dato">Tipo servicio</label></th>
                                    <th data-field="descripcion_servicio" class="text-center"><label class="titulo-dato">Descripción servicio</label></th>
                                    <th data-field="unidad" class="unidad text-center" ><label class="titulo-dato">Unidad</label></th>
                                    <th data-field="fecha_estimada" class="text-center"><label class="titulo-dato">Fecha estimada</label></th>

                                    <th data-field="fecha_entrega" class="text-center" data-formatter="fechaEntregaFormatter"><label class="titulo-dato">Fecha completado</label></th>
                                    <th data-field="comentarios_servicio" class="text-center" data-formatter="comentariosServicioFormatter"><label class="titulo-dato">Comentarios de la entrega</label></th>
                                    <th data-field="estatus_detalle" class="text-center" data-formatter="estatusDetalleFormatter"><label class="titulo-dato">Estado de la ejecución</label></th>

                                    <th data-field="asignado_a" class="text-center" data-formatter="asignadoAFormatter"><label class="titulo-dato">Asignado a</label></th>
                                    <th data-field="confirmado_por" class="text-center" data-formatter="confirmadoPorFormatter"><label class="titulo-dato">Confirmado por</label></th>

                                    <th class="text-center" data-formatter="guardarAvanceFormatter"><label class="titulo-dato">Acciones</label></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <p>
                        Esta pantalla le permite capturar completa o parcialmente la fecha y el estado de los entregables que usted y el área usuaria acordaron anteriormente.
                    </p>
                    <p>
                        Puede regresar las veces que sea necesario a esta tarea para guardar un avance parcial. Al finalizar oprima el botón "Guardar avance".
                    </p>
                    <p>
                        La tarea se considerará lista para terminar cuando todos los entregables tengan un estado de entrega definido; de lo contrario, el oprimir el botón de "Finalizar tarea" no tendrá efecto.
                    </p>

                    @if ($solicitaServicio->servicioGeneral->clave == 'telefonia')
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label class="titulo-dato"><strong><span class="requeridos">* </span> Comentarios adicionales: </strong></label>
                                <textarea class="form-control normalizar-texto" id="comentario_privado" name="comentario_privado" rows="3" required></textarea>
                            </div>
                        </div>
                    @endif

                </div>

                <div class="card-footer">
                    <div class="text-center">
                        <a type="button" id="descargar_ejecucion_servicio" href="{{ route('solicitud.servicio.generar.descargar.detalle.servicios', $solicitaServicio->p08_solicita_servicio_id) }}" class="btn btn-primary" data-toggle="tooltip" title="Descargar pdf"> <i class="far fa-file-pdf"></i> Descargar detalle </a>
                        <button type="button" id="bnt_finaliza_ejecucion_servicios" class="btn btn-success"><i class="fas fa-check-square"></i> Finalizar proceso </button>
                    </div>
                </div>

            </div>

        </form>

    <!-- Inicio Modal PDF -->
    <div id="pdfModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title">Archivo PDF</h5>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
                <div class="modal-body">
                <iframe id="pdfmodal" src="" style="width:100%; height:80vh;"></iframe>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin Modal PDF -->
@endsection

@push('styles')
    <link href="{{ asset('metronic/plugins/custom/bootstraptable/css/bootstrap-table.min.css') }}" type="text/css" rel="stylesheet"/>
    <link href="{{ asset('metronic/plugins/custom/lightbox2/src/css/lightbox.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .unidad label {
        width:180px;
        }
    </style>
@endpush

@push('scripts')
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
    <script src="{{ asset('js/p08_solicita_servicios/tareas/T03_ejecucionServicio.js?ver=1.0') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/lightbox2/src/js/lightbox.js') }}"></script>
    <script>
        const detalleSolicitaServicio = @json($detalleSolicitaServicio);
        const claveServicio = @json($solicitaServicio->servicioGeneral->clave);
        const urlGuardaAvances = @json(route('guardar.avances.servicios'));
    </script>
@endpush
