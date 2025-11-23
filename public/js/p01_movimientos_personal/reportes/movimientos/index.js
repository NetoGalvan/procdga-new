const formBuscar = $("#form_buscar");
const tablaRegistros = $("#tabla_registros");
const btnLimpiar = $("[data-accion=limpiar]");
const selectTipoMovimiento = $('#tipo_movimiento_id');
const selectQna = $('#qna_procesado');
const selectEstatus = $('#estatus');
const inputFolio = $('#folio');

selectTipoMovimiento.select2({placeholder: "Selecciona una opción"})
selectQna.select2({placeholder: "Selecciona una opción"})
selectEstatus.select2({placeholder: "Selecciona una opción"})

var validatorFormBuscar = formBuscar.validate({
    submitHandler: function(form) {
        let accion = $(this.submitButton).data("accion");
        let datosFormulario = $(form).serialize();
        datosFormulario += "&accion=" + encodeURIComponent(accion);
        tablaRegistros.bootstrapTable("load", []);
        KTApp.blockPage({
            overlayColor: '#000000',
            state: 'danger',
            message: 'Por favor, espere...'
        });
        $.get($(form).attr("action"), datosFormulario).done(function(resp) {
            if (resp.estatus) {
                if (accion == "descargar") {
                    window.location.href = resp.url;
                } else {
                    if (resp.registros.length == 0) {
                        swal.fire("No se encontraron registros que coincidan con tu búsqueda.", "", "error");
                    } else {
                        tablaRegistros.bootstrapTable("load", resp.registros);
                        swal.fire("La consulta ha sido exitosa.", "", "success");
                    }
                }
            } else {
                swal.fire("", resp.mensaje, "error");
            }
        }).fail(function(jqXHR, textStatus, error) {
            swal.fire("", error, "error");
        }).always(function() {
            KTApp.unblockPage();
        });
    }
});

btnLimpiar.click(function () {
    formBuscar.trigger("reset");
    validatorFormBuscar.resetForm();
    tablaRegistros.bootstrapTable("load", []);
});

$('.input-date-range-current').datepicker('destroy');
$('.input-date-range-current').datepicker({
    rtl: KTUtil.isRTL(),
    todayHighlight: true,
    format: "dd-mm-yyyy",
    autoclose: true,
    language: "es",
    showOnFocus: true,
    orientation: "bottom left",
    endDate: new Date(new Date().setDate(new Date().getDate()))
}).on("change", function() {
    $(this).find("input").trigger("keyup");
});

function fechaSolicitud(value, row) {
    if (row.fecha_solicitud === null) {
        return `<span class="badge badge-secondary">N/A<span>`;
    }
    return value;
}

function tipoMovimiento(value, row) {
    if (value === null) {
        return `<span class="badge badge-secondary">N/A<span>`;
    }
    return `${value.codigo} - ${value.descripcion}`
}

function qnaProcesado(value, row) {
    if (row.qna_procesado === null) {
        return `<span class="badge badge-secondary">N/A<span>`;
    }
    return value;
}

function unidadAdministrativa(value, row) {
    if (row.nombre_area === null) {
        return `<span class="badge badge-secondary">N/A<span>`;
    }
    return value;
}

function nombreEmpleado(value, row) {
    if (row.nombre_empleado === null) {
        return `<span class="badge badge-secondary">N/A<span>`;
    }
    return value;
}

function apellidoPaterno(value, row) {
    if (row.apellido_paterno === null) {
        return `<span class="badge badge-secondary">N/A<span>`;
    }
    return value;
}

function apellidoMaterno(value, row) {
    if (row.apellido_materno === null) {
        return `<span class="badge badge-secondary">N/A<span>`;
    }
    return value;
}

function numeroEmpleado(value, row) {
    if (row.numero_empleado === null) {
        return `<span class="badge badge-secondary">N/A<span>`;
    }
    return value;
}

function codigoPuesto(value, row) {
    if (row.codigo_puesto === null) {
        return `<span class="badge badge-secondary">N/A<span>`;
    }
    return value;
}

function numeroPlaza(value, row) {
    if (row.numero_plaza === null) {
        return `<span class="badge badge-secondary">N/A<span>`;
    }
    return value;
}

function telefonoCelular(value, row) {
    if (row.telefono_celular === null) {
        return `<span class="badge badge-secondary">N/A<span>`;
    }
    return value;
}

function email(value, row) {
    if (row.email === null) {
        return `<span class="badge badge-secondary">N/A<span>`;
    }
    return value;
}

function estatus(value, row) {
    if (value == 'EN_PROCESO') {
        return `<span class="badge badge-primary"><i class="fas fa-spinner icon-nm text-white mr-1"></i> EN PROCESO </span>`;
    } else if (value == 'EN_PAUSA') {
        return `<span class="badge badge-default"><i class="far fa-check-circle icon-nm text-white mr-1"></i> EN PAUSA </span>`;
	} else if (value == 'COMPLETADO') {
        return `<span class="badge badge-success"><i class="far fa-check-circle icon-nm text-white mr-1"></i> COMPLETADO </span>`;
	} else if (value == 'RECHAZADO') {
		return `<span class="badge badge-danger"><i class="far fa-times-circle icon-nm text-white mr-1"></i> RECHAZADO </span>`;
	} else if (value == 'CANCELADO') {
		return `<span class="badge badge-danger"><i class="far fa-times-circle icon-nm text-white mr-1"></i> CANCELADO </span>`;
	}
}

function acciones(value, row) {
    if (row.estatus == "COMPLETADO") {
        return `<a 
            href="${row.ruta_descargar_alimentario}" 
            class="btn btn-primary descargar-alimentario">
            <i class="fas fa-file-download p-0"></i>
        </a>`;
    }
    return `<span class="badge badge-secondary">N/A<span>`;
} 

tablaRegistros.on("click", ".descargar-alimentario", function(e) {
    e.preventDefault(); 
    var url = $(this).attr("href");
    KTApp.blockPage({
        overlayColor: '#000000',
        state: 'danger',
        message: 'Por favor, espere...'
    });
    var iframe = $("<iframe>", { src: url }).hide().appendTo("body");
    iframe.on("load", function() {
        KTApp.unblockPage();
        setTimeout(function() {
            iframe.remove();
        }, 1000);
    });
});