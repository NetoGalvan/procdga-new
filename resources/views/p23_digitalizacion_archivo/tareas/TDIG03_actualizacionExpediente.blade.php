@extends('layouts.main')

@section('title', 'ACTUALIZACIÓN DE EXPEDIENTE')

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
                'titulo' => 'ACTUALIZACIÓN DE EXPEDIENTE'
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
        <div class="card-body py-3">
            <div class="alert alert-custom alert-success col-md-12 pb-0 pt-3" role="alert">
                <div class="alert-icon"><i class="flaticon-warning"></i>
                </div>
                <div class="alert-text">
                        Nota: Tendra la posibilidad de capturar notas o comentarios sobre el expediente
                </div>
            </div>
            <div>
                <div class="row my-2">
                    <div class="col-md-4 align-middle">
                        <div class="form-group">
                            <label class="titulo-dato">Apellido paterno</label>
                            <span class="valor-dato"> {{ $digitalizacion->apellido_paterno }} </span>
                        </div>
                    </div>
                    <div class="col-md-4 align-middle">
                        <div class="form-group">
                            <label class="titulo-dato">Apellido materno</label>
                            <span class="valor-dato"> {{ $digitalizacion->apellido_materno }} </span>
                        </div>
                    </div>
                    <div class="col-md-4 align-middle">
                        <div class="form-group">
                            <label class="titulo-dato">Nombre(s)</label>
                            <span class="valor-dato"> {{ $digitalizacion->nombre_empleado }} </span>
                        </div>
                    </div>
                    <div class="col-md-4 align-middle">
                        <div class="form-group">
                            <label class="titulo-dato">RFC</label>
                            <span class="valor-dato"> {{ $digitalizacion->rfc }} </span>
                        </div>
                    </div>
                    <div class="col-md-4 align-middle">
                        <div class="form-group">
                            <label class="titulo-dato">Número de empleado</label>
                            <span class="valor-dato"> {{ $digitalizacion->numero_empleado }} </span>
                        </div>
                    </div>
                    <div class="col-md-4 align-middle">
                        <div class="form-group">
                            <label class="titulo-dato">Número de expediente</label>
                            <span class="valor-dato"> {{ $digitalizacion->numero_expediente }} </span>
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
                            <label class="titulo-dato"><span class="requeridos">*</span> Añadir notas</label>
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
                            data-page-size="4"
                            data-page-number="1"
                            data-page-list="[4,10,all]"
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
                            <tbody>
                                @foreach($notas as $nt)
                                <tr>
                                    <td> {{$nt->nota}} </td>
                                    <td> {{$nt->fecha}} </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
        </div>
        <div class="card-footer text-center">
            <form method="POST" id="form_actualizar_notas">
                <button type="button" id="btn_actualizar_notas" class="btn btn-success">
                    <i class="fas fa-check-square"></i>Actualizar notas
                </button>
            </form>
        </div>
    </div>

    <div class="card card-custom mt-5">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">Expediente actual</h3>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 text-justify ">
                    Seleccione el botón <b>"Expediente actual"</b> para obtener el archivo digital del expediente que se tiene disponible. <br> Este archivo digital puede servirle de base para añadir más fojas.

                    <div class="text-center mt-5 info-boton {{($digitalizacion->ruta_archivo != null) ? '' : 'd-none'}}">

                        <a class="btn btn-danger btn-lg w-100" id="expediente_actual"
                           target="_blank"
                           href="{{asset('storage/'.$digitalizacion->ruta_archivo)}}"
                           data-toggle="tooltip"
                           data-html="true"
                           title="<b>ABRIR DOCUMENTO</b>"
                        >
                            <i class="far fa-file-pdf"></i>Expediente actual - {{$digitalizacion->nombre_archivo}}
                        </a>
                    </div>

                    <div class="alert alert-custom alert-success mt-5 info-alert {{($digitalizacion->ruta_archivo != null) ? 'd-none' : ''}}" role="alert">
                        <div class="alert-icon"><i class="flaticon-warning"></i></div>
                        <div class="alert-text">
                            No se cuenta con una versión digital previa para este expediente.
                        </div>
                    </div>
                </div>


                <div class="col-md-6 form-group info-doc {{($digitalizacion->ruta_archivo != null) ? '' : 'd-none'}}">
                    <table width="100%" class="table" id="tabla_informativa_documentos"
                    data-toggle='table'
                    data-pagination="true"
                    data-page-size="4"
                    data-page-number="1"
                    data-page-list="[4,10,all]"
                    data-search="true"
                    data-cache="false"
                    >
                        <thead>
                            <tr>
                                <th data-field="info_tipo" class="text-center"><label class="titulo-dato"> Tipo </label></th>
                                <th data-field="info_fojas" class="text-center"><label class="titulo-dato"> Fojas </label></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($descripcionesDocumento as $descripcion)
                                <tr>
                                    <td>{{ $descripcion->documento }}</td>
                                    <td>{{ $descripcion->hojas }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-custom mt-5">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">Expediente modificado</h3>
            </div>
        </div>
        <div class="card-body py-3">
            <form method="POST" id="form_cargar_documento">
                <div class="alert alert-custom alert-success col-md-12" role="alert">
                    <div class="alert-icon">
                        <i class="flaticon-warning"></i>
                    </div>
                    <div class="alert-text">
                        <p class="mb-2">Instrucciones:</p>
                        <ol class="mb-0">
                            <li>Agregar un expediente digital.</li>
                            <li>Describir el contenido del expediente digital agregando "el tipo de documento que lo componen" y "el número de fojas" correspondientes a cada documento</li>
                            Ejemplo:
                            <ul>
                                <li> <b> Tipo: Acta de nacimiento | Fojas: 1 </b></li>
                                <li> <b> Tipo: Comprobante de domicilio | Fojas: 1 </b></li>
                                <li> <b> Tipo: Comprobante de estudios | Fojas: 3 </b></li>
                            </ul>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="dropzone dropzone-default dropzone-success" id="guardar_archivo_dropzone">
                            <div class="dropzone-msg dz-message needsclick">
                                <h3 class="dropzone-msg-title">
                                    <i class="fas fa-upload" aria-hidden="true"></i> Cargar documento
                                </h3>
                                <span class="dropzone-msg-desc">
                                    Sólo se acepta documento en formato .PDF y peso máximo de 10 MB
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="titulo-dato"><span class="requeridos">*</span> Tipo</label>
                            <input type="text" class="form-control form-control-sm normalizar-texto" name="tipo">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="titulo-dato"><span class="requeridos">*</span> Fojas</label>
                            <input type="text" class="form-control form-control-sm normalizar-texto number" name="fojas">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label class="titulo-dato" style="color: white;">a</label>
                            <button type="button" id="btn_agregar_documento" class="btn btn-primary btn-sm w-100">
                                <i class="fas fa-plus"></i>Agregar descripción de documento
                            </button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 form-group">
                        <table width="100%" class="table" id="tabla_descripcion_documento"
                            data-toggle='table'
                            data-pagination="true"
                            data-page-size="5"
                            data-page-number="1"
                            data-page-list="[5,10,all]"
                            data-cache="false"
                        >
                            <thead>
                                <tr>
                                    <th data-field="tipo" class="text-center">
                                        <label class="titulo-dato"> Tipo </label>
                                    </th>
                                    <th data-field="fojas" class="text-center">
                                        <label class="titulo-dato"> Fojas </label>
                                    </th>
                                    <th data-field="accion" class="text-center">
                                        <label class="titulo-dato"> Acciones </label>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($descripDocumentoFalse as $descripcion)
                                    <tr>
                                        <td>{{ $descripcion->documento }}</td>
                                        <td>{{ $descripcion->hojas }}</td>
                                        <td>
                                            <button id="eliminar_descripcion"
                                            class="btn btn-outline-danger btn-sm"
                                            data-tipo="{{$descripcion->documento}}">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-footer text-center">
            <button type="button" class="btn btn-success" id="btn_cargar_documento">
                <i class="flaticon-attachment"></i>Adjuntar
            </button>
        </div>
    </div>


        <div class="card card-custom mt-5">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Borrar ficha del expediente</h3>
                </div>
            </div>
            <div class="card-body py-3">
                <div class="alert alert-custom alert-success col-md-12 pb-0 pt-3" role="alert">
                    <div class="alert-icon">
                        <i class="flaticon-warning"></i>
                    </div>
                    <div class="alert-text">
                        <strong>
                            <p class="mb-2">Instrucciones:</p>
                            <p>
                                Si los datos de la ficha no corresponden con la documentación del empleado, borre la ficha estableciendo la causa de la eliminación.
                            <br><br>
                                NOTA: Esta acción es definitiva y deberá hacer una nueva ficha y expediente digital para el empleado.
                            </p>
                        </strong>
                    </div>
                </div>
                <form action="{{ route('digitalizacion.archivos.actualizacion.expediente', [$digitalizacion, $instanciaTarea]) }}" method="POST" id="form_borrar_ficha_expediente">
                @method('post') @csrf
                    <div class="row align-items-center">
                        <div class="col-md-3 text-center">
                            <div class="form-group">
                                <label class="checkbox checkbox-danger">
                                    <input type="checkbox" name="check_borrar_expediente" />
                                    <span></span>
                                    Borrar ficha del expediente
                                </label>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <label class="titulo-dato"><span class="requeridos">*</span> Causa de eliminación</strong></label>
                                <textarea rows="3" class="form-control form-control-sm normalizar-texto" name="causa_eliminacion"></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-footer">
                <div class="text-center">
                    <button type="button" id="btn_finalizar_proceso" class="btn btn-success"><i class="fas fa-check-square"></i>Finalizar Tarea</button>
                </div>
            </div>
        </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        var URL_actualizarNotas = "{{ route('digitalizacion.archivos.actualizacion.expediente', [$digitalizacion, $instanciaTarea]) }}";
        var URL_enviarDocumento = "{{ route('digitalizacion.archivo.guardar.documento', $digitalizacion ) }}";

        var dataNotas = @json($notas);
        var storage = "{{ asset('/storage') }}";
    </script>
    <script src="{{ asset('js/p23_digitalizacion_archivo/p23_general.js') }}"></script>
    <script src="{{ asset('js/p23_digitalizacion_archivo/sweet_alert_general.js') }}"></script>
    <script src="{{ asset('js/p23_digitalizacion_archivo/tareas/TDIG03_actualizarExpediente.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
@endpush

@push('styles')
    <link href="{{ asset('metronic/plugins/custom/bootstraptable/css/bootstrap-table.min.css') }}" type="text/css" rel="stylesheet"/>
@endpush
