const formGuardar = $("#form_guardar");

validateFormGuardar = formGuardar.validate({
    submitHandler: function(form) {
        Swal.fire({
            title: "Verifique los datos antes de continuar.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Continuar",
            cancelButtonText: "Cancelar",
            reverseButtons: true
        }).then((result) => {
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
