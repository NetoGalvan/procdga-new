const tableTramites = $('#table_tramites');

$(document).ready(function () {
    if ( tramitesKardex.length > 0 ){
        tableTramites.bootstrapTable("destroy");
        tableTramites.bootstrapTable({data: tramitesKardex});
    } else {
        tableTramites.bootstrapTable();
    }
});

function tipoTramiteFormatter(value, row) {
    if (row.tipo_tramite_kardex) {
        let { nombre } = row.tipo_tramite_kardex;
        return `<span class="badge badge-primary"> ${nombre.toUpperCase()} </span>`;
    } else {
        return `<span class="badge badge-primary"> PENDIENTE </span>`;
    }
}

function estatusFormatter(value, row) {
    if (value == 'EN_PROCESO') {
        return `<span class="badge badge-primary"><i class="fas fa-spinner icon-nm text-white mr-1"></i> EN PROCESO </span>`;
    } else if (value == 'COMPLETADO') {
        return `<span class="badge badge-success"><i class="far fa-check-circle icon-nm text-white mr-1"></i> COMPLETADO </span>`;
	} else {
		return `<span class="badge badge-warning"><i class="far fa-times-circle icon-nm text-secondary mr-1"></i> PENDIENTE </span>`;
	}
}

function asignadoAUsuarioFormatter(value, row) {
    if (row.asignado_a_usuario) {
        let { nombre_completo } = row.asignado_a_usuario;
        return `${nombre_completo.toUpperCase()}`;
    } else {
        return `PENDIENTE`;
    }
}

function accionesFormatter(value, row) {
    return '<div class="d-flex justify-content-center"> <button type="button" class="btn btn-outline-success btn-icon" onclick="verTramiteKardex('+row.tramite_kardex_id+')" data-toggle="tooltip" data-placement="top" title="Ver Trámite" > <i class="fas fa-eye"></i> </button> </div>'
}

function verTramiteKardex(id) {
    url = urlVerTramite.replace('idTramiteKardex', id);
    window.location.href = url;
}

