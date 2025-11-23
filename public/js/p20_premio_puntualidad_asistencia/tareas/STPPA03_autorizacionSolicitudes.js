const tablaAutorizacionSub = $("#tabla_autorizacion_subproceso");

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
    if ( subAreas.length > 0 ){
        tablaAutorizacionSub.bootstrapTable("destroy");
        tablaAutorizacionSub.bootstrapTable({data: subAreas});
    } else {
        tablaAutorizacionSub.bootstrapTable();
    }
});

function areasFormatter(value, row) {
    let { identificador, nombre} = value;
    return `${identificador} - ${nombre}`;
}

function estatusFormatter(value, row) {
    if (value === 'NUEVO' ) {
        return `<span class="user-select-none label label-inline label-lg font-weight-bold label-rounded label-primary">EN PROCESO</span>`;
    } else if (value === 'EN_CORRECCION') {
        return `<span class="user-select-none label label-inline label-lg font-weight-bold label-rounded label-info">EN CORRECCIÓN</span>`;
    } else if (value === 'COMPLETADO') {
        return `<span class="user-select-none label label-inline label-lg font-weight-bold label-rounded label-success">${value}</span>`;
    }
}

function reporteFormatter(value, row) {
    let { premio_puntualidad_area_id } = row.subProcesoArea;
    if (value === 'COMPLETADO') {
        return `<button type="button" class="btn btn-outline-success btn-icon"
                    onclick="descargarReporte(${premio_puntualidad_area_id})">
                    <i class="fas fa-file-excel"></i>
                </button>`
    } else {
        return ``;
    }
}

function rechazarFormatter(value, row) {
    let { instancia_tarea_id } = row;
    let { premio_puntualidad_area_id } = row.subProcesoArea;
    if (value === 'COMPLETADO') {
        return `<button type="button" class="btn btn-outline-danger btn-icon"
                    onclick="abrirModalRechazo(${instancia_tarea_id}, ${premio_puntualidad_area_id})">
                    <i class="fas fa-window-close"></i>
                </button>`;
    } else {
        return ``;
    }
}

// Individual
function descargarReporte(id) {

    KTApp.blockPage({
        overlayColor: '#000000',
        state: 'danger',
        message: 'Por favor, espere...'
    });
    $.ajax({
        type: 'GET',
        url: urlReporteArea+'/'+id,
        xhrFields: {
            responseType: 'blob' // Configura la respuesta como un objeto Blob
        },
        success: function(response) {
            let link = document.createElement('a');
            let url = window.URL.createObjectURL(response);
            link.href = url;
            link.download = 'premio-puntualidad-asistencia.xlsx';
            link.click();
            window.URL.revokeObjectURL(url);
            Swal.fire({
                text: '¡Descarga exitosa!',
                icon: 'success',
                confirmButtonColor: '#0BB7AF',
                confirmButtonText: 'Ok'
            })
        },
        error: function(jqXHR, textStatus, errorThrown) {
            Swal.fire({
                html: '¡Error, intente más tarde o comuniquese con el área correspondiente!',
                icon: 'warning',
                confirmButtonColor: '#0BB7AF',
                confirmButtonText: 'Ok'
            });
        },
        complete : function(xhr, status) {
            KTApp.unblockPage();
        }
    });
}

function abrirModalRechazo(instancia_tarea_id, premio_puntualidad_area_id){
    $("#modal_rechazo").modal("show");
    $("#instancia_tarea_id").val(instancia_tarea_id);
    $("#premio_puntualidad_area_id").val(premio_puntualidad_area_id);
}

const formRechazarTarea = $("#form_rechazar_tarea");
const btnRechazarTarea = $("#rechazar_tarea");

btnRechazarTarea.click(function(e) {
    if ( $("#form_rechazar_tarea").valid() ) {
        swal.fire({
            title: "¿Está seguro de rechazar esta tarea?",
            text: "No podrá revertir el cambio",
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
                formRechazarTarea.submit();
            }
        });
    }
});

$('#modal_rechazo').on('hide.bs.modal', function (e) {
    $("#form_rechazar_tarea")[0].reset();
})

const btnFinalizarTarea = $("#finalizarTarea");
const formFinalizarTarea = $("#form_finalizar_tarea");

btnFinalizarTarea.click(function(e) {

    swal.fire({
        title: "¿Está seguro de finalizar el subproceso?",
        text: "Antes de continuar, verifique que los datos ingresados sean correctos. Después de finalizar la tarea, no podrá regresar.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, continuar",
        cancelButtonText: "Cancelar",
        reverseButtons: true,
        allowOutsideClick: false,
    }).then((result) => {
        if (result.value) {
            $('#avance_subareas').val(JSON.stringify(subAreas));
            KTApp.blockPage({
                overlayColor: '#000000',
                state: 'danger',
                message: 'Por favor, espere...'
            });
            formFinalizarTarea.submit();
        }
    });

});
