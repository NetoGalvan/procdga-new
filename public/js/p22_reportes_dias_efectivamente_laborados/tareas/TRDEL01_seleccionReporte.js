//Variables
var periodoEvaluacion = $('.periodo_evaluacionV2');
// -----
var btnCancelarProceso = $("#btn_cancelar_proceso");
var btnFinalizarTarea = $("#btn_finalizar_TRDEL01");
var formSeleccionarReporte = $("#form_seleccionar_reporte");

//BEGIN::Validación
formSeleccionarReporte.validate({
    onfocusout: false,
    rules: {
        tipo_reporte: 'required',
        periodo_evaluacion: 'required',
    },
    messages: {
        tipo_reporte: 'Campo obligatorio',
        periodo_evaluacion: 'Campo obligatorio',
    }
});
//END::Validación
//BEGIN::Botones
btnFinalizarTarea.click(function(e) {
    e.preventDefault();

    if( formSeleccionarReporte.valid() ){
        alert_warning_secondary("Verifique que el reporte y periodo seleccionado sean los indicados.", (result) => {
            if (result.value) {
              KTApp.blockPage({
                   overlayColor: '#000000',
                   state: 'danger',
                   message: 'Por favor, espere...'
               });
               formSeleccionarReporte.attr('action', URL_seleccionarReporte);
               formSeleccionarReporte.submit();
            }
        });
    }
});
// ------
btnCancelarProceso.click(function(e) {
    e.preventDefault();

    formSeleccionarReporte.validate().settings.ignore = "#tipo_reporte, .periodo_evaluacionV2";

    alert_warning_secondary("Está por cancelar el proceso.", (result) => {
        if (result.value) {
            KTApp.blockPage({
                overlayColor: '#000000',
                state: 'danger',
                message: 'Por favor, espere...'
            });
            formSeleccionarReporte.attr('action', URL_finalizarProceso);
            formSeleccionarReporte.submit();
        }
    });
});
//END::Botones

//BEGIN::Configuración DatePicker
//Variables
var resultado = '';
var HTML_configDatePicker = `<hr>
                            <div class="interno text-center">
                                <div class=" col-12 radio-inline mb-5">
                                    <label class="radio text-center primero">
                                        <input type="radio" class="semestre" name="semestre" id="primero" value="primer_semestre" checked/>
                                        <span></span>
                                        &nbsp; ENE-JUN
                                    </label>
                                    <label class="radio text-center segundo">
                                        <input type="radio" class="semestre" name="semestre" id="segundo" value="segundo_semestre" />
                                        <span></span>
                                        &nbsp; JUL-DIC
                                    </label>
                                 </div>
                                <div>
                                    <button class="btn btn-primary btn-sm save">Guardar</button>
                                </div>
                            </div>`;
// ------------------------------------------------------------------------------------
var meses = {
            1: "ENERO", 2: "FEBRERO", 3: "MARZO", 4: "ABRIL", 
            5: "MAYO", 6: "JUNIO", 7: "JULIO", 8: "AGOSTO", 
            9: "SEPTIEMBRE", 10: "OCTUBRE",11: "NOVIEMBRE",12: "DICIEMBRE"
        };

$('#tipo_reporte').on('change', function(e) {
    e.preventDefault();

    periodoEvaluacion.off('change');
    periodoEvaluacion.off('click');
    $('body').off('click');
    periodoEvaluacion.datepicker('destroy');
    
    switch( $(this).val() )
    {
        case 'RMF':
            resultado = '';
            eventoDatePicker(2);
        break;

        case 'RML':
            resultado = '';
            semestreDatePickerPersonalized(periodoEvaluacion);
            
            periodoEvaluacion.on('click', function(e) {
                e.preventDefault();

                var div = document.querySelector('.interno');
                if (div == null) {
                    $('.datepicker .datepicker-years').append(HTML_configDatePicker);
                }
  
                radioButtons('primero', 'segundo');
                radioButtons('segundo', 'primero');         
                 $('.interno').on('click', '.save', function(e) {
                    e.preventDefault();

                    var semestre = '';
                    $.each($('.semestre'), function(key, item) {
                        if ( $(this).is(':checked') ) 
                        {
                            semestre = $(this).val();
                            return false;
                        }
                    });
                    semestre = ( semestre == 'primer_semestre' ) ? 'DE ENERO A JUNIO DEL ' : 'DE JULIO A DICIEMBRE DEL ';

                    var añoPorDefecto = document.querySelector('.datepicker-years span.focused');
                    var añoActivo = (añoPorDefecto != null) ? añoPorDefecto.innerHTML : $('.datepicker .datepicker-years').find('span.active').html();
                    
                    resultado = (semestre + añoActivo);
                    manipulacionDatePicker( periodoEvaluacion, resultado, semestreDatePickerPersonalized );
                });
            });

            
            periodoEvaluacion.on('change', function(e) {
                $('.datepicker .datepicker-years').find('span.focused').attr('class', 'year');
                periodoEvaluacion.val(resultado);
            });

            configurarDatePicker(semestreDatePickerPersonalized);
        break;

        case 'RE':
            resultado = '';
            eventoDatePicker(11);
        break;
    }
    periodoEvaluacion.attr('disabled', false);
});

var datePickerPersonalized = (campo) =>{
    campo.datepicker({
        viewMode: "months",
        minViewMode: "months",
        format: `mm-yyyy`,
        language: 'es',
        autoclose: true,
    });
}

var semestreDatePickerPersonalized = (campo) =>{
    campo.datepicker({
        changeYear: true,
        viewMode: "years",
        minViewMode: "years",
        format: `yyyy`,
        language: 'es',
    });
}

var radioButtons = (opt1, opt2) => {
    $('.interno').on('click', `.${opt1}`, function(e) {
        e.preventDefault();

        if($(`#${opt2}`).is(':checked')){
            $(`#${opt1}`).prop('checked', true);

        } else {
            $(`#${opt2}`).prop('checked', false);
        }
       
    }); 
}

var eventoDatePicker = (hasta) => {
    datePickerPersonalized(periodoEvaluacion);

    periodoEvaluacion.on('change', function(e) {

        var dataDate = $(this).val().split("-");
        var numberMesFin = parseInt(dataDate[0]) + hasta;
        var añoFin = parseInt(dataDate[1]);

        if (numberMesFin > 12) {
            numberMesFin = numberMesFin - 12;
            añoFin = añoFin + 1;
        }

        var inicio = `DE ${meses[parseInt(dataDate[0])]} DEL ${dataDate[1]}`;
        var fin = `${meses[numberMesFin]} DEL ${añoFin}`;

        resultado = (inicio + ' A ' + fin);
        manipulacionDatePicker( $(this), resultado, datePickerPersonalized );
    });

    configurarDatePicker(datePickerPersonalized);
}

var manipulacionDatePicker = (campo, value, configDatePicker) => {
    campo.datepicker('destroy');
    campo.val( value );
    configDatePicker(periodoEvaluacion);
}

var configurarDatePicker = (configDatePicker) => {
    $('body').click( function(e) {
        e.preventDefault();

        var datepicker = document.querySelector('.datepicker');
        if(datepicker == null) manipulacionDatePicker(periodoEvaluacion, resultado, configDatePicker);
    });
}
//END::Configuración DatePicker