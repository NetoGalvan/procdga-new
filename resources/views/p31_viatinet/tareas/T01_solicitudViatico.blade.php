@extends('layouts.main')

@section('title', 'VIATINET')

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
                'titulo' => "{$instanciaTarea->tarea->proceso->nombre} - {$instanciaTarea->tarea->nombre}"
            ]
        ]
    ]])
@endsection

@section('aside_menu')
    @include('layouts.partials.main.aside_menu', ["asideMenu" =>
        [
            "item_seleccionado" => "procesos",
        ]
    ])
@endsection

@push('styles')
    <link href="{{ asset('metronic/plugins/custom/bootstraptable/css/bootstrap-table.min.css') }}" rel="stylesheet" type="text/css"/>
@endpush

@section('contenido')
    <div class="card card-custom">
        <div class="card-body">
            @include("p31_viatinet.tareas.partials.datos_general", [
                "secciones" => [
                    "general" => []
                ]
            ])
        </div>
    </div>
    <div class="card card-custom mt-8">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">Documentos soporte</h3>
            </div>
        </div>
        <div class="card-body">
            <form id="form_documentos_soporte">
                <div class="row">
                    <div class="form-group col-md-12">
                        <div class="alert alert-custom alert-outline-danger fade show mb-0" role="alert">
                            <div class="alert-icon"><i class="flaticon-warning"></i></div>
                            <div class="alert-text">Sólo se acepta documento en formato PDF y peso máximo de 5MB</div>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <label class="titulo-dato"><strong><span class="text-danger">*</span> Documento </strong></label>
                        <div id="dropzone_documentos" class="dropzone dropzone-default dropzone-success">
                            <div class="dropzone-msg dz-message needsclick">
                                <h3 class="dropzone-msg-title">Cargar documento</h3>
                                <span class="dropzone-msg-desc">Sólo se acepta documento en formato PDF y peso máximo de 5MB</span>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="form-group col-md-4">
                        <label class="titulo-dato"><strong><span class="text-danger">*</span> Nombre </strong></label>
                        <input id="nombre_documento" class="form-control" autocomplete="off" required>
                    </div> --}}
                    <div class="form-group col-md-4">
                        <label class="titulo-dato"><strong><span class="text-danger">*</span> Tipo de documento </strong></label>
                        <select id="tipo_documento_id" class="form-control" autocomplete="off" required>
                            <option value=""> Selecciona una opción </option>
                            @foreach ($tiposDocumentos as $tipoDocumento)
                                <option value="{{ $tipoDocumento->tipo_documento_id }}"> {{ $tipoDocumento->nombre }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-12">
                        <button type="button" id="btn_cargar_documento" class="btn btn-success"> <i class="fas fa-upload"></i> Cargar documento </button>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <label class="titulo-dato"><strong><span class="text-danger">*</span> Documentos cargados </strong></label>
                        <div class="table-responsive">
                            <table
                                id="tabla_documentos_soporte"
                                data-toggle="table"
                                data-unique-id="documento_id">
                                <thead>
                                    <tr>
                                        <th data-field="nombre_original"><label class="titulo-dato">Nombre original</label></th>
                                        <th data-field="nombre"><label class="titulo-dato">Nombre</label></th>
                                        <th data-field="fecha_subida"><label class="titulo-dato">Fecha de carga</label></th>
                                        <th data-field="tipo_documento.nombre"><label class="titulo-dato">Tipo de documento</label></th>
                                        <th data-field="acciones" data-formatter="acccionesFormatterDocumentos"><label class="titulo-dato">Acciones a realizar</label></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <form id="form_solicitud_viatico" action="{{ route('viatinet.solicitud.viatico', [$solicitudViatico, $instanciaTarea]) }}" method="POST">
        @method('post')
        @csrf
        <div class="card card-custom mt-8">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Datos de la comisión</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato"><strong><span class="text-danger">* </span>Tipo de viático</strong></label>
                        <select class="form-control select2" name="tipo_ambito" id="tipo_ambito" autocomplete="off" required>
                            <option value="">Selecciona una opción</option>
                            @foreach ($tiposAmbitos as $tipoAmbito)
                                <option value="{{ $tipoAmbito->identificador }}">
                                    {{ $tipoAmbito->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row" id="contenedor_paises" style="display: none">
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato"><strong><span class="text-danger">* </span>País</strong></label>
                        <select class="form-control select2" name="pais_id" id="pais_id" autocomplete="off" required>
                            <option value="">Selecciona una opción</option>
                            @foreach ($paises as $pais)
                                <option value="{{ $pais->pais_id }}">
                                    {{ $pais->tipoZonaTarifaria->nombre }} - {{ $pais->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row" id="contenedor_entidades" style="display: none">
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato"><strong><span class="text-danger">* </span>Entidad Federativa</strong></label>
                        <select class="form-control select2" name="entidad_federativa_id" id="entidad_federativa_id" autocomplete="off" required>
                            <option value="">Selecciona una opción</option>
                            @foreach ($entidadesFederativas as $entidadFederativa)
                                <option value="{{ $entidadFederativa->entidad_federativa_id }}">
                                    {{ $entidadFederativa->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato"><strong><span class="text-danger">* </span>Municipio</strong></label>
                        <select class="form-control select2" name="municipio_id" id="municipio_id" autocomplete="off" required>
                            <option value="">Selecciona una opción</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 form-group">
                        <label class="titulo-dato"><strong><span class="text-danger">* </span>Días</strong></label>
                        <input type="number" class="form-control" name="dias" step=".5" placeholder="Días de comisión" autocomplete="off" required>
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="titulo-dato"><strong><span class="text-danger">* </span>Fecha de inicio y final</strong></label>
                        <div class="input-daterange input-group input-rango-fecha" id="rango_fecha">
                            <input type="text" class="form-control" name="fecha_inicio" placeholder="Fecha inicio" autocomplete="off" readonly="true" required>
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="la la-ellipsis-h"></i></span>
                            </div>
                            <input type="text" class="form-control" name="fecha_final" placeholder="Fecha final" autocomplete="off" readonly="true" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 form-group">
                        <label class="titulo-dato"><strong><span class="text-danger">* </span>Motivo</strong></label>
                        <textarea class="form-control normalizar-texto" placeholder="Escriba el motivo..." id="motivo_comision" name="motivo_comision" rows="3" autocomplete="off" required></textarea>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="text-center">
                    <div class="text-center">
                        <button type="submit" class="btn btn-success"><i class="fas fa-check-square"></i> Finalizar tarea</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @include("componentes.view_pdf")
@endsection

@push('scripts')
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
    <script>
        var tiposDocumentos = @json($tiposDocumentos);
        var rutaGuardarDocumentos = @json(route("viatinet.guardar.documentos", $solicitudViatico));
        var rutaGetMunicipios = @json(route("viatinet.getMunicipios"));
        var documentosSolicitud = @json($documentosSolicitud);
        var selectTipoDocumento = $("#tipo_documento_id");
        var btnCargarDocumento = $("#btn_cargar_documento");
        var formDocumentosSoporte = $("#form_documentos_soporte");
        var formSolicitudViatico = $("#form_solicitud_viatico");
        var tablaDocumentosSoporte = $("#tabla_documentos_soporte");
        var contenedorPaises = $("#contenedor_paises");
        var contenedorEntidades = $("#contenedor_entidades");
        var selectTipoAmbito = $("#tipo_ambito");
        var selectPaises = $("#pais_id");
        var selectEntidadesFederativas = $("#entidad_federativa_id");
        var selectMunicipios = $("#municipio_id");
        var inputRangoFecha = $("#rango_fecha");

        var validatorFormDocumentosSoporte = formDocumentosSoporte.validate();

        selectTipoAmbito.select2({placeholder: "Selecciona una opción"});

        tablaDocumentosSoporte.bootstrapTable({data: documentosSolicitud});

        var dropzoneDocumentos = new Dropzone('#dropzone_documentos', {
            headers : {
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            },
            url: rutaGuardarDocumentos,
            method: 'POST',
            paramName: "file",
            maxFiles: 1,
            addRemoveLinks: true,
            autoProcessQueue: false,
            acceptedFiles: "application/pdf",
            maxFilesize: 5, //MB
            accept: function(file, done) {
                done();
            }
        });
        dropzoneDocumentos.on("error", function(file, error, xhr) {
            dropzoneDocumentos.removeFile(file)
            swal.fire(error, "", "error");
        });
        dropzoneDocumentos.on("removedfile", function(file) {
            swal.fire("El archivo se eliminó correctamente", "", "success");
        });

        dropzoneDocumentos.on("sending", function(file, xhr, formData) {
            formData.append("tipo_documento_id", selectTipoDocumento.val());
        });

        btnCargarDocumento.click(function(e) {
            if (validatorFormDocumentosSoporte.form()) {
                if (dropzoneDocumentos.getAcceptedFiles().length == 1) {
                    $(this).addClass("spinner spinner-white spinner-right");
                    $(this).prop('disabled', true);
                    dropzoneDocumentos.processQueue();
                } else {
                    swal.fire("Debe de elegir un documento antes de cargarlo", "", "warning");
                }
            }
        });

        dropzoneDocumentos.on("success", function(file, response) {
            btnCargarDocumento.removeClass("spinner spinner-white spinner-right");
            btnCargarDocumento.prop('disabled', false);
            if (response.estatus) {
                dropzoneDocumentos.removeFile(file);
                selectTipoDocumento.val("");
                tablaDocumentosSoporte.bootstrapTable('insertRow', {
                    index: 0,
                    row: response.documento
                });
                swal.fire("El documento se ha cargado con exito", "", "success");
            } else {
                dropzoneDocumentos.removeFile(file)
                file.status = Dropzone.QUEUED
                file.upload.progress = 0;
                file.upload.bytesSent = 0;
                swal.fire(response.mensaje, "", "error");
            }
        });

        function acccionesFormatterDocumentos(value, row) {
            return `
                <a href="${row.ruta_show}" class="btn btn-icon btn-light btn-hover-primary btn-sm mr-3 btn-view-pdf">
                    <i class="fas fa-eye icon-md text-primary"></i>
                </a>
                <a href="${row.ruta_download}" class="btn btn-icon btn-light btn-hover-primary btn-sm mr-3">
                    <i class="fas fa-download icon-md text-primary"></i>
                </a>
                <a href="${row.ruta_destroy}" class="btn btn-icon btn-light btn-hover-primary btn-sm btn-eliminar-documento">
                    <i class="fas fa-trash icon-md text-primary"></i>
                </a>`;
        }

        var validatorFormSolicitudViatico = formSolicitudViatico.validate({
            onfocusout: false,
            validClass: "is-valid",
            errorClass: "is-invalid",
            errorPlacement: function(label, element) {
                if (element.hasClass("select2")) {
                    element.parent().append(label);
                    element.next().find(".select2-selection.select2-selection--single").css("border-color", "#E60035");
                } else if (element.attr("type") == "radio") {
                    element.closest(".radio-inline").after(label);
                } else if (element.parent().hasClass("input-rango-fecha")) {
                    if (!element.parent().next().hasClass("is-invalid")) {
                        element.parent().after(label);
                    }
                } else {
                    label.insertAfter(element);
                }
            },
            unhighlight: function(element, errorClass, validClass) {
                if ($(element).hasClass("select2")) {
                    $(element).next().find(".select2-selection.select2-selection--single").css({"border": "1px solid", "border-color": "#1BC5BD"});
                } else if ($(element).attr("type") == "radio") {
                    $(element).closest(".radio-inline").next().remove();
                } else {
                    $(element).removeClass(errorClass).addClass(validClass);
                }
            },
            submitHandler: function(form) {
                var existeDocumento = false;

                tiposDocumentos.every((item, index) => {
                    existeDocumento = false;
                    let documentosSoporte = tablaDocumentosSoporte.bootstrapTable('getData');
                    documentosSoporte.forEach((documento, indexDocumento) => {
                        if (item.identificador == documento.tipo_documento.identificador) {
                            existeDocumento = true;
                        }
                    });
                    if (!existeDocumento) {
                        Swal.fire(`Agregue un documento de tipo "${item.nombre}"`, "", "error");
                        return;
                    }
                    return true
                });

                if (existeDocumento) {
                    Swal.fire({
                        title: "¿Está seguro?",
                        text: "Antes de continuar, verifique que los datos ingresados sean correctos. Después de finalizar la tarea, no podrá regresar.",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: "Sí, continuar",
                        cancelButtonText: "Cancelar",
                        reverseButtons: true
                    }).then(function(result) {
                        if (result.value) {
                            form.submit();
                        }
                    });
                }
            }
        });

        selectTipoAmbito.change(function () {
            if ($(this).val() == "nacional") {
                contenedorPaises.hide();
                contenedorEntidades.show();
                selectEntidadesFederativas.select2({placeholder: "Selecciona una opción"});
                selectMunicipios.select2({placeholder: "Selecciona una opción"});
            } else {
                contenedorPaises.show();
                contenedorEntidades.hide();
                selectPaises.select2({placeholder: "Selecciona una opción"});
            }
        });

        selectEntidadesFederativas.change(function () {
            var entidadFederativaId = $(this).val();
            $.get(rutaGetMunicipios, {entidadFederativaId}, function (municipios) {
                selectMunicipios.html("<option value=''>Selecciona una opción</option>");
                municipios.forEach((item, key) => {
                    var option = new Option(`${item.tipo_zona_tarifaria.nombre} - ${item.nombre}`, item.municipio_id);
                    selectMunicipios.append(option);
                });
            });
        });
    </script>
@endpush
