// Variables
var btnAceptarTodos = $('#aceptar_todos');
var btnRechazarTodos = $('#rechazar_todos');
var btnRechazarPermanentTodos = $('#rechazar_todos_permanentemente');
// -----
var rulesPersonalizadas = {};
var msgPersonalizados = {};
// -----
var formFinalizarT02Validacion = $( "#id_finalizar_T02Validacion" );
var btnTerminarT02Validacion = $('#finalizarT02Validacion');

//Función para los botones de valideciones
var accionTodosPrestadores = (button) => {
    button.click(function(e) {
        e.preventDefault();

        var valor = $(this).data('validacion');
        $.each($('.asignar_validacion'), function(x, item) {
            var prestador_id = $(this).data('prestador');
            $(this).val(`${valor},${prestador_id}`).trigger('change');
            validator.element(`#${$(this).attr('id')}`);
        });

        alert_success("Todos los prestadores están con la validación de: <br> <strong>"+valor+"</strong>", null);    
    });
}

//BEGIN::Validación
$.each($('.asignar_validacion'), function(x, item) {
    var name = $(this).attr('name');

    rulesPersonalizadas[name] = 'required';
    msgPersonalizados[name] = 'Campo obligatorio';
});

var validator = formFinalizarT02Validacion.validate({
    onfocusout: false,
    rules: rulesPersonalizadas,
    messages: msgPersonalizados,
});
//END::Validación
//BEGIN::Botones
$('#prestadores_para_validar').on('change', '.asignar_validacion', function(e) {
    e.preventDefault();

    $.post(URL_validaciones, {'asignar_validacion[]': $(this).val()});
})

btnTerminarT02Validacion.click(function(e) {
    e.preventDefault();

    if( formFinalizarT02Validacion.valid() )
    {   
        alert_warning_secondary("Verifique que las validaciones sean las correctas", 
        (result) => {
            if (result.value) 
            {
                KTApp.blockPage({
                    overlayColor: '#000000',
                    state: 'danger',
                    message: 'Por favor, espere...'
                });
                $.each($('.asignar_validacion'), function(x, item) {
                    $(this).attr('name', 'asignar_validacion[]');
                });
                formFinalizarT02Validacion.attr('action', URL_validaciones);
                formFinalizarT02Validacion.submit();
            }
        });
        
    }
});
// ------
accionTodosPrestadores(btnAceptarTodos);
accionTodosPrestadores(btnRechazarTodos);
accionTodosPrestadores(btnRechazarPermanentTodos);
//END::Botones