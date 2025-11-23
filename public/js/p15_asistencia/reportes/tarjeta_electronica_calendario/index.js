// INICIA CONFIGURACIÓN DE FORMULARIO PARA FILTRAR
const formFiltrar = $("#form_filtrar");
const btnLimpiar = $("[data-accion=limpiar]");
var validatorFormFiltrar = formFiltrar.validate({
    submitHandler: function(form) {
        calendar.removeAllEvents();
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
                        calendar.addEventSource(getEventos(resp.registros));
                        calendar.refetchEvents();
                        calendar.setOption("validRange", {
                            start: moment(resp.fecha_inicio, "DD-MM-Y").format("Y-MM-DD"),
                            end: moment(resp.fecha_final, "DD-MM-Y").add(1, 'days').format("Y-MM-DD"),
                        });
                        calendar.gotoDate(moment(resp.fecha_inicio, "DD-MM-Y").toDate());
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
    calendar.removeAllEvents();
    calendar.setOption("validRange");
});
btnLimpiar.click(function (e) {
    formFiltrar.trigger("reset");
    validatorFormFiltrar.resetForm();
    selectEmpleados.val("").trigger("change");
    calendar.removeAllEvents();
    calendar.setOption("validRange");
});
// FINALIZA CONFIGURACIÓN DE FORMULARIO PARA FILTRAR

// INICIA CONFIGURACIÓN DE CALENDARIO
var calendarEl = document.getElementById('calendar');
var calendar = new FullCalendar.Calendar(calendarEl, {
    locale: 'es',
    showNonCurrentDates: false,
    plugins: ['bootstrap', 'interaction', 'dayGrid', 'timeGrid', 'list'],
    themeSystem: 'bootstrap',
    isRTL: KTUtil.isRTL(),
    header: {
        left: 'prev,next',
        center: 'title',
        right: ''
    },
    events: [],
    editable: false,
    eventClick: function (arg) {
        let props = arg.event.extendedProps;
        let className = ``;
        if (["SIN_EVALUACION", "POR_EVALUAR", "DIA_INHABIL", "DIA_FESTIVO"].includes(props.evaluacion_final)) {
            return false;
        } else if (props.evaluacion_final == "ASISTENCIA") {
            className = "badge badge-success";
        } else if (props.evaluacion_final == "FALTA") {
            className = "badge badge-danger";
        } else if (props.evaluacion_final == "RETARDO_LEVE") {
            className = "badge badge-primary";
        } else if (props.evaluacion_final == "RETARDO_GRAVE") {
            className = "badge badge-warning";
        } else if (props.evaluacion_final == "SIN_EVALUACION") {
            className = "badge badge-secondary";
        } 
        tablaEventos.bootstrapTable("load", props.eventos);
        tablaEventosEvaluacion.bootstrapTable("load", [props.eventos_validos]);
        tablaIncidencias.bootstrapTable("load", props.incidencias);
        modalDetalleAsistencia.find("#fecha").html(moment(props.fecha).format("DD-MM-Y"));
        modalDetalleAsistencia.find("#evaluacion").removeClass().addClass(className).html(props.evaluacion_final.replace(/_/g, " "));

        if (props.horario != null) {
            let diasFormatoString = ``;
            props.horario.dias_formato_string.forEach((dia, indice) => {
                diasFormatoString += dia;
                if (indice < props.horario.dias_formato_string.length - 1) {
                    diasFormatoString += ", ";
                }
            });
            if (props.horario.salida) {
                modalDetalleAsistencia.find("#horario").html(`${props.horario.entrada} - ${props.horario.salida} - ${diasFormatoString}`);
            } else {
                modalDetalleAsistencia.find("#horario").html(`${props.horario.entrada} - ${diasFormatoString}`);
            }
            props.horario.intervalos.forEach(item => {
                if (item.tipo == "ENTRADA") {
                    modalDetalleAsistencia.find("#horario_entrada").html(`${item.inicio} - ${item.final}`);
                } else if (item.tipo == "RETARDO_LEVE") {
                    modalDetalleAsistencia.find("#horario_retardo_leve").html(`${item.inicio} - ${item.final}`);
                } else if (item.tipo == "RETARDO_GRAVE") {
                    modalDetalleAsistencia.find("#horario_retardo_grave").html(`${item.inicio} - ${item.final}`);
                } else if (item.tipo == "SALIDA") {
                    modalDetalleAsistencia.find("#horario_salida").html(`${item.inicio} - ${item.final}`);
                }
            });
            modalDetalleAsistencia.find("#contenedor_horario").show();
            modalDetalleAsistencia.find("#contenedor_sin_horario").hide();
        } else {
            modalDetalleAsistencia.find("#contenedor_sin_horario").html(`<span class="badge badge-danger" style="white-space:nowrap;">SIN ASIGNACIÓN DE UN HORARIO PARA ESTA FECHA</span>`);
            modalDetalleAsistencia.find("#contenedor_sin_horario").show();
            modalDetalleAsistencia.find("#contenedor_horario").hide();
        }
        
        modalDetalleAsistencia.modal("show");
    },
    eventRender: function(info) {
        var element = $(info.el);
        if (info.event.extendedProps && info.event.extendedProps.description) {
            if (element.hasClass('fc-day-grid-event')) {
                element.data('content', info.event.extendedProps.description);
                element.data('placement', 'top');
                KTApp.initPopover(element);
            } else if (element.hasClass('fc-time-grid-event')) {
                element.find('.fc-title').append('<div class="fc-description">' + info.event.extendedProps.description + '</div>');
            } else if (element.find('.fc-list-item-title').lenght !== 0) {
                element.find('.fc-list-item-title').append('<div class="fc-description">' + info.event.extendedProps.description + '</div>');
            }
        }
    }
});
calendar.render();

function getEventos(evaluaciones) {
    var events = [];
    evaluaciones.forEach((item, key) => {
        let className = ``;
        let description = ``;
        if (item.evaluacion_final == "ASISTENCIA") {
            className = "fc-event-solid-success";
            description = "Ver detalle";
        } else if (item.evaluacion_final == "FALTA") {
            className = "fc-event-solid-danger";
            description = "Ver detalle";
        } else if (item.evaluacion_final == "RETARDO_LEVE") {
            className = "fc-event-solid-primary";
            description = "Ver detalle";
        } else if (item.evaluacion_final == "RETARDO_GRAVE") {
            className = "fc-event-solid-warning";
            description = "Ver detalle";
        } else if (item.evaluacion_final == "DIA_FESTIVO") {
            className = "fc-event-success";
        } 
        events.push({
            title: item.evaluacion_final.replace(/_/g, " "),
            start: item.fecha,
            fecha: item.fecha,
            horario: item.horario,
            eventos: item.eventos,
            incidencias: item.incidencias,
            eventos_validos: item.eventos_validos,
            evaluacion_final: item.evaluacion_final,
            description: description,
            className: className
        }); 
    });
    return events;
}
// FINALIZA CONFIGURACIÓN DE CALENDARIO

// INICIA CONFIGURACIÓN MODAL
var modalDetalleAsistencia = $("#modal_detalle_asistencia");
var modalDetalleEvento = $("#modal_detalle_evento");
var tablaEventos = $("#tabla_eventos");
var tablaEventosEvaluacion = $("#tabla_eventos_evaluacion");
var tablaIncidencias = $("#tabla_incidencias"); 

// INICIA CONFIGURACIÓN TABLA EVENTOS
function fechaFormatter(value, row) {
    fecha = moment(value);
    return `<span style="white-space: nowrap;">${fecha.format('HH:mm:ss')}</span>`;
}
function biometricoFormatter(value, row) {
    return value ?? row.tip ?? `<span class="badge badge-secondary">N/A<span>`;
}
function accessoFormatter(value, row) {
    return value ?? `<span class="badge badge-secondary">N/A<span>`;
}
function accionesEventosFormatter(value, row) {
    if (row.biometrico != null && row.biometrico.tipo == "facial") {
        return `<button class="btn btn-outline-primary btn-icon ver-imagen" data-toggle="tooltip" title="Ver">
            <i class="fas fa-eye"></i>
        </button>`;
    }
    return `<span class="badge badge-secondary">N/A<span>`;
}
function estatusEventoFormatter(value, row) {
    if (value == "REGISTRO_VERIFICADO") {
        return `<span class="badge badge-success"><i class="fas fa-check icon-nm text-white mr-1"></i> REGISTRO VERIFICADO </span>`;
    } 
	return `<span class="badge badge-danger"><i class="far fa-times icon-nm text-white mr-1"></i> REGISTRO NO VERIFICADO </span>`;
}
var accionesEventosEvents = {
    'click .ver-imagen': function (e, value, row, index) {
        KTApp.blockPage({
            overlayColor: '#000000',
            state: 'danger',
            message: 'Por favor, espere...'
        });
        $.get(rutaGetImagenEvento, {evento_id: row.id})
            .done(function(resp) {
                modalDetalleEvento.find("img").attr("src", `data:image/png;base64,${resp.imagen}`);
                modalDetalleEvento.modal("show");
            }).fail(function(jqXHR, textStatus, error) {
                swal.fire("", error, "error");
            }).always(function() {
                KTApp.unblockPage();
            });
    }
}
tablaEventos = $("#tabla_eventos").bootstrapTable({
    formatNoMatches: function () {
        return 'No se han encontrado eventos en esta fecha.';
    }
});
// FINALIZA CONFIGURACIÓN TABLA EVENTOS

// INICIA CONFIGURACIÓN TABLA DE EVENTOS DE EVALUACIÓN
function eventoEvaluacionFormatter(value, row) {
    if (value === null) {
        return`<span class="badge badge-secondary">N/A<span>`;
    }
    fecha = moment(value.fecha);
    return fecha.format('HH:mm:ss');
}
// FINALIZA CONFIGURACIÓN TABLA DE EVENTOS DE EVALUACIÓN

// INICIA CONFIGURACIÓN TABLA INCIDENCIAS
tablaIncidencias = $("#tabla_incidencias").bootstrapTable({
    formatNoMatches: function () {
        return 'No se han solicitado incidencias para esta fecha.';
    }
});
// FINALIZA CONFIGURACIÓN TABLA INCIDENCIAS

// FINALIZA CONFIGURACIÓN MODAL