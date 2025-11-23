const formBuscar = $("#form_buscar");
const tablaRegistros = $("#tabla_registros");
const btnLimpiar = $("[data-accion=limpiar]");

var validatorFormBuscar = formBuscar.validate({
    submitHandler: function(form) {
        let accion = $(this.submitButton).data("accion");
        let datosFormulario = $(form).serialize();
        datosFormulario += "&accion=" + encodeURIComponent(accion);
        tablaRegistros.bootstrapTable("load", []);
        KTApp.blockPage({
            overlayColor: '#000000',
            state: 'danger',
            message: 'Por favor, espere...'
        });
        $.get($(form).attr("action"), datosFormulario).done(function(resp) {
            if (resp.estatus) {
                if (resp.registros.length == 0) {
                    swal.fire("No se encontraron registros que coincidan con tu búsqueda.", "", "error");
                } else {
                    if (accion == "descargar") {
                        window.location.href = resp.url;
                    } else {
                        tablaRegistros.bootstrapTable("load", resp.registros);
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
    tablaRegistros.bootstrapTable("load", []);
});

$('.input-date-range-current').datepicker('destroy');
$('.input-date-range-current').datepicker({
    rtl: KTUtil.isRTL(),
    todayHighlight: true,
    format: "dd-mm-yyyy",
    autoclose: true,
    language: "es",
    showOnFocus: true,
    orientation: "bottom left",
    endDate: new Date(new Date().setDate(new Date().getDate()))
}).on("change", function() {
    $(this).find("input").trigger("keyup");
});