
const btnLimpiar = $("[data-accion=limpiar]");
const formReporteReimpresionLayout = $( "#reporte_reimpresion_relacion" );
const tablaPremio = $("#tabla_premio_relacion");
const btnDescargar = $("#btn_descargar");
const btnBuscar = $("#btn_buscar");

btnLimpiar.click(function () {
    formReporteReimpresionLayout.trigger("reset");
    validator.resetForm();
    tablaPremio.bootstrapTable("load", []);
});

function estatusFormatter(value, row) {
    if (value === 'COMPLETADO') {
        return `<span class="user-select-none label label-inline label-lg font-weight-bold label-rounded label-success">${value}</span>`;
    } else {
        return `<span class="user-select-none label label-inline label-lg font-weight-bold label-rounded label-warning">PENDIENTE</span>`;
    }
}

function areaFormatter(value, row) {
    let { identificador, nombre } = value;
    return `${identificador} - ${nombre}`
}

function inscripcionesFormatter(value, row) {
    return `${value.length}`
}

btnBuscar.click(function (e) {
    e.preventDefault();

    if ( formReporteReimpresionLayout.valid() ) {

        let folio = $("#folio").val();

        KTApp.blockPage({
            overlayColor: '#000000',
            state: 'danger',
            message: 'Por favor, espere...'
        });

        $.ajax({
            type: "POST",
            url: urlReporteEmpleadosIncluidosBuscar,
            data: {folio},
            success: function (response) {
                if (response.estatus) {
                    tablaPremio.bootstrapTable("destroy");
                    tablaPremio.bootstrapTable({data: [response.data]});
                } else {
                    swal.fire({
                        text: response.mensaje,
                        icon: "warning",
                        confirmButtonColor: "#0abb87",
                        confirmButtonText: "Ok",
                    });
                }
            },
            complete : function(xhr, status) {
                KTApp.unblockPage();
            }
        });
    }

});

btnDescargar.click(function (e) {
    e.preventDefault();

    if ( formReporteReimpresionLayout.valid() ) {
        let folio = $("#folio").val();

        KTApp.blockPage({
            overlayColor: '#000000',
            state: 'danger',
            message: 'Por favor, espere...'
        });

        $.ajax({
            type: 'GET',
            url: urlReimpresionRelacionEmpleados+'/'+folio,
            xhrFields: {
                responseType: 'blob' // Configura la respuesta como un objeto Blob
            },
            success: function (response) {
                let estatus = response.estatus && response.estatus == false ? true : false;
                let link = document.createElement('a');
                let url = window.URL.createObjectURL(response);
                link.href = url;
                link.download = 'reporte_empleado.pdf';
                link.click();
                window.URL.revokeObjectURL(url);
                Swal.fire({
                    text: '¡Descarga exitosa!',
                    icon: 'success',
                    confirmButtonColor: '#0BB7AF',
                    confirmButtonText: 'Ok'
                })
            },
            error: function(jqXHR, textStatus, errorThrown) {
                Swal.fire({
                    html: '¡El folio ingresado no existe o esta en proceso aún, intente con otro!',
                    icon: 'warning',
                    confirmButtonColor: '#0BB7AF',
                    confirmButtonText: 'Ok'
                });
            },
            complete : function(xhr, status) {
                KTApp.unblockPage();
            }
        });
    }
});

$.validator.addMethod("folio", function(value, element) {
    return this.optional(element) || /^([A-Z0-9]){5}-[0-9]{4}-[A-Z0-9]{5}$/i.test(value);
});

var validator = formReporteReimpresionLayout.validate({
    onfocusout: false,
    rules: {
        folio: {
            required: true,
            campoNoVacio: true,
            folio: true
        }
    },
    messages: {
        folio: {
            required: 'Campo obligatorio',
            campoNoVacio: "No se puede enviar espacios en blanco",
            folio: "Ingrese un folio valido"
        }
    },
    errorPlacement: function(label, element) {
        element.addClass('error');
        label.insertAfter(element);
    }
});
