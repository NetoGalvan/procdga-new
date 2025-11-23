//Variables
var formRevCentEmpleados = $('#form_rev_cent_empleados');
var btnAgregarEmpleado = $('.btn_agregar_empleado');
var btnFinalizarT02 = $('#btn_finalizar_TRDEL02');

//BEGIN::Agregar Empleado
// ------ Botón para agregar empleado
btnAgregarEmpleado.click( function(e) {
    e.preventDefault();

    $.post(URL_agregarEmpleado, formRevCentEmpleados.serialize() ).done(function(response){
        if ( response.estatus ) {
            $('#tabla_buscar_empleado').bootstrapTable("load", response.empleados_agregados);
        } else {
            alert_error(response.mensaje, null);
        }
        $('#datos_empleado').val('').trigger('change');
    });
});
// ------ Función principal : Mostrar empleados agregados
function showEmpleadosAgregados(params){
    $.post(URL_agregarEmpleado).done( function(response) {
        if ( response.estatus ) params.success(response.empleados_agregados);
    });
}
// ------ Funciones formatter para la tabla
function nombreCompletoFormatter(v, data) {
    return `${data.apellido_paterno} ${data.apellido_materno} ${data.nombre_empleado}`;
}

function eliminarFormatter(value, d) {
    return `<button class="btn btn-outline-danger btn-remover-empleado" data-reporte-detalle=${value}>
                <i class="fas fa-trash"></i>
            </button>`;
}
//END::Agregar Empleado

//BEGIN::Botones
$('#tabla_buscar_empleado').on('click', '.btn-remover-empleado', function(e) {
    e.preventDefault();

    var reporteDetalle = $(this).data('reporteDetalle');

    alert_warning_secondary('Remover al empleado del reporte', (result) => {
        if ( result.value ) {

            $.post(URL_removerEmpleado, {remover_empleado: true, reporte_detalle_id: reporteDetalle} )
             .done(function(response){
                if ( response.estatus ) 
                {
                    $('#tabla_buscar_empleado').bootstrapTable("load", response.empleados_agregados);
                    alert_success('El empleado ha sido removido correctamente', null);
                }
            });
        }
    });
});

btnFinalizarT02.click( function(e) {
    e.preventDefault();

    alert_warning_secondary('Finalizara con la tarea', (result) => {
        if ( result.value ) {
            KTApp.blockPage({
                overlayColor: '#000000',
                state: 'danger',
                message: 'Por favor, espere...'
            });
            formRevCentEmpleados.attr('action', URL_finalizarRevisionCentradoEmpleados);
            formRevCentEmpleados.submit();
        }
    });
});
//END::Botones