
var contenedorRespuesta =  $("#id_contenedor_respuesta");
var selectEstatusTramite = $("#estatus");
var contenedorRechazo = $("#id_contenedor_motivo_rechazo");
var contenedorProcesamiento = $("#id_contenedor_procesamiento");
var formFinalizarBajas = $("#formFinalizarBajas");

selectEstatusTramite.change(function () { 
    if ($(this).val() == "COMPLETADO") {
        contenedorProcesamiento.removeClass('d-none');
        contenedorRechazo.addClass('d-none');            
    } else if ($(this).val() == "RECHAZADO") {
        contenedorRechazo.removeClass('d-none');
        contenedorProcesamiento.addClass('d-none');
    } else {
        contenedorRechazo.addClass('d-none');   
        contenedorProcesamiento.addClass('d-none');
    }
});

formFinalizarBajas.validate({
    submitHandler: function(form) {
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
                KTApp.blockPage({
                    overlayColor: '#000000',
                    state: 'danger',
                    message: 'Por favor, espere...'
                });
                form.submit();
            }
        });
    }
});
