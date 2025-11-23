var selectEmpleadosFichaExpediente = $("#datos_empleado");
var formCrearExpediente = $('#form_crear_expediente');

var rfc = $('[name="rfc"]');
var numeroEmpleado = $('[name="numero_empleado"]');
var nombre = $('[name="nombre"]');
var apellidoPaterno = $('[name="apellido_paterno"]');
var apellidoMaterno = $('[name="apellido_materno"]');

var noExpediente = $('[name="numero_expediente"]');

var btnCancelarProceso = $('#btn_cancelar_proceso');

//BEGIN::Select Empleados
selectEmpleadosFichaExpediente.change( function(e){ 
    e.preventDefault();

    if( $(this).val() != null){
        var datosEmpleado = JSON.parse($(this).val());
        rfc.val(datosEmpleado.rfc);
        numeroEmpleado.val(datosEmpleado.numero_empleado);
        nombre.val(datosEmpleado.nombre);
        apellidoPaterno.val(datosEmpleado.apellido_paterno);
        apellidoMaterno.val(datosEmpleado.apellido_materno);

        $.post(URL_crearExpediente, {rfc: rfc.val()} ).done(function(response) { // Funcion "creacionExpediente" del controlador -> Comprobar que el empleado no tenga ningún expediente
            if ( !response.estatus ) { 
                alert_error(response.mensaje, null); 
                selectEmpleadosFichaExpediente.val('').trigger('change');
            }
        });
    } else {
        rfc.val('');
        numeroEmpleado.val('');
        nombre.val('');
        apellidoPaterno.val('');
        apellidoMaterno.val('');
    }

    validator.element(rfc);
    validator.element(numeroEmpleado);
    validator.element(nombre);
    validator.element(apellidoPaterno);
    validator.element(apellidoMaterno);
});
//END::Select Empleados

//BEGIN::Número de expediente
noExpediente.on('input', function(e) {
    e.preventDefault();

    $.validator.addMethod("comparacion", function(value, element, params) { return (value == params) ? false : true; });

    $.post(URL_crearExpediente, {no_expediente: $(this).val()} ).done(function(response) { // Funcion "creacionExpediente" del controlador -> Comprobar que el número de expediente no exista para evitar duplicados

        if ( !response.estatus ) { 

            noExpediente.rules( "add", {   // -----> Agregando regla
                comparacion: response.mensaje,
                messages: {
                    campoNoVacio: 'Campo obligatorio',
                    comparacion: 'Existe un expediente registrado con este número'
                }
            });
        }
        validator.element(noExpediente);
    });
});
//END::Número de expediente

//BEGIN::Finalizar tarea
$('#finalizarTarea').click( function(e) {
    e.preventDefault();

    if( formCrearExpediente.valid() ) {
        var datos = datosNotasActualizado();

        alert_warning_secondary(`Crear expediente con número: <b>${noExpediente.val()}</b>`, (result) => {
            if (result.value) {
                KTApp.blockPage({
                    overlayColor: '#000000',
                    state: 'danger',
                    message: 'Por favor, espere...'
                });
                 
                notas.css('color', 'white');
                notas.val(JSON.stringify(datos));

                formCrearExpediente.attr('action', URL_crearExpediente);
                formCrearExpediente.submit();
            }
        });
    }
});

var validator = formCrearExpediente.validate({
    onfocusout: false,
    rules: {
        rfc: 'required',
        numero_empleado: 'required',
        nombre: 'required',
        apellido_paterno: 'required',
        apellido_materno: 'required',
        numero_expediente: 'campoNoVacio'
    },
    messages: {
        rfc: 'Campo obligatorio',
        numero_empleado: 'Campo obligatorio',
        nombre: 'Campo obligatorio',
        apellido_paterno: 'Campo obligatorio',
        apellido_materno: 'Campo obligatorio',
        numero_expediente: 'Campo obligatorio'
    }
});
//END::Finalizar tarea

btnCancelarProceso.click(function(e) {
    e.preventDefault();

    formCrearExpediente.validate().settings.ignore = '[name="rfc"], [name="numero_empleado"], [name="nombre"], [name="apellido_paterno"], [name="apellido_materno"], [name="numero_expediente"], [name="datos_empleado"]';
    
    alert_warning_secondary("Está por cancelar el proceso.", (result) => {
        if (result.value) {

            KTApp.blockPage({
                overlayColor: '#000000',
                state: 'danger',
                message: 'Por favor, espere...'
            });
  
            formCrearExpediente.attr('action', URL_cancelarProceso);
            formCrearExpediente.submit();
        }
    });
});