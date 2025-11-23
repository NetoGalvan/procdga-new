const formFinalizarTarea = $("#form_selecciona_tipo_tramite_kardex");
const datosEmpleado = $("#datos_empleado");
let inputCurp = $("#curp");

// Función que genera el Switch
let Switch = function() {
    let activaSwitch = function() {
        $('[data-switch=true]').bootstrapSwitch();
    };
    return {
        init: function() {
            activaSwitch();
        },
    };
}();

$(document).ready(function () {

    if (mensajeTramite) {
        Swal.fire({
            html: mensajeTramite,
            icon: 'warning',
            confirmButtonColor: '#0BB7AF',
            confirmButtonText: 'Ok'
        });
    }

    // Inicializa el Switchs
    Switch.init();
    // Valida documentos
    $('#identificacion_oficial').on('switchChange.bootstrapSwitch', function(event, state) {
        // Acciones a realizar cuando cambie el estado del switch
        identificacionOficial = state;
    });
    $('#recibo_nomina').on('switchChange.bootstrapSwitch', function(event, state) {
        // Acciones a realizar cuando cambie el estado del switch
        reciboNomina = state;
    });
    $('#comprobante_domicilio').on('switchChange.bootstrapSwitch', function(event, state) {
        // Acciones a realizar cuando cambie el estado del switch
        comprobanteDomicilio = state;
    });
});

datosEmpleado.change(function (e) {
    e.preventDefault();
    let { curp } = this.value && JSON.parse(this.value);
    inputCurp.val(curp);
    formFinalizarTarea.validate().element("#curp");
});

const validatorFormFinalizarTarea = formFinalizarTarea.validate({
    submitHandler: function(form) {
        if ( identificacionOficial && reciboNomina && comprobanteDomicilio ) {
            Swal.fire({
                title: "¿Está seguro?",
                text: "Antes de continuar, verifique que los datos ingresados sean correctos. Después de finalizar la tarea, no podrá regresar.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Sí, continuar",
                cancelButtonText: "Cancelar",
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    KTApp.blockPage({
                        overlayColor: '#000000',
                        state: 'danger',
                        message: 'Por favor, espere...'
                    });
                    form.submit();
                }
            });
        } else {
            Swal.fire({
                html: 'Para poder finalizar la tarea,</br> deben estar verificados todos los documentos.',
                icon: 'warning',
                confirmButtonColor: '#0BB7AF',
                confirmButtonText: 'Ok'
            });
        }
    }
});
