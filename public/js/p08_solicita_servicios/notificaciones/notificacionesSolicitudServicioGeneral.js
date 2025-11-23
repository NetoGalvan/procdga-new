const formNotificacion = $('#form_notificacion');
const btnFinalizarNotificacion = $('#btn_finalizar_notificacion');

btnFinalizarNotificacion.click(function() {
    Swal.fire({
        title: "Notificación",
        text: "¿Elimimar esta notificación?",
        icon: "question",
        showCancelButton: true,
        cancelButtonColor: '#F64E60',
        cancelButtonText: "Cancelar",
        confirmButtonText: "Sí, continuar",
        confirmButtonColor: '#0BB7AF',
        reverseButtons: true,
    }).then(function(result) {
        if (result.value) {
            KTApp.blockPage({
                overlayColor: '#000000',
                state: 'danger',
                message: 'Por favor, espere...'
            });
            formNotificacion.submit();
        }
    });
});

function mostrarPDF(base64PDF) {
    const pdfViewer = document.getElementById('pdfmodal');
    pdfViewer.src = "data:application/pdf;base64," + base64PDF;
    $('#pdfModal').modal('show');
}
