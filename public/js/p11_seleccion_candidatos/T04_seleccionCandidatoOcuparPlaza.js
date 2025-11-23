$(document).ready(function() {
	llenarTablaSeleccionCandidatos(datos1);
	mensajeErrorListas(mensajeErrores);
	$("label").addClass("titulo-dato");
});
var alturaPaginas = $("main").height()
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
	var candidatoValidos = 0;
	var encontrados;
	var datosColumnas = $("#tablaCandidatosSeleccionados").bootstrapTable('getData');
	correctos = true;
	for (var i = 0; i < tablas.length; i++) {
		var candidatos = new Object()
		candidatos.seleccion_candidato_id = datosColumnas[i].seleccion_candidato_id;
		candidatos.candidato_id = datosColumnas[i].candidato_id;
		candidatos.validacionSecretarios = $($($(tablas[i]).find('td')['5']).find('select')[0]).val();
		candidatoValidos = (candidatos.validacionSecretarios == 'ACEPTADO' ? candidatoValidos = candidatoValidos + 1 : candidatoValidos = candidatoValidos + 0);
		arreglosCandidatos.push(candidatos);
	}
	$("#arregloTablaCandidatosSeleccionados").val(JSON.stringify(arreglosCandidatos));
}
function enviar(e) {
	e.preventDefault();
	return false;
}
function validacionSecretarios(value, row) {
	return ' <select class="form-control form-control-sm" id="titularSolicitante"'
			+ 'name="titularSolicitante" > <option value="-1">--Seleccióne--</option><option value="ACEPTADO">ACEPTADO</option><option value=RECHAZADO">RECHAZADO</option></select>';
}
function mensajeError(mensajeError) {
	$("#mensajeError").empty();
	$("#mensajeError").append('<div class="alert alert-danger" role="alert">' + mensajeError + '</div>');
	$("#mensajeError").fadeIn(2000);
	$("#mensajeError").fadeOut(20000);
}
function mensajeErrorListas(mensajeError) {
	if (!$.isEmptyObject(mensajeError)) {
		$("body,html").animate({
			scrollTop : alturaPaginas
		}, 800);
		$("#errorMensajes").empty();
		for ( var valores in mensajeError) {
			$("#errorMensajes").append('<div class="alert alert-danger" role="alert">' + mensajeError[valores] + '</div>');
		}
		$("#errorMensajes").fadeIn(2000);
		$("#errorMensajes").fadeOut(10000);
	}
}
var formIniciarProceso = $("#formSeleccionCandidatos");
var btnIniciarProceso = $("#btnSeleccionCandidatos");
var modal = $("#modal");
modal.inicializar({
	header : false,
	cuerpo : "<span class='align-middle'> Esta a punto de finalizar la tarea <b>'Selección del candidato a ocupar la plaza.'</b>. <br> ¿Está seguro de continuar?  </span>",
	submit : formIniciarProceso
});
btnIniciarProceso.click(function() {
	guardarDatosTablas();
	modal.mostrarModal();
});