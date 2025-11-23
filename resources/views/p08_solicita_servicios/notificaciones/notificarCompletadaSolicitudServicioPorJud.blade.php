@extends('layouts.main')

@section('title', 'Completada solicitud de servicio')

@section('subheader')
    @include('layouts.partials.main.subheader', ["subheader" => [
        "titulo_subheader" => "PROCDGA",
        "icono_titulo_subheader" => "far fa-folder-open",
        "breadcrumbs" => [
            1 => [
                'activo' => false,
                'titulo' => 'Notificaciones disponibles',
                'ruta' => Route('notificaciones')
            ],
            2 => [
                'activo' => true,
                'titulo' => 'Completada solicitud de servicio'
            ]
        ]
    ]])
@endsection

@section('aside_menu')
    @include('layouts.partials.main.aside_menu', ["asideMenu" =>
        [
            "item_seleccionado" => "notificaciones",
        ]
    ])
@endsection

@section('contenido')

    <form method="POST" id="form_notificacion" action="{{ route('solicitud.servicio.notificacion.completada.jud', [$solicitaServicio, $instanciaTarea]) }}">
        @method('post')
        @csrf

        <div class="card card-custom mb-5">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Notificación - Completada Solicitud de Servicio</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="alert alert-custom alert-outline-success" role="alert">
                    <div class="alert-icon"><i class="flaticon-warning"></i></div>
                    <div class="alert-text">
                        Solicitud de Servicio de <b> {{ $solicitaServicio->servicioGeneral->nombre_servicio_general }} </b> será atendida <br>
                    </div>
                </div>
            </div>
        </div>

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
                            @if ( $solicitaServicio->comentarios_rechazo )
                                <div class="col-md-6 form-group">
                                    <label for="texto_solicitud" class="titulo-dato"> Descripción de la solicitud de servicio: </label>
                                    <div>{!!$solicitaServicio->texto_solicitud!!}</div>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="texto_solicitud" class="titulo-dato"> Comentarios solicitando corrección de entregables: </label>
                                    <div>{!!$solicitaServicio->comentarios_rechazo!!}</div>
                                </div>
                            @else
                                <div class="col-md-12 form-group">
                                    <label for="texto_solicitud" class="titulo-dato"> Descripción de la solicitud de servicio: </label>
                                    <div>{!! isset($solicitaServicio->texto_solicitud) ? $solicitaServicio->texto_solicitud : '' !!}</div>
                                </div>
                            @endif
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

        <div class="card card-custom mb-5">

            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Entregas realizadas para el servicio solicitado</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center"><label class="titulo-dato"> Partida </label></th>
                                <th scope="col" class="text-center"><label class="titulo-dato"> Tipo de servicio </label></th>
                                <th scope="col" class="text-center"><label class="titulo-dato"> Descripción del servicio </label></th>
                                <th scope="col" class="text-center"><label class="titulo-dato"> Unidad </label></th>
                                <th scope="col" class="text-center"><label class="titulo-dato"> Fecha estimada </label></th>
                                <th scope="col" class="text-center"><label class="titulo-dato"> Fecha completado </label></th>
                                <th scope="col" class="text-center"><label class="titulo-dato"> Estado de la ejecución </label></th>
                                <th scope="col" class="text-center"><label class="titulo-dato"> Comentarios de entrega </label></th>
                                <th scope="col" class="text-center"><label class="titulo-dato"> Asignado a </label></th>
                                <th scope="col" class="text-center"><label class="titulo-dato"> Confirmado por </label></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($detalleSolicitaServicio as $key => $detalleServicio)
                            <tr>
                                <th scope="row" class="text-center">{{ ( $i <= $registros ) ? $i++ : '' }}</th>
                                <td class="text-uppercase text-center"> {{ $detalleServicio->servicio->nombre_servicio }} </td>
                                <td class="text-center"> {{ $detalleServicio->descripcion_servicio }} </td>
                                <td class="text-center"> {{ $detalleServicio->unidad }} </td>
                                <td class="text-center"> {{ $detalleServicio->fecha_estimada }} </td>
                                <td class="text-center"> {{ $detalleServicio->fecha_entrega }} </td>
                                <td class="text-center">
                                    @if ($detalleServicio->estatus_detalle == 'PARCIAL')
                                        SERVICIO PRESTADO PARCIALMENTE
                                    @endif
                                    @if ( $detalleServicio->estatus_detalle == 'COMPLETADO' )
                                        SERVICIO PRESTADO EXITOSAMENTE
                                    @endif
                                    @if ( $detalleServicio->estatus_detalle == 'RECHAZADO' )
                                        SERVICIO NO REALIZADO
                                    @endif
                                    @if ( $detalleServicio->estatus_detalle == 'EN_PROCESO' )
                                        EN PROCESO
                                    @endif
                                </td>
                                <td> {{ $detalleServicio->comentarios_servicio }} </td>
                                 <td class="text-center"> {{ $detalleServicio->asignado_a }} </td>
                                <td class="text-center"> {{ $detalleServicio->confirmado_por }} </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <div class="text-center">
                    <button type="button" id="btn_finalizar_notificacion" class="btn btn-success"><i class="fas fa-check-square"></i> Enterado, eliminar notificación </button>
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
    <link href="{{ asset('metronic/plugins/custom/lightbox2/src/css/lightbox.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('scripts')
<script src="{{ asset('js/p08_solicita_servicios/notificaciones/notificacionesSolicitudServicioGeneral.js?ver=1.0') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/lightbox2/src/js/lightbox.js') }}"></script>
@endpush
