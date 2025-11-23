var formGenerarDocumentoAltas = $("#formGenerarDocumentoAltas");

validadorFormGenerarDocumentoAltas = formGenerarDocumentoAltas.validate({
    submitHandler: function(form) {
        Swal.fire({
            title: "¿Está seguro?",
            text: "Está por finalizar el proceso.",
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