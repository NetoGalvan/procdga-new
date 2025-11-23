const btnBuscar = $("#btn_buscar_empleado");
const contenedorBtnBuscar = $(".contenerdor_btn_buscar_empleado");
const btnEvaluar = $("#btn_evaluar_empleado");
const formValidarEmpleado = $( "#form_busqueda_empleado" );
const tableEmpleadosAgregados = $('#tabla_empleados_agregados');
const tableEvaluarEmpleado = $('#tabla_evaluar_empleado');
const contenedorTableEvaluarEmpleado = $(".contenedor_tabla_evaluar_empleado");
const selectMes = $("#mes_inicio_evaluacion");
const selectBuscarEmpleado = $("#datos_empleado");
const formFinalizarTarea = $( "#form_datos_solicitudes" );
const btnFinalizar = $("#btn_finalizar");
let inputEvaluacionEmpleado = $("#evaluacion_empleado");

$(document).ready(function () {
    if ( empleadosRegistrados.length > 0 ){
        tableEmpleadosAgregados.bootstrapTable("destroy");
        tableEmpleadosAgregados.bootstrapTable({data: empleadosRegistrados});
    } else {
        tableEmpleadosAgregados.bootstrapTable();
    }

    selectMes.select2({
        placeholder: "Selecciona una opción"
    });
});

function nombreFormatter(value, row) {
    let { apellido_materno, apellido_paterno, nombre_empleado } = row;
    return `${nombre_empleado} ${apellido_paterno} ${apellido_materno}`;
}

function eliminarFormatter(value,row){
    return `<button type="button" class="btn btn-outline-danger btn-icon" onclick="eliminarFila(${row.premio_puntualidad_empleado_id})"><i class="fas fa-trash-alt"></i></button>`;
}

function descargarReporteFormatter(value, row) {
    let acciones =  `<button type="button" class="btn btn-outline-danger btn-icon"
                        onclick="descargarReporte(${row.premio_puntualidad_empleado_id})">
                        <i class="fas fa-file-pdf"></i>
                    </button>`;
    return acciones;
}

// Valida input empleado
function validacionForm() {
    const validacion = formValidarEmpleado.validate({
        onfocusout: false,
        rules: {
            datos_empleado : {
                required: true
            },
            mes_inicio_evaluacion: {
                required: true,
                select: '-1'
            }
        },
        messages: {
            datos_empleado: {
                required : 'Seleccione una opción'
            },
            mes_inicio_evaluacion: {
                required: 'Campo obligatorio'
            }
        },
        errorPlacement: function(error, element) {
            if (element.hasClass('select2') && element.next('.select2-container').length) {
                error.insertAfter(element.next('.select2-container'));
            } else {
                error.insertAfter(element);
            }

        },
    });
    return validacion;
}

$.validator.addMethod("select", function(value, element, arg){
    return arg !== value;
}, 'Seleccione el mes de evaluación');

btnEvaluar.click(function(e) {
    e.preventDefault();
    let validacion = validacionForm();
    let validado = validacion.form();

    if (validado) {

        let datos_empleado = selectBuscarEmpleado.val();
        let datosEmpleado = JSON.parse(datos_empleado);
        let mesInicioEvaluacion = document.getElementById("mes_inicio_evaluacion").value;
        let premioPuntualidadInscripcionId = subproceso.premio_puntualidad_inscripcion_id;
        let premioPuntualidadAreaId = subArea.premio_puntualidad_area_id;

        if (datosEmpleado.seccion_sindical != 0) {
            inputEvaluacionEmpleado.val('');
            KTApp.blockPage({
                overlayColor: '#000000',
                state: 'danger',
                message: 'Por favor, espere...'
            });
            $.ajax({
                type: "POST",
                url: evaluarEmpleadoRoute,
                data: {datos_empleado, mesInicioEvaluacion, premioPuntualidadInscripcionId, premioPuntualidadAreaId},
                success: function(response){
                    if (response.estatus) {
                        inputEvaluacionEmpleado.val(JSON.stringify(response.data));
                        contenedorTableEvaluarEmpleado.removeClass("d-none");
                        tableEvaluarEmpleado.bootstrapTable("destroy");
                        tableEvaluarEmpleado.bootstrapTable({data: response.data});
                        Swal.fire({
                            "text": response.mensaje,
                            "icon": "success",
                            "confirmButtonColor": '#0abb87',
                            "confirmButtonText": 'Aceptar',
                            "allowOutsideClick": false,
                        });
                        validarDatosEvaluacion();
                    } else {
                        Swal.fire('¡Información!',response.mensaje,'warning');
                    }
                },
                error: function (responseText, textStatus, errorThrown) {
                    Swal.fire({
                        title: 'Error',
                        text: errorThrown,
                        icon: 'error',
                        confirmButtonColor: '#F64E60',
                        confirmButtonText: 'Ok'
                    });
                },
                complete: function (xhr, status) {
                    KTApp.unblockPage();
                }

            });
        } else {
            Swal.fire("No se puede evaluar al empleado porque NO es un empleado sindicalizado.", "", "warning");
            Swal.fire({
                title: 'El empleado seleccionado no puede participar ya que NO es sindicalizado',
                icon: 'warning',
                confirmButtonColor: '#0BB7AF',
                confirmButtonText: 'Ok'
            })
        }
    }
});

// Formatter para evaluar
function evaluacionFinalFormatter(value, row, index) {
    return `${value}`;
}

// Evento que detecta cuando estan buscando otro dato de empleado nuevo
selectBuscarEmpleado.change( function() {
    tableEvaluarEmpleado.bootstrapTable("destroy");
    contenedorTableEvaluarEmpleado.addClass("d-none");
    contenedorBtnBuscar.addClass("d-none");
});

function validarDatosEvaluacion() {
    let EvaluacionEmpleado = tableEvaluarEmpleado.bootstrapTable('getData');
    let califica = 0;
    EvaluacionEmpleado.forEach(function(fila, index) {
        let renglon = tableEvaluarEmpleado.find('tr[data-index="' + index + '"]');
        if ( fila.evaluacionFinal == 'CALIFICA' ) {
            califica ++;
            renglon.addClass('table-success');
        } else {
            renglon.addClass('table-danger');
        }
    });

    if ( califica == 6 ) {
        contenedorBtnBuscar.removeClass("d-none");
    } else {
        contenedorBtnBuscar.addClass("d-none");
    }
}

btnBuscar.click(function(e) {
    e.preventDefault();
    let validacion = validacionForm();
    let validado = validacion.form();

    if (validado) {

        let datos_empleado = selectBuscarEmpleado.val();
        let datosEmpleado = JSON.parse(datos_empleado);
        let mesInicioEvaluacion = document.getElementById("mes_inicio_evaluacion").value;
        let premioPuntualidadInscripcionId = subproceso.premio_puntualidad_inscripcion_id;
        let premioPuntualidadAreaId = subArea.premio_puntualidad_area_id;
        let evaluacionEmpleado = inputEvaluacionEmpleado.val();

        if (datosEmpleado.seccion_sindical != 0) {
            KTApp.blockPage({
                overlayColor: '#000000',
                state: 'danger',
                message: 'Por favor, espere...'
            });
            $.ajax({
                type: "POST",
                url: agregarEmpleadoRoute,
                data: {datos_empleado, mesInicioEvaluacion, premioPuntualidadInscripcionId, premioPuntualidadAreaId, evaluacionEmpleado},
                success: function(response){
                    if (response.estatus) {
                        tableEmpleadosAgregados.bootstrapTable("destroy");
                        tableEmpleadosAgregados.bootstrapTable({data: response.data});
                        // Limpiar Select
                        selectBuscarEmpleado.val('').trigger('change');
                        Swal.fire({
                            "text": response.mensaje,
                            "icon": "success",
                            "confirmButtonColor": '#0abb87',
                            "confirmButtonText": 'Aceptar',
                            "allowOutsideClick": false,
                        });
                    } else {
                        Swal.fire('¡Información!',response.mensaje,'warning');
                    }
                },
                error: function (responseText, textStatus, errorThrown) {
                    Swal.fire({
                        title: 'Error',
                        text: errorThrown,
                        icon: 'error',
                        confirmButtonColor: '#F64E60',
                        confirmButtonText: 'Ok'
                    });
                },
                complete: function (xhr, status) {
                    KTApp.unblockPage();
                }

            });
        } else {
            Swal.fire("No se puede evaluar al empleado porque NO es un empleado sindicalizado.", "", "warning");
            Swal.fire({
                title: 'El empleado seleccionado no puede participar ya que NO es sindicalizado',
                icon: 'warning',
                confirmButtonColor: '#0BB7AF',
                confirmButtonText: 'Ok'
            })
        }
    }
});

function eliminarFila(id){

    swal.fire({
        html: "¿Está seguro de eliminar este empleado?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, continuar",
        cancelButtonText: "Cancelar",
        reverseButtons: true,
        allowOutsideClick: false,
    }).then((result) => {
        if (result.value) {
            let premioPuntualidadAreaId = subArea.premio_puntualidad_area_id;
            KTApp.blockPage({
                overlayColor: '#000000',
                state: 'danger',
                message: 'Por favor, espere...'
            });
            $.ajax({
                type: "POST",
                url: borrarEmpleadoAreaRoute,
                data: {id, premioPuntualidadAreaId},
                asyn:false,
                success: function(data){
                    if ( data.estatus ) {
                        tableEmpleadosAgregados.bootstrapTable("destroy");
                        tableEmpleadosAgregados.bootstrapTable({data: data.data});
                        swal.fire({
                            "title": data.mensaje,
                            "icon": "success",
                            "confirmButtonColor": '#0abb87',
                            "confirmButtonText": 'Aceptar',
                            "allowOutsideClick": false,
                        });
                    } else {
                        Swal.fire(data.mensaje, "", "error");
                    };
                },
                error: function (responseText, textStatus, errorThrown) {
                    Swal.fire({
                        title: 'Error',
                        text: errorThrown,
                        icon: 'error',
                        confirmButtonColor: '#F64E60',
                        confirmButtonText: 'Ok'
                    });
                },
                complete: function (xhr, status) {
                    KTApp.unblockPage();
                }
            });
        }
    });
}

function descargarReporte(id) {

    KTApp.blockPage({
        overlayColor: '#000000',
        state: 'danger',
        message: 'Por favor, espere...'
    });

    $.ajax({
        type: 'GET',
        url: urlPdfReporteEmpleado+'/'+id,
        xhrFields: {
            responseType: 'blob' // Configura la respuesta como un objeto Blob
        },
        success: function(response) {
            let link = document.createElement('a');
            let url = window.URL.createObjectURL(response);
            link.href = url;
            link.download = 'reporte_empleado.pdf';
            link.click();
            window.URL.revokeObjectURL(url);
            Swal.fire({
                text: '¡Descarga exitosa!',
                icon: 'success',
                confirmButtonColor: '#0BB7AF',
                confirmButtonText: 'Ok'
            })
        },
        error: function(jqXHR, textStatus, errorThrown) {
            Swal.fire({
                html: '¡Error, intente más tarde o comuniquese con el área correspondiente!',
                icon: 'warning',
                confirmButtonColor: '#0BB7AF',
                confirmButtonText: 'Ok'
            });
        },
        complete : function(xhr, status) {
            KTApp.unblockPage();
        }
    });
}

btnFinalizar.click(function(e) {

    if ( tableEmpleadosAgregados.bootstrapTable('getData').length >= 1 ) {

        swal.fire({
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
                formFinalizarTarea.submit();
            }
        });

    } else {
        Swal.fire("Debes agregar al menos un empleado antes de finalizar la tarea.", "", "warning");
    }
});
