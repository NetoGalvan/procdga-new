//Variables
var fechaInicio = $('.fecha-inicio');
var fechaFin = $('.fecha-fin');
var tabla_datosPrestador = $('#datosPrestador');

var btnFiltrar = $('#btn_filtrar');

var color;
//BEGIN::Configuraciones
// ----- Fecha
var estructurarFecha = (fecha) => {
    var fechaPartes = fecha.split("/");
    return `${fechaPartes[2]}-${fechaPartes[1]}-${fechaPartes[0]}`;
}
//END::Configuraciones
//BEGIN::Bootstrap Table
function tablaDatosPrestador(params) {
    var inicio = estructurarFecha( fechaInicio.val() );
    var fin = estructurarFecha( fechaFin.val() );
    
    $.post(URL_datosPersonalesPrestador, { fecha_inicio: inicio, fecha_fin: fin} )
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
    if( tipoServicio == 'PRÁCTICAS PROFESIONALES' || tipoServicio == 'PRACTICAS PROFESIONALES') color = 'secondary';
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

function descargarReporteFormatter(v, data) {
    return `<a type="button"
                class="btn btn-sm btn-outline-danger btn-icon btn-descargarReporte"
                data-folio="${data.folio}"
                title="Descargar reporte">
                <i class="fas fa-file-pdf"></i>
            </a>`
}
//END::Bootstrap Table
//Boton Buscar
btnFiltrar.on('click', function(e) {
    e.preventDefault();

    activarSpinner( $(this) );

    var inicio = estructurarFecha( fechaInicio.val() );
    var fin = estructurarFecha( fechaFin.val() );

        tabla_datosPrestador.bootstrapTable('refreshOptions', {
            pageNumber : 1,  
            pageSize: 10, 
            onRefreshOptions: function() {
                $.post(URL_datosPersonalesPrestador, { fecha_inicio: inicio, fecha_fin: fin });
            },
            onLoadSuccess: function() { desactivarSpinner( btnFiltrar ); }
        
     });
});

tabla_datosPrestador.on('click', '.btn-descargarReporte', function(e) {
    e.preventDefault();

    var folio = $(this).data('folio');

    $.ajax({
        url: URL_reportePrestadorPDF+'/'+folio,
        type: "GET",
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
            link.download = 'Reporte-Datos-Personales-'+folio+'.pdf';
            link.click();

            KTApp.unblockPage();
        }
    });
});