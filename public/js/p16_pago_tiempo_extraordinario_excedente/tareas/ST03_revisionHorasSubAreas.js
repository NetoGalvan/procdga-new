const tableSubprocesos = $("#table_tareas_activas");

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
    if ( subareas.length > 0 ){
        tableSubprocesos.bootstrapTable("destroy");
        tableSubprocesos.bootstrapTable({data: subareas});
    } else {
        tableSubprocesos.bootstrapTable();
    }
});

function areaFormatter(value, row) {
    let { identificador, nombre, nombre_empleado } = value;
    return `${identificador} - ${nombre}`;
}

function estatusFormatter(value, row) {
    if (value === 'NUEVO' ) {
        return `<span class="user-select-none label label-inline label-md font-weight-bold label-rounded label-primary">EN PROCESO</span>`;
    } else if (value === 'EN_CORRECCION') {
        return `<span class="user-select-none label label-inline label-md font-weight-bold label-rounded label-info">EN CORRECCIÓN</span>`;
    } else if (value === 'COMPLETADO') {
        return `<span class="user-select-none label label-inline label-md font-weight-bold label-rounded label-success">${value}</span>`;
    }
}

function reporteFormatter(value, row) {
    let { p16_presupuesto_quincenal_subareas_id } = row;
    if (value === 'COMPLETADO') {
        return `<button type="button" class="btn btn-sm btn-success btn-icon"
                    onclick="descargarReporte(${p16_presupuesto_quincenal_subareas_id})">
                    <i class="fas fa-file-excel"></i>
                </button>`
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
        url: urlDescargarReporteIndividualSubareas+'/'+id,
        xhrFields: {
            responseType: 'blob' // Configura la respuesta como un objeto Blob
        },
        success: function(response) {
            let link = document.createElement('a');
            let url = window.URL.createObjectURL(response);
            link.href = url;
            link.download = 'pago_tiempo_extra_subareas.xlsx';
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

function rechazarFormatter(value, row) {
    let { instancia_tarea_id, p16_presupuesto_quincenal_subareas_id } = row;
    if (value === 'COMPLETADO') {
        return `<button type="button" class="btn btn-sm btn-danger btn-icon"
                    onclick="abrirModalRechazo(${instancia_tarea_id}, ${p16_presupuesto_quincenal_subareas_id})">
                    <i class="fas fa-window-close"></i>
                </button>`;
    } else {
        return ``;
    }
}

// Para descargar el reporte general
const btnDescargarReporteGeneral = $("#reporte_general");

btnDescargarReporteGeneral.click(function (e) {
    e.preventDefault();

    KTApp.blockPage({
        overlayColor: '#000000',
        state: 'danger',
        message: 'Por favor, espere...'
    });

    ajaxDescargarReporteGeneral(subareas_general).done(function(respuesta, xhr, response) {
        KTApp.unblockPage();
        Swal.fire({
            text: '¡Reporte descargado exitosamente!',
            icon: 'success',
            confirmButtonColor: '#0BB7AF',
            confirmButtonText: 'Ok'
        })
        var a = document.createElement('a');
        var url = window.URL.createObjectURL(respuesta);
        var nombre = response.getResponseHeader('Content-Disposition').split('filename=')[1];
        nombre = nombre.replace(/['"]+/g, '');

        a.href = url;
        a.download = nombre;
        document.body.append(a);
        a.click();
        a.remove();
        window.URL.revokeObjectURL(url);
    });

});

function ajaxDescargarReporteGeneral(subareas_general) {
    return $.ajax({
        url: urlDescargarReporteGeneralSubareas,
        type: 'GET',
        data: {subareas_general},
        async: true,
        xhrFields: {
            responseType: 'blob'
        },
    });
}

function abrirModalRechazo(instancia_tarea_id, subarea_id){
    $("#modal_rechazo").modal("show");
    $("#instancia_tarea_id").val(instancia_tarea_id);
    $("#subarea_id").val(subarea_id);
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
const formCancelarTarea = $("#form_cancelar_tarea");


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
            $('#avance_subareas').val(JSON.stringify(subareas));
            KTApp.blockPage({
                overlayColor: '#000000',
                state: 'danger',
                message: 'Por favor, espere...'
            });
            formFinalizarTarea.submit();
        }
    });

});
