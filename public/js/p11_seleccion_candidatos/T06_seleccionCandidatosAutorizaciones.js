$(document).ready(function() {
	$("label").addClass("titulo-dato");
});
var formIniciarProceso = $("#formCandidatosAutorizaciones");
var btnIniciarProceso = $("#btnCandidatosAutorizaciones");
var modal = $("#modal");
modal.inicializar({
	header : false,
	cuerpo : "<span class='align-middle'> Esta a punto de Finalizar con la tarea<b>'Autorización del candidato a ocupar la plaza. <br> ¿Está seguro de continuar?  </span>",
	submit : formIniciarProceso
});
btnIniciarProceso.click(function() {
	if (validator.form()) {
		modal.mostrarModal();
	}
});
var validator = $("#formCandidatosAutorizaciones").validate({
	rules : {
		aceptacion_srio : {
			select : '-1',
			required : true
		}
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