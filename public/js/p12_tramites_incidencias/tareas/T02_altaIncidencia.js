// INICIA CONFIGURACIÓN SELECCIÓN TIPO INCIDENCIA
const selectTipoIncidencia = $("[name=tipo_incidencia_id]");
const contenedorDetalleTipoIncidencia = $("#contenedor_detalle_tipo_incidencia");
const tablaDetalleTipoIncidencia = $("#tabla_detalle_tipo_incidencia");
const contenedorHorario = $("#contenedor_horario")
const contenedorFechas = $("#contenedor_fechas")

var data = $.map(tiposIncidencias, function (tiposIncidencia) {
    tiposIncidencia.id = tiposIncidencia.tipo_incidencia_id; 
    tiposIncidencia.text = `${tiposIncidencia.tipo_justificacion.nombre} — 
        Artículo: ${tiposIncidencia.articulo ?? "N/A"} — 
        Subartículo: ${tiposIncidencia.subarticulo ?? "N/A"} — 
        Intervalo: ${tiposIncidencia.intervalo_evaluacion.replace(/_/g, " ")} - 
        Sexo: ${tiposIncidencia.sexo == "F" ? "FEMENINO" : tiposIncidencia.sexo == "M" ? "MASCULINO" : "TODOS" } - 
        Tipo días: ${tiposIncidencia.tipo_dias.replace(/_/g, " ")} - 
        Tipo de empleado: ${tiposIncidencia.tipo_empleado.replace(/_/g, " ")}`;
    return tiposIncidencia;
});
selectTipoIncidencia.select2({
    placeholder: "Seleccione tipo de incidencia",
    data: data,
});
selectTipoIncidencia.on('select2:select', function (e) {
    var data = e.params.data;
    contenedorDetalleTipoIncidencia.removeClass("d-none");
    tablaDetalleTipoIncidencia.bootstrapTable("load", [data]);
    
    // Limpiar campos incidencia general
    $("[name=horario_id]").val("");
    $("[name=total_dias]").val("");
    $("[name=fecha_inicio]").val("");
    $("[name=fecha_final]").val("");
    inputRangoFecha.val("").trigger("change");
    iniciarDaterangepicker();
    tablaFechas.bootstrapTable("load", []);
    inicializaSelectHorario();
    contenedorFechas.show();
    
    if (data.tipo_justificacion.identificador == "cambio_horario") {
        contenedorHorario.show();        
    } else {
        contenedorHorario.hide();
    }
});
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
function tipoDiasFormatter(value, row) {
    return value.replace(/_/g, " ");
}
function tipoEmpleadoFormatter(value, row) {
    return value.replace(/_/g, " ");
}
function sexoFormatter(value, row) {
    if (value == "M") return "MASCULINO";
    if (value == "F") return "FEMENINO";

    return value;
}
$(document).ready(function () {
    if (tipoIncidenciaId != null) {
        tiposIncidencias.forEach((item) => {
            if (item.tipo_incidencia_id == tipoIncidenciaId) {
                selectTipoIncidencia.val(tipoIncidenciaId).trigger("change").trigger({
                    type: 'select2:select',
                    params: {
                        data: item
                    }
                });
            }
        });
    }
});
// FINALIZA CONFIGURACIÓN SELECCIÓN TIPO INCIDENCIA

// INICIA CONFIGURACIÓN SELECCIÓN HORARIO
const selectHorario = $("[name=horario_id]");
function inicializaSelectHorario() {
    selectHorario.select2({
        placeholder: "Seleccione horario",
    });
}
// FINALIZA CONFIGURACIÓN SELECCIÓN HORARIO

// INICIA CONFIGURACIÓN FORMULARIO GENERAL DE LA TAREA
const formFinalizarTarea = $("#form_finalizar_tarea");
const modalDetalleDias = $("#modal_detalle_dias");
const btnDetalleDias = $("#btn_detalle_dias");
const tablaFechas = $("#tabla_fechas");
const inputRangoFecha = $('#input_rango_fecha');
const inputRangoFechaHorario = $('#input_rango_fecha_horario');
// Fecha final de horario debe ser mayor a fecha final de inicio
$.validator.addMethod("fechaFinal", function(value, element) {
    var fechaInicio = $("[name=fecha_inicio_horario]").val();
    return moment(value, "DD-MM-Y").isAfter(moment(fechaInicio, "DD-MM-Y")) || value == "";
}, "Fecha final debe ser mayor a fecha de inicio");

const validatorFormFinalizarTarea = formFinalizarTarea.validate({
    errorPlacement: function(label, element) {
        if (element.hasClass("select2")) {
            element.parent().append(label);
        } else if (element.parent().hasClass("input-rango-fecha-custom")) {
            if (!element.parent().next().hasClass("is-invalid")) {
                element.parent().after(label);
            }
        } else if (element.parent().hasClass("input-group")) {
            if (!element.parent().next().hasClass("is-invalid")) {
                element.parent().after(label);
            }
        } else {
            label.insertAfter(element);
        }
    },
    submitHandler: function(form) {
        // VALIDAR QUE EL RANGO DE FECHAS SELECCIONADO ESTE DENTRO DEL RANGO PERMITIDO POR EL TIPO DE INCIDENCIA
        let fechaInicioTI = selectTipoIncidencia.select2('data')[0].fecha_inicio;
        let fechaFinalTI = selectTipoIncidencia.select2('data')[0].fecha_final;
        let fechaInicioInc = inputRangoFecha.data('daterangepicker').startDate.format("Y-MM-DD");
        let fechaFinalInc = inputRangoFecha.data('daterangepicker').endDate.format("Y-MM-DD");
        if (fechaInicioTI && fechaFinalTI && fechaInicioInc && fechaFinalInc) {
            fechaInicioTI =  moment(fechaInicioTI, "Y-MM-DD");
            fechaFinalTI =  moment(fechaFinalTI, "Y-MM-DD");
            fechaInicioInc =  moment(fechaInicioInc, "Y-MM-DD");
            fechaFinalInc =  moment(fechaFinalInc, "Y-MM-DD");
            const isInRange = fechaInicioInc.isSameOrAfter(fechaInicioTI) && fechaFinalInc.isSameOrBefore(fechaFinalTI);
            if (!isInRange) {
                Swal.fire({
                    title: "Error en el rango de fechas",
                    text: `El rango de fechas seleccionadas debe estar entre ${fechaInicioTI.format("DD/MM/YYYY")} y ${fechaFinalTI.format("DD/MM/YYYY")}.`,
                    icon: "error"
                });
                return false;
            }
        }

        if (selectTipoIncidencia.select2('data')[0].tipo_justificacion.identificador != "cambio_horario" &&
            $("[name=total_dias]").val() == 0) {
            swal.fire("Antes de continuar debe agregar las fechas válidas para esta incidencia.", "", "warning");
            return false;
        }
        Swal.fire({
            title: "¿Está seguro?",
            text: "Antes de continuar, verifique que los datos ingresados sean correctos. Después de finalizar la tarea, no podrá regresar.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Sí, continuar",
            cancelButtonText: "Cancelar",
            reverseButtons: true
        }).then(function(result) {
            if (result.value) {
                KTApp.blockPage({
                    overlayColor: '#000000',
                    state: 'danger',
                    message: 'Por favor, espere...'
                });
                form.submit();
            }
        });
    }
});
tablaFechas.bootstrapTable({
    paginationParts: ["pageInfo", "pageList"]
});
function iniciarDaterangepicker() {
    inputRangoFecha.daterangepicker({
        buttonClasses: "btn",
        applyClass: "btn-primary",
        cancelClass: "btn-secondary",
        autoUpdateInput: false,
        maxSpan: {
            months: 12
        },
        locale: {
            cancelLabel: 'Clear',
            format: "DD/MM/YYYY",
            separator: " - ",
            applyLabel: "Guardar",
            cancelLabel: "Cancelar",
            fromLabel: "Desde",
            toLabel: "Hasta",
            customRangeLabel: "Personalizar",
            daysOfWeek: [
                "Do",
                "Lu",
                "Ma",
                "Mi",
                "Ju",
                "Vi",
                "Sa"
            ],
            monthNames: [
                "Enero",
                "Febrero",
                "Marzo",
                "Abril",
                "Mayo",
                "Junio",
                "Julio",
                "Agosto",
                "Setiembre",
                "Octubre",
                "Noviembre",
                "Diciembre"
            ],
            firstDay: 1
        },
    });
    inputRangoFecha.on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
        $(this).trigger("keyup");
        let fechaInicio = inputRangoFecha.data('daterangepicker').startDate.format("DD-MM-Y");
        let fechaFinal = inputRangoFecha.data('daterangepicker').endDate.format("DD-MM-Y");
        let tipoIncidenciaId = $("[name=tipo_incidencia_id]").val();
        KTApp.blockPage({
            overlayColor: '#000000',
            state: 'danger',
            message: 'Por favor, espere...'
        });
        $.get(rutaCalcularDias, {fechaInicio, fechaFinal, tipoIncidenciaId})
            .done((resp) => {
                if (resp.estatus) {
                    $("[name=fecha_inicio]").val(fechaInicio);
                    $("[name=fecha_final]").val(fechaFinal);
                    $("[name=total_dias]").val(resp.fechas_por_estatus["VALIDO"].length).trigger("keyup");
                    $("[name=fechas]").val(JSON.stringify(resp.fechas_por_estatus["VALIDO"]));
                    tablaFechas.bootstrapTable("load", resp.fechas);
                } else {
                    swal.fire("", resp.mensaje, "error");
                }
            }).fail(function(jqXHR, textStatus, error) {
                swal.fire("", error, "error");
            }).always(function() {
                KTApp.unblockPage();
            }); 
    });
}
iniciarDaterangepicker();
// Formatters detalle días
function fechaFormatter(value, row) {
    return moment(value).format("DD-MM-Y");
}
function estatusFormatter(value, row) {
    let span = ``;
    if (value == "VALIDO") {
        span = `<span class="badge badge-success" style="white-space:nowrap;">VÁLIDO<span>`;
    } else if (value == "INVALIDO") {
        span = `<span class="badge badge-danger" style="white-space:nowrap;">INVÁLIDO<span>`;
    } else if (value == "INHABIL") {
        span = `<span class="badge badge-secondary" style="white-space:nowrap;">INHÁBIL<span>`;
    } else if (value == "FESTIVO") {
        span = `<span class="badge badge-warning" style="white-space:nowrap;">FESTIVO<span>`;
    } 
    return span;
}    
// FINALIZA CONFIGURACIÓN FORMULARIO GENERAL DE LA TAREA

// INICIA CONFIGURACIÓN INCIDENCIAS EMPLEADO
const tablaIncidenciasEmpleado = $("#tabla_incidencias_empleado");

tablaIncidenciasEmpleado.bootstrapTable({
    queryParamsType : '',
    formatSearch: function () {
        return "Buscar ..."
    }
});

function getIncidenciasEmpleado(params) {
    $.get(urlGetIncidenciasEmpleado).then(function (res) {
        params.success(res);
    })
}
// FINALIZA CONFIGURACIÓN INCIDENCIAS EMPLEADO

