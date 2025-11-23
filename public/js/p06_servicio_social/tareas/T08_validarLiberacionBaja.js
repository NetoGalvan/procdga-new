//Variables
var btnValidarTarea = $("#validarTarea");
var formValidarTarea = $( "#formValidarTarea" );
var table = $('#tabla_documento');

//BEGIN::Validación
validator = formValidarTarea.validate({
    onfocusout: false,
    rules: {
        validacion: 'required'
    },
    messages: {
        validacion: 'Campo obligatorio'
    }
});
//END::Validación
//BEGIN::Botón de validación (Liberar/Baja)
btnValidarTarea.click(function(e) {
    e.preventDefault();

    if ( formValidarTarea.valid() ) {

        var baja = false;
        var abandono = false;
        
        $.each(table.find('td'), function(i, item) {
            if($(this).text() == "SOLICITAR BAJA"){
                baja = true;
                return false;
            }
        });

        $.each(table.find('td'), function(i, item) {
            if($(this).text() == "ABANDONO"){
                abandono = true;
                return false;
            }
        });

        if(($('#validacion').val() == 'BAJA') && (baja == false)) {
            alert_error('<span class="badge badge-secondary badge-lg"><strong>No se puede dar de baja al candidato</strong></span><br><br>El enlace no ha generado la solicitud de baja', null);
             
        } else if(($('#validacion').val() == 'ABANDONO') && (abandono == false)) {
            alert_error('<span class="badge badge-secondary badge-lg"><strong>No se puede validar el abandono</strong></span><br><br>El enlace no ha generado la solicitud de abandono', null);
             
        } else if(($('#validacion').val() == 'LIBERADO') && (parseInt($('.horas-restantes').html()) != 0)){
            alert_error('<span class="badge badge-secondary badge-lg"><strong>No se puede liberar el servicio</strong></span><br><br>El candidato aún no finaliza con el tiempo y horas del servico', null);
        } 
        else {
            alert_warning_secondary("Verifique que la opción elegida sea la correcta", (result) => {

                if (result.value) {
                    KTApp.blockPage({
                        overlayColor: '#000000',
                        state: 'danger',
                        message: 'Por favor, espere...'
                    });
                    formValidarTarea.submit();
                }
            });
        }
    }
});
//END::Botón de validación (Liberar/Baja)