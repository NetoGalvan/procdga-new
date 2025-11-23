//Variables
var fechaInicio = '.fecha-inicio';
var fechaFin = '.fecha-fin';
var formAsignarFunciones = $( "#formAsignacionFunciones" );
var btnAsignarFunciones = $("#btnAsignarFunciones");

// ----- Select área de adscripción --->
$(".area_adscripcion_id").on('change', function(e) {
    e.preventDefault();
    $.get(URL_getEscuelas, {area_adscripcion_id: $(this).val()})
     .done(function(response) {
        $('.domicilio_ua').val(response.direccion_area_adscripcion);
     });
});
// <---
//BEGIN::Botón para asignar funciones
btnAsignarFunciones.click(function(e) {
    e.preventDefault();
    if ( formAsignarFunciones.valid() ) {
        alert_warning_secondary("Verifique que el candidato seleccionado sea el indicado.", (result) => {
            if (result.value) {
                KTApp.blockPage({
                     overlayColor: '#000000',
                     state: 'danger',
                     message: 'Por favor, espere...'
                 });
                formAsignarFunciones.submit();
            }
        });
    }

    $(`${fechaInicio}, ${fechaFin}`).datepicker().on('changeDate', function(e){
            validator.element(fechaInicio);
            validator.element(fechaFin);
    });

});
//END::Botón para asignar funciones
//BEGIN::Validación
var validator = formAsignarFunciones.validate({
    onfocusout: false,
    rules: {
        fecha_inicio: {
            required: {
                depends: function() {
                    if($(fechaInicio).val() == "" && $(fechaFin).val() == "") {
                        $(fechaFin).attr('class', 'form-control date-picker cursor-pointer fecha-fin is-invalid');
                    }
                    return true;
                }
            }
        },
        actividades: 'campoNoVacio',
        jefe: 'required',
        puesto_jefe: 'required',
        telefono_jefe: 'required',
        telefono_ext_jefe: 'required',
        area_adscripcion_id: 'required',
        subdireccion_ua: 'required',
        unidad_departamental_ua: 'required'
    },
    messages: {
        fecha_inicio: 'Campos obligatorios',
        actividades: 'Campo obligatorio',
        jefe: 'Campo obligatorio',
        puesto_jefe: 'Campo obligatorio',
        telefono_jefe: 'Campo obligatorio',
        telefono_ext_jefe: 'Campo obligatorio',
        area_adscripcion_id: 'Campo obligatorio',
        subdireccion_ua: 'Campo obligatorio',
        unidad_departamental_ua: 'Campo obligatorio'
    },
    errorPlacement: (label, element) => {
        if(element.attr('name') == $(fechaInicio).attr('name')){
            element.closest(".campo").find(".msg").append(label);
        } else {
            element.addClass('error');
            label.insertAfter(element);
        }
    }
});
//END::Validación