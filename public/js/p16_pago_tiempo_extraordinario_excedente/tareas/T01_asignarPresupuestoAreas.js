//Regex de validacion del presupuesto asignado
jQuery.validator.addMethod("regexNumero", function(value, element) {
    //1000000 numeros solamente
    return this.optional( element ) || /^([0-9]{0,10})$/.test( value );
}, 'Ingrese un número (máx. 1000000000).');
//agregamos validador a la clase presupuesto (para los inputs de los presupuestos para las areas)
jQuery.validator.addClassRules("presupuesto", {
    required: true,
    regexNumero: true

});
//inicializa el select2 de las unidades administrativas
$('#unidadesAdministrativas').select2({
    placeholder: "Seleccione...",
});

$(document).ready(function(){
    if (mensajeError) {
        Swal.fire({
            html: mensajeError,
            icon: 'warning',
            confirmButtonColor: '#0BB7AF',
            confirmButtonText: 'Ok'
        });
    }
});

const tablePresupuestos = $('#tablaPresupuestos');

$('#fecha_limite').datepicker({
    rtl: KTUtil.isRTL(),
    todayHighlight: true,
    format: "dd/mm/yyyy",
    autoclose: true,
    language: "es",
    showOnFocus: true,
    orientation: "bottom left",
    daysOfWeekDisabled: [0,6],
    startDate: '0', // Bloquear fechas anteriores a la actual
});

//almacena el primer dato del proceso, la quincena  designada para este proceso
function buscarPresupuesto(){
    var validator = $('#buscarPresupuestoForm').validate({
        validClass: "is-valid",
        errorClass: "is-invalid",
        rules: {
            quincena: {
                required: true,
            }
        },
        messages:{
            quincena: {
                required: 'Seleccione una Quincena.',
            }
        }
    });
    if (validator.form()) {
        var datos = new FormData(document.getElementById("buscarPresupuestoForm"));
        Swal.fire({
            "html": "<b>Una vez elegida, no se podra cambiar la información</b><br>¿Desea continuar?",
            "icon": "warning",
            "customClass": {
                "confirmButton": 'btn btn-primary',
                "cancelButton": 'btn btn-danger'
            },
            "confirmButtonText": 'Aceptar',
            "showCancelButton": true,
            "cancelButtonText": 'Cancelar',
            "allowOutsideClick": false,
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'post',
                    url: guardarTipoPeriodoRoute,
                    data: datos,
                    dataType: 'json',
                    processData: false,
                    contentType: false
                }).done(function (response) {
                    if (response.estatus) {
                        Swal.fire({
                            "html": response.mensaje+"<br>Ahora debe asignar los presupuestos a cada Área",
                            "icon": "success",
                            "customClass": {
                                "confirmButton": 'btn btn-primary',
                            },
                            "confirmButtonText": 'Aceptar',
                            "allowOutsideClick": false,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $("#quincena").attr('disabled', 'disabled');
                                $("#cardUnidades").show("slow");
                                $("#btnBuscarTipoPeriodo").hide("slow");
                            }
                        });
                    } else {
                        Swal.fire('¡Upss!',response.mensaje,'warning');
                    }
                }).fail(function(data) {
                    Swal.fire('¡Upss!',data.responseText+' Code-TEEC-002','warning');
                });
            }
        });
    } else {
        validator.focusInvalid();
    }
    event.preventDefault();
}

const formDatosTarea = $("#datosProcesoForm");
const btnFinalizarTarea = $("#finalizarTarea");

btnFinalizarTarea.click(function (e) {
    e.preventDefault();
    const isValid =  formDatosTarea.valid();
    if ( isValid ) {
        if ( $("#tablaPresupuestos").bootstrapTable('getData').length >= 1 ) {
            Swal.fire({
                "html": "Esta por terminar la tarea:<br><b>Asignar Presupuesto a las Áreas</b><br>¿Desea continuar?",
                "icon": "info",
                "customClass": {
                    "confirmButton": 'btn btn-primary',
                    "cancelButton": 'btn btn-danger',
                },
                "confirmButtonText": 'Aceptar',
                "showCancelButton": true,
                "cancelButtonText": 'Cancelar',
                "allowOutsideClick": false,
            }).then(function(result) {
                if (result.value) {
                    KTApp.blockPage({
                        overlayColor: '#000000',
                        state: 'danger',
                        message: 'Por favor, espere...'
                    });
                    formDatosTarea.submit();
                }
            });
        }
    }
});

formDatosTarea.validate({
    ignore: "",
    onfocusout: false,
    rules: {
        quincena: {
            required: true
        },
        fecha_limite: {
            required: true
        }
    },
    messages: {
        quincena : {
            required : 'Debe seleccionar una quincena'
        },
        fecha_limite : {
            required : 'Debe seleccionar la fecha limite'
        }
    },
    errorPlacement: function(label, element) {
        if ( element.attr('id') == 'texto_solicitud' ) {
            const textAreaTinyMCE = element.next();
            if (label.text() != "") {
                textAreaTinyMCE
                        .addClass('error');
            }

            textAreaTinyMCE.after(label);
        }
        else {
            element.addClass('error');
            label.insertAfter(element);
        }

    }
});

var ids = 0;
$('#btnAgregarUnidad').click(function(){
    var validator = $('#unidadesAdmnistrativasForm').validate({
        validClass: "is-valid",
        errorClass: "is-invalid",
        rules: {
            unidadesAdministrativas: {
                required: true,
            },
            presupuesto: {
                required: true,
            }
        },
        messages:{
            unidadesAdministrativas: {
                required: 'Seleccione una área',
            },
            presupuesto: {
                required: 'Ingrese el presupuesto',
            }
        },
        errorPlacement: function(label, element) {
            label.addClass('invalid-feedback');
            element.parent().append(label);
            element.next().find(".select2-selection.select2-selection--single").css("border-color", "#E60035");
        },
        unhighlight: function(element, errorClass, validClass) {
            if (!$(element).prop("required") && $(element).val() == ' ') {
                $(element).removeClass(errorClass).removeClass(validClass);
            } else {
                $(element).next().find(".select2-selection.select2-selection--single").css({"border": "1px solid", "border-color": "#1BC5BD"});
            }
        },
    });

    if (validator.form( "#unidadesAdmnistrativasForm" )) {
        swal.fire({
            "title": "Esta a punto de guardar el área y su presupuesto.",
            "text": "¿Está seguro de continuar?",
            "icon": "question",
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
                const rows = [];
    
                $.ajax({
                    url : asignarPresupuestoRoute,
                    type : 'POST',
                    data: $('#unidadesAdmnistrativasForm').serialize(),
                    async : false,
                    success: function(data){
                        if ( data.estatus ) {
                            KTApp.unblockPage({
                                overlayColor: '#000000',
                                state: 'danger',
                                message: 'Por favor, espere...'
                            });
                            rows.push({
                                id : data.ultimoRegistro.p16_presupuesto_quincenal_area_id,
                                unidadAdministrativa: data.ultimoRegistro.identificador + " - "  + data.ultimoRegistro.nombre,
                                presupuesto : data.ultimoRegistro.presupuesto,
                                acciones: ""
                            });
                            tablePresupuestos.bootstrapTable('append', rows);
                            $('#unidadesAdministrativas').val(null).trigger('change');
                            $("#presupuesto").val(" ");
                            Swal.fire(data.mensaje, "", "success");
                        }else{
                            KTApp.unblockPage({
                                overlayColor: '#000000',
                                state: 'danger',
                                message: 'Por favor, espere...'
                            });
                            Swal.fire(data.mensaje, "", "warning");
                        };
                    }
                });
            }
        });
    } else {
        validator.focusInvalid();
    }
});

function eliminar(value,row){
    return '<button type="button" class="btn btn-outline-danger btn-icon" onclick="eliminarFila(\''+row.id+'\')"><i class="fas fa-trash-alt"></i></button>';
}

function eliminarFila(id){

    swal.fire({
        "html": "Esta a punto de eliminar el área. <br><br> ¿Está seguro de continuar?",
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
                url : urlEliminar,
                type : 'POST',
                data : {id},
                async : false,
                success: function(data){

                    if ( data.estatus ) {
                        tablePresupuestos.bootstrapTable('remove', {
                            field: 'id',
                            values: id
                        });
                        Swal.fire(data.mensaje, "", "success");
                    }else{
                        Swal.fire(data.mensaje, "", "warning");
                    };
                }
            });
        }
    });
}