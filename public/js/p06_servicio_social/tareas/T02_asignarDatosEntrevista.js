//Variables
var fecha_cita = $(".fecha-cita");
var formDatosEntrevista = $( "#formDatosEntrevista" );
var btnDatosEntrevista = $("#btnDatosEntrevista");
var btnFinalizarProceso = $("#finalizar");

//BEGIN::Botones
btnDatosEntrevista.click(function() {
    if ( formDatosEntrevista.valid() ) {
        alert_warning_secondary("Verifique que el candidato seleccionado sea el indicado.", (result) => {
            if (result.value) {
                KTApp.blockPage({
                     overlayColor: '#000000',
                     state: 'danger',
                     message: 'Por favor, espere...'
                 });
                formDatosEntrevista.attr('action', URL_asignarEntrevista);
                formDatosEntrevista.submit();
            }
        });
    }
});
// -----
btnFinalizarProceso.click(function(e) {
    e.preventDefault();

    formDatosEntrevista.validate().settings.ignore = ".fecha-cita, .hora-cita";
    
    alert_warning_secondary("Está por finalizar el proceso.", (result) => {
        if (result.value) {
          KTApp.blockPage({
               overlayColor: '#000000',
               state: 'danger',
               message: 'Por favor, espere...'
           });
           formDatosEntrevista.attr('action', URL_finalizarProceso);
           formDatosEntrevista.submit();
        }
    });
});
//END::Botones
//BEGIN::Validación  
var validator = formDatosEntrevista.validate({
    onfocusout: false,
    rules: {
        fecha_cita: 'required',
        hora_cita: 'required'
    },
    messages: {
        fecha_cita: 'Campo obligatorio',
        hora_cita: 'Campo obligatorio'
    }
});
//END::Validación