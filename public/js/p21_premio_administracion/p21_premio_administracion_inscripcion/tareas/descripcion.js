
formIniciarProceso = $("#form_iniciar_proceso_p21_inscripcion");
btnIniciarProceso = $("#btn_iniciar_proceso_p21_inscripcion");

btnIniciarProceso.click(function() {
    Swal.fire({
        html: "Esta a punto de iniciar el proceso: <br><b> Inscripción al premio de administración. </b><br><br>¿Desea continuar?",
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
