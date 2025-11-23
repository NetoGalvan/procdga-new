const formGeneracionArchivosPago    = $("#form_generacion_archivos_pago");
const btnFinalizarProceso           = $("#btn_finalizar_proceso");
const btnContinuarProceso           = $("#btn_continuar_proceso");
const tablaGeneracionArchivosPago   = $('#tabla_generacion_archivos_pago');
const btnCancelarProceso            = $("#btn_cancelar");

// Cargar data
$(document).ready(function () {
    // Se valida si existen se carga en la tabla
    if ( subprocesosFinales.length > 0 ){
        tablaGeneracionArchivosPago.bootstrapTable("destroy");
        tablaGeneracionArchivosPago.bootstrapTable({data: subprocesosFinales});
    } else {
        tablaGeneracionArchivosPago.bootstrapTable();
    }

});

// Formatters de la tabla
function premiosAplicadosFormatter(value, row){
    return `${value}`;
}

// Evento que permite Continuar y Finalizar con la T04
btnContinuarProceso.click(function (e) {
    e.preventDefault();

    Swal.fire({
        title: 'Continuar',
        text: "¿Esta seguro(a) de continuar con este proceso?",
        icon: 'question',
        showCancelButton: true,
        cancelButtonColor: '#F64E60',
        cancelButtonText: 'No',
        confirmButtonColor: '#0BB7AF',
        confirmButtonText: 'Si'
    }).then((result) => {
        if (result.isConfirmed) {
            KTApp.blockPage({
                overlayColor: '#000000',
                state: 'danger',
                message: 'Por favor, espere...'
            });
            formGeneracionArchivosPago.submit();
        }
    })

});

btnCancelarProceso.click(function() {
    swal.fire({
        title: "¿Está seguro de cancelar el proceso?",
        text: "El folio se cancelará y no podrá continuar.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, CANCELAR proceso",
        cancelButtonText: "No, regresar",
        reverseButtons: true
    }).then((result) => {
        if (result.value) {
            KTApp.blockPage({
                overlayColor: '#000000',
                state: 'danger',
                message: 'Por favor, espere...'
            });
            $("#form_generacion_archivos_pago").append(`<input type="hidden" name="accion" value="cancelar">`);
            $("#form_generacion_archivos_pago")[0].submit();
        }
    });
});

function descargarReporte(event, url) {
    event.preventDefault(); // Evita que el enlace se ejecute normalmente

    // Muestra el indicador de carga
    KTApp.blockPage({
        overlayColor: '#000000',
        state: 'danger',
        message: 'Por favor, espere...'
    });

    // Realiza la solicitud de descarga
    $.ajax({
        url: url,
        method: 'GET',
        xhrFields: {
            responseType: 'blob' // Indica que esperamos un archivo
        },
        success: function(data) {
            // Si la solicitud es exitosa, crea un enlace temporal y lo usa para descargar el archivo
            var a = document.createElement('a');
            var url = window.URL.createObjectURL(data);
            a.href = url;
            a.download = 'layout.xlsx'; // Ajusta el nombre del archivo según sea necesario
            document.body.append(a);
            a.click();
            a.remove();
            window.URL.revokeObjectURL(url);
        },
        complete: function() {
            // Oculta el indicador de carga cuando la solicitud se completa
            KTApp.unblockPage();
        }
    });
}


function descargarReportePDF(event, url) {
    event.preventDefault(); // Evita que el enlace se ejecute normalmente

    // Muestra el indicador de carga
    KTApp.blockPage({
        overlayColor: '#000000',
        state: 'danger',
        message: 'Por favor, espere...'
    });

    // Realiza la solicitud de descarga
    $.ajax({
        url: url,
        method: 'GET',
        xhrFields: {
            responseType: 'blob' // Indica que esperamos un archivo
        },
        success: function(data) {
            // Si la solicitud es exitosa, crea un enlace temporal y lo usa para descargar el archivo
            var a = document.createElement('a');
            var url = window.URL.createObjectURL(data);
            a.href = url;
            a.download = 'concentrado.pdf'; // Ajusta el nombre del archivo según sea necesario
            document.body.append(a);
            a.click();
            a.remove();
            window.URL.revokeObjectURL(url);
        },
        complete: function() {
            // Oculta el indicador de carga cuando la solicitud se completa
            KTApp.unblockPage();
        }
    });
}

