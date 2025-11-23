const btnLimpiar = $("[data-accion=limpiar]");
const formReporteEnlaceListadoSolicitantes = $( "#reporte_enlace_listado" );
const tablaPremio = $("#tabla_premio_empleados");
const btnDescargar = $("#btn_descargar");
const btnBuscar = $("#btn_buscar");

btnLimpiar.click(function () {
    formReporteEnlaceListadoSolicitantes.trigger("reset");
    validator.resetForm();
    tablaPremio.bootstrapTable("load", []);
});

function areaFormatter(value, row) {
    let { identificador, nombre } = value;
    return `${identificador} - ${nombre}`
}

function nombreFormatter(value, row) {
    let { nombre_empleado, apellido_paterno, apellido_materno } = row;
    return `${nombre_empleado} ${apellido_paterno} ${apellido_materno}`;
}

function tarjetaElectronicaFormatter(value, row) {
    let botones =  `<button
                        onclick="descargarTarjetaElectronica( ${row.premio_puntualidad_empleado_id} )"
                        class="btn btn-icon btn-outline-danger descargar-detalle-reporte"
                        data-toggle="tooltip"
                        title="Descargar Información">
                        <i class="far fa-file-pdf"></i>
                    </button>`;
    return botones;
}

btnBuscar.click(function (e) {
    e.preventDefault();

    if ( formReporteEnlaceListadoSolicitantes.valid() ) {

        let folio = $("#folio").val();

        KTApp.blockPage({
            overlayColor: '#000000',
            state: 'danger',
            message: 'Por favor, espere...'
        });

        $.ajax({
            type: "POST",
            url: urlEnlaceListadoSolicitantesBuscar,
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

btnDescargar.click(function (e) {
    e.preventDefault();

    if ( formReporteEnlaceListadoSolicitantes.valid() ) {
        let folio = $("#folio").val();

        KTApp.blockPage({
            overlayColor: '#000000',
            state: 'danger',
            message: 'Por favor, espere...'
        });

        $.ajax({
            type: 'GET',
            url: urlEnlaceListadoSolicitantes+'/'+folio,
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

var validator = formReporteEnlaceListadoSolicitantes.validate({
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

function descargarTarjetaElectronica(id)
{
    KTApp.blockPage({
        overlayColor: '#000000',
        state: 'danger',
        message: 'Por favor, espere...'
    });

    $.ajax({
        type: "POST",
        url: urlEnlaceListadoSolicitantesTarjetaElectronica,
        data : { id },
        success: function (response) {
            if (response.estatus) {
                // Decodificar el PDF que viene en base64
                const pdfContent = atob(response.pdf);
                // Convertir la cadena decodificada en un Uint8Array
                const byteArray = new Uint8Array([...pdfContent].map(char => char.charCodeAt(0)));
                // Crear un Blob con el contenido del PDF
                const blob = new Blob([byteArray], { type: 'application/pdf' });
                // Crear una URL para el Blob
                const url = window.URL.createObjectURL(blob);

                // Crear un enlace temporal para descargar el archivo
                const link = document.createElement('a');
                link.href = url;
                link.download = response.nombre; // Usar el nombre recibido desde el servidor
                link.click();

                // Revocar la URL del Blob
                window.URL.revokeObjectURL(url);
                Swal.fire({
                    text: '¡Descarga exitosa!',
                    icon: 'success',
                    confirmButtonColor: '#0BB7AF',
                    confirmButtonText: 'Ok'
                });
            } else {
                Swal.fire({
                    text: '¡Error al generar el PDF, intente más tarde!',
                    icon: 'error',
                    confirmButtonColor: '#0BB7AF',
                    confirmButtonText: 'Ok'
                });
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            Swal.fire({
                html: '¡Error, intente más tarde o comuniquese con el área correspondiente!',
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
