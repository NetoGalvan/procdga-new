//Variables
var formSeleccionarNomina = $( "#id_form_finalizar_T01_seleccion_nomina" );
var btnSeleccionarNomina = $('#finalizarT01SeleccionNomina');
var fechaInicio = '.fecha-inicio';
var fechaFin = '.fecha-fin';
var btnFinalizarSubProceso = $('#finalizarSubProceso');

//BEGIN::Configuraión Fecha
$(`${fechaInicio}, ${fechaFin}`).css('cursor', 'pointer');

$('#rango_de_fecha').datepicker({
    rtl: KTUtil.isRTL(),
    todayHighlight: true,
    format: 'dd/mm/yyyy',
    language: 'es',
    autoclose: true,
    daysOfWeekDisabled: [0,6]
});
//END::Configuraión Fecha
//BEGIN::Validación
validator = formSeleccionarNomina.validate({
    onfocusout: false,
    rules: {
        tipo_nomina: 'required',
        nombreNomina: 'campoNoVacio',
        observacionesNomina: 'campoNoVacio',
        fecha_inicio: {
            required: {
                depends: function() {
                    if($(fechaInicio).val() == "" && $(fechaFin).val() == "") {
                        $(fechaFin).attr('class', 'form-control fecha-fin is-invalid');
                    }
                    return true;
                }
            }
        },
    },
    messages: {
        tipo_nomina: 'Campo obligatorio',
        nombreNomina: 'Campo obligatorio',
        observacionesNomina: 'Campo obligatorio',
        fecha_inicio: 'Campos obligatorio',
    },
    errorPlacement: (label, element) => {
        if(element.attr('name') == $(fechaInicio).attr('name') || element.attr('name') == $('#nomina').attr('name')){
            element.closest(".campo").find(".msg").append(label);
        } else {
            element.addClass('error');
            label.insertAfter(element);
        }
    }
});
//END::Validación
//BEGIN::Botón para seleccionar nómina
btnSeleccionarNomina.click(function(e) {
    e.preventDefault();

    if ( formSeleccionarNomina.valid() )
    {
        $.post(URL_seleccionarTipoNomina, formSeleccionarNomina.serialize())
         .done(function(response) {

            alert_warning_secondary("Verifique que la información sea correcta", (result) => {
                if (result.value) {

                    if( !response.estatus ){
                        alert_error(response.mensaje, null);
                    } else {
                        KTApp.blockPage({
                            overlayColor: '#000000',
                            state: 'danger',
                            message: 'Por favor, espere...'
                        });
                        formSeleccionarNomina.attr('action', URL_seleccionarTipoNomina);
                        formSeleccionarNomina.submit();
                    }

                }
            });

         });
    }

    $(`${fechaInicio}, ${fechaFin}`).datepicker().on('changeDate', function(e){
            validator.element(fechaInicio);
            validator.element(fechaFin);
    });
});
//END::Botón para seleccionar nómina
$('.tipo-nomina').on('change', function(e) {
    var tipo_nomina = $(this).val().toUpperCase();

    var date = new Date();
    var mesNumber = (date.getMonth()+1);
    var meses = {
        1: 'ENERO', 2: 'FEBRERO', 3: 'MARZO', 4: 'ABRIL', 5: 'MAYO', 6: 'JUNIO',
        7: 'JULIO', 8: 'AGOSTO', 9: 'SEPTIEMBRE', 10: 'OCTUBRE', 11: 'NOVIEMBRE', 12: 'DICIEMBRE'
    }

    $('#nombreNomina').val(`${meses[mesNumber]} ${date.getFullYear()} NÓMINA ${tipo_nomina}`);
});


btnFinalizarSubProceso.click(function(e) {
    e.preventDefault();

    formSeleccionarNomina.validate().settings.ignore = ".fecha-inicio, .fecha-fin, .tipo-nomina, #nombreNomina, #observacionesNomina"; // Ignorar campo de la validación

    alert_warning_secondary("Finalizara con el proceso",
        (result) => {
            if(result.value) {
                KTApp.blockPage({
                    overlayColor: '#000000',
                    state: 'danger',
                    message: 'Por favor, espere...'
                });
                formSeleccionarNomina.attr('action', URL_finalizarProceso);
                formSeleccionarNomina.submit();
            }
        });

});
