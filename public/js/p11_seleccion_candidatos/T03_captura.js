var urPrincipal = window.location.origin;
var id_candidato = $("#candidato_id").val()
var arrayGrafica = new Array();
$(document).ready(function() {
	$(function() {
		$('[data-toggle="tooltip"]').tooltip()
	})
	$.validator.addMethod("select", function(value, element, arg) {
		return arg !== value;
	}, 'Seleccione una Opcion Valida');
	$.validator.addMethod("CURP", function(value, element) {
		if (value !== '') {
			var patt = new RegExp("^[A-Z][A,E,I,O,U,X][A-Z]{2}[0-9]{2}[0-1][0-9][0-3][0-9][M,H][A-Z]{2}[B,C,D,F,G,H,J,K,L,M,N,Ñ,P,Q,R,S,T,V,W,X,Y,Z]{3}[0-9,A-Z][0-9]$");
			return patt.test(value);
		} else {
			return false;
		}
	}, "Ingrese una CURP valido");
	$.validator.addMethod("CodigoPostal", function(value, element) {
		if (value !== '') {
			var patt = new RegExp("^[0-9]{5}$");
			return patt.test(value);
		} else {
			return false;
		}
	}, "Ingrese una Código Postal valido");
	llenarTablaSeleccionCandidatos(datos1);
	$("label").addClass("titulo-dato");
	$("#datosCandidatosBoton").click(function() {
		var url = $("#datosUsuarios").attr('action')
		if ($("#datosUsuarios").valid()) {
			guardarDatosEmpleados($("#datosUsuarios").serialize(), url).always(function(data, textStatus, jqXHR) {
				mensajeGuardadosTextos('mensajesDatosPersonales', textStatus);
			});
		} else {
			mensajeGuardadosTextos('mensajesDatosPersonales', 'error')
		}
	});
	$("#datosCandidatosEval").click(function() {
		var url = $("#evaluaciones").attr('action')
		guardarDatosEmpleados($("#evaluaciones").serialize(), url).always(function(data, textStatus, jqXHR) {
			mensajeGuardadosTextos('mensajesEscalaz', textStatus);
		});
		;
	});
	$("#graficar").click(function() {
		arrayGrafica = [];
		$("#validez select").each(function() {
			if ($(this).val() == "N.A.") {
				arrayGrafica.push(0)
			} else {
				arrayGrafica.push($(this).val())
			}
		});
		tablas();
		graficarLoader();
	});
	$(".show-toast").click(function() {
		$("#myToast").toast('show');
	});
	tamanoLetras();
});
var validator = $("#datosUsuarios").validate({
	rules : {
		apePaterno : "required",
		apeMaterno : "required",
		nombre : "required",
		fhNacimiento : {
			required : true,
			date : false
		},
		edad : {
			required : true,
			number : true
		},
		sexo : {
			select : '-1'
		},
		estadoCivil : {
			select : '-1'
		},
		escolaridad : "required",
		puestoActual : "required",
		tipoMovimiento : "required",
		motivoEvaluacion : "required",
		folioContraloria : "required",
		elabora : "required",
		fhEvaluacion : {
			required : true,
			date : false
		},
		aceptacion_eval : "required",
		sintesisEvaluacion : "required",
	},
	errorPlacement : function(error, element) {
		error.addClass("error");
		element.addClass('letraPequeña');
		error.insertAfter(element);
	},
	errorClass : "error",
	validClass : "valid",
	messages : {
		apePaterno : {
			required : "El campo no puede estar vacio"
		},
		apeMaterno : {
			required : "El campo no puede estar vacio"
		},
		nombre : {
			required : "El campo no puede estar vacio"
		},
		fhNacimiento : {
			required : "El campo no puede estar vacio"
		},
		edad : {
			required : "El campo no puede estar vacio",
			number : "El valor debe ser numerico"
		},
		escolaridad : {
			required : "El campo no puede estar vacio"
		},
		puestoActual : {
			required : "El campo no puede estar vacio"
		},
		tipoMovimiento : {
			required : "El campo no puede estar vacio"
		},
		motivoEvaluacion : {
			required : "El campo no puede estar vacio"
		},
		folioContraloria : {
			required : "El campo no puede estar vacio"
		},
		elabora : {
			required : "El campo no puede estar vacio"
		},
		fhEvaluacion : {
			required : "El campo no puede estar vacio"
		},
		aceptacion_eval : {
			required : "El campo no puede estar vacio"
		},
		sintesisEvaluacion : {
			required : "El campo no puede estar vacio"
		}
	}
});
function guardarDatosEmpleados(data, url) {
	return $.ajax({
		url : url,
		type : 'POST',
		data : data,
		async : true
	});
}
function datoEmpleados(seleccionCandidatoId, candidato) {
	return $.ajax({
		url : candidatos + "/procesos/seleccion-candidatos/datos-candidato/" + seleccionCandidatoId + '/' + candidato,
		type : 'POST',
		async : true
	});
}
function catalogoEstadoCivil() {
	return $.ajax({
		url : estadoCivil,
		type : 'POST',
		async : true
	});
}
function getNivelesEstudios() {
	return $.ajax({
		url : urlNivelesEstudios,
		type : 'POST',
		async : true
	});
}
function catalogoSexos() {
	return $.ajax({
		url : urlSexos,
		type : 'GET',
		async : true
	});
}
function mensajeGuardadosTextos(idElementos, estatusValidaciones) {
	$("#" + idElementos).empty();
	if (estatusValidaciones != 'error') {
		$("#" + idElementos).append("<div class='alert alert-success form-control-sm' role='alert' style='padding:4px !important;text-align:center !important'>Se guardo correctamente</div>");
	} else {
		$("#" + idElementos).append("<div class='alert alert-danger form-control-sm' role='alert' style='padding:4px !important; text-align:center !important'>Ocurrio un error al guardar</div>");
	}
	$("#" + idElementos).fadeIn(500);
	$("#" + idElementos).fadeOut(2000);
}
function llenarSexos() {
	$("#sexo").empty();
	$("#sexo").append("<option value='-1'>Seleccione por favor</option>");
	catalogoSexos().done(function(data) {
		$.each(data, function(index, value) {
			$("#sexo").append("<option value='" + value.idsexo + "'>" + value.sexo + "</option>");
		});
	});
}
function llenarEstadoCivil() {
	$("#estadoCivil").empty();
	$("#estadoCivil").append("<option value='-1'>Seleccione por favor</option>");
	catalogoEstadoCivil().done(function(data) {
		$.each(data, function(index, value) {
			$("#estadoCivil").append("<option value='" + value.estado_civil_id + "'>" + value.estado_civil + "</option>");
		});
	});
}
function tablas() {
	var ctx = document.getElementById('myChart').getContext('2d');
	var myChart = new Chart(ctx, {
		type : 'bar',
		data : {
			labels : [ 'L', 'F', 'K', 'HS', 'D', 'HI', 'DP', 'MF', 'PO', 'PT', 'ES', 'MA', 'LS', 'ANS', 'MIE', 'OBS', 'DEP', 'SAU', 'DEL', 'ENJ', 'CIN', 'PAS', 'PTA', 'BAE', 'ISO', 'FAM', 'DTR',
					'RTR', 'A', 'R', 'FYO', 'AMAC', 'HR', 'DO', 'DPR', 'RS' ],
			datasets : [ {
				label : '# Valor de',
				data : arrayGrafica,
				borderWidth : 1
			} ]
		},
		options : {
			responsive : true,
			maintainAspectRatio : false,
			scales : {
				yAxes : [ {
					ticks : {
						min : 0,
						max : 120,
						stepSize : 10
					},
					xAxes : [ {
						barPercentage : 0.5,
						barThickness : 6,
						maxBarThickness : 8,
						minBarLength : 2,
						gridLines : {
							offsetGridLines : true
						}
					} ]
				} ]
			},
			legend : {
				labels : {
					fontColor : 'black',
					FontSize : '5px'
				}
			}
		}
	});
}
function llenarNiveles() {
	$("#escolaridad").empty();
	$("#escolaridad").append("<option value='-1'>Seleccione por favor</option>");
	getNivelesEstudios().done(function(data) {
		$.each(data, function(index, value) {
			$("#escolaridad").append("<option value='" + value.nivel_estudio_id + "'>" + value.nivel_estudio + "</option>");
		});
	});
}
function llenarSelects() {
	$("#validez select").each(function() {
		$(this).empty();
		$(this).append("<option value='N.A.'>N.A.</option>");
		for (var i = 30; i <= 120; i++) {
			$(this).append("<option value='" + i + "'>" + i + "</option>");
		}
	});
}
function tamanoLetras() {
	$("#datosUsuarios label").each(function() {
		$(this).addClass('tamanoLetras');
	});
}
function graficarLoader() {
	$("#graficarCargar").empty();
	$("#graficarCargar").append('<div class="spinner-border text-success" role="status" style="display:none" id="loaderCargados"><span class="sr-only form-control-sm">Loading...</span></div>');
	$("#loaderCargados").fadeIn(500);
	$("#loaderCargados").fadeOut(1000);
}
function abrirModal(candidato_id) {
	var candidatosModal = candidato_id;
	$("#candidato_id").val("");
	$("#candidato_id").val(candidatosModal);
	$("#candidato_id_1").val(candidatosModal);
	$('#datosCandidatos').modal('show')
	limpiarCampos();
	tablas();
	llenarNiveles();
	llenarSexos();
	llenarEstadoCivil();
	llenarSelects();
	llenarCamposCandidatos(candidatosIds.seleccion_candidato_id, candidatosModal);
}
function llenarCamposCandidatos(seleccionCandidatoId, candidatos) {
	datoEmpleados(seleccionCandidatoId, candidatos).done(function(data) {
		if (data != '') {
			$("#nombre").val(data.nombre_candidato);
			$("#apePaterno").val(data.apellido_paterno_candidato);
			$("#apeMaterno").val(data.apellido_materno_candidato);
			$("#fhNacimiento").val(data.fecha_nacimiento);
			$("#sexo").val((data.sexo_id != null ? data.sexo_id : '-1'));
			$("#edad").val(data.estado_civil_id != null ? data.estado_civil_id : '-1');
			$("#escolaridad").val(data.estado_civil_id != null ? data.estado_civil_id : '-1');
			$("#estadoCivil").val(data.estado_civil_id != null ? data.estado_civil_id : '-1');
			$("#estadoCivil").val(data.estado_civil_id != null ? data.estado_civil_id : '-1');
			$("#estadoCivil").val(data.estado_civil_id != null ? data.estado_civil_id : '-1');
			$("#estadoCivil").val(data.estado_civil_id != null ? data.estado_civil_id : '-1');
			$("#estadoCivil").val(data.estado_civil_id != null ? data.estado_civil_id : '-1');
			$("#estadoCivil").val(data.estado_civil_id != null ? data.estado_civil_id : '-1');
			$("#estadoCivil").val(data.estado_civil_id != null ? data.estado_civil_id : '-1');
			$("#estadoCivil").val(data.estado_civil_id != null ? data.estado_civil_id : '-1');
			$("#estadoCivil").val(data.estado_civil_id != null ? data.estado_civil_id : '-1');
		}
	});
}
function cerrarModal() {
	validator.resetForm();
	$('#datosCandidatos').modal('hide');
}
function limpiarCampos() {
	$("#datosUsuarios input,#datosUsuarios select, #datosUsuarios textarea").each(function(index, value) {
		if (value.name != '_token' && value.tagName != 'SELECT' && value.name != 'candidato_id') {
			$(value).val('');
		} else if (value.tagName == 'SELECT') {
			$(value).val('-1')
		}
	});
}
function llenarTablaSeleccionCandidatos(data) {
	$("#tablaCandidatosSeleccionados").bootstrapTable({
		data : data,
		pagination : true,
		sortable : true,
		pageList : [ 5, 10, 25, 50 ]
	});
}
function guardarDatosTablas() {
	var tablas = $($("#tablaCandidatosSeleccionados").find('tbody')).find('tr');
	var arreglosCandidatos = [];
	var encontrados;
	var datosColumnas = $("#tablaCandidatosSeleccionados").bootstrapTable('getData');
	correctos = true;
	for (var i = 0; i < tablas.length; i++) {
		var candidatos = new Object()
		candidatos.seleccion_candidato_id = datosColumnas[i].seleccion_candidato_id;
		candidatos.candidato_id = datosColumnas[i].candidato_id;
		candidatos.validacionSecretarios = $($($(tablas[i]).find('td')['4']).find('select')[0]).val();
		encontrados = (candidatos.validacionSecretarios != '-1' ? true : false);
		arreglosCandidatos.push(candidatos);
	}
	if (!encontrados) {
		return e.preventDefault();
	} else {
		$("#arregloTablaCandidatosSeleccionados").val(JSON.stringify(arreglosCandidatos));
	}
}
function enviar(e) {
	e.preventDefault();
	return false;
}
function validacionSecretarios(value, row) {
	return ' <select class="form-control form-control-sm" id="titularSolicitante"'
			+ 'name="titularSolicitante" > <option value="-1">--Seleccióne--</option><option value="RECHAZADO">RECHAZADO</option><option value="VALIDADO">VALIDADO</option></select>';
}
function nombreCandidatos(value, row) {
	return '<b><h6>' + row.nombre_candidato + ' ' + row.apellido_paterno_candidato + ' ' + row.apellido_materno_candidato + '</h6></b>' + '<h9 class="colorLetras"> RFC : ' + row.rfc + '</h9>';
}
function datosDeLaPlazas(value, row) {
	return '<p><span class="colorLetras">Numero:</span> <b>' + row.plaza.numero_plaza + '</b></p>' + '<p><span class="colorLetras">Codigo:</span> <b>' + row.plaza.codigo_puesto + ' '
			+ row.plaza.denominacion_puesto + '</b></p>' + '<p><span class="colorLetras">Adscripcion:</span> <b>' + row.unidad + '</b></p>'
}
function editarCandidatos(value, row) {
	return '<div class="d-flex justify-content-center"><button type="button" class="btn btn-primary btn-sm" onclick="abrirModal(' + row.candidato_id + ')">Editar</button></div>';
}
function reportes(value, row) {
	return '<button class="btn btn-primary btn-sm">Descargar</button>';
}
var formIniciarProceso = $("#capturaResultadosExamenes");
var btnIniciarProceso = $("#btnCapturaResultados");
var modal = $("#modal");
modal.inicializar({
	header : false,
	cuerpo : "<span class='align-middle'> Esta a punto de terminar la tarea <b>'Captura de resultados de examen psicométrico'</b>.  <br> ¿Está seguro de continuar?  </span>",
	submit : formIniciarProceso
});
btnIniciarProceso.click(function() {
	guardarDatosTablas();
	modal.mostrarModal();
});
