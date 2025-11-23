const tablaAsistencias = $("#tabla_asistencias");

tablaAsistencias.bootstrapTable({data: asistencias});

function estatusFormatter(value, row) {
    if (value == 'EN_PROCESO') {
        return `<span class="badge badge-primary"><i class="fas fa-spinner icon-nm text-white mr-1"></i> EN PROCESO </span>`;
    } else if (value == 'COMPLETADO') {
        return `<span class="badge badge-success"><i class="far fa-check-circle icon-nm text-white mr-1"></i> COMPLETADO </span>`;
	} else {
		return `<span class="badge badge-warning"><i class="far fa-times-circle icon-nm text-secondary mr-1"></i> PENDIENTE </span>`;
	}
}