var formActualizarNotas = $('#form_actualizar_notas');
var formCargarDocumento = $('#form_cargar_documento');
var tipo = $('[name="tipo"]');
var fojas = $('[name="fojas"]');
var tablaDescripcionTabla = $('#tabla_descripcion_documento');
var tablaInformativaDocumentos = $('#tabla_informativa_documentos');
var btnAgregarDocumento = $('#btn_agregar_documento');
var btnCargarDocumento = $('#btn_cargar_documento');
var dataDocumentos = [];
var expedienteActual = $('#expediente_actual');
var btnfinalizarProceso = $('#btn_finalizar_proceso');
var checkBorrarExp = $('[name="check_borrar_expediente"]');
var causaEliminacion = $('[name="causa_eliminacion"]');
var formBorrarExp = $('#form_borrar_ficha_expediente');

//BEGIN::TABLA ACTUALIZAR NOTAS
$('#btn_actualizar_notas').click( function(e) {
    e.preventDefault();

    var datos = datosNotasActualizado();

    $.post(URL_actualizarNotas, {dataNotas: datos} ).done(function(response) {
        tablaNotas.bootstrapTable('load', response.actualizarNotas);
        dataNotas = response.actualizarNotas;
    });
});
//END::TABLA ACTUALIZAR NOTAS

//BEGIN::TABLA CARGAR DOCUMENTO
btnAgregarDocumento.click( function(e) {
    e.preventDefault();

    var vTipo = tipo.val().trim();
    var vFojas = fojas.val().trim();

    if( formCargarDocumento.valid() ) {
        var existe = false;
        $.each(dataDocumentos, function(x, item) { if ( item.tipo == vTipo ) existe = true; });

        if( !existe ) {
            dataDocumentos.push({
                'tipo': vTipo,
                'fojas': vFojas,
                'accion': `<button id="eliminar_descripcion" class="btn btn-outline-danger btn-sm" data-tipo="${vTipo}"> <i class="fas fa-trash-alt"></i> </button>`
            });
        }
        tablaDescripcionTabla.bootstrapTable('load', dataDocumentos);
        formCargarDocumento.trigger("reset");
        validator.resetForm();
    }
});

tablaDescripcionTabla.on('click', '#eliminar_descripcion', function(e) {
    e.preventDefault();

    var dataTipo = $(this).data('tipo');

    if(dataDocumentos.length == 0) dataDocumentos = tablaDescripcionTabla.bootstrapTable('getData');

    var a = '';
    $.each(dataDocumentos, function(x, item) { if ( item.tipo == dataTipo ) a = x; });

    dataDocumentos.splice(a, 1);
    tablaDescripcionTabla.bootstrapTable('load', dataDocumentos);
});

var validator = formCargarDocumento.validate({
    onfocusout: false,
    rules: {
        tipo: 'campoNoVacio',
        fojas: 'campoNoVacio'
    },
    messages: {
        tipo: 'Campo obligatorio',
        fojas: 'Campo obligatorio'
    }
});
//END::TABLA CARGAR DOCUMENTO

//BEGIN::CARGAR DOCUMENTO
var dropzoneSubirDocumento = new Dropzone('#guardar_archivo_dropzone', {
    headers : {
        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
    },
    url: URL_enviarDocumento,
    method: 'POST',
    paramName: "file",
    maxFiles: 1,
    addRemoveLinks: true,
    autoProcessQueue: false,
    acceptedFiles: "application/pdf",
    maxFilesize: 10,
    accept: function(file, done) {
        done();
    }
});
// -----------------------------------------------------------------------------------------------
dropzoneSubirDocumento.on("maxfilesexceeded", function(file, error, xhr) {
    dropzoneSubirDocumento.removeAllFiles();
    dropzoneSubirDocumento.addFile(file);
});
// -----------------------------------------------------------------------------------------------
dropzoneSubirDocumento.on("sending", function(file, xhr, formData) {
    var datosDoc = [];
    $.each(dataDocumentos, function(x, item) { datosDoc.push({tipo: item.tipo, fojas: item.fojas}) });
    formData.append( "descripciones_del_documento", JSON.stringify(datosDoc) );
});
// -----------------------------------------------------------------------------------------------
dropzoneSubirDocumento.on("success", function(file, response) {
    dropzoneSubirDocumento.removeFile(file)
    
    if (response.estatus) {

        var dataDescripcionExp = [];
        $.each(response.detalles_exp, function(x, item) {
            dataDescripcionExp.push({
                'info_tipo': item.documento,
                'info_fojas': item.hojas
            });
        });

        $('.info-alert').addClass('d-none');
        $('.info-boton').removeClass('d-none');
        $('.info-doc').removeClass('d-none');

        tablaInformativaDocumentos.bootstrapTable('refreshOptions', { pageNumber : 1 });
        tablaInformativaDocumentos.bootstrapTable('load', dataDescripcionExp);

        expedienteActual.attr('href', `${storage}/${response.ruta_archivo}`);
        expedienteActual.html(`<i class="far fa-file-pdf"></i>Expediente actual - ${response.nombre_archivo}`);

        dataDocumentos = [];
        tablaDescripcionTabla.bootstrapTable('load', dataDocumentos);

        alert_success(response.mensaje, null);

    } else {
        alert_error(response.mensaje, null);
    }
});
// -----------------------------------------------------------------------------------------------
btnCargarDocumento.click( function(e) {
    e.preventDefault();

    var dataDescripcionExp = tablaInformativaDocumentos.bootstrapTable('getData'); 
    if(dataDocumentos.length == 0) dataDocumentos = tablaDescripcionTabla.bootstrapTable('getData');

    if (dropzoneSubirDocumento.getAcceptedFiles().length == 1) {
        if( dataDocumentos.length == 0 ) {
            alert_warning_simple('Agregar las descripciones correspondientes del documento', null);

        } else {
            alert_warning_secondary('¡Verifique que el documento que enviará sea el correspondiente!', 
                (result) => {
                    if (result.value) dropzoneSubirDocumento.processQueue();
            });
        }

    } else {
        alert_warning_simple('¡Verifique cargar el documento correspondiente!', null);

    }
});
//END::CARGAR DOCUMENTO

//BEGIN::FINALIZAR PROCESO
btnfinalizarProceso.click( function(e) { 
    e.preventDefault();

    if( checkBorrarExp.is(':checked') ) {
        if ( formBorrarExp.valid() ) {
            alert_warning_secondary('Eliminar ficha del expediente.', 
                (result) => {
                    if (result.value) submitEnd();
            }); 
        }
    } else {
        formBorrarExp.validate().settings.ignore = '[name="causa_eliminacion"]';
        alert_warning_secondary('Finalizar actualización del expediente.', 
            (result) => {
                if (result.value) submitEnd();
        }); 
    }
});

validatorBorrarExp = formBorrarExp.validate({
    onfocusout: false,
    rules: {
        causa_eliminacion: 'campoNoVacio'
    },
    messages: {
        causa_eliminacion: 'Campo obligatorio'
    }
});

var submitEnd = () => {
    KTApp.blockPage({
            overlayColor: '#000000',
            state: 'danger',
            message: 'Por favor, espere...'
        });
    formBorrarExp.submit();
} 
//END::FINALIZAR PROCESO