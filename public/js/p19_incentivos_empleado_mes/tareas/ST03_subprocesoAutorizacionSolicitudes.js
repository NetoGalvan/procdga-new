const formSubprocesoAutorizacionSolicitudes  = $("#form_subproceso_autorizacion_solicitudes");
const tablaSubprocesoAutorizacionSolicitudes = $('#tabla_subproceso_autorizacion_solicitudes');
const btnContinuarProceso   = $('#btn_continuar_proceso');

// Cargar data
$(document).ready(function () {
    // Se valida si existen se carga en la tabla
    if ( subAreas.length > 0 ){
        tablaSubprocesoAutorizacionSolicitudes.bootstrapTable("destroy");
        tablaSubprocesoAutorizacionSolicitudes.bootstrapTable({data: subAreas});
    } else {
        tablaSubprocesoAutorizacionSolicitudes.bootstrapTable();
    }

});

// Formatters de la tabla
function estadoFormatter(value, row){
    if ( value == 'COMPLETADO' ) {
        return `<span class="badge badge-success">COMPLETADO</span>`;
    } else {
        return `<span class="badge badge-warning">PENDIENTE</span>`;
    }
}
function finalizoFormatter(value, row){
    if ( value == 'COMPLETADO' ) {
        return `<i class="flaticon2-check-mark text-success"></i>`;
    } else {
        return `<i class="flaticon2-cross text-danger"></i>`;
    }
}

// Evento que permite Continuar y Finalizar con la ST03
btnContinuarProceso.click(function (e) {
    e.preventDefault();

    // Validamos que los datos de las Sub áreas que este en la tabla esten FINALIZADOS
    let validado = validarSubareasTareasFinalizadas();

    if ( validado ) {

        Swal.fire({
            title: 'Continuar',
            text: "¿Esta seguro(a) de continuar con este proceso?",
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
                formSubprocesoAutorizacionSolicitudes.submit();
            }
        })
    } else {
        Swal.fire({
            title: 'Continuar',
            html: "<p>Todas aquellas Sub Áreas <br> cuyo estado sea <b>''PENDIENTE'', NO </b> se les tomará<br> en cuenta los premios que hayan solicitado<br> ¿Aún así deseas continuar? </p>",
            icon: 'warning',
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
                formSubprocesoAutorizacionSolicitudes.submit();
            }
        })
    }

});

// Evento que valida los datos de las Sub Areas que aparezcan su ST02 como finalizada
function validarSubareasTareasFinalizadas() {
    let arregloSubAreasTarea = tablaSubprocesoAutorizacionSolicitudes.bootstrapTable('getData');
    // Adicional lo agregamos en un campo input para su envío al Back
    $('#arreglo_sub_areas_tareas').val(JSON.stringify(arregloSubAreasTarea));

    let pendientes = 0;
    arregloSubAreasTarea.forEach(subproceso => {
        if ( subproceso.estatus == 'PENDIENTE' ) {
            pendientes ++;
        }

    });

    // Si existe algun Subproceso pendientes se notifica
    return pendientes > 0 ? false : true ;
}
