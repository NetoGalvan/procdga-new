@extends('layouts.main')

@section('title', 'Desglose')

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
                'titulo' => 'Desglose'
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

    <form method="POST" id="form_desglose_servicio" action="{{ route('solicitud.servicio.desglose.servicio', [$solicitaServicio->p08_solicita_servicio_id, $instanciaTarea->instancia_tarea_id]) }}">
        @method('post')
        @csrf

        <div class="card card-custom mb-5">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Desglose del servicio</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="alert alert-custom alert-outline-success" role="alert">
                    <div class="alert-icon"><i class="flaticon-warning"></i></div>
                    <div class="alert-text">
                        Debes revisar el servicio que fue soliciado y responder cuando y como será atendido
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

        <div class="card card-custom mb-5">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Desglose de los entregables individuales</h3>
                </div>
            </div>
            <div class="card-body">
                <p>
                    La única persona que sabe correctamente que servicios hay que entregar, así como las características técnicas, y los tiempos posibles, es usted; favor de desglosar la solicitud original en entregables definidos.
                </p>
                <p>
                    En caso de que esta tarea haya regresado por un rechazo del área usuaria, le sugerimos que los revise puesto que ahí se debe de detallar cualquier razón que pudiera causar que los entregables no sean aceptables.
                </p>
                <div class="table-responsive">
                    <table id="table" class="text-center" data-toggle="table" data-toolbar="#toolbar">
                        <thead>
                            <tr>
                                <th data-field="servicio_id"><label class="titulo-dato">Id servicio</label></th>
                                <th data-field="tipo_servicio" class="text-uppercase"><label class="titulo-dato">Tipo servicio</label></th>
                                <th data-field="descripcion_servicio"><label class="titulo-dato">Descripción servicio</label></th>
                                <th data-field="unidad"><label class="titulo-dato">Unidad</label></th>
                                <th data-field="fecha_estimada"><label class="titulo-dato">Fecha estimada</label></th>
                                <th data-formatter="eliminarFormatter"><label class="titulo-dato">Acciones</label></th>
                            </tr>
                        </thead>
                    </table>
                </div>

                <small>
                    Si se equivocó en alguna partida, simplemente haga click en el botón eliminar y agregue otra.
                </small>

                <div class="row">
                    <div class="form-group my-5 col-md-4 d-flex flex-column" >
                        <!-- Button lanza modal -->
                        <button type="button" class="btn btn-primary mr-5" data-toggle="modal" data-target="#modalNuevaPartida"> <i class="fas fa-plus"></i> Agregar nueva partida</button>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group my-5 col-md-4 d-flex flex-column">
                        <label for="rechazar" class="titulo-dato">Estatus solicitud</label>
                        <input data-switch="true" id="rechazar" name="rechazar" type="checkbox" data-on-text="Rechazar" data-off-text="Continuar" data-on-color="danger" data-off-color="success" />
                    </div>
                    <div class="form-group mt-5 col-md-8 container-motivo-rechazo d-none">
                        <label for="motivo_rechazo" class="titulo-dato"><span class="requeridos">* </span><b> Motivo de rechazo </b> </label>
                        <textarea id="motivo_rechazo" name="motivo_rechazo"
                        class="form-control normalizar-texto btn-sm @error('motivo_rechazo') error @enderror"
                        rows="3" required></textarea>
                    </div>
                </div>
            </div>




            <div class="card-footer">
                <div class="text-center">
                    <button type="button" id="btn_finalizar_desglose" class="btn btn-success"><i class="fas fa-check-square"></i> Finalizar tarea</button>
                </div>
            </div>
        </div>

    </form>


    <!-- Inicio Modal -->
    <div class="modal fade" id="modalNuevaPartida" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tituloNuevaPartida">Nueva partida</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form method="POST" id="form_modal_desglose_servicio" action="">
                        @method('post')
                        @csrf
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label for="servicio_id" class="titulo-dato"><span class="requeridos">* </span> <b> Tipo de servicio: </b> </label>
                                <select class="form-control text-uppercase" name="servicio_id" id="servicio_id" data-url="{{ route('catalogo.servicios', ['solicitaServicio' => $solicitaServicio->p08_solicita_servicio_id]) }}">
                                        <option value=""> Seleccione una opción </option>
                                    @if ( !$servicio )
                                        <label id="servicio_id-error" class="error" for="servicio_id">No hay registros</label>
                                    @else
                                        @foreach ( $servicio as $servicios )
                                            <option class="text-uppercase" value="{{ $servicios->servicio_id }}" > {{ $servicios->nombre_servicio }} </option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('servicio_id')
                                    <label id="servicio_id-error" class="error" for="servicio_id">{{ $message }}</label>
                                @enderror
                            </div>

                            @if ( $vehiculos )
                                <div class="col-md-4 form-group">
                                    <label for="unidad" class="titulo-dato"><span class="requeridos">* </span> <b> Unidad: </b> </label>
                                    <select class="form-control select2" style="width: 100%" name="unidad" id="unidad" >
                                            <option value=""> Elige vehículo </option>
                                            @foreach ( $vehiculos as $vehiculo )
                                                    <option class="text-uppercase" value="{{ $vehiculo->placa }} - {{ $vehiculo->marca }} - {{ $vehiculo->submarca }} - {{ $vehiculo->modelo }} - {{ $vehiculo->color }}" > {{ $vehiculo->placa }} - {{ $vehiculo->marca }} - {{ $vehiculo->submarca }} - {{ $vehiculo->modelo }} - {{ $vehiculo->color }} </option>
                                            @endforeach
                                    </select>
                                    @error('unidad')
                                        <label id="unidad-error" class="error" for="unidad">{{ $message }}</label>
                                    @enderror
                                </div>
                            @else
                                <div class="col-md-4 form-group">
                                    <label for="unidad" class="titulo-dato"><span class="requeridos"> {{$solicitaServicio->servicioGeneral->clave == 'telefonia' ? '' :  '*'}} </span> <b> Unidad: (pieza, servicio, viaje, etc.) </b> </label>
                                    <input type="text" id="unidad" name="unidad"
                                        class="form-control normalizar-texto @error('unidad') error @enderror"
                                        placeholder="Unidad"
                                        value="" >
                                    @error('unidad')
                                        <label id="unidad-error" class="error" for="unidad">{{ $message }}</label>
                                    @enderror
                                </div>
                            @endif


                            <div class="col-md-4 form-group">
                                <label for="fecha_estimada" class="titulo-dato"><span class="requeridos">* </span> <b> Fecha estimada de entrega: </b> </label>
                                <input type="text" class="form-control date-general-weekend " name="fecha_estimada" id="fecha_estimada"
                                    placeholder="Fecha estimada"    value="">
                                @error('fecha_estimada')
                                    <label id="fecha_estimada-error" class="error" for="fecha_estimada">{{ $message }}</label>
                                @enderror
                            </div>

                            <div class="col-md-12 form-group">
                                <label for="descripcion_servicio" class="titulo-dato"><span class="requeridos">* </span> <b> Descripción: </b> </label>
                                <textarea id="descripcion_servicio" name="descripcion_servicio" cols="30" rows="5" placeholder="Descripción" class="form-control normalizar-texto"></textarea>
                                @error('descripcion_servicio')
                                    <label id="descripcion_servicio-error" class="error" for="descripcion_servicio">{{ $message }}</label>
                                @enderror
                            </div>
                        </div>
                    </form>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="btn_agrega_partida" name="btn_agrega_partida" class="btn btn-primary">Agregar</button>
                </div>

            </div>
        </div>
    </div>
    <!-- Fin Modal -->

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
    <link rel="stylesheet" type="text/css" href="{{ asset('css/p08_solicitud_servicios/T02_desgloseServicio.css') }}" />
    <link href="{{ asset('metronic/plugins/custom/bootstraptable/css/bootstrap-table.min.css') }}" type="text/css" rel="stylesheet"/>
    <link href="{{ asset('metronic/plugins/custom/lightbox2/src/css/lightbox.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('scripts')
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
    <script src="{{ asset('js/p08_solicita_servicios/tareas/T02_desgloseServicio.js?ver=1.1') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/lightbox2/src/js/lightbox.js') }}"></script>
    <script>
        const detalleSolicitaServicio = @json($detalleSolicitaServicio);
        const solicitaServicioId = @json($solicitaServicio->p08_solicita_servicio_id);
        const instanciaTareaId = @json($instanciaTarea->instancia_tarea_id);
        const claveServicio = @json($solicitaServicio->servicioGeneral->clave);
        const urlEliminar = @json(route('delete.servicios'));
        const urlFinalizarProceso = @json(route('solicitud.servicio.finalizar.prematuramente.desglose.servicio'));
        const urlTareas = @json( route('tareas') );
    </script>
@endpush
