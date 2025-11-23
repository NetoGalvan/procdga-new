var modalDatosCandidato = $('#modalDatosCandidatos');

$(document).ready(function () {
    llenarTablaSeleccionCandidatos(candidatoSelecionado);
});

function llenarTablaSeleccionCandidatos(data) {
	$("#tablaCandidatosSeleccionados").bootstrapTable({
		data : [data],
		pagination : true,
		sortable : true,
		pageList : [ 5, 10, 25, 50 ]
	});
}

/* Formatter para info del Candidato */
function infoCandidatoFormatter(value, row) {
    return  '<p><b>'+ row.nombre_candidato + ' ' + row.apellido_paterno_candidato + ' ' + row.apellido_materno_candidato +'</b><p>' +
            '<p>'+ row.rfc +'</p>' ;
}

/* Formatter para info del examen de evaluación para el Candidato */
function infoEvaluacionFormatter(value, row) {
    return  '<p>Dia:<b> ' + row.fecha_cita + '</b></p>' +
            '<p>Hora:<b> ' + row.hora_cita + ' hrs.</b></p>' +
            '<p>Lugar:<b> ' + row.lugar_cita + '</b></p>';
}

/* Formatter para datos de la Plaza del Candidato */
function datosDeLaPlazasFormatter(value, row) {
	return  '<p>Número:<b> ' + row.plaza.numero_plaza + '</b></p>' +
            '<p>Código:<b> ' + row.plaza.codigo_puesto + '</b></p>' +
            '<p>Puesto:<b> ' + row.plaza.denominacion_puesto + '</b></p>' +
            '<p>Adscripcion:<b> ' + row.unidad + '</b></p>' ;
}

/* Formatter para datos de la Plaza del Candidato */
function editarCandidatoFornatter(value, row) {
	return '<button type="button" class="btn btn-light-success font-weight-bold btn-md" onclick="abrirModal(' + row.candidato_id + ')"> <i class="far fa-edit"></i> </button>';
}

/* Formatter para generar reporte del Examen del Candidato */
function reportesFormatter(value, row) {
	return '<button type="button" class="btn btn-light-danger font-weight-bold btn-md" onclick="abrirModal(' + row.candidato_id + ')"> <i class="far fa-file-pdf"></i> </button>';
}

/* Función para desplegar la información del Candidato en el Modal */
function abrirModal(candidato_id) {
	var candidatosModal = candidato_id;
	$("#candidato_id").val("");
	$("#candidato_id").val(candidatosModal);
	$("#candidato_id_1").val(candidatosModal);
	modalDatosCandidato.modal('show')
	/* limpiarCampos();
	tablas();
	llenarNiveles();
	llenarSexos();
	llenarEstadoCivil();
	llenarSelects();
	llenarCamposCandidatos(candidatosIds.seleccion_candidato_id, candidatosModal); */
}

/* Función para cerrar el Modal */
function cerrarModal() {
	// validator.resetForm();
	modalDatosCandidato.modal('hide');
}
