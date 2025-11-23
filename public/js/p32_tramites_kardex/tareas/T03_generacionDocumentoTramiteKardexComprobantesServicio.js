const formSeguimientos = $("#id_form_generacion_documento_kardex_seguimientos");
const tableSeguimientos = $('#table_seguimientos');
const btnAgregarSeguimiento = $('#btn_agregar_seguimiento');
const textArea = $('#textarea_seguimiento');
const formDetalles = $("#id_form_generacion_documento_kardex_detalles");
const tableDetalles = $('#table_detalles');
const btnAgregarDetalle = $('#btn_agregar_detalle');
const formFinalizarTarea = $("#id_form_generacion_documento_kardex");
const selectArea = $("#area_id");

selectArea.select2({
    placeholder: "Selecciona una opción"
});

$(document).ready(function () {
    if ( seguimientos.length > 0 ){
        tableSeguimientos.bootstrapTable("destroy");
        tableSeguimientos.bootstrapTable({data: seguimientos});
    } else {
        tableSeguimientos.bootstrapTable();
    }

    if ( detalles.length > 0 ){
        tableDetalles.bootstrapTable("destroy");
        tableDetalles.bootstrapTable({data: detalles});
    } else {
        tableDetalles.bootstrapTable();
    }
});

btnAgregarSeguimiento.click(function (evento) {
    evento.preventDefault();

    let comentario_seguimiento = textArea.val();
    let validForm = formSeguimientos.valid();
    // Valida si contiena datos el textarea
    if ( comentario_seguimiento !== '' && validForm ) {
        Swal.fire({
            title: 'Seguimiento',
            text: "¿Agregar seguimiento?",
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
                let { tramite_kardex_id } = tramiteKardex;
                $.ajax({
                    type: "POST",
                    url: urlGuardarSeguimientos,
                    data: { tramite_kardex_id, comentario_seguimiento },
                    success: function (response) {
                        KTApp.unblockPage();
                        if ( response.estatus ) {
                            tableSeguimientos.bootstrapTable("destroy");
                            tableSeguimientos.bootstrapTable({data: response.data});
                            textArea.val('');
                            Swal.fire({
                                text: response.mensaje,
                                icon: 'success',
                                confirmButtonColor: '#0BB7AF',
                                confirmButtonText: 'Ok'
                            })
                        }
                        else {
                            Swal.fire({
                                html: response.mensaje,
                                icon: 'warning',
                                confirmButtonColor: '#0BB7AF',
                                confirmButtonText: 'Ok'
                            });
                        }
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
    } else {
        Swal.fire({
            title: "Seguimiento",
            html: "Debes capturar un seguimiento primero, <br> para que se pueda agregar a la tabla",
            icon: 'warning',
            confirmButtonColor: '#0BB7AF',
            confirmButtonText: 'Ok'
        });
    }

});

function eliminarSeguimientoFormatter(value, row) {
    return '<div class="d-flex justify-content-center"> <button type="button" class="btn btn-outline-danger btn-icon" onclick="eliminarSeguimiento('+row.seguimiento_id+')" data-toggle="tooltip" data-placement="top" title="Eliminar" > <i class="fas fa-trash-alt"></i> </button> </div>'
}

function eliminarSeguimiento(seguimiento_id) {
    Swal.fire({
        title: 'Eliminar',
        text: "¿Esta seguro(a) de eliminar este seguimiento?",
        icon: 'question',
        showCancelButton: true,
        cancelButtonColor: '#F64E60',
        cancelButtonText: 'No',
        confirmButtonColor: '#0BB7AF',
        confirmButtonText: 'Si'
    }).then((result) => {
        if (result.isConfirmed) {
            let { tramite_kardex_id } = tramiteKardex;
            $.ajax({
                type: "POST",
                url: urlEliminarSeguimientos,
                data: { tramite_kardex_id, seguimiento_id },
                success: function (response) {
                    if ( response.estatus ) {
                        tableSeguimientos.bootstrapTable("destroy");
                        tableSeguimientos.bootstrapTable({data: response.data});
                        Swal.fire({
                            text: response.mensaje,
                            icon: 'success',
                            confirmButtonColor: '#0BB7AF',
                            confirmButtonText: 'Ok'
                        })
                    }
                    else {
                        Swal.fire({
                            html: response.mensaje,
                            icon: 'warning',
                            confirmButtonColor: '#0BB7AF',
                            confirmButtonText: 'Ok'
                        });
                    }
                }
            });
        }
    })
}

btnAgregarDetalle.click(function (evento) {
    evento.preventDefault();

    let validForm = formDetalles.valid();
    // Valida si contiena datos el textarea
    if ( validForm ) {
        Swal.fire({
            title: 'Detalle',
            text: "¿Agregar detalle?",
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
                let dataDetalle = formDetalles.serializeArray();
                let { tramite_kardex_id } = tramiteKardex;
                dataDetalle.push({ name: 'tramite_kardex_id', value: tramite_kardex_id });

                $.ajax({
                    type: "POST",
                    url: urlGuardarDetalles,
                    data: dataDetalle,
                    success: function (response) {
                        KTApp.unblockPage();
                        if ( response.estatus ) {
                            tableDetalles.bootstrapTable("destroy");
                            tableDetalles.bootstrapTable({data: response.data});
                            formDetalles.trigger("reset");
                            Swal.fire({
                                text: response.mensaje,
                                icon: 'success',
                                confirmButtonColor: '#0BB7AF',
                                confirmButtonText: 'Ok'
                            })
                        }
                        else {
                            Swal.fire({
                                html: response.mensaje,
                                icon: 'warning',
                                confirmButtonColor: '#0BB7AF',
                                confirmButtonText: 'Ok'
                            });
                        }
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
    }

});

function eliminarDetalleFormatter(value, row) {
    return '<div class="d-flex justify-content-center"> <button type="button" class="btn btn-outline-danger btn-icon" onclick="eliminarDetalle('+row.detalle_id+')" data-toggle="tooltip" data-placement="top" title="Eliminar" > <i class="fas fa-trash-alt"></i> </button> </div>'
}

function eliminarDetalle(detalle_id) {
    Swal.fire({
        title: 'Eliminar',
        text: "¿Esta seguro(a) de eliminar este detalle?",
        icon: 'question',
        showCancelButton: true,
        cancelButtonColor: '#F64E60',
        cancelButtonText: 'No',
        confirmButtonColor: '#0BB7AF',
        confirmButtonText: 'Si'
    }).then((result) => {
        if (result.isConfirmed) {
            let { tramite_kardex_id } = tramiteKardex;
            $.ajax({
                type: "POST",
                url: urlEliminarDetalles,
                data: { tramite_kardex_id, detalle_id },
                success: function (response) {
                    if ( response.estatus ) {
                        tableDetalles.bootstrapTable("destroy");
                        tableDetalles.bootstrapTable({data: response.data});
                        Swal.fire({
                            text: response.mensaje,
                            icon: 'success',
                            confirmButtonColor: '#0BB7AF',
                            confirmButtonText: 'Ok'
                        })
                    }
                    else {
                        Swal.fire({
                            html: response.mensaje,
                            icon: 'warning',
                            confirmButtonColor: '#0BB7AF',
                            confirmButtonText: 'Ok'
                        });
                    }
                }
            });
        }
    })
}

const validatorFormFinalizarTarea = formFinalizarTarea.validate({
    submitHandler: function(form) {
        let seguimientos = tableSeguimientos.bootstrapTable('getData');
        let detalles = tableDetalles.bootstrapTable('getData');
        if ( seguimientos.length > 0 && detalles.length > 0 ) {
            Swal.fire({
                title: "¿Está seguro?",
                text: "Antes de continuar, verifique que los datos ingresados sean correctos. Después de finalizar la tarea, no podrá regresar.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Sí, continuar",
                cancelButtonText: "Cancelar",
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    KTApp.blockPage({
                        overlayColor: '#000000',
                        state: 'danger',
                        message: 'Por favor, espere...'
                    });
                    form.submit();
                }
            });
        } else {
            Swal.fire({
                html: `Para poder finalizar la tarea,</br> deben capturar al menos un ${seguimientos.length == 0 ? '<b>Seguimiento</b>' : '<b>Detalle</b>' }.`,
                icon: 'warning',
                confirmButtonColor: '#0BB7AF',
                confirmButtonText: 'Ok'
            });
        }
    }
});
