soloTexto = $('.solo-texto');

function tooltip(tabla, btnAccion) {
    tabla.on('mouseover', btnAccion, function(e) {
        $(this).tooltip({ html: true, trigger:'hover' }).tooltip('show');
    });
}

soloTexto.on('keypress', (e) => { if( !(/[A-Z\. ]/ig).test( e.key ) ) return false });

// ---> input mask
$(".inputmk-10").inputmask({ "mask": "9", "repeat": 10 });
$(".inputmk-6").inputmask({ "mask": "9", "repeat": 6 });

// ---> cursor-pointer
$('cursor-pointer').css('cursor', 'pointer');

// ---> date picker
$('.date-picker').datepicker({
    rtl: KTUtil.isRTL(),
    todayHighlight: true,
    format: 'dd/mm/yyyy',
    startDate: '0',
    language: 'es',
    autoclose: true,
    daysOfWeekDisabled: [0,6]
});

$('.date-picker-range').datepicker({
    rtl: KTUtil.isRTL(),
    todayHighlight: true,
    format: 'dd/mm/yyyy',
    startDate: '0',
    language: 'es',
    autoclose: true,
    daysOfWeekDisabled: [0,6]
});

$('.time-picker').timepicker();

// validacion
$('.selectpicker').on("change", (e) => { validator.element('.selectpicker') });
$('.date-picker').datepicker().on('changeDate', (e) => { validator.element('.date-picker') });

function restablecer_formulario( form ){
    document.getElementById( form.attr('id') ).reset(); // restablecer campos
    form.validate().resetForm(); // restablecer validación

    $.each(form.find('.is-invalid'), function(x, i) { // Limpiar validaciones ( mensajes - class )
        if($(this).attr('name') != undefined) $(`#${ $(this).attr('name') }-error`).remove();
        $(this).attr('class', $(this).attr('class').replace(" is-invalid", "") );
    });

    $.each(form.find('.is-valid'), function(x, i) {
        $(this).attr('class', $(this).attr('class').replace(" is-valid", "") );
    });
}