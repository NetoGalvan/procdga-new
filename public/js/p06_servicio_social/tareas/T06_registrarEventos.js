//Variables
var formFinalizarServicio = $('#finalizarServicio');
var btnLiberarServicio = $('#liberarServicio');
var btnBajaCandidato = $("#darDeBaja");
var btnAbandonoCandidato = $("#abandono");
var textBtnSelecionado = $('#opcion');

var horasTerminadas = (parseInt($('.horas-restantes').html()) == 0) ? true : false;

//BEGIN::Botones
$('#abandono, #liberarServicio, #darDeBaja').click(function(e){
    e.preventDefault();
    
    textBtnSelecionado.val('');
    var opcion = $(this).data('opcion');
    textBtnSelecionado.val(opcion);

    if (textBtnSelecionado.val() == 'LIBERADO') {
        if( horasTerminadas ) {
            if(validacion == 'LIBERADO') { finalizarTarea("Realizará la liberación del servicio"); }
            else { alert_error('La liberación del servicio aún no ha sido validado', null); }
        } else {
            alert_error('El candidato aún no finaliza con el tiempo y horas del servico', null);
        }
    }
    
    if (textBtnSelecionado.val() == 'BAJA') {
        var baja = buscarSolicitudBajaAbandono( "SOLICITAR BAJA" );

        if( baja ) {
            if(validacion == 'BAJA') { finalizarTarea("Realizará la baja del candidato");}
            else {alert_error('La baja del candidato aún no ha sido validada', null);}
        } else {
            alert_error('Verifique cargar el documento para la baja del candidato', null);
        }
    }

    if (textBtnSelecionado.val() == 'ABANDONO') {
        var abandono = buscarSolicitudBajaAbandono( "ABANDONO" );

        if( abandono ) {
            if(validacion == 'ABANDONO'){ finalizarTarea("Finalizará el proceso"); }
            else { alert_error('Aún no se ha validado el abandono del candidato', null); }
        } else {
            alert_error('Verifique enviar el abandono del candidato', null);
        }
    }
});

function finalizarTarea(mensaje) {
    alert_warning_secondary(mensaje, (result) => {
        if (result.value) {
            KTApp.blockPage({
                overlayColor: '#000000',
                state: 'danger',
                message: 'Por favor, espere...'
            });
            formFinalizarServicio.attr('action', URL_finalizarTarea);
            formFinalizarServicio.submit();
        }
    });
}

function buscarSolicitudBajaAbandono(solicitud) {
    var estatus = false;
    $.each(tablaCargarDocumentos.find('td'), function(i, item) {
        if($(this).text() == solicitud) {
            estatus = true;
            return false;
        }
    });

    return estatus;
}