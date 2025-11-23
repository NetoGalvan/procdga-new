
const tablaDatosEmpleado = $('#tabla_datos_empleado');
const tablaListadoCandidatos = $('#tabla_listado_candidatos');
// Para guardar el Puntaje y el Premio
const formAsignarPP = $("#frm_asignar_pp");
const btnGuardarPP = $("#btn_guardar_lista_candidatos");
// Para agregar a un nuevo candidato
const formBusquedaEmpleado = $("#frm_busqueda_empleado");
const btnGuardarNuevoCandidato = $("#btn_guardar_nuevo_candidato");
const btnBuscar = $("#btn_buscar_empleado");
const selectEmpleadosT01 = $("#datos_empleado");
// Finalizar o Continuar
const btnContinuar = $("#continuar_tarea");
const btnFinalizar = $("#finalizar_tarea");
const btnCancelar = $("#cancelar_proceso");
const formFinalizar = $('#frm_finalizar');
const inputTipoFin = $('#tipo_fin');
let tipoFin = '';

$(document).ready(function(){
    tablaDatosEmpleado.bootstrapTable();
    tablaListadoCandidatos.bootstrapTable();

    if ( candidatos_premio.length == 0) {
        btnContinuar.prop('disabled', true);
        btnFinalizar.prop('disabled', false);
    } else {
        if (yaHuboComite == null) {
            btnFinalizar.prop('disabled', true);
        } else {
            $("#agregar_candidatos_premio").hide();
        }
    }
});

btnGuardarPP.click(function() {

    if(document.querySelector(".puntaje") && document.querySelector(".premios") ){

        var puntaje = $(".puntaje").valid();
        var premio = $(".premios").valid();

        if (puntaje && premio ) {

            var url = formAsignarPP.attr('action');

            swal.fire({
                "html": "Esta a punto de guardar <br><b> el Puntaje y el Premio </b><br><br> ¿Está seguro de continuar?",
                "icon": "warning",
                "confirmButtonColor": '#0abb87',
                "confirmButtonText": 'Aceptar',
                "showCancelButton": true,
                "cancelButtonColor": '#fd397a',
                "cancelButtonText": 'Cancelar',
                "allowOutsideClick": false,
            }).then((result) => {

                if (result.value) {

                    $.ajax({

                        type: "POST",
                        url: url,
                        data: formAsignarPP.serialize(),
                        asyn:false,
                        success: function(data){

                            if ( data.estatus ) {
                                swal.fire({
                                    "text": data.mensaje,
                                    "icon": "success",
                                    "confirmButtonColor": '#0abb87',
                                    "confirmButtonText": 'Aceptar',
                                    "allowOutsideClick": false,
                                });

                            }else{
                                swal.fire({
                                    "text": data.mensaje,
                                    "icon": "warning",
                                    "confirmButtonColor": '#0abb87',
                                    "confirmButtonText": 'Aceptar',
                                    "allowOutsideClick": false,
                                });
                            };
                        }
                    });
                }
            });
        }
    }
});

let validatorPP = formAsignarPP.validate({
    onfocusout: false,
    rules: {
        "puntaje[]": {
            required: true,
        },
        "premios[]": {
            required: true,
        }
    },
    messages: {
        puntaje: {
            required: 'Campo obligatorio'
        },
        premios: {
            required: 'Campo obligatorio',
        }
    },
    errorPlacement: function(label, element) {
        element.addClass('error');
        label.insertAfter(element);
    }
});

btnGuardarNuevoCandidato.click(function() {

    if ( formBusquedaEmpleado.valid() ) {

        if ( tablaDatosEmpleado.bootstrapTable('getData').length >= 1 ) {

            var datosTabla = tablaDatosEmpleado.bootstrapTable('getData');
            let datos_empleado = selectEmpleadosT01.val();

            var obj = new Object();
            obj.datosTabla = datosTabla;
            obj.grupo = $("#grupo").val();
            obj.tipo_nombramiento = $("#tipoNombramiento").val();
            obj.comentarios_desempenio = $("#comentario_desem").val();
            obj.comentarios_cursos = $("#comentario_cursos").val();
            obj.datos_empleado = datos_empleado;

            swal.fire({
                "html": "Esta por agregar a un nuevo candidato <br><br> ¿Está seguro de continuar?",
                "icon": "question",
                "confirmButtonColor": '#0abb87',
                "confirmButtonText": 'Aceptar',
                "showCancelButton": true,
                "cancelButtonColor": '#fd397a',
                "cancelButtonText": 'Cancelar',
                "allowOutsideClick": false,
            }).then((result) => {

                if (result.value) {

                    $.ajax({

                        type: "POST",
                        url: urlGuardarNuevoEmpleado,
                        data: obj,
                        asyn:false,
                        success: function(data){

                            if ( data.estatus ) {
                                swal.fire({
                                    "text": data.mensaje,
                                    "icon": "success",
                                    "confirmButtonColor": '#0abb87',
                                    "confirmButtonText": 'Aceptar',
                                    "allowOutsideClick": false,
                                }).then((result) => {
                                    window.location.reload(true);
                                });

                            }else{
                                swal.fire({
                                    "text": data.mensaje,
                                    "icon": "warning",
                                    "confirmButtonColor": '#0abb87',
                                    "confirmButtonText": 'Aceptar',
                                    "allowOutsideClick": false,
                                });
                            };
                        }
                    });
                }
            });
        }else{
            swal.fire({
                "text": "Debe buscar y obtener los datos de un empleado antes de finalizar la tarea",
                "icon": "warning",
                "confirmButtonColor": '#0abb87',
                "confirmButtonText": 'Aceptar',
                "allowOutsideClick": false,
            });
        }
    }
});

$.validator.addMethod("select", function(value, element, arg){
    return arg !== value;
    }, 'Seleccione una opción');

var validator = formBusquedaEmpleado.validate({
    onfocusout: false,
    rules: {
        grupo: {
            required: true,
            campoNoVacio: true
        },
        tipoNombramiento: {
            required: true,
            select: '-1'
        },
        comentario_desem: {
            required: true,
            campoNoVacio: true
        },
        comentario_cursos: {
            required: true,
            campoNoVacio: true
        }
    },
    messages: {
        grupo: {
            required: 'Campo obligatorio',
            campoNoVacio: "No se puede enviar espacios en blanco"
        },
        tipoNombramiento: {
            required: 'Campo obligatorio'
        },
        comentario_desem: {
            required: 'Campo obligatorio',
            campoNoVacio: "No se puede enviar espacios en blanco"
        },
        comentario_cursos: {
            required: 'Campo obligatorio',
            campoNoVacio: "No se puede enviar espacios en blanco"
        }
    },
    errorPlacement: function(label, element) {
        element.addClass('error');
        label.insertAfter(element);
    }
});

// Para descargar el pdf con el listado de candidatos
btnListadoCandidatos = $("#listado_candidatos");

btnListadoCandidatos.click(function() {

    swal.fire({
        "html": "Asegúrese de haber guardado previamente los datos, para que el listado este lo más actualizado posible.<br><br> ¿Está seguro de continuar?",
        "icon": "warning",
        "confirmButtonColor": '#0abb87',
        "confirmButtonText": 'Aceptar',
        "showCancelButton": true,
        "cancelButtonColor": '#fd397a',
        "cancelButtonText": 'Cancelar',
        "allowOutsideClick": false,
    }).then((result) => {

        if (result.value) {
            KTApp.blockPage({
                overlayColor: '#000000',
                state: 'danger',
                message: 'Por favor, espere...'
            });
            ajaxPdfListaCandidatos(premio_id).done(function(respuesta, xhr, response) {
                var a = document.createElement('a');
                var url = window.URL.createObjectURL(respuesta);
                var nombre = response.getResponseHeader('Content-Disposition').split('filename=')[1];
                nombre = nombre.replace(/['"]+/g, '');

                a.href = url;
                a.download = nombre;
                document.body.append(a);
                a.click();
                a.remove();
                window.URL.revokeObjectURL(url);
                KTApp.unblockPage();
            });
        }
    });
});

function ajaxPdfListaCandidatos(premio_id) {
    return $.ajax({
        url: urlDescargarListadoCandidatos+'/'+premio_id,
        type: 'POST',
        async: true,
        xhrFields: {
            responseType: 'blob'
        },
    });
}

function unidadAdministrativaFormatter(value, row) {
    let rfc = row.unidad_administrativa.nombre_unidad;
    return `${rfc}`;
}

/* // Para Finalizar la tarea y terminar el proceso
btnFinalizarProceso = $("#finalizar_tarea");

btnFinalizarProceso.click(function() {

    var obj = new Object();
    obj.data_premio = data_premio;
    obj.motivo = "finalizarTareaYProceso";

    var url = $('#frm_busqueda_empleado').attr('action');

    swal.fire({
        "html": "Esta por finalizar la tarea <br><b> ASIGNACIÓN DE PREMIOS. </b><br>Y a su vez estará <b> finalizando el proceso.</b><br><br> ¿Está seguro de continuar?",
        "icon": "question",
        "confirmButtonColor": '#0abb87',
        "confirmButtonText": 'Aceptar',
        "showCancelButton": true,
        "cancelButtonColor": '#fd397a',
        "cancelButtonText": 'Cancelar',
        "allowOutsideClick": false,
    }).then((result) => {

        if (result.value) {

            $.ajax({

                type: "POST",
                url: url,
                data: obj,
                asyn:false,
                success: function(data){

                    if ( data.estatus ) {
                        swal.fire({
                            "text": data.mensaje,
                            "icon": "success",
                            "confirmButtonColor": '#0abb87',
                            "confirmButtonText": 'Aceptar',
                            "allowOutsideClick": false,
                        }).then((result) => {
                            window.location.href = data.ruta;
                        });

                    }else{
                        swal.fire({
                            "text": data.mensaje,
                            "icon": "warning",
                            "confirmButtonColor": '#0abb87',
                            "confirmButtonText": 'Aceptar',
                            "allowOutsideClick": false,
                        });
                    };
                }
            });
        }
    });
}); */

function validacionForm() {

    const validacion = formBusquedaEmpleado.validate({
        onfocusout: false,
        rules: {
            user_id : {
                required: true
            }
        },
        messages: {
            user_id: {
                required : 'Seleccione una opción'
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

        let datos_empleado = selectEmpleadosT01.val();

        $.ajax({

            type: "POST",
            url: urlValidarEmpleado,
            data: {datos_empleado},
            success: function(response){

                if (response.estatus) {
                    Swal.fire("Datos encontrados correctamente", "", "success");

                    tablaDatosEmpleado.bootstrapTable("destroy");
                    tablaDatosEmpleado.bootstrapTable({data: [response.empleado] });

                    $("#tituloDatos").show();
                    $("#camposDatos").show();
                    $("#guardarNuevoCandidato").show();
                } else {
                    Swal.fire(response.mensaje, "", "error");
                    tablaDatosEmpleado.bootstrapTable("destroy");
                    tablaDatosEmpleado.bootstrapTable();
                }
            }
        });

    } else {
        Swal.fire({
            title: 'Debes buscar y seleccionar a un empleado para poder continuar',
            icon: 'error',
            confirmButtonColor: '#0BB7AF',
            confirmButtonText: 'Ok'
        })
    }
});

btnContinuar.click(function (e) {
    tipoFin = 'continuar_tarea';
});

btnFinalizar.click(function (e) {
    tipoFin = 'finalizar_tarea';
});

btnCancelar.click(function (e) {
    tipoFin = 'cancelar_tarea';
});

const validatorFormFinalizarTarea = formFinalizar.validate({

    submitHandler: function(form) {

        let puntaje = $(".puntaje").valid();
        let premio = $(".premios").valid();

        let mensaje = "Antes de continuar, verifique que los datos ingresados sean correctos. Después de <b> finalizar </b> la tarea, no podrá regresar";
        if (tipoFin == 'cancelar_tarea') {
            mensaje = "Antes de continuar, verifique si desea cancelar. Después de <b> cancelar </b>, no podrá regresar";
        }

        if ( puntaje && premio ) {
            Swal.fire({
                title: "¿Está seguro?",
                html: mensaje,
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Sí, continuar",
                cancelButtonText: "Cancelar",
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    inputTipoFin.val(tipoFin);
                    KTApp.blockPage({
                        overlayColor: '#000000',
                        state: 'danger',
                        message: 'Por favor, espere...'
                    });
                    form.submit();
                }
            });
        } else {
            swal.fire({
                "text": "Debes captura la información faltante",
                "icon": "warning",
                "confirmButtonColor": '#0abb87',
                "confirmButtonText": 'Aceptar',
                "allowOutsideClick": false,
            });
        }
    }
});
