const tablaSubprocesos = $("#tabla_subproceso");

$(document).ready(function () {
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

// Descargar PDF
const btnDescargarRelacion = $("#descargar_relacion");

btnDescargarRelacion.click(function (e) {
    e.preventDefault();
    Swal.fire({
        title: '¿Descargar relación de empleados?',
        icon: 'question',
        showCancelButton: true,
        cancelButtonColor: '#F64E60',
        cancelButtonText: 'No',
        confirmButtonColor: '#0BB7AF',
        confirmButtonText: 'Si'
    }).then((result) => {
        if (result.isConfirmed) {
            KTApp.blockPage({
                overlayColor: '#000000',
                state: 'danger',
                message: 'Por favor, espere...'
            });

            ajaxDescargarRelacion(premioPuntualidad.premio_puntualidad_id).done(function(respuesta, xhr, response) {

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

                KTApp.unblockPage();
                Swal.fire("Relación de empleados descargado correctamente", "", "success");

            });
        }
    });
});

function ajaxDescargarRelacion(premio) {
    return $.ajax({
        url: urlDescargarRelacionEmpleados,
        type: 'GET',
        data: {premio},
        async: true,
        xhrFields: {
            responseType: 'blob'
        },
    });
}

// Descargar CON nombres
const btnDescargarConNombres = $("#descargar_con_nombres");

btnDescargarConNombres.click(function (e) {
    e.preventDefault();
    Swal.fire({
        title: '¿Descargar layout con nombres?',
        icon: 'question',
        showCancelButton: true,
        cancelButtonColor: '#F64E60',
        cancelButtonText: 'No',
        confirmButtonColor: '#0BB7AF',
        confirmButtonText: 'Si'
    }).then((result) => {
        if (result.isConfirmed) {
            KTApp.blockPage({
                overlayColor: '#000000',
                state: 'danger',
                message: 'Por favor, espere...'
            });

            ajaxDescargarConNombres(premioPuntualidad.premio_puntualidad_id).done(function(respuesta, xhr, response) {

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

                KTApp.unblockPage();
                Swal.fire("Layout descargado correctamente", "", "success");

            });
        }
    });
});

function ajaxDescargarConNombres(premio) {
    return $.ajax({
        url: urlDescargarLayoutConNombres,
        type: 'GET',
        data: {premio},
        async: true,
        xhrFields: {
            responseType: 'blob'
        },
    });
}

// Descargar SIN nombres
const btnDescargarSinNombres = $("#descargar_sin_nombres");

btnDescargarSinNombres.click(function (e) {
    e.preventDefault();
    Swal.fire({
        title: '¿Descargar layout sin nombres?',
        icon: 'question',
        showCancelButton: true,
        cancelButtonColor: '#F64E60',
        cancelButtonText: 'No',
        confirmButtonColor: '#0BB7AF',
        confirmButtonText: 'Si'
    }).then((result) => {
        if (result.isConfirmed) {
            KTApp.blockPage({
                overlayColor: '#000000',
                state: 'danger',
                message: 'Por favor, espere...'
            });

            ajaxDescargarSinNombres(premioPuntualidad.premio_puntualidad_id).done(function(respuesta, xhr, response) {

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

                KTApp.unblockPage();
                Swal.fire("Layout descargado correctamente", "", "success");
            });
        }
    });
});

function ajaxDescargarSinNombres(premio) {
    return $.ajax({
        url: urlDescargarLayoutSinNombres,
        type: 'GET',
        data: {premio},
        async: true,
        xhrFields: {
            responseType: 'blob'
        },
    });
}

// Click en el boton de Finalizar
const btnFinalizarTarea = $("#btn_finalizar");
const formFinalizarProceso = $('#form_generacion_archivos');

btnFinalizarTarea.click(function(e) {

    swal.fire({
        title: "¿Está seguro de finalizar?",
        text: "Antes de continuar, verifique que los datos ingresados sean correctos. Después de finalizar el proceso, no podrá regresar.",
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
            formFinalizarProceso.submit();
        }
    });

});

const btnCancelarProceso = $("#btn_cancelar_proceso");

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
            $("#form_generacion_archivos").append(`<input type="hidden" name="accion" value="cancelar">`);
            $("#form_generacion_archivos")[0].submit();
        }
    });
});
