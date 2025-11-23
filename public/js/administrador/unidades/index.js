const tablaRegistros = $("#tabla_registros");
tablaRegistros.bootstrapTable({data: unidades});

function accionesFormatter(value, row, index) {
    return `<a type="button" 
        class="btn btn-outline-primary btn-icon mr-2" 
        href="${row.ruta_editar}" 
        data-toggle="tooltip" 
        data-placement="top" 
        title="Editar" >
        <i class="fas fa-edit"></i>
    </a>
    <a type="button" 
        class="btn btn-outline-success btn-icon" 
        href="${row.ruta_areas}" 
        data-toggle="tooltip" 
        data-placement="top" 
        title="Áreas">
        <i class="fas fa-hotel"></i>
    </a>`;
}