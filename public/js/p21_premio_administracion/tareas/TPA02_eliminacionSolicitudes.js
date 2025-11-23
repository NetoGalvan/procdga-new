
$(document).ready(function(){

    if ( hayCandidatos.length == 0 ) {
        $("#btn_guardar_estado").hide();
    }else{
        $("#btn_guardar_estado").show();
    }

});

formEliminarSolicitudes = $("#frm_eliminacion_solicitudes");
btnGuardarEstado = $("#btn_guardar_estado");

btnGuardarEstado.click(function(e) {
    e.preventDefault();

    if(document.querySelector(".estado_candidatos") && document.querySelector(".razon") ){

        var estados = $(".estado_candidatos").valid();
        var razones = $(".razon").valid();

        if (estados && razones) {

            var estadoCandidatos = $('.estado_candidatos').val();
            var razones = $('.razon').val();

            swal.fire({
                "html": "Verifique que la información sea correcta <br><br> ¿Está seguro de continuar?",
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
                        url: urlGuardarAvance,
                        data: $('#frm_eliminacion_solicitudes').serialize(),
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

                                    if (result.value) {

                                        swal.fire({
                                            "title": "A continuación, se generará un archivo con el listado de los empleados agregados.",
                                            "icon": "success",
                                            "confirmButtonColor": '#0abb87',
                                            "confirmButtonText": 'Aceptar',
                                            "allowOutsideClick": false,
                                        }).then((result) => {
                                            KTApp.blockPage({
                                                overlayColor: '#000000',
                                                state: 'danger',
                                                message: 'Por favor, espere...'
                                            });
                                            if (result.value) {
                                                ajaxPdfListaCandidatos(data.premio).done(function(respuesta, xhr, response) {
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
                                    }

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

    }else{
    }
});

function ajaxPdfListaCandidatos(premio) {
    return $.ajax({
        url: rutaDescargarListaCandidatos+'/'+premio,
        type: 'POST',
        async: true,
        xhrFields: {
            responseType: 'blob'
        },
    });
}

/* var validator = formEliminarSolicitudes.validate({
    onfocusout: false,
    rules: {
        "estado_candidatos[]": {
            required: true,
        },
        "razon[]": {
            required: true,
            campoNoVacio: true
        }
    },
    messages: {
        estado_candidatos: {
            required: 'Campo obligatorio'
        },
        razon: {
            required: 'Campo obligatorio',
            campoNoVacio: "No se puede enviar espacios en blanco"
        }
    },
    errorPlacement: function(label, element) {
        element.addClass('error');
        label.insertAfter(element);
    }
}); */

btnFinalizarTPA02 = $("#btn_finalizar_TPA02");

const validatorFormFinalizarTarea = formEliminarSolicitudes.validate({
    submitHandler: function(form) {
        if (inscripcionExiste) {
            Swal.fire({
                title: "¿Está seguro?",
                html: "Tome en cuenta que al cerrar la convocatoria <b><br> ya no podrán inscribirse más candidatos</b> <br><br> ¿Está seguro que desea cerrar la convocatoria?",
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
            Swal.fire({
                title: 'Debes esperar a que el área inicie y concluya el proceso de inscripción',
                icon: 'error',
                confirmButtonColor: '#0BB7AF',
                confirmButtonText: 'Ok'
            })
        }
    }
});
