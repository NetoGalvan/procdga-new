
var tablaDatosEmpleado = $('#tabla_datos_empleado');
const btnBuscar = $("#btn_buscar_empleado");
const formValidarEmpleado = $( "#frm_busqueda_empleado" );
const selectEmpleadosT01 = $("#datos_empleado");

$(document).ready(function(){

    if ( yaTieneConvocatoria != null ) {
        $("#seleccion_convocatoria").hide();
        $("#btn_guardar_convocatoria").prop('disabled', true);
        $("#datos_premio").show();
        $("#solicitud_premio").show();
    }

    tablaDatosEmpleado.bootstrapTable();

});

// Para cancelar el proceso
btnCancelarProceso = $("#btn_cancelar_proceso");

btnCancelarProceso.click(function() {

    var obj = new Object();
    obj.instancia_id = instancia_id;
    obj.p21_inscripcion_id = p21_inscripcion_id;

    swal.fire({
        "html": "Esta a punto de cancelar el proceso: <br><b> Inscripción al Premio de Administración. </b><br><br> ¿Está seguro de continuar?",
        "icon": "question",
        "confirmButtonColor": '#0abb87',
        "confirmButtonText": 'Aceptar',
        "showCancelButton": true,
        "cancelButtonColor": '#fd397a',
        "cancelButtonText": 'Cancelar',
        "allowOutsideClick": false,
    }).then((result) => {

        if (result.value) {

            KTApp.blockPage({
                overlayColor: '#000000',
                state: 'danger',
                message: 'Por favor, espere...'
            });

            $.ajax({
                type: "POST",
                url: cancelarProceso,
                data: obj,
                asyn:false,
                success: function(data){
                    KTApp.unblockPage();
                    if ( data.estatus ) {
                        swal.fire({
                            "text": data.mensaje,
                            "icon": "success",
                            "confirmButtonColor": '#0abb87',
                            "confirmButtonText": 'Aceptar',
                            "allowOutsideClick": false,
                        }).then((result) => {
                            window.location.href = data.ruta;
                        });

                    }else{
                        swal.fire({
                            "text": data.mensaje,
                            "icon": "warning",
                            "confirmButtonColor": '#0abb87',
                            "confirmButtonText": 'Aceptar',
                            "allowOutsideClick": false,
                        });
                    };
                }
            });
        }
    });
});

formGuardarConvocatoria = $("#form_guardar_convocatoria");
btnGuardarConvocatoria = $("#btn_guardar_convocatoria");

btnGuardarConvocatoria.click(function() {

    if ( $("#form_guardar_convocatoria").valid() ) {

        var obj = new Object();
        obj.folio = $('#folio').val();
        obj.convocatoria = $('#convocatoria').val();
        obj.tipo = "guardarConvocatoria";

        var url = $('#form_guardar_convocatoria').attr('action');

        swal.fire({
            "html": "Esta por guardar la convocatoria: <br><b>" +obj.convocatoria+ "</b><br><br> ¿Está seguro de continuar?",
            "icon": "question",
            "confirmButtonColor": '#0abb87',
            "confirmButtonText": 'Aceptar',
            "showCancelButton": true,
            "cancelButtonColor": '#fd397a',
            "cancelButtonText": 'Cancelar',
            "allowOutsideClick": false,
        }).then((result) => {

            if (result.value) {

                KTApp.blockPage({
                    overlayColor: '#000000',
                    state: 'danger',
                    message: 'Por favor, espere...'
                });

                $.ajax({

                    type: "POST",
                    url: url,
                    data: obj,
                    asyn:false,
                    success: function(data){
                        KTApp.unblockPage();
                        if ( data.estatus ) {
                            swal.fire({
                                "text": data.mensaje,
                                "icon": "success",
                                "confirmButtonColor": '#0abb87',
                                "confirmButtonText": 'Aceptar',
                                "allowOutsideClick": false,
                            }).then((result) => {

                                $("#btn_guardar_convocatoria").prop('disabled', true);
                                $("#seleccion_convocatoria").hide();
                                $("#datos_premio").show();
                                $("#solicitud_premio").show();

                                $('#fecha_convocatoria').html( data.fecha_convocatoria );
                                $('#comentario_admin').html( data.comentario_admin );
                                $('#fechas_evaluacion').html( data.fecha_inicio + '  al  ' + data.fecha_fin );
                            });

                        }else{

                            if (data.fallo_por == "error") {
                                swal.fire({
                                    "text": data.mensaje,
                                    "icon": "warning",
                                    "confirmButtonColor": '#0abb87',
                                    "confirmButtonText": 'Aceptar',
                                    "allowOutsideClick": false,
                                });
                            } else if (data.fallo_por == "cerrada") {
                                swal.fire({
                                    "title": data.title,
                                    "text": data.mensaje,
                                    "icon": "warning",
                                    "confirmButtonColor": '#0abb87',
                                    "confirmButtonText": 'Aceptar',
                                    "allowOutsideClick": false,
                                });
                            }
                        };
                    }
                });
            }
        });
    }
});

$.validator.addMethod("select", function(value, element, arg){
    return arg !== value;
    }, 'Seleccione una opción');

var validator = formGuardarConvocatoria.validate({
    onfocusout: false,
    rules: {
        convocatoria: {
            required: true,
            select: '-1'
        }
    },
    messages: {
        convocatoria: {
            required: 'Campo obligatorio'
        }
    },
    errorPlacement: function(label, element) {
        element.addClass('error');
        label.insertAfter(element);
    }
});

//Para guardar el segundo formulario y terminar la tarea

formFinalizarTarea = $("#form_completar_tarea");
btnFinalizarTarea = $("#btn_finalizar_T01");

btnFinalizarTarea.click(function() {

    if ( $("#form_completar_tarea").valid() && $("#frm_busqueda_empleado").valid() ) {

        if ( $("#tabla_datos_empleado").bootstrapTable('getData').length >= 1 ) {

            var datosTabla = $("#tabla_datos_empleado").bootstrapTable('getData');
            var arreglos =$("#arreglos").val();
            var comentarios =$("#comentarios").val();
            let datos_empleado = selectEmpleadosT01.val();

            var obj = new Object();
            obj.datosTabla = datosTabla;
            obj.arreglos = arreglos;
            obj.comentarios = comentarios;
            obj.tipo = "finalizarTarea";
            obj.datos_empleado = datos_empleado;

            var url = $('#form_completar_tarea').attr('action');

            swal.fire({
                "html": "Esta por finalizar la tarea <br><b> Busqueda y captura de formatos. </b><br><br> ¿Está seguro de continuar?",
                "icon": "question",
                "confirmButtonColor": '#0abb87',
                "confirmButtonText": 'Aceptar',
                "showCancelButton": true,
                "cancelButtonColor": '#fd397a',
                "cancelButtonText": 'Cancelar',
                "allowOutsideClick": false,
            }).then((result) => {

                if (result.value) {

                    $.ajax({

                        type: "POST",
                        url: url,
                        data: obj,
                        asyn:false,
                        success: function(data){

                            if ( data.estatus ) {
                                swal.fire({
                                    "text": data.mensaje,
                                    "icon": "success",
                                    "confirmButtonColor": '#0abb87',
                                    "confirmButtonText": 'Aceptar',
                                    "allowOutsideClick": false,
                                }).then((result) => {
                                    window.location.href = data.ruta;
                                });

                            }else{
                                swal.fire({
                                    "text": data.mensaje,
                                    "icon": "warning",
                                    "confirmButtonColor": '#0abb87',
                                    "confirmButtonText": 'Aceptar',
                                    "allowOutsideClick": false,
                                });
                            };
                        }
                    });
                }
            });
        }else{

            swal.fire({
                "text": "Debe buscar y obtener los datos de un empleado antes de finalizar la tarea",
                "icon": "warning",
                "confirmButtonColor": '#0abb87',
                "confirmButtonText": 'Aceptar',
                "allowOutsideClick": false,
            });
        }
    }
});

var validator = formFinalizarTarea.validate({
    onfocusout: false,
    rules: {
        comentarios: {
            required: true,
            campoNoVacio: true
        }
    },
    messages: {
        comentarios: {
            required: 'Campo obligatorio',
            campoNoVacio: "No se puede enviar espacios en blanco"
        }
    },
    errorPlacement: function(label, element) {
        element.addClass('error');
        label.insertAfter(element);
    }
});

function unidadAdministrativaFormatter(value, row) {
    let rfc = row.unidad_administrativa.nombre_unidad;
    return `${rfc}`;
}

function accionesFormatterDescargarReportes(value, row) {
    let acciones =  `<a type="button"
                        href="javascript:void(0);"
                        class="btn btn-sm btn-danger btn-icon"
                        data-url="${urlPdfPropuestaCandidato}/${row.rfc}"
                        data-toggle="tooltip"
                        title="Propuesta de candidato"
                        onclick="downloadPdf(this)">
                        <i class="fas fa-file-pdf"></i>
                    </a>

                    <a type="button"
                        href="javascript:void(0);"
                        class="btn btn-sm btn-danger btn-icon"
                        data-url="${urlPdfCedulaDesempeno}/${row.rfc}"
                        data-toggle="tooltip"
                        title="Cédula de desempeño"
                        onclick="downloadPdf(this)">
                        <i class="fas fa-file-pdf"></i>
                    </a>

                    <a type="button"
                        href="javascript:void(0);"
                        class="btn btn-sm btn-danger btn-icon"
                        data-url="${urlPdfCedulaCursos}/${row.rfc}"
                        data-toggle="tooltip"
                        title="Cédula de cursos"
                        onclick="downloadPdf(this)">
                        <i class="fas fa-file-pdf"></i>
                    </a>

                    <a type="button"
                        href="javascript:void(0);"
                        class="btn btn-sm btn-danger btn-icon"
                        data-url="${urlPdfPuntualidadAsistencia}/${row.rfc}"
                        data-toggle="tooltip"
                        title="Control de puntualidad y asistencia"
                        onclick="downloadPdf(this)">
                        <i class="fas fa-file-pdf"></i>
                    </a>`;

    return acciones;
}

function downloadPdf(element) {
    var url = element.getAttribute('data-url');

    KTApp.blockPage({
        overlayColor: '#000000',
        state: 'danger',
        message: 'Por favor, espere...'
    });

    $.ajax({
        url: url,
        method: 'GET',
        xhrFields: {
            responseType: 'blob' // Important for handling binary data
        },
        success: function(data, status, xhr) {
            KTApp.unblockPage();
            var disposition = xhr.getResponseHeader('Content-Disposition');
            var filename = '';
            if (disposition && disposition.indexOf('attachment') !== -1) {
                var matches = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/.exec(disposition);
                if (matches != null && matches[1]) {
                    filename = matches[1].replace(/['"]/g, '');
                }
            }
            var a = document.createElement('a');
            var url = window.URL.createObjectURL(data);
            a.href = url;
            a.download = filename || 'download.pdf'; // Default filename if not provided
            document.body.appendChild(a);
            a.click();
            window.URL.revokeObjectURL(url);
            a.remove();
        },
        error: function() {
            alert('Error al descargar el archivo.');
        }
    });
}

function validacionForm() {

    const validacion = formValidarEmpleado.validate({
        onfocusout: false,
        rules: {
            datos_empleado : {
                required: true
            }
        },
        messages: {
            datos_empleado: {
                required : 'Seleccione una opción'
            }
        },
        errorPlacement: function(error, element) {
            if (element.hasClass('select2') && element.next('.select2-container').length) {
                error.insertAfter(element.next('.select2-container'));
            } else {
                error.insertAfter(element);
            }

        },
    });

    return validacion;
}

btnBuscar.click(function(e) {

    e.preventDefault();

    let validacion = validacionForm();
    let validado = validacion.form();

    if (validado) {

        let datos_empleado = selectEmpleadosT01.val();

        KTApp.blockPage({
            overlayColor: '#000000',
            state: 'danger',
            message: 'Por favor, espere...'
        });

        $.ajax({

            type: "POST",
            url: urlValidarEmpleado,
            data: {datos_empleado},
            success: function(response){
                KTApp.unblockPage();
                if (response.estatus) {
                        Swal.fire("Datos verificados correctamente", "", "success");
                        tablaDatosEmpleado.bootstrapTable("destroy");
                        tablaDatosEmpleado.bootstrapTable({data: [response.empleado] });
                } else {
                    Swal.fire(response.mensaje, "", "error");
                    tablaDatosEmpleado.bootstrapTable("destroy");
                    tablaDatosEmpleado.bootstrapTable();
                }
            }
        });

    } else {
        Swal.fire({
            title: 'Debes buscar y seleccionar a un empleado para poder continuar',
            icon: 'error',
            confirmButtonColor: '#0BB7AF',
            confirmButtonText: 'Ok'
        })
    }
});
