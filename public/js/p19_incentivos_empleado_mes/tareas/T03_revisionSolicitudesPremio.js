const formRevisionSolicitudesPremio  = $("#form_revision_solicitudes_premio");
const tablaRevisionSolicitudesPremio = $('#tabla_revision_solicitudes_premio');
const btnContinuarProceso            = $('#btn_continuar_proceso');
const inputPremiosAsignados          = $('#premios_asignados_total');

// Cargar data
$(document).ready(function () {
    // Se valida si existen se carga en la tabla
    if ( subprocesos.length > 0 ){
        tablaRevisionSolicitudesPremio.bootstrapTable("destroy");
        tablaRevisionSolicitudesPremio.bootstrapTable({data: subprocesos});
    } else {
        tablaRevisionSolicitudesPremio.bootstrapTable();
    }

});


// Formatters de la tabla
function premiosAplicadosFormatter(value, row){
    return `${value}`;
}
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

// Evento que permite Continuar y Finalizar con la T03
btnContinuarProceso.click(function (e) {
    e.preventDefault();

    // Validamos que los datos del Subproceso que este en la tabla esten FINALIZADOS
    let validado = validarSubprocesosFinalizados();

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
                formRevisionSolicitudesPremio.submit();
            }
        })
    } else {
        Swal.fire({
            title: 'Continuar',
            html: "<p>Todas aquellas Unidades Adminsitrativas <br> cuyo estado sea <b>''PENDIENTE'', NO </b> se les tomará<br> en cuenta los premios que hayan solicitado<br> ¿Aún así deseas continuar? </p>",
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
                formRevisionSolicitudesPremio.submit();
            }
        })
    }

});

// Evento que valida los datos del Subproceso que este en la tabla esten FINALIZADOS
function validarSubprocesosFinalizados() {
    let arregloSubprocesos = tablaRevisionSolicitudesPremio.bootstrapTable('getData');
    // Adicional lo agregamos en un campo input para su envío al Back
    $('#arreglo_subprocesos').val(JSON.stringify(arregloSubprocesos));

    let pendientes = 0;
    arregloSubprocesos.forEach(subproceso => {
        if ( subproceso.estatus == 'EN_PROCESO' ) {
            pendientes ++;
        }

    });

    // Si existe algun Subproceso pendientes se notifica
    return pendientes > 0 ? false : true ;
}
