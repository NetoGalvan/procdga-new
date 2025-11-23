var btnLimpiarFiltro = $('#btn_limpiar_filtro');
var btnFiltrar = $('#btn_filtrar_reporte');
var formFiltrar = $('#form_filtro');
var inputFolio = $('#folio');
const tablaTramitesKardex = $('#tablaTramitesKardex');
const hrefDescargarDetalles = $("#href_descargar_detalles");
const hrefDescargarSeguimientos = $("#href_descargar_seguimientos");
var btnGenerarReporte = $('#btn_generar_reporte');

$(document).ready(function () {
    // Mostrar u ocultar select con estatus radio button
    $("input[id$='local']").click(function() {
        $('#estatus_new').show();
        $('#estatus_local').val("");
        $('#estatus_old').hide();
    });

    $("input[id$='historico']").click(function() {
        $('#estatus_new').hide();
        $('#estatus_historico').val("");
        $('#estatus_old').show();
    });
});

btnLimpiarFiltro.click(function (e) {
    Swal.fire({
        title: '¿Limpiar filtros de búsqueda?',
        text: "",
        icon: 'question',
        showCancelButton: true,
        cancelButtonColor: '#F64E60',
        cancelButtonText: 'No',
        confirmButtonColor: '#0BB7AF',
        confirmButtonText: 'Si'
    }).then((result) => {
        if (result.isConfirmed) {
            $('#tipo_tramite').val(""); $('#fecha_de').val(""); $('#fecha_a').val(""); $('#folio').val(""); $('#estatus_historico').val(""); $('#estatus_local').val("");
        }
    })
});

// Formato de rango de fechas
$('#rango_de_fecha').datepicker({
    rtl: KTUtil.isRTL(),
    todayHighlight: true,
    format: "dd/mm/yyyy",
    autoclose: true,
    language: "es",
    showOnFocus: true,
    orientation: "bottom left",
});

// Función para validar que los input estas vacios y ayuda a no filtrar si no hay nada seleccionado
function camposVacios() {
    var camposVacios = 0;
    if ( $("#estatus_local").val() !== '' ) {
        camposVacios ++;
    }
    if ( $("#tipo_tramite").val() !== '' ) {
        camposVacios ++;
    }
    if ( inputFolio.val() !== '' ) {
        camposVacios ++;
    }
    if ( $('#rango_de_fecha input[name=fecha_de]').val() !== '' && $('#rango_de_fecha input[name=fecha_a]').val() !== '' ) {
        camposVacios ++;
    }
    return camposVacios;
}

btnFiltrar.click(function (e) {

    var hayCamposVacios = camposVacios();
    if (hayCamposVacios <= 0) {
        Swal.fire({
            title: 'Filtrar',
            text: "Debes seleccionar al menos un dato antes de aplicar la busqueda",
            icon: 'warning',
            confirmButtonColor: '#0BB7AF',
            confirmButtonText: 'Entendido'
        });
    } else {
        swal.fire({
            "title": "Verifique la información para filtrar la búsqueda",
            "icon": "warning",
            "confirmButtonColor": '#0abb87',
            "confirmButtonText": 'Aceptar',
            "showCancelButton": true,
            "cancelButtonColor": '#fd397a',
            "cancelButtonText": 'Cancelar',
            "allowOutsideClick": false,
        }).then((result) => {

            swal.fire({
                title: "Buscando información",
                text: "Por favor espera",
                allowOutsideClick: false,
                onOpen: function() {
                    swal.showLoading()
                }
            });

            if (!result.value) {
                swal.close()
            }

            if (result.value) {
                tablaTramitesKardex.bootstrapTable("destroy");
                tablaTramitesKardex.bootstrapTable();
                setTimeout(() => {
                    $.ajax({
                        type: "POST",
                        url: urlGetHojasServicio,
                        data: formFiltrar.serializeArray(),
                        asyn:false,
                        success: function(data){

                            if (data.estatus) {
                                Swal.fire(data.mensaje, "", "success");
                                tablaTramitesKardex.bootstrapTable("destroy");
                                tablaTramitesKardex.bootstrapTable();

                                data.infoServicioQuery.forEach(info => {
                                    tablaTramitesKardex.bootstrapTable("load", data.infoServicioQuery);
                                });
                            }else{
                                swal.fire({
                                    "title": data.mensaje,
                                    "icon": "error",
                                    "confirmButtonColor": '#0abb87',
                                    "confirmButtonText": 'Aceptar',
                                    "allowOutsideClick": false,
                                });
                            }
                        }
                    }).fail(function(respuesta, xhr, response) {
                        swal.fire({
                            "text": "Ocurrio un error al buscar la información",
                            "icon": "warning",
                            "confirmButtonColor": '#0abb87',
                            "confirmButtonText": 'Aceptar',
                        });
                    });
                },2000)
            }
        });
    }
});

function hojasServicioFormatter(value, row) {
    if (row.tipo_tramite_kardex_id == 1 || row.id_proc == 'p03') {
        return `<span class="badge badge-primary text-uppercase">HOJAS DE SERVICIO </span>`;
    } else if (row.tipo_tramite_kardex_id == 2 || row.id_proc == 'p04') {
        return `<span class="badge badge-success text-uppercase">COMPROBANTES DE SERVICIO</span>`;
    } else {
        return `<span class="badge badge-danger text-uppercase">Faltante</span>`;
    }
}

function nombreEmpleadoFormatter(value, row) {

    let buscar_en = $('input[name="buscar_por"]:checked').val();

    if (buscar_en == "local") {
        let nombreEmpleado = `${row.nombre} ${row.apellido_paterno} ${row.apellido_materno} `;
        return nombreEmpleado;
    } else {
        let nombreEmpleado = `${row.nombre_empleado} ${row.apellido_paterno} ${row.apellido_materno} `;
        return nombreEmpleado;
    }
}

function accionesFormatterServiciosSolicitados(value, row) {

    let buscar_en = $('input[name="buscar_por"]:checked').val();

    if (buscar_en == "local") {
        let botones =
        `<a type="button"
            id="href_descargar_detalles"
            href="${urlImprimirDetalles}/${row.folio}/${row.tipo_tramite_kardex_id}"
            class="btn btn-sm btn-outline-danger btn-icon"
            data-toggle="tooltip"
            title="Descargar detalle(s)">
            <i class="fas fa-file-pdf"></i>
        </a>

        <a type="button"
            id="href_descargar_seguimientos"
            href="${urlImprimirSeguimientos}/${row.folio}/${row.tipo_tramite_kardex_id}"
            class="btn btn-sm btn-outline-danger btn-icon"
            data-toggle="tooltip"
            title="Descargar seguimiento(s)">
            <i class="fas fa-file-pdf"></i>
        </a>`;

        return botones;
    } else {
        let botones =
        `<a type="button"
            id="href_descargar_detalles"
            href="${urlImprimirDetalles}/${row.folio}/${row.id_proc}"
            class="btn btn-sm btn-outline-danger btn-icon"
            data-toggle="tooltip"
            title="Descargar detalle(s)">
            <i class="fas fa-file-pdf"></i>
        </a>

        <a type="button"
            id="href_descargar_seguimientos"
            href="${urlImprimirSeguimientos}/${row.folio}/${row.id_proc}"
            class="btn btn-sm btn-outline-danger btn-icon"
            data-toggle="tooltip"
            title="Descargar seguimiento(s)">
            <i class="fas fa-file-pdf"></i>
        </a>`;

        return botones;
    }


}

function generarReporte() {
    var inputFechaDe = $('#rango_de_fecha input[name=fecha_de]').val() == '' ? null : $('#rango_de_fecha input[name=fecha_de]').val();
    var inputFechaA = $('#rango_de_fecha input[name=fecha_a]').val() == '' ? null : $('#rango_de_fecha input[name=fecha_a]').val();
    var folio = inputFolio.val() == '' ? null : inputFolio.val();
    var tipo_tramite = $("#tipo_tramite").val() == '' ? null : $("#tipo_tramite").val();
    var estatus_local = $("#estatus_local").val() == '' ? null : $("#estatus_local").val();
    var estatus_historico = $("#estatus_historico").val() == '' ? null : $("#estatus_historico").val();
    let buscar_en = $('input[name="buscar_por"]:checked').val();
    // Si hay fecha capturada de cambia la estructura para su envío por la url
    if ( inputFechaDe ) {
        var fechaDe = inputFechaDe.split('/');
        var fechaDe = fechaDe.join('-');
    } else {
        var fechaDe = null;
    }
    if ( inputFechaA ) {
        var fechaA = inputFechaA.split('/');
        var fechaA = fechaA.join('-');
    } else {
        var fechaA = null;
    }
    // Se asigna al href para la busqueda y descarga
    btnGenerarReporte.attr('href', urlGenerarReporteExcel+'/'+fechaDe+'/'+fechaA+'/'+folio+'/'+tipo_tramite+'/'+estatus_local+'/'+estatus_historico+'/'+buscar_en);
}
