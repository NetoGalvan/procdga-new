const tablaRoles = $("#tabla_roles")

tablaRoles.bootstrapTable({
    data: roles
})

function accionesFormatter(val, row) {
    return `
        <a href="${row.ruta_editar}" class="btn btn-outline-primary btn-icon editar" data-toggle="tooltip" title="" data-original-title="Editar">
            <i class="fas fa-edit"></i>
        </a>
    `;
}

function nameFormatter(val, row) {
    return `
        <p class='badge badge-secondary mb-0'>${val}</p>
    `;
}

function labelFormatter(val, row) {
    return `
        <p class='badge badge-success mb-0'>${val}</p>
    `;
}