//Variables
var formFinalizarT03 = $( "#id_finalizar_T03Cierre" );
var btnTerminarT03CierreNomina = $('#finalizarT03Cierre');
var btnFinalizarSubProceso = $('#finalizarSubProceso');

//BEGIN::Botones
btnTerminarT03CierreNomina.click(function(e) {
    e.preventDefault();
    
    var nuevo = false;
    var table = $('#estado_de_validacion_subEA');

    $.each(table.find('td'), function(i, item) {

        if($(this).text() == "NUEVO"){
            nuevo = true;
            return false;
        }
    });

    var tablePrestadoresLength = $('#prestadores_que_ya_pasaron_validacion tbody tr td').length;
    
    if( !nuevo ){
        if( tablePrestadoresLength > 1){
            alert_warning_secondary("Finalizara con la tarea", (result) => {
                if(result.value) {
                    KTApp.blockPage({
                        overlayColor: '#000000',
                        state: 'danger',
                        message: 'Por favor, espere...'
                    });
                    formFinalizarT03.attr('action', URL_finalizarTarea);
                    formFinalizarT03.submit();
                }
            });
        } else {
            alert_error("Ningún prestador fue aceptado para esta nómina", null);
        }
    } else {
        alert_error("Aún faltan áreas que no han terminado con su validación", null);
    }
});
// ------
btnFinalizarSubProceso.click(function(e) {
    e.preventDefault();
    
    var nuevo = false;
    var table = $('#estado_de_validacion_subEA');

    $.each(table.find('td'), function(i, item) {
        
        if($(this).text() == "NUEVO"){
            nuevo = true;
            return false;
        }
    });

    var tablePrestadoresLength = $('#prestadores_que_ya_pasaron_validacion tbody tr td').length;
    
    if( !nuevo ){
        if( tablePrestadoresLength > 1){
            alert_error("Hay prestadores susceptibles a la beca", null);
        } else {
            alert_warning_secondary("Finalizara con el proceso", 
            (result) => {
                if(result.value) {
                    KTApp.blockPage({
                        overlayColor: '#000000',
                        state: 'danger',
                        message: 'Por favor, espere...'
                    });
                    formFinalizarT03.attr('action', URL_finalizarProceso);
                    formFinalizarT03.submit();
                }
            });
            
        }
    } else {
        alert_error("Aún faltan áreas que no han terminado con su validación", null);
    }
});
//END::Botones