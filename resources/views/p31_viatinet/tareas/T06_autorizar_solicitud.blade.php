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
                    "general" => [],
                    "soporte" => [],
                    "comision" => [],
                    "comisionados" => []
                ]
            ])
        </div>
    </div>
    <form id="form_finalizar_tarea" action="{{ route('viatinet.autorizacion', [$solicitudViatico, $instanciaTarea]) }}" method="POST" enctype="multipart/form-data">
        @method('post')
        @csrf
        <div class="card card-custom mt-8">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Autorización</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-4">
                        <label class="titulo-dato"><strong><span class="text-danger">*</span> Respuesta </strong></label>
                        <select id="select_respuesta" name="select_respuesta" class="form-control" autocomplete="off" required>
                            <option value=""> Selecciona una opción </option>
                            <option value="autorizar"> AUTORIZAR </option>
                            <option value="rechazar"> RECHAZAR </option>
                        </select>
                    </div>
                </div>
                <div id="contenedor_form_autorizar" style="display: none">
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label class="titulo-dato"><strong><span class="text-danger">*</span> Documento </strong></label>
                            <div></div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" accept="application/pdf" id="file" name="file" />
                                <label class="custom-file-label" for="customFile" style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">Elegir archivo</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="contenedor_form_rechazar" style="display: none">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label class="titulo-dato"><strong><span class="requeridos">* </span> Motivo de rechazo: </strong></label>
                            <textarea class="form-control normalizar-texto" placeholder="Escriba el motivo" id="motivo_rechazo" name="motivo_rechazo" rows="3"></textarea>
                        </div>
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
    @include("p31_viatinet.tareas.modals.terminos_condiciones")
@endsection

@push('scripts')
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
    <script>
        var formFinalizarTarea = $("#form_finalizar_tarea");
        var selectRespuesta = $("#select_respuesta");
        var contenedorFormAutorizar = $("#contenedor_form_autorizar");
        var contenedorFormRechazar = $("#contenedor_form_rechazar");

        /* Configuración tabla de documentos soporte */
        var documentosSolicitud = @json($documentosSolicitud);
        var tablaDocumentosSoporte = $("#tabla_documentos_soporte");
        tablaDocumentosSoporte.bootstrapTable({data: documentosSolicitud});
        function acccionesFormatterDocumentos(value, row) {
            return `
                <a href="${row.ruta_show}" class="btn btn-icon btn-light btn-hover-primary btn-sm mr-3 btn-view-pdf">
                    <i class="fas fa-eye icon-md text-primary"></i>
                </a>
                <a href="${row.ruta_download}" class="btn btn-icon btn-light btn-hover-primary btn-sm mr-3">
                    <i class="fas fa-download icon-md text-primary"></i>
                </a>`;
        }

        /* Configuración tabla de comisionados */
        var tablaComisionados = $("#tabla_comisionados");
        var comisionados = @json($solicitudViatico->comisionados()->with("tiposPartidas")->get());

        function nombreFormatter(value, row) {
            return `${row.nombre} ${row.apellido_paterno} ${row.apellido_materno == null ? "" : row.apellido_materno}`;
        }

        function tipoPartidaTerrestreFormatter(value, row) {
            if (value === null) {
                return `<span class="label label-default label-pill label-inline mr-2">N/A</span>`;
            }
            return `Importe: ${value.pivot.importe}`;
        }

        function tipoPartidaAereoFormatter(value, row) {
            if (value === null) {
                return `<span class="label label-default label-pill label-inline mr-2">N/A</span>`;
            }
            return `Importe: ${value.pivot.importe}`;
        }

        function tipoPartidaIntegralFormatter(value, row) {
            if (value === null) {
                return `<span class="label label-default label-pill label-inline mr-2">N/A</span>`;
            }
            return `Importe: ${value.pivot.importe}`;
        }

        tablaComisionados.bootstrapTable({data: comisionados});

        selectRespuesta.change(function() {
            if ($(this).val() == "autorizar") {
                contenedorFormAutorizar.show();
                contenedorFormRechazar.hide();
            } else {
                contenedorFormRechazar.show();
                contenedorFormAutorizar.hide();
            }
        });

        var validatorFormFinalizarTarea = formFinalizarTarea.validate({
            onfocusout: false,
            validClass: "is-valid",
            errorClass: "is-invalid",
            submitHandler: function(form) {
                swal.fire({
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
        });


    </script>
@endpush
