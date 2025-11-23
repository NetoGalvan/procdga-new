const btnModalGuardarVehiculo = $('#btn_modal_guarda_vehiculo');
const formModalCatalogoVehiculo = $('#modalNuevoVehiculo #form_modal_catalogo_vehiculo');
const modalNuevoVehiculo = $("#modalNuevoVehiculo");
const tablaVehiculos = $('#tabla_vehiculos');

$(document).ready(function () {

    // Se valida si existen se carga en la tabla
    if ( vehiculos.length > 0 ){
        tablaVehiculos.bootstrapTable("destroy");
        tablaVehiculos.bootstrapTable({data: vehiculos});
    } else {
        tablaVehiculos.bootstrapTable();
    }



    //Remueve el Spinner general del modulo
    $(document).ajaxStart( function() {
        $('#loader').hide();
    }).ajaxStop(function(){
        $('#loader').hide();
    });


    /** Escucha el evento click del modal para Guardar un nuevo Vehículo. */
    btnModalGuardarVehiculo.click(function (evento) {
        evento.preventDefault();

        if ( formModalCatalogoVehiculo.valid() ) {

            Swal.fire({
                title: "Guardar vehículo",
                text: "¿Esta seguro(a) guardar los datos del vehículo?",
                icon: "question",
                showCancelButton: true,
                cancelButtonColor: '#F64E60',
                cancelButtonText: "Cancelar",
                confirmButtonText: "Continuar",
                confirmButtonColor: '#0BB7AF',
                reverseButtons: true,
            }).then(function(result) {
                if (result.value) {
                    let camposformularioVehiculo = formModalCatalogoVehiculo.serialize();
                    let url = formModalCatalogoVehiculo.attr('action');
                    $.ajax({
                        type: "POST",
                        url: url,
                        data:  camposformularioVehiculo,
                        success: function(response) {
                            if (response.existe) {
                                Swal.fire({
                                    title: "Error",
                                    text: response.mensaje,
                                    icon: 'error',
                                    confirmButtonColor: '#0BB7AF',
                                    confirmButtonText: 'Entendido'
                                });
                            } else if ( response.actualizado ) {
                                modalNuevoVehiculo.modal("hide");
                                Swal.fire({
                                    title: "Vehículo",
                                    text: response.mensaje,
                                    icon: 'success',
                                    confirmButtonColor: '#0BB7AF',
                                    confirmButtonText: 'Entendido'
                                });
                                formModalCatalogoVehiculo.trigger("reset");
                                $('#modalNuevoVehiculo #p08_vehiculo_id').val('');
                                iniciarInterruptor();
                                tablaVehiculos.bootstrapTable("destroy");
                                tablaVehiculos.bootstrapTable({data: response.vehiculos});

                            } else if ( response.guardado ) {

                                modalNuevoVehiculo.modal("hide");
                                Swal.fire({
                                    title: "Vehículo",
                                    text: response.mensaje,
                                    icon: 'success',
                                    confirmButtonColor: '#0BB7AF',
                                    confirmButtonText: 'Entendido'
                                });
                                formModalCatalogoVehiculo.trigger("reset");
                                $('#modalNuevoVehiculo #p08_vehiculo_id').val('');
                                iniciarInterruptor();
                                tablaVehiculos.bootstrapTable("destroy");
                                tablaVehiculos.bootstrapTable({data: response.vehiculos});

                            } else {
                                modalNuevoVehiculo.modal("hide");
                                Swal.fire({
                                    title: "Vehículo",
                                    text: 'Surgió un problema intente mas tarde',
                                    icon: 'success',
                                    confirmButtonColor: '#0BB7AF',
                                    confirmButtonText: 'Entendido'
                                });

                            };
                        },
                        error: function (request, status, error) {
                            jsonValue = jQuery.parseJSON( request.responseText );
                            Swal.fire({
                                title: "Error",
                                text: jsonValue.message,
                                icon: 'error',
                                confirmButtonColor: '#0BB7AF',
                                confirmButtonText: 'Entendido'
                            });
                        }
                    });
                }
            });
        } else {
            validator.focusInvalid();
        }
    });


    //Función donde se define los parametros iniciales del INTERRUPTOR
    iniciarInterruptor();


    //Interruptor para la asignación del vehículo.
    $("#interruptorAsignacion").change(function(){
        if($(this).prop("checked") == true){
            $( '.camposAsignacion' ).show();
            $( '#interruptorLabel').html('<span class="requeridos">* </span>Asignar vehículo');
            $( '#area_id' ).prop('required', true);
            $( '#numero_tarjeta_combustible' ).prop('required', true);
            $( '#nombre_conductor' ).prop('required', true);
        }else{
            $("#area_id").removeClass("error");
            $("#numero_tarjeta_combustible").removeClass("error");
            $("#nombre_conductor").removeClass("error");
            $(".interruptor label.error").hide();
            iniciarInterruptor();
            $( '#area_id' ).val('');
            $( '#numero_tarjeta_combustible' ).val('');
            $( '#nombre_conductor' ).val('');
        }
    });

});

// Formatters
function datosVehiculoPlacaFormatter(value, row){
    let { placa } = row;

    return `${placa}`;
}

function datosVehiculoMarcaFormatter(value, row){
    let { marca, submarca } = row;

    return `Marca: ${marca} </br>
            Submarca: ${submarca}`;
}

function datosVehiculoModeloFormatter(value, row){
    let { modelo, color } = row;
    return `Modelo: ${modelo} </br>
            Color: ${color}`;
}

function datosVehiculoMotorFormatter(value, row){
    let { cilindros, numero_serie, numero_motor, numero_economico } = row;
    return `Cilindros: ${cilindros} </br>
            No. serie: ${numero_serie} </br>
            No. motor: ${numero_motor} </br>
            No. económico: ${numero_economico ? numero_economico : 'N/A'} `;
}

function accionesFormatter(value, row) {

    let botones =
    `<button
        type="button"
        class="btn btn-outline-primary btn-icon mr-2 "
        onclick="editarFila( ${row.p08_vehiculo_id} )"
        data-toggle="tooltip"
        data-placement="top"
        title="Editar" >
        <i class="fas fa-edit"></i>
    </button>

    <button
        type="button"
        class="btn btn-outline-danger btn-icon mr-2 "
        onclick="eliminarFila( ${row.p08_vehiculo_id} )"
        data-toggle="tooltip"
        data-placement="top"
        title="Eliminar" >
        <i class="fas fa-trash-alt"></i>
    </button>`;

    // Es la ruta para Bitacora
    {/* <a role="button"
    href="${urlBitacora}/${row.p08_vehiculo_id}"
    class="btn btn-outline-warning btn-icon mr-2"
    data-toggle="tooltip"
    data-placement="top"
    title="Bitácora">
    <i class="fas fa-edit"></i>
    </a> */}

    return botones;
}

//Función de JQuery validate para Formulario del modal de Vehículos
const validator = formModalCatalogoVehiculo.validate({

    rules: {
        tipo_vehiculo : {
            required : true,
            campoNoVacio: true
        },
        placa : {
            required : true,
            campoNoVacio: true
        },
        marca : {
            required : true,
            campoNoVacio: true
        },
        submarca : {
            required : true,
            campoNoVacio: true
        },
        modelo : {
            required : true,
            campoNoVacio: true,
            number: true
        },
        numero_motor : {
            required : true,
            campoNoVacio: true
        },
        numero_serie : {
            required : true,
            campoNoVacio: true
        },
        color : {
            required : true,
            campoNoVacio: true
        },
        cilindros : {
            required : true,
            campoNoVacio: true,
            number: true
        },
        area_id: {
            required: true
        },
        numero_tarjeta_combustible : {
            required : true,
            campoNoVacio: true
        },
        nombre_conductor : {
            required : true,
            campoNoVacio: true
        },
        copia_factura : {
            required : true,
            campoNoVacio: true
        },
        copia_tarjeta_circulacion : {
            required : true,
            campoNoVacio: true
        }
    },
    messages: {
        tipo_vehiculo : {
            required : 'Seleccione una opción',
            campoNoVacio: 'No se puede enviar espacios en blanco'
        },
        placa: {
            required : 'Este campo debe ser llenado',
            campoNoVacio: 'No se puede enviar espacios en blanco'
        },
        marca: {
            required : 'Este campo debe ser llenado',
            campoNoVacio: 'No se puede enviar espacios en blanco'
        },
        submarca: {
            required : 'Este campo debe ser llenado',
            campoNoVacio: 'No se puede enviar espacios en blanco'
        },
        modelo: {
            required : 'Este campo debe ser llenado',
            number : 'Este campo solo acepta numeros',
            campoNoVacio: 'No se puede enviar espacios en blanco'
        },
        numero_motor: {
            required : 'Este campo debe ser llenado',
            campoNoVacio: 'No se puede enviar espacios en blanco'
        },
        numero_serie: {
            required : 'Este campo debe ser llenado',
            campoNoVacio: 'No se puede enviar espacios en blanco'
        },
        color: {
            required : 'Este campo debe ser llenado',
            campoNoVacio: 'No se puede enviar espacios en blanco'
        },
        cilindros: {
            required : 'Este campo debe ser llenado',
            number : 'Este campo solo acepta numeros',
            campoNoVacio: 'No se puede enviar espacios en blanco'
        },
        area_id : {
            required : 'Debes seleccionar una opción'
        },
        nombre_conductor: {
            required : 'Este campo debe ser llenado',
            campoNoVacio: 'No se puede enviar espacios en blanco'
        },
        numero_tarjeta_combustible: {
            required : 'Este campo debe ser llenado',
            campoNoVacio: 'No se puede enviar espacios en blanco'
        },
        copia_factura: {
            required : 'Este campo debe ser llenado',
            campoNoVacio: 'No se puede enviar espacios en blanco'
        },
        copia_tarjeta_circulacion: {
            required : 'Este campo debe ser llenado',
            campoNoVacio: 'No se puede enviar espacios en blanco'
        }
    },
});


//Esta función inicializa el modal y lo devuelve a su forma inicial.
function iniciarInterruptor(){
    $( '.camposAsignacion' ).hide();
    $('#interruptorLabel').html('<span class="requeridos">* </span>Vehículo deshabilitado');
    $( '#area_id' ).removeAttr('required');
    $( '#numero_tarjeta_combustible' ).removeAttr('required');
    $( '#nombre_conductor' ).removeAttr('required');
}


/**Función que usa un evento onClick para eliminar el elemento de la tabla*/
function eliminarFila(id){

    Swal.fire({
        title: "Eliminar vehículo",
        text: "¿Esta seguro(a) de eliminar este vehículo?",
        icon: "question",
        showCancelButton: true,
        cancelButtonColor: '#F64E60',
        cancelButtonText: "Cancelar",
        confirmButtonText: "Continuar",
        confirmButtonColor: '#0BB7AF',
        reverseButtons: true,
    }).then(function(result) {
        if (result.value) {
            $.ajax({
                type: "POST",
                url: urlEliminar,
                data: {id : id},
                success: function (response) {
                    if ( response.eliminado) {
                        $('#modal').modal('hide');
                        Swal.fire({
                            title: "Eliminado",
                            text:  response.mensaje,
                            icon: 'success',
                            confirmButtonColor: '#0BB7AF',
                            confirmButtonText: 'Entendido'
                        });
                        tablaVehiculos.bootstrapTable("destroy");
                        tablaVehiculos.bootstrapTable({data: response.vehiculos});
                    }
                }
            });
        }
    });

}


/**Función que usa un evento onClick para editar el elemento de la tabla*/
function editarFila(id){
    $.ajax({
        type: "POST",
        url: urlEditar,
        data: {id : id},
        success: function (response) {
            $("#modalNuevoVehiculo #p08_vehiculo_id").val(response.vehiculo.p08_vehiculo_id);
            $("#modalNuevoVehiculo #placa").val(response.vehiculo.placa);
            $("#modalNuevoVehiculo #marca").val(response.vehiculo.marca);
            $("#modalNuevoVehiculo #submarca").val(response.vehiculo.submarca);
            $("#modalNuevoVehiculo #modelo").val(response.vehiculo.modelo);
            $("#modalNuevoVehiculo #tipo_vehiculo").val(response.vehiculo.tipo_vehiculo);
            $("#modalNuevoVehiculo #numero_motor").val(response.vehiculo.numero_motor);
            $("#modalNuevoVehiculo #numero_economico").val(response.vehiculo.numero_economico);
            $("#modalNuevoVehiculo #numero_serie").val(response.vehiculo.numero_serie);
            $("#modalNuevoVehiculo #color").val(response.vehiculo.color);
            $("#modalNuevoVehiculo #cilindros").val(response.vehiculo.cilindros);
            $("#modalNuevoVehiculo #copia_factura").val(response.vehiculo.copia_factura);
            $("#modalNuevoVehiculo #copia_tarjeta_circulacion").val(response.vehiculo.copia_tarjeta_circulacion);
            if ( response.vehiculo.area_id ) {
                $( '.camposAsignacion' ).show();
                $( '#interruptorAsignacion' ).prop('checked', true) ;
                $( '#interruptorLabel').html('<span class="requeridos">* </span>Vehículo asignado a:');
                $("#modalNuevoVehiculo #area_id").val(response.vehiculo.area_id);
                $("#modalNuevoVehiculo #numero_tarjeta_combustible").val(response.vehiculo.numero_tarjeta_combustible);
                $("#modalNuevoVehiculo #nombre_conductor").val(response.vehiculo.nombre_conductor);

            }
            modalNuevoVehiculo.modal("show");
        }
    });
}


//Función de boostrap que activa el Tooltip (Mensaje en los iconos)
$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})


//Evento, cuando se oculta el Modal se limpian los datos del formulario y se resetea la validación
modalNuevoVehiculo.on('hide.bs.modal', function () {
    $('#modalNuevoVehiculo #p08_vehiculo_id').val('');
    formModalCatalogoVehiculo.trigger("reset");
    validator.resetForm();
    iniciarInterruptor();

})

