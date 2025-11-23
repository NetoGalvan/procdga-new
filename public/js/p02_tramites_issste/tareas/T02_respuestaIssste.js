const formFinalizarTarea = $('#form_finalizar_tarea');
const selectEstatusMovimientos = $("#estatus_movimientos");
const btnAplicarEstatus = $("#btn_aplicar_estatus");

validadorFormFinalizarTarea = formFinalizarTarea.validate({    
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
                form.submit();
            }
        });
    }
}); 

btnAplicarEstatus.click(function(e) {
    let optionSelected = selectEstatusMovimientos.val();
    swal.fire({
        text: `¿Desea poner como ${optionSelected} todos los folios?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, continuar',
        cancelButtonText: 'Cancelar',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            let selectsEstatusMovimientos = $(".estatusMovimiento");
            $.each(selectsEstatusMovimientos, function (index, element) {
                $(element).val(optionSelected);
                $(element).trigger("change");
                swal.fire(`Se cambió el estatus de todos los folios a ${optionSelected} correctamente`, "", "success");
                if (optionSelected == "ACEPTADO") {
                    $(element).closest(".row").find(".contenedor_motivo_rechazo").hide();
                } else if (optionSelected == "RECHAZADO") {
                    $(element).closest(".row").find(".contenedor_motivo_rechazo").show();
                }
            });
        }
    })    
});

$(".estatusMovimiento").on("change", function() { 
    if ($(this).val() == "RECHAZADO") {
        $(this).closest(".row").find(".contenedor_motivo_rechazo").show();
    } else {
        $(this).closest(".row").find(".contenedor_motivo_rechazo").hide();
    }
});