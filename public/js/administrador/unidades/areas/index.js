const tablaRegistros = $("#tabla_registros");
tablaRegistros.bootstrapTable({data: registros});

function activoFormatter(value, row) {
    if (value) {
        return `<span class="badge badge-success"> ACTIVO </span>`;
    } else {
		return `<span class="badge badge-danger"> INACTIVO </span>`;
	}
}

function accionesFormatter(value, row, index) {
    return row.ruta_editar ? `<a type="button" 
        class="btn btn-outline-primary btn-icon" 
        href="${row.ruta_editar}" 
        data-toggle="tooltip" 
        data-placement="top" 
        title="Editar">
        <i class="fas fa-edit"></i>
    </a>` : `<span class="badge badge-secondary"> N/A </span>`;
}
