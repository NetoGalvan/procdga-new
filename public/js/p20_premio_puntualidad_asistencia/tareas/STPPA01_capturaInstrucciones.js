const tablaPremioPuntualidadSub = $("#tabla_premio_puntualidad_subproceso");
const formInstrucciones         = $("#frm_captura_instrucciones");
const btnFinalizar              = $("#btn_finalizar_subtarea");

$(document).ready(function(){
    if (mensajeError) {
        Swal.fire({
            html: mensajeError,
            icon: 'warning',
            confirmButtonColor: '#0BB7AF',
            confirmButtonText: 'Ok'
        });
    }

    // Inicializa la tabla
    if ( areasQueParticipan.length > 0 ){
        tablaPremioPuntualidadSub.bootstrapTable("destroy");
        tablaPremioPuntualidadSub.bootstrapTable({data: areasQueParticipan});
    } else {
        tablaPremioPuntualidadSub.bootstrapTable();
    }

});

function areasFormatter(value, row) {
    let { identificador, nombre} = row;
    return `${identificador} - ${nombre}`;
}

btnFinalizar.click(function(e) {
    e.preventDefault();
    // Recuperamos los renglones seleccionados
    let subareasIncentivo = tablaPremioPuntualidadSub.bootstrapTable('getSelections');
    if ( subareasIncentivo.length > 0 ) {
        if ( $("#frm_captura_instrucciones").valid() ) {
            $('#subareas').val(JSON.stringify(subareasIncentivo));
            swal.fire({
                title: "¿Está seguro?",
                html: "Antes de continuar, verifique que los datos ingresados sean correctos. Después de finalizar la tarea, no podrá regresar.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Sí, continuar",
                cancelButtonText: "Cancelar",
                reverseButtons: true,
                allowOutsideClick: false,
            }).then((result) => {
                if (result.value) {
                    KTApp.blockPage({
                        overlayColor: '#000000',
                        state: 'danger',
                        message: 'Por favor, espere...'
                    });
                    formInstrucciones.submit();
                }
            });
        }
    } else {
        Swal.fire("¡Atención!", "Debes seleccionar al menos una área ó subárea.", "warning");
    }

});
