formFinalizarTarea = $("#form_finalizar_tarea");

const validatorFormFinalizarTarea = formFinalizarTarea.validate({
    submitHandler: function(form) {
        let opcionesSeleccionadas = tablaIncidenciasEmpleado.bootstrapTable('getSelections');
        if (opcionesSeleccionadas.length == 0) {
            Swal.fire("Antes de continuar, debe seleccionar al menos a un empleado.", "", "error");
            return;
        }
        
        $("[name=empleados_a_cancelar]").val(JSON.stringify(opcionesSeleccionadas));
        Swal.fire({
            title: "¿Está seguro?",
            text: "Antes de continuar, verifique que los datos ingresados sean correctos. Después de finalizar la tarea, no podrá regresar.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Sí, continuar",
            cancelButtonText: "Cancelar",
            reverseButtons: true
        }).then(function(result) {
            if (result.value) {
                KTApp.blockPage({
                    overlayColor: '#000000',
                    state: 'danger',
                    message: 'Por favor, espere...'
                });
                form.submit();
            }
        });
    }
});

// INICIA CONFIGURACION TABLA INCIDENCIAS EMPLEADO
const tablaIncidenciasEmpleado = $("#tabla_incidencias_empleado");
        
tablaIncidenciasEmpleado.on('click-row.bs.table', function (e, row, $element) {
    tablaIncidenciasEmpleado.bootstrapTable("checkBy", {field: "incidencia_empleado_id", values: [row.incidencia_empleado_id]})
});

tablaIncidenciasEmpleado.bootstrapTable({data: incidenciasEmpleado});

// FINALIZA CONFIGURACION TABLA INCIDENCIAS EMPLEADO