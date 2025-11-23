var tablaCandidatos = $("#tablaCandidatosSeleccionados");
var formValidacionCandidatos = $("#formValidacionPropuestas");
var btnFinalizarValidacionCandidatos = $("#btnValidacionPropuestas");
var urlFinalizarValidacionCandidatos = formValidacionCandidatos.attr("action");

$(document).ready(function () {
    // Llenamos la tabla con los datos de los candidatos
    llenarTablaSeleccionCandidatos(candidatosSelecionados);
});

/* Función para llenar tabla  */
function llenarTablaSeleccionCandidatos(data) {
	tablaCandidatos.bootstrapTable({
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

/* Formatter para el Autorización*/
function validacionSecretarios(value, row) {
    return '<select class="form-control form-control-sm" id="titularSolicitante_'+value+'" name="titularSolicitante_'+value+'" >' +
                '<option value="">Seleccione una opción</option>' +
                '<option value="RECHAZADO" ' + (row.aceptacion_srio == 'RECHAZADO' ? 'selected' : '') +  ' >RECHAZADO</option>' +
                '<option value="VALIDADO" ' + (row.aceptacion_srio == 'VALIDADO' ? 'selected' : '') +  ' >VALIDADO</option>' +
            '</select>';
}


// Evento para Finalizar la TS02
btnFinalizarValidacionCandidatos.click(function (e) {
    e.preventDefault();

    // Inicializamos en Validador
    var validator = validacionCampos(candidatosSelecionados);
    // Validamos antes de Finalizar
    var validado = validator.form();

    if ( validado ) {

        // Validamos que seleccionó
        var selecciono = validarQueSelecciono(candidatosSelecionados);
        // Solo puede validar a un candidato o a ninguno
        if ( selecciono <= 1 ) {
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
                    var dataTable = tablaCandidatos.bootstrapTable('getData');
                    // Asignamos estos datos a un input hidden para su envío con la demas información
                    $("#dataTableCandidatos").val(JSON.stringify(dataTable));
                    // Mandamos los datos del Form
                    let data = formValidacionCandidatos.serialize();

                    $.ajax({
                        type: "POST",
                        url: urlFinalizarValidacionCandidatos,
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
                                    icon: 'success',
                                    confirmButtonColor: '#0BB7AF',
                                    confirmButtonText: 'Entendido',
                                    allowOutsideClick: false,
                                }).then((result) => {
                                    if ( result.isConfirmed ) {
                                        window.location.href = urlTareas;
                                    }
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
                title: '¡Atención!',
                text: "Solo puedes validar a un candidato o rechazar a todos",
                icon: 'warning',
                confirmButtonColor: '#0BB7AF',
                confirmButtonText: 'Entendido'
            });


        }

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
function validacionCampos(candidatosSelecionados) {

    // Inicializamos en Validador
    var validator = formValidacionCandidatos.validate();

    /* Agregar Validación al Select */
    $.each(candidatosSelecionados, function (index, valor) {
        // Agregar regla de validación
        $('#titularSolicitante_'+valor.candidato_id).rules( "add", {
            required : true,
            messages: {
                required : "Este campo es requerido",
            }
        });

    });

    return validator;
}


// Función para validar que selecciono el Usuario
function validarQueSelecciono(candidatosSelecionados) {

    var validado = 0;
    // Validar que Selecciono
    $.each(candidatosSelecionados, function (index, valor) {
        // Agregar regla de validación
        let campoSeleccion = $('#titularSolicitante_'+valor.candidato_id).val();
        // Solo puede validar un candidato o a ninguno
        if ( campoSeleccion == 'VALIDADO' ) {
            validado ++;
        }
    });

    return validado;

}
