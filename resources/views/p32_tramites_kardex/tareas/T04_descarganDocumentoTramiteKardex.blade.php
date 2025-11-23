@extends('layouts.main')

@section('title', 'Descarga de documento')

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
                'titulo' => 'Descarga de documento'
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

    <div class="card card-custom mb-5">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">Descarga de documento</h3>
            </div>
        </div>
        <div class="card-body">
            <div class="alert alert-custom alert-outline-success" role="alert">
                <div class="alert-icon"><i class="flaticon-warning"></i></div>
                <div class="alert-text">
                    Puedes ver el detalle del trámite kardex en curso y descargar el documento correspondiente
                </div>
            </div>
        </div>
    </div>

    <form method="POST" id="id_form_descarga_documento_kardex" action="{{ route('tramites.kardex.descargar.documento', [$tramiteKardex, $instanciaTarea]) }}">
    @method('post')
    @csrf
        <div class="card card-custom mb-5">
            <div class="card-header card-header-tabs-line">
                <div class="card-toolbar">
                    <ul class="nav nav-tabs nav-bold nav-tabs-line">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#kt_tab_descarga_documentos">
                            <span class="nav-icon"><i class="flaticon-download-1"></i></span>
                            <span class="nav-text">Descarga de documentos</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#kt_tab_datos_tramite">
                            <span class="nav-icon"><i class="flaticon2-list-1"></i></span>
                            <span class="nav-text">Datos del trámite</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#kt_tab_datos_empleado">
                            <span class="nav-icon"><i class="flaticon2-map"></i></span>
                            <span class="nav-text">Dirección del empleado</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#kt_tab_datos_documentos_verificados">
                            <span class="nav-icon"><i class="flaticon-doc"></i></span>
                            <span class="nav-text">Documentos verifcados</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#kt_tab_datos_usuarios">
                            <span class="nav-icon"><i class="flaticon2-group"></i></span>
                            <span class="nav-text">Usuarios</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="kt_tab_descarga_documentos" role="tabpanel" aria-labelledby="kt_tab_descarga_documentos">
                        <div class="row">
                            <div class="col-md-12 d-flex flex-column text-center">
                                <h5>El trámite <b> {{$tramiteKardex->tipoTramiteKardex->nombre}} </b> con  folio <b> {{$tramiteKardex->folio}} </b> ya fue completado.</h5> <br>
                            </div>
                            <input type="hidden" id="firmado" name="firmado" value="{{isset($firmas)?true:false}}">
                            @if (isset($firmas))
                                <div class="col-md-6 d-flex flex-column mb-3">
                                    <label class="titulo-dato"> Descargar detalle(s): </label>
                                    <a href="{{ route('tramites.kardex.descargar.documento.detalles', $tramiteKardex ) }}" id="href_descargar_detalles"> <button type="button" class="btn btn-success btn-block"><i class="flaticon-download"></i> Detalle(s)</button> </a>
                                </div>
                                <div class="col-md-6 d-flex flex-column mb-3">
                                    <label class="titulo-dato"> Descargar seguimiento(s): </label>
                                    <a href="{{ route('tramites.kardex.descargar.documento.seguimientos', $tramiteKardex ) }}" id="href_descargar_seguimientos"> <button type="button" class="btn btn-success btn-block"><i class="flaticon-download"></i> Seguimiento(s)</button> </a>
                                </div>
                            @else
                                <div class="col-md-6 form-group">
                                    <label for="usuario_verifico" class="titulo-dato"><span class="requeridos">* </span> <b> Usuario que verificó  </b> </label>
                                    <input type="text" class="form-control normalizar-texto" id="usuario_verifico" name="usuario_verifico" value="" placeholder="Ingresa usuario que verificó" required campoNoVacio="true" soloLetras="true" />
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="usuario_autorizo" class="titulo-dato"><span class="requeridos">* </span> <b> Usuario que autorizó </b> </label>
                                    <input type="text" class="form-control normalizar-texto" id="usuario_autorizo" name="usuario_autorizo" value="" placeholder="Ingresa usuario que autorizó" required campoNoVacio="true" soloLetras="true" />
                                </div>
                            @endif

                        </div>
                    </div>
                    <div class="tab-pane fade" id="kt_tab_datos_tramite" role="tabpanel" aria-labelledby="kt_tab_datos_tramite">
                        <div class="row">
                            <div class="col-md-4 d-flex flex-column mb-3">
                                <label class="titulo-dato"> Tipo de trámite: </label>
                                <span class="badge badge-primary"> {{ mb_strtoupper($tramiteKardex->tipoTramiteKardex->nombre) }} </span>
                            </div>
                            <div class="col-md-4">
                                <label class="titulo-dato"> Folio: </label>
                                <span class="valor-dato"> <b> {{ $tramiteKardex->folio }} </b> </span>
                            </div>
                            <div class="col-md-4">
                                <label class="titulo-dato"> Fecha elaboración: </label>
                                <span class="valor-dato"> <b>{{ date('d-m-Y', strtotime($tramiteKardex->fecha_elaboracion_tramite))}} </b> </span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label class="titulo-dato"> Nombre del empleado: </label>
                                <span class="valor-dato"> <b> {{ mb_strtoupper($tramiteKardex->nombre_completo) }} </b> </span>
                            </div>
                            <div class="col-md-4">
                                <label class="titulo-dato"> No. empleado: </label>
                                <span class="valor-dato"> <b> {{ $tramiteKardex->numero_empleado }} </b> </span>
                            </div>
                            <div class="col-md-4">
                                <label class="titulo-dato"> RFC: </label>
                                <span class="valor-dato"> <b> {{ $tramiteKardex->rfc }} </b> </span>
                            </div>
                            <div class="col-md-4">
                                <label class="titulo-dato"> CURP: </label>
                                <span class="valor-dato"> <b> {{ $tramiteKardex->curp }} </b> </span>
                            </div>
                            <div class="col-md-4">
                                <label class="titulo-dato"> Área: </label>
                                <span class="valor-dato"> <b> {{ isset($tramiteKardex->unidad_administrativa_nombre) ? mb_strtoupper($tramiteKardex->unidad_administrativa_nombre) : '' }} </b> </span>
                            </div>
                            <div class="col-md-4">
                                <label class="titulo-dato"> Puesto: </label>
                                <span class="valor-dato"> <b> {{ mb_strtoupper($tramiteKardex->puesto) }} </b> </span>
                            </div>
                            <div class="col-md-4">
                                <label class="titulo-dato"> Código: </label>
                                <span class="valor-dato"> <b> {{ mb_strtoupper($tramiteKardex->codigo_puesto) }} </b> </span>
                            </div>
                            <div class="col-md-4">
                                <label class="titulo-dato"> Nivel salarial: </label>
                                <span class="valor-dato"> <b> {{ mb_strtoupper($tramiteKardex->nivel_salarial) }} </b> </span>
                            </div>
                            <div class="col-md-4">
                                <label class="titulo-dato"> Fecha alta empleado: </label>
                                <span class="valor-dato"> <b> {{ date('d-m-Y', strtotime($tramiteKardex->fecha_alta_empleado))}} </b> </span>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="kt_tab_datos_empleado" role="tabpanel" aria-labelledby="kt_tab_datos_empleado">
                        <div class="row">
                            <div class="col-md-4">
                                <label class="titulo-dato"> Calle: </label>
                                <span class="valor-dato"> <b> {{ mb_strtoupper($tramiteKardex->calle) }} </b> </span>
                            </div>
                            <div class="col-md-4">
                                <label class="titulo-dato"> Número exterior: </label>
                                <span class="valor-dato"> <b> {{ mb_strtoupper($tramiteKardex->numero_exterior) }} </b> </span>
                            </div>
                            <div class="col-md-4">
                                <label class="titulo-dato"> Número interior: </label>
                                <span class="valor-dato"> <b> {{ mb_strtoupper($tramiteKardex->numero_interior) }} </b> </span>
                            </div>
                            <div class="col-md-4">
                                <label class="titulo-dato"> Colonia: </label>
                                <span class="valor-dato"> <b> {{ mb_strtoupper($tramiteKardex->colonia) }} </b> </span>
                            </div>
                            <div class="col-md-4">
                                <label class="titulo-dato"> Municipio o Alcaldia: </label>
                                <span class="valor-dato"> <b> {{ mb_strtoupper($tramiteKardex->municipio_alcaldia) }} </b> </span>
                            </div>
                            <div class="col-md-4">
                                <label class="titulo-dato"> Ciudad: </label>
                                <span class="valor-dato"> <b> {{ mb_strtoupper($tramiteKardex->ciudad) }} </b> </span>
                            </div>
                            <div class="col-md-4">
                                <label class="titulo-dato"> Entidad: </label>
                                <span class="valor-dato"> <b> {{ mb_strtoupper($tramiteKardex->entidad->nombre) }} </b> </span>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="kt_tab_datos_documentos_verificados" role="tabpanel" aria-labelledby="kt_tab_datos_documentos_verificados">
                        <div class="row">
                            @foreach ($documentosVerificados as $key => $documentoVerificado)
                                <div class="col-md-4 d-flex flex-column mb-3">
                                    <label class="titulo-dato"> {{ mb_strtoupper(str_replace('_', ' ', $key)) }}: </label>
                                    @if ( $documentoVerificado )
                                        <span class="badge badge-success"> <i class="flaticon2-check-mark text-white"></i> VERIFICADO</span>
                                    @else
                                        <span class="badge badge-danger"> <i class="flaticon2-cross text-white"></i> SIN VERIFICAR</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="tab-pane fade" id="kt_tab_datos_usuarios" role="tabpanel" aria-labelledby="kt_tab_datos_usuarios">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="titulo-dato"> Capturado por: </label>
                                <span class="valor-dato"> <b> {{ mb_strtoupper($tramiteKardex->revisadoPorUsuario->nombre) }} {{ mb_strtoupper($tramiteKardex->revisadoPorUsuario->apellido_paterno) }} {{ mb_strtoupper($tramiteKardex->revisadoPorUsuario->apellido_materno) }} </b> </span>
                            </div>
                            <div class="col-md-3">
                                <label class="titulo-dato"> Asignado por: </label>
                                <span class="valor-dato"> <b> {{ mb_strtoupper($tramiteKardex->autorizadoPorUsuario->nombre) }} {{ mb_strtoupper($tramiteKardex->autorizadoPorUsuario->apellido_paterno) }} {{ mb_strtoupper($tramiteKardex->autorizadoPorUsuario->apellido_materno) }} </b> </span>
                            </div>
                            <div class="col-md-3">
                                <label class="titulo-dato"> Asignado a: </label>
                                <span class="valor-dato"> <b> {{ mb_strtoupper($tramiteKardex->asignadoAUsuario->nombre) }} {{ mb_strtoupper($tramiteKardex->asignadoAUsuario->apellido_paterno) }} {{ mb_strtoupper($tramiteKardex->asignadoAUsuario->apellido_materno) }} </b> </span>
                            </div>
                            <div class="col-md-3">
                                <label class="titulo-dato"> Solicitado por: </label>
                                <span class="valor-dato"> <b> {{ mb_strtoupper($tramiteKardex->solicitante) }} </b> </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                    <div class="text-center">
                        <button type="submit" id="btn_finalizar_descarga_documento_kardex" class="btn btn-success"><i class="fas fa-check-square"></i> {{ isset($firmas) ? 'Finalizar proceso' : 'Guardar firmas' }} </button>
                    </div>
            </div>
        </div>
    </form>

@endsection

@push('styles')

@endpush

@push('scripts')
    <script src="{{ asset('js/p32_tramites_kardex/tareas/T04_descarganDocumentoTramiteKardex.js?ver=1.0') }}"></script>
    <script>
        const tramiteKardex = @json($tramiteKardex);
        const detalles = @json($detalles);
        const firmas = @json($firmas);
        const urlGuardarDetalles = @json(route('tramites.kardex.guardar.detalles'));
        const urlEliminarDetalles = @json(route('tramites.kardex.eliminar.detalles'));
    </script>
@endpush
