const tablaTareas = $("#tabla_tareas");

tablaTareas.bootstrapTable({
    pageNumber : 1,
    pageSize : 10,
    queryParamsType : '',
    formatSearch: function () {
        return "Buscar ..."
    }
});

function getTareas(params) {
    $.get(urlGetTareas + '?' + $.param(params.data)).then(function (res) {
        params.success(res);
    })
}

function queryParams(params) {
    params.page = params.pageNumber;
    return params;
}

tablaTareas.on('click-row.bs.table', function(e, row, $element) {
	window.location.href = row.ruta_tarea;
});

function nombreProcesoFormatter(value, row) {
    if (row.instancia.model["tipo_tramite"] != undefined) {
        return row.instancia.model.tipo_tramite.replace(/_/g, " ");
    }
    return value;
}

function estatusFormmatter (value, row, index, field) {
	if (value == 'NUEVO') {
		return `<span class="badge badge-primary" style="white-space:nowrap;"><i class="far fa-star icon-nm text-white mr-1"></i> NUEVO </span>`;
	} else if (value == 'EN_CORRECCION') {
		return `<span class="badge badge-info" style="white-space:nowrap;"><i class="fas fa-sync-alt icon-nm text-white mr-1"></i> CORRECCIÓN </span>`;
	} else if (value == 'NOTIFICACION_NO_LEIDO') {
		return `<span class="badge badge-success" style="white-space:nowrap;"><i class="far fa-star icon-nm text-white mr-1"></i> NO LEÍDO </span>`;
	} else if (value == 'NOTIFICACION_LEIDO') {
		return `<span class="badge badge-warning" style="white-space:nowrap;"><i class="fas fa-check icon-nm text-white mr-1"></i> LEÍDO </span>`;
	}
	return `${value}`;
}
function creadoPorUsuarioFormatter(value, row) {
    return `${value.nombre_completo}`;
}
function creadoPorAreaFormatter(value, row) {
    return `${value.identificador} - ${value.nombre}`;
}
function fechaFormatter(value, row) {
	return moment(value).locale('es-mx').fromNow();
}
