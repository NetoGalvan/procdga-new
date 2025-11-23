var nombreEmpleado = $('#nombre-empleado');
var numeroExpediente = $('#numero-expediente');
var tablaExpedientes = $('#tabla-expedientes');

var date = new Date();
var dia = (date.getDate() < 10) ? `0${date.getDate()}` : date.getDate();
var mes = ((date.getMonth()+1) < 10) ? `0${date.getMonth()+1}` : date.getMonth()+1;
var anio = date.getFullYear();

function mostrarDatosExpedientes(params) {
    $.post(URL_buscarExpedientes, { 
        nombre_empleado: nombreEmpleado.val(),
        numero_expediente: numeroExpediente.val()

    })
    .done(function(response){  params.success(response); });
}

function descargarReporteFormatter(v, data) {
    return `<a type="button"
                class="btn btn-sm btn-outline-danger btn-icon descargar-reporte"
                data-numero-expediente="${data.numero_expediente}"
                data-html="true"
                title="<b>Descargar</b>">
                <i class="fas fa-file-pdf"></i>
            </a>`
}

$('#btn-filtrar').click( function(e) {
    e.preventDefault(e);

    tablaExpedientes.bootstrapTable('refreshOptions', { 
        pageNumber : 1,  
        pageSize: 10,
        onRefreshOptions: function() { $('#btn-filtrar-spinner, #btn-filtrar').toggleClass('d-none'); },
        onLoadSuccess: function() { $('#btn-filtrar-spinner, #btn-filtrar').toggleClass('d-none'); }
    });
});

$('#btn-limpiar').click( function(e) {
    e.preventDefault(e);
    $('#formBuscar').trigger("reset");

    tablaExpedientes.bootstrapTable('refreshOptions', { 
        pageNumber : 1,  
        pageSize: 10,
        onRefreshOptions: function() { $('#btn-limpiar-spinner, #btn-limpiar').toggleClass('d-none'); },
        onLoadSuccess: function() { $('#btn-limpiar-spinner, #btn-limpiar').toggleClass('d-none'); }
    });
});

tablaExpedientes.on('mouseover', (e) => { $('.descargar-reporte').tooltip() });
tablaExpedientes.on('click', '.descargar-reporte', function(e) {
    var dataNumeroExpediente = `/${ $(this).data('numeroExpediente') }`;

    $.ajax({
        url: URL_descargarReporte+dataNumeroExpediente,
        type: "POST",
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
            link.download = `Reporte_detalle_expediente-${dataNumeroExpediente}-${dia}_${mes}_${anio}.pdf`;
            link.click();

            KTApp.unblockPage();
        }
    });
});