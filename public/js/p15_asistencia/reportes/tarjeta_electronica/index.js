const formBuscar = $("#form_buscar");
const tablaRegistros = $("#tabla_registros");
const btnLimpiar = $("[data-accion=limpiar]");

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
                if (resp.registros.length == 0) {
                    swal.fire("No se encontraron registros que coincidan con tu búsqueda. Por favor, intenta modificar tus criterios de búsqueda.", "", "error");
                } else {
                    if (accion == "descargar") {
                        downloadFileBase64(resp.pdf, resp.nombre)
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
    selectEmpleados.val("").trigger("change");
    tablaRegistros.bootstrapTable("load", []);
});

function fechaFormatter(v) {
    fecha = moment(v);
    return `<span style="white-space: nowrap;">${fecha.format('DD-MM-Y')}</span>`;
}

function eventoValidoFormatter(v) {
    if (v === null) {
        return`<span class="badge badge-secondary">N/A<span>`;
    }
    fecha = moment(v.fecha);
    return fecha.format('HH:mm:ss');
}

function horarioFormatter(v) {
    if (v === null) {
        return`<span class="badge badge-secondary">N/A<span>`;
    }
    let horario = v.entrada.substring(0, 5);
    if (v.salida) {
       horario += ` - ${v.salida.substring(0, 5)}`;  
    }
    return horario;
}

function evaluacionFormatter(v) {
    let className = "badge badge-secondary";
    if (v == "ASISTENCIA") {
        className = "badge badge-success";
    } else if (v == "FALTA") {
        className = "badge badge-danger";
    }  else if (v == "RETARDO_LEVE") {
        className = "badge badge-primary";
    } else if (v == "RETARDO_GRAVE") {
        className = "badge badge-warning";
    } 
    return `<span class="${className}" style="white-space:nowrap;">${v.replace("_", " ")}<span>`;
}

function foliosIncidenciasFormatter(v) {
    let incidencias = ``;
    if (v.length == 0) {
        return`<span class="badge badge-secondary">N/A<span>`;
    }
    v.forEach((item, index) => {
        incidencias += `<span style="white-space: nowrap;">
            ${item.folio_autorizacion}   
        </span><br>`;
    });
    return incidencias;
}

function tiposIncidenciasFormatter(v) {
    let incidencias = ``;
    if (v.length == 0) {
        return`<span class="badge badge-secondary">N/A<span>`;
    }
    v.forEach((item, index) => {
        incidencias += `<span style="white-space: nowrap;">
        ${item.tipo_incidencia.tipo_justificacion.nombre} - ${item.tipo_incidencia.articulo}    
        </span><br>`;
    });
    return incidencias;
}