$('#tablaAnioNominas').on('click', '.btn-descargarReporteNominas', function(e) {
    e.preventDefault();

    var anio = $(this).data('anio');
    $.ajax({
        url: URL_reporteEjecutivoNomina,
        type: "POST",
        data: {
            anio: anio
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
            let link = document.createElement('a');
            let url = window.URL.createObjectURL(response);
            link.href = url;
            link.download = `Reporte ejecutivo de contraprestación de prestadores_${anio}.pdf`;
            link.click();

            KTApp.unblockPage();
        }
    });
});