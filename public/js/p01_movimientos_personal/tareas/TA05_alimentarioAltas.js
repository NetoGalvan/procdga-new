// Recuperar elementos del DOM
const formAlimentarioAltas = $('#formAlimentarioAltas');
const inputCelular = $("#telefono_celular");
const numeroCuentaBancaria = $("#numero_cuenta_bancaria");
const btnGuardarAvance = $("#btn_guardar_avance");
const selectZonaPagadora = $("#zona_pagadora_id");
const selectEntidadNacimiento = $("#entidad_federativa_nacimiento_id");

inputCelular.inputmask("mask", {
    "mask": "9999999999"
});

numeroCuentaBancaria.inputmask("mask", {
    "mask": "9999999999999999"
});

selectZonaPagadora.select2({
    placeholder: "Seleccionar una zona pagadora"
});

selectEntidadNacimiento.select2({
    placeholder: "Seleccionar una opción"
});

validadorFormAlimentarioAltas = formAlimentarioAltas.validate({
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

btnGuardarAvance.click(function() {
    $.post(formAlimentarioAltas.attr('action'), formAlimentarioAltas.serialize(), function (resp) {
        if (resp.estatus) {
            Swal.fire("Se ha guardado correctamente el avance", "", "success");
        }
    });
});
