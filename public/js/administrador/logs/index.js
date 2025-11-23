const tablaLogs = $("#tabla_logs");

tablaLogs.bootstrapTable({
    pageNumber : 1,
    pageSize : 20,
    queryParamsType : '',
});

function getLogs(params) {
    $.get(urlGetLogs + '?' + $.param(params.data)).then(function (res) {
        params.success(res);
    })
}

function queryParams(params) {
    params.page = params.pageNumber;
    return params;
}

function fechaFormatter(value, row) {
    fecha = moment(value);
    return `<span style="white-space: nowrap;">${fecha.format('DD-MM-Y')} ${fecha.format('H:mm:ss')}</span>`;
}

function tipoFormatter(value, row, index) {
    switch(value) {
        case 'ERROR':
            return '<span class="badge badge-danger">ERROR</span>'; 
        case 'INFO':
            return '<span class="badge badge-info">INFO</span>'; 
        case 'WARNING':
            return '<span class="badge badge-warning">WARNING</span>'; 
        default:
            return value;
    }
}

function datosExtraFormatter(value, row) {
    if (value) {
        let datosExtra = JSON.parse(value);
        let valores = "";
        for (var campo in datosExtra) {
            valores += `<strong>${campo}:</strong> ${datosExtra[campo]} `;
        }

        return valores;
    }

    return `<span class="badge badge-secondary">N/A</span>`;
}

function usuarioFormatter(value, row) {
    return `<strong>ID:</strong> ${row.usuario.id} <br> 
        <strong>Nombre:</strong> ${row.usuario.nombre_completo} <br>
        <strong>RFC:</strong> ${row.usuario.rfc} <br>
        <strong>Área:</strong> ${row.usuario.area.nombre}`;
}