const formAgregarEmpleado = $("#form_agregar_candidato");
const inputNumeroEmpleado = $("#numero_empleado");
const inputNombreEmpleado = $("#nombre_empleado");
const inputApellidoPaterno = $("#apellido_paterno");
const inputApellidoMaterno = $("#apellido_materno");
const inputUnidadAdministrativa = $("#nombre_unidad");
const inputSeccionSindical = $("#seccion_sindical");
const inputRFC = $("#rfc");
const inputCURP = $("#curp");
const btnAgregarCandidato = $("#btn_agregar_candidato");
const tablaCandidatos = $("#table_reg_candidatos");
const btnFinalizarTarea = $("#btn_finalizar_tarea");
const formFinalizarTarea = $("#form_finalizar_tarea");
var candidato = {};

$(document).ready(function () {

    // Valida si existen Candidatos
    if ( candidatos.length > 0 ){
        tablaCandidatos.bootstrapTable("destroy");
        tablaCandidatos.bootstrapTable({data: candidatos});
    } else {
        tablaCandidatos.bootstrapTable();
    }

});


const validadorFormAgregarEmpleado = formAgregarEmpleado.validate({
	onfocusout: false,
	rules: {
		numero_empleado: {
			required: true,
			number: true
		},
		nombre_empleado: {
			required: true,
		},
		primer_apellido: {
			required: true,
		},
		segundo_apellido: {
			required: true,
		},
		nombre_unidad: {
			required: true,
		},
		seccion_sindical: {
			required: true,
		},
		rfc: {
			RFC: true,
			required: true,
		},
		curp : {
			required: true,
		}
	},
	errorPlacement: function(label, element) {
		element.addClass('error');
		label.insertAfter(element);
	},
	onsubmit: false
});

$("#formularioDatos").html(crearFormularios('normal'));
$("#editarDatosEmpleados").html(crearFormularios('modal'));
$('.input-date').datepicker({
	format : 'dd/mm/yyyy',
	autoclose : true,
	language : 'es'
}).on('changeDate', function() {
	validadorFormAgregarEmpleado.element(this);
});

btnAgregarCandidato.click(function() {
	fieldsPrestacion.forEach(field => {
		$(`#${field.name}`).rules("add", {required: true});
	});
	if (validadorFormAgregarEmpleado.form()) {
		Swal.fire({
			title: "¿Está seguro de continuar?",
			text: "Asegurese de que los datos ingresados son correctos",
			icon: "warning",
			showCancelButton: true,
			confirmButtonText: "Sí, continuar",
			cancelButtonText: "Cancelar",
			reverseButtons: true
		}).then((result) => {
			if (result.value) {
				fieldsValue = new Object();
				fieldsPrestacion.forEach(field => {
                    let valor = $(`#${field.name}`).val();
                    if (typeof valor === 'string') {
                        valor = valor.toUpperCase();
                    }
                    fieldsValue[field.name] = valor;
				});
				$.ajax({
					type: "POST",
					url: $(this).data("url"),
					data: {datos_empleado: $("[name=datos_empleado]").val(), fieldsValue: JSON.stringify(fieldsValue)},
					dataType: "json",
					success: function (response) {
						if (response.status) {
							tablaCandidatos.bootstrapTable('insertRow', {
								index: 0,
								row: response.candidato
							})
							Swal.fire("Candidato agregado con éxito", "", "success");
						} else {
							Swal.fire(response.mensaje, "", "error");
						}
						limpiarCampos();
					}
				});
			}
		});
	}
});


formFinalizarTarea.validate({
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


function crearFormularios(tipoForms) {
	var tablas = '';
	if (tipoForms == 'normal') {
		for (key in fieldsPrestacion) {
			if (fieldsPrestacion[key].name.lastIndexOf("fec") != '-1') {
				tablas += '<div class="col-md-3">' + '<div class="form-group">' + '<label for="' + fieldsPrestacion[key].name + '" class="titulo-dato"><span class="requeridos">* </span>'
						+ fieldsPrestacion[key].desc + '</label> <input class="form-control input-date"' + 'type="text" name="' + fieldsPrestacion[key].name + '" id="'
						+ fieldsPrestacion[key].name + '" placeholder="' + fieldsPrestacion[key].desc + '">' + '</div></div>'
			} else if (fieldsPrestacion[key].name.lastIndexOf("sexo") != '-1') {
				tablas += '<div class="col-md-3">' + '<div class="form-group">' + '<label for="' + fieldsPrestacion[key].name + '" class="titulo-dato"><span class="requeridos">* </span>'
						+ fieldsPrestacion[key].desc + '</label>' + '<select class="form-control" id="' + fieldsPrestacion[key].name + '" name="' + fieldsPrestacion[key].name + '">'
						+ '</select></div></div>';
				llenarSexos(fieldsPrestacion[key].name);
			} else {
				tablas += '<div class="col-md-3">' + '<div class="form-group">' + '<label for="' + fieldsPrestacion[key].name + '" class="titulo-dato"s><span class="requeridos">* </span>'
						+ fieldsPrestacion[key].desc + '</label> <input class="form-control normalizar-texto"' + 'type="text" name="' + fieldsPrestacion[key].name + '" id="'
						+ fieldsPrestacion[key].name + '" placeholder="' + fieldsPrestacion[key].desc + '">' + '</div></div>';
			}
		}
	} else if (tipoForms == 'modal') {
		for (key in fieldsPrestacion) {
			if (fieldsPrestacion[key].name.lastIndexOf("fec") != '-1') {
				tablas += '<div class="col-md-3">' + '<div class="form-group">' + '<label for="' + fieldsPrestacion[key].name + '" class="titulo-dato"><span class="requeridos">* </span>'
						+ fieldsPrestacion[key].desc + '</label> <input class="form-control input-date"' + 'type="text" name="' + fieldsPrestacion[key].name + '_modal" id="'
						+ fieldsPrestacion[key].name + '_modal">' + '</div></div>'
			} else if (fieldsPrestacion[key].name.lastIndexOf("sexo") != '-1') {
				tablas += '<div class="col-md-3">' + '<div class="form-group">' + '<label for="' + fieldsPrestacion[key].name + '" class="titulo-dato"><span class="requeridos">* </span>'
						+ fieldsPrestacion[key].desc + '</label>' + '<select class="form-control" id="' + fieldsPrestacion[key].name + '_modal" name="' + fieldsPrestacion[key].name
						+ '_modal">' + '</select></div></div>';
				llenarSexos(fieldsPrestacion[key].name + '_modal');
			} else {
				tablas += '<div class="col-md-3">' + '<div class="form-group">' + '<label for="' + fieldsPrestacion[key].name + '" class="titulo-dato"><span class="requeridos">* </span>'
						+ fieldsPrestacion[key].desc + '</label> <input class="form-control normalizar-texto"' + 'type="text" name="' + fieldsPrestacion[key].name + '_modal" id="'
						+ fieldsPrestacion[key].name + '_modal">' + '</div></div>';
			}
		}
	}
	return tablas;
}

function llenarSexos(idSexos) {
	$("#" + idSexos).empty();
    setTimeout(() => {
        $("#" + idSexos).append("<option value=''>Seleccione por favor</option>");
        sexos.forEach(sexo => {
            $("#" + idSexos).append("<option value='" + sexo.nombre + "'>" + sexo.nombre + "</option>");
        });
    }, 1000);
}


function limpiarCampos() {
	formAgregarEmpleado[0].reset();
	validadorFormAgregarEmpleado.resetForm();
	candidato = {};
}

/* Función que crea el boton ELIMINAR en la tabla */
function eliminarFormatter(value, row) {
    return '<div class="d-flex justify-content-center"> <button type="button" class="btn btn-outline-danger btn-icon" onclick="eliminarFila('+row.candidato_prestacion_id+')" data-toggle="tooltip" data-placement="top" title="Eliminar" > <i class="fas fa-trash-alt"></i> </button> </div>'
}

/* Función que usa eliminarFormatter */
function eliminarFila(id){
    Swal.fire({
        title: 'Eliminar',
        text: "¿Esta seguro(a) de eliminar este registro?",
        icon: 'question',
        showCancelButton: true,
        cancelButtonColor: '#F64E60',
        cancelButtonText: 'No',
        confirmButtonColor: '#0BB7AF',
        confirmButtonText: 'Si'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "post",
                url: urlEliminar,
                data: {id : id},
                success: function (response) {
                    if ( response.estatus ) {
                        tablaCandidatos.bootstrapTable('remove', {
                            field: 'candidato_prestacion_id',
                            values: response.id
                        })
                        Swal.fire({
                            text: response.mensaje,
                            icon: 'success',
                            confirmButtonColor: '#0BB7AF',
                            confirmButtonText: 'Ok'
                        })
                    } else {
                        Swal.fire({
                            text: response.mensaje,
                            icon: 'error',
                            confirmButtonColor: '#0BB7AF',
                            confirmButtonText: 'Ok'
                        })
                    }

                },
            });
        }
    })
}
