const formEjecucionServicio = $( "#form_ejecucion_servicio" );
const validator = $( "#form_ejecucion_servicio" ).validate();
const btnFinalizarEjecucionServicio = $("#bnt_finaliza_ejecucion_servicios");
const btnDescargarDetallePDF = $("#descargar_ejecucion_servicio");

$(document).ready(function () {
    /**Función que recibe el arreglo de los detallesdelServicio y
     * carga los datos en la tabla de boostrap, este arreglo vienen del controlador */
    if ( detalleSolicitaServicio ) {
        //Función de JQuery validate
        $.each( detalleSolicitaServicio, function(index, detalle) {

            $( '#table' ).bootstrapTable( 'insertRow', {
                index: 0,
                row: {
                    id: detalle.p08_detalle_solicita_servicio_id,
                    servicio_id: detalle.servicio_id,
                    tipo_servicio: detalle.servicio.nombre_servicio,
                    unidad: detalle.unidad,
                    fecha_estimada: detalle.fecha_estimada,
                    descripcion_servicio: detalle.descripcion_servicio,
                    fecha_entrega: detalle.fecha_entrega,
                    estatus_detalle: detalle.estatus_detalle,
                    comentarios_servicio: detalle.comentarios_servicio,
                    asignado_a: detalle.asignado_a,
                    confirmado_por: detalle.confirmado_por,
                },
            });
        });
        $.each( detalleSolicitaServicio, function(index, value) {
            $( "#estatus_detalle_"+value.p08_detalle_solicita_servicio_id ).rules( "add", {
                required: true,
                messages: {
                    required: "Debe seleccionar y guardar un estatus para el servicio",
                }
            });
            $( "#fecha_entrega_"+value.p08_detalle_solicita_servicio_id ).rules( "add", {
                required: true,
                messages: {
                    required: "Eliga una fecha",
                }
            });
            $( "#comentarios_servicio_"+value.p08_detalle_solicita_servicio_id ).rules( "add", {
                required: true,
                messages: {
                    required: "Debe completar este campo",
                }
            });
            // Solo para teléfonia son obligatorios estos campos
            if ( claveServicio === 'telefonia' ) {
                $( "#asignado_a_"+value.p08_detalle_solicita_servicio_id ).rules( "add", {
                    required: true,
                    messages: {
                        required: "Debe completar este campo",
                    }
                });
                $( "#confirmado_por_"+value.p08_detalle_solicita_servicio_id ).rules( "add", {
                    required: true,
                    messages: {
                        required: "Debe completar este campo",
                    }
                });
            }
        });

    }

    /**Evento que activa la fecha */
    $('.date-general').click(function (e) {
        e.preventDefault();
        $(this).datepicker({
            format : 'dd/mm/yyyy',
            autoclose : true,
            language : 'es',
            ignoreReadonly : true
        } );
        $(this).datepicker('show');
    });

    $(".normalizar-texto").keyup(function (e) {
        this.value = this.value.toUpperCase();
    });

    /* Evento que finaliza la tarea */
    btnFinalizarEjecucionServicio.click(function (e) {
        e.preventDefault();
        const isValid =  formEjecucionServicio.valid();

        if ( isValid ) {
            let arregloEjecucionServicios = $( '#table' ).bootstrapTable('getData');
            $('#arreglo_servicio').val(JSON.stringify(arregloEjecucionServicios));
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
                    formEjecucionServicio.submit();
                }
            });
        } else {
            Swal.fire({
                title: "Finalizar tarea",
                text: "Para finalizar la tarea, debes capturar la información",
                icon: 'warning',
                confirmButtonColor: '#0BB7AF',
                confirmButtonText: 'Entendido'
            });
        }

    });
});


function fechaEntregaFormatter(value, row){
    return '<input type="text" class="form-control data-input-fecha_entrega date-general" name="fecha_entrega_'+row.id+'" id="fecha_entrega_'+row.id+'"  value="'+(row.fecha_entrega != undefined ? row.fecha_entrega : "")+'" > ';
}

function estatusDetalleFormatter(value, row){
    return '<select class="form-control data-input-estatus_detalle text-uppercase" name="estatus_detalle_'+row.id+'" id="estatus_detalle_'+row.id+'" ><option class="text-uppercase" value="COMPLETADO" '+(row.estatus_detalle == "COMPLETADO" ? "selected" : "" )+' > Servicio prestado </option><option class="text-uppercase" value="PARCIAL" '+(row.estatus_detalle == "PARCIAL" ? "selected" : "" )+' > Servicio prestado parcialmente </option><option class="text-uppercase" value="RECHAZADO" '+(row.estatus_detalle == "RECHAZADO" ? "selected" : "" )+' > Este servicio no será prestado </option></select>';
}

function comentariosServicioFormatter(value, row){
    return '<input class="form-control data-input-comentarios_servicio normalizar-texto" type="text" name="comentarios_servicio_'+row.id+'" id="comentarios_servicio_'+row.id+'" value="'+(row.comentarios_servicio != undefined ? row.comentarios_servicio : "")+'" >';
}

function asignadoAFormatter(value, row){
    return '<input class="form-control data-input-asignado_a normalizar-texto" type="text" name="asignado_a_'+row.id+'" id="asignado_a_'+row.id+'" value="'+(row.asignado_a != undefined ? row.asignado_a : "")+'" >';
}

function confirmadoPorFormatter(value, row){
    return '<input class="form-control data-input-confirmado_por normalizar-texto" type="text" name="confirmado_por_'+row.id+'" id="confirmado_por_'+row.id+'" value="'+(row.confirmado_por != undefined ? row.confirmado_por : "")+'" >';
}

/**El botón activa la Función que permite Guardar Avances en la tabla de Detalle de Servicios */
function guardarAvanceFormatter(value, row) {
    return '<input type="button" class="btn btn-success guardaAvance" name="guarda_avance" onclick="guardarAvance(this, '+row.id+')" value="Guardar avance" />'
}

/**
 * Función para actualizar la los campos de la tabla en la T05
 * @param {*} id del registro seleccionado
 */
function guardarAvance(element, id){
    $table = $('#table');
    let detalle = $table.bootstrapTable('getRowByUniqueId', id );

    //Se accede al atributo(valor) del elemento a través de su id
    campoFecha = $(element).parent().prev().prev().prev().prev().prev().find('.data-input-fecha_entrega').attr("id");
    campoComentario = $(element).parent().prev().prev().prev().prev().find('.data-input-comentarios_servicio').attr("id");
    campoEstatus = $(element).parent().prev().prev().prev().find('.data-input-estatus_detalle').attr("id");
    campoAsignadoA = $(element).parent().prev().prev().find('.data-input-asignado_a').attr("id");
    campoConfirmadoPor = $(element).parent().prev().find('.data-input-confirmado_por').attr("id");

    //Se obtiene el valor del elemento seleccionado
    let fechaEntrega = $(element).parent().prev().prev().prev().prev().prev().find('.data-input-fecha_entrega').val();
    let comentariosServicio = $(element).parent().prev().prev().prev().prev().find('.data-input-comentarios_servicio').val();
    let estatusDetalle = $(element).parent().prev().prev().prev().find('.data-input-estatus_detalle option').filter(':selected').val();
    let asignadoA = $(element).parent().prev().prev().find('.data-input-asignado_a').val();
    let confirmadoPor = $(element).parent().prev().find('.data-input-confirmado_por').val();

    validator.element("#"+campoComentario);
    validator.element("#"+campoEstatus);
    validator.element("#"+campoFecha);
    validator.element("#"+campoAsignadoA);
    validator.element("#"+campoConfirmadoPor);

    if (  validator.element("#"+campoEstatus) && validator.element("#"+campoFecha) && validator.element("#"+campoComentario)) {

        $.ajax({
            type: "post",
            url: urlGuardaAvances,
            data: { id : id,
                    fecha_entrega: fechaEntrega,
                    estatus_detalle: estatusDetalle,
                    comentarios_servicio: comentariosServicio,
                    asignado_a: asignadoA,
                    confirmado_por: confirmadoPor,
                },
            success: function (response) {
                if (response.mensaje) {
                    $('#mensajeGuardarAvance').html( '<p class="alert alert-success" align="center">' + response.mensaje + '</p>' ).fadeIn(400);
                    $('#mensajeGuardarAvance').html( '<p class="alert alert-success" align="center">' + response.mensaje + '</p>' ).fadeOut(4000);
                    $("#mensajeGuardarAvance").prop("disabled", false);
                } else {
                    $('#mensajeGuardarAvance').html( '<p class="alert alert-danger" align="center">' + response.error + '</p>' ).fadeIn(400);
                    $('#mensajeGuardarAvance').html( '<p class="alert alert-danger" align="center">' + response.error + '</p>' ).fadeOut(4000);
                    $("#mensajeGuardarAvance").prop("disabled", false);
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {

            }
        });
    }
}

// Evento para descargar detalle
btnDescargarDetallePDF.click(function (e) {
    e.preventDefault();
    Swal.fire({
        title: 'Detalle(s)',
        text: "¿Descargar detalle(s)?",
        icon: 'question',
        showCancelButton: true,
        cancelButtonColor: '#F64E60',
        cancelButtonText: 'No',
        confirmButtonColor: '#0BB7AF',
        confirmButtonText: 'Si'
    }).then((result) => {
        if (result.isConfirmed) {
            KTApp.blockPage({
                overlayColor: '#000000',
                state: 'danger',
                message: 'Por favor, espere...'
            });
            let url = btnDescargarDetallePDF.attr('href');
            let data = '';

            $.ajax({
                type: "GET",
                url: url,
                data: data,
                success: function (response) {
                    let url = "data:application/pdf;base64," + response.pdf;
                    let link = document.createElement('a');
                    link.href = url;
                    link.download = response.nombre;
                    link.click();

                    KTApp.unblockPage();
                    Swal.fire({
                        text: '¡Descarga exitosa!',
                        icon: 'success',
                        confirmButtonColor: '#0BB7AF',
                        confirmButtonText: 'Ok'
                    })
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    KTApp.unblockPage();
                    Swal.fire({
                        html: '¡Error, intente más tarde o comuniquese con el área correspondiente!',
                        icon: 'warning',
                        confirmButtonColor: '#0BB7AF',
                        confirmButtonText: 'Ok'
                    });
                }
            });
        }
    })
});

function mostrarPDF(base64PDF) {
    const pdfViewer = document.getElementById('pdfmodal');
    pdfViewer.src = "data:application/pdf;base64," + base64PDF;
    $('#pdfModal').modal('show');
}
