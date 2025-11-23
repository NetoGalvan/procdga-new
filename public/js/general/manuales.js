const modalViewManual = $("#modal_manual_usuario");
const tituloManual = $("#titulo_manual");
const visualizadorPDF = $("#visualizador_pdf");
const cardManual = $(".card-manual");

cardManual.click(function() {
    let tituloPDF = $(this).data("titulo");
    let urlPDF = $(this).data("url");
    tituloManual.html(tituloPDF);
    visualizadorPDF.attr("src", urlPDF);
    modalViewManual.modal("show");
});
