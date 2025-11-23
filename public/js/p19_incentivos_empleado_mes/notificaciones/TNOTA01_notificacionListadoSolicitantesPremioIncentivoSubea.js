const formNotificacion              = $('#form_notificacion');
const btnFinalizarNotificacion      = $('#btn_finalizar_notificacion');
const tablaListadoEmpleados         = $('#tabla_notificacion_listado_empleados');

btnFinalizarNotificacion.click(function() {
    Swal.fire({
        title: "Notificación",
        text: "¿Elimimar esta notificación?",
        icon: "question",
        showCancelButton: true,
        cancelButtonColor: '#F64E60',
        cancelButtonText: "Cancelar",
        confirmButtonText: "Sí, continuar",
        confirmButtonColor: '#0BB7AF',
        reverseButtons: true,
    }).then(function(result) {
        if (result.value) {
            KTApp.blockPage({
                overlayColor: '#000000',
                state: 'danger',
                message: 'Por favor, espere...'
            });
            formNotificacion.submit();
        }
    });
});

// Cargar data
$(document).ready(function () {
    // Se valida si existen se carga en la tabla
    if ( subProcesoNomina.nominas.length > 0 ){
        tablaListadoEmpleados.bootstrapTable("destroy");
        tablaListadoEmpleados.bootstrapTable({data: subProcesoNomina.nominas});
    } else {
        tablaListadoEmpleados.bootstrapTable();
    }

});

// Formatters de la tabla
function nombreEmpleadoFormatter(value, row) {
    let nombreEmpleado = `${row.nombre_empleado} ${row.apellido_paterno} ${row.apellido_materno} `;
    return nombreEmpleado;
}

function subAreaFormatter(value, row) {
    let identificadorSubArea = row.subarea_empleado?.identificador ? row.subarea_empleado.identificador : '';
    let nombreSubArea = row.subarea_empleado?.nombre ? row.subarea_empleado.nombre : '';
    return `${identificadorSubArea} - ${nombreSubArea}`;
}

function nivelSalarialFormatter(value, row) {
    let nivel = `${value ? value : '-'}`;
    return nivel;
}
