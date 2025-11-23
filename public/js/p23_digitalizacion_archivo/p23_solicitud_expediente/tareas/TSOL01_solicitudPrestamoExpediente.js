btnBuscarExpediente = $("#buscar");
btnCancelarProceso = $("#btn_cancelar_proceso");
var formCancelarProceso = $("#frm_solicitud_cancelar_proceso");
const formFinalizarTarea = $("#frm_solicitud_seleccion_prestamo");
const tableExpediente = $('#datos_expediente');

$(document).ready(function(){
    tableExpediente.bootstrapTable();

    if (mensajeError) {
        Swal.fire({
            html: mensajeError,
            icon: 'warning',
            confirmButtonColor: '#0BB7AF',
            confirmButtonText: 'Ok'
        });
    }
});

const validatorFormFinalizarTarea = formFinalizarTarea.validate({
    submitHandler: function(form) {
        Swal.fire({
            title: "¿Está seguro?",
            text: "Antes de continuar, verifique que los datos ingresados sean correctos. Después de finalizar la tarea, no podrá regresar.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Aceptar",
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
    }
});

btnCancelarProceso.click(function(e) {
    e.preventDefault();
    Swal.fire({
        title: "¿Está seguro de cancelar el proceso?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Aceptar",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.value) {
            KTApp.blockPage({
                overlayColor: '#000000',
                state: 'danger',
                message: 'Por favor, espere...'
            });
            formCancelarProceso.submit();
        }
    });
});

btnBuscarExpediente.click(function(e) {
    e.preventDefault();
    if ( $("#tipo_prestamo").valid() && $("#rfc").valid() ) {

        var obj = new Object();
        obj.tipo_prestamo = $("#tipo_prestamo").val();
        obj.rfc = $("#rfc").val();

        swal.fire({
            "title": "Verifique la información",
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
                $.ajax({

                    type: "POST",
                    url: buscarExpedienteTrabajador,
                    data: obj,
                    asyn:false,
                    success: function(data){
                        tableExpediente.bootstrapTable("destroy");
                        tableExpediente.bootstrapTable();
                        if ( data.estatus ) {
                            tableExpediente.bootstrapTable("destroy");
                            $("#datos_del_expediente").show();
                            tableExpediente.bootstrapTable({data: data.datos });
                            Swal.fire(data.mensaje, '', 'success');
                        }else{
                            $("#datos_del_expediente").hide();
                            Swal.fire(data.mensaje, '', 'warning');
                        };
                    }
                });
            }
        });
    } else {
        Swal.fire("Campos obligatorios para la búsqueda:", "Tipo de prestamo y RFC", "warning");
    }
});

function expedienteFormatter(value, row) {
    let numero_expediente = row.numero_expediente ? row.numero_expediente : row.numero_expediente;
    return `${numero_expediente}`;
}

function nombreCompletoFormatter(value, row) {
    let nombre = row.nombre_empleado ? row.nombre_empleado : row.nombre_empleado;
    let apellidoP = row.apellido_paterno ? row.apellido_paterno : row.apellido_paterno;
    let apellidoM = row.apellido_materno ? row.apellido_materno : row.apellido_materno;
    return `${nombre} ${apellidoP} ${apellidoM}`;
}

function rfcFormatter(value, row) {
    let rfc = row.rfc ? row.rfc : row.rfc;
    return `${rfc}`;
}

function empleadoFormatter(value, row) {
    let numero_empleado = row.numero_empleado ? row.numero_empleado : row.numero_empleado;
    return `${numero_empleado}`;
}

function accionesFormatter(value, row) {
    let acciones =  `<input type="radio" value="${row.p23_indice_id}" name="indice_id_seleccion" id="seleccion_${row.p23_indice_id}">`;
    return acciones;
}

function mostrar(id) {
    
    if (id == "autoridad_judicial") {
        $("#div_nombre").show();
        $("#div_cargo").show();
        $("#div_dependencia").show();
        $("#div_referencia").show();
        $("#div_unidad").hide();
        $("#div_parentesco").hide();
        $("#div_razon").hide();        
    }

    if (id == "funcionario_cdmx") {
        $("#div_nombre").show();
        $("#div_cargo").show();
        $("#div_referencia").show();
        $("#div_unidad").show();
        $("#div_dependencia").hide();
        $("#div_parentesco").hide();
        $("#div_razon").hide();
    }

    if (id == "funcionario_otra_dependencia") {
        $("#div_nombre").show();
        $("#div_cargo").show();
        $("#div_dependencia").show();
        $("#div_referencia").show();
        $("#div_unidad").hide();
        $("#div_parentesco").hide();
        $("#div_razon").hide();
    }

    if (id == "familiar") {
        $("#div_nombre").show();
        $("#div_parentesco").show();
        $("#div_razon").show();
        $("#div_cargo").hide();
        $("#div_dependencia").hide();
        $("#div_referencia").hide();
        $("#div_unidad").hide();
    }

    if (id == "empleado") {
        $("#div_nombre").show();
        $("#div_cargo").show();
        $("#div_dependencia").hide();
        $("#div_referencia").hide();
        $("#div_unidad").hide();
        $("#div_parentesco").hide();
        $("#div_razon").hide();
    }

    if (id == "otro") {
        $("#div_nombre").show();
        $("#div_cargo").show();
        $("#div_referencia").show();
        $("#div_dependencia").hide();
        $("#div_unidad").hide();
        $("#div_parentesco").hide();
        $("#div_razon").hide();
    }

    if (id == "") {
        $("#div_nombre").hide();
        $("#div_cargo").hide();
        $("#div_referencia").hide();
        $("#div_dependencia").hide();
        $("#div_unidad").hide();
        $("#div_parentesco").hide();
        $("#div_razon").hide();
    }
}