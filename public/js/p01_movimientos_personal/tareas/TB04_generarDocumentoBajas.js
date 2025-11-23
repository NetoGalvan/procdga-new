var formGenerarDocumento = $("#formGenerarDocumentoBajas");

validadorFormGenerarDocumento = formGenerarDocumento.validate({
    onfocusout: false,
    validClass: "is-valid",
    errorClass: "is-invalid",
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