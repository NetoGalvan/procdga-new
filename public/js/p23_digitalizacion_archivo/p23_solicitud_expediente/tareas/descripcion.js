
formIniciarProceso = $("#form_iniciar_proceso_p23_solicitud");
btnIniciarProceso = $("#btn_iniciar_proceso_p23_solicitud");

btnIniciarProceso.click(function() {

    var url = $('#form_iniciar_proceso_p23_solicitud').attr('action');

    swal.fire({
        "html": "Esta a punto de iniciar el proceso: <br><b> Solicitud de expediente. </b><br> Se creará un folio y la primer tarea del mismo. <br> ¿Está seguro de continuar?",
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
});
