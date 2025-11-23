//Variables
var tipoAccion = "#tipo_accion";
var descripcion = "#descripcion";
var hrsAsistencia = "#horas_asistencia";
//var horasTerminadas = (parseInt($('.horas-restantes').html()) == 0) ? true : false;

var tablaCargarDocumentos = $('#tabla_documentos');
var formCargarDocumento = $("#cargarDocumento");
var btnCargarDocumentos = $("#btn_carga_documento");

//BEGIN::Tabla cargar documentos
function showCargarDocumentos(params){
    $.post(URL_registrarDocumentos).done(function(response){
        params.success(response);
    });
}
// -----
function tipoDocumentoFormatter(value, r){
    console.log(value);
    var color;
    if(value == 'SUBIR HORAS'){
        color = 'primary';
    } else if(value == 'SOLICITAR BAJA'){
        color = 'danger';
    } else {
    	color = 'secondary';
    }
    return `<span class="badge badge-${color}">${value}</span>`;
};
// -----
function horasAsistenciaFormatter(value, r){
    return (value == null) ? 'N/A' : value;
};
// -----
function archivoFormatter(v, row){
	if(row.tipo_archivo == 'ABANDONO') return 'N/A';
    return `<a class="btn btn-outline-danger abrir-archivo" title="<b>ABRIR DOCUMENTO</b>"
                target="_blank" href="${storage + '/' + row.ruta_archivo}"
            >
                <i class="far fa-file-pdf"></i>
            </a>`;
};

tooltip(tablaCargarDocumentos, '.abrir-archivo');
//END::Tabla cargar documentos
//
//BEGIN::Horas asistencia
const HTML_horasAsistencia = `<label class="titulo-dato"><span class="requeridos">* </span>Horas de asistencia</label>
                              <input type="text" class="form-control w-50 m-auto" name="horas_asistencia" id="horas_asistencia">`;

$(tipoAccion).on('change', function(e) {
    e.preventDefault();

    if($(this).val() == 'SUBIR HORAS'){
        $('.horas-asistencia').html(HTML_horasAsistencia);
        $('.horas-asistencia').attr('class', 'col-md-3 horas-asistencia');
        $("#horas_asistencia").inputmask({ "mask": "9", "repeat": 3 });
    }  else {
        $('.horas-asistencia').html('');
        $('.horas-asistencia').attr('class', 'horas-asistencia');
    }
});
//END::Horas asistencia
//
// Boton -->
btnCargarDocumentos.on('click', function(e) {
    if ( formCargarDocumento.valid() ) {
        if( $(tipoAccion).val() == 'ABANDONO' ) {
            alert_warning_secondary("Verifique que los datos sean correctos", 
            (result) => {
                if (result.value) {
                    $.post(URL_registrarDocumentos, formCargarDocumento.serialize() ).done(function(response) {
                        if( response.estatus ){
                            tablaCargarDocumentos.bootstrapTable('refresh');
                            restablecer_formulario( formCargarDocumento );
                            alert_success(response.mensaje, null);
                        } else {
                            alert_error(response.mensaje, null);
                        }
                    });
                }
            });
            
        } else {
            if (dropzoneSubirDocumento.getAcceptedFiles().length == 1) {
                alert_warning_secondary("Verifique el documento que enviará", 
                (result) => {
                    if (result.value)  dropzoneSubirDocumento.processQueue();
                });
                
            } else {
                alert_warning_simple("Debe subir el documento correspondiente");
            }
        }
    }
});
// Boton <--
//BEGIN::Dropzone
var dropzoneSubirDocumento = new Dropzone('#guardar_archivo_dropzone', {
    headers : {
        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
    },
    url: URL_registrarDocumentos,
    method: 'POST',
    paramName: "file",
    maxFiles: 1,
    addRemoveLinks: true,
    autoProcessQueue: false,
    acceptedFiles: "application/pdf",
    maxFilesize: 10,
});
// ----- Enviar
dropzoneSubirDocumento.on("sending", function(file, xhr, formData) {
    formData.append("tipo_accion", $(tipoAccion).val() );
    formData.append("descripcion", $(descripcion).val() );

    if( $(hrsAsistencia).val() != undefined )
    {
        formData.append("horas_asistencia", $(hrsAsistencia).val());
    }
});
// -----
dropzoneSubirDocumento.on("success", function(file, response) {
    
    if (response.estatus) {
        tablaCargarDocumentos.bootstrapTable('refresh');
        restablecer_formulario( formCargarDocumento );
        
        //Actualizar horas restantes
        $('.horas-restantes').html(response.horasRestantes);
        horasTerminadas = (response.horasRestantes == 0) ? true : false;

        //Actualizar validacón cantidad máxima
        formCargarDocumento.validate().settings.rules.horas_asistencia.max = response.horasRestantes;   
        alert_success(response.mensaje, null);
    } else {
        alert_error(response.mensaje, null);
    }
    dropzoneSubirDocumento.removeFile(file);
});
//END::Dropzone
//
//BEGIN::Validación
validator = formCargarDocumento.validate({
    onfocusout: false,
    rules: {
        tipo_accion: 'required',
        descripcion: 'campoNoVacio',
        horas_asistencia: {
            required: true,
            max: parseInt($('.horas-restantes').html()),
        }
    },
    messages: {
        tipo_accion: 'Campo obligatorio',
        descripcion: 'Campo obligatorio',
        horas_asistencia: {
            required: 'Campo obligatorio',
            max: 'Sobrepasa a las horas restantes'
        }
    }
});
//END::Validación