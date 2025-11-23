// INICIA CONFIGURACIÓN SECCIÓN FILTRAR
const formFiltrar = $("#form_filtrar");
const tablaEmpleados = $("#tabla_empleados");
const contenedorSeccionSindical = $("#contenedor_seccion_sindical");
const selectUnidadesAdministrativas = $("[name=unidad_administrativa_id]");
const selectSexo = $("[name=sexo]");
const selectTipoEmpleado = $("[name=tipo_empleado]");
const selectSeccionSindical = $("[name=seccion_sindical]");
const txtAreaNumerosEmpleados = $("[name=numeros_empleados]");

function limpiarTablaEmpleados(e) {
    tablaEmpleados.bootstrapTable("load", []);
}

selectUnidadesAdministrativas.select2({
    placeholder: "Seleccione una opción",
    allowClear: true,
}).on('select2:unselect', limpiarTablaEmpleados)
.on('select2:select', limpiarTablaEmpleados);
selectSexo.select2({
    placeholder: "Seleccione una opción",
    allowClear: true,
}).on('select2:unselect', limpiarTablaEmpleados)
.on('select2:select', limpiarTablaEmpleados);
selectTipoEmpleado.select2({
    placeholder: "Seleccione una opción",
    allowClear: true,
}).on('select2:unselect', limpiarTablaEmpleados)
.on('select2:select', limpiarTablaEmpleados);
selectSeccionSindical.select2({
    placeholder: "Seleccione una opción",
    allowClear: true,
}).on('select2:unselect', limpiarTablaEmpleados)
.on('select2:select', limpiarTablaEmpleados);
selectTipoEmpleado.change(function() {
    if ($(this).val() == "SINDICALIZADO") {
        contenedorSeccionSindical.show();
    } else {
        contenedorSeccionSindical.hide();
        selectSeccionSindical.val("").trigger("change");
    }
});
let valorPrevio = "";
txtAreaNumerosEmpleados.on('input', function() {
    const valorActual = $(this).val();
    if (valorActual.length < valorPrevio.length) {
        limpiarTablaEmpleados();
    }
    valorPrevio = valorActual;
});
var valor = "";
var pasteEvent = false;
txtAreaNumerosEmpleados.on("input", function() {
    if (!pasteEvent) {
        let valorAux = $(this).val();
        let regExp = /^(\d+)(,\d+)*,?$/;
        if (!(valorAux == "") && !regExp.test(valorAux)) {
            $(this).val(valor);
        } else {
            valor = valorAux;
        }
    }
    pasteEvent = false;
});
document.getElementById("numeros_empleados").addEventListener('paste', function(e) {
    pasteEvent = true;
    let valorAux = e.clipboardData.getData('text');
    let regExp = /^(\d+)(,\d+)*,?$/;
    if (!regExp.test(valorAux)) {
        Swal.fire("Por favor, verifique que la cadena cumpla con la estructura adecuada, ya que actualmente no se ajusta a los criterios requeridos.", "", "error");
        $(this).val("");
    }
}); 
const validatorFormFiltrar = formFiltrar.validate({
    submitHandler: function(form) {
        KTApp.blockPage({
            overlayColor: '#000000',
            state: 'danger',
            message: 'Por favor, espere...'
        });
        if ($(this.submitButton).data("accion") == "limpiar") {
            limpiarTablaEmpleados();
            formFiltrar.trigger("reset");
            validatorFormFiltrar.resetForm();
            selectUnidadesAdministrativas.val("").trigger("change");
            selectSexo.val("").trigger("change");
            selectTipoEmpleado.val("").trigger("change");
            selectSeccionSindical.val("").trigger("change");
            KTApp.unblock();
            return false;
        }
        tablaEmpleados.bootstrapTable("load", []);
        $.get(rutaGetEmpleados, $(form).serialize())
            .done(function(resp) {
                if (resp.estatus) {
                    tablaEmpleados.bootstrapTable("load", resp.empleados);
                    formFinalizarTarea.find("[name=empleados]").val(JSON.stringify(resp.empleados));
                } else {
                    swal.fire("", resp.mensaje, "error");
                }
            })
            .always(function() {
                KTApp.unblock();
            });
    }
});
function unidadAdministrativaFormatter(value, row) {
    return `${row.unidad_administrativa} - ${row.unidad_administrativa_nombre}`;
}
function sexoFormatter(value, row) {
    if (value == "M") return "MASCULINO";
    if (value == "F") return "FEMENINO";
    return value;
}
function tipoEmpleadoFormatter(value, row) {
    return value.replace(/_/g, " ");
}
// FINALIZA SECCIÓN FILTRAR

// INICIA CONFIGURACIÓN SECCIÓN FECHAS
const inputRangoFecha = $("#input_rango_fecha");
const inputRangoFechaHorario = $('#input_rango_fecha_horario');

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
// FINALIZA CONFIGURACIÓN SECCIÓN FECHAS

// INICIA CONFIGURACIÓN SECCIÓN GENERAL
const formFinalizarTarea = $("#form_finalizar_tarea");
const selectTipoIncidencia = $("[name=tipo_incidencia_id]");
const tablaDetalleTipoIncidencia = $("#tabla_detalle_tipo_incidencia");
const selectHorario = $("[name=horario_id]");
const tablaFechas = $("#tabla_fechas");
const contenedorDetalleTipoIncidencia = $("#contenedor_detalle_tipo_incidencia");
const contenedorHorario = $("#contenedor_horario");
const contenedorFechas = $("#contenedor_fechas");

var data = $.map(tiposIncidencias, function (tiposIncidencia) {
    tiposIncidencia.id = tiposIncidencia.tipo_incidencia_id; 
    tiposIncidencia.text = `
        ${tiposIncidencia.tipo_justificacion.nombre} — 
        Artículo: ${tiposIncidencia.articulo ?? "N/A"} — 
        Subartículo: ${tiposIncidencia.subarticulo ?? "N/A"} — 
        Intervalo: ${tiposIncidencia.intervalo_evaluacion.replace(/_/g, " ")} - 
        Sexo: ${tiposIncidencia.sexo == "F" ? "FEMENINO" : tiposIncidencia.sexo == "M" ? "MASCULINO" : "TODOS" } -
        Tipo de empleado: ${tiposIncidencia.tipo_empleado.replace(/_/g, " ")}`
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
    
    contenedorFechas.show();
    
    if (data.tipo_justificacion.identificador == "cambio_horario") {
        contenedorHorario.show();        
    } else {
        $("[name=horario_id]").val("");
        inicializaSelectHorario();
        contenedorHorario.hide();
    }
});

function inicializaSelectHorario() {
    var dataHorarios = $.map(horarios, function (horario) {
        horario.id = horario.horario_id; 
        horario.text = `
            ${horario.entrada} ${horario.salida ? " - " + horario.salida : ""} ·
        `;
        let dias = ``;
        horario.dias_formato_string.forEach(dia => {
            dias += `${dia} `;
        });
        if (horario.dias_festivos_son_laborales) {
            dias += ` Dias Festivos`;
        }
        horario.text += dias.trim();
        horario.text += ` · ${horario.tipo_empleado.replace(/_/g, " ")}`;
        return horario;
    });
    selectHorario.select2({
        placeholder: "Seleccione horario",
        data: dataHorarios
    });
}
inicializaSelectHorario();

// INICIA CONFIGURACIÓN DE FORMATTERS TABLA DETALLE TIPO INCIDENCIAS
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
// CONFIGURACIÓN DE FORMATTERS TABLA DETALLE INCIDENCIAS

// INICIA CONFIGURACIÓN DE FORMATTERS TABLA DETALLE FECHAS VÁLIDAS
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
// FINALIZA CONFIGURACIÓN DE FORMATTERS TABLA DETALLE FECHAS VÁLIDAS

const validatorFormFinalizarTarea = formFinalizarTarea.validate({
    submitHandler: function(form) {
        let empleados = tablaEmpleados.bootstrapTable("getData");
        if (empleados.length == 0) {
            swal.fire("Antes de continuar debe agregar a un grupo de empleados.", "", "warning");
            return false;
        }
        
        if (selectTipoIncidencia.select2('data')[0].tipo_justificacion.identificador != "cambio_horario" &&
            $("[name=total_dias]").val() == 0) {
            swal.fire("Antes de continuar debe agregar las fechas válidas para esta incidencia.", "", "warning");
            return false;
        }

        let sexoEmpleados = $("[name=sexo]").val();
        let sexoTipoIncidencia = selectTipoIncidencia.select2('data')[0].sexo;

        if (sexoTipoIncidencia != "TODOS") {
            if (sexoTipoIncidencia != sexoEmpleados) {
                swal.fire("Verifique que el sexo de los empleados concuerde con el tipo de incidencia seleccionado.", "", "warning");
                return false;
            }
        }

        let tipoEmpleadoEmpleados = $("[name=tipo_empleado]").val();
        let tipoEmpleadoIncidencia = selectTipoIncidencia.select2('data')[0].tipo_empleado;
        if (tipoEmpleadoIncidencia != "TODOS") {
            if (tipoEmpleadoIncidencia == "SINDICALIZADO") {
                if (!["SINDICALIZADO"].includes(tipoEmpleadoEmpleados)) {
                    swal.fire("Verifique que el tipo de empleados concuerde con el tipo de incidencia seleccionado.", "", "warning");
                    return false;
                }
            }
            if (tipoEmpleadoIncidencia == "NO_SINDICALIZADO") {
                if (!["NO_SINDICALIZADO", "NOMINA_8", "ESTRUCTURA"].includes(tipoEmpleadoEmpleados)) {
                    swal.fire("Verifique que el tipo de empleados concuerde con el tipo de incidencia seleccionado.", "", "warning");
                    return false;
                }
            }
        }

        if (selectTipoIncidencia.select2('data')[0].tipo_justificacion.identificador == "cambio_horario") {
            let tipoEmpleadoHorario = selectHorario.select2('data')[0].tipo_empleado;
            if (tipoEmpleadoEmpleados != tipoEmpleadoHorario) {
                swal.fire("Verifique que el tipo de los empleados concuerde con el tipo de empleado del horario.", "", "warning");
                return false;
            }
        }

        Swal.fire({
            title: "¿Está seguro?",
            text: "Antes de continuar, verifique que los datos ingresados sean correctos. Después de finalizar, no podrá regresar.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Sí, continuar",
            cancelButtonText: "Cancelar",
            reverseButtons: true
        }).then((result) => {
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