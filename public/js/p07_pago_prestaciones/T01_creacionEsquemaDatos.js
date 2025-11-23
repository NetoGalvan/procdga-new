function esquemaPrestacion(esquemas) {
	var datas = '';
	$("#tablasEsquemas").empty()
	if (esquemas != '-1') {
		if (esquemas == '1') {
			datas = tablaDiaDelNino();
		} else if (esquemas == '2') {
			datas = tablaDiaDelaMadres()
		} else if (esquemas == '3') {
			datas = tablaDiaDelPadres()
		} else {
			datas = tablaUtilesEscolares()
		}
		$("#tablasEsquemas").append(tablaGeneral() + botones() + tablasMens())
		$("#tablaGeneral").bootstrapTable({
			pagination : true,
			sortable : true,
			data : datas,
			pageList : [ 5, 10, 25, 50 ]
		});
	}
}
function tablaGeneral() {
	return `<table class="table"
		id="tablaGeneral"
		data-toggle="table"
		data-unique-id="id"
		data-show-columns="false">
			<thead>
				<tr>
					<th data-field="nombre"><label class="titulo-dato">Nombre del campo</label></th>
					<th data-field="descripcion"><label class="titulo-dato">Descripción</label></th>
					<th data-field="tamanio"><label class="titulo-dato">Tamaño</label></th>
					<th data-formatter="eliminarBoton" data-events="operateEvents"><label class="titulo-dato">Acciones</label></th>
				</tr>
			</thead>
		</table>`;
}
function tablaUtilesEscolares() {
	var tablaUtiles = new Object();
	var datosEsquemas = [ {
		'id' : 100 + ~~(Math.random() * 100),
		'nombre' : 'fec_inicio_utiles',
		'descripcion' : 'Fecha de inicio de útiles',
		'tamanio' : '20'
	}, {
		'id' : 100 + ~~(Math.random() * 100),
		'nombre' : 'fec_fin_utiles',
		'descripcion' : 'Fecha de fin de útiles',
		'tamanio' : '20'
	}, {
		'id' : 100 + ~~(Math.random() * 100),
		'nombre' : 'nombre_menor',
		'descripcion' : 'Nombre (hijo)',
		'tamanio' : '20'
	}, {
		'id' : 100 + ~~(Math.random() * 100),
		'nombre' : 'paterno_menor',
		'descripcion' : 'Apellido paterno (hijo)',
		'tamanio' : '20'
	}, {
		'id' : 100 + ~~(Math.random() * 100),
		'nombre' : 'materno_menor',
		'descripcion' : 'Apellido materno (hijo)',
		'tamanio' : '20'
	} ];
	return datosEsquemas;
}
function tablaDiaDelaMadres() {
	var tablaMadre = new Object();
	var datosEsquemas = [ {
		'id' : 100 + ~~(Math.random() * 100),
		'nombre' : 'no_acta',
		'descripcion' : 'Número de acta',
		'tamanio' : '20'
	}, ];
	return datosEsquemas;
}
function tablaDiaDelPadres() {
	var tablaNino = new Object();
	var datosEsquemas = [ {
		'id' : 100 + ~~(Math.random() * 100),
		'nombre' : 'nombre_menor',
		'descripcion' : 'Nombre del hijo',
		'tamanio' : '20'
	}, {
		'id' : 100 + ~~(Math.random() * 100),
		'nombre' : 'sexo_menor',
		'descripcion' : 'Sexo',
		'tamanio' : '20'
	}, {
		'id' : 100 + ~~(Math.random() * 100),
		'nombre' : 'fec_nac_menor',
		'descripcion' : 'Fecha de nacimiento',
		'tamanio' : '20'
	}, {
		'id' : 100 + ~~(Math.random() * 100),
		'nombre' : 'fec_reg_civil',
		'descripcion' : 'Fecha del registro civil',
		'tamanio' : '20'
	}, {
		'id' : 100 + ~~(Math.random() * 100),
		'nombre' : 'libro_reg_civil',
		'descripcion' : 'Libro del registro civil',
		'tamanio' : '20'
	}, {
		'id' : 100 + ~~(Math.random() * 100),
		'nombre' : 'libro_acta_primogenito',
		'descripcion' : 'Libro del acta del primogenito',
		'tamanio' : '20'
	}, {
		'id' : 100 + ~~(Math.random() * 100),
		'nombre' : 'foja_acta_nacimiento_primogenito',
		'descripcion' : 'Foja de la acta de nacimiento del primogenito',
		'tamanio' : '20'
	}, {
		'id' : 100 + ~~(Math.random() * 100),
		'nombre' : 'no_acta',
		'descripcion' : 'No. de acta',
		'tamanio' : '20'
	} ];
	return datosEsquemas;
}
function tablaDiaDelNino() {
	var tablaNino = new Object();
	var datosEsquemas = [ {
		'id' : 100 + ~~(Math.random() * 100),
		'nombre' : 'nombre_menor',
		'descripcion' : 'Nombre(s) del menor',
		'tamanio' : '20'
	}, {
		'id' : 100 + ~~(Math.random() * 100),
		'nombre' : 'paterno_menor',
		'descripcion' : 'Apellido paterno del menor',
		'tamanio' : '20'
	}, {
		'id' : 100 + ~~(Math.random() * 100),
		'nombre' : 'materno_menor',
		'descripcion' : 'Apellido materno del menor',
		'tamanio' : '20'
	}, {
		'id' : 100 + ~~(Math.random() * 100),
		'nombre' : 'fec_nac',
		'descripcion' : 'Fecha de nacimiento',
		'tamanio' : '20'
	} ];
	return datosEsquemas;
}
function eliminarBoton(value, row) {
	return 	`<a href="javascript:void(0)"
				class="remove btn btn-outline-danger btn-icon">
				<i class="fas fa-trash-alt"></i>
			</a>
			<a href="javascript:void(0)"
				class="editar btn btn-outline-primary btn-icon">
				<i class="fas fa-edit"></i>
			</a>`;
}
function eliminarRows(value, row) {
}
function tablasMens() {
	return `<div class="alert alert-custom alert-outline-success fade show mt-4" role="alert">
		<div class="alert-icon"><i class="flaticon-warning"></i></div>
		<div class="alert-text">
			Usted puede editar cualquier celda de esta tabla pulsando sobre ella, así como borrar todo un renglón pulsando el ícono rojo.
			Además puede agregar tantos renglones como desee, pulsando el botón que dice "Agregar campo". <br><br>
			<b">NO ES NECESARIO</b> que agregue los siguientes campos:
			<ul>
				<li>Número consecutivo: (id_ordinal, no, num_reg o cualquiera parecido)</li>
				<li>Número de empleado: (id_empleado, no_trabajador, o cualquiera parecido)</li>
				<li>Nombre de empleado: (nombre_empleado, nombre_emp, o cualquiera parecido)</li>
				<li>Apellido paterno de empleado: (paterno_empleado, paterno, o cualquiera parecido)</li>
				<li>Apellido materno de empleado: (materno_empleado, materno, o cualquiera parecido)</li>
				<li>Id unidad administrativa: (ua, id_admva, o cualquiera parecido)</li>
				<li>RFC: (rfc, id_legal, o cualquiera parecido)</li>
				<li>CURP: (curp, id_legal_curp, o cualquiera parecido)</li>
				<li>Sección Sindical (s_sindical,id_sindicato, o cualquiera parecido)</li>
			</ul>
		</div>
	</div>`;
}
function botones() {
	return `<div class="d-flex justify-content-center">
		<div class="p-2 bd-highlight">
			<button class="btn btn-primary" type="button" onclick="abrirModal()"><i class="fas fa-plus"></i> Agregar Campo</button>
		</div>
	</div>`;
}
window.operateEvents = {
	'click .editar' : function(e, value, row, index) {
		/* desplazarVentanas(700); */
		$("#modalAgregar").modal('show');
		$("#nombre").val(row.nombre)
		$("#descripcion").val(row.descripcion);
		$("#tamanio").val(row.tamanio)
		$("#editar").val(true);
		$("#id_row").val(row.id);
	},
	'click .remove' : function(e, value, row, index) {
		$("#tablaGeneral").bootstrapTable('remove', {
			field : 'id',
			values : [ row.id ]
		})
	}
}
function agregarFilas() {
	if (validatorCampos.form()) {
		var nombre = $("#nombre").val()
		var descripcion = $("#descripcion").val();
		var tamanio = $("#tamanio").val()
		if ($("#editar").val() == "true") {
			$("#tablaGeneral").bootstrapTable('updateByUniqueId', {
				id: $("#id_row").val(),
				row: {
					nombre : nombre,
					descripcion : descripcion,
					tamanio : tamanio
				}
			});
		} else {
			var randomId = 100 + ~~(Math.random() * 100)
			$("#tablaGeneral").bootstrapTable('append', [ {
				id : randomId,
				nombre : nombre,
				descripcion : descripcion,
				tamanio : tamanio
			}]);
		}
		$("#modalAgregar").modal('hide');
		$("#formCamposNuevos")[0].reset();
	}
}

function abrirModal() {
	$("#modalAgregar").modal('show');
	$("#nombre").val('');
	$("#descripcion").val('');
	$("#tamanio").val('');
	$("#editar").val(false);
}

var formEsquemaDatos = $("#form_esquema_datos");
var validator = formEsquemaDatos.validate({
    submitHandler: function(form) {
		var campos = $("#tablaGeneral").bootstrapTable('getData')

		if (campos.length === 0) {
			swal.fire("Agregue al menos un campo.", "", "error");
			return false;
		}

		var estructuraConcurrente = [];
		for (key in campos) {
			var campo = new Object()
			campo.campo_num = key;
			campo.name = campos[key].nombre;
			campo.desc = campos[key].descripcion;
			campo.tamanio = campos[key].tamanio;
			estructuraConcurrente.push(campo);
		}
		$("#estructura_concurrente").val(JSON.stringify(estructuraConcurrente));

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

var validator = formEsquemaDatos.validate({
	rules : {
		fecha_limite : {
			required : true,
			date : false
		},
		observaciones : {
			required : true,
			campoNoVacio : true,
			soloLetras : true
		}
	},
	errorPlacement : function(error, element) {
		error.addClass("error");
		error.insertAfter(element);
	},
	errorClass : "error",
	validClass : "valido",
	messages : {
		observaciones : {
			required : "El campo no puede estar vacio",
			campoNoVacio : "No puede ingresar espacios",
			soloLetras : "Solo puede ingresar Letras"
		},
		fecha_limite : {
			required : "El campo no puede estar vacio"
		}
	}
});

var validatorCampos = $("#formCamposNuevos").validate({
	rules : {
		nombre : {
			required : true,
			date : false,
			campoNoVacio : true
		},
		descripcion : {
			required : true,
			campoNoVacio : true
		},
		tamanio : {
			required : true,
			number : true,
			campoNoVacio : true
		}
	},
	errorPlacement : function(error, element) {
		error.addClass("error");
		error.insertAfter(element);
	},
	errorClass : "error",
	validClass : "valido",
	messages : {
		nombre : {
			required : "El campo no puede estar vacío",
			campoNoVacio : "No puede ingresar espacios",
			soloLetras : "Solo puede ingresar Letras"
		},
		descripcion : {
			required : "El campo no puede estar vacío",
			campoNoVacio : "No puede ingresar espacios",
		},
		tamanio : {
			required : "El campo no puede estar vacío",
			campoNoVacio : "No puede ingresar espacios",
			number : "Solo puede ingresar números"
		}
	}
});



$('#modalAgregar').on('hide.bs.modal', function(e) {
	validatorCampos.resetForm();
})
