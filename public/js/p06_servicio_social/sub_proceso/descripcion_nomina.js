//Variables
var formIniciarProceso = $("#id_form_iniciar_proceso_nomina");
var btnIniciarProceso = $("#id_btn_iniciar_proceso_nomina");

//Botón
btnIniciarProceso.click(function() {
  alert_warning_primary("Se creará un nuevo folio y la primer tarea para el proceso.", (result) => {
      if (result.value) {
          KTApp.blockPage({
              overlayColor: '#000000',
              state: 'danger',
              message: 'Por favor, espere...'
          });
          formIniciarProceso.submit();
      }
  });
});