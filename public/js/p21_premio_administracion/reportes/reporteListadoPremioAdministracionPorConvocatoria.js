const btnLimpiar = $("[data-accion=limpiar]");
const formReporteListadoPorConvocatoria = $( "#listado_candidatos_premio_administracion_una_convocatoria" );
const tablaListaPremio = $("#tabla_lista_empleados");
const btnDescargar = $("#btn_descargar");
const btnBuscar = $("#btn_buscar");

btnLimpiar.click(function () {
    formReporteListadoPorConvocatoria.trigger("reset");
    validator.resetForm();
    tablaListaPremio.bootstrapTable("load", []);
});

function nombreFormatter(value, row) {
    let { nombre_empleado, apellido_paterno, apellido_materno } = row;
    return `${nombre_empleado} ${apellido_paterno} ${apellido_materno}`;
}

function inscripcionFormatter(value, row) {
    return `${value ? value : 'ADICIONAL'}`;
}

btnBuscar.click(function (e) {
    e.preventDefault();

    if ( formReporteListadoPorConvocatoria.valid() ) {

        let folio = $("#folio").val();

        KTApp.blockPage({
            overlayColor: '#000000',
            state: 'danger',
            message: 'Por favor, espere...'
        });

        $.ajax({
            type: "POST",
            url: urlListadoSolicitantesAdminBuscar,
            data: {folio},
            success: function (response) {
                if (response.estatus) {
                    tablaListaPremio.bootstrapTable("destroy");
                    tablaListaPremio.bootstrapTable({data: response.data});
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

    if ( formReporteListadoPorConvocatoria.valid() ) {
        let folio = $("#folio").val();

        KTApp.blockPage({
            overlayColor: '#000000',
            state: 'danger',
            message: 'Por favor, espere...'
        });

        $.ajax({
            type: 'GET',
            url: urlPdfReporteListadoPremioAdministracionPorConvocatoria+'/'+folio,
            xhrFields: {
                responseType: 'blob' // Configura la respuesta como un objeto Blob
            },
            success: function (response) {
                let estatus = response.estatus && response.estatus == false ? true : false;
                let link = document.createElement('a');
                let url = window.URL.createObjectURL(response);
                link.href = url;
                link.download = 'reporte_empleados.pdf';
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

var validator = formReporteListadoPorConvocatoria.validate({
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
