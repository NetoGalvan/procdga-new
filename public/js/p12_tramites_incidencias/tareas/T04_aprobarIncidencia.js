const formFinalizarTarea = $("#form_finalizar_tarea");
const selectEstatusTramite = $("#estatus");
const contenedorMotivoRechazo = $("#contenedor_motivo_rechazo");
const validatorFormFinalizarTarea = formFinalizarTarea.validate({
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
selectEstatusTramite.change(function () { 
    if ($(this).val() == "RECHAZADO") {
        contenedorMotivoRechazo.removeClass('d-none');
    } else {
        contenedorMotivoRechazo.addClass('d-none');
    }
});