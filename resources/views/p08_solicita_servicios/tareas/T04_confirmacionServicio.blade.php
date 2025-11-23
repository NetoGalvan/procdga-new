@extends('layouts.main')

@section('title', 'Confirmación de recepción')

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
                'titulo' => 'Confirmación de recepción'
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

        <form method="POST" id="form_confirmacion_servicio" action="{{ route('solicitud.servicio.confirmacion.servicio', [$solicitaServicio->p08_solicita_servicio_id, $instanciaTarea->instancia_tarea_id]) }}">
            @method('post')
            @csrf

            <div class="card card-custom mb-5">
                <div class="card-header">
                    <div class="card-title">
                        <h3 class="card-label">Confirmación de recepción del servicio</h3>
                    </div>
                </div>
                <div class="card-body">
                    <div class="alert alert-custom alert-outline-success" role="alert">
                        <div class="alert-icon"><i class="flaticon-warning"></i></div>
                        <div class="alert-text">
                            Si el servicio recibido fue como esta descrito puede finalizarlo, si no, puede rechazarlo para su corrección
                        </div>
                    </div>
                    <p> <span class="requeridos">Campos obligatorios (*)</span> </p>
                </div>
            </div>

            <div class="card card-custom mb-5">
                <div class="card-header card-header-tabs-line">
                    <div class="card-toolbar">
                        <ul class="nav nav-tabs nav-bold nav-tabs-line">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#kt_tab_datos_solicitud">
                                <span class="nav-icon"><i class="flaticon2-list-1"></i></span>
                                <span class="nav-text">Detalles del servicio recibido</span>
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
                    </div>
                </div>
            </div>

            <div class="card card-custom mb-5">

                <div class="card-header">
                    <div class="card-title">
                        <h3 class="card-label">Entregas realizadas por el área correspondiente</h3>
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
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($detalleSolicitaServicio as $key => $detalleServicio)
                                <tr>
                                    <th scope="row">{{ ( $i <= $registros ) ? $i++ : '' }}</th>
                                    <td class="text-uppercase"> {{ $detalleServicio->servicio->nombre_servicio }} </td>
                                    <td> {{ $detalleServicio->descripcion_servicio }} </td>
                                    <td> {{ $detalleServicio->unidad }} </td>
                                    <td> {{ $detalleServicio->fecha_estimada }} </td>
                                    <td> {{ $detalleServicio->fecha_entrega }} </td>
                                    <td>
                                        @if ($detalleServicio->estatus_detalle == 'PARCIAL')
                                            SERVICIO PRESTADO PARCIALMENTE
                                        @endif
                                        @if ( $detalleServicio->estatus_detalle == 'COMPLETADO' )
                                            SERVICIO PRESTADO EXITOSAMENTE
                                        @endif
                                        @if ( $detalleServicio->estatus_detalle == 'RECHAZADO' )
                                            SERVICIO NO REALIZADO
                                        @endif
                                    </td>
                                    <td> {{ $detalleServicio->comentarios_servicio }} </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <p>
                        Este es el estado de los entregables de la solicitud de servicio. El área responsable ha marcado las fechas y estados de cada uno, describiendo brevememente la entrega total, parcial o la denegación de este.
                    </p>
                    <p><b>
                        Usted debe de decidir si el área responsable ha descrito correctamente el estado de esta solicitud de servicio.
                        Seleccione si está de acuerdo o no.
                    </b></p>
                </div>

            </div>

            <div class="card card-custom mb-5">

                <div class="card-header">
                    <div class="card-title">
                        <h3 class="card-label">Confirmar o rechazar entregables</h3>
                    </div>
                </div>
                <div class="card-body">
                    <p><b>¿Está usted de acuerdo con estos entregables?</b></p>

                    <input data-switch="true" id="interruptorEntregable" name="interruptorEntregable" type="checkbox" checked data-on-text="Si" data-off-text="No" data-on-color="success" data-off-color="danger" />
                    <label id="interruptorLabel" for="interruptorEntregable"></label>

                    <div id="textAreaRechazo" class="mt-3 mb-3" >
                        <p>En caso de que NO esté de conforme con la información recibida, por favor describa las razones en el espacio inferior.</p>
                        <textarea id="textarea_comentarios_rechazo" name="textarea_comentarios_rechazo"></textarea>
                    </div>

                    <div id="textAreaSatisfecho" class="mt-3 mb-3" >
                        <p>Si gusta, puede colocar comentarios de conformidad.</p>
                        <textarea id="textarea_comentario_satisfecho" name="textarea_comentario_satisfecho"></textarea>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="text-center">
                        <button type="button" id="btn_finalizar_servicio" class="btn btn-success"><i class="fas fa-check-square"></i> Finalizar tarea</button>
                    </div>
                </div>

            </div>

        </form>


@endsection

@push('styles')
    <link href="{{ asset('metronic/plugins/custom/lightbox2/src/css/lightbox.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('scripts')
    <script src="{{ asset('metronic/plugins/custom/tinymce/tinymce.bundle.js') }}"></script>
    <script src="{{ asset('js/p08_solicita_servicios/tareas/T04_confirmacionServicio.js?ver=1.0') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/lightbox2/src/js/lightbox.js') }}"></script>
@endpush
