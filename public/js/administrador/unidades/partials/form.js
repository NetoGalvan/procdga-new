const formGuardar = $("#form_guardar");

validadorFormGuardar = formGuardar.validate({
    submitHandler: function(form) {
        let title = "";
        let html = "";
        if ($(form).data("type") == "editar") {
            title = "Editar";
            html = "Se actualizará la información de la Unidad Administrativa. <br> ¿Está seguro?";
        } else {
            title = "Guardar";
            html = "Se creará una nueva Unidad Administrativa.<br> ¿Está seguro?";
        }
        Swal.fire({
            title: title,
            html: html,
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Sí, continuar",
            cancelButtonText: "Cancelar",
            reverseButtons: true
        }).then(function(result) {
            if (result.value) {
                form.submit();
                KTApp.blockPage({
                    overlayColor: '#000000',
                    state: 'primary',
                    message: 'Por favor, espere...'
                });
            }
        });
    }
});
