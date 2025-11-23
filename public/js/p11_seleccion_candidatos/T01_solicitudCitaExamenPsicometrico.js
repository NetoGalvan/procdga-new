var table = $("#tablaCandidatos").bootstrapTable();
var alturaPaginas = $("main").height()
$(document).ready(function() {
    datosEmpleados();
    mensajeErrorListas(errores);
});
var formularios1 = $("#formCandidatos").validate({
    ignore: ".ignore",
    onfocusout: true,
    rules: {
        numPlaza: {
            select: '-1',
            required: true
        },
        titularSolicitante: {
            select: '-1',
            required: true
        },
        rfcs: {
            required: true,
            campoNoVacio: true
        },
        noempleados: {
            required: true,
            number: true,
            campoNoVacio: true
        }
    },
    errorPlacement: function(error, element) {
        error.addClass("error");
        error.insertAfter(element);
    },
    highlight: function(element, errorClass, validClass) {
        $(element).addClass("error").removeClass("valido");
    },
    unhighlight: function(element, errorClass, validClass) {
        $(element).addClass("valido").removeClass("error");
    },
    messages: {
        numPlaza: {
            required: "El campo no puede estar vacio"
        },
        noempleados: {
            required: "El campo no puede estar vacio",
            number: "Solo puede introducir numeros"
        },
        rfcs: {
            required: "El campo no puede estar vacio"
        }
    }
});
var filasTablas = [];
var ids = 0;

function llenarTablaCandidatos(rfc) {
    var rows = [];
    ids++;
    var rfc = $("#rfcs").val();
    var arr = obtenerArregloTablas();
    table.bootstrapTable('removeAll');
    consultaRfc(rfc).done(function(data) {
        if (data != "" && data != null) {
            arr.push({
                id: ids,
                nombre: data[0].nombre_candidato,
                apePaterno: data[0].apellido_paterno_candidato,
                apeMaterno: data[0].apellido_materno_candidato,
                rfc: data[0].rfc,
                homoclave: data[0].homoclave,
                en: 0
            });
        } else {
            arr.push({
                id: ids,
                rfc: rfc,
                en: 1
            });
        }
    });
    table.bootstrapTable('append', arr);
    $("#rfcs").val("");
}
var arreglosCandidatos1 = new Array();

function eliminarFila(id) {
    obtenerArregloTablas();
    table.bootstrapTable('remove', {
        field: 'id',
        values: id.toString()
    });
    for (var i = 0; i < arreglosCandidatos1.length; i++) {
        if (arreglosCandidatos1[i].id == id) {
            arreglosCandidatos1.splice(i, 1);
        }
    }
    table.bootstrapTable('removeAll');
    table.bootstrapTable('load', arreglosCandidatos1);
    $("#errorBusqueda").text("");
}

function tipoMovimientoFormatter(value, row) {
    return '<select class="form-control form-control-sm" id="tipoMovimientos" name="tipoMovimientos"><option>PROMOCION</option><option>NUEVO INGRESO</option><option>REINGRESO</option></select>';
}

function nombreFormatter(value, row) {
    return '<input class="form-control form-control-sm" type="text" id="nombre" value="' + (row.nombre != undefined ? row.nombre : "") + '" required>';
}

function apePaternoFormatter(value, row) {
    return '<input class="form-control form-control-sm" type="text" id="apePaterno" value="' + (row.apePaterno != undefined ? row.apePaterno : "") + '" required>';
}

function apeMaternoFormatter(value, row) {
    return '<input class="form-control form-control-sm" type="text" id="apeMaterno" value="' + (row.apeMaterno != undefined ? row.apeMaterno : "") + '" required>';
}

function rfcFormatter(value, row) {
    return '<input class="form-control form-control-sm" type="text" id="tipoMovimiento" value="' + (row.rfc != undefined ? row.rfc : "") + '" required>';
}

function homoclaveFormatter(value, row) {
    return '<input class="form-control form-control-sm" type="text" id="tipoMovimiento" value="' + (row.homoclave != undefined ? row.homoclave : "") + '" required>';
}

function observacionesFormatter(value, row) {
    return '<input class="form-control form-control-sm" type="text" id="tipoMovimiento" >';
}

function accionesFormatter(value, row) {
    return '<button type="button" class="btn btn-danger" onclick="eliminarFila(' + row.id + ')">Eliminar</button> ';
}
var correctos = false;

function obtenerDatosTablas() {
    var datos = table.bootstrapTable('getData');
    var tablas = $($("#tablaCandidatos").find('tbody')).find('tr');
    var arreglosCandidatos = [];
    if (formularios1.form()) {
        if (tablas.hasClass('no-records-found') != true) {
            correctos = true;
            for (var i = 0; i < tablas.length; i++) {
                var candidatos = new Object();
                candidatos.tiposMovimientos = $($($(tablas[i]).find('td')['0']).find('select')[0]).val();
                candidatos.nombre = $($($(tablas[i]).find('td')['1']).find('input')[0]).val();
                candidatos.apePaterno = $($($(tablas[i]).find('td')['2']).find('input')[0]).val();
                candidatos.apeMaterno = $($($(tablas[i]).find('td')['3']).find('input')[0]).val();
                candidatos.rfc = $($($(tablas[i]).find('td')['4']).find('input')[0]).val();
                candidatos.homoclave = $($($(tablas[i]).find('td')['5']).find('input')[0]).val();
                candidatos.observaciones = $($($(tablas[i]).find('td')['6']).find('input')[0]).val();
                arreglosCandidatos.push(candidatos);
            }
            $("#arregloTablaCandidatos").val(JSON.stringify(arreglosCandidatos));
            modal.mostrarModal();
        } else {
            mensajeError("se tienen que agregar un candidato");
        }
    }
    $("#rfcs").removeClass("ignore");
    $("#noempleados").removeClass("ignore");
    return correctos;
}

function obtenerArregloTablas() {
    arreglosCandidatos1 = [];
    var tablas = $($("#tablaCandidatos").find('tbody')).find('tr');
    var datos = table.bootstrapTable('getData');
    if (datos.length >= 1) {
        for (var i = 0; i < tablas.length; i++) {
            var candidatos = new Object();
            candidatos.id = datos[i].id;
            candidatos.tiposMovimientos = $($($(tablas[i]).find('td')['0']).find('select')[0]).val();
            candidatos.nombre = $($($(tablas[i]).find('td')['1']).find('input')[0]).val();
            candidatos.apePaterno = $($($(tablas[i]).find('td')['2']).find('input')[0]).val();
            candidatos.apeMaterno = $($($(tablas[i]).find('td')['3']).find('input')[0]).val();
            candidatos.rfc = $($($(tablas[i]).find('td')['4']).find('input')[0]).val();
            candidatos.homoclave = $($($(tablas[i]).find('td')['5']).find('input')[0]).val();
            candidatos.observaciones = $($($(tablas[i]).find('td')['6']).find('input')[0]).val();
            arreglosCandidatos1.push(candidatos);
        }
    }
    return arreglosCandidatos1;
}
var urPrincipal = window.location.origin;

function consultaRfc(rfc) {
    return $.ajax({
        url: urPrincipal + "/procesos/seleccion-candidatos/consulta-rfc/" + rfc,
        type: 'POST',
        async: false
    });
}

function mensajeErrorListas(mensajeError) {
    if (!$.isEmptyObject(mensajeError)) {
        $("body,html").animate({
            scrollTop: alturaPaginas
        }, 800);
        $("#errorMensajes").empty();
        for (var valores in mensajeError) {
            $("#errorMensajes").append('<div class="alert alert-danger" role="alert">' + mensajeError[valores] + '</div>');
        }
        $("#errorMensajes").fadeIn(2000);
        $("#errorMensajes").fadeOut(10000);
    }
}

function mensajeError(mensajeError) {
    $("body,html").animate({
        scrollTop: alturaPaginas
    }, 800);
    window.scrollTo(0, alturaPaginas);
    $("#errorMensajes").empty();
    $("#errorMensajes").append('<div class="alert alert-danger" role="alert">' + mensajeError + '</div>');
    $("#errorMensajes").fadeIn(1000);
    $("#errorMensajes").fadeOut(2500);
}
$.validator.addMethod("select", function(value, element, arg) {
    return arg !== value;
}, 'Seleccione una opcion valida');
$.validator.addMethod("RFC", function(value, element) {
    if (value !== '') {
        var patt = new RegExp(rexp);
        return patt.test(value);
    } else {
        return false;
    }
}, "Ingrese un RFC valido");

function validarCampoRfcs(data) {
    var rfc = $(data).val().trim().toUpperCase();
    $(data).val(rfc);
    var rfcCorrecto = rfcValido(rfc);
    if (rfcCorrecto) {
        agregarMensajesValidos("RFC Correcto");
    } else {
        var id11 = $(data.target)[0]
        if (rfc.length <= 0) {
            $(data).removeClass("errorRfc");
            $(".invalid-tooltip").hide();
        } else {
            agregarMensajes("RFC incorrecto");
        }
    }
}

function rfcExp(rfc) {}

function rfcValido(rfc, aceptarGenerico = true) {
    const re = /^([A-ZÑ&]{3,4}) ?(?:- ?)?(\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])) ?(?:- ?)?([A-Z\d]{2})([A\d])$/;
    var validado = rfc.match(re);
    if (!validado) return false;
    const digitoVerificador = validado.pop(),
        rfcSinDigito = validado.slice(1).join(''),
        len = rfcSinDigito.length,
        diccionario = "0123456789ABCDEFGHIJKLMN&OPQRSTUVWXYZ Ñ",
        indice = len + 1;
    var suma, digitoEsperado;
    if (len == 12) suma = 0
    else suma = 481;
    for (var i = 0; i < len; i++) suma += diccionario.indexOf(rfcSinDigito.charAt(i)) * (indice - i);
    digitoEsperado = 11 - suma % 11;
    if (digitoEsperado == 11) digitoEsperado = 0;
    else if (digitoEsperado == 10) digitoEsperado = "A";
    if ((digitoVerificador != digitoEsperado) && (!aceptarGenerico || rfcSinDigito + digitoVerificador != "XAXX010101000")) return false;
    else if (!aceptarGenerico && rfcSinDigito + digitoVerificador == "XEXX010101000") return false;
    return rfcSinDigito + digitoVerificador;
}

function agregarMensajes(mensaje) {
    $("#rfcs").removeClass("validoRfc");
    $("#rfcs").addClass("errorRfc");
    $("#rfcs").removeClass("is-invalid");
    $("#validos").hide();
    $("#invalidos").val('');
    $("#invalidos").empty();
    $("#invalidos").append(mensaje);
    $("#invalidos").fadeIn(1000);
}

function agregarMensajesValidos(mensaje) {
    $("#rfcs").removeClass("errorRfc");
    $("#rfcs").addClass("validoRfc");
    $("#invalidos").hide();
    $("#validos").empty();
    $("#validos").append(mensaje);
    $("#validos").fadeIn(1000);
}
var formIniciarProceso = $("#formCandidatos");
var btnIniciarProceso = $("#solicitarCitas");
var modal = $("#modal");
modal.inicializar({
    header: false,
    cuerpo: "<span class='align-middle'> Esta a punto de finalizar la  tarea <b>'Solicitud de examen psicométrico de candidatos a plaza de estructura '</b>.  <br> ¿Está seguro de continuar?  </span>",
    submit: formIniciarProceso
});
btnIniciarProceso.click(function() {
    $("#rfcs").addClass("ignore");
    $("#noempleados").addClass("ignore");
    obtenerDatosTablas();
});

function empleados(empleado) {
    return $.ajax({
        url: urlEmpleadosCandidatos,
        type: 'POST',
        data: empleado,
        async: false
    });
}

function c() {
    $("#candidatoRfc").click(function() {
        var empleado = new Object();
        empleado.rfc = $("#rfcs").val();
        empleado.numero_empleado = $("#noempleados").val();
        empleado.campos_requeridos = ['numero_empleado', 'rfc', 'nombre_completo', 'unidad_administrativa', 'seccion_sindical', 'curp', 'primer_apellido', 'segundo_apellido', 'nombre_empleado'];
        empleados(empleado).done(function(data) {
            if (data.hasOwnProperty('original')) {
                var datosEmpleadosInfos = data.original;
                if (!datosEmpleadosInfos.hasOwnProperty('error')) {
                    llenarCamposEmpleadosAjax(datosEmpleadosInfos);
                } else {}
            } else {
                llenarCamposEmpleados(data[0]);
            }
        });
    });
}

function datosEmpleados() {
    $("#candidatoRfc").click(function() {
        var numEmpleados = formularios1.element("#noempleados");
        var rfcs = formularios1.element("#rfcs");
        validarCampoRfcs($("#rfcs"));
        if (rfcs && $("#rfcs").hasClass("validoRfc") == true && numEmpleados) {
            if (table.bootstrapTable('getData').length < 2) {
                var rows = [];
                ids++;
                var rfc = $("#rfcs").val();
                var arr = obtenerArregloTablas();
                table.bootstrapTable('removeAll');
                var empleado = new Object();
                empleado.rfc = $("#rfcs").val();
                empleado.numero_empleado = $("#noempleados").val();
                empleado.campos_requeridos = ['numero_empleado', 'rfc', 'nombre_completo', 'unidad_administrativa', 'seccion_sindical', 'curp', 'primer_apellido', 'segundo_apellido', 'nombre_empleado'];
                empleados(empleado).done(function(data) {
                    if (!$.isEmptyObject(data)) {
                        if (data.hasOwnProperty('original')) {
                            var datosEmpleadosInfos = data.original;
                            if (!datosEmpleadosInfos.hasOwnProperty('error')) {
                                arr.push({
                                    id: ids,
                                    nombre: datosEmpleadosInfos.nombre_empleado,
                                    apePaterno: datosEmpleadosInfos.primer_apellido,
                                    apeMaterno: datosEmpleadosInfos.segundo_apellido,
                                    rfc: datosEmpleadosInfos.rfc,
                                    homoclave: "rfc",
                                    en: 0
                                });
                            } else {
                                arr.push({
                                    id: ids,
                                    rfc: rfc,
                                    en: 1
                                });
                            }
                        } else {
                            arr.push({
                                id: ids,
                                nombre: data[0].nombre_candidato,
                                apePaterno: data[0].apellido_materno_candidato,
                                apeMaterno: data[0].apellido_paterno_candidato,
                                rfc: data[0].rfc,
                                homoclave: "rfc",
                                en: 0
                            });
                        }
                    } else {
                        arr.push({
                            id: ids,
                            rfc: rfc,
                            en: 1
                        });
                    }
                });
                table.bootstrapTable('append', arr);
                $("#rfcs").val("");
                $("#noempleados").val("");
                $("#rfcs").removeClass("errorRfc");
                $("#invalidos").hide();
                $("#noempleados").removeClass("is-invalid");
            } else {
                agregarMensajes("No puede ser mayor a dos candidatos");
                $("#rfcs").removeClass("errorRfc");
                $("#rfcs").val('');
            }
        } else {
            $("#invalidos").hide();
            agregarMensajes("El campo esta vacio o es incorrecto");
        }
    });
}