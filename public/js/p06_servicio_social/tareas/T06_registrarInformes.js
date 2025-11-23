//Variables
var tablaSeguimientos = $('#TablaSeguimientoEventos');
var formRegistrarSegumiento = $("#registrarSeguimiento");
var btnSeguimientos = $('#btnSeguimientoEventos');

//BEGIN::Tabla informes/seguimientos
function showCargarInformes(params){
    $.post(URL_registrarInformes).done(function(response){
        params.success(response);
    });
}
// -----
function tipoInformeFormatter(value, r){
    var tipoInforme;
    var color;
    switch(value){
        case 'informe_uno':
            tipoInforme = '1ER INFORME';
            color = 'success';
            break;

        case 'informe_dos':
            tipoInforme = '2DO INFORME';
            color = 'primary';
            break;

        case 'informe_tres':
            tipoInforme = '3ER INFORME';
            color = 'warning';
            break;
    }
    return `<span class="badge badge-${color}">${tipoInforme}</span>`;
};
//END::Tabla informes/seguimientos
//BEGIN::Validición
formRegistrarSegumiento.validate({
    onfocusout: false,
    rules: {
        tipo_informe: 'required',
        comentario: 'campoNoVacio'
    },
    messages: {
        tipo_informe: 'Campo obligatorio',
        comentario: 'Campo obligatorio'
    }
});
//END::Validación
// Boton -->
btnSeguimientos.on('click', function(e){
    e.preventDefault();
    if( formRegistrarSegumiento.valid() )
    {
        alert_warning_secondary("Verifique que la información ingresada sea correcta.", 
        (result) => {
            if (result.value) {
                $.post(URL_registrarInformes, formRegistrarSegumiento.serialize() ).done(function(response) {
                    if( response.estatus ){
                        tablaSeguimientos.bootstrapTable('refresh');
                        restablecer_formulario( formRegistrarSegumiento );
                        alert_success(response.mensaje, null);
                    } else {
                        alert_error(response.mensaje, null);
                    }
                });
            }
        });
    }
});
// Boton <--