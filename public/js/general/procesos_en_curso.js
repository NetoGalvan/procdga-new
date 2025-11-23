const tablaProcesosEnCurso = $('#tabla_procesos_en_curso');
tablaProcesosEnCurso.bootstrapTable({
    pageNumber : 1,
    pageSize : 10,
    queryParamsType : '',
    formatSearch: function () {
        return "Buscar ..."
    }
});
function getProcesosEnCurso(params) {
    $.get(urlGetProcesosEnCurso + '?' + $.param(params.data)).then(function (res) {
        params.success(res);
    })
}
function queryParams(params) {
    params.page = params.pageNumber;
    return params;
}
function fechaInstanciaFormatter(value, row) {
    fecha = moment(value)
    return fecha.format("DD-MM-Y H:mm:ss");
}
function tipoProcesoFormatter(value, row) {
    return `<span class="badge badge-primary text-uppercase"> ${value} </span>`;
}
function estatusInstanciaFormatter(value, row) {
    if (value == 'EN_PROCESO') {
        return `<span class="badge badge-primary"><i class="fas fa-spinner icon-nm text-white mr-1"></i> EN PROCESO </span>`;
    } else if (value == 'EN_PAUSA') {
        return `<span class="badge badge-default"><i class="far fa-check-circle icon-nm text-white mr-1"></i> EN PAUSA </span>`;
	} else if (value == 'COMPLETADO') {
        return `<span class="badge badge-success"><i class="far fa-check-circle icon-nm text-white mr-1"></i> COMPLETADO </span>`;
	} else if (value == 'RECHAZADO') {
		return `<span class="badge badge-danger"><i class="far fa-times-circle icon-nm text-white mr-1"></i> RECHAZADO </span>`;
	} else if (value == 'CANCELADO') {
		return `<span class="badge badge-warning"><i class="far fa-times-circle icon-nm text-secondary mr-1"></i> CANCELADO </span>`;
	} else {
        return `<span class="badge badge-secondary"><i class="far fa-times-circle icon-nm text-secondary mr-1"></i> ${value.replace(/_/g, " ")} </span>`;
    }
}
function nombreProcesoFormatter(value, row) {
    if (row.instancia.model["tipo_tramite"] != undefined) {
        return row.instancia.model.tipo_tramite.replace(/_/g, " ");
    }
    return value;
}
function acccionesFormatterProcesosEnCurso(value, row) {
    let botones =  `<button
        type="button"
        class="btn btn-sm btn-outline-success btn-icon"
        data-toggle="tooltip"
        title="Ver avance"
        onClick="verAvanceDeProceso(${row.instancia.instancia_id})">
        <i class="far fa-eye"></i>
    </button>`;
    return botones;
}

const modalProcesoEnCurso = $('#modal_proceso_en_curso');
const tablaAvanceTareas = $("#tabla_avance_tareas");

function verAvanceDeProceso( instanciaId ) {
    $.ajax({
        type: "GET",
        url: urlAvanceDelProceso+'/'+instanciaId,
        success: function (tareas) {
            tablaAvanceTareas.bootstrapTable("load", tareas);
            modalProcesoEnCurso.modal('show');
        }
    });
}

function fechaFormatter(value, row) {
    fecha = moment(value);
    return `<span style="white-space: nowrap;">${fecha.format('DD-MM-Y')} ${fecha.format('H:mm:ss')}</span>`;
}
function creadoPorUsuarioFormatter(value, row) {
    return `${value.nombre_completo}`;
}
function creadoPorAreaFormatter(value, row) {
    return `${value.identificador} - ${value.nombre}`;
}
function autorizadoPorUsuarioFormatter(value, row) {
    return value ? `${value.nombre_completo}` : "-";
}
function autorizadoPorAreaFormatter(value, row) {
    return value ? `${value.identificador} - ${value.nombre}` : "-";
}
function estatusFormatter(value, row) {
    if (value == "NUEVO") {
        return `<span class="badge badge-primary" style="white-space:nowrap;"><i class="far fa-star icon-nm text-white mr-1"></i> NUEVO </span>`;
    } else if (value == "EN_CORRECCION") {
        return `<span class="badge badge-info" style="white-space:nowrap;"><i class="fas fa-sync-alt icon-nm text-white mr-1"></i> CORRECCIÓN </span>`;
    } else if (value == "COMPLETADO") {
        return `<span class="badge badge-success" style="white-space:nowrap;"><i class="far fa-check-circle icon-nm text-white mr-1"></i>${value}</span>`;
    } else if (value == "RECHAZADO") {
        return `<span class="badge badge-danger" style="white-space:nowrap;"><i class="fas fa-times icon-nm text-white mr-1"></i> RECHAZADO </span>`;
    } else if (value == 'CANCELADO') {
		return `<span class="badge badge-warning" style="white-space:nowrap;"><i class="far fa-times-circle icon-nm text-secondary mr-1"></i> CANCELADO </span>`;
	}
    return estatus;
}