@extends('layouts.main')

@section('title', 'Selección')

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
                'titulo' => 'Selección'
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

        <form
            method="POST"
            id="form_selecciona_servicio"
            action="{{ route('solicitud.servicio.seleccionar.servicio', [$solicitaServicio->p08_solicita_servicio_id, $instanciaTarea->instancia_tarea_id]) }}"
            enctype="multipart/form-data"
        >
            @method('post')
            @csrf

            <div class="card card-custom mb-5">
                <div class="card-header">
                    <div class="card-title">
                        <h3 class="card-label">Solicitud de servicios</h3>
                    </div>
                </div>
                <div class="card-body">
                    <div class="alert alert-custom alert-outline-success" role="alert">
                        <div class="alert-icon"><i class="flaticon-warning"></i></div>
                        <div class="alert-text">
                            Debes describir el servicio que necesitas para ser atendido
                        </div>
                    </div>
                    <p> <span class="requeridos">Campos obligatorios (*)</span> </p>
                </div>
            </div>

            <div class="card card-custom mb-5">
                <div class="card-header">
                    <div class="card-title">
                        <h3 class="card-label">Selección y descripción de servicio requerido</h3>
                    </div>
                </div>
                <div class="card-body" >
                    <div class="row">

                        <div class="col-md-6 form-group">
                            <label for="servicio_general_id" class="titulo-dato"><span class="requeridos">* </span> <b> Tipos de servicios </b></label>
                            <select class="form-control text-uppercase" name="servicio_general_id" id="servicio_general_id">
                                @if ( !$serviciosGenerales )
                                    <label id="servicio_general_id-error" class="error" for="servicio_general_id">No hay registros</label>
                                @else
                                    @foreach ( $serviciosGenerales as $servicioGenerale )
                                        <option class="text-uppercase" value="{{ $servicioGenerale->servicio_general_id }}" > {{ $servicioGenerale->nombre_servicio_general }} </option>
                                    @endforeach
                                @endif
                            </select>
                            @error('servicio_general_id')
                            <label id="servicio_general_id-error" class="error" for="servicio_general_id">{{ $message }}</label>
                            @enderror
                            <small id="emailHelp" class="form-text text-muted text-justify">Para procesar su solicitud, seleccione el tipo de servicio que requiere. En caso de ser reproducciones, especifique la cantidad.</small>
                        </div>

                        <div class="col-md-6 form-group d-none" id="cantidad-solicitud-container" disabled>
                            <label for="cantidad_solicitud" class="titulo-dato"> <b> Cantidad de reproducciones </b></label>
                            <input type="number" id="cantidad_solicitud" name="cantidad_solicitud"
                                class="form-control normalizar-texto @error('cantidad_solicitud') error @enderror"
                                placeholder="Cantidad de reproducciones"
                                value="{{ isset($solicitaServicio->cantidad_solicitud) ? $solicitaServicio->cantidad_solicitud : '' }}" >
                            @error('cantidad_solicitud')
                                <label id="cantidad_solicitud-error" class="error" for="cantidad_solicitud">{{ $message }}</label>
                            @enderror
                        </div>

                        <div class="col-md-6 form-group d-none" id="select-tipo-de-servicio-container" disabled>
                            <label for="tipo_servicio_id" class="titulo-dato"><span class="requeridos">* </span> <b> Tipo de servicio: </b></label>
                            <select class="form-control text-uppercase" name="tipo_servicio_id" id="tipo_servicio_id">
                                <option value=""> Seleccione una opción </option>
                                @if ( $tiposServicios )
                                    @foreach ($tiposServicios as $telefonia)
                                    <option class="text-uppercase" value="{{$telefonia->servicio_id}}"> {{ $telefonia->nombre_servicio }} </option>
                                    @endforeach
                                @endif
                            </select>
                            @error('tipo_servicio_id')
                                <label id="tipo_servicio_id-error" class="error" for="tipo_servicio_id">{{ $message }}</label>
                            @enderror
                        </div>

                        <div class="col-md-12">
                            <div class="alert alert-custom alert-outline-success" role="alert">
                                <div class="alert-text">
                                    RECOMENDACIONES:
                                    <ul>
                                        <li>
                                            Sea lo más breve posible al exponer su solicitud.</li>
                                        <li>
                                            Si no es una emergencia, evite escribir mensajes como: </li>
                                        <li style="list-style-type: none;">
                                            <ul>
                                                <li>
                                                    URGENTE
                                                </li>
                                                <li>
                                                    A LA BREVEDAD POSIBLE
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                    EJEMPLOS:
                                    <ul>
                                        <li>
                                            <span class="text-justify">
                                                Se requiere el transporte de 12 cajas de documentos del punto "A" al punto "B".
                                                Las cajas son muy pesadas y tal vez se requiera un medio de trasporte adecuado.
                                                Sería conveniente que se lleve a cabo el día lunes 30 del mes en curso por la mañana.
                                            </span>
                                        </li>
                                        <li>
                                            <span class="text-justify">
                                                Hay un charco de agua en la entrada de la Secretaría de Finanzas,
                                                favor de acudir, revisar y solucionar este problema.
                                            </span>
                                        </li>
                                        <li>
                                            <span class="text-justify">
                                                Necesitamos la reproducción de 1500 formatos "ABC-123".
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label for="texto_solicitud" class="titulo-dato"><span class="requeridos">* </span> <b> Descripción </b> </label>
                            <textarea class="form-control" id="texto_solicitud" name="texto_solicitud" ></textarea>
                            @error('texto_solicitud')
                            <label id="texto_solicitud-error" class="error" for="texto_solicitud">{{ $message }}</label>
                            @enderror
                            <small id="emailHelp" class="form-text text-muted">Describa brevemente lo que esta solicitando, entre más claro sea el texto, los responsables del servicio podrán brindarle una mejor atención.</small>
                        </div>

                        @if ($solicitaServicio->servicioGeneral->clave == 'mantenimiento' || $solicitaServicio->servicioGeneral->clave == 'telefonia')
                            <div class="col-md-12 mt-4">
                                <div class="alert alert-custom alert-outline-success" role="alert">
                                    <div class="alert-text">
                                        EVIDENCIA:
                                        <ul>
                                            <li>Puede ingresar un máximo de 3 imágenes para agregar como evidencia de la solicitud de servicio</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" >
                                <div
                                    class="dropzone dropzone-default dropzone-success"
                                    id="id_dropzone_imagenes_evidencia_solicita_servicio"
                                    enctype="multipart/form-data"
                                    data-url="{{ route('solicitud.servicio.seleccionar.servicio.guardar.imagenes', [$solicitaServicio->p08_solicita_servicio_id]) }}">
                                    <div class="dropzone-msg dz-message needsclick">
                                        <h3 class="dropzone-msg-title"> <i class="fas fa-upload" aria-hidden="true"></i> Cargar imágenes</h3>
                                        <span class="dropzone-msg-desc">Sólo se acepta un máximo de 3 imágenes con un peso máximo de 5MB</span>
                                    </div>
                                </div>
                            </div>
                        @elseif ($solicitaServicio->servicioGeneral->clave == 'reproduccion')
                            <div class="col-md-12 mt-4">
                                <div class="alert alert-custom alert-outline-success" role="alert">
                                    <div class="alert-text">
                                        EVIDENCIA:
                                        <ul>
                                            <li>Puede ingresar un máximo de 1 PDF para agregar como evidencia de la solicitud de servicio</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" >
                                <div
                                    class="dropzone dropzone-default dropzone-success"
                                    id="id_dropzone_pdfs_evidencia_solicita_servicio"
                                    enctype="multipart/form-data"
                                    data-url="{{ route('solicitud.servicio.seleccionar.servicio.guardar.pdfs', [$solicitaServicio->p08_solicita_servicio_id]) }}">
                                    <div class="dropzone-msg dz-message needsclick">
                                        <h3 class="dropzone-msg-title"> <i class="fas fa-upload" aria-hidden="true"></i> Cargar pdf</h3>
                                        <span class="dropzone-msg-desc">Sólo se acepta un máximo de un archivo pdf con un peso máximo de 10MB</span>
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
                        <h3 class="card-label">Detalle donde se prestará el servicio</h3>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">

                        <div class="col-md-4 form-group">
                            <label for="contacto_servicio" class="titulo-dato"><span class="requeridos">* </span> <b> Nombre del contacto </b> </label>
                            <input type="text" id="contacto_servicio" name="contacto_servicio"
                                class="form-control normalizar-texto @error('contacto_servicio') error @enderror"
                                placeholder="Nombre del contacto"
                                value="{{ isset($solicitaServicio->contacto_servicio) ? $solicitaServicio->contacto_servicio : '' }}" >
                            @error('contacto_servicio')
                                <label id="contacto_servicio-error" class="error" for="contacto_servicio">{{ $message }}</label>
                            @enderror
                        </div>

                        <div class="col-md-4 form-group">
                            <label for="contacto_correo" class="titulo-dato"><span class="requeridos">* </span> <b> Correo del contacto </b> </label>
                            <input type="email" id="contacto_correo" name="contacto_correo"
                                class="form-control @error('contacto_correo') error @enderror"
                                placeholder="Correo del contacto"
                                value="{{ isset($solicitaServicio->contacto_correo) ? $solicitaServicio->contacto_correo : '' }}" >
                            @error('contacto_correo')
                                <label id="contacto_correo-error" class="error" for="contacto_correo">{{ $message }}</label>
                            @enderror
                        </div>

                        <div class="col-md-4 form-group">
                            <label for="sub_area" class="titulo-dato"><span class="requeridos">* </span> <b> Subárea </b> </label>
                            <input type="text" id="sub_area" name="sub_area"
                                class="form-control normalizar-texto @error('sub_area') error @enderror"
                                placeholder="Área de servicio"
                                value="{{ isset($solicitaServicio->sub_area) ? $solicitaServicio->sub_area : '' }}" >
                            @error('sub_area')
                                <label id="sub_area-error" class="error" for="sub_area">{{ $message }}</label>
                            @enderror
                        </div>

                        <div class="col-md-4 form-group">
                            <label for="telefono_servicio" class="titulo-dato"><span class="requeridos">* </span> <b> Teléfono </b> </label>
                            <input type="text" maxlength="10" id="telefono_servicio" name="telefono_servicio"
                                class="form-control normalizar-texto @error('telefono_servicio') error @enderror"
                                placeholder="Teléfono de contacto"
                                value="{{ isset($solicitaServicio->telefono_servicio) ? $solicitaServicio->telefono_servicio : '' }}" >
                            @error('telefono_servicio')
                                <label id="telefono_servicio-error" class="error" for="telefono_servicio">{{ $message }}</label>
                            @enderror
                        </div>

                        <div class="col-md-2 form-group">
                            <label for="ext_servicio" class="titulo-dato">Ext.</label>
                            <input type="text" maxlength="10" id="ext_servicio" name="ext_servicio"
                                class="form-control normalizar-texto @error('ext_servicio') error @enderror"
                                placeholder="Ext. de contacto"
                                value="{{ isset($solicitaServicio->ext_servicio) ? $solicitaServicio->ext_servicio : '' }}" >
                            @error('ext_servicio')
                                <label id="ext_servicio-error" class="error" for="ext_servicio">{{ $message }}</label>
                            @enderror
                        </div>

                        <div class="col-md-2 form-group">
                        </div>

                        <div class="col-md-4 form-group">
                            <input type="hidden" id="creado_por_usuario_id" name="creado_por_usuario_id" value="{{$usuario->id}}" >
                            <label for="creado_por_usuario" class="titulo-dato"><span class="requeridos">* </span> <b> Solicitud creada por </b> </label>
                            <input type="text" id="creado_por_usuario" name="creado_por_usuario"
                                class="form-control normalizar-texto @error('creado_por_usuario') error @enderror"
                                placeholder="Solicitud creada por" disabled
                                value="{{ isset($usuario->id) ? $usuario->nombre .' '. $usuario->apellido_paterno .' '. $usuario->apellido_materno : '' }}" >
                            @error('creado_por_usuario')
                                <label id="creado_por_usuario-error" class="error" for="creado_por_usuario">{{ $message }}</label>
                            @enderror
                        </div>

                        <div class="col-md-8 form-group">
                            <label for="direccion_servicio" class="titulo-dato"><span class="requeridos">* </span> <b> Dirección </b> </label>
                            <input type="text" id="direccion_servicio" name="direccion_servicio"
                                class="form-control normalizar-texto @error('direccion_servicio') error @enderror"
                                placeholder="Dirección del servicio"
                                value="{{ isset($solicitaServicio->direccion_servicio) ? $solicitaServicio->direccion_servicio : '' }}" >
                            @error('direccion_servicio')
                                <label id="direccion_servicio-error" class="error" for="direccion_servicio">{{ $message }}</label>
                            @enderror
                        </div>

                        @if ($solicitaServicio->servicioGeneral->clave == 'mantenimiento')
                            <div class="form-group col-md-4 text-center">
                                <label for="urgente" class="titulo-dato">Prioridad</label>
                                <input data-switch="true" id="urgente" name="urgente" type="checkbox" data-on-text="Urgente" data-off-text="Normal" data-on-color="danger" data-off-color="success" />
                            </div>
                        @endif

                    </div>
                </div>
                <div class="card-footer">
                    <div class="text-center">
                        <button type="button" id="btn_finalizar_seleccion_servicio" class="btn btn-success"><i class="fas fa-check-square"></i> Finalizar tarea</button>
                    </div>
                </div>
            </div>
        </form>

@endsection

@push('styles')
@endpush

@push('scripts')
    <script>
        const usuario = @json( $usuario );
        const solicitaServicio = @json( $solicitaServicio );
        const tipoServicio = @json( $solicitaServicio->servicioGeneral );
    </script>
    <script src="{{ asset('metronic/plugins/custom/tinymce/tinymce.bundle.js') }}"></script>
    <script src="{{ asset('js/p08_solicita_servicios/tareas/T01_seleccionaServicio.js?ver=1.01') }}"></script>
@endpush
