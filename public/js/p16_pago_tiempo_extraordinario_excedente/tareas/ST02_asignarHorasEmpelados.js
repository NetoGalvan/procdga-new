const formValidarEmpleado = $( "#form_busqueda_empleado" );
const btnBuscar = $("#btn_buscar_empleado");
const selectHorasEmpleados = $("#datos_empleado");
const btnFinalizarTarea = $("#finalizarTarea");
const formFinalizarTarea = $("#form_finalizar_tarea");

const formGuardarHoras = $("#asignarHorasForm"); // Form de las Horas
const tablaDatosEmpleado = $('#tabla_asignar_horas'); // Tabla Horas Empleado

$(document).ready(function(){
    // Inicializa la tabla
    if ( empleadosAgregados.length > 0 ){
        tablaDatosEmpleado.bootstrapTable("destroy");
        tablaDatosEmpleado.bootstrapTable({data: empleadosAgregados});
    } else {
        tablaDatosEmpleado.bootstrapTable();
    }

});

jQuery.validator.addClassRules("numero", {
    required: true,
    number: true,
});

function horasFormatter(value, row) {
    let { horas_empleado_id, horas, nivel_salarial, sindicalizado, tipo, codigo_puesto, subproceso_pago_tiempo_extra_excedente_id } = row;
    return `<input type="number" min="1" max='24' class="form-control normalizar-texto horas"
            name="horas[]" id="horas_${horas_empleado_id}"
            value="${horas ? horas : '' }"
            onchange="calculoMontoBruto(${nivel_salarial},'${sindicalizado}',${horas_empleado_id}, ${presuQuinceSubarea.presupuesto_sub_area},'${tipo}','${codigo_puesto}','${subproceso_pago_tiempo_extra_excedente_id}')">`;
}

function montoFormatter(value, row) {
    let { horas_empleado_id, monto_bruto } = row;
    return `<input type="number" readonly class="form-control normalizar-texto monto_bruto"
            name="monto_bruto[]" id="monto_bruto_${horas_empleado_id}"
            value="${ monto_bruto ? monto_bruto : '' }">`;
}

function observacionesFormatter(value, row) {
    let { horas_empleado_id, observaciones } = row;
    return `<input type="text" class="form-control normalizar-texto observaciones"
            name="observaciones" id="observaciones_${horas_empleado_id}"
            value="${ observaciones ? observaciones : '' }" onchange="guardarObservaciones(${horas_empleado_id})">`;
}

function nombreFormatter(value, row) {
    let { apellido_materno, apellido_paterno, nombre_empleado } = row;
    return `${nombre_empleado} ${apellido_paterno} ${apellido_materno}`;
}

function calculoMontoBruto(nivel_salarial, tipo_personal, horas_empleado_id, presupuesto_sub_area, tipo_pago, codigo_puesto, subproceso_pago_tiempo_extra_excedente_id){

    let horas = $('#horas_'+horas_empleado_id).val();
    let validator = formGuardarHoras.validate();

    if(validator.element('#horas_'+horas_empleado_id)){
        let datos = {nivel_salarial:nivel_salarial, tipo_personal:tipo_personal, horas:horas, presupuesto_sub_area:presupuesto_sub_area, tipo_pago:tipo_pago, codigo_puesto:codigo_puesto, subproceso_pago_tiempo_extra_excedente_id:subproceso_pago_tiempo_extra_excedente_id };
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: calcularMontoRoute,
            data: datos,
            dataType: 'json',
            success: function(response){
                if (response.estatus) {
                    $('#monto_bruto_'+horas_empleado_id).val(response.mensaje)
                    let instancia_tarea_id = instanciaTarea.instancia_tarea_id;
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        url: guardarDatosAutomaticamente,
                        data: {datos:datos, monto_bruto:$('#monto_bruto_'+horas_empleado_id).val(), empleado_id:horas_empleado_id, 'instancia_tarea_id' :instancia_tarea_id, 'costo_unitario' : response.costo_unitario},
                        dataType: 'json',
                        success: function(respuesta){
                            if (respuesta.estatus) {

                            } else {
                                Swal.fire(respuesta.mensaje, "", "error");
                                $('#horas_'+horas_empleado_id).val(respuesta.data.horas);
                                $('#monto_bruto_'+horas_empleado_id).val(respuesta.data.monto_bruto);
                            }
                        }
                    });

                } else {
                    Swal.fire(response.mensaje, "", "error");
                }
            }
        });
    }
    else{
        validator.focusInvalid();
    }
}

function guardarObservaciones(empleado_id) {

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        url: guardarObservacionesAutomaticamente,
        data: { empleado_id:empleado_id, observaciones:$('#observaciones_'+empleado_id).val() },
        dataType: 'json',
        success: function(respuesta){
            if (respuesta.estatus) {

            } else {
                Swal.fire({
                    "title": "Fuera del presupuesto",
                    "text": respuesta.mensaje,
                    "icon": "error",
                    "confirmButtonColor": '#0abb87',
                    "confirmButtonText": 'Aceptar',
                    "allowOutsideClick": false,
                }).then((result) => {
                    $('#observaciones_'+horas_empleado_id).val(respuesta.data.observaciones);
                });
            }
        }
    });
}

function validacionForm() {

    const validacion = formValidarEmpleado.validate({
        onfocusout: false,
        rules: {
            datos_empleado : {
                required: true
            }
        },
        messages: {
            datos_empleado: {
                required : 'Debe buscar y seleccionar a un empleado para poder continuar'
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

btnBuscar.click(function(e) {
    e.preventDefault();

    let validacion = validacionForm();
    let validado = validacion.form();

    if (validado) {

        let datos_empleado = selectHorasEmpleados.val();
        let tipo = $("#tipo").val();
        let folio = $("#folio").val();
        let subproceso_id = $("#subproceso_id").val();
        let presu_quince_subarea_id = $("#presu_quince_subarea_id").val();
        let pago_id = $("#pago_id").val();
        var datosEmpleado = JSON.parse(datos_empleado);
        let instancia_tarea_id = instanciaTarea.instancia_tarea_id;

        if ( datosEmpleado.nivel_salarial > 88 && datosEmpleado.nivel_salarial < 200 ) {
            ajaxGuardarEmpleado(datos_empleado, tipo, folio, subproceso_id, presu_quince_subarea_id, pago_id, instancia_tarea_id).done(function (respuesta) {
                if (respuesta.estatus) {
                    tablaDatosEmpleado.bootstrapTable("destroy");
                    tablaDatosEmpleado.bootstrapTable({data: respuesta.data});
                    // Limpiar Select
                    selectHorasEmpleados.val('').trigger('change');
                    $(`#horas_${respuesta.idEmpleadoCreado}`).val(respuesta.totalHorasExtra);
                    $(`#horas_${respuesta.idEmpleadoCreado}`).trigger('change');
                    Swal.fire({
                        "text": respuesta.mensaje,
                        "icon": "success",
                        "confirmButtonColor": '#0abb87',
                        "confirmButtonText": 'Aceptar',
                        "allowOutsideClick": false,
                    });
                } else {
                    Swal.fire('¡Información!',respuesta.mensaje,'warning');
                }
            }).fail(function(data) {
                Swal.fire('¡Información!',data.mensaje,'warning');
            }).always(function() {
                KTApp.unblockPage();
            });

        }else if( datosEmpleado.nivel_salarial == 1184 ){
            ajaxGuardarEmpleado(datos_empleado, tipo, folio, subproceso_id, presu_quince_subarea_id, pago_id, instancia_tarea_id).done(function (respuesta) {
                if (respuesta.estatus) {
                    tablaDatosEmpleado.bootstrapTable("destroy");
                    tablaDatosEmpleado.bootstrapTable({data: respuesta.data});
                    // Limpiar Select
                    selectHorasEmpleados.val('').trigger('change');
                    $(`#horas_${respuesta.idEmpleadoCreado}`).val(respuesta.totalHorasExtra);
                    $(`#horas_${respuesta.idEmpleadoCreado}`).trigger('change');
                    Swal.fire({
                        "text": respuesta.mensaje,
                        "icon": "success",
                        "confirmButtonColor": '#0abb87',
                        "confirmButtonText": 'Aceptar',
                        "allowOutsideClick": false,
                    });
                } else {
                    Swal.fire('¡Información!',respuesta.mensaje,'warning');
                }
            }).fail(function(data) {
                Swal.fire('¡Información!',data.mensaje,'warning');
            }).always(function() {
                KTApp.unblockPage();
            });
        }else{
            Swal.fire("A los empleados con nivel salarial menor al 89 y superior al 199 no se les puede otorgar esta prestación.", "A excepción de nivel salarial 1184, este si tiene la prestación.", "warning");
        }
    }
});

function ajaxGuardarEmpleado(empleado, tipo, folio, subproceso_id, presu_quince_subarea_id, pago_id, instancia_tarea_id) {
    KTApp.blockPage({
        overlayColor: '#000000',
        state: 'danger',
        message: 'Por favor, espere...'
    });
    return $.ajax({
                type: 'post',
                url: agregarEmpleadoRoute,
                data: {empleado, tipo, folio, subproceso_id, presu_quince_subarea_id, pago_id, instancia_tarea_id},
                asyn:false,
            });
}

function eliminarFormatter(value, row) {
    let { horas_empleado_id } = row;
	return `<button type="button" class="btn btn-outline-danger btn-icon" onclick="eliminarFila(${horas_empleado_id})" data-toggle="tooltip" data-placement="top" title="Eliminar empleado"><i class="far fa-trash-alt"></i></button>`;
}

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
            let subproceso_id = $("#subproceso_id").val();
            let instancia_tarea_id = instanciaTarea.instancia_tarea_id;
            KTApp.blockPage({
                overlayColor: '#000000',
                state: 'danger',
                message: 'Por favor, espere...'
            });
            $.ajax({
                type: "POST",
                url: borrarEmpleadoAreaRoute,
                data: {'id' : id, 'subproceso_id' : subproceso_id, 'instancia_tarea_id' : instancia_tarea_id},
                asyn:false,
                success: function(data){
                    if ( data.estatus ) {
                        tablaDatosEmpleado.bootstrapTable("destroy");
                        tablaDatosEmpleado.bootstrapTable({data: data.data});
                        swal.fire({
                            "title": data.mensaje,
                            "icon": "success",
                            "confirmButtonColor": '#0abb87',
                            "confirmButtonText": 'Aceptar',
                            "allowOutsideClick": false,
                        }).then((result) => {
                            if (result.value) {
                            }
                        });
                    }else{
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

var validator = formGuardarHoras.validate({
    onfocusout: false,
    rules: {
        "horas[]": {
            required: true,
        },
        "monto_bruto[]": {
            required: true,
        }
    },
    messages: {
        horas: {
            required: 'Campo obligatorio'
        },
        monto_bruto: {
            required: 'Campo obligatorio',
        }
    },
    errorPlacement: function(label, element) {
        element.addClass('error');
        label.insertAfter(element);
    }
});

btnFinalizarTarea.click(function(e) {

    if ( tablaDatosEmpleado.bootstrapTable('getData').length >= 1 ) {

        if(document.querySelector(".horas") && document.querySelector(".monto_bruto") ){

            var horas = $(".horas").valid();
            var monto_bruto = $(".monto_bruto").valid();

            if (horas && monto_bruto ) {
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
            }
        } else {
            validator.focusInvalid();
        }
    } else {
        Swal.fire("Debes agregar al menos un empleado antes de finalizar la tarea.", "", "warning");
    }
});
