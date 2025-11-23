//Variables
var btnDescargarNominaExcel = $('#descargarNominaExcel');
var btnFinalizarProceso = $('#finalizarSubProceso');
var formGenerarNomina = $('#form_generar_nomina');

//BEGIN::Botones
btnFinalizarProceso.click(function(e) {
    e.preventDefault()

    alert_warning_secondary("Verifique haber descargado la nomina <br> finalizara con el proceso", (result) => {
        if(result.value) {
            KTApp.blockPage({
                overlayColor: '#000000',
                state: 'danger',
                message: 'Por favor, espere...'
            });
            formGenerarNomina.attr('action', URL_finalizarProceso);
            formGenerarNomina.submit();
        }
    });
});
// ------
btnDescargarNominaExcel.click(function(e) {
    e.preventDefault();

    KTApp.blockPage({
        overlayColor: '#000000',
        state: 'danger',
        message: 'Por favor, espere...'
    });

    $.ajax({
        url: URL_descargarNominaExcel,
        type: "POST",
        xhrFields: {
            responseType: 'blob'
        },
        success: function(response){

            var blob = new Blob([response]);
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);

            link.download = nombreArchivoExcel;
            link.click();

            KTApp.unblockPage();
        },
        error: function(blob){
        }
    });
});
//END::Botones