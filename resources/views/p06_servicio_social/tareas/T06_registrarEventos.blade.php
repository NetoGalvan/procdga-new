@extends('layouts.main')

@section('title', 'REGISTRAR EVENTOS')

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
                'titulo' => 'REGISTRAR EVENTOS'
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

@push('styles')
	<link href="{{ asset('metronic/plugins/custom/bootstraptable/css/bootstrap-table.min.css') }}" type="text/css" rel="stylesheet"/>
@endpush
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('contenido')
    @include('p06_servicio_social.partials.detalles_proceso', [ 
        "secciones" => [
            "general", 
            "datos_candidato" => [],
            "datos_escolares",
            "prestacion_servicio"
        ] 
    ])
    <form method="POST" id="cargarDocumento">
    @csrf
    @method('post')
        <div class="card card-custom mt-5 mb-5">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Carga de documentos</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-custom alert-success" role="alert">
                            <div class="alert-icon"><i class="flaticon-warning"></i></div>
                            <div class="alert-text">
                                <strong>
                                    <p class="mb-2 ml-6">Instrucciones:</p>
                                    <ul class="mb-0">
                                        <li>
                                            Cargar el documento correspondiente a enviar para "subir horas - solicitar baja"
                                        </li>
                                        <li>
                                            Escribir una breve deacripción que valide o justifique el documento que va a enviar.
                                        </li>
                                        <li>
                                            En caso de cargar un documento de horas agregar las horas de asistencia que validen al archivo.
                                        </li>
                                    </ul>
                                </strong>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="dropzone dropzone-default dropzone-success" id="guardar_archivo_dropzone">
                            <div class="dropzone-msg dz-message needsclick">
                                <h3 class="dropzone-msg-title"> <i class="fas fa-upload" aria-hidden="true"></i> Cargar documento</h3>
                                <span class="dropzone-msg-desc">Sólo se acepta documento en formato .PDF y peso máximo de 10 MB</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-6">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="titulo-dato"><strong><span class="requeridos">*</span>Tipo</strong></label>
                            <select class="form-control" name="tipo_accion" id="tipo_accion">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                @foreach ($tipos as $tipo)
                                    <option value="{{ $tipo }}">{{ $tipo }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="form-group">
                            <label class="titulo-dato"><strong><span class="requeridos">*</span>Descripcion</strong></label>
                            <textarea name="descripcion" rows="3" id="descripcion" class="form-control normalizar-texto" placeholder="Descripción...."></textarea>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group text-center">
                            <label id="a" class="titulo-dato" style="color: white">a</label>
                            <button type="button" id="btn_carga_documento" class="btn btn-success"><i class="fas fa-arrow-right "></i>Enviar</button>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center text-center">
                    <div class="horas-asistencia"></div>
                    <div class="col-md-2">
                        <label class="titulo-dato">Total de horas </label>
                        <div class="total-horas"> {{$servicioSocial->prestador->total_horas}} </div>
                    </div>
                    <div class="col-md-3">
                        <label class="titulo-dato">Horas restantes</label>
                        <div class="horas-restantes">
                            {{$servicioSocial->prestador->total_horas - $servicioSocial->horas_acumuladas}}
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label class="titulo-dato">Días faltantes</label>
                        <div> {{$diasFaltantes}} </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table font-size-lg" id="tabla_documentos" 
                            data-toggle='table'
                            data-ajax='showCargarDocumentos'
                            data-cache='false'
                        >
                            <thead>
                                <tr>
                                    <th data-field="tipo_archivo" data-formatter="tipoDocumentoFormatter" class="text-center"><label class="titulo-dato"> Tipo </label></th>
                                    <th class="w-50" data-field="descripcion"><label class="titulo-dato text-center"> Descripción </label></th>
                                    <th class="text-center" data-field="horas_asistencia" data-formatter="horasAsistenciaFormatter"><label class="titulo-dato text-center"> Horas de asistencia</label></th>
                                    <th data-field="fecha_detalle" class="text-center w-25"><label class="titulo-dato"> Fecha </label></th>
                                    <th data-formatter="archivoFormatter" class="text-center"><label class="titulo-dato"> Archivo </label></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>  
            </div>
        </div>
    </form>

    <form method="POST" id="registrarSeguimiento">
    @csrf
    @method('post')
        <div class="card card-custom mb-5">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Seguimientos</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-custom alert-success" role="alert">
                            <div class="alert-icon"><i class="flaticon-warning"></i></div>
                            <div class="alert-text">
                                <strong>
                                    <p class="mb-2 ml-6">Instrucciones:</p>
                                    <ul class="mb-0">
                                        <li>
                                            Seleccionar el tipo de informe que guardará.
                                        </li>
                                        <li>
                                            Escribir un breve comentario que valide o justifique el informe que va a guardar.
                                        </li>
                                    </ul>
                                </strong>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2 form-group align-middle">
                        <div class="form-group">
                            <label class="titulo-dato"><strong><span class="requeridos">* </span>Informe</strong></label>
                            <select class="form-control" name="tipo_informe">
                                <option value="" selected disabled>SELECCIONE...</option>
                                @foreach ($informes as $clave=>$valor)
                                    <option value="{{ $clave }}">{{ $valor }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-7 form-group">
                        <label class="titulo-dato"><strong><span class="requeridos">* </span>Comentario</strong></label>
                        <textarea name="comentario" rows="4" class="form-control normalizar-texto" placeholder="Escribir comentario"></textarea>
                    </div>
                    <div class="col-md-3 form-group text-center">
                        <label class="titulo-dato" for=""></label>
                        <button type="button" id="btnSeguimientoEventos" name="btnSeguimientoEventos" class="btn btn-primary mt-7"><i class="fas fa-plus"></i>Agregar seguimiento</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 form-group">
                        <table width="100%" class="table font-size-lg" id="TablaSeguimientoEventos"         
                            data-toggle='table'
                            data-ajax='showCargarInformes'
                            data-cache='false'
                        >
                            <thead>
                                <th class="text-center" data-field="fecha_comentario"><label class="titulo-dato">Fecha</label></th>
                                <th class="w-50"  data-field="comentario"><label class="titulo-dato text-center">Comentario</label></th>
                                <th class="text-center" data-field="informe" data-formatter="tipoInformeFormatter"><label class="titulo-dato">Informe</label></th>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form method="POST" id="finalizarServicio">
    @csrf
    @method('post')
    <div class="card card-custom mb-5">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Finalizar servicio</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-custom alert-success" role="alert">
                            <div class="alert-icon"><i class="flaticon-warning"></i></div>
                            <div class="alert-text">
                                <strong>
                                    Nota: <p>Antes de liberar el servicio o dar de baja al candidato el área de validación tiene que confirmar la solicitud para que pueda finalizar con la tarea.</p>
                                </strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="text-center">
                    <input type="hidden" id="opcion" name="opcion">
                    <button type="button" class="btn btn-success m-2" id="liberarServicio" name="liberarServicio" data-opcion="LIBERADO">
                        <i class="fas fa-user-check"></i>Liberar servicio
                    </button>
                    <button class="btn btn-danger m-2" id="darDeBaja" name="darDeBaja" data-opcion="BAJA">
                        <i class="fas fa-user-times"></i>Dar de baja
                    </button>
                    <button type="button" class="btn btn-secondary m-2" id="abandono" name="abandono" data-opcion="ABANDONO">
                        <i class="fas fa-sign-in-alt"></i>Abandono
                    </button>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script type="text/javascript">     
        var URL_registrarDocumentos = '{{ route('ss.registrar.documentos', [$servicioSocial, $instanciaTarea]) }}';
        var URL_registrarInformes = '{{ route('ss.registrar.informes', [$servicioSocial, $instanciaTarea]) }}';
        var URL_liberarServicioSocial = "{{ route('servicio.social.registrar.eventos.1', [$servicioSocial, $instanciaTarea]) }}";
        var URL_bajaCandidato = "{{ route('decision.baja.prestador', [$servicioSocial, $instanciaTarea]) }}";

        var URL_finalizarTarea = "{{ route('servicio.social.registrar.eventos.1', [$servicioSocial, $instanciaTarea]) }}";

        var validacion = "{{$servicioSocial->validacion}}";
        var storage = "{{ asset('/storage') }}";
    </script>
    <script src="{{ asset('js/p06_servicio_social/js_general.js') }}"></script>
    <script src="{{ asset('js/p06_servicio_social/general_swal_alert.js') }}"></script>
    <script src="{{ asset('js/p06_servicio_social/tareas/T06_registrarEventos.js') }}"></script>
    <script src="{{ asset('js/p06_servicio_social/tareas/T06_registrarInformes.js') }}"></script>
    <script src="{{ asset('js/p06_servicio_social/tareas/T06_registrarDocumentos.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
@endpush
