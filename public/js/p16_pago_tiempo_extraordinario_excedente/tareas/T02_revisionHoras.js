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
    if ( subInstancias.length > 0 ){
        tableSubprocesos.bootstrapTable("destroy");
        tableSubprocesos.bootstrapTable({data: subInstancias});
    } else {
        tableSubprocesos.bootstrapTable();
    }
});

function areaFormatter(value, row) {
    let { identificador, nombre } = value;
    return `${identificador} - ${nombre}`;
}

function estatusFormatter(value, row) {
    if (value === 'EN_PROCESO' ) {
        return `<span class="user-select-none label label-inline label-md font-weight-bold label-rounded label-primary">EN PROCESO</span>`;
    } else if (value === 'COMPLETADO') {
        return `<span class="user-select-none label label-inline label-md font-weight-bold label-rounded label-success">${value}</span>`;
    } else if (value === 'CANCELADO') {
        return `<span class="user-select-none label label-inline label-md font-weight-bold label-rounded label-danger">CANCELADO</span>`;
    }
}

function reporteFormatter(value, row) {
    let { folio } = row;
    if (value === 'COMPLETADO') {
        return `<button type="button" class="btn btn-sm btn-success btn-icon"
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
        url: urlDescargarReporteIndividual+'/'+folio,
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

// Para descargar el reporte general
const btnDescargarReporteGeneral = $("#reporte_general");

btnDescargarReporteGeneral.click(function (e) {
    e.preventDefault();

    KTApp.blockPage({
        overlayColor: '#000000',
        state: 'danger',
        message: 'Por favor, espere...'
    });

    ajaxDescargarReporteGeneral(folios).done(function(respuesta, xhr, response) {
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

function ajaxDescargarReporteGeneral(folios) {
    return $.ajax({
        url: urlDescargarReporteGeneral,
        type: 'GET',
        data: {folios},
        async: true,
        xhrFields: {
            responseType: 'blob'
        },
    });
}

const btnFinalizarProceso = $("#btn_terminar_proceso");
const formFinalizarProceso = $("#form_finalizar_proceso");

btnFinalizarProceso.click(function(e) {
    swal.fire({
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
            formFinalizarProceso.submit();
        }
    });
});
