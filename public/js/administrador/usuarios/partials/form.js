const formUser = $("#form_user");
const selectArea = $("#area_id");

selectArea.select2({
    placeholder: "Selecciona una opción"
});

validadorFormUser = formUser.validate({
    submitHandler: function(form) {
        let title = "";
        if ($(form).data("type") == "editar") {
            title += "Se actualizará la información del usuario. ¿Está seguro?";
        } else {
            title += "Se creará un nuevo usuario. ¿Está seguro?";
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
                $("[name='roles[]'").attr("disabled", false);
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

$("[data-toggle=tab]").click(function () {
    let opcion = $(this).attr("href");
    let estaActivo = $(this).hasClass("active");

    if (estaActivo) return false;

    $("#datos_empleado").val(null).trigger("change");
    $("#nombre").val("");
    $("#apellido_paterno").val("");
    $("#apellido_materno").val("");
    $("#curp").val("");
    $("#rfc").val("");
    $("#numero_empleado").val("");
    $("#email").val("");
    $("#puesto").val("");

    if (opcion == "#registro_manual") {
        $("#tipo_registro").val("MANUAL");
    } else {
        $("#tipo_registro").val("EXISTENTE");
    }
});