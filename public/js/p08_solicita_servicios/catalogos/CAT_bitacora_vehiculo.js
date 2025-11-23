const formModalBitacoraVehiculo = $('#form_modal_bitacora_vehiculo');
const btnModalGuardarBitacoraVehiculo = $('#btn_modal_guarda_bitacora_vehiculo');
const modalNuevaBitacora = $("#modalNuevaBitacora");

$(document).ready(function () {


    /** Escucha el evento click del modal para Guardar una nueva Bitácora del Vehículo. */
    btnModalGuardarBitacoraVehiculo.click(function (evento) {
        evento.preventDefault();

        if ( formModalBitacoraVehiculo.valid() ) {

            if ( validator.element( "#kilometros_total" ) ) {

                $('#nombre_elabora').removeAttr('disabled');
                $('#kilometros_total').removeAttr('disabled');
                Swal.fire({
                    title: "Guardar bitácora",
                    text: "¿Esta seguro(a) guardar los datos de la bitácora de rutas?",
                    icon: "question",
                    showCancelButton: true,
                    cancelButtonColor: '#F64E60',
                    cancelButtonText: "Cancelar",
                    confirmButtonText: "Continuar",
                    confirmButtonColor: '#0BB7AF',
                    reverseButtons: true,
                }).then(function(result) {
                    if (result.value) {
                        formModalBitacoraVehiculo.submit();
                    }
                });
            } else {

                validator.focusInvalid();
            }

        } else {

            validator.focusInvalid();

        }
    });


    // Evento que llena el dato del usuario logueado quien llena la bitácora
    $('#btn-modal-nueva-bitacora').click(function (e) {
        e.preventDefault();
        elaboro = usuario.nombre + ' ' + usuario.apellido_paterno + ' ' + usuario.apellido_materno ;
        $('#nombre_elabora').val(elaboro.toUpperCase());
        $('#nombre_elabora').prop('disabled', true);
        $('#kilometros_final').prop('disabled', true);
        $('#kilometros_total').prop('disabled', true);

        if ( ultimoKilomatraje ){
            $('#kilometros_inicial').val(ultimoKilomatraje.kilometros_final);
            $('#kilometros_final').removeAttr('disabled');
            $('#kilometros_total').val($('#kilometros_inicial').val());
            totalKilometros();
        }

    });


    // Inicia el RichText TinyMCE en el modal
    tinymce.init({
        selector: '#observaciones_ruta',
        plugins : 'advlist autolink link image lists charmap print preview',
        toolbar: [
            ' fontselect |  fontsizeselect | bold italic underline | alignleft aligncenter alignright '
          ],
          language : 'es_MX',
          menubar: false,
          branding: false,
          statusbar: false,

        setup: function(editor) {
			editor.on('change', function(e) {
                tinyMCE.triggerSave();
                if ($("#" + editor.id ).siblings('.tox.tox-tinymce').next().length > 0) {
                    if ($("#" + editor.id).valid()) {
                        $("#" + editor.id ).siblings('.tox.tox-tinymce').removeClass('error')
                    } else {
                        $("#" + editor.id ).siblings('.tox.tox-tinymce').addClass('error')
                    }
                }
			});
		}

    });


    // Evento para capturar los kilometros iniciales
    // Este llama al segundo evento
    $('#kilometros_inicial').keyup(function (e) {
        Kinicial = $('#kilometros_inicial').val();

        if ( Kinicial.length > 0  && validator.element( "#kilometros_inicial" ) ) {

            $('#kilometros_final').removeAttr('disabled');
            $('#kilometros_total').val($('#kilometros_inicial').val());
            totalKilometros();
        } else {
            $('#kilometros_final').prop('disabled', true);
            $('#kilometros_final').removeClass('error').next('label.error').remove();
            $('#kilometros_total').val( '' );
        }

    });


    // Se colocó un dato especial para esta fecha
    $('.date-general-bitacora').datepicker({
        format : 'dd/mm/yyyy',
        autoclose : true,
        language : 'es',
        daysOfWeekDisabled: [0,6],
        datesDisabled: ['01/01/2019','04/02/2019','18/03/2019','01/05/2019','16/09/2019', '01/11/2019', '18/11/2019', '25/12/2019', '01/01/2020']
    });


    $('.date-general-bitacora').datepicker()
        .on('changeDate', function(e) {
            $(this).removeClass("error");
            $(this).addClass("valid");
            $(this).next().text("");
    });

});


// Función que ayuda a la validación de los inputs de Kilometros
function totalKilometros () {
    $('#kilometros_final').keyup(function (e) {
        Kfinal = $('#kilometros_final').val();

        if ( Kfinal.length > 0  && validator.element( "#kilometros_final" ) ) {
            diferencia = ( $('#kilometros_final').val() - $('#kilometros_inicial').val() );
            $('#kilometros_total').val(diferencia);
            validator.element( "#kilometros_total" )
        } else {
            validator.element( "#kilometros_total" )
            $('#kilometros_total').val( $('#kilometros_inicial').val() );
        }
    });
}


// Función de JQuery validate para Formulario del modal de Bitácora de Vehículos
const validator = formModalBitacoraVehiculo.validate({
    ignore: "",
    onfocusout: false,
    rules: {
        fecha_ruta : {
            required : true,
            campoNoVacio: true
        },
        nombre_elabora : {
            required : true,
            campoNoVacio: true,
            soloLetras: true
        },
        nombre_revisa : {
            required : true,
            campoNoVacio: true,
            soloLetras : true
        },
        observaciones_ruta: {
            tinyMCE: true
        },
        kilometros_inicial : {
            required : true,
            campoNoVacio: true,
            number: true
        },
        kilometros_final : {
            required : true,
            campoNoVacio: true,
            number: true
        },
        kilometros_total : {
            required : true,
            campoNoVacio: true,
            number: true,
            min: 1
        },
        litros_combustible : {
            number: true
        },
        importe_combustible : {
            number: true
        },
        litros_lubricante : {
            number: true
        },
        importe_lubricante : {
            number: true
        }
    },

    messages: {
        fecha_ruta : {
            required : 'Seleccione una opción',
            campoNoVacio: 'No se puede enviar espacios en blanco'
        },
        nombre_elabora: {
            required : 'Este campo debe ser llenado',
            campoNoVacio : 'No se puede enviar espacios en blanco',
            soloLetras : 'Este campo solo acepta texto'
        },
        nombre_revisa : {
            required : 'Este campo debe ser llenado',
            campoNoVacio: 'No se puede enviar espacios en blanco',
            soloLetras : 'Este campo solo acepta texto'
        },
        observaciones_ruta : {
            tinyMCE: 'Este campo debe ser llenado'
        },
        kilometros_inicial : {
            required : 'Este campo debe ser llenado',
            campoNoVacio : 'No se puede enviar espacios en blanco',
            number : 'Este campo solo acepta numeros'
        },
        kilometros_final : {
            required : 'Este campo debe ser llenado',
            campoNoVacio : 'No se puede enviar espacios en blanco',
            number : 'Este campo solo acepta numeros'
        },
        kilometros_total : {
            required : 'Este campo debe ser llenado',
            campoNoVacio : 'No se puede enviar espacios en blanco',
            number : 'Este campo solo acepta numeros',
            min: "El valor no puede ser negativo"
        },
        litros_combustible : {
            number : 'Este campo solo acepta numeros enteros o decimales ',
        },
        importe_combustible : {
            number : 'Este campo solo acepta numeros enteros o decimales ',
        },
        litros_lubricante : {
            number : 'Este campo solo acepta numeros enteros o decimales ',
        },
        importe_lubricante : {
            number : 'Este campo solo acepta numeros enteros o decimales ',
        }
    },

    errorPlacement: function(label, element) {
        if ( element.attr('id') == 'observaciones_ruta' ) {
            let textAreaTinyMCE = element.next();
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


// Evento, cuando se oculta el Modal se limpian los datos
modalNuevaBitacora.on('hidden.bs.modal', function () {
    validator.resetForm();
    formModalBitacoraVehiculo.trigger("reset");
    $( '#observaciones_ruta' ).val('');
    $( '#observaciones_ruta' ).removeAttr('required');
    $( '#observaciones_ruta' ).siblings('.tox.tox-tinymce').removeClass('error')
})

