const formSeleccionarNotasBuenas = $("#seleccionar_notas_buenas");
const formFinalizarTarea = $("#form_finalizar_tarea");
const selectTipoAplicacion = $("[name=tipo_aplicacion]");
const selectFechasRetardosFaltas = $("[name=fechas_retardos_faltas]");
const selectNotasBuenas = $("[name=notas_buenas]");
const btnAgregarFecha = $("#btn_agregar_fecha")
const contenedorGeneral = $("#contenedor_general");
const contenedorFechas = $("#contenedor_fechas");
const contenedorNotasBuenas = $("#contenedor_notas_buenas");
const btnAgregarFechaChecador = $("#btn_agregar_fecha_checador");
const modalFechaChecador = $("#modal_fechas_checador");
const formAgregarFechaChecador = $("#form_agregar_fecha_checador");
const contenedorFechasRetardosFaltas = $("#contenedor_fechas_retardos_faltas");
const tablaNotasBuenas = $("#tabla_notas_buenas");

validatorFormFinalizarTarea = formFinalizarTarea.validate({
    submitHandler: function(form) {
        let aplicacionesNotasBuenas = tablaNotasBuenas.bootstrapTable('getData');
        if (aplicacionesNotasBuenas.length == 0) {
            Swal.fire("Para continuar, debe agregar al menos una aplicación de nota buena", "", "error");
            return;
        }
        $("[name=aplicaciones_notas_buenas]").val(JSON.stringify(aplicacionesNotasBuenas));
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

let validatorFormAgregarFechaChecador = formAgregarFechaChecador.validate({
    submitHandler: (form) => {
        nameInputDate = formAgregarFechaChecador.data("name-input-date");  
        $(`[name="${nameInputDate}"]`).val(moment(selectFechasRetardosFaltas.val()).format("DD-MM-Y")).trigger("change");
        modalFechaChecador.modal("hide");
    }
});

/* var respFechasRetardosFaltasConst = {}; */
var seSeleccionoTipoAplicacion = false;
/* var respFechasRetardosFaltas = {}; */
var respNotasBuenas = {};

validatorFormSeleccionarNotasBuenas = formSeleccionarNotasBuenas.validate({
    submitHandler: function (form) {
        var inputsFechas = $(form).find(".input-date").filter(function() {
            return /^fechas\[\d+\]$/.test($(this).attr("name"));
        }).toArray();
        
        var fechasSeleccionadas = inputsFechas.map(inputFecha => {
            return moment($(inputFecha).val(), "DD-MM-Y").format("Y-MM-DD");
        });

        // Obtener los valores del campo "intereses" en un array
        let tipoAplicacion = selectTipoAplicacion.val();
        /* let fechasSeleccionadas = selectFechasRetardosFaltas.val(); */
        let notasBuenasSeleccionadas = selectNotasBuenas.val();
        
        // COMPROBAR QUE TODAS LA FECHAS SELECCIONADA, SEA MAYOR A LAS 
        // FECHAS DE LOS SELLOS DE NOTAS BUENAS.
        let fechaSeleccionada = moment(fechasSeleccionadas[0], "Y-MM-DD");
        let esSuperior = true;
        notasBuenasSeleccionadas.forEach((item) => {
            let [mesYAnio] = item.split(" | ");
            let [mes, anio] = mesYAnio.split(" ");
            mes = meses.indexOf(mes.toUpperCase());
            let fechaNota = moment(new Date(anio, mes, 1)).startOf("month");
            if (fechaSeleccionada.isSameOrBefore(fechaNota, "month")) {
                esSuperior = false; 
            }
        });
        if (!esSuperior) {
            Swal.fire("Los sellos de nota buena debieron obtenerse antes de la fecha seleccionada", "", "error");
            return false;
        }
                
        let cumpleCondiciones = false;
        let mensajeError = ""; 
        if (tipoAplicacion == "RETARDO_LEVE") {
            if (fechasSeleccionadas.length >= 1 && fechasSeleccionadas.length <= 4) {
                if (notasBuenasSeleccionadas.length == 1) {
                    cumpleCondiciones = true;
                } else {
                    mensajeError = "Debe seleccionar una nota buena";
                }
            } else {
                mensajeError = "Debe seleccionar entre una y cuatro fechas";
            }
        } else if (tipoAplicacion == "RETARDO_GRAVE") {
            if (fechasSeleccionadas.length == 1) {
                if (notasBuenasSeleccionadas.length == 1) {
                    cumpleCondiciones = true;
                } else {
                    mensajeError = "Debe seleccionar una nota buena";
                }
            } else {
                mensajeError = "Debe seleccionar una fecha";
            }
        } else if (tipoAplicacion == "INASISTENCIA") {
            if (fechasSeleccionadas.length == 1) {
                if (notasBuenasSeleccionadas.length == 3) {
                    cumpleCondiciones = true;
                } else {
                    mensajeError = "Debe seleccionar tres notas buenas";
                }
            } else {
                mensajeError = "Debe seleccionar una fecha";
            }
        }

        /* return false; */

        if (cumpleCondiciones) {
            // Agregar en la tabla
            tablaNotasBuenas.bootstrapTable('insertRow', {
                index: 0,
                row: {
                    "id": Math.random().toString(16).slice(2) + (new Date()).getTime(),
                    "tipo_aplicacion": tipoAplicacion,
                    "fechas": fechasSeleccionadas,
                    "notas_buenas": notasBuenasSeleccionadas
                }
            });
            // Eliminar elementos seleccionados de los arrays de fechas y notas buenas
            /* respFechasRetardosFaltas[tipoAplicacion] = respFechasRetardosFaltas[tipoAplicacion].filter((fecha) => !fechasSeleccionadas.includes(fecha)); */
            notasBuenasSeleccionadas.forEach(notaBuena => {
                let periodo = notaBuena.split('|')[0].trim();
                let tipo = notaBuena.split('|')[1].trim();
                respNotasBuenas[periodo][tipo] = false;
            })
            // Reset form
            $(form).trigger("reset");
            validatorFormSeleccionarNotasBuenas.resetForm();  
            contenedorGeneral.hide(); 
            Swal.fire("Se agregó correctamente", "", "success");     
        } else {
            Swal.fire(mensajeError, "", "error");
        }
    }
});

selectTipoAplicacion.change(function() {
    let tipoAplicacion = $(this).val();
    validatorFormSeleccionarNotasBuenas.resetForm();  

    if (tipoAplicacion != "") {
        if (!seSeleccionoTipoAplicacion) {
            KTApp.blockPage({
                overlayColor: '#000000',
                state: 'danger',
                message: 'Están cargando las notas buenas. Por favor, espere...'
            });
            $.ajax({
                url: rutaGetNotasBuenas,
                type: 'GET',
            }).done(function (resp) {
                if (resp.estatus) {
                    seSeleccionoTipoAplicacion = true;
                    respNotasBuenas = resp.notasBuenasDisponibles;
                    /* respFechasRetardosFaltas = resp.fechaRetardosFaltas;
                    respFechasRetardosFaltasConst = Object.fromEntries(Object.entries(resp.fechaRetardosFaltas)); */
                    populateSelectNotasBuenas();
                    /* populateSelectFechasRetardosFaltas(tipoAplicacion); */
                    contenedorGeneral.show();
                } else {
                    swal.fire("", resp.mensaje, "error");
                }
            }).fail(function(jqXHR, textStatus, error) {
                swal.fire("", error, "error");
            }).always(function(jqXHR, textStatus, error) {
                KTApp.unblockPage();
            });              
        } else {
            limpiarCampoFechas();
            populateSelectNotasBuenas();
            /* populateSelectFechasRetardosFaltas(tipoAplicacion); */
            KTApp.unblockPage();
            contenedorGeneral.show();
        }
    } else {
        contenedorGeneral.hide();
    } 
});

btnAgregarFecha.on('click', function() {
    var repeater = $('.repeater');
    let tipoAplicacion = selectTipoAplicacion.val();
    var currentRepeats = repeater.find('.repeater-item').length;
    if (tipoAplicacion == "RETARDO_LEVE" && currentRepeats == 4) {
        swal.fire("Sólo se puede agregar un máximo de 4 fechas para retardos leves.", "", "warning");
        return false;
    } else if (tipoAplicacion == "RETARDO_GRAVE" && currentRepeats == 1) {
        swal.fire("Sólo se puede agregar una fecha como máximo para retardos graves.", "", "warning");
        return false;
    } else if (tipoAplicacion == "INASISTENCIA" && currentRepeats == 1) {
        swal.fire("Sólo se puede agregar una fecha como máximo para inasistencias.", "", "warning");
        return false;
    }
    repeater.append(`<div class="row repeater-item repeater-item-clone mt-4">
        <div class="col-10">
            <input type="text" name="fechas[${currentRepeats}]" class="form-control input-date" placeholder="Seleccionar fecha..." autocomplete="off" readonly required>
        </div>
        <div class="col-2">
            <button type="button" class="btn btn-light-danger btn-eliminar-fecha">
                <i class="fas fa-trash-alt pr-0"></i>
            </button>
        </div>
    </div>`);
    $('.input-date').datepicker({
        todayHighlight: true,
        language: 'es',
        format: 'dd-mm-yyyy',
        autoclose : true,
    });
});

contenedorFechas.on("change", ".input-date", function() {
    var selectedDate = $(this);
    var $otherDatepickers = $(".input-date").not(this);

    $otherDatepickers.each(function() {
        if ($(this).val() === selectedDate.val()) {
            swal.fire("Ya se ha agregado la fecha seleccionada", "", "warning");
            selectedDate.val("");
            return false;
        }
    });
    selectedDate.trigger("keyup");
});

contenedorFechas.on("click", ".btn-eliminar-fecha", function() {
    var repeaterItem = $(this).closest('.repeater-item');
    repeaterItem.slideUp(function() {
        $(this).remove();
    });
});

contenedorFechas.on("click", ".btn-agregar-fecha-checador", function() {
    let tipoAplicacion = selectTipoAplicacion.val();
    if (tipoAplicacion == "RETARDO_LEVE") {
        modalFechaChecador.find("#titulo_modal_fechas_checador").html("SELECCIONAR RETARDO LEVE");
    } else if (tipoAplicacion == "RETARDO_GRAVE") {
        modalFechaChecador.find("#titulo_modal_fechas_checador").html("SELECCIONAR RETARDO GRAVE");
    } else if (tipoAplicacion == "INASISTENCIA") {
        modalFechaChecador.find("#titulo_modal_fechas_checador").html("SELECCIONAR INASISTENCIA");
    }
    formAgregarFechaChecador.data("name-input-date", $(this).closest(".repeater-item").find(".input-date").attr("name"));  
    modalFechaChecador.modal("show");  
});

modalFechaChecador.on("hide.bs.modal", function (event) {
    formAgregarFechaChecador.trigger("reset");
    validatorFormAgregarFechaChecador.resetForm();  
})

  
selectNotasBuenas.on("mousedown", "option", function (e) {
    e.preventDefault();
    let tipoAplicacion = selectTipoAplicacion.val();
    let opcionSeleccionada = $(this);
    opcionSeleccionada.prop('selected', !opcionSeleccionada.prop('selected'));
    let opcionesSeleccionadas = selectNotasBuenas.val();
    
    if (["RETARDO_LEVE", "RETARDO_GRAVE"].includes(tipoAplicacion)) {
        if (opcionesSeleccionadas.length > 1) {
            opcionSeleccionada.prop("selected", false);
        }
    } else {
        if (opcionesSeleccionadas.length > 3) {
            opcionSeleccionada.prop("selected", false);
        }
    }
});

function populateSelectNotasBuenas() {
    let group = ``;
    $.each(respNotasBuenas, function (periodo, notasBuenas) { 
        group += `<optgroup label="${periodo}">`;
        $.each(notasBuenas, function (tipo, esValido) { 
            if (esValido) {
                group += `<option value="${periodo} | ${tipo}" class="text-dark"><strong>${tipo.replace(/_/g, " ")}</strong></option>`;
            } else {
                group += `<option value="${periodo} | ${tipo}" class="text-muted" disabled>${tipo.replace(/_/g, " ")}</option>`;
            }
        });
        group += `</optgroup>`;
    });
    selectNotasBuenas.html(group); 
}

/* function populateSelectFechasRetardosFaltas(tipoAplicacion) {
    let options = ``;
    if (respFechasRetardosFaltas[tipoAplicacion].length > 0) {
        respFechasRetardosFaltas[tipoAplicacion].sort((fecha1, fecha2) => parseDate(fecha2) - parseDate(fecha1));
        options += `<option value="">Selecciona una opción...</option>`;
        $.each(respFechasRetardosFaltas[tipoAplicacion], function (indice, fecha) { 
            options += `<option value="${fecha}" class="text-dark"><strong>${moment(fecha).format("DD-MM-Y")}</strong></option>`;
        });
    } else {
        options += '<option disabled selected>No hay fechas para mostrar...</option>';
    }
    selectFechasRetardosFaltas.html(options);
} */
function limpiarCampoFechas() {
    $(".repeater-item").find(`.input-date`).val("");
    $(".repeater-item-clone").remove();
}

function nbTipoApliacionFormatter(value, row) {
    return value.replace(/_/g, " ");
}

function nbFechasFormatter(value, row) {
    let fechas = ``;
    value.forEach(fecha => {
        fechas += moment(fecha).format("DD-MM-Y") + "<br>"; 
    });
    return fechas;
}

function nbNotasBuenasFormatter(value, row) {
    let notasBuenas = ``;
    value.forEach(notaBuena => {
        let periodo = notaBuena.split('|')[0].trim();
        let tipo = notaBuena.split('|')[1].trim();
        notasBuenas += `<strong>${periodo}</strong> ${tipo.replace(/_/g, " ")} <br>`; 
    });
    return notasBuenas;
}

function nbAccionesFormatter(value, row) {
    return `<button class="btn btn-outline-danger btn-icon eliminar" data-toggle="tooltip" title="Eliminar">
        <i class="far fa-trash-alt"></i>
    </button>`;
}

var operateEventsAcciones = {
    'click .eliminar': function (e, value, row, index) {
        tablaNotasBuenas.bootstrapTable('removeByUniqueId', row.id)
        // Agregar elementos seleccionados a los arrays de fechas y notas buenas
       /*  row.fechas.forEach(fecha => {
            if (respFechasRetardosFaltasConst[row.tipo_aplicacion].includes(fecha)) {
                respFechasRetardosFaltas[row.tipo_aplicacion].push(fecha);
            }
        }) */
        row.notas_buenas.forEach(notaBuena => {
            let periodo = notaBuena.split('|')[0].trim();
            let tipo = notaBuena.split('|')[1].trim();
            respNotasBuenas[periodo][tipo] = true;
        })

        if (selectTipoAplicacion.val() != "") {
            populateSelectNotasBuenas();
            /* populateSelectFechasRetardosFaltas(selectTipoAplicacion.val()); */
        }

        validatorFormSeleccionarNotasBuenas.resetForm();  
        swal.fire("Se eliminó correctamente", "", "success")
    }
}

function parseDate(dateString) {
    const [year, month, day] = dateString.split('-').map(Number);
    return new Date(year, month - 1, day);
}
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