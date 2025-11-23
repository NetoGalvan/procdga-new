$(document).ready(function() {
	$("label").addClass("titulo-dato");
});
var validator = $("#formSeleccionComentarios").validate({
	rules : {
		comentarioDga : {
			required : true,
			campoNoVacio : "No puede enviar el campo vacio"
		},
		vacios : ' '
	},
	errorPlacement : function(error, element) {
		error.addClass("error");
		error.insertAfter(element);
	},
	messages : {
		comentarioDga : {
			required : "El campo no puede estar vacio"
		},
	}
});
function enviar(e) {
	e.preventDefault();
	return false;
}
function validacionSecretarios(value, row) {
	return ' <select class="form-control form-control-sm" id="titularSolicitante"'
			+ 'name="titularSolicitante" > <option value="-1">--Seleccióne--</option><option value="ACEPTADO">ACEPTADO</option><option value=RECHAZADO">RECHAZADO</option></select>';
}
function guardarComentarios() {
	if ($("#form1").valid()) {
		mensajeGuardadosTextos('mensajesDatosPersonales', 'error')
	}
}
var formIniciarProceso = $("#formSeleccionComentarios");
var btnIniciarProceso = $("#btnSeleccionComentarios");
var modal = $("#modal");
modal.inicializar({
	header : false,
	cuerpo : "<span class='align-middle'> Esta a punto de finalizar con la tarea <b>'Comentarios al candidato a ocupar la plaza de estructura.'</b>. <br> ¿Está seguro de continuar?  </span>",
	submit : formIniciarProceso
});
btnIniciarProceso.click(function() {
	if (validator.form()) {
		modal.mostrarModal();
	}
});
$.validator.addMethod("vacios", function(value, element, arg) {
	return arg == value;
}, 'Seleccione una Opcion Valida');