//BEGIN::Botón correcciones
$('.btn-homework').on('click', '#btnRegresoCorrecciones', function(e) {
    e.preventDefault();
    
    if (validator.element( "#correcciones" )) {
        alert_warning_secondary("Verifique que la información sea correcta, regresará a la tarea para hacer las correcciones correspondientes", (result) => {
            if (result.value) {
                KTApp.blockPage({
                     overlayColor: '#000000',
                     state: 'danger',
                     message: 'Por favor, espere...'
                 });
                formCartaInicio_T05.attr('action', URL_correcciones);
                formCartaInicio_T05.submit();
            }
        });
    }
});
//END::Botón correcciones