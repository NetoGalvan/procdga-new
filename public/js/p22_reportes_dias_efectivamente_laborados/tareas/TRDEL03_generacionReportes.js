//Variables
var formGenerarReporte = $('#form_generar_reporte');
var btnReporteExcel = $('.reporte-excel');
var btnFinalizarProceso = $('.finalizar-proceso');

//BEGIN::Botones
btnFinalizarProceso.click( function(e) {
    e.preventDefault();

    alert_warning_secondary('Finalizar el proceso', (result) => {
        if( result.value ) {
            KTApp.blockPage({
                overlayColor: '#000000',
                state: 'danger',
                message: 'Por favor, espere...'
            });
            formGenerarReporte.attr('action', URL_finalizarProceso);
            formGenerarReporte.submit();
        }
    });
});

btnReporteExcel.click( function(e) {
    e.preventDefault();
    
    $.ajax({
        url: URL_descargarReporte,
        type: "POST",
        xhrFields: { responseType: 'blob' },
        beforeSend: function() {
            KTApp.blockPage({
                overlayColor: '#000000',
                state: 'danger',
                message: 'Por favor, espere...'
            });
        },
        success: function (response) {
            let link = document.createElement('a');
            let url = window.URL.createObjectURL(response);
            link.href = url;
            link.download = nombreArchivo;
            link.click();

            KTApp.unblockPage();
        }

    });
});
//END::Botones