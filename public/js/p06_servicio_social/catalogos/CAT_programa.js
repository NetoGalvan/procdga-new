// Variables
var btnAgregarPrograma = $('.programa');
var modalCatalogoProgramas = $('#modalCatalogoProgramas');
var modalPrograma = $('#modalPrograma');

var tablaProgramas = $('#tablaProgramas');
var btnEditarPrograma = '#editarPrograma';
var btnEliminarPrograma = '#eliminarPrograma';

var nombrePrograma = $('#nombrePrograma');
var clavePrograma = $('#clavePrograma');

var formPrograma = $('#formPrograma');
var finalizarProcesoPrograma = $('.guardar-modificar-programa');

//BEGIN::Bootstrap Table -> Programas
// ------> Funcion Formatter
function accionesProgramasFormatter(v, row) {
    return `<button class="btn btn-icon btn-sm btn-outline-primary m-2" title="<b>EDITAR PROGRAMA</b>"
                id="editarPrograma" data-programa="${row.clave_programa}"
            >
                <i class="far fa-edit"></i>
            </button>
            <button class="btn btn-icon btn-sm btn-outline-danger m-2" title="<b>ELIMINAR PROGRAMA</b>"
                id="eliminarPrograma" data-programa="${row.clave_programa}"
            >
                <i class="far fa-trash-alt"></i>
            </button>`;
}
//END::Bootstrap Table -> Programas
//Botones
btnAgregarPrograma.click( function() {
    finalizarProcesoPrograma.data('clavePrograma', null); 
    modalCatalogoProgramas.modal('hide');
    
    modalPrograma.find('.modal-title').html(`Agregar programa ${spanTitulo}`);
});
// ------> Abrir modal para editar programa
tablaProgramas.on('click', btnEditarPrograma, function(e) {
    e.preventDefault();
    
    modalCatalogoProgramas.modal('hide');
    bloquearModal();
    //alert_loading();
    
    var dataClavePrograma = $(this).data('programa');
    modalPrograma.find('.modal-title').html(`Editar programa ${spanTitulo}`);

    $.post(`${URL_datosPrograma}/${dataClavePrograma}`)
     .done( function (response) {

        nombrePrograma.val(response.nombre_programa);
        clave_prog = response.clave_programa.split("-");
        clavePrograma.val(clave_prog[1]);
        finalizarProcesoPrograma.data('clavePrograma', dataClavePrograma);

        modalPrograma.modal('show');
        desbloquearModal(1000);
        //alert_time_close(1000);
     });
});
// ------> eliminar programa
tablaProgramas.on('click', btnEliminarPrograma, function(e) {
    e.preventDefault();
    
    var dataClavePrograma = $(this).data('programa');

    alert_warning_secondary(`Eliminara el programa de <b>${dataClavePrograma}</b>`, 
    function(result) {
        if ( result.value ) {
            $.post( URL_eliminar_programa + '/' + dataClavePrograma ).done(function(response) 
             {
                if ( response.estatus ) {
                    alert_success(`El programa <b>${dataClavePrograma}</b> se eliminó correctamente.`, null);
                    tablaProgramas.bootstrapTable('load', response.programas);
                    tablaProgramas.bootstrapTable('refreshOptions', { pageNumber : 1, pageSize: 5 });
                } else {
                    alert_error(response.mensaje, null);
                }
             });
        }
    });
});
// ------> Guardar o editar programa
finalizarProcesoPrograma.click(function(e) {
    e.preventDefault();

    var dataClaveInstitucion = '/' + $(this).data('claveInstitucion');
    var dataClavePrograma = '/' + $(this).data('clavePrograma');
    
    if ( formPrograma.valid() ) {
        alert_warning_secondary('Verifique que la información sea correcta', 
        function(result) {
            if ( result.value ) {
                $.post( URL_guardar_modificar_programa + dataClaveInstitucion + dataClavePrograma, formPrograma.serialize() )
                 .done(function(response) {
                    if ( response.estatus ) 
                    {
                        alert_success(response.mensaje, null);
                        tablaProgramas.bootstrapTable('load', response.programas);
                        modalPrograma.modal('hide');
                    } else {
                        alert_error(response.mensaje, null);
                    }
                 });
            }
        });
    }
});

// Validación
formPrograma.validate({
    onfocusout: false,
    rules: {
        nombre_programa: 'campoNoVacio'
    },
    messages: {
        nombre_programa: 'Campo obligatorio'
    }
});
// <------
tooltip( tablaProgramas, btnEditarPrograma );
tooltip( tablaProgramas, btnEliminarPrograma );
// ------> Restablecer modal 
modalPrograma.on('hidden.bs.modal', function () {
    modalCatalogoProgramas.modal('show');
    restablecer_formulario( formPrograma );
}).modal('hide');