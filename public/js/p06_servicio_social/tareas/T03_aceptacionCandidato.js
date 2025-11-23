//Variables
formDatosAceptacion = $( "#formDatosAceptacion" );
btnDatosAceptacion = $("#btnDatosEntrevista");

//BEGIN::Boton enviar estatus
btnDatosAceptacion.click(function(e) {
    e.preventDefault();
    if ( formDatosAceptacion.valid() ) {
        alert_warning_secondary("Verifique que el candidato seleccionado sea el indicado.", (result) => {
            if (result.value) {
                KTApp.blockPage({
                     overlayColor: '#000000',
                     state: 'danger',
                     message: 'Por favor, espere...'
                 });
                formDatosAceptacion.submit();
            }
        });
    }
});
//END::Boton enviar estatus
//BEGIN::Validación
var validator = formDatosAceptacion.validate({
    onfocusout: false,
    rules: {
        EstatusCandidato: 'required'
    },
    messages: {
        EstatusCandidato: 'Campo obligatorio'
    },
    errorPlacement: function(label, element) {
        element.addClass('error');
        label.insertAfter(element);
    }
});
//END::Validación