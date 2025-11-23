const formDatosIniciales = $("#form_selecciona_servicio");
const btnFinalizarSeleccionServicio = $("#btn_finalizar_seleccion_servicio");
let dropzoneSubirImagenesEvidencia = null;

// Función que genera el Switch de Urgente
let Switch = function() {
    let activaSwitch = function() {
        $('[data-switch=true]').bootstrapSwitch();
    };
    return {
        init: function() {
            activaSwitch();
        },
    };
}();

$(document).ready(function () {

    /* if ( solicitaServicio.servicio_general_id == 2 ) {
        $( "#tipo_servicio_id" ).prop( "disabled", true );
        $('#select-tipo-de-servicio-container').addClass('d-none');

        $('#cantidad-solicitud-container').removeClass('d-none');
        $( "#cantidad_solicitud" ).prop( "disabled", false );
    } else */ if ( solicitaServicio.servicio_general_id == 4 || solicitaServicio.servicio_general_id == 3 || solicitaServicio.servicio_general_id == 2 ) {
        $( "#cantidad_solicitud" ).prop( "disabled", true );
        $('#cantidad-solicitud-container').addClass('d-none');

        $('#select-tipo-de-servicio-container').removeClass('d-none');
        $( "#tipo_servicio_id" ).prop( "disabled", false );
    } else {
        $( "#cantidad_solicitud" ).prop( "disabled", true );
        $('#cantidad-solicitud-container').addClass('d-none');

        $( "#tipo_servicio_id" ).prop( "disabled", true );
        $('#select-tipo-de-servicio-container').addClass('d-none');
    }

    // Inicializa el Switch
    Switch.init();

    //Inicia el RichText TinyMCE
    tinymce.init({
        selector: '#texto_solicitud',
        plugins : 'advlist autolink link image lists charmap print preview',
        toolbar: [
            ' fontselect |  fontsizeselect | bold italic underline | alignleft aligncenter alignright '
          ],
          language : 'es_MX',
          menubar: false,
          branding: false,
          statusbar: false,

        setup: function(editor) {
			editor.on('change', function(e) {
                tinyMCE.triggerSave();
                if ($("#" + editor.id ).siblings('.tox.tox-tinymce').next().length > 0) {
                    if ($("#" + editor.id).valid()) {
                        $("#" + editor.id ).siblings('.tox.tox-tinymce').removeClass('error')
                    } else {
                        $("#" + editor.id ).siblings('.tox.tox-tinymce').addClass('error')
                    }
                }
			});
		}

    });

    // Función que evalua que los campos de texto no acepten numeros
    $.validator.addMethod("digitosTelefono", function(value, element) {
        return this.optional(element) || /^[0-9]{10}$/i.test(value);
    });

    formDatosIniciales.validate({
        ignore: "",
        onfocusout: false,
        rules: {
            servicio_general_id: {
                required: true
            },
            tipo_servicio_id: {
                required: true
            },
            texto_solicitud: {
                tinyMCE: true
            },
            contacto_servicio: {
                required: true,
                soloLetras: true,
                campoNoVacio: true
            },
            contacto_correo: {
                required: true,
                campoNoVacio: true
            },
            telefono_servicio : {
                required: true,
                campoNoVacio: true,
                number: true,
                digitosTelefono: true
            },
            sub_area : {
                required: true,
                campoNoVacio: true,
            },
            direccion_servicio : {
                required: true,
                campoNoVacio: true
            },
        },
        messages: {
            servicio_general_id : {
                required : 'Debe seleccionar una opción'
            },
            tipo_servicio_id : {
                required : 'Debe seleccionar una opción'
            },
            texto_solicitud : {
                tinyMCE: 'Este campo debe ser llenado'
            },
            contacto_servicio: {
                required : 'Este campo debe ser llenado',
                soloLetras : 'Este campo sólo acepta letras',
                campoNoVacio: "No deje espacios en blanco al inicio del texto"
            },
            contacto_correo: {
                required : 'Este campo debe ser llenado',
                campoNoVacio: "No deje espacios en blanco al inicio del texto"
            },
            telefono_servicio: {
                required : 'Este campo debe ser llenado',
                campoNoVacio: "No deje espacios en blanco al inicio del texto",
                number : 'Este campo sólo acepta numeros',
                digitosTelefono: 'El número telefónio debe tener 10 dígitos'
            },
            sub_area : {
                required : 'Este campo debe ser llenado',
                campoNoVacio: "No deje espacios en blanco al inicio del texto",
            },
            direccion_servicio: {
                required : 'Este campo debe ser llenado',
                campoNoVacio: "No deje espacios en blanco al inicio del texto"
            },
        },
        errorPlacement: function(label, element) {
            if ( element.attr('id') == 'texto_solicitud' ) {
                const textAreaTinyMCE = element.next();
                if (label.text() != "") {
                    textAreaTinyMCE
                            .addClass('error');
                }

                textAreaTinyMCE.after(label);
            }
            else {
                element.addClass('error');
                label.insertAfter(element);
            }

        }
    });

    if (tipoServicio.clave === "mantenimiento" || tipoServicio.clave === "telefonia") {
        inicializardropZone();
    } else if (tipoServicio.clave === "reproduccion") {
        inicializardropZonePDF();
    }

    btnFinalizarSeleccionServicio.click(function (e) {
        e.preventDefault();
        const isValid =  formDatosIniciales.valid();

        if ( isValid ) {
            // Cuando se captura una solicitud de servicio se valida que lleve imagenes
            if ( tipoServicio.clave === "mantenimiento" ) {
                if ( dropzoneSubirImagenesEvidencia.getAcceptedFiles().length > 0 ) {
                    Swal.fire({
                        title: "Finalizar tarea",
                        text: "¿Esta seguro(a) de terminar esta tarea?",
                        icon: "question",
                        showCancelButton: true,
                        cancelButtonColor: '#F64E60',
                        cancelButtonText: "Cancelar",
                        confirmButtonText: "Continuar",
                        confirmButtonColor: '#0BB7AF',
                        reverseButtons: true,
                    }).then(function(result) {
                        if (result.value) {
                            KTApp.blockPage({
                                overlayColor: '#000000',
                                state: 'danger',
                                message: 'Por favor, espere...'
                            });
                            // Se envian la imagenes para su guardado y si todo sale ok, despues en el evento success de DropZone se lanza el submit
                            dropzoneSubirImagenesEvidencia.processQueue();
                        }
                    });
                } else {
                    Swal.fire({
                        title: "Finalizar tarea",
                        html: "Para finalizar la tarea,<br> <b> debes capturar evidencias (Imagenes) </b>",
                        icon: 'warning',
                        confirmButtonColor: '#0BB7AF',
                        confirmButtonText: 'Ok'
                    });
                }
            } else {
                Swal.fire({
                    title: "Finalizar tarea",
                    text: "¿Esta seguro(a) de terminar esta tarea?",
                    icon: "question",
                    showCancelButton: true,
                    cancelButtonColor: '#F64E60',
                    cancelButtonText: "Cancelar",
                    confirmButtonText: "Continuar",
                    confirmButtonColor: '#0BB7AF',
                    reverseButtons: true,
                }).then(function(result) {
                    if (result.value) {
                        KTApp.blockPage({
                            overlayColor: '#000000',
                            state: 'danger',
                            message: 'Por favor, espere...'
                        });
                        if ( tipoServicio.clave === "telefonia" ) {
                            if ( dropzoneSubirImagenesEvidencia.getAcceptedFiles().length > 0 ) {
                                // Se envian la imagenes para su guardado y si todo sale ok, despues en el evento success de DropZone se lanza el submit
                                dropzoneSubirImagenesEvidencia.processQueue();
                            } else {
                                // Con los demas servicios solo se hace submit
                                formDatosIniciales.submit();
                            }
                        } else if (tipoServicio.clave === "reproduccion") {
                            if ( dropzoneSubirPDFEvidencia.getAcceptedFiles().length > 0 ) {
                                // Se envian la imagenes para su guardado y si todo sale ok, despues en el evento success de DropZone se lanza el submit
                                dropzoneSubirPDFEvidencia.processQueue();
                            } else {
                                // Con los demas servicios solo se hace submit
                                formDatosIniciales.submit();
                            }
                        } else {
                            // Con los demas servicios solo se hace submit
                            formDatosIniciales.submit();
                        }
                    }
                });
            }
        } else {
            Swal.fire({
                title: "Finalizar tarea",
                html: "Para finalizar la tarea,<br> <b> debes capturar la información </b>",
                icon: 'warning',
                confirmButtonColor: '#0BB7AF',
                confirmButtonText: 'Ok'
            });
        }

    });

});


function inicializardropZone() {
    // Url para guardar la imagenes de solicitud de servicio en base64 en la DB
    const urlEnviarImagenesEvidencia = $('#id_dropzone_imagenes_evidencia_solicita_servicio').data('url');
    dropzoneSubirImagenesEvidencia = new Dropzone('#id_dropzone_imagenes_evidencia_solicita_servicio', {
        headers : {
            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        },
        url: urlEnviarImagenesEvidencia,
        method: 'POST',
        paramName: "file",
        uploadMultiple: true,
        maxFiles: 3,
        parallelUploads: 3,
        acceptedFiles: "image/*",
        maxFilesize: 10,
        dictMaxFilesExceeded: "Solo puedes subir 3 imagenes",
        addRemoveLinks: true,
        autoProcessQueue: false,
        accept: function(file, done) {
            done();
        }
    });

    dropzoneSubirImagenesEvidencia.on("error", function(file, error, xhr) {
        dropzoneSubirImagenesEvidencia.removeFile(file)
        Swal.fire({
            title: "",
            html: "No puedes subir más de 3 archivos",
            icon: 'warning',
            confirmButtonColor: '#0BB7AF',
            confirmButtonText: 'Ok'
        });
    });

    dropzoneSubirImagenesEvidencia.on("removedfile", function(file) {
        Swal.fire({
            title: "",
            html: "Se elimino el archivo correctamente",
            icon: 'warning',
            confirmButtonColor: '#0BB7AF',
            confirmButtonText: 'Ok'
        });
    });

    dropzoneSubirImagenesEvidencia.on("sending", function(file, xhr, formData) {
        /* formData.append("nombre_documento", 'NOMBRE');
        formData.append("tipo_documento_expediente", 'TIPODOC'); */
    });

    dropzoneSubirImagenesEvidencia.on("success", function(file, response) {
        if (response.estatus) {
            formDatosIniciales.submit();
        } else {
            dropzoneSubirImagenesEvidencia.removeFile(file);
            file.status = Dropzone.QUEUED
            file.upload.progress = 0;
            file.upload.bytesSent = 0;
            Swal.fire({
                title: "",
                html: response.mensaje,
                icon: 'warning',
                confirmButtonColor: '#0BB7AF',
                confirmButtonText: 'Ok'
            });
        }
    });
}

function inicializardropZonePDF() {
    // Url para guardar la imagenes de solicitud de servicio en base64 en la DB
    const urlEnviarImagenesEvidencia = $('#id_dropzone_pdfs_evidencia_solicita_servicio').data('url');
    dropzoneSubirPDFEvidencia = new Dropzone('#id_dropzone_pdfs_evidencia_solicita_servicio', {
        headers : {
            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        },
        url: urlEnviarImagenesEvidencia,
        method: 'POST',
        paramName: "file",
        uploadMultiple: false,
        maxFiles: 1,
        parallelUploads: 1,
        acceptedFiles: "application/pdf",
        maxFilesize: 10,
        dictMaxFilesExceeded: "Solo puedes subir un archivo PDF",
        dictInvalidFileType: "Solo se permiten archivos PDF",
        addRemoveLinks: true,
        autoProcessQueue: false,
        accept: function(file, done) {
            done();
        }
    });

    dropzoneSubirPDFEvidencia.on("error", function(file, error, xhr) {
        dropzoneSubirPDFEvidencia.removeFile(file)
        Swal.fire({
            title: "",
            html: "No puedes subir más de 1 archivos",
            icon: 'warning',
            confirmButtonColor: '#0BB7AF',
            confirmButtonText: 'Ok'
        });
    });

    dropzoneSubirPDFEvidencia.on("removedfile", function(file) {
        Swal.fire({
            title: "",
            html: "Se elimino el archivo correctamente",
            icon: 'warning',
            confirmButtonColor: '#0BB7AF',
            confirmButtonText: 'Ok'
        });
    });

    dropzoneSubirPDFEvidencia.on("sending", function(file, xhr, formData) {
        /* formData.append("nombre_documento", 'NOMBRE');
        formData.append("tipo_documento_expediente", 'TIPODOC'); */
    });

    dropzoneSubirPDFEvidencia.on("success", function(file, response) {
        if (response.estatus) {
            formDatosIniciales.submit();
        } else {
            dropzoneSubirPDFEvidencia.removeFile(file);
            file.status = Dropzone.QUEUED
            file.upload.progress = 0;
            file.upload.bytesSent = 0;
            Swal.fire({
                title: "",
                html: response.mensaje,
                icon: 'warning',
                confirmButtonColor: '#0BB7AF',
                confirmButtonText: 'Ok'
            });
        }
    });
}




