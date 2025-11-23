var tablaCandidato = $("#tablaCandidatosSeleccionadosFechaCitas");
var formFechaPsicometricos = $("#formAsignacionFechaPsicometricos");
var btnFinalizarFechaPsicometricos = $("#btnAsignacionFechaPsicometricos");
var urlFinalizarFechaPsicometricos = formFechaPsicometricos.attr("action");

// Inicializa JS
$(document).ready(function() {
    // Llena la tabla con los datos del Candidato
	llenarTablaSeleccionCandidatos(candidatoSelecionado);
});

/* Función para llenar tabla  */
function llenarTablaSeleccionCandidatos(data) {
	tablaCandidato.bootstrapTable({
		data : data,
		pagination : true,
		sortable : true,
		pageList : [ 5, 10, 25, 50 ]
	});
}

/* Formatter para nombre del Candidato */
function nombreCandidatoFormatter(value, row) {
    return row.nombre_candidato + ' ' + row.apellido_paterno_candidato + ' ' + row.apellido_materno_candidato ;
}

/* Formatter para el estatus*/
function tipoMovimientoFormatter(value, row) {
    return '<span class="badge badge-primary">'+ value +'</span>';
}

/* Formatter para la fecha del Examen Psicométrico */
function fechaEvaluacionActual(value, row) {
    return '<input type="date" class="form-control form-control-sm" name="fecha_cita_'+`${value}`+'" id="fecha_cita_'+`${value}`+'" value="'+ (row.fecha_cita == null ? '' : row.fecha_cita) +'">';
}

/* Formatter para la hora del Examen Psicométrico */
function horaEvaluacionActual(value, row) {
	return '<input type="time" class="form-control form-control-sm" name="hora_cita_'+`${value}`+'" id="hora_cita_'+`${value}`+'" value="'+ (row.hora_cita == null ? '' : row.hora_cita) +'">';
}

/* Formatter para el lugar del Examen Psicométrico */
function lugarEvaluacionActual(value, row) {
	return '<input type="text" class="form-control form-control-sm" name="lugar_cita_'+`${value}`+'" id="lugar_cita_'+`${value}`+'" value="'+ (row.lugar_cita == null ? 'CGMDA' : row.lugar_cita) +'">';
}


// Evento para Finalizar la T02
btnFinalizarFechaPsicometricos.click(function (e) {
    e.preventDefault();

    // Inicializamos en Validador
    var validator = validacionCampos(candidatoSelecionado);
    // Validamos antes de Finalizar
    var validado = validator.form();

    if ( validado ) {

        // Solo puede validar a un candidato o a ninguno
        Swal.fire({
            title: 'Finalizar',
            text: "¿Esta seguro de finalizar la tarea?",
            icon: 'question',
            showCancelButton: true,
            cancelButtonColor: '#F64E60',
            cancelButtonText: 'No',
            confirmButtonColor: '#0BB7AF',
            confirmButtonText: 'Si'
        }).then((result) => {
            if (result.isConfirmed) {

                // Obtenemos los datos de la tabla
                var dataTable = tablaCandidato.bootstrapTable('getData');
                // Asignamos estos datos a un input hidden para su envío con la demas información
                $("#dataTableCandidatos").val(JSON.stringify(dataTable));
                // Mandamos los datos del Form
                let data = formFechaPsicometricos.serialize();

                $.ajax({
                    type: "POST",
                    url: urlFinalizarFechaPsicometricos,
                    data: data,
                    success: function (response) {

                        if ( response.estatus ) {
                            Swal.fire({
                                title: '',
                                text: response.msj,
                                icon: 'success',
                                confirmButtonColor: '#0BB7AF',
                                confirmButtonText: 'Entendido',
                                allowOutsideClick: false,
                            }).then((result) => {
                                if ( result.isConfirmed ) {
                                    window.location.href = urlTareas;
                                }
                            })
                        } else {
                            Swal.fire({
                                title: '',
                                text: response.msj,
                                icon: 'error',
                                confirmButtonColor: '#DC3545',
                                confirmButtonText: 'Ok',
                            })
                        }
                    },
                    error: function (responseText, textStatus, errorThrown) {
                        Swal.fire({
                            title: 'Error',
                            text: errorThrown,
                            icon: 'error',
                            confirmButtonColor: '#DC3545',
                            confirmButtonText: 'Ok'
                        });
                    }
                });

            }
        });

    } else {

        Swal.fire({
            title: 'Complete la información',
            text: "Debe llenar todos los campos que se solicitan",
            icon: 'warning',
            confirmButtonColor: '#0BB7AF',
            confirmButtonText: 'Entendido'
        });

    }

});

// Función para agregar reglas y validar campos
function validacionCampos(candidatoSelecionado) {

    // Inicializamos en Validador
    var validator = formFechaPsicometricos.validate();

    /* Agregar Validación a los campos requeridos */
    $.each(candidatoSelecionado, function (index, valor) {
        // Agregar regla de validación
        $('#fecha_cita_'+valor.candidato_id).rules( "add", {
            required : true,
            messages: {
                required : "Este campo es requerido",
            }
        });
        // Agregar regla de validación
        $('#hora_cita_'+valor.candidato_id).rules( "add", {
            required : true,
            messages: {
                required : "Este campo es requerido",
            }
        });
        // Agregar regla de validación
        $('#lugar_cita_'+valor.candidato_id).rules( "add", {
            required : true,
            campoNoVacio : true,
            messages: {
                required : "Este campo es requerido",
                campoNoVacio : "No deje espacios en blanco al inicio del texto",
            }
        });

    });

    return validator;
}
