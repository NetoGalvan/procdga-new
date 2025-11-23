// Recuperar elementos del DOM
const formAlimentario = $('#formAlimentarioBajas');
const selectAutorizador = $("#autorizador");
const selectTitular = $("#titular");
const tablaPlaza = $("#tabla_plaza");

selectAutorizador.select2({
    placeholder: "Seleccionar una opción"
});

selectTitular.select2({
    placeholder: "Seleccionar una opción"
});

validadorFormAlimentario = formAlimentario.validate({
    submitHandler: function(form) {
        Swal.fire({
            title: "¿Está seguro?",
            text: "Antes de continuar, verifique que los datos ingresados sean correctos. Después de finalizar la tarea, no podrá regresar.",
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

$('#datos_empleado').on('select2:select', function (e) {
    var data = e.params.data;
    tablaPlaza.bootstrapTable('removeAll');
    tablaPlaza.bootstrapTable('insertRow', {
        index: 1,
        row: data
    });
});
