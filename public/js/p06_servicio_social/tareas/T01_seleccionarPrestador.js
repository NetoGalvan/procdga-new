//Variables
var btnSeleccionarCandidato = $("#seleccionarCandidato");
var btnFinalizarProceso = $("#finalizar");
var formSeleccionarPrestador = $('#seleccionarPrestador');

//Configuración tabla
$('#candidatosTable tbody').find('tr').css('cursor', 'pointer');
$('#candidatosTable tbody').on('click', 'tr',function() {
    $('#candidatosTable #seleccion:checked').attr('checked',false);
    $(this).find('#seleccion').attr('checked',true);
});

//BEGIN::Botones
// -----
btnSeleccionarCandidato.click(function(e) {
    e.preventDefault();
    var prestador_id = $('#candidatosTable #seleccion:checked').data('seleccionar');//obener el id del prestador seleccionado

    if(prestador_id){
        alert_warning_secondary("Verifique que el candidato seleccionado sea el indicado.", (result) => {
            if (result.value) {
                KTApp.blockPage({
                    overlayColor: '#000000',
                    state: 'danger',
                    message: 'Por favor, espere...'
                });
                formSeleccionarPrestador.attr('action', URL_seleccionarPrestador);
                formSeleccionarPrestador.find('#seleccion:checked').val(prestador_id); //Modificar valor del radio "on" por el "id del prestador"
                formSeleccionarPrestador.submit();
            }
        });
    } else {
        alert_warning_simple("Seleccione a un candidato");
    }
});
// -----
btnFinalizarProceso.click(function(e) {
    e.preventDefault();

    alert_warning_secondary("Está por finalizar el proceso.", (result) => {
        if (result.value) {
          KTApp.blockPage({
               overlayColor: '#000000',
               state: 'danger',
               message: 'Por favor, espere...'
           });
           formSeleccionarPrestador.attr('action', URL_finalizarProceso);
           formSeleccionarPrestador.submit();
        }
    });
});
//END::Botones