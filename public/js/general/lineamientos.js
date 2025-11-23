const modalView = $("#modal_view");
const tituloModal = $("#titulo_modal");
const visualizadorPDF = $("#visualizador_pdf");
const cardManual = $(".card-lineamiento");

cardManual.click(function() {
    let tituloPDF = $(this).data("titulo");
    let urlPDF = $(this).data("url");
    tituloModal.html(tituloPDF);
    visualizadorPDF.attr("src", urlPDF);
    modalView.modal("show");
});
