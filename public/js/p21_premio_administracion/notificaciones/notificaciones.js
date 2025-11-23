const formNotificacion = $('#form_eliminar_notificacion');
const btnFinalizarNotificacion = $('#btn_eliminar_notificacion');

const formNotificacion2 = $('#form_eliminar_notificacion2');
const btnFinalizarNotificacion2 = $('#btn_eliminar_notificacion2');

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

btnFinalizarNotificacion2.click(function() {
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
            formNotificacion2.submit();
        }
    });
});

// Para descargar el pdf con el listado de candidatos
btnListadoCandidatos = $("#listado_candidatos");

btnListadoCandidatos.click(function() {
    ajaxPdfListaCandidatos(premio_id).done(function(respuesta, xhr, response) {
        var a = document.createElement('a');
        var url = window.URL.createObjectURL(respuesta);
        var nombre = response.getResponseHeader('Content-Disposition').split('filename=')[1];
        nombre = nombre.replace(/['"]+/g, '');

        a.href = url;
        a.download = nombre;
        document.body.append(a);
        a.click();
        a.remove();
        window.URL.revokeObjectURL(url);
        KTApp.unblockPage();
    });
});

function ajaxPdfListaCandidatos(premio_id) {
    KTApp.blockPage({
        overlayColor: '#000000',
        state: 'danger',
        message: 'Por favor, espere...'
    });
    return $.ajax({
        url: urlDescargarListadoCandidatos+'/'+premio_id,
        type: 'POST',
        async: true,
        xhrFields: {
            responseType: 'blob'
        },
    });
}
