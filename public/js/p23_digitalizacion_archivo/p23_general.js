//BEGIN::INPUTS

//begin --> number: solo aceptar numeros
$('.number').on('input', function(e) {
    var regex = new RegExp("^[0-9]+$");
    var resultado = $(this).val();

    if ( !regex.test($(this).val()) ) resultado = resultado.substring(0, resultado.length - 1);
    $(this).val(resultado);
});
$('.number').on('paste', function(e) { return false; });
//end <-- number: solo aceptar numeros

//END::INPUTS

//BEGIN::NOTAS
var notas = $('[name="notas"]');
var agragarNota = $('#agregarNota');
var tablaNotas = $("#tabla_notas");
//var dataNotas = []; 

var f = new Date();
var dia = (f.getDate() < 10) ? `0${f.getDate()}` : f.getDate();
var mes = ((f.getMonth()+1) < 10) ? `0${f.getMonth()+1}` : (f.getMonth()+1);

agragarNota.click( function(e) {
    e.preventDefault();

    if(notas.val().trim() != '') {
        
        var existe = false;
        $.each(dataNotas, function(x, item) { if ( item.nota == notas.val() ) existe = true; });

        if( !existe ) {
            dataNotas.push({
                'nota': notas.val(),
                'fecha': (`${dia}-${mes}-${f.getFullYear()}`),
                'accion': `<button id="eliminar_nota" class="btn btn-outline-danger btn-sm" data-nota="${notas.val()}"> <i class="fas fa-trash-alt"></i> </button>`
            });
        }
        tablaNotas.bootstrapTable('load', dataNotas);
        notas.val('');
    }
});

tablaNotas.on('click', '#eliminar_nota', function(e) {
    e.preventDefault();

    var dataNota = $(this).data('nota');
    var a = '';

    $.each(dataNotas, function(x, item) { if ( item.nota == dataNota ) a = x; });

    dataNotas.splice(a, 1);
    tablaNotas.bootstrapTable('load', dataNotas);
});

var datosNotasActualizado = () => {
	var datos = [];
    $.each(dataNotas, function(x, item) { 
    	datos.push({nota: item.nota, fecha: item.fecha}) 
    });
    return datos;
}
//END::NOTAS