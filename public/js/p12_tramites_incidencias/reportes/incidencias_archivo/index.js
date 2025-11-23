const formBuscar = $("#form_buscar");
const tablaIncidenciasEmpleado = $("#tabla_incidencias_empleado");
const btnLimpiar = $("[data-accion=limpiar]");

var validatorFormBuscar = formBuscar.validate({
    submitHandler: function(form) {
        let accion = $(this.submitButton).data("accion");
        let datosFormulario = $(form).serialize();
        datosFormulario += "&accion=" + encodeURIComponent(accion);
        tablaIncidenciasEmpleado.bootstrapTable("load", []);
        KTApp.blockPage({
            overlayColor: '#000000',
            state: 'danger',
            message: 'Por favor, espere...'
        });
        $.get($(form).attr("action"), datosFormulario).done(function(resp) {
            if (resp.estatus) {
                if (accion == "descargar") {
                    downloadFileBase64(resp.pdf, resp.nombre)
                } else {
                    if (resp.incidenciasEmpleado.length == 0) {
                        swal.fire("No se encontraron incidencias que coincidan con tu búsqueda. Por favor, intenta modificar tus criterios de búsqueda.", "", "error");
                    } else {
                        tablaIncidenciasEmpleado.bootstrapTable("load", resp.incidenciasEmpleado);
                        swal.fire("La consulta ha sido exitosa.", "", "success");
                    }
                }
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
    tablaIncidenciasEmpleado.bootstrapTable("load", []);
});
