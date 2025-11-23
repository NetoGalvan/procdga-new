const btnAgregarPartida = $('#btn_agrega_partida');
const formModalDesgloseServicios = $('#form_modal_desglose_servicio');
const formDesagloseServicio = $('#form_desglose_servicio');
const btnFinalizarDesglose = $('#btn_finalizar_desglose');
const table = $('#table');
const modalNuevaPartida = $("#modalNuevaPartida");
const containerMotivoRechazo = $(".container-motivo-rechazo");
const inputMotivoRechazo = $("#motivo_rechazo");
let   rechazarSolicitud = false;
const selectUnidad = $("#unidad");

// Función que genera el Switch de Urgente
let Switch = function() {
    let activaSwitch = function() {
        $('[data-switch=true]').bootstrapSwitch();
    };
    return {
        init: function() {
            activaSwitch();
        },
    };
}();



$(document).ready(function () {

    if ( claveServicio === 'vehiculos' ) {
        selectUnidad.select2({
            placeholder: "Selecciona una opción",
        });
    }

    // Inicializa el Switch
    Switch.init();
    // Valida si será rechazada la solicitud
    $('#rechazar').on('switchChange.bootstrapSwitch', function(event, state) {
        // Acciones a realizar cuando cambie el estado del switch
        if (state) {
            // El switch está activado
            rechazarSolicitud = true;
            containerMotivoRechazo.removeClass('d-none');
        } else {
            // El switch está desactivado
            rechazarSolicitud = false;
            containerMotivoRechazo.addClass('d-none');
        }
    });

    /** Escucha el evento click del modal para Agregar Partidas */
    btnAgregarPartida.click(function (evento) {
        /**La variable 'randomId' asigna un valor random al boton ELIMINAR de la tabla para poder ser borrado de ser necesario */
        let randomId = 100 + ~~(Math.random() * 100);
        servicio_id = $("#modalNuevaPartida #servicio_id").val().trim();
        unidad = $("#modalNuevaPartida #unidad").val().trim();
        fecha_estimada = $("#modalNuevaPartida #fecha_estimada").val().trim();
        descripcion_servicio = $("#modalNuevaPartida #descripcion_servicio").val().trim();

        selectServicios = $('select#servicio_id');
        url = selectServicios.data('url');

        // Para servicios de telefonía no es obligatorio el campo UNIDAD
        if ( claveServicio === 'telefonia' || claveServicio === 'vehiculos' ) {
            $("#unidad").rules("remove");
        }

        if ( formModalDesgloseServicios.valid() ) {
            $.ajax({
                type: "post",
                url: url,
                data: { servicio_id : servicio_id },
                success: function (response) {
                    table.bootstrapTable( 'insertRow', {
                        index: 1,
                        row: {
                            id: randomId,
                            servicio_id: servicio_id ,
                            tipo_servicio: response[0]?.nombre_servicio,
                            unidad: unidad ? unidad : 'N/A',
                            fecha_estimada: fecha_estimada,
                            descripcion_servicio: descripcion_servicio
                        },
                    });
                    //Función de boostrap que activa el Tooltip (Mensaje en los iconos)
                    $('[data-toggle="tooltip"]').tooltip();
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert("Surgio un " + errorThrown + " intenta capturar mas tarde.");
                }
            });

            formModalDesgloseServicios.trigger("reset");
            modalNuevaPartida.modal("hide");
        }
    });

    /** Evento que carga los datos guardados previamente de los detalles del servicio, Vienen del controlador */
    if ( detalleSolicitaServicio ) {
        detalleSolicitaServicio.forEach(detalle => {
            table.bootstrapTable( 'insertRow', {
                index: 0,
                row: {
                    id: detalle.p08_detalle_solicita_servicio_id,
                    servicio_id: detalle.servicio_id,
                    tipo_servicio: detalle.servicio.nombre_servicio,
                    unidad: detalle.unidad,
                    fecha_estimada: detalle.fecha_estimada,
                    descripcion_servicio: detalle.descripcion_servicio
                },
            });
        });
    }

    modalNuevaPartida.on('hidden.bs.modal', function (e) {
        formModalDesgloseServicios.trigger("reset");
    })

    // Evento de JQuery validate
    formModalDesgloseServicios.validate({
        rules: {
            servicio_id : {
                required : true
            },
            unidad : {
                required : true,
                campoNoVacio: true
            },
            fecha_estimada : {
                required : true,
                date : false,
                campoNoVacio: true
            },
            descripcion_servicio : {
                required : true,
                campoNoVacio: true
            }
        },
        messages: {
            servicio_id : {
                required : 'Seleccione una opción',
            },
            unidad: {
                required : 'Este campo debe ser llenado',
                campoNoVacio: 'No se puede enviar espacios en blanco'
            },
            fecha_estimada: {
                required : 'Seleccione una fecha',
                campoNoVacio: 'No se puede enviar espacios en blanco'
            },
            descripcion_servicio: {
                required : 'Este campo debe ser llenado',
                campoNoVacio: 'No se puede enviar espacios en blanco'
            }
        },
    });

    formDesagloseServicio.validate();

    btnFinalizarDesglose.click(function (e) {
        e.preventDefault();
        const arregloDesgloseServicios = table.bootstrapTable('getData');
        const isValid = arregloDesgloseServicios.length > 0;

        if (rechazarSolicitud) {
            if (formDesagloseServicio.valid()) {
                Swal.fire({
                    title: "Rechazar tarea",
                    html: "¿Esta seguro(a) de <b> rechazar y finalizar </b> todo el proceso?",
                    icon: "warning",
                    showCancelButton: true,
                    cancelButtonColor: '#F64E60',
                    cancelButtonText: "Cancelar",
                    confirmButtonText: "Continuar",
                    confirmButtonColor: '#0BB7AF',
                    reverseButtons: true,
                }).then(function(result) {
                    if (result.value) {
                        KTApp.blockPage({
                            overlayColor: '#000000',
                            state: 'danger',
                            message: 'Por favor, espere...'
                        });
                        $.ajax({
                            type: "POST",
                            url: urlFinalizarProceso,
                            data: { motivo_rechazo : inputMotivoRechazo.val(), solicita_servicio_id : solicitaServicioId, instancia_tarea_id : instanciaTareaId },
                            success: function (response) {
                                if ( response.finalizado ) {
                                    Swal.fire({
                                        text: response.mensaje,
                                        icon: 'success',
                                        confirmButtonColor: '#0BB7AF',
                                        confirmButtonText: 'Ok',
                                        allowOutsideClick: false,
                                    }).then( (result) => {
                                        if ( result.isConfirmed ) {
                                            window.location.href = urlTareas;
                                        }
                                    })
                                    window.location.href = urlTareas;
                                } else {
                                    swal.fire({
                                        "title": 'Error',
                                        "text": response.mensaje,
                                        "icon": "warning",
                                        "confirmButtonColor": '#0abb87',
                                        "confirmButtonText": 'Ok',
                                        "allowOutsideClick": false,
                                    });
                                }
                            },
                            error: function( jqXHR, textStatus, errorThrown ) {
                                swal.fire({
                                    "title": 'Error',
                                    "text": response.mensaje,
                                    "icon": "warning",
                                    "confirmButtonColor": '#0abb87',
                                    "confirmButtonText": 'Ok',
                                    "allowOutsideClick": false,
                                });
                            }
                        });
                    }
                });
            }
        } else {
            if ( isValid ) {
                $('#arreglo_servicio').val(JSON.stringify(arregloDesgloseServicios));
                Swal.fire({
                    title: "Finalizar tarea",
                    text: "¿Esta seguro(a) de terminar esta tarea?",
                    icon: "question",
                    showCancelButton: true,
                    cancelButtonColor: '#F64E60',
                    cancelButtonText: "Cancelar",
                    confirmButtonText: "Continuar",
                    confirmButtonColor: '#0BB7AF',
                    reverseButtons: true,
                }).then(function(result) {
                    if (result.value) {
                        KTApp.blockPage({
                            overlayColor: '#000000',
                            state: 'danger',
                            message: 'Por favor, espere...'
                        });
                        formDesagloseServicio.submit();
                    }
                });
            } else {
                Swal.fire({
                    title: "Finalizar tarea",
                    html: "Para finalizar la tarea,<br> debes agregar al menos un entregable",
                    icon: 'warning',
                    confirmButtonColor: '#0BB7AF',
                    confirmButtonText: 'Ok'
                });
            }
        }

    });

});

/**Función que crea el boton ELIMINAR en la tabla de Detalle de Aportaciones/Baja */
function eliminarFormatter(value, row) {
    return '<div class="d-flex justify-content-center"> <button type="button" class="btn btn-outline-danger btn-icon" onclick="eliminarFila('+row.id+')" data-toggle="tooltip" data-placement="top" title="Eliminar" > <i class="fas fa-trash-alt"></i> </button> </div>'
}

/**Función que usa eliminarFormatter (La función de arriba) para eliminar el elemento de la tabla  con la libreria Bootstrap Table*/
function eliminarFila(id){
    $(document).ready({ urlEliminar });
    Swal.fire({
        title: 'Eliminar',
        text: "¿Esta seguro(a) de eliminar este entregable?",
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
                    table.bootstrapTable('remove', {
                        field: 'id',
                        values: id.toString()
                    })
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    table.bootstrapTable('remove', {
                        field: 'id',
                        values: id.toString()
                    })
                }
            });
        }
    })
}

//Función de boostrap que activa el Tooltip (Mensaje en los iconos)
$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})

function mostrarPDF(base64PDF) {
    const pdfViewer = document.getElementById('pdfmodal');
    pdfViewer.src = "data:application/pdf;base64," + base64PDF;
    $('#pdfModal').modal('show');
}
