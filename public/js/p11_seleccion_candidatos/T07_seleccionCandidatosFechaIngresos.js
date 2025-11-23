$(document).ready(function() {
	$("label").addClass("titulo-dato");
});
var formIniciarProceso = $("#formFechaAltas");
var btnIniciarProceso = $("#btnFechaAltas");
var modal = $("#modal");
modal.inicializar({
	header : false,
	cuerpo : "<span class='align-middle'> Esta a punto de Finalizar con la tarea<b> 'Asignación de fecha de ingreso.</b> <br> ¿Está seguro de continuar?  </span>",
	submit : formIniciarProceso
});
btnIniciarProceso.click(function() {
	if (validator.form()) {
		modal.mostrarModal();
	}
});
var validator = $("#formFechaAltas").validate({
	rules : {
		fecha_alta : {
			date : false,
			required : true
		}
	},
	errorPlacement : function(error, element) {

		error.addClass("error");

		error.insertAfter(element);

	},
	errorClass : "error",
	validClass : "valid",
	messages : {
		fecha_alta : {
			required : "El campo no puede estar vacio"
		},
	}
});
