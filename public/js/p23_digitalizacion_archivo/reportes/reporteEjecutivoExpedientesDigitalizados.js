var tablaExpedientes = $('#tabla-expedientes');

$('.inputmk-fecha').inputmask({mask: '##/##/####'});
$('.date-picker').datepicker({
    rtl: KTUtil.isRTL(),
    todayHighlight: true,
    format: 'dd/mm/yyyy',
    language: 'es',
    autoclose: true,
    orientation: 'bottom'
});

var date = new Date();
var dia = (date.getDate() < 10) ? `0${date.getDate()}` : date.getDate();
var mes = ((date.getMonth()+1) < 10) ? `0${date.getMonth()+1}` : date.getMonth()+1;
var anio = date.getFullYear();

$('.fecha-inicio').val(`01/01/${ anio }`);
$('.fecha-fin').val(`31/12/${ anio }`);

function mostrarDatosExpedientes(params) {
    $.post(URL_buscarExpedientes, { 
        fecha_inicio: $('.fecha-inicio').val(),
        fecha_fin: $('.fecha-fin').val()

    }).done(function(response){  params.success(response); });
}

function createdAtFormatter(v, data) {
    var fechaCreacion = new Date(data.created_at);

    var mes = {
        1: 'ENERO',
        2: 'FEBRERO',
        3: 'MARZO',
        4: 'ABRIL',
        5: 'MAYO',
        6: 'JUNIO',
        7: 'JULIO',
        8: 'AGOSTO',
        9: 'SEPTIEMBRE',
        10: 'OCTUBRE',
        11: 'NOVIEMBRE',
        12: 'DICIEMBRE'
    }

    return `${fechaCreacion.getDate()} DE ${mes[date.getMonth()+1]} DEL ${fechaCreacion.getFullYear()}`;
}

$('#btn-filtrar').click( function(e) {
    e.preventDefault(e);

    if( $('.fecha-inicio').val() != '' && $('.fecha-fin').val() != '' ) { 
        tablaExpedientes.bootstrapTable('refreshOptions', { 
            pageNumber : 1,  
            pageSize: 10,
            onRefreshOptions: function() { $('#btn-filtrar-spinner, #btn-filtrar').toggleClass('d-none'); },
            onLoadSuccess: function() { $('#btn-filtrar-spinner, #btn-filtrar').toggleClass('d-none'); }
        });

    } else { alert_warning_simple('Ingresar el rango de fechas', null); }
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

$('#btn-descargar-reporte').click( function(e) {
    if( $('.fecha-inicio').val() != '' && $('.fecha-fin').val() != '' ) {
        $.ajax({
            url: URL_descargarReporte,
            type: "POST",
            data: { 
                fecha_inicio: $('.fecha-inicio').val(),
                fecha_fin: $('.fecha-fin').val()
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
                link.download = `Reporte_ejecutivo_digitalizacion_archivo-${ $('.fecha-inicio').val() }_${ $('.fecha-fin').val()}.pdf`;
                link.click();

                KTApp.unblockPage();
            }
        });

    } else { alert_warning_simple('Ingresar el rango de fechas', null); }
});