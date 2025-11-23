const hrefDescargarSeguimientos = $("#href_descargar_seguimientos");
const hrefDescargarDetalles = $("#href_descargar_detalles");
const formFinalizacion = $('#id_form_descarga_documento_kardex');
const btnFinalizarProceso = $("#btn_finalizar_descarga_documento_kardex");

$(document).ready(function () {

    // validamos que tab esta activo
    $(".nav a").on("click", function(){
        var activeTabHref = $(this).attr('href');
        if (activeTabHref === "#kt_tab_descarga_documentos") {
            btnFinalizarProceso.prop('disabled', false);
        } else {
            btnFinalizarProceso.prop('disabled', true);
        }
    });

});

hrefDescargarSeguimientos.click(function (e) {
    e.preventDefault();
    Swal.fire({
        title: 'Seguimiento(s)',
        text: "¿Descargar seguimiento(s)?",
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
            let url = hrefDescargarSeguimientos.attr('href');
            let data = '';

            $.ajax({
                type: "GET",
                url: url,
                data: data,
                success: function (response) {
                    let url = "data:application/pdf;base64," + response.pdf;
                    let link = document.createElement('a');
                    link.href = url;
                    link.download = response.nombre;
                    link.click();

                    KTApp.unblockPage();
                    Swal.fire({
                        text: '¡Descarga exitosa!',
                        icon: 'success',
                        confirmButtonColor: '#0BB7AF',
                        confirmButtonText: 'Ok'
                    })
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    KTApp.unblockPage();
                    Swal.fire({
                        html: '¡Error, intente más tarde o comuniquese con el área correspondiente!',
                        icon: 'warning',
                        confirmButtonColor: '#0BB7AF',
                        confirmButtonText: 'Ok'
                    });
                }
            });
        }
    })
});

hrefDescargarDetalles.click(function (e) {
    e.preventDefault();
    Swal.fire({
        title: 'Detalle(s)',
        text: "¿Descargar detalle(s)?",
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
            let url = hrefDescargarDetalles.attr('href');
            let data = '';

            $.ajax({
                type: "GET",
                url: url,
                data: data,
                success: function (response) {
                    let url = "data:application/pdf;base64," + response.pdf;
                    let link = document.createElement('a');
                    link.href = url;
                    link.download = response.nombre;
                    link.click();

                    KTApp.unblockPage();
                    Swal.fire({
                        text: '¡Descarga exitosa!',
                        icon: 'success',
                        confirmButtonColor: '#0BB7AF',
                        confirmButtonText: 'Ok'
                    })
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    KTApp.unblockPage();
                    Swal.fire({
                        html: '¡Error, intente más tarde o comuniquese con el área correspondiente!',
                        icon: 'warning',
                        confirmButtonColor: '#0BB7AF',
                        confirmButtonText: 'Ok'
                    });
                }
            });
        }
    })
});

const validatorFormFinalizarTarea = formFinalizacion.validate({
    submitHandler: function(form) {
        Swal.fire({
            title: `${firmas ? '¿Finalizar proceso?' : '¿Guardar firmas?'}`,
            text: "Antes de continuar, verifique que la información sea correcta. Después ya no podrá realizar ningún cambio.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Sí, continuar",
            cancelButtonText: "Cancelar",
            reverseButtons: true
        }).then((result) => {
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
