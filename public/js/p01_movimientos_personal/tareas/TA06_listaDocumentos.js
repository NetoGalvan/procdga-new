// Recuperar elementos del DOM
const formListaDocumentos = $('#form_lista_documentacion');
const tablaTiposDocumentos = $('#tabla_tipos_documentos');
const btnDescargarPDF = $("#btn_descargar_pdf");

tablaTiposDocumentos.bootstrapTable({
    data: tiposDocumentos
});

btnDescargarPDF.click(function() {
    let listaDocumentos = JSON.stringify(tablaTiposDocumentos.bootstrapTable('getData'));
    KTApp.blockPage({
        overlayColor: '#000000',
        state: 'danger',
        message: 'Por favor, espere...'
    });
    $.ajax({
        url: $(this).attr("href"),
        type: "POST",
        data: {listaDocumentos},
        dataType: "json",
        success: function(resp) {
            downloadFileBase64(resp.pdf, resp.nombre_pdf)
        }
    }).always(function() {
        KTApp.unblockPage();
    });
});

validadorFormListaDocumentos = formListaDocumentos.validate({
    submitHandler: function(form) {
        Swal.fire({
            title: "¿Está seguro?",
            text: "Antes de continuar, verifique que los datos ingresados sean correctos. Después de finalizar la tarea, no podrá regresar.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Sí, continuar",
            cancelButtonText: "Cancelar",
            reverseButtons: true
        }).then(function(result) {
            if (result.value) {
                KTApp.blockPage({
                    overlayColor: '#000000',
                    state: 'danger',
                    message: 'Por favor, espere...'
                });
                form.submit();
            }
        });
    }
});


