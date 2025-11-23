//BEGIN::Variables
var nombre_funcionario = $('#nombre_funcionario');
var puesto_funcionario = $('#puesto_funcionario');
var telefono_funcionario = $('#telefono_funcionario');
var formFuncionarioFin = $('#responsable_funcionario_fin');
var btnFuncionarioFin = $('#guardar_funcionario_fin');
//----
var formCartaFin = $('#carta_fin_T07');
var observaciones_carta_fin = $('#observaciones_carta_fin');
var btnAgregarObservaciones = $('#observacionesCartaFin');
//END::Variables
//BEGIN::Configuración
//telefono_funcionario.inputmask({ "mask": "9", "repeat": 10 });

//END::Configuración
//BEGIN::Validaciones
formFuncionarioFin.validate({
    onfocusout: false,

    rules: {
        nombre_funcionario: 'campoNoVacio',
        puesto_funcionario: 'campoNoVacio',
        telefono_funcionario: 'required'
    },
    messages: {
        nombre_funcionario: 'Campo obligatorio',
        puesto_funcionario: 'Campo obligatorio',
        telefono_funcionario: 'Campo obligatorio',
    }
});
// -----
formCartaFin.validate({
    onfocusout: false,

    rules: {
        observaciones_carta_fin : 'campoNoVacio'
    },
    messages: {
        observaciones_carta_fin: 'Campo obligatorio'
    }
 });

//END::Validaciones
//BEGIN::Botones
btnFuncionarioFin.click(function(e){
    e.preventDefault();

    if ( formFuncionarioFin.valid() ) {  

        const attrClass = $(this).attr('class');
        const HTML_buttonIcon = $(this).html();

        btnFuncionarioFin.attr('class', `${attrClass} spinner spinner-white spinner-right`);
        btnFuncionarioFin.html(`<i class="fas fa-save"></i>Actualizando...`);
        btnFuncionarioFin.attr('disabled', true);
        $.post(URL_postCartaFin, formFuncionarioFin.serialize() ).done(function(response) {
            btnFuncionarioFin.attr('disabled', false);
            btnFuncionarioFin.attr('class', `${attrClass}`);
            btnFuncionarioFin.html(HTML_buttonIcon);
        });
    }
});
// -----
btnAgregarObservaciones.click(function(e){
    e.preventDefault();

    if ( formCartaFin.valid() ) {

        alert_warning_secondary("Verifique que los datos ingresados sean los correctos.", (result) => {
            if (result.value) 
            {
                KTApp.blockPage({
                    overlayColor: '#000000',
                    state: 'danger',
                    message: 'Por favor, espere...'
                });
                $.post(URL_postCartaFin, formCartaFin.serialize() ).done(function(response) {
                    KTApp.unblockPage();
                    alert_success(response.mensaje, null);
                });
            }
        });
    }
});
// -----
$('.carta_termino').on('click', function(e) {
        e.preventDefault();

        $.ajax({
            url: URL_cartaFinPDF,
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
                link.download = nombreArchivoCartaTermino;
                link.click();

                KTApp.unblockPage();
            }
        });
    });
// -----
$('.carta_firmada').on('change', function(e) {
    e.preventDefault();

    if($(this).is(':checked')){
        $.post(URL_postCartaFin, {carta_firmada: $(this).is(':checked')})
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
$('#btnFinalizarCartaTerminacion').on('click', function(e) {
    e.preventDefault();

    formCartaFin.validate().settings.ignore = "#observaciones_carta_fin"; // Ignorar campo de la validación
    
    if($('.carta_firmada').is(':checked')){

        alert_warning_secondary("Después de finalizar la tarea, no podrá regresar.", (result) => { 
            if (result.value) {
                KTApp.blockPage({
                     overlayColor: '#000000',
                     state: 'danger',
                     message: 'Por favor, espere...'
                 });
                formCartaFin.attr('action', URL_postCartaFin);
                formCartaFin.submit();
            }
        });
    } else {
        alert_error('Confirme que la carta de termino este firmada para continuar', null);
    }
});
//END::Botones