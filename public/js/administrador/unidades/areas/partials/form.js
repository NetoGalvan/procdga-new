const formGuardar = $("#form_guardar");
const selectTipoArea = $("#tipo_area");
const selectAreaId = $("#area_id");
const contenedorDatosArea = $(".contenedor-datos-area");
const contenedorDatosAreaSubarea = $(".contenedor-datos-area-subarea");
const inputNombre = $("#nombre");
const inpurIdentificador = $("#identificador");
const mensajeIdentificador = $("#mensaje_identificador");

$(document).ready(function() {

    // Valida cambio en el Select Tipo Área
    selectTipoArea.change(function (e) {
        e.preventDefault();
        let identificadorUnidad = unidad.identificador;
        inputNombre.val('');
        inpurIdentificador.val('');
        selectAreaId.val('');

        if ( $(this).val() === "AREA_PRINCIPAL") {
            contenedorDatosArea.removeClass('d-none');
            contenedorDatosAreaSubarea.addClass('d-none');
            let mensaje = `Identificador Unidad Administrativa: ${identificadorUnidad}`;
            mensajeIdentificador.html(mensaje);
            inpurIdentificador.attr('pattern', '[0-9]{1}').attr('title', 'Por favor, ingresa un número del 0 al 9');
        } else if ( $(this).val() === 'SUBAREA' ) {
            contenedorDatosArea.removeClass('d-none');
            contenedorDatosAreaSubarea.removeClass('d-none');
            let mensaje = `Identificador Unidad Administrativa: ${identificadorUnidad}`;
            mensajeIdentificador.html(mensaje);
            inpurIdentificador.attr('pattern', '(0[1-9]|[1-9][0-9])').attr('title', 'Por favor, ingresa un número del 01 al 99');;
        } else {
            contenedorDatosArea.addClass('d-none');
            contenedorDatosAreaSubarea.addClass('d-none');
        }
    });

    // Ajusta Texto en el Identificador al seleccionar Área
    selectAreaId.change(function (e) {
        e.preventDefault();
        let areaTexto = $(this).find('option:selected').text();
        var partes = areaTexto.split("-");
        let mensaje = `Identificador Unidad Administrativa y Área: ${partes[0]}`;
        mensajeIdentificador.html(mensaje);
    });

});

validadorFormGuardar = formGuardar.validate({
    submitHandler: function(form) {
        let title = "";
        let html = "";
        if ($(form).data("type") == "editar") {
            title = "Editar";
            html = "Se actualizará la información del Área<br> de esta Unidad Administrativa. <br> ¿Está seguro?";
        } else {
            title = "Guardar";
            html = "Se creará una nueva Área<br> para esta Unidad Administrativa.<br> ¿Está seguro?";
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
