const tablaUsuarios = $("#tabla_usuarios");

tablaUsuarios.bootstrapTable({
    pageNumber : 1,
    pageSize : 20,
    queryParamsType : '',
    formatSearch: function () {
        return "Buscar ..."
    }
});

function getUsuarios(params) {
    $.get(urlGetUsuarios + '?' + $.param(params.data)).then(function (res) {
        params.success(res);
    })
}

function queryParams(params) {
    params.page = params.pageNumber;
    return params;
}

/* function customSearch(data, text) {
    return data.filter(function (row) {
        return row.nombre_completo.toLowerCase().indexOf(text) > -1 || row.nombre_usuario.toLowerCase().indexOf(text) > -1 || row.email.toLowerCase().indexOf(text) > -1
    })
} */

function activoFormatter(value, row) {
    return value ? "<p class='badge badge-success mb-0'> Activo </p>" : "<p class='badge badge-danger'> Inactivo </p>"
}

function rolesFormatter(value, row) {
    let roles = ``;
    value.forEach(rol => {
        roles += `<span class='badge badge-secondary mb-2 mr-2'> ${rol.name} </span>`;
    });

    return roles
}

function areaFormatter(value, row) {
    return `${row.area.identificador} - ${row.area.nombre}`;
}

function accionesFormatter(value, row) {
    return `<a href="${row.ruta_editar}" class="btn btn-outline-primary btn-icon" data-toggle="tooltip" title="Editar usuario">
        <i class="far fa-edit"></i>
    </a>`
}