const btnLimpiar = $("[data-accion=limpiar]");
const formReporteEjecutivoProcesosEjecutados = $( "#reporte_ejecutivo_procesos_ejecutados" );
const tablaPremioEjacutivo = $("#tabla_premio_ejecutivo");
const btnDescargar = $("#btn_descargar");
const btnBuscar = $("#btn_buscar");

btnLimpiar.click(function () {
    formReporteEjecutivoProcesosEjecutados.trigger("reset");
    validator.resetForm();
    tablaPremioEjacutivo.bootstrapTable("load", []);
});

function estatusFormatter(value, row) {
    if (value === 'COMPLETADO') {
        return `<span class="user-select-none label label-inline label-lg font-weight-bold label-rounded label-success">${value}</span>`;
    } else {
        return `<span class="user-select-none label label-inline label-lg font-weight-bold label-rounded label-warning">PENDIENTE</span>`;
    }
}

btnBuscar.click(function (e) {
    e.preventDefault();

    if ( formReporteEjecutivoProcesosEjecutados.valid() ) {

        tablaPremioEjacutivo.bootstrapTable("load", []);
        let fechaInicio = $("#fecha_inicio").val();
        let fechaFinal = $("#fecha_final").val();

        KTApp.blockPage({
            overlayColor: '#000000',
            state: 'danger',
            message: 'Por favor, espere...'
        });

        $.ajax({
            type: "POST",
            url: urlReporteEmpleadosEjecutivoBuscar,
            data: {fechaInicio, fechaFinal},
            success: function (response) {
                if (response.estatus) {
                    tablaPremioEjacutivo.bootstrapTable("destroy");
                    tablaPremioEjacutivo.bootstrapTable({data: response.data});
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

    if ( formReporteEjecutivoProcesosEjecutados.valid() ) {

        let fechaInicio = $("#fecha_inicio").val();
        let fechaFinal = $("#fecha_final").val();

        KTApp.blockPage({
            overlayColor: '#000000',
            state: 'danger',
            message: 'Por favor, espere...'
        });

        $.ajax({
            type: 'GET',
            url: urlReporteEjecutivoProcesosEjecutados+'/'+fechaInicio+'/'+fechaFinal,
            xhrFields: {
                responseType: 'blob' // Configura la respuesta como un objeto Blob
            },
            success: function (response) {
                let estatus = response.estatus && response.estatus == false ? true : false;
                let link = document.createElement('a');
                let url = window.URL.createObjectURL(response);
                link.href = url;
                link.download = 'reporte_ejecutivo_pagos.pdf';
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
                    html: '¡El rango de fechas ingredo no contiene pagos, intente con otro!',
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

var validator = formReporteEjecutivoProcesosEjecutados.validate({
    onfocusout: false,
    rules: {
        fecha_inicio: {
            required: true,
        },
        fecha_final: {
            required: true,
        }
    },
    messages: {
        fecha_inicio: {
            required: 'Campo obligatorio',
        },
        fecha_final: {
            required: 'Campo obligatorio',
        }
    },
    errorPlacement: function(error, element) {
        error.appendTo(element);
    },
});
