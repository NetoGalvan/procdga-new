$('.sidebar-nav li .archivos_para_issste').addClass('active');
$('.sidebar-nav li .archivos_para_issste').attr("disabled", "disabled").on("click", function() {
    return false;
});

const tablaArchivosIssste = $('#tabla_archivos_issste');

$(document).ready(function () {

    // Valida si existen archivos para enviar al ISSSTE
    if ( archivosIssste.length > 0 ){
        tablaArchivosIssste.bootstrapTable("destroy");
        tablaArchivosIssste.bootstrapTable({data: archivosIssste});
    } else {
        tablaArchivosIssste.bootstrapTable();
    }

});


// Acciones para descargar el Excel
function acccionesFormatterTipoDeMovimiento(value, row) {
    if ( row.tipo_movimiento_issste == 'ALTA') {
        return '<span class="badge badge-success">ALTA</span>';
    }
    if ( row.tipo_movimiento_issste == 'BAJA') {
        return '<span class="badge badge-danger">BAJA</span>';
    }
    if ( row.tipo_movimiento_issste == 'MODIFICACION') {
        return '<span class="badge badge-secondary">MODIFICACIÓN</span>';
    }
}

// Acciones para descargar el Excel
function acccionesFormatterDescargarExcelIssste(value, row) {
    let path = urlDescargarArchivosIssste+'/'+row.tramite_issste_id+'/'+row.tipo_movimiento_issste_id
    let botones = `<a
                        type="button"
                        class="btn btn-sm btn-success btn-icon"
                        href="${path}"
                        data-toggle="kt-tooltip"
                        title="Descargar Archivo">
                        <i class="far fa-file-excel"></i>
                    </a>`;
    return botones;
}

