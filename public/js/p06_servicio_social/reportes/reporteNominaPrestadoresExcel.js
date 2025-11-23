var date = new Date();
var mes = ((date.getMonth()+1) < 10) ? `0${date.getMonth()+1}` : date.getMonth()+1;
// ------ Descargar Reporte Nomina
$('#tablaNominaServicioSocial').on('click', '.btn-descargarNomina', function(e) {
    e.preventDefault();

    var folio = $(this).data('folio');
    $.ajax({
        url: URL_descargarReporteNomina,
        type: "GET",
        data: {
            folio: folio
        },
        xhrFields: { responseType: 'blob' },
        beforeSend: function() {
            KTApp.blockPage({
                overlayColor: '#000000',
                state: 'danger',
                message: 'Por favor, espere...'
            });
        },
        success: function (response) {
            var blob = new Blob([response]);
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);

            link.download = `Nomina_${folio}_${date.getDate()}-${mes}-${date.getFullYear()}.xlsx`;
            link.click();

            KTApp.unblockPage();
        }
    });
});