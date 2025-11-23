//Variables
var tabla_IEP = $('#tabla_IEP');
var opcion = $('.opciones');
var btnDescargarReporte = $('#btn_reporte');
const thAcronimo = $('.acronimo').attr('class');

var btnFiltrar = $('#btn_filtrar');
const btnFiltrarClass = btnFiltrar.attr('class');
const HTML_buttonIcon = '<i class="fas fa-search"></i>';
//BEGIN::Bootstrap Table
function tablaIEP(params) {
    
    $.post(URL_reporteIEP, { opcion: opcion.val() } ).done(function(response){
        params.success(response);
    });
}
// ------ Funciones Formatter
function nombreIEPFormatter(v, data) {
    var nombreIEP;
    
    if ( data.nombre_escuela ) nombreIEP = data.nombre_escuela;
    if ( data.nombre_programa ) nombreIEP = data.nombre_programa;
    if ( data.nombre_institucion ) nombreIEP = data.nombre_institucion;

    return nombreIEP;
}

function acronimoIEPFormatter(v, data) {
    var acronimoIEP;
    
    if ( data.acronimo_escuela ) acronimoIEP = data.acronimo_escuela;
    if ( data.numero_programa ) acronimoIEP = data.numero_programa;
    if ( data.acronimo_institucion ) acronimoIEP = data.acronimo_institucion;

    return acronimoIEP;
}

function claveODirIEPFormatter(v, data) {
    var clave_direcccion_IEP;
    
    if ( data.direccion_escuela ) clave_direcccion_IEP = data.direccion_escuela;
    if ( data.clave_programa ) clave_direcccion_IEP = data.clave_programa;
    if ( data.clave_institucion ) clave_direcccion_IEP = data.clave_institucion;

    return clave_direcccion_IEP;
}
//END::Bootstrap Table
//BEGIN::Botones
// ------ Filtrar
btnFiltrar.on('click', function(e) {
    e.preventDefault();

    botonFiltrar(true, `${btnFiltrarClass} spinner spinner-white spinner-right`, `${HTML_buttonIcon} Buscando...`);    

    $.post(URL_reporteIEP, { opcion: opcion.val() } ).done(function(response){

        tabla_IEP.bootstrapTable('refreshOptions', {
            pageNumber : 1,  
            pageSize: 10, 
            onLoadSuccess: function() {
                botonFiltrar(false, btnFiltrarClass, `${HTML_buttonIcon} Buscar`);
            }
        });
        
        ( opcion.val() != 'ESCUELAS' ) ? $('.COD').html('Clave') : $('.COD').html('Dirección');
        ( opcion.val() == 'PROGRAMAS' )
            ? tabla_IEP.bootstrapTable('hideColumn', 'acronimo')
            : tabla_IEP.bootstrapTable('showColumn', 'acronimo') ;

     });
});
// ------ Descargar reporte
btnDescargarReporte.on('click', function(e) {
    e.preventDefault();

    var date = new Date();
    var mes = ((date.getMonth()+1) < 10) ? `0${date.getMonth()+1}` : date.getMonth()+1;

    $.ajax({
        url: URL_reporteIEP,
        type: "GET",
        data: { 
            opcion: opcion.val(), 
            descargar_reporte: true
        },
        xhrFields: { responseType: 'blob' },
        beforeSend: function() {
            KTApp.blockPage({
                overlayColor: '#000000',
                state: 'danger',
                message: 'Por favor, espere...'
            });
        },
        success: function (response) {
            let link = document.createElement('a');
            let url = window.URL.createObjectURL(response);
            link.href = url;
            link.download = `Reporte ejecutivo de ${opcion.val()}_${date.getDate()}-${mes}-${date.getFullYear()}.pdf`;
            link.click();

            KTApp.unblockPage();
        }
    });
});
//END::Botones

var botonFiltrar = (disabled, atr_class, html) =>{
    btnFiltrar.attr('disabled', disabled);
    btnFiltrar.attr('class', atr_class);
    btnFiltrar.html(html);
}