
// Para guardar el Puntaje y el Premio
const formStatusComentario = $("#frm_inconformidades");
const btnStatusComentario = $("#btn_guardar_status_comentario");

btnStatusComentario.click(function() {

    if(document.querySelector(".estatus_inconformidad") && document.querySelector(".comentario_inconformidad") ){

        var estatus_inconformidad = $(".estatus_inconformidad").valid();
        var comentario = $(".comentario_inconformidad").valid();

        if (estatus_inconformidad && comentario ) {

            swal.fire({
                "html": "Esta a punto de guardar <br><b> el Estatus y el Comentario </b><br><br> ¿Está seguro de continuar?",
                "icon": "warning",
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
                        url: urlGuardarRecepcionInconformidades,
                        data: formStatusComentario.serialize(),
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
        }
    }
});

/* var validator = formStatusComentario.validate({
    onfocusout: false,
    rules: {
        "estatus_inconformidad[]": {
            required: true,
        },
        "comentario_inconformidad[]": {
            required: true,
            campoNoVacio: true
        }
    },
    messages: {
        estatus_inconformidad: {
            required: 'Campo obligatorio'
        },
        comentario_inconformidad: {
            required: 'Campo obligatorio',
            campoNoVacio: "No se puede enviar espacios en blanco"
        }
    },
    errorPlacement: function(label, element) {
        element.addClass('error');
        label.insertAfter(element);
    }
}); */

// Para descargar el pdf con el listado de candidatos actualizado
btnListadoCandidatos = $("#listado_candidatos");

btnListadoCandidatos.click(function() {

    swal.fire({
        "html": "Asegúrese de haber guardado previamente los datos, para que el listado este lo más actualizado posible.<br><br> ¿Está seguro de continuar?",
        "icon": "warning",
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

            ajaxPdfListaCandidatosInconformidades(premio_id).done(function(respuesta, xhr, response) {
                var a = document.createElement('a');
                var url = window.URL.createObjectURL(respuesta);
                var nombre = response.getResponseHeader('Content-Disposition').split('filename=')[1];
                nombre = nombre.replace(/['"]+/g, '');

                a.href = url;
                a.download = nombre;
                document.body.append(a);
                a.click();
                a.remove();
                window.URL.revokeObjectURL(url);

                KTApp.unblockPage();
            });
        }
    });
});

function ajaxPdfListaCandidatosInconformidades(premio_id) {
    return $.ajax({
        url: urlDescargarListadoCandidatos+'/'+premio_id,
        type: 'POST',
        async: true,
        xhrFields: {
            responseType: 'blob'
        },
    });
}

const validatorFormFinalizarTarea = formStatusComentario.validate({

    submitHandler: function(form) {

        let estatus_inconformidad = $(".estatus_inconformidad").valid();
        let comentario = $(".comentario_inconformidad").valid();
        if ( estatus_inconformidad && comentario ) {
            Swal.fire({
                title: "¿Está seguro?",
                html: "Antes de continuar, verifique que los datos ingresados sean correctos. Después de finalizar la tarea, no podrá regresar",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Sí, continuar",
                cancelButtonText: "Cancelar",
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    KTApp.blockPage({
                        overlayColor: '#000000',
                        state: 'danger',
                        message: 'Por favor, espere...'
                    });
                    form.submit();
                }
            });
        } else {
            swal.fire({
                "text": "Debes captura la información faltante",
                "icon": "warning",
                "confirmButtonColor": '#0abb87',
                "confirmButtonText": 'Aceptar',
                "allowOutsideClick": false,
            });
        }
    }
});
