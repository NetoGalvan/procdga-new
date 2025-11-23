function tooltip(tabla, btnAccion) {
    tabla.on('mouseover', btnAccion, function(e) {
        $(this).tooltip({ html: true, trigger:'hover' }).tooltip('show');
    });
}

var activarSpinner = (button) => {
    button.attr('hidden', true);
    $('#spinner_active').attr('hidden', false);
}

var desactivarSpinner = (button) => {
    button.attr('hidden', false);
    $('#spinner_active').attr('hidden', true);
}

var activarSpinner02 = (button) => {
    button.attr('hidden', true);
    $('#spinner_active_02').attr('hidden', false);
}

var desactivarSpinner02 = (button) => {
    button.attr('hidden', false);
    $('#spinner_active_02').attr('hidden', true);
}

$('.inputmk-fecha').inputmask({mask: '##/##/####'});
$('.date-picker').datepicker({
    rtl: KTUtil.isRTL(),
    todayHighlight: true,
    format: 'dd/mm/yyyy',
    language: 'es',
    autoclose: true,
    orientation: 'bottom'
});

$('.year-picker').datepicker({
    format: "yyyy",
    viewMode: "years",
    minViewMode: "years",
    startDate: '2000',
    endDate: '+0y',
    autoclose : true,
    orientation: "bottom left"
});

$('.select-pk').select2({
    placeholder: 'SELECCIONE UNA OPCIÓN'
});

$('cursor-pointer').css('cursor', 'pointer');