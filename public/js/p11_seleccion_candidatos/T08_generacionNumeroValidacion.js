$(document).ready(function() {
	llenarTablaSeleccionCandidatos(datos1);
	$("label").addClass("titulo-dato");
});
function llenarTablaSeleccionCandidatos(data) {
	$("#tablaCandidatosSeleccionados").bootstrapTable({
		data : data,
		pagination : true,
		sortable : true,
		pageList : [ 5, 10, 25, 50 ]
	});
}
function guardarDatosTablas(e) {
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
var formIniciarProceso = $("#formNumeroValidacion");
var btnIniciarProceso = $("#btnNumeroValidacion");
var modal = $("#modal");
modal.inicializar({
	header : false,
	cuerpo : "<span class='align-middle'> Esta a punto de Finalizar con la tarea<b> 'Generación del número de validación.' <br> ¿Está seguro de continuar?  </span>",
	submit : formIniciarProceso
});
btnIniciarProceso.click(function() {
	modal.mostrarModal();
});