var btnCrearFichaExp = $('#crearFichaExpediente');
var tablaExpedientes = $('#tabla_expedientes tbody');
var btnCancelarProceso = $('#cancelar_proceso');

// Crear Expediente -->>
btnCrearFichaExp.click(function() {
    alert_warning_secondary("Crear nuevo expediente", (result) => {
        if (result.value) {

             KTApp.blockPage({
                overlayColor: '#000000',
                state: 'danger',
                message: 'Por favor, espere...'
            });

            formBuscarExpediente.attr('action', URL_buscarDatosExpediente);
            formBuscarExpediente.submit();
        }
    });
});

// Actualizar Expediente -->>
tablaExpedientes.on('click', 'tr', function(e){
    var noExpediente = $(this).data('expediente');
    var URL_expedienteEncontrado = $(this).data('url');
    
    alert_warning_secondary(`Actualizar el expediente <br> <b>${noExpediente}</b>`, (result) => {
        if (result.value) {
      
            KTApp.blockPage({
                overlayColor: '#000000',
                state: 'danger',
                message: 'Por favor, espere...'
            });

            formBuscarExpediente.attr('action', URL_expedienteEncontrado);
            formBuscarExpediente.submit();
        }
    });
});

// Cancelar Proceso -->>
btnCancelarProceso.click(function(e) {
    e.preventDefault();

    alert_warning_secondary("Está por cancelar el proceso.", (result) => {
        if (result.value) {

            KTApp.blockPage({
                overlayColor: '#000000',
                state: 'danger',
                message: 'Por favor, espere...'
            });
  
            formBuscarExpediente.attr('action', URL_cancelarProceso);
            formBuscarExpediente.submit();
        }
    });
});