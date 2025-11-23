
$(document).ready(function() {
    llenarTablaSeleccionCandidatos(datos1);
    $("label").addClass("titulo-dato");
});

function llenarTablaSeleccionCandidatos(data) {
    $("#tablaCandidatosSeleccionadosFechaCitas").bootstrapTable({
        data: data,
        pagination: true,
        sortable: true,

        pageList: [5, 10, 25, 50]

    });
}

function guardarDatosTablas() {
    var tablas = $($("#tablaCandidatosSeleccionadosFechaCitas").find('tbody')).find('tr');
    var arreglosCandidatos = [];

    var encontrados;
    var datosColumnas = $("#tablaCandidatosSeleccionadosFechaCitas").bootstrapTable('getData');
    correctos = true;
    for (var i = 0; i < tablas.length; i++) {
        var candidatos = new Object()

        candidatos.candidato_id = datosColumnas[i].candidato_id;
        candidatos.fhEval = $($($(tablas[i]).find('td')['4']).find('input')[0]).val();
        candidatos.horaEval = $($($(tablas[i]).find('td')['5']).find('input')[0]).val();
        candidatos.lugarEval = $($($(tablas[i]).find('td')['6']).find('input')[0]).val();

        arreglosCandidatos.push(candidatos);

    }



    $("#arregloTablaCandidatosSeleccionados").val(JSON.stringify(arreglosCandidatos));


}

function enviar(e) {
    e.preventDefault();
    return false;
}

function validacionSecretarios(value, row) {


    return '<input class="form-control form-control-sm" type="date" required>';
}

function horaEvaluacion(value, row) {


    return '<input class="form-control form-control-sm" type="time" id="nombre" required>';
}

function lugarEvaluacion(value, row) {


    return '<input class="form-control form-control-sm" type="text" value="CGEMDA" required  disabled>';
}

function nombreCandidatos(value, row) {



    return '<b><h6>' + row.nombre_candidato + ' ' + row.apellido_paterno_candidato + ' ' + row.apellido_materno_candidato + '</h6></b>' +
        '<h9 class="colorLetras"> RFC : ' + row.rfc + '</h9>';
}
