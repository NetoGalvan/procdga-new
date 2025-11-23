const btnCancelarProceso = $("#btn_cancelar");
btnCancelarProceso.click(function() {
    swal.fire({
        title: "¿Está seguro de cancelar el trámite?",
        text: "El folio se cancelará y no podrá continuar.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, CANCELAR trámite",
        cancelButtonText: "No, regresar",
        reverseButtons: true
    }).then((result) => {
        if (result.value) {
            KTApp.blockPage({
                overlayColor: '#000000',
                state: 'danger',
                message: 'Por favor, espere...'
            });
            $("#form_finalizar_tarea").append(`<input type="hidden" name="accion" value="cancelar">`);
            $("#form_finalizar_tarea")[0].submit();
        }
    });
});