// Click en el boton de Finalizar
const tablaSubprocesos = $("#tabla_subproceso");
const btnFinalizarTarea = $("#btn_finalizar");
const formFinalizarTarea = $("#form_concentrado_solicitudes");

$(document).ready(function () {
    // Inicializa la tabla
    if ( subprocesos.length > 0 ){
        tablaSubprocesos.bootstrapTable("destroy");
        tablaSubprocesos.bootstrapTable({data: subprocesos});
    } else {
        tablaSubprocesos.bootstrapTable();
    }
});

function areasFormatter(value, row) {
    let { identificador, nombre} = row.area;
    return `${identificador} - ${nombre}`;
}

function estatusFormatter(value, row) {
    if (value == "EN_PROCESO") {
        return `<span class="badge badge-primary" style="white-space:nowrap;"> EN PROCESO </span>`;
    } else if (value == "EN_CORRECCION") {
        return `<span class="badge badge-warning" style="white-space:nowrap;"> CORRECCIÓN </span>`;
    } else if (value == "COMPLETADO") {
        return `<span class="badge badge-success" style="white-space:nowrap;"> ${value} </span>`;
    } else if (value == "RECHAZADO") {
        return `<span class="badge badge-danger" style="white-space:nowrap;"> RECHAZADO </span>`;
    } else if (value == 'CANCELADO') {
		return `<span class="badge badge-danger" style="white-space:nowrap;"> CANCELADO </span>`;
	} else {
        return `<span class="badge badge-warning" style="white-space:nowrap;"> PENDIENTE </span>`;
    }
}

function reporteFormatter(value, row) {
    let { folio } = row;
    if (value === 'COMPLETADO') {
        return `<button type="button" class="btn btn-sm btn-outline-success btn-icon"
                    onclick="descargarReporte('${folio}')">
                    <i class="fas fa-file-excel"></i>
                </button>`
    } else {
        return ``;
    }
}

// Individual
function descargarReporte(folio) {

    KTApp.blockPage({
        overlayColor: '#000000',
        state: 'danger',
        message: 'Por favor, espere...'
    });
    $.ajax({
        type: 'GET',
        url: urlReporteArea+'/'+folio,
        xhrFields: {
            responseType: 'blob' // Configura la respuesta como un objeto Blob
        },
        success: function(response) {
            let link = document.createElement('a');
            let url = window.URL.createObjectURL(response);
            link.href = url;
            link.download = 'pago_tiempo_extra_area.xlsx';
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


btnFinalizarTarea.click(function(e) {

    swal.fire({
        title: "¿Está seguro de finalizar?",
        text: "Antes de continuar, verifique que los datos ingresados sean correctos. Después de finalizar la tarea, no podrá regresar.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, continuar",
        cancelButtonText: "Cancelar",
        reverseButtons: true,
        allowOutsideClick: false,
    }).then((result) => {
        if (result.value) {
            $('#avance_subprocesos').val(JSON.stringify(subprocesos));
            KTApp.blockPage({
                overlayColor: '#000000',
                state: 'danger',
                message: 'Por favor, espere...'
            });
            formFinalizarTarea.submit();
        }
    });

});
