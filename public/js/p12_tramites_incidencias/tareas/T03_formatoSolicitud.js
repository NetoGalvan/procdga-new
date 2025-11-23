const formFinalizarTarea = $("#form_finalizar_tarea");
const btnDescargarFormato = $("#btn_descargar_formato");

const validatorFormFinalizarTarea = formFinalizarTarea.validate({
    submitHandler: function(form) {
        swal.fire({
            title: "¿Está seguro?",
            text: "Imprima el formato antes de continuar. Después de finalizar la tarea, no podrá regresar.",
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

btnDescargarFormato.click(function (e) {
    e.preventDefault();
        KTApp.blockPage({
            overlayColor: '#000000',
            state: 'danger',
            message: 'Por favor, espere...'
        });
    $.get($(this).attr("href")).done(function (resp) {
        downloadFileBase64(resp.pdf, resp.nombre)
    }).fail(function(jqXHR, textStatus, error) {
        swal.fire("", error, "error");
    }).always(function() {
        KTApp.unblockPage();
    });
});