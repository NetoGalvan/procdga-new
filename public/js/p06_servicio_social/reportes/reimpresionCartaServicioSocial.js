//Variables
var fechaInicio = $('.fecha-inicio');
var fechaFin = $('.fecha-fin');
var tablaPrestadores = $('#tablaPrestadores');

var btnFiltrar = $('#btn_filtrar');
const btnFiltrarClass = btnFiltrar.attr('class');
const HTML_buttonIcon = '<i class="fas fa-search"></i>';

//BEGIN::Configuraciones
/*
// ----- Fecha
var date = new Date;
$(fechaInicio).val(`01/01/${date.getFullYear()}`);
$(fechaFin).val(`31/12/${date.getFullYear()}`);

$(`${fechaInicio}, ${fechaFin}`).inputmask({mask: '##/##/####'});
$(`${fechaInicio}, ${fechaFin}`).datepicker({
    rtl: KTUtil.isRTL(),
    todayHighlight: true,
    format: 'dd/mm/yyyy',
    language: 'es',
    autoclose: true,
    orientation: 'bottom'
});
*/
var estructurarFecha = (fecha) => {
    var fechaPartes = fecha.split("/");
    return `${fechaPartes[2]}-${fechaPartes[1]}-${fechaPartes[0]}`;
}
//END::Configuraciones
//BEGIN::Bootstrap Table
var color, info;
var catalogoEstatus = {
        FREE: 'LIBERADO',
        WORKING: 'EN CURSO',
        ABANDON: 'ABANDONO',
        EN_CURSO: "EN CURSO"
    };

function datosPrestadores(params) {
    var inicio = estructurarFecha( fechaInicio.val() );
    var fin = estructurarFecha( fechaFin.val() );
    
    $.post(URL_datosPrestadores, { fecha_inicio: inicio, fecha_fin: fin} )
     .done(function(response){
        params.success(response);
     });
}
// ------ Funciones Formatter
function matriculaFormatter(v, data) {
    return (data.prestador != null) ? data.prestador.matricula : data.matricula;
}

function tipoServicioFormatter(v, data) {
    var tipoServicio = (data.prestador != null) ? data.prestador.tipo_prestador : data.tipo_prestador;
    tipoServicio = tipoServicio.toUpperCase();

    if( tipoServicio == 'SERVICIO SOCIAL' ) color = 'primary';
    if( tipoServicio == 'PRÁCTICAS PROFESIONALES' || tipoServicio == 'PRACTICAS PROFESIONALES' ) color = 'secondary';
    if( tipoServicio == 'RESIDENCIA PROFECIONAL' ) color = 'info';

    return `<span class="badge badge-${color} badge-sm">${tipoServicio}</span>`;
}

function estatusServicioFormatter(v, data) {
    var estatus = (data.prestador != null) ? data.prestador.estatus_prestador : catalogoEstatus[data.work_status];
    estatus = (estatus == 'EN_CURSO') ? catalogoEstatus[data.prestador.estatus_prestador] : estatus;

    if( estatus == 'LIBERADO' ) color = 'success';
    if( estatus == 'EN CURSO' ) color = 'primary';
    if( estatus == 'BAJA') color = 'danger';
    if( estatus == 'ABANDONO') color = 'outline-danger';

    return `<span class="label label-lg label-${color} label-inline mr-2">${estatus}</span>`;
}

function descargarCartaInicioFormatter(v, data) {
    return `<a type="button"
                class="btn btn-sm btn-outline-danger btn-icon btn-descargarCartaInicio"
                data-toggle="tooltip"
                data-folio="${data.folio}"
                title="Descargar">
                <i class="fas fa-file-pdf"></i>
            </a>`
}

function descargarCartaTerminoFormatter(v, data) {
    var estatus = (data.prestador != null) ? data.prestador.estatus_prestador : catalogoEstatus[data.work_status];
    estatus = (estatus == 'EN_CURSO') ? catalogoEstatus[data.prestador.estatus_prestador] : estatus;

    if( estatus == 'LIBERADO' || estatus == 'EN CURSO' ){
        color = 'secondary';
        info = 'PENDIENTE';
    } else if( estatus == 'BAJA' ){
        color = 'info';
        info = 'SIN CARTA';
    } else if( estatus == 'ABANDONO' ){
        color = 'outline-info';
        info = 'SIN CARTA';
    }
    if( data.fecha_carta_fin == null){
        return `<span class="label label-lg label-${color} label-inline mr-2"><b>${info}</b></span>`;
    } else {
        return `<a type="button"
                    class="btn btn-sm btn-outline-danger btn-icon btn-descargarCartaTermino"
                    data-toggle="tooltip"
                    data-folio="${data.folio}"
                    title="Descargar">
                    <i class="fas fa-file-pdf"></i>
                </a>`;
    }
}
//END::Bootstrap Table
//BEGIN::Botones
// ------ Filtrar
btnFiltrar.on('click', function(e) {
    e.preventDefault();

    //botonFiltrar(true, `${btnFiltrarClass} spinner spinner-white spinner-right`, `${HTML_buttonIcon} Buscando...`);
    activarSpinner( $(this) );

    var inicio = estructurarFecha( fechaInicio.val() );
    var fin = estructurarFecha( fechaFin.val() );

    //$.post(URL_datosPrestadores, { fecha_inicio: inicio, fecha_fin: fin} )
    // .done( function(response) {
        tablaPrestadores.bootstrapTable('refreshOptions', { 
            pageNumber : 1,  
            pageSize: 10, 
            onRefreshOptions: function() {
                $.post(URL_datosPrestadores, { fecha_inicio: inicio, fecha_fin: fin });
            },
            onLoadSuccess: function() { desactivarSpinner( btnFiltrar ); }
        });
     //});
});
// ------ Descargar Carta Inicio/Aceptacion
tablaPrestadores.on('click', '.btn-descargarCartaInicio', function(e) {
    e.preventDefault();

    var folio = $(this).data('folio');
    descargarCartas(folio, 'ACEPTACION');
});
// ------ Descargar Carta Termino/Finalizacion
tablaPrestadores.on('click', '.btn-descargarCartaTermino', function(e) {
    e.preventDefault();

    var folio = $(this).data('folio');
    descargarCartas(folio, 'TERMINO');  
});
// ------ Función AJAX para la descarga de las cartas
var descargarCartas = (folio, tipo_carta) => {
    $.ajax({
        url: URL_descargarCartas,
        type: "POST",
        data: {
            folio: folio,
            tipo_carta: tipo_carta
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
            link.download = `CARTA-${tipo_carta}_${folio}.pdf`;
            link.click();

            KTApp.unblockPage();
        }
    });
}

var botonFiltrar = (disabled, atr_class, html) =>{
    btnFiltrar.attr('disabled', disabled);
    btnFiltrar.attr('class', atr_class);
    btnFiltrar.html(html);
}