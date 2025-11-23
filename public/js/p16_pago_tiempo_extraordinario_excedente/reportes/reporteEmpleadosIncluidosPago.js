const btnLimpiar = $("[data-accion=limpiar]");
const formReporteEmpleadosIncluidos = $( "#form_reporte_empleados_incluidos" );
const tablaPremio = $("#tabla_premio");
const btnDescargar = $("#btn_descargar");
const btnBuscar = $("#btn_buscar");

btnLimpiar.click(function () {
    formReporteEmpleadosIncluidos.trigger("reset");
    validator.resetForm();
    tablaPremio.bootstrapTable("load", []);
});

btnBuscar.click(function (e) {
    e.preventDefault();

    if ( formReporteEmpleadosIncluidos.valid() ) {

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
                    tablaPremio.bootstrapTable({data: response.data});
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

function nombreEmpleadoFormatter(value, row) {
    let { nombre_empleado, apellido_paterno, apellido_materno } = row;
    return `${nombre_empleado} ${apellido_paterno} ${apellido_materno}`;
}

btnDescargar.click(function (e) {
    e.preventDefault();

    if ( formReporteEmpleadosIncluidos.valid() ) {
        let folio = $("#folio").val();

        KTApp.blockPage({
            overlayColor: '#000000',
            state: 'danger',
            message: 'Por favor, espere...'
        });

        $.ajax({
            type: 'GET',
            url: urlReporteEmpleadosIncluidos+'/'+folio,
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
    return this.optional(element) || /^([A-Z0-9]){5,6}-[0-9]{4}-[A-Z0-9]{5,6}$/i.test(value);
});

let validator = formReporteEmpleadosIncluidos.validate({
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
