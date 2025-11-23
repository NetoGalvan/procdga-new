const tablaServiciosSolicitados = $('#tablaServiciosSolicitados');
const tablaDetalleServicioSolicitado = $('#tablaDetalleServiciosSolicitados');
const modalDetalleServicio = $('#modal_ss');
const modalLabelArea = $('#modal_area');
const modalLabelNombre = $('#modal_nombre_contacto');
const modalLabelTelefono = $('#modal_telefono');
const modalLabelDireccion = $('#modal_direccion');
const modalLabelDescripcion = $('#modal_descripcion');
const formFiltrar = $('#form_filtro');
const urlFormFiltrar = formFiltrar.attr('action');
const btnFiltrar = $('#btn_filtrar_reporte');
const btnLimpiarFiltro = $('#btn_limpiar_filtro');
const inputAnio = $('#input_year');
const inputArea = $('#area_id');
const inputEstatus = $('#estatus');
const inputEspecialidad = $('#especialidad');
const btnGenerarReporte = $('#btn_generar_reporte');

$('#rango_de_fecha').datepicker({
    rtl: KTUtil.isRTL(),
    todayHighlight: true,
    format: "dd/mm/yyyy",
    autoclose: true,
    language: "es",
    showOnFocus: true,
    orientation: "bottom left",
});
$('#area_id').select2({
    placeholder: 'Seleccione una opción'
});
$('#estatus').select2({
    placeholder: 'Seleccione una opción'
});
$('#especialidad').select2({
    placeholder: 'Seleccione una opción'
});

/* Formatter para la especialidad del Detalle del servicio */
function estatusDetalleServicioFormatter(value, row) {
    let estatusDetalle = row.estatus_detalle;
    if ( estatusDetalle == ' ' || estatusDetalle == 'undefined' || estatusDetalle == null )
        return `<span class="badge badge-warning text-uppercase">PENDIENTE</span>`;
    else {
		return `<span class="badge badge-primary text-uppercase">${estatusDetalle}</span>`;
	}
}

/* Formatter para la Especialidad/Taller del Detalle del servicio */
function especialidadDetalleServicioFormatter(value, row) {
    let tipoServicio = row.nombre_servicio ? row.nombre_servicio : row.tipo_servicio;
    if ( value !== ' ' )
		return `<span class="badge badge-primary text-uppercase">${tipoServicio}</span>`;
	else {
		return `<span class="badge badge-warning text-uppercase">PENDIENTE</span>`;
	}
}

// Función para validar que los input estas vacios y ayuda a no filtrar si no hay nada seleccionado
function camposVacios() {
    let camposVacios = 0;
    if ( inputArea.val() !== '' ) {
        camposVacios ++;
    }
    if ( inputEspecialidad.val() !== '' ) {
        camposVacios ++;
    }
    if ( inputEstatus.val() !== '' ) {
        camposVacios ++;
    }
    if ( inputAnio.val() !== '' ) {
        camposVacios ++;
    }
    /* if ( $('#rango_de_fecha input[name=fecha_de]').val() !== '' && $('#rango_de_fecha input[name=fecha_a]').val() !== '' ) {
        camposVacios ++;
    } */

    return camposVacios;
}

// Evento que envía los datos para generar el reporte
btnGenerarReporte.click(function (e) {
    e.preventDefault();

    Swal.fire({
        title: 'Reporte',
        text: "¿Descargar reporte?",
        icon: 'question',
        showCancelButton: true,
        cancelButtonColor: '#F64E60',
        cancelButtonText: 'No',
        confirmButtonColor: '#0BB7AF',
        confirmButtonText: 'Si'
    }).then((result) => {
        if (result.isConfirmed) {
            KTApp.blockPage({
                overlayColor: '#000000',
                state: 'danger',
                message: 'Por favor, espere...'
            });

            let anio = inputAnio.val() == '' ? null : inputAnio.val();
            let areaId = inputArea.val() == '' ? null : inputArea.val();
            let estatus = inputEstatus.val() == '' ? null : inputEstatus.val();
            let especialidad = inputEspecialidad.val() == '' ? null : inputEspecialidad.val();
            let url = urlGenerarReporteExcel+'/'+tipoDeServicio.servicio_general_id+'/'+anio+'/'+areaId+'/'+estatus+'/'+especialidad;

            $.ajax({
                type: "GET",
                url: url,
                xhrFields: {
                    responseType: 'blob' // Configura la respuesta como un objeto Blob
                },
                success: function (response) {
                    let link = document.createElement('a');
                    let url = window.URL.createObjectURL(response);
                    link.href = url;
                    link.download = 'reporte_solicitud_servicio.xlsx';
                    link.click();
                    window.URL.revokeObjectURL(url);

                    KTApp.unblockPage();
                    Swal.fire({
                        text: '¡Descarga exitosa!',
                        icon: 'success',
                        confirmButtonColor: '#0BB7AF',
                        confirmButtonText: 'Ok'
                    })
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    KTApp.unblockPage();
                    Swal.fire({
                        html: '¡Error, intente más tarde o comuniquese con el área correspondiente!',
                        icon: 'warning',
                        confirmButtonColor: '#0BB7AF',
                        confirmButtonText: 'Ok'
                    });
                }
            });
        }
    })

});

tablaServiciosSolicitados.bootstrapTable({
    pageNumber : 1,
    pageSize : 5,
    /* pageList : [ 5, 10, 15 ], */
    queryParamsType : '',
});

// Función encargada de cargar la tabla con datos al iniciar
function getServiciosSolicitados(params) {
    $.post(urlGetServiciosSolicitados + '?' + $.param(params.data)).then(function (res) {
        if (typeof res.data === 'object') {
            res.data = Object.values(res.data);
        }
        params.hasOwnProperty('success') ? params.success(res) : tablaServiciosSolicitados.bootstrapTable("load", res)
    })
}

function queryParams(params) {
    params.page = params.pageNumber;
    fieldsForm = formFiltrar.serializeArray();
    fieldsForm.forEach(element => {
        params[element.name] = element.value
    });
    return params;
}

/* Formatter para el estatus*/
function estatusServicioFormatter(value, row) {
    let className = `badge-primary`;
    let style = `color: #3699FF; background-color: #E1F0FF;`;
    if (value == 'RECHAZADO') {
		className = `badge-danger`;
        style = `color: #F64E60; background-color: #FFE2E5;`;
	}
    if ( value == 'COMPLETADO' ) {
		className = `badge-success`;
		style = `color: #1BC5BD; background-color: #C9F7F5;`;
	}

	return `<span class="badge ${className} text-uppercase" style="${style}">${value.replace(/_/g, ' ')}</span>`;
}

/* Formatter para el tipo de servicio*/
function unidadServicioFormatter(value, row) {
    return `${row.area.identificador} - ${row.area.nombre}`;
}

// Acciones que puede hacer en esta sección
function accionesFormatterServiciosSolicitados(value, row) {
    let botones =  `
                    <button
                        type="button"
                        class="btn btn-icon btn-outline-success"
                        data-toggle="tooltip"
                        title="Ver Detalle"
                        onclick="verDetalle('${row.folio}')">
                        <i class="far fa-eye"></i>
                    </button>
                    <a type="button"
                        href="${urlImprimirDetalle}/${row.p08_solicita_servicio_id}/${row.folio}"
                        class="btn btn-icon btn-outline-danger descargar-detalle-reporte"
                        data-toggle="tooltip"
                        title="Descargar Información">
                        <i class="far fa-file-pdf"></i>
                    </a>`;
    return botones;
}

// Este evento espera que se cargue la tabla y a traves de su clase obtiene los datos del elemento seleccionado
$(document).ready(function() {
    tablaServiciosSolicitados.on('post-body.bs.table', function() {
        const elementos = document.getElementsByClassName('descargar-detalle-reporte');

        for (let i = 0; i < elementos.length; i++) {
            elementos[i].addEventListener('click', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Detalle(s)',
                    text: "¿Descargar detalle(s)?",
                    icon: 'question',
                    showCancelButton: true,
                    cancelButtonColor: '#F64E60',
                    cancelButtonText: 'No',
                    confirmButtonColor: '#0BB7AF',
                    confirmButtonText: 'Si'
                }).then((result) => {
                    if (result.isConfirmed) {
                        KTApp.blockPage({
                            overlayColor: '#000000',
                            state: 'danger',
                            message: 'Por favor, espere...'
                        });
                        let url = elementos[i].href;
                        let data = '';

                        $.ajax({
                            type: "GET",
                            url: url,
                            data: data,
                            success: function (response) {
                                let url = "data:application/pdf;base64," + response.pdf;
                                let link = document.createElement('a');
                                link.href = url;
                                link.download = response.nombre;
                                link.click();

                                KTApp.unblockPage();
                                Swal.fire({
                                    text: '¡Descarga exitosa!',
                                    icon: 'success',
                                    confirmButtonColor: '#0BB7AF',
                                    confirmButtonText: 'Ok'
                                })
                            },
                            error: function(XMLHttpRequest, textStatus, errorThrown) {
                                KTApp.unblockPage();
                                Swal.fire({
                                    html: '¡Error, intente más tarde o comuniquese con el área correspondiente!',
                                    icon: 'warning',
                                    confirmButtonColor: '#0BB7AF',
                                    confirmButtonText: 'Ok'
                                });
                            }
                        });
                    }
                })

            });
        }
    });
});

// Función para Ver el detalle del Servicio
function verDetalle(folio) {
    $.ajax({
        type: "POST",
        url: urlVerDetalleSolicitud,
        data: {'folio' : folio},
        success: function (response) {
            if ( response.estatus ) {
                // Si la respuesta fue exitosa mostramos el modal con la información encontrada
                modalDetalleServicio.modal('show');
                tablaDetalleServicioSolicitado.bootstrapTable("destroy");
                tablaDetalleServicioSolicitado.bootstrapTable({ data : response.servicioSolicitado.detalles });
                modalLabelArea.text(response.servicioSolicitado.sub_area);
                modalLabelNombre.text(response.servicioSolicitado.contacto_servicio);
                modalLabelTelefono.text(response.servicioSolicitado.telefono_servicio);
                modalLabelDireccion.text(response.servicioSolicitado.direccion_servicio);
                modalLabelDescripcion.html(response.servicioSolicitado.texto_solicitud);
            } else {
                // Si no se muestra msj de error
                Swal.fire({
                    title: '',
                    text: response.msj,
                    icon: 'error',
                    confirmButtonColor: '#DC3545',
                    confirmButtonText: 'Ok',
                })
            }
        }
    });
}

// Evento que manda los datos del Filtro para buscar
btnFiltrar.click(function (e) {
    let data = formFiltrar.serializeArray();
    let hayCamposVacios = camposVacios();
    if (hayCamposVacios <= 0) {
        Swal.fire({
            title: 'Filtrar',
            text: "Debes seleccionar al menos un dato antes de aplicar la busqueda",
            icon: 'warning',
            confirmButtonColor: '#0BB7AF',
            confirmButtonText: 'Entendido'
        });
    } else {
        params = {};
        params.data = {
            page: 1,
            pageNumber: 1,
            pageSize: 5,
            searchText: "",
            sortName: undefined,
            sortOrder: "asc",
        }
        data.forEach(element => {
            params.data[element.name] = element.value
        });

        getServiciosSolicitados(params)
        tablaServiciosSolicitados.bootstrapTable('refreshOptions', {
            pageNumber: 1
        })
    }
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
            location.reload()
        }
    })

});

$("#input_year").datepicker({
    format: "yyyy",
    viewMode: "years",
    minViewMode: "years",
    startDate: '2000',
    endDate: '+0y',
    autoclose : true,
}).on("change", function() {
    $(this).trigger("keyup");
});
