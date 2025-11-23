// Variables
var btnAgregarInstitucion = $('.institucion');
var modalInstitucion = $('#modalInstitucion');
var formInstitucion = $('#formInstitucion');

var tablaInstituciones = $('#tablaInstituciones');
var btnVerProgramas = '#verProgramas';
var btnVerEscuelas = '#verEscuelas';
var btnEditarInstitucion = '#editarInstitucion';
var btnEliminarInstitucion = '#eliminarInstitucion';

var nombreInstitucion = $('#nombreInstitucion');
var acronimoInstitucion = $('#acronimoInstitucion');
var claveInstitucion = $('#claveInstitucion');
var finalizarProcesoInstitucion = $('.guardar-modificar-institucion');

//BEGIN::Bootstrap Table -> Cargar instituciones
function showInstituciones(params){
    $.post(URL_showInstituciones).done(function(response){
        params.success(response);
    });
}
// ------> Funciones Formatter
function accionesFormatter(v, row) {
    return `<button class="btn btn-icon btn-sm btn-outline-success m-2" id="verProgramas" title="<b>VER PROGRAMAS</b>"
                data-institucion="${row.clave_institucion}" 
                data-nombre-institucion="${row.acronimo_institucion} | ${row.nombre_institucion}"
            >
                <i class="fas fa-list-ul"></i>
            </button>
            <button class="btn btn-icon btn-sm btn-outline-info m-2" id="verEscuelas" title="<b>VER ESCUELAS</b>"
                data-institucion="${row.clave_institucion}"
                data-nombre-institucion="${row.acronimo_institucion} | ${row.nombre_institucion}"
            >
                <i class="fas fa-school"></i>
            </button>
            <button class="btn btn-icon btn-sm btn-outline-primary m-2" id="editarInstitucion" title="<b>EDITAR INSTITUCIÓN</b>"
                data-institucion="${row.clave_institucion}"
            >
                <i class="far fa-edit"></i>
            </button>
            <button class="btn btn-icon btn-sm btn-outline-danger m-2" id="eliminarInstitucion" title="<b>ELIMINAR INSTITUCIÓN</b>"
                data-institucion="${row.clave_institucion}"
                data-acronimo-institucion="${row.acronimo_institucion}"
            >
                <i class="far fa-trash-alt"></i>
            </button>`;
}
//END::Bootstrap Table -> Cargar instituciones

//BEGIN::Botones
// ------> Abrir modal para agregar una institucion
btnAgregarInstitucion.click(function () {
    finalizarProcesoInstitucion.data('claveInstitucion', null);
    modalInstitucion.find('.modal-title').html(`Agregar Institución ${spanTitulo}`); //Modificar modal-title (titulo del modal)
});
// ------> Abrir modal para editar prestador
tablaInstituciones.on('click', btnEditarInstitucion, function(e) {
    e.preventDefault();

    bloquearModal();//alert_loading();
    var clave_institucion = $(this).data('institucion');

    modalInstitucion.find('.modal-title').html(`Editar institución ${spanTitulo}`); //Modificar modal-title (titulo del modal)

    $.post(`${URL_datosInstitucion}/${clave_institucion}`)
     .done( function (response) {

        nombreInstitucion.val(response.nombre_institucion);
        acronimoInstitucion.val(response.acronimo_institucion);
        claveInstitucion.val(response.clave_institucion);
        finalizarProcesoInstitucion.data('claveInstitucion', clave_institucion);

        modalInstitucion.modal('show');
        desbloquearModal(1000);
        //alert_time_close(750);
     });
});
// ------> Guardar o editar institucion
finalizarProcesoInstitucion.click(function(e) {
    e.preventDefault();

    var dataClaveInstitucion = '/' + $(this).data('claveInstitucion');

    if ( formInstitucion.valid() ) {
        alert_warning_secondary('Verifique que la información sea correcta', 
        function(result) {
            if ( result.value ) {
                $.post( URL_guardar_modificar_institucion + dataClaveInstitucion, formInstitucion.serialize() )
                 .done(function(response) {
                    if ( response.estatus ) 
                    {
                        alert_success(response.mensaje, null);
                        tablaInstituciones.bootstrapTable('load', response.instituciones);
                        tablaInstituciones.bootstrapTable('refreshOptions', { pageNumber : 1, pageSize: 5 });
                        modalInstitucion.modal('hide');
                    } else {
                        alert_error(response.mensaje, null);
                    }
                 });
            }
        });
    }
});
// ------> eliminar institucion
tablaInstituciones.on('click', btnEliminarInstitucion, function(e) {
    e.preventDefault();
    
    var dataClaveInstitucion = $(this).data('institucion');
    var dataAcronimoInstitucion = $(this).data('acronimoInstitucion');

    alert_warning_secondary(`Eliminara la institución <b>${dataAcronimoInstitucion}</b>`, 
    function(result) {
        if ( result.value ) {
            $.post( URL_eliminar_institucion + '/' + dataClaveInstitucion ).done(function(response) 
             {
                if ( response.estatus ) {
                    alert_success(`La institución <b>${dataAcronimoInstitucion}</b> se eliminó correctamente.`, null);
                    tablaInstituciones.bootstrapTable('load', response.instituciones);
                    tablaInstituciones.bootstrapTable('refreshOptions', { pageNumber : 1, pageSize: 5 });
                } else {
                    alert_error(response.mensaje, null);
                }
             });
        }
    });
});
//
// Botones::Catalogos --> 
// ------> Ver programas
tablaInstituciones.on('click', btnVerProgramas, function(e) {
    e.preventDefault();

    var dataClaveInstitucion = $(this).data('institucion');
    modalCatalogoProgramas.find('.nombre-institucion').html('<b>' + $(this).data('nombreInstitucion') + '</b>'); // Titulo de la institución en el modal del catálogo de programas
    $('.clave-programa').html(`<b>${dataClaveInstitucion} - </b>`); // Modal programa - asignar clave de la institucion al span de la clave programa

    $.post(`${URL_showProgramas}/${dataClaveInstitucion}`)
     .done( function (response) {
        tablaProgramas.bootstrapTable('load', response);
        finalizarProcesoPrograma.data('claveInstitucion', dataClaveInstitucion); //Asignar atributo data en el modal programa - boton de guardar
        modalCatalogoProgramas.modal('show');
     });

    modalCatalogoProgramas.on('hidden.bs.modal', function () {
        tablaProgramas.bootstrapTable('refreshOptions', { pageNumber : 1, pageSize: 5 });
    }).modal('hide');
});
// ------> Ver escuelas
tablaInstituciones.on('click', btnVerEscuelas, function(e) {
    e.preventDefault();

    var dataClaveInstitucion = $(this).data('institucion');
    modalCatalogoEscuelas.find('.nombre-institucion').html('<b>' + $(this).data('nombreInstitucion') + '</b>'); // Titulo de la institución en el modal del catálogo de escuelas

    $.post(`${URL_showEscuelas}/${dataClaveInstitucion}`)
     .done( function (response) {
        tablaEscuelas.bootstrapTable('load', response);
        finalizarProcesoEscuela.data('claveInstitucion', dataClaveInstitucion); //Asignar atributo data en el modal escuela - boton de guardar
        modalCatalogoEscuelas.modal('show');
     });

    modalCatalogoEscuelas.on('hidden.bs.modal', function () {
        tablaEscuelas.bootstrapTable('refreshOptions', { pageNumber : 1, pageSize: 5 });
    }).modal('hide');
});
// Botones::Catalogos <--

// ------> Tooltip
tooltip( tablaInstituciones, btnVerProgramas );
tooltip( tablaInstituciones, btnVerEscuelas );
tooltip( tablaInstituciones, btnEditarInstitucion );
tooltip( tablaInstituciones, btnEliminarInstitucion );

// Validación
formInstitucion.validate({
    onfocusout: false,
    rules: {
        nombre_institucion: 'campoNoVacio',
        acronimo_institucion: 'campoNoVacio',
        clave_institucion: 'campoNoVacio'
    },
    messages: {
        nombre_institucion: 'Campo obligatorio',
        acronimo_institucion: 'Campo obligatorio',
        clave_institucion: 'Campo obligatorio'
    }
});

// ------> Restablecer modal 
modalInstitucion.on('hidden.bs.modal', function () {
    restablecer_formulario( formInstitucion );
}).modal('hide');