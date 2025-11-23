const formEditarEmpleado = $("#form_editar_empleado");
const selectArea = $("#area_id");

selectArea.select2({
    placeholder: "Selecciona una opción"
});

$(document).ready(function() {
    // Inicializa el switch
    $('#activo').bootstrapSwitch();
    // Define el estado del switch
    $('#activo').bootstrapSwitch('state', empleado.activo);
});

const validatorFormFinalizarTarea = formEditarEmpleado.validate({
    submitHandler: function(form) {
        Swal.fire({
            title: "¿Editar empleado?",
            text: "¿Esta seguro de editar este empleado?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Sí, continuar",
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
