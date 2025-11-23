const formBuscar = $("#form_buscar");
const selectTiposIncidencias = $("#tipos_incidencias");
const selectEstatus = $("#estatus");
const tablaIncidenciasEmpleado = $("#tabla_incidencias_empleado");
const btnLimpiar = $("[data-accion=limpiar]");
const listCbCampos = $('input[name="campos_adicionales[]"]');

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
                if (resp.incidenciasEmpleado.length == 0) {
                    swal.fire("No se encontraron incidencias que coincidan con tu búsqueda. Por favor, intenta modificar tus criterios de búsqueda.", "", "error");
                } else {
                    if (accion == "descargar") {
                        downloadFileBase64(resp.pdf, resp.nombre)
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

selectTiposIncidencias.select2({
    placeholder: 'Seleccione una opción',
    allowClear: true
});

selectEstatus.select2({
    placeholder: 'Seleccione una opción',
    allowClear: true
});

listCbCampos.on("change", function() {
    if ($(this).is(":checked")) {
        tablaIncidenciasEmpleado.bootstrapTable("showColumn", $(this).val());
    } else {
        tablaIncidenciasEmpleado.bootstrapTable("hideColumn", $(this).val());
    }
});

btnLimpiar.click(function () {
    formBuscar.trigger("reset");
    validatorFormBuscar.resetForm();
    selectEmpleados.val("").trigger("change");
    selectTiposIncidencias.val([]).trigger("change");
    selectEstatus.val("").trigger("change");
    tablaIncidenciasEmpleado.bootstrapTable("load", []);
});

