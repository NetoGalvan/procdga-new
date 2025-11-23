const btnFinalizarServicio = $('#btn_finalizar_servicio');
const formConfirmacionServicio = $('#form_confirmacion_servicio');

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

    // Inicializa el Switch
    Switch.init();

    $('#interruptorLabel').html('<span class="requeridos">* </span>SI - El servicio brindado fue satisfactorio');
    $( '#textAreaRechazo' ).hide();
    $( '#textAreaSatisfecho' ).show();

    $('#interruptorEntregable').on('switchChange.bootstrapSwitch', function (event, state) {
        if ( $('#interruptorEntregable').is(':checked') ) {
            $( '#interruptorLabel').html('<span class="requeridos">* </span>SI - El servicio brindado fue satisfactorio');
            $( '#textAreaRechazo' ).hide();
            $( '#textAreaSatisfecho' ).show();
        } else {
            $('#interruptorLabel').html('<span class="requeridos">* </span>NO - Se requiere aclarar o ajustar uno o varios entregables');
            $( '#textAreaRechazo' ).show();
            $( '#textAreaSatisfecho' ).hide();
        }
    });

    tinymce.init({
        selector: '#textarea_comentarios_rechazo',
        plugins : 'advlist autolink link image lists charmap print preview',
        toolbar: [
            ' fontselect |  fontsizeselect | bold italic underline | alignleft aligncenter alignright '
          ],
          language : 'es_MX',
          menubar: false,
          branding: false,
          statusbar: false,
    });

    tinymce.init({
        selector: '#textarea_comentario_satisfecho',
        plugins : 'advlist autolink link image lists charmap print preview',
        toolbar: [
            ' fontselect |  fontsizeselect | bold italic underline | alignleft aligncenter alignright '
          ],
          language : 'es_MX',
          menubar: false,
          branding: false,
          statusbar: false,
    });

    /** Evento que finaliza la tarea*/
    btnFinalizarServicio.click(function (e) {
        e.preventDefault();

        Swal.fire({
            title: "Finalizar proceso",
            html: "¿Esta seguro(a) de terminar esta tarea? </br> Verifique que la opción elegida sea la deseada",
            icon: "question",
            showCancelButton: true,
            cancelButtonColor: '#F64E60',
            cancelButtonText: "Cancelar",
            confirmButtonText: "Continuar",
            confirmButtonColor: '#0BB7AF',
            reverseButtons: true,
        }).then(function(result) {
            if (result.value) {
                KTApp.blockPage({
                    overlayColor: '#000000',
                    state: 'danger',
                    message: 'Por favor, espere...'
                });
                formConfirmacionServicio.submit();
            }
        });

    });

});
