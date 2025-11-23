formFinalizarTarea = $("#form_finalizar_tarea");

const validatorFormFinalizarTarea = formFinalizarTarea.validate({
    submitHandler: function(form) {
        let opcionSeleccionada = tablaTramitesIncidencias.bootstrapTable('getSelections');
        if (opcionSeleccionada.length == 0) {
            Swal.fire("Debe seleccionar un folio antes de continuar", "", "error");
            return;
        }
        $("[name=tramite_incidencia]").val(JSON.stringify(opcionSeleccionada[0]));
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

// INICIA CONFIGURACIÓN TRAMITES INCIDENCIAS EMPLEADO
const tablaTramitesIncidencias = $("#tabla_tramites_incidencias");

function tipoCapturaFormatter(value, row) {
    let tipoCaptura = `<div class="text-nowrap">`;
    if (value === "alta") {
        tipoCaptura += `<span class="badge badge-primary">ALTA<span>`;
    } else if (value === "alta_nb") {
        tipoCaptura += `<span class="badge badge-success">ALTA NB<span>`;
    }
    tipoCaptura += `</div">`;
    return tipoCaptura;
}

function tipoTramiteFormatter(value, row) {
    return value.replace(/_/g, " ");
}

function accionesFormatter(value, row) {
    return `<a class="btn btn-outline-primary btn-icon ver-detalle" data-toggle="tooltip" title="Ver detalle">       
        <i class="fas fa-eye"></i>
    </a>`
}

var accionesEvents = {
    'click .ver-detalle': function (e, value, row, index) {
        e.stopPropagation();
        $("#tabla_incidencias_empleado").bootstrapTable('load', row.incidencias_empleado);
        $("#modal_detalle_tramite_incidencia").modal("show"); 
    }
}

tablaTramitesIncidencias.on('click-row.bs.table', function (e, row, $element) {
    tablaTramitesIncidencias.bootstrapTable("checkBy", {field: "folio", values: [row.folio]})
});

tablaTramitesIncidencias.bootstrapTable({data: tramitesIncidencias});
// FINALIZA CONFIGURACIÓN INCIDENCIAS EMPLEADO