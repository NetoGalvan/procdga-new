const tablaTiposIncidencias = $('#tabla_tipos_incidencias');
       
tablaTiposIncidencias.bootstrapTable({data: tiposIncidencias});

function descripcionFormatter(value, row) {
    return value ??`<span class="badge badge-secondary">N/A<span>`;
}
function articuloFormatter(value, row) {
    return value ??`<span class="badge badge-secondary">N/A<span>`;
}
function subarticuloFormatter(value, row) {
    return value ??`<span class="badge badge-secondary">N/A<span>`;
}
function unicaVezFormatter(value, row) {
    return value ? `<span class="badge badge-success">SÍ<span>` : `<span class="badge badge-danger">NO<span>`;
}
function diasFormatter(value, row) {
    return value ? `<span class="badge badge-success">${value} días<span>` : `<span class="badge badge-secondary">N/A<span>`;
}
function anioFormatter(value, row) {
    return value ? `<span class="badge badge-success">${value}<span>` : `<span class="badge badge-secondary">N/A<span>`;
}
function intervaloEvaluacionFormatter(value, row) {
    return value.replace(/_/g, " ");
}
function tipoEmpleadoFormatter(value, row) {
    return value.replace(/_/g, " ");
}
function aplicaAutoincidenciasFormatter(value, row) {
    return value ? `<p class="badge badge-success mb-0"> SI </p>` : 
        `<p class="badge badge-danger"> NO </p>`;
}
function activoFormatter(value, row) {
    return value ? `<p class="badge badge-success mb-0"><i class="far fa-check-circle font-size-sm text-white"></i> Activo </p>` : 
        `<p class="badge badge-danger"><i class="fas fa-times font-size-sm text-white"></i> Inactivo </p>`;
}
function accionesFormatter(val, row) {
    return `
        <a href="${row.ruta_editar}" class="btn btn-outline-primary btn-icon editar" data-toggle="tooltip" title="" data-original-title="Editar">
            <i class="fas fa-edit"></i>
        </a>
    `;
}