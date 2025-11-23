var formIniciarProceso = $("#formCandidatosDescripcion");
var btnIniciarProceso = $("#btnAceptarDescripcion");
var modal = $("#modal");

modal.inicializar({
			header : false,
			cuerpo : "<span class='align-middle'> Esta a punto de iniciar el proceso <b>'Selección de Candidatos de Personal de Estructura'</b>. <br> Se creará un nuevo folio y la primer tarea del mismo. <br> ¿Está seguro de continuar?  </span>",
			submit : formIniciarProceso
		});
btnIniciarProceso.click(function() {
	modal.mostrarModal();
});
