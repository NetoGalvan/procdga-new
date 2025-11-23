// Variables
var btnAgregarEscuela = $('.escuela');
var modalCatalogoEscuelas = $('#modalCatalogoEscuelas');
var modalEscuela = $('#modalEscuela');

var tablaEscuelas = $('#tablaEscuelas');
var btnEditarEscuela = '#editarEscuela';
var btnEliminarEscuela = '#eliminarEscuela';

var nombreEscuela = $('#nombreEscuela');
var acronimoEscuela = $('#acronimoEscuela');
var direccionEscuela = $('#direccionEscuela');

var formEscuela = $('#formEscuela');
var finalizarProcesoEscuela = $('.guardar-modificar-escuela');

//BEGIN::Bootstrap Table -> Escuelas
// ------> Funcion Formatter
function accionesEscuelasFormatter(v, row) {
    return `<button class="btn btn-icon btn-sm btn-outline-primary m-2" id="editarEscuela" title="<b>EDITAR ESCUELA</b>" 
                data-escuela="${row.acronimo_escuela}"
            >
                <i class="far fa-edit"></i>
            </button>
            <button class="btn btn-icon btn-sm btn-outline-danger m-2" id="eliminarEscuela" title="<b>ELIMINAR ESCUELA</b>"
                data-escuela="${row.acronimo_escuela}"
            >
                <i class="far fa-trash-alt"></i>
            </button>`;
}

// Botones
btnAgregarEscuela.click( function() {
    finalizarProcesoEscuela.data('acronimoEscuela', null);
    modalCatalogoEscuelas.modal('hide');

    modalEscuela.find('.modal-title').html(`Agregar escuela ${spanTitulo}`);
});
// ------> Abrir modal para editar Escuela
tablaEscuelas.on('click', btnEditarEscuela, function(e) {
    e.preventDefault();
    
    modalCatalogoEscuelas.modal('hide');
    //alert_loading();
    bloquearModal();
    var acronimo_escuela = $(this).data('escuela');
    modalEscuela.find('.modal-title').html(`Editar escuela ${spanTitulo}`);

    $.post(`${URL_datosEscuela}/${acronimo_escuela}`)
     .done( function (response) {
        // Insertar valores al modal
        nombreEscuela.val(response.nombre_escuela);
        acronimoEscuela.val(response.acronimo_escuela);
        direccionEscuela.text(response.direccion_escuela);
        finalizarProcesoEscuela.data('acronimoEscuela', acronimo_escuela);

        modalEscuela.modal('show');
        desbloquearModal(1000);
        //alert_time_close(750);
     });
});
// ------> eliminar Escuela
tablaEscuelas.on('click', btnEliminarEscuela, function(e) {
    e.preventDefault();
    
    var dataAcronimoEscuela = $(this).data('escuela');

    alert_warning_secondary(`Eliminara la escuela <b>${dataAcronimoEscuela}</b>`, 
    function(result) {
        if ( result.value ) {
            $.post( URL_eliminar_escuela + '/' + dataAcronimoEscuela ).done(function(response) 
             {
                if ( response.estatus ) {
                    alert_success(`La escuela <b>${dataAcronimoEscuela}</b> se eliminó correctamente`, null);
                    $('#tablaEscuelas').bootstrapTable('load', response.escuelas);
                    $('#tablaEscuelas').bootstrapTable('refreshOptions', { pageNumber : 1, pageSize: 5 });
                } else {
                    alert_error(response.mensaje, null);
                }
             });
        }
    });
});
// ------> Guardar o editar escuela
finalizarProcesoEscuela.click(function(e) {
    e.preventDefault();

    var dataClaveInstitucion = '/' + $(this).data('claveInstitucion');
    var dataAcronimoEscuela = '/' + $(this).data('acronimoEscuela');

    if ( formEscuela.valid() ) {
        alert_warning_secondary('Verifique que la información sea correcta', 
        function(result) {
            if ( result.value ) {
                $.post( URL_guardar_modificar_escuela + dataClaveInstitucion + dataAcronimoEscuela, formEscuela.serialize() )
                 .done(function(response) {
                    if ( response.estatus ) 
                    {
                        alert_success(response.mensaje, null);
                        $('#tablaEscuelas').bootstrapTable('load', response.escuelas);
                        modalEscuela.modal('hide');
                    } else {
                        alert_error(response.mensaje, null);
                    }
                 });
            }
        });
    }
});

// Validación
formEscuela.validate({
    onfocusout: false,
    rules: {
        nombre_escuela: 'campoNoVacio',
        acronimo_escuela: 'campoNoVacio',
        direccion_escuela: 'campoNoVacio',
    },
    messages: {
        nombre_escuela: 'Campo obligatorio',
        acronimo_escuela: 'Campo obligatorio',
        direccion_escuela: 'Campo obligatorio'
    }
});
// ------> Tooltip
tooltip( tablaEscuelas, btnEditarEscuela );
tooltip( tablaEscuelas, btnEliminarEscuela );
// ------> Restablecer modal 
modalEscuela.on('hidden.bs.modal', function () {
    modalCatalogoEscuelas.modal('show');
    restablecer_formulario( formEscuela );
    direccionEscuela.text(null);
}).modal('hide');