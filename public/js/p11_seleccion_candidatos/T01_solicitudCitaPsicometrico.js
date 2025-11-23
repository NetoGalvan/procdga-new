var formCandidatos = $("#formCandidatos");
var btnBuscarCandidato = $('#candidatoRfc');
var btnAgregarCandidato = $('#btn_agregar_candidato');
var inputRCF = $('#rfc');
var inputNoEmpleado = $('#numero_empleado');
var inputNombreCandidato = $('#nombre_candidato');
var inputPrimerApellido = $('#apellido_paterno_cadidato');
var inputSegundoApellido = $('#apellido_materno_cadidato');
var inputObservaciones = $('#observaciones_titular');
var inputTipoMovimiento = $('#tipo_movimiento');
var tablaCandidatos = $("#tablaCandidatos");
var btnFinaliarProceso = $('#btn_finalizar_proceso');
var btnFinaliarSolicitarCita = $('#btn_finalizar_solicitar_cita');

$(document).ready(function () {
    // Si existen datos previos se cargan en la tabla
    if ( seleccionCandidatos.length > 0 ) {
        seleccionCandidatos.forEach(infoCandidato => {
            tablaCandidatos.bootstrapTable('insertRow', {
                index: 0,
                row: {
                    id: infoCandidato.candidato_id,
                    tipoMovimiento: infoCandidato.tipo_movimiento,
                    nombre: infoCandidato.nombre_candidato,
                    apePaterno: infoCandidato.apellido_paterno_candidato,
                    apeMaterno: infoCandidato.apellido_paterno_candidato,
                    rfc: infoCandidato.rfc,
                    noEmpleado: infoCandidato.no_empleado,
                    observaciones: infoCandidato.observaciones_titular
                }
            });
        });
    }

});

// Agregar la libreria de Select2
$('#numPlaza').select2({
    placeholder: "Seleccione una opción",
});
$('#titularSolicitante').select2({
    placeholder: "Seleccione una opción",
});

// Evento que activa la función de buscar
btnBuscarCandidato.click(function (e) {
    e.preventDefault();

    var validator = validarForm();
    var rfcValidado = validator.element( "#rfc" );
    var noEmpleadoValidado = validator.element( "#numero_empleado" );

    // Valida los campos de rfc y no empleado
    if ( rfcValidado && noEmpleadoValidado ) {
        // Si pasa la validación se mandan los campos para obtener los datos
        $.ajax({
            type: "POST",
            url: urlEmpleadosCandidatos,
            data: {
                    numero_empleado: inputNoEmpleado.val(),
                    rfc : inputRCF.val(),
                    campos_requeridos : [
                        'curp' , 'nombre_empleado', 'primer_apellido', 'segundo_apellido',
                        'unidad_administrativa', 'nombre_unidad_administrativa',
                        'nivel_salarial', 'nombre_puesto', 'descripcion_puesto'
                    ],
            },
            success: function (response) {
                // Se valida la respuesta
                if ( response.estatus ) {
                    Swal.fire({
                        title: '',
                        text: response.msj,
                        icon: 'success',
                        confirmButtonColor: '#0BB7AF',
                        confirmButtonText: 'Ok'
                    });
                    // Si los datos vienen de la DB
                    if ( response.dondeSebusco == 'db' ) {
                        inputNombreCandidato.val( response.data.nombre_candidato );
                        inputPrimerApellido.val( response.data.apellido_paterno_candidato );
                        inputSegundoApellido.val( response.data.apellido_materno_candidato );
                        validator.resetForm();
                    } else {
                        // Si los datos vienen del WS
                        inputNombreCandidato.val( response.data.nombre_empleado );
                        inputPrimerApellido.val( response.data.primer_apellido );
                        inputSegundoApellido.val( response.data.segundo_apellido );
                        validator.resetForm();
                    }
                } else {
                    Swal.fire({
                        title: '',
                        text: response.msj,
                        icon: 'warning',
                        confirmButtonColor: '#DC3545',
                        confirmButtonText: 'Ok'
                    });
                    inputNombreCandidato.val('');
                    inputPrimerApellido.val('');
                    inputSegundoApellido.val('');
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

// Evento que activa la funcion de agregar candidatos a la Tabla
btnAgregarCandidato.click(function (e) {
    e.preventDefault();

    // Validamos los campos del Formulario
    var validator = validarForm();
    // Removemos la validación para estos campos ya que para agregar un candidato no se requiren validar
    $('#numPlaza').rules('remove');
    $('#titularSolicitante').rules('remove');
    // Despues de remover se hace la validación
    var result = validator.form();

    if ( result ) {
        // Obtenemos los registros de la tabla
        var registrosTabla = tablaCandidatos.bootstrapTable('getData');

        /* Si ya existe 1 registro en la tabal se obtiene el RFC para comparar con el nuevo a ingresar
         para validar que no repitan */
        if ( registrosTabla.length == 1 ) {
            var rfcRegistrado = registrosTabla[0].rfc;
        }

        // Si existe un resgitro se compara que no se repita
        if ( inputRCF.val() == rfcRegistrado ) {
            Swal.fire({
                title: 'Información',
                text: '¡No se puede agregar el mismo RFC, debe ser diferente!',
                icon: 'warning',
                confirmButtonColor: '#0BB7AF',
                confirmButtonText: 'Ok'
            });
        } else {
            // Si existen menos de 2 sigue insertando, Solo acepta 2 registros
            if ( registrosTabla.length < 2 ) {

                var randomId = 100 + ~~(Math.random() * 100)
                // Insertamos los valores en la Tabla
                tablaCandidatos.bootstrapTable('insertRow', {
                    index: 0,
                    row: {
                        id: randomId,
                        tipoMovimiento: inputTipoMovimiento.val(),
                        nombre: inputNombreCandidato.val(),
                        apePaterno: inputPrimerApellido.val(),
                        apeMaterno: inputSegundoApellido.val(),
                        rfc: inputRCF.val(),
                        noEmpleado: inputNoEmpleado.val(),
                        observaciones: inputObservaciones.val()
                    }
                });
                // Despues de insertar, Limpiamos los inputs
                inputTipoMovimiento.val('');
                inputNombreCandidato.val('');
                inputPrimerApellido.val('');
                inputSegundoApellido.val('');
                inputRCF.val('');
                inputNoEmpleado.val('');
                inputObservaciones.val('');

            } else {
                Swal.fire({
                    title: 'Información',
                    text: '¡Solo se puede agregar un máximo de 2 registros!',
                    icon: 'warning',
                    confirmButtonColor: '#0BB7AF',
                    confirmButtonText: 'Ok'
                });
            }
        }


    }

})

// Valida los campos de agregar
function validarForm () {
    var validator = formCandidatos.validate({
        rules: {
            numPlaza: {
                required: true
            },
            titularSolicitante: {
                required: true
            },
            rfc: {
                RFC: true,
                required: true,
                campoNoVacio: true,
            },
            numero_empleado: {
                required: true,
                number: true,
                campoNoVacio: true
            },
            tipo_movimiento: {
                required: true,
            },
            nombre_candidato: {
                required: true,
                campoNoVacio: true,
                soloLetras: true
            },
            apellido_paterno_cadidato: {
                required: true,
                campoNoVacio: true,
                soloLetras: true
            },
            apellido_materno_cadidato: {
                required: true,
                campoNoVacio: true,
                soloLetras: true
            },
            observaciones_titular: {
                required: true,
                campoNoVacio: true,
            },
        },
        messages: {
            numPlaza: {
                required: "El campo no puede estar vacio"
            },
            titularSolicitante: {
                required: "El campo no puede estar vacio"
            },
            rfc: {
                RFC: "Ingresa RFC valido",
                required: "El campo no puede estar vacio",
                campoNoVacio: "El campo no puede estar vacio",
            },
            numero_empleado: {
                required: "El campo no puede estar vacio",
                number: "Solo puede introducir numeros",
                campoNoVacio: "El campo no puede estar vacio",
            },
            tipo_movimiento: {
                required: "El campo no puede estar vacio",
            },
            nombre_candidato: {
                required: "El campo no puede estar vacio",
                campoNoVacio: "El campo no puede estar vacio",
                soloLetras: "Solo acepta letras"
            },
            apellido_paterno_cadidato: {
                required: "El campo no puede estar vacio",
                campoNoVacio: "El campo no puede estar vacio",
                soloLetras: "Solo acepta letras"
            },
            apellido_materno_cadidato: {
                required: "El campo no puede estar vacio",
                campoNoVacio: "El campo no puede estar vacio",
                soloLetras: "Solo acepta letras"
            },
            observaciones_titular: {
                required: "El campo no puede estar vacio",
                campoNoVacio: "El campo no puede estar vacio",
            },
        },
        errorPlacement: function(error, element) {
            if (element.hasClass('select2') && element.next('.select2-container').length) {
                error.insertAfter(element.next('.select2-container'));
            } else {
                error.insertAfter(element);
            }

        },
    });

    return validator;
}

// Da formato al campo de Tipo de Movimiento en la Tabla
function tipoMovimientoFormatter(value, row) {
    return '<span class="text-primary font-weight-bolder">'+ value +'</span>';
}

// Acciones que puede hacer en esta sección
function accionesFormatterSolicitarCita(value, row) {
    let botones =  `<button
                        type="button"
                        class="btn btn-sm btn-outline-danger btn-icon"
                        data-toggle="tooltip"
                        title="Eliminar Candidato"
                        onclick="eliminarCandidato( ${row.id})">
                        <i class="fa fa-trash"></i>
                    </button>`;
    /* if (row.ruta_archivo_acuse != null) {
        botones += `<button
                        data-path=${row.ruta_acuse_notificacion_leida}
                        type="button"
                        class="btn btn-sm btn-outline-info btn-icon btn-descargar-documento"
                        data-toggle="kt-tooltip"
                        title="Descargar Acuse">
                        <i class="fas fa-file-pdf"></i>
                    </button>`;
    } */
    return botones;
}

// Elimina el registro del candidato
function eliminarCandidato(id){
    Swal.fire({
        title: 'Eliminar',
        text: "¿Desea eliminar este registro?",
        icon: 'question',
        showCancelButton: true,
        cancelButtonColor: '#F64E60',
        cancelButtonText: 'No',
        confirmButtonColor: '#0BB7AF',
        confirmButtonText: 'Si'
    }).then((result) => {
        if ( result.isConfirmed ) {
            tablaCandidatos.bootstrapTable('removeByUniqueId', id);
        }
    })
}

// Evento que Finaliza el Proceso desde la T01
btnFinaliarProceso.click( function (e) {
    e.preventDefault();
    Swal.fire({
        title: 'Finalizar',
        text: "¿Esta seguro de finalizar este trámite?",
        icon: 'warning',
        showCancelButton: true,
        cancelButtonColor: '#F64E60',
        cancelButtonText: 'No',
        confirmButtonColor: '#0BB7AF',
        confirmButtonText: 'Si'
    }).then((result) => {
        if ( result.isConfirmed ) {
            $.ajax({
                type: "GET",
                url: urlFinalizarProceso,
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
                            title: 'Error',
                            text: response.msj,
                            icon: 'error',
                            confirmButtonColor: '#F64E60',
                            confirmButtonText: 'Ok'
                        });
                    }
                }
            });
        }
    })
})

// Evento que Finaliza la T01 Solicitud Cita para Candidatos
btnFinaliarSolicitarCita.click(function (e) {
    e.preventDefault();
    // Obtengo los registros de la tabla
    var registrosTabla = tablaCandidatos.bootstrapTable('getData');
    // Valida que exista al menos un registro en la tabla
    if ( registrosTabla.length > 0 ) {

        // Valida los 2 Selects para verificar que esten seleccionados
        var validator = validarForm();
        validator.resetForm();
        $('#numPlaza').rules('add', 'required');
        var numPlazaValidado = validator.element( "#numPlaza" );
        $('#titularSolicitante').rules('add', 'required');
        var titularSolicitanteValidado = validator.element( "#titularSolicitante" );

        // Si estan seleccionados esos 2 Select permite Finalizar la T01
        if ( numPlazaValidado && titularSolicitanteValidado ) {

            Swal.fire({
                title: 'Solicitar Cita',
                text: "¿Enviar información para solicitud de cita?",
                icon: 'question',
                showCancelButton: true,
                cancelButtonColor: '#F64E60',
                cancelButtonText: 'No',
                confirmButtonColor: '#0BB7AF',
                confirmButtonText: 'Si'
            }).then((result) => {
                if ( result.isConfirmed ) {
                    // Para enviar los datos se omiten las validaciones de los inputs
                    formCandidatos.validate().currentForm = '';
                    // Se asignan los datos de la tabla al inpuT
                    $("#arregloTablaCandidatos").val(JSON.stringify(registrosTabla));
                    // Se envia el Formulario
                    formCandidatos.submit();
                }
            })

        } else {
            Swal.fire({
                title: 'Falta información',
                html: '<p>Verifica que seleccionaste</p><p>Plaza y Titular</p>',
                icon: 'warning',
                confirmButtonColor: '#0BB7AF',
                confirmButtonText: 'Ok'
            });
        }

    } else {
        Swal.fire({
            title: 'Agregar candidatos',
            text: 'Debes agregar al menos un candidato antes de poner finalizar',
            icon: 'warning',
            confirmButtonColor: '#0BB7AF',
            confirmButtonText: 'Ok'
        });
    }

});

