formIniciarProceso = $("#id_form_iniciar_proceso");
btnIniciarProceso = $("#id_btn_iniciar_proceso");

btnIniciarProceso.click(function() {
    Swal.fire({
        title: "¿Está seguro?",
        text: "Se creará un nuevo folio y la primer tarea para el proceso de Trámites Kardex.",
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

