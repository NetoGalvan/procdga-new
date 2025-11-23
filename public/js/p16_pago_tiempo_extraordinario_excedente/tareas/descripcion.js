formIniciarProceso = $("#form_iniciar_proceso_p16");
btnIniciarProceso = $("#btn_iniciar_proceso_p16");

btnIniciarProceso.click(function() {
    Swal.fire({
        html: "Esta a punto de iniciar el proceso: <br><b> Pago de Tiempo Extraordinario y Excedente. </b><br>¿Desea continuar?",
        icon: "warning",
        showCancelButton: true,
        cancelButtonColor: '#F64E60',
        cancelButtonText: "Cancelar",
        confirmButtonText: "Sí, continuar",
        confirmButtonColor: '#0BB7AF',
        reverseButtons: true,
    }).then(function(result) {
        if (result.value) {
            KTApp.blockPage({
                overlayColor: '#000000',
                state: 'danger',
                message: 'Por favor, espere...'
            });
            formIniciarProceso.submit();
        }
    });
});