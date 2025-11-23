//Variables
var formIniciarProceso = $("#form_iniciar_proceso_p22_reportes");
var btnIniciarProceso = $("#btn_iniciar_proceso_p22_reportes");

//Botón
btnIniciarProceso.click(function(e) {
    e.preventDefault();

    alert_warning_primary("Se creará un nuevo folio y la primer tarea para el proceso.", (result) => {
        if ( result.value ) 
        {
            KTApp.blockPage({
                overlayColor: '#000000',
                state: 'danger',
                message: 'Por favor, espere...'
            });
            formIniciarProceso.submit();
        }
    });
});