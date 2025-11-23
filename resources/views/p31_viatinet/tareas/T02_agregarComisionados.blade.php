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
                ]
            ])
        </div>
    </div>
    <div class="card card-custom mt-8">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">Datos de los comisionados</h3>
            </div>
        </div>
        <div class="card-body">
            <form id="form_comisionados">
                @include("componentes.busqueda_empleado", [
                    "existeEmpleado" => false,
                ])
                <div class="row">
                    <div class="form-group col-md-3">
                        <label class="titulo-dato">Viáticos terrestres</label>
                        <div>
                            <span class="switch switch-icon">
                                <label class="my-0">
                                    <input type="checkbox" id="viaticos_terrestres" name="viaticos_terrestres" autocomplete="off"/>
                                    <span class="my-0"></span>
                                </label>
                            </span>
                        </div>
                    </div>
                    <div class="form-group col-md-3" id="contenedor_viaticos_terrestres" style="display: none">
                        <label class="titulo-dato"><strong><span class="text-danger">* </span>Importe</strong></label>
                        <input type="text" class="form-control" name="importe_terrestres" placeholder="Importe" autocomplete="off" required>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-3">
                        <label class="titulo-dato">Viáticos aéreos</label>
                        <div>
                            <span class="switch switch-icon">
                                <label class="my-0">
                                    <input type="checkbox" id="viaticos_aereos" name="viaticos_aereos" autocomplete="off"/>
                                    <span class="my-0"></span>
                                </label>
                            </span>
                        </div>
                    </div>
                    <div class="form-group col-md-3" id="contenedor_viaticos_aereos" style="display: none">
                        <label class="titulo-dato"><strong><span class="text-danger">* </span>Importe</strong></label>
                        <input type="text" class="form-control" name="importe_aereos" placeholder="Importe" autocomplete="off" required>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-3">
                        <label class="titulo-dato">Viáticos integrales</label>
                        <div>
                            <span class="switch switch-icon">
                                <label class="my-0">
                                    <input type="checkbox" id="viaticos_integrales" name="viaticos_integrales" autocomplete="off"/>
                                    <span class="my-0"></span>
                                </label>
                            </span>
                        </div>
                    </div>
                    <div class="form-group col-md-3" id="contenedor_viaticos_integrales" style="display: none">
                        <label class="titulo-dato"><strong><span class="text-danger">* </span>Importe</strong></label>
                        <input type="text" class="form-control" name="importe_integrales" placeholder="Importe" autocomplete="off" required>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <button type="button" id="btn_agregar_comisionado" class="btn btn-success"> <i class="fas fa-plus"></i> Agregar comisionado </button>
                    </div>
                </div>
            </form>
            <div class="table-responsive">
                <table
                    id="tabla_comisionados"
                    data-toggle="table"
                    data-unique-id="comisionado_id">
                    <thead>
                        <tr>
                            <th data-field="numero_empleado"><label class="titulo-dato">Número de empleado</label></th>
                            <th data-field="nombre" data-formatter="nombreFormatter"><label class="titulo-dato">Nombre completo</label></th>
                            <th data-field="rfc"><label class="titulo-dato">RFC</label></th>
                            <th data-field="puesto"><label class="titulo-dato">Puesto</label></th>
                            <th data-field="nivel_salarial"><label class="titulo-dato">Nivel salarial</label></th>
                            <th data-field="tipo_partida_terreste" data-formatter="tipoPartidaTerrestreFormatter"><label class="titulo-dato">Viáticos terrestres</label></th>
                            <th data-field="tipo_partida_aereo" data-formatter="tipoPartidaAereoFormatter"><label class="titulo-dato">Viáticos aereos</label></th>
                            <th data-field="tipo_partida_integral" data-formatter="tipoPartidaIntegralFormatter"><label class="titulo-dato">Viáticos integrales</label></th>
                            <th data-field="acciones" data-formatter="acccionesFormatter" data-events="operateEventsAcciones"><label class="titulo-dato">Acciones</label></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <form id="form_finalizar_tarea" action="{{ route('viatinet.agregar.comisionados', [$solicitudViatico, $instanciaTarea]) }}" method="POST">
        @method('post')
        @csrf
        <div class="card card-custom mt-8">
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
    <script src="{{ asset('js/componentes/busqueda_empleado.js') }}"></script>
    <script>
        var rutaGuardarComisionados = @json(route("viatinet.guardar.comisionados", $solicitudViatico));
        var rutaEliminarComisionados = @json(route("viatinet.eliminar.comisionados", $solicitudViatico));
        var btnAgregarComisionado = $("#btn_agregar_comisionado");
        var formComisionados = $("#form_comisionados");
        var formFinalizarTarea = $("#form_finalizar_tarea");
        var cbViaticosTerrestres = $("#viaticos_terrestres");
        var cbViaticosAereos = $("#viaticos_aereos");
        var cbViaticosIntegrales = $("#viaticos_integrales");
        var contenedorViaticosTerrestres = $("#contenedor_viaticos_terrestres");
        var contenedorViaticosAereos = $("#contenedor_viaticos_aereos");
        var contenedorViaticosIntegrales = $("#contenedor_viaticos_integrales");

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
        function acccionesFormatter(value, row) {
            return `
                <button class="btn btn-icon btn-light btn-hover-primary btn-sm eliminar">
                    <i class="fas fa-trash icon-md text-primary"></i>
                </button>`;
        }

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

        var operateEventsAcciones = {
            'click .eliminar': function (e, value, row, index) {
                swal.fire({
                    title: "¿Está seguro?",
                    text: "No podrá revertir esta acción",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Sí, continuar",
                    cancelButtonText: "Cancelar",
                    reverseButtons: true
                }).then(function(result) {
                    if (result.value) {
                        let comisionadoId = row.comisionado_id;
                        $.post(rutaEliminarComisionados, {comisionadoId}, (resp) => {
                            if (resp.estatus) {
                                tablaComisionados.bootstrapTable('removeByUniqueId', comisionadoId);
                                swal.fire("El comisionado se eliminó correctamente.", "", "success");
                            } else {
                                swal.fire(resp.mensaje, "", "error");
                            }
                        });
                    }
                });
            }
        }

        tablaComisionados.bootstrapTable({data: comisionados});

        var validatorFormComisionados = formComisionados.validate({
            validClass: "is-valid",
            errorClass: "is-invalid"
        });

        cbViaticosTerrestres.change(function () {
            if ($(this).is(':checked')) {
                contenedorViaticosTerrestres.show();
            } else {
                contenedorViaticosTerrestres.hide();
            }
        });

        cbViaticosAereos.change(function () {
            if ($(this).is(':checked')) {
                contenedorViaticosAereos.show();
            } else {
                contenedorViaticosAereos.hide();
            }
        });

        cbViaticosIntegrales.change(function () {
            if ($(this).is(':checked')) {
                contenedorViaticosIntegrales.show();
            } else {
                contenedorViaticosIntegrales.hide();
            }
        });

        btnAgregarComisionado.click(function(e) {
            if (validatorFormComisionados.form()) {
                $.post(rutaGuardarComisionados, formComisionados.serialize(), function (resp) {
                    if (resp.estatus) {
                        tablaComisionados.bootstrapTable('insertRow', {
                            index: 0,
                            row: resp.comisionado
                        });
                        formComisionados.trigger("reset");
                        validatorFormComisionados.resetForm();
                        contenedorViaticosTerrestres.hide();
                        contenedorViaticosAereos.hide();
                        contenedorViaticosIntegrales.hide();
                        $('#datos_empleado').val(null).trigger('change');
                        $(".select2").css({"border-color": ""});
                        swal.fire("El comisionado se ha cargado con exito", "", "success");
                    } else {
                        swal.fire(resp.mensaje, "", "error")
                    }
                });
            }
        });

        var validatorFormFinalizarTarea = formFinalizarTarea.validate({
            onfocusout: false,
            validClass: "is-valid",
            errorClass: "is-invalid",
            submitHandler: function(form) {
                let comisionados = tablaComisionados.bootstrapTable('getData');
                if (comisionados.length > 0) {
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
                } else {
                    swal.fire("Debe agregar al menos un comisionado", "", "error")
                }
            }
        });
    </script>
@endpush
