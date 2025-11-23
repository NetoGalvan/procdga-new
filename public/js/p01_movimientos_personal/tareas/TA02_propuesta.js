// Recuperar elementos del DOM
const formCapturaPropuesta = $('#form_captura_propuesta');
const selectPlazas = $("#numero_plaza");
const selectSituacionesPlaza = $("#situacion_plaza_id");
const selectNivelesSalariales = $("#nivel_salarial_id");
const selectUniversos = $("#universo_id");
const inputTelefono = $("#telefono");
const inputEmail = $("#email");


selectPlazas.select2({
    placeholder: "Seleccionar plaza"
});

selectSituacionesPlaza.select2({
    placeholder: "Seleccionar situación plaza"
});

selectNivelesSalariales.select2({
    placeholder: "Seleccionar nivel salarial"
});

selectUniversos.select2({
    placeholder: "Seleccionar universo"
});

inputTelefono.inputmask("mask", {
    "mask": "9999999999"
});

inputEmail.inputmask({
    mask: "*{1,20}[.*{1,20}][.*{1,20}][.*{1,20}]@*{1,20}[.*{2,6}][.*{1,2}]",
    greedy: false,
    onBeforePaste: function (pastedValue, opts) {
     pastedValue = pastedValue.toLowerCase();
     return pastedValue.replace("mailto:", "");
    },
    definitions: {
     '*': {
      validator: "[0-9A-Za-z!#$%&'*+/=?^_`{|}~\-]",
      cardinality: 1,
      casing: "lower"
     }
    }
});

selectPlazas.on('select2:select', function (e) {
    let data = e.params.data;
    let denominacionPuesto = $(data.element).data("denominacion-puesto"); 
    let codigoPuesto = $(data.element).data("codigo-puesto"); 
    let nivelSalarial = $(data.element).data("nivel-salarial");
    let situacionPlaza = $(data.element).data("situacion-plaza");
    let universo = $(data.element).data("universo");

    $("#codigoPuesto").val(codigoPuesto);
    $("#puesto").val(denominacionPuesto);
    $("#nivelPlaza").val(nivelSalarial);
    $("#situacionPlaza").val(situacionPlaza);
    $("#universo").val(universo);
});

validadorFormCapturaPropuesta = formCapturaPropuesta.validate({
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

