const formGuardar = $("#form_guardar");
const selectUnidad = $("#unidad_administrativa_id");

selectUnidad.select2({
    placeholder: "Selecciona una opción"
});

validadorFormGuardar = formGuardar.validate({
    submitHandler: function(form) {
        let title = "";
        if ($(form).data("type") == "editar") {
            title += "Se actualizará la información del área. ¿Está seguro?";
        } else {
            title += "Se creará una nueva área. ¿Está seguro?";
        }

        Swal.fire({
            title: title,
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