const tablaBiometricos = $("#tabla_biometricos");

function ipFormatter(v) {
    return v ? v : `<span class="badge badge-secondary">N/A</span>`;
}

function accesoFormatter(v) {
    return v ? v : `<span class="badge badge-secondary">N/A</span>`;
}

function ubicacionFormatter(v) {
    return v ? v : `<span class="badge badge-secondary">N/A</span>`;
}

function accionesFormatter(value, row) {
    return `<a href="${row.ruta_edit}" class="btn btn-outline-primary btn-icon">
        <i class="fas fa-edit"></i>
    </a>`;
}  

tablaBiometricos.bootstrapTable({data: biometricos});