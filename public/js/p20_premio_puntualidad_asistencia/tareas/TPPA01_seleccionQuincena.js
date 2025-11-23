const tablaPremioPuntualidad    = $("#tabla_premio_puntualidad");
const formInstrucciones         = $("#frm_seleccion_quincena");
const btnFinalizar              = $("#btn_finalizar");
const btnCancelarProceso        = $("#btn_cancelar_proceso");
const selectQuincena            = $("#fecha_quincena");

$(document).ready(function(){
    if (mensajeError) {
        Swal.fire({
            html: mensajeError,
            icon: 'warning',
            confirmButtonColor: '#0BB7AF',
            confirmButtonText: 'Ok'
        });
    }

    selectQuincena.select2({
        placeholder: "Selecciona una opción"
    });

    // Inicializa la tabla
    if ( areasQueParticipan.length > 0 ){
        tablaPremioPuntualidad.bootstrapTable("destroy");
        tablaPremioPuntualidad.bootstrapTable({data: areasQueParticipan});
    } else {
        tablaPremioPuntualidad.bootstrapTable();
    }

});

function areasFormatter(value, row) {
    let { identificador, nombre} = row;
    return `${identificador} - ${nombre}`;
}

/* function presupuestoFormatter(value, row) {
    let {area_id} = row;
    return `<div class="center">
                <span class="switch switch-outline switch-icon switch-success">
                    <label>
                        <input class="check" type="checkbox" name="areas[]" value="${area_id}" id="area_${area_id}" autocomplete="off" />
                        <span></span>
                    </label>
                </span>
            </div>`;
} */

btnCancelarProceso.click(function() {

    swal.fire({
        title: "¿Está seguro de cancelar el proceso?",
        text: "El folio se cancelará y no podrá continuar.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, CANCELAR proceso",
        cancelButtonText: "No, regresar",
        reverseButtons: true
    }).then((result) => {
        if (result.value) {
            KTApp.blockPage({
                overlayColor: '#000000',
                state: 'danger',
                message: 'Por favor, espere...'
            });
            $("#frm_seleccion_quincena").append(`<input type="hidden" name="accion" value="cancelar">`);
            $("#frm_seleccion_quincena")[0].submit();
        }
    });

});

btnFinalizar.click(function(e) {
    e.preventDefault();

    // Recuperamos los renglones seleccionados
    let areasIncentivo = tablaPremioPuntualidad.bootstrapTable('getSelections');

    if ( areasIncentivo.length > 0 ) {
        if ( $("#frm_seleccion_quincena").valid() ) {
            $('#areas').val(JSON.stringify(areasIncentivo));
            swal.fire({
                title: "Finalizar tarea",
                text: "Antes de continuar, verifique que los datos ingresados sean correctos. Después de finalizar la tarea, no podrá regresar.",
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
        Swal.fire("¡Atención!", "Debes seleccionar al menos una área.", "warning");
    }

});
