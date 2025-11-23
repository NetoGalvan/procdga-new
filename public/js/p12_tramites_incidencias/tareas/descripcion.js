formIniciarProceso = $("#form_iniciar_proceso");

formIniciarProceso.validate({
    submitHandler: function(form) {
        Swal.fire({
            title: "¿Está seguro?",
            text: "Se creará un nuevo folio y la primer tarea para el proceso de Incidencias.",
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
                form.submit();
            }
        });
    }
});


    
