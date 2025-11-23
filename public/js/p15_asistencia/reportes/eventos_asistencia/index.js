// INICIA CONFIGURACIÓN FORMULARIO FILTAR
const formFiltrar = $("#form_filtrar");
const btnLimpiar = $("[data-accion=limpiar]");
var validatorFormFiltrar = formFiltrar.validate({
    submitHandler: function(form) {
        let accion = $(this.submitButton).data("accion");
        let datosFormulario = $(form).serialize();
        datosFormulario += "&accion=" + encodeURIComponent(accion);
        KTApp.blockPage({
            overlayColor: '#000000',
            state: 'danger',
            message: 'Por favor, espere...'
        });
        $.get($(form).attr("action"), datosFormulario).done(function(resp) {
            if (resp.estatus) {
                if (resp.registros.length == 0) {
                    swal.fire("No se encontraron eventos. Intente con otra consulta.", "", "error");
                } else {
                    if (accion == "descargar") {
                        downloadFileBase64(resp.pdf, resp.nombre)
                    } else {
                        swal.fire("La consulta ha sido exitosa.", "", "success");
                        tablaFechasEventos.bootstrapTable("load", resp.registros);
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
selectEmpleados.on('select2:unselecting, change', function (e) {
    tablaFechasEventos.bootstrapTable('removeAll');
});
btnLimpiar.click(function (e) {
    formFiltrar.trigger("reset");
    validatorFormFiltrar.resetForm();
    selectEmpleados.val("").trigger("change");
    tablaFechasEventos.bootstrapTable('removeAll');
});
// FINALIZAR CONFIGURACIÓN FORMULARIO FILTRAR

// INICIA CONFIGURACIÓN TABLA DE EVENTOS
var tablaFechasEventos = $("#tabla_fechas_eventos");

function fechaFormatter(value, row) {
    fecha = moment(value);
    return fecha.format('DD-MM-Y');
}

function eventosFormatter(v) {
    let eventos = ``;
    if (v.length == 0) {
        return`<span class="badge badge-secondary">N/A<span>`;
    }
    v.forEach((item, index) => {
        fecha = moment(item.fecha);
        eventos += `<span style="white-space: nowrap;">
            ${fecha.format('HH:mm:ss')}
        </span><br>`;
    });
    return eventos;
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
// FINALIZA CONFIGURACIÓN TABLA DE EVENTOS
