//Variables
var area = $('#area_id');
var anio = $('#anio_busqueda');
var estatus = $('#estatus');
var tablaPrestadoresPorUnidad = $('#tablaPrestadoresPorUnidad');

var btnFiltrar = $('#btn_filtrar');
const btnFiltrarClass = btnFiltrar.attr('class');
const HTML_buttonIconFiltrar = '<i class="fas fa-search"></i>';

var btnLimpiar = $('#btn_limpiar');
const btnLimpiarClass = btnLimpiar.attr('class');
const HTML_buttonIconLimpiar = '<i class="fas fa-brush"></i>';

var color;
//BEGIN::Configuraciones
/*
area.select2({
    placeholder: 'SELECCIONE UNA OPCIÓN'
});

anio.datepicker({
    format: "yyyy",
    viewMode: "years",
    minViewMode: "years",
    startDate: '2000',
    endDate: '+0y',
    autoclose : true,
    orientation: "bottom left"
});
*/
var dataForm = (area, anio, estatus) => {
    return { 
        area_identificador: area.val(), 
        anio: anio.val(),
        estatus: estatus.val(),

    }
}
//END::Configuraciones
//BEGIN::Bootstrap Table
function prestadoresPorUnidad(params) {
    
    $.post(URL_prestadoresPorUdAdmin, dataForm(area, anio, estatus) ).done(function(response){
        params.success(response);
    });
}
// ------ Funciones Formatter
function tipoServicioFormatter(v, data) {
    var tipoServicio = (data.prestador != null) ? data.prestador.tipo_prestador : data.tipo_prestador;
    tipoServicio = tipoServicio.toUpperCase();

    if( tipoServicio == 'SERVICIO SOCIAL' ) color = 'primary';
    if( tipoServicio == 'PRÁCTICAS PROFESIONALES' || tipoServicio == 'PRACTICAS PROFESIONALES' ) color = 'secondary';
    if( tipoServicio == 'RESIDENCIA PROFECIONAL' ) color = 'info';
    
    return `<span class="badge badge-${color} badge-sm">${tipoServicio}</span>`;
}

function estatusServicioFormatter(v, data) {
    var catalogoEstatus = {
            FREE: 'LIBERADO',
            WORKING: 'EN CURSO',
            ABANDON: 'ABANDONO',
            EN_CURSO: 'EN CURSO'
        };

    var estatus = (data.prestador != null) ? data.prestador.estatus_prestador : catalogoEstatus[data.work_status];
    estatus = (estatus == 'EN_CURSO') ? catalogoEstatus[data.prestador.estatus_prestador] : estatus;

    if( estatus == 'LIBERADO' ) color = 'success';
    if( estatus == 'EN CURSO' ) color = 'primary';
    if( estatus == 'BAJA') color = 'danger';
    if( estatus == 'ABANDONO') color = 'outline-danger';

    return `<span class="label label-lg label-${color} label-inline mr-2">${estatus}</span>`;
}
//END::Bootstrap Table
//BEGIN::Botones
// ------ Filtrar
btnFiltrar.on('click', function(e) {
    e.preventDefault();

    //botonFiltrar(btnFiltrar, true, `${btnFiltrarClass} spinner spinner-white spinner-right`, `${HTML_buttonIconFiltrar} Buscando...`);    
    activarSpinner( $(this) );
    //$.post(URL_prestadoresPorUdAdmin, dataForm(area, anio, estatus) )
     //.done(function(response){
        tablaPrestadoresPorUnidad.bootstrapTable('refreshOptions', {
            pageNumber : 1,  
            pageSize: 10, 
            onRefreshOptions: function() {
                $.post(URL_prestadoresPorUdAdmin, dataForm(area, anio, estatus) );
            },
            onLoadSuccess: function() { desactivarSpinner( btnFiltrar ); }
        });
    //});
});
// ------ Limpiar
btnLimpiar.on('click', function(e) {
    e.preventDefault();

    //botonFiltrar(btnLimpiar, true, `${btnLimpiarClass} spinner spinner-white spinner-right`, `${HTML_buttonIconLimpiar} Restableciendo...`); 
    activarSpinner02( $(this) );

    var date = new Date();
    $('#area_id, #estatus').val('').trigger('change'); 
    anio.val(date.getFullYear());
    
    //$.post(URL_prestadoresPorUdAdmin, dataForm(area, anio, estatus) ).done(function(response){
        tablaPrestadoresPorUnidad.bootstrapTable('refreshOptions', { 
            pageNumber : 1,  
            pageSize: 10,
            onRefreshOptions: function() {
                $.post(URL_prestadoresPorUdAdmin, dataForm(area, anio, estatus) );
            },
            onLoadSuccess: function() { desactivarSpinner02( btnLimpiar ); }
        
        });
    //});
});
// ------ Descargar reporte
$('#btn_reporte').on('click', function(e) {
    e.preventDefault();
    var date = new Date();
    var mes = ((date.getMonth()+1) < 10) ? `0${date.getMonth()+1}` : date.getMonth()+1;

    var data_form = dataForm(area, anio, estatus);
    data_form.descargar_reporte = true;

    $.ajax({
        url: URL_prestadoresPorUdAdmin,
        type: "GET",
        data: data_form,
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
            link.download = `Reporte por unidades administrativas_'${date.getDate()}-${mes}-${date.getFullYear()}.pdf`;
            link.click();

            KTApp.unblockPage();
        }
    });
});
//END::Botones

var botonFiltrar = (boton, disabled, atr_class, html) =>{
    boton.attr('disabled', disabled);
    boton.attr('class', atr_class);
    boton.html(html);
}