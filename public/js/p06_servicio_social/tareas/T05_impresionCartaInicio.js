//BEGIN::Botones
$('.correcto-incorrecto').on('click', '#agregarObservaciones', function(e) {
    e.preventDefault();
    if ( validator.element( "#observaciones_carta_inicio" ) ) {
        alert_warning_secondary("Verifique que los datos sean los correctos.", (result) => { 
            if (result.value) {
                KTApp.blockPage({
                     overlayColor: '#000000',
                     state: 'danger',
                     message: 'Por favor, espere...'
                 });
                $.post(URL_cartaInicio, {observaciones_carta_inicio: $("#observaciones_carta_inicio").val()})
                 .done(function(response) {
                    KTApp.unblockPage();
                    alert_success(response.mensaje, null);
                 });
            }
        });
    }
});
// -----
$('.card-body').on('change', '.carta_firmada', function(e) {
    e.preventDefault();

    if($(this).is(':checked')){
        $.post(URL_cartaInicio, {carta_firmada: $(this).is(':checked')})
         .done(function(response) {
            if( !response.estatus ) { 
                alert_error(response.mensaje, (result) => { 
                    $('.card-body .carta_firmada').prop('checked', false);
                });
            }
         });
    }
});
// -----
function descargarDocumento(URL_documento, nameButton, nombreArchivo) {
    $('.card-body').on('click', nameButton, function(e) {
        e.preventDefault();

        $.ajax({
            url: URL_documento,
            type: "GET",
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
                link.download = nombreArchivo;
                link.click();

                KTApp.unblockPage();
            }
        });
    });
}

descargarDocumento(URL_cartaInicioPDF, '.carta_aceptacion', nombreArchivoCartaAceptacion);
descargarDocumento(URL_fichaPrestadorPDF, '.ficha_prestador', nombreArchivoFichaPrestador);
// -----
$('.btn-homework').on('click', '#btnFinalizarCartaInicio', function(e) {
    e.preventDefault();

    formCartaInicio_T05.validate().settings.ignore = "#observaciones_carta_inicio"; // Ignorar campo de la validación
    
    if($('.carta_firmada').is(':checked')){

        alert_warning_secondary("Después de finalizar la tarea, no podrá regresar.", (result) => { 
            if (result.value) {
                KTApp.blockPage({
                     overlayColor: '#000000',
                     state: 'danger',
                     message: 'Por favor, espere...'
                 });
                formCartaInicio_T05.attr('action', URL_cartaInicio);
                formCartaInicio_T05.submit();
            }
        });
    } else {
        alert_error('Confirme que la carta de aceptación este firmada para continuar', null);
    }
});
//END::Botones