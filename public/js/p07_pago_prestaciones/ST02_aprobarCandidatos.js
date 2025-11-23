const tablaCandidatos = $("#table_reg_candidatos");
const cbEstatusAprobacion = $("#estatus_aprobacion");
const contenedorRechazo = $("#contenedor_rechazo");
const formFinalizarTarea = $("#form_finalizar_tarea");
const btnFinalizarTarea = $("#btn_finalizar_tarea");
const textAreaMsjRechazo = $("#comentarios_rechazo");

tablaCandidatos.bootstrapTable({data: candidatos});

tinymce.init({
	selector: '#comentarios_rechazo',
	toolbar: [
		'fontselect|fontsizeselect|bold italic underline|alignleft aligncenter alignright|bullist numlist'
	],
	statusbar: false,
	language : 'es_MX',
});

formFinalizarTarea.validate({
	errorPlacement: function(label, element) {
		if (element.attr("id") == "comentarios_rechazo") {
			var textAreaTinyMCE = element.next();
			if (label.text() != "") {
				textAreaTinyMCE.addClass('error');
			}
			textAreaTinyMCE.after(label);
		} else {
			element.addClass('error');
			label.insertAfter(element);
		}
	},
    submitHandler: function(form) {
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

cbEstatusAprobacion.change(function() {
	if ($(this).is(":checked")) {
		$(this).closest(".form-group").find(".col-form-label").html("Aprobar nómina");
		$(this).closest(".switch").removeClass("switch-danger");
		$(this).closest(".switch").addClass("switch-outline switch-icon switch-success");
		contenedorRechazo.hide();
	} else {
		$(this).closest(".form-group").find(".col-form-label").html("Rechazar nómina");
		$(this).closest(".switch").removeClass("switch-outline switch-icon switch-success");
		$(this).closest(".switch").addClass("switch-danger");
		contenedorRechazo.show();
	}
});

/* $(document).ready(function() {
	esquemaPrestacion(usuariosPrestacion);
	$('#tablaGeneral .detail-icon').each(function() {
	});
});
function esquemaPrestacion( datas ) {
	$("#tablaGeneralAprobacion").empty().append(inicializarCabeceraTablas());
	$("#tablaGeneral").bootstrapTable({
		pagination : true,
		sortable : true,
		data : datas,
		pageList : [ 5, 10, 25, 50 ]
	});


}
function inicializarCabeceraTablas() {
	var tablas = '<table class="table table-striped"' + '	id="tablaGeneral" '
			+ '	data-show-columns="false" data-unique-id="id" data-show-toggle="true" data-detail-view="true" data-detail-formatter="detailFormatter">' + '	<thead style="font-size:12px;">' + '		<tr>'
			+ '			<th data-field="id_empleado"><label for="" class="titulo-dato">No. Empleado</label></th>' + '			<th data-field="nombre"><label for="" class="titulo-dato">Nombre</label></th>'
			+ '			<th data-field="apellido_paterno"><label for="" class="titulo-dato">Apellido Paterno</label></th>'
			+ '			<th data-field="apellido_materno" data-events="operateEvents"><label for="" class="titulo-dato">Apellido Materno</label></th>'
			+ '			<th data-field="ua"><label for="" class="titulo-dato">Unidad Admva.</label></th>' + '			<th data-field="rfc"><label for="" class="titulo-dato">RFC</label></th>'
			+ '			<th data-field="curp"><label for="" class="titulo-dato">CURP</label></th>' + '			<th data-field="id_sindicato"><label for="" class="titulo-dato">Sección Sindical</label></th>';
	// for (key in columnasTablas) {
	// tablas += '<th data-field="' + columnasTablas[key].name + '"><label
	// for="" class="titulo-dato">' + columnasTablas[key].desc +
	// '</label></th>';
	// }

	tablas += '</tr></thead></table>';
	return tablas;
}
var formIniciarProceso = $("#formAprobacion");
var btnAprobar = $("#aprobar");
var btnRechazar = $("#rechazar");
var modal = $("#modal");
modal.inicializar({
	header : false,
	cuerpo : "<span class='align-middle'> Esta a punto de finalizar con la tarea <b>'Envío de nómina de prestaciones para aprobación '</b>. <br>¿Está seguro de continuar?  </span>",
	submit : formIniciarProceso
});
btnAprobar.click(function() {
	modal.mostrarModal();
});
btnRechazar.click(function() {
	modal.mostrarModal();
});

function detailFormatter( index, row ) {
	var html = []
	$.each(JSON.parse(row.campos_adicionales), function( key, value ) {
	});
	var contador = 0;
	var jsonCamposAdicionales = JSON.parse(row.campos_adicionales);
	var tablaLista = '<div class="row px-4 py-4">';
	for (key in jsonCamposAdicionales) {
		tablaLista += '<div class="col-md-3"><label for="" class="titulo-dato">' + columnasTablas[contador].desc + '</label></th>'
				+ '<input type="text" readonly class="form-control-plaintext" value="' + jsonCamposAdicionales[key] + '"></div>';
		contador++;
	}
	// tablaLista += '<label for="" class="titulo-dato">No. Empleado</label>'
	// '<input type="text" readonly class="form-control-plaintext"
	// id="staticEmail" value="';
	tablaLista += '</div>';
	return tablaLista;
}

$(".detail-icon").on('click', function() {
	($(this).find('i').hasClass('fa-plus') != true ? $(this).empty().append('<i class="material-icons">remove</i>') : $(this).empty().append('<i class="material-icons">add</i>'));
})
 */
