const tablaAreas = $("#tabla_areas");

tablaAreas.bootstrapTable({
    pageNumber : 1,
    pageSize : 20,
    queryParamsType : '',
    formatSearch: function () {
        return "Buscar ..."
    }
});

function getAreas(params) {
    $.get(urlGetAreas + '?' + $.param(params.data)).then(function (res) {
        params.success(res);
    })
}

function queryParams(params) {
    params.page = params.pageNumber;
    return params;
}

function nombreFormatter(val, row) {
    return `${row.identificador} ${row.nombre}`;
}

function accionesFormatter(val, row) {
    return `
        <a href="${row.ruta_editar}" class="btn btn-outline-primary btn-icon editar" data-toggle="tooltip" title="" data-original-title="Editar">
            <i class="fas fa-edit"></i>
        </a>
    `;
}