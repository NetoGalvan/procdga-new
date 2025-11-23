const formGuardarHorario = $("#form_guardar_horario");
const swAplicaRetardos = $("[name=aplica_retardos]");
const contenedorIntervalosRetardos = $("#contenedor_intervalos_retardos");
const inputSalida = $("[name=salida]");
const inputIntervaloSalidaInicio = $("[name='intervalos[SALIDA][inicio]']");
const inputIntervaloSalidaFinal = $("[name='intervalos[SALIDA][final]']");

validateFormGuardarHorario = formGuardarHorario.validate({
    rules: {
        'dias_laborales[]': {
            required: true,
        }
    },
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

inputSalida.keyup(function() {
    if ($(this).val() == "") {
        inputIntervaloSalidaInicio.val("");
        inputIntervaloSalidaFinal.val("");
        inputIntervaloSalidaInicio.attr("required", false);
        inputIntervaloSalidaFinal.attr("required", false);
        inputIntervaloSalidaInicio.prev().html(`Inicio`);
        inputIntervaloSalidaFinal.prev().html(`Final`);
    } else {
        inputIntervaloSalidaInicio.attr("required", true);
        inputIntervaloSalidaFinal.attr("required", true);
        inputIntervaloSalidaInicio.prev().html(`<strong><span class="text-danger">*</span> Inicio</strong>`);
        inputIntervaloSalidaFinal.prev().html(`<strong><span class="text-danger">*</span> Final</strong>`);
    }
});

swAplicaRetardos.change(function(e) {
    if ($(this).is(':checked')) {
        contenedorIntervalosRetardos.show();
    } else {
        contenedorIntervalosRetardos.hide();
        $("[name='intervalos[RETARDO_LEVE][inicio]']").val("");
        $("[name='intervalos[RETARDO_LEVE][final]']").val("");
        $("[name='intervalos[RETARDO_GRAVE][inicio]']").val("");
        $("[name='intervalos[RETARDO_GRAVE][final]']").val("");
    }
});