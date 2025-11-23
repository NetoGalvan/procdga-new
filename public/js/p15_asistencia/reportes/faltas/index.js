const formBuscar = $("#form_buscar");
const tablaRegistros = $("#tabla_registros");
const btnLimpiar = $("[data-accion=limpiar]");
const selectUnidad = $("[name=unidad_administrativa_id]");
const selectTipoReporte = $("#tipo_reporte");

var validatorFormBuscar = formBuscar.validate({
    submitHandler: function(form) {
        let accion = $(this.submitButton).data("accion");
        let datosFormulario = $(form).serialize();
        datosFormulario += "&accion=" + encodeURIComponent(accion);
        KTApp.blockPage({
            overlayColor: '#000000',
            state: 'danger',
            message: 'Por favor, espere...'
        });
        $.get($(form).attr("action"), datosFormulario).done(function(resp) {
            if (resp.estatus) {
                window.location.href = resp.url;
                /* downloadFileBase64(resp.pdf, resp.nombre); */
            } else {
                swal.fire("", resp.mensaje, "error");
            }
        }).fail(function(jqXHR, textStatus, error) {
            swal.fire("", error, "error");
        }).always(function() {
            KTApp.unblockPage();
        });
    }
});

btnLimpiar.click(function () {
    formBuscar.trigger("reset");
    validatorFormBuscar.resetForm();
    selectUnidad.val("").trigger("change");
});

selectUnidad.select2({
    placeholder: "Seleccione una opción",
    allowClear: true,
});
selectTipoReporte.select2({
    multiple: true,
});
