// Variables
var btnAgregarAreaAdscripcion = $('.area-adscripcion');
var modalAreaAdscripcion = $('#modalAreaAdscripcion');
var formAreaAdscripcion = $('#formAreaAdscripcion');

var tablaAreaAdscripcion = $('#tablaAreasAdscripcion');
var btnEditarAreaAdscripcion = '#editarAreaAdscripcion';
var btnEliminarAreaAdscripcion = '#eliminarAreaAdscripcion';

var btnFinalizarProcesoAreaAdscripcion = $('.guardar-modificar-area-adscripcion');

//BEGIN::Bootstrap Table -> Cargar area de inscripcion
function showAreasAdscripcion(params){
    $.post(URL_showAreasAdscripcion).done(function(response){
        params.success(response);
    });
}
// ------> Funciones Formatter
function accionesFormatter(v, row) {
    return `<button class="btn btn-icon btn-sm btn-outline-primary m-2" id="editarAreaAdscripcion" title="<b>EDITAR ÁREA</b>"
                data-toggle="modal" data-target="#modalAreaAdscripcion"
                data-area-adscripcion="${row.nombre_area_adscripcion}"
                data-area-direccion="${row.direccion_area_adscripcion}"
            >
                <i class="far fa-edit"></i>
            </button>
            <button class="btn btn-icon btn-sm btn-outline-danger m-2" id="eliminarAreaAdscripcion" title="<b>ELIMINAR ÁREA</b>"
                data-area-adscripcion="${row.nombre_area_adscripcion}"
                data-area-direccion="${row.direccion_area_adscripcion}"
            >
                <i class="far fa-trash-alt"></i>
            </button>`;
}
//END::Bootstrap Table -> Cargar area de inscripcion

//BEGIN::Botones
// ------> Abrir modal para agregar prestador
btnAgregarAreaAdscripcion.click(function () {
    btnFinalizarProcesoAreaAdscripcion.data('areaAds', null);
    btnFinalizarProcesoAreaAdscripcion.data('direccionAreaAds', null);
    modalAreaAdscripcion.find('.modal-title').html(`Agregar área de adscripción ${spanTitulo}`);
});
// ------> Abrir modal para editar area de adscripcion
tablaAreaAdscripcion.on('click', btnEditarAreaAdscripcion, function(e) {
    e.preventDefault();

    var nombre_area_ads = $(this).data('areaAdscripcion');
    var direccion_area_ads = $(this).data('areaDireccion');
    modalAreaAdscripcion.find('.modal-title').html(`Editar área de adscripción ${spanTitulo}`);

    bloquearModal();
    $.post(`${URL_datosAreaAdscripcion}/${nombre_area_ads}/${direccion_area_ads}`)
     .done( function (response) {
        $('.nombre_area').val(response.nombre_area_adscripcion);
        $('.direccion_area').val(response.direccion_area_adscripcion);

        btnFinalizarProcesoAreaAdscripcion.data('areaAds', response.nombre_area_adscripcion);
        btnFinalizarProcesoAreaAdscripcion.data('direccionAreaAds', response.direccion_area_adscripcion);
        desbloquearModal(1000);
     });
});
// ------> Guardar - Editar "Area de adscripción"
btnFinalizarProcesoAreaAdscripcion.click( function(e) {
    e.preventDefault();

    var dataNombreArea = '/' + $(this).data('areaAds');
    var dataDireccionArea = '/' + $(this).data('direccionAreaAds');
    
    if ( formAreaAdscripcion.valid() ) {
        alert_warning_secondary('Verifique que la información sea correcta', 
        function(result) {
            if ( result.value ) 
            {
                $.post(URL_guardar_modificar_areaAdscripcion+dataNombreArea+dataDireccionArea, formAreaAdscripcion.serialize())
                 .done( function(response) {
                    if ( response.estatus ) 
                    {
                        tablaAreaAdscripcion.bootstrapTable('refreshOptions', { pageNumber : 1, pageSize: 5 });
                        modalAreaAdscripcion.modal('hide');
                        alert_success(response.mensaje, null);
                    } else {
                        alert_error(response.mensaje, null);
                    }
                 });
            }
        }); 
    }
});
/// ------> 
tablaAreaAdscripcion.on('click', btnEliminarAreaAdscripcion, function(e) {
    e.preventDefault();

    var dataNombreArea = $(this).data('areaAdscripcion');
    var dataDireccionArea = '/' + $(this).data('areaDireccion');

    alert_warning_secondary(`Eliminara el área de <br><b>${dataNombreArea}</b>`, 
    function(result) {
        if ( result.value ) 
        {
            $.post(URL_eliminar_areaAdscripcion +'/'+ dataNombreArea+dataDireccionArea)
             .done( function(response) {
                if ( response.estatus ) 
                {
                    tablaAreaAdscripcion.bootstrapTable('refreshOptions', { pageNumber : 1, pageSize: 5 });
                    alert_success(response.mensaje, null);
                } else {
                    alert_error(response.mensaje, null);
                }
             });
        }
    });
});
//END::Botones

// ------> Tooltip
tooltip( tablaAreaAdscripcion, btnEditarAreaAdscripcion );
tooltip( tablaAreaAdscripcion, btnEliminarAreaAdscripcion );

// Validación
formAreaAdscripcion.validate({
    onfocusout: false,
    rules: {
        nombre_area: 'campoNoVacio',
        direccion_area: 'campoNoVacio'
    },
    messages: {
        nombre_area: 'Campo obligatorio',
        direccion_area: 'Campo obligatorio'
    }
});

// ------> Restablecer modal 
modalAreaAdscripcion.on('hidden.bs.modal', function () {
    restablecer_formulario( formAreaAdscripcion );
}).modal('hide');

/*
var table = $('#table');

function eliminarFormatter(value, row) {
    return [
        '<button type="button" class="btn btn-outline-primary btn-icon" onclick="abrirModalEditarArea('+row.id+')" data-toggle="tooltip" data-placement="top" title="Editar"><i class="far fa-edit"></i></button>', ' ',
        '<button type="button" class="btn btn-outline-danger btn-icon" onclick="eliminarFila('+row.id+')" data-toggle="tooltip" data-placement="top" title="Eliminar"><i class="far fa-trash-alt"></i></button>'
    ].join('');
}

$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})

function eliminarFila(id){

    var obj = new Object();
    obj.area_adscripcion_id = id;

    swal.fire({
        "html": "Esta a punto de eliminar esta área. <br><br> ¿Está seguro de continuar?",
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
                data : obj,
                async : false,
                success: function(data){

                    if ( data.estatus ) {
                        table.bootstrapTable('removeByUniqueId', id);
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

var modal = $("#modal");

btnGuardarArea = $("#guardarArea");
btnActualizarArea = $("#actualizarArea");
formGuardarArea = $( "#modalNuevaArea" );

function abrirModalArea(){
    $("#nombreArea").val('');
    $("#direccionArea").val('');

    $("#modalArea").modal("show");
}

// Guardar Nueva Area
btnGuardarArea.click(function() {

    if ( $("#modalNuevaArea").valid() ) {

        var url = $('#modalNuevaArea').attr('action');

        swal.fire({
            "html": "Verifique que la información sea correcta <br><br> ¿Está seguro de continuar?",
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
                    data: $('#modalNuevaArea').serialize(),
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
    }
});

// Actualizar Area
btnActualizarArea.click(function() {

    if ( $("#modalNuevaArea").valid() ) {

        swal.fire({
            "html": "Verifique que la información sea correcta <br><br> ¿Está seguro de continuar?",
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
                    url: urlEditar,
                    data: $('#modalNuevaArea').serialize(),
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
    }
});

var validatorNuevaInsticucion = formGuardarArea.validate({
    onfocusout: false,
    rules: {
        nombreArea: {
            required: true,
            campoNoVacio: true
        },
        direccionArea: {
            required: true,
            campoNoVacio: true
        }
    },
        errorClass : "error",
        validClass : "valido",
    messages: {
        nombreArea: {
            required: 'Campo obligatorio',
            campoNoVacio: "No se puede enviar espacios en blanco"
        },
        direccionArea: {
            required: 'Campo obligatorio',
            campoNoVacio: "No se puede enviar espacios en blanco"
        }
    },
    errorPlacement: function(label, element) {
        element.addClass('error');
        label.insertAfter(element);
    }
});

function abrirModalEditarArea(area_adscripcion_id){

    var obj = new Object();
    obj.area_adscripcion_id = area_adscripcion_id;
    obj.si_es = "recuperarDatosParaEditarPorAjax";

    $.ajax({
        url : urlEditar,
        type : 'POST',
        data : obj,
        async : false,
        success: function(data){
            var html = '';
            html += `<input type="hidden" value="${data.area.area_adscripcion_id}" name="area_ads_id" id="area_ads_id">`;
            $('#newRow').append(html);
            $("#modalArea #nombreArea").val(data.area.nombre_area_adscripcion);
            $("#modalArea #direccionArea").val(data.area.direccion_area_adscripcion);
            $("#guardarArea").hide();
            $("#actualizarArea").show();
            $("#modalArea").modal("show");
        }
    });
}

$('#modalArea').on('hide.bs.modal', function (e) {
    validatorNuevaInsticucion.resetForm();
    $("#guardarArea").show();
    $("#actualizarArea").hide();
})
*/