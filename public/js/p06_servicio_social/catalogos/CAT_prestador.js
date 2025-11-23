// Variables
var btnAgregarPrestador = $('.prestador');
var tablaPrestadores = $('#tablaPrestadores');
var btnEditarPrestador = '#editarPrestador';
var btnEliminarPrestador = '#eliminarPrestador';

var modalPrestador = $('#modalPrestador');
var formPrestador = $('#formPrestador');
var btnFinalizarProcesoPrestador = $('.guardar-modificar-prestador');

var instituciones = $('.instituciones');
var escuelas = $('.escuelas');
var programas = $('.programas');
var entidades = $('.entidades');
var alcaldias_municipios = $('.alcaldias_municipios');

var seleccionar = { escuela: '', programa: '', municipio: '' };

//BEGIN::Bootstrap Table -> Cargar prestadores
function showPrestadores(params){
    $.post(URL_showPrestadores).done(function(response){
        params.success(response);
    });
}
// ------> Funciones Formatter
function datosFormatter(v, row){
    return `<b>CORREO:</b> ${row.email} <br>
            <b>TELÉFONO:</b> ${row.telefono}`;
};
// ---
function tipoPrestadorFormatter(v, row){
    if( row.tipo_prestador == 'SERVICIO SOCIAL' ) {
        return `<span class="badge badge-success badge-sm">${row.tipo_prestador}</span>`;
    } 
    return `<span class="badge badge-primary badge-sm">${row.tipo_prestador}</span>`;
};
// ---
function datosAcademicosFormatter(v, row){
    return `<b> INSTITUCIÓN: </b> ${ row.escuela.institucion.nombre_institucion } <br>
            <b> ESCUELA: </b> ${ row.escuela.nombre_escuela } <br> 
            <b> CARRERA: </b> ${ row.carrera } <br>
            <b> MATRÍCULA: </b> ${ row.matricula }`;
};
// ---
function domicilioFormatter(v, row) {
    return `<b> MUNICIPIO: </b> ${ row.municipio.nombre },
            <b> CIUDAD: </b> ${ row.ciudad },
            <b> COLONIA: </b> ${ row.colonia },
            <b> CALLE: </b> ${ row.calle } ,
            <b> NO. EXT.: </b> ${ row.numero_exterior },
            <b> C.P.: </b> ${ row.cp },
            <b> ENTIDAD: </b> ${ row.municipio.entidad.nombre}`;
}
// ---
function accionesFormatter(v, row) {
    return `<button class="btn btn-icon btn-sm btn-outline-primary m-2" id="editarPrestador" title="<b>EDITAR PRESTADOR</b>"
                data-prestador="${row.prestador_id}" data-toggle="modal" data-target="#modalPrestador"
            >
                <i class="fas fa-user-edit"></i>
            </button>
            <button class="btn btn-icon btn-sm btn-outline-danger m-2" id="eliminarPrestador" title="<b>ELIMINAR PRESTADOR</b>"
                data-prestador="${row.prestador_id}" 
                data-nombre-prestador="${row.nombre_prestador_completo}"
            >
                <i class="fas fa-user-times"></i>
            </button> `;
}
// <------
//END::Bootstrap Table -> Cargar prestadores

//BEGIN::Botones
// ------> Abrir modal para agregar prestador
btnAgregarPrestador.click(function () {
    btnFinalizarProcesoPrestador.data('prestador', 0);
    modalPrestador.find('.card-label').html(`Agregar prestador ${spanTitulo}`);
});
// ------> Abrir modal para editar prestador
tablaPrestadores.on('click', btnEditarPrestador, function(e) {
    e.preventDefault();

    var prestador_id = $(this).data('prestador');
    modalPrestador.find('.card-label').html(`Editar prestador ${spanTitulo}`);

    bloquearModal();
    $.post(`${URL_datosPrestador}/${prestador_id}`)
     .done( function (response) {
        var prestador = response.prestador

        instituciones.val(prestador.escuela.institucion_id).trigger('change');
        entidades.val(prestador.municipio.entidad_federativa_id).trigger('change');
        $('.tipo-prestador').val(prestador.tipo_prestador).trigger('change');

        $('.nombre-func').val(prestador.nombre_funcionario);
        $('.puesto-func').val(prestador.puesto_funcionario);
        $('.telefono-func').val(prestador.telefono_funcionario);
        $('.carrera').val(prestador.carrera);
        $('.matricula').val(prestador.matricula);
        
        $('.nombre-prestador').val(prestador.nombre_prestador);
        $('.primer-ape').val(prestador.primer_apellido);
        $('.segundo-ape').val(prestador.segundo_apellido);
        $('.telefono').val(prestador.telefono);
        $('.correo').val(prestador.email);
        
        var horario = prestador.horario_tentativo;
        var horas = horario.split(" - ");
        $('.hr-entrada').timepicker('setTime', horas[0]);
        $('.hr-salida').timepicker('setTime', horas[1]);
        $('.total-hrs').val(prestador.total_horas);
       
        $('.observaciones').text(prestador.observaciones);

        $('.cp').val(prestador.cp);
        $('.ciudad').val(prestador.ciudad);
        $('.colonia').val(prestador.colonia);
        $('.calle').val(prestador.calle);
        $('.no-ext').val(prestador.numero_exterior);
        $('.no-int').val(prestador.numero_interior);

        seleccionar.escuela = prestador.escuela_id;
        seleccionar.programa = prestador.programa_id;
        seleccionar.municipio = prestador.municipio_id;

        btnFinalizarProcesoPrestador.data('prestador', prestador_id);
        desbloquearModal(1500);
     });
     
});
// ------> Eliminar prestador
tablaPrestadores.on('click', btnEliminarPrestador, function(e) {
    e.preventDefault();

    var prestador_id = $(this).data('prestador');
    var nombrePrestador = $(this).data('nombrePrestador');
    
    alert_warning_secondary(`Eliminara al prestador <br> <b>${nombrePrestador}</b>`, 
    function(result) {
        if ( result.value ) {
            $.post(`${URL_eliminarPrestador}/${prestador_id}`)
             .done( function (response) {
                if ( response.estatus ) 
                    {
                    tablaPrestadores.bootstrapTable("load", response.prestadores); //Actualizar tabla
                    alert_success('El prestador se elimino correctamente.', null);
                } else {
                    alert_error(response.mensaje, null);
                }
             });
        }
    });
});
//END::Botones

//BEGIN::Modal
btnFinalizarProcesoPrestador.on('click', function(e) {
    e.preventDefault();
    var dataPrestador = '/' + $(this).data('prestador');
    
    if ( formPrestador.valid() ) {
        alert_warning_secondary('Verifique que la información sea correcta', 
        function(result) {
            if ( result.value ) 
            {
                $.post(URL_prestador+dataPrestador, formPrestador.serialize())
                 .done( function(response) {
                    if ( response.estatus ) 
                    {
                        tablaPrestadores.bootstrapTable('refreshOptions', { pageNumber : 1, pageSize: 5 });
                        $('#modalPrestador').modal('hide');
                        alert_success(response.mensaje, null);
                    } else {
                        alert_error(response.mensaje, null);
                    }
                 });
            }
        }); 
    }
});
// ------> Configuración inicial
//$('.modal-header').css('padding', '1rem 1.75rem 0');

$('.instituciones, .entidades, .alcaldias_municipios, .escuelas').select2({placeholder: 'seleccione una opción'});
$('.hr-entrada, .hr-salida').css('cursor', 'pointer');
$('.hr-entrada, .hr-salida').timepicker({defaultTime: '12:00'});
$(".telefono-func, .telefono, .no-ext, .no-int").inputmask({ "mask": "9", "repeat": 10 });
$(".total-hrs, .cp").inputmask({ "mask": "9", "repeat": 5 });

//
// ------> Configurar Selects
eventoChange(instituciones, URL_getEscuelasProgramas, $('.escuelas, .programas'), true);
eventoChange(entidades, URL_getAlcaldiasMunicipios, $('.alcaldias_municipios'), false);

function eventoChange(selectPrincipal, URL_getDatos, selectSecundario, instituciones) {
    selectPrincipal.change( function(e) {
        var opcionSeleccionada = $(this).val();

        if(opcionSeleccionada !== null){
            agregarPrimeraOpcion(selectSecundario, 'BUSCANDO ...');
            var data = ( instituciones ) ? {institucion_id: opcionSeleccionada} : {entidad_id: opcionSeleccionada};

            $.get(URL_getDatos, data).done( function(resp) {
                agregarPrimeraOpcion(selectSecundario, 'SELECCIONE UNA OPCIÓN');

                if( instituciones ) {
                    resp.programas.forEach((prog) => programas.append(`<option value="${prog.programa_id}">${prog.nombre_programa}</option>`));
                    resp.escuelas.forEach((esc) => escuelas.append(`<option value="${esc.escuela_id}"><b>${esc.acronimo_escuela} |</b> ${esc.nombre_escuela}</option>`));
                
                    escuelas.val( seleccionar.escuela ).trigger('change');
                    programas.val( seleccionar.programa ).trigger('change');
                } else {
                    resp.municipios.forEach((munp) => alcaldias_municipios.append(`<option value="${munp.municipio_id}">${munp.nombre}</option>`));
                    alcaldias_municipios.val( seleccionar.municipio ).trigger('change');
                }
             });
        } else {
            agregarPrimeraOpcion(selectSecundario, 'SELECCIONE UNA OPCIÓN');
        }
    });
}
var agregarPrimeraOpcion = (select, primera_opt) => {
    select.find('option').remove();
    select.append(`<option value="" selected disabled> ${primera_opt} </option>`);
}
// <------
//END::Modal

// ------> Validación
formPrestador.validate({
    onfocusout: false,
    rules: {
        institucion_id: 'required',
        escuela_id: 'required',
        nombre_funcionario: 'campoNoVacio',
        puesto_funcionario: 'campoNoVacio',
        telefono_funcionario: 'campoNoVacio',
        carrera: 'campoNoVacio',
        matricula: 'campoNoVacio',
        tipo_prestador: 'required',
        nombre: 'campoNoVacio',
        apePaterno: 'campoNoVacio',
        apeMaterno: 'campoNoVacio',
        cp: 'campoNoVacio',
        entidad_id: 'required',
        colonia: 'campoNoVacio',
        ciudad: 'campoNoVacio',
        municipio_id: 'required',
        correo: 'campoNoVacio',
        total_horas: 'required',
        hora_entrada: 'required',
        hora_salida: 'required',
        telefono: 'required',
        calle: 'required',
        exterior: 'required'
    },
    messages: {
        institucion_id: 'Campo obligatorio',
        escuela_id: 'Campo obligatorio',
        nombre_funcionario: 'Campo obligatorio',
        puesto_funcionario: 'Campo obligatorio',
        telefono_funcionario: 'Campo obligatorio',
        carrera: 'Campo obligatorio',
        matricula: 'Campo obligatorio',
        tipo_prestador: 'Campo obligatorio',
        nombre: 'Campo obligatorio',
        apePaterno: 'Campo obligatorio',
        apeMaterno: 'Campo obligatorio',
        cp: 'Campo obligatorio',
        entidad_id: 'Campo obligatorio',
        colonia: 'Campo obligatorio',
        ciudad: 'Campo obligatorio',
        municipio_id: 'Campo obligatorio',
        correo: 'Campo obligatorio',
        total_horas: 'Campo obligatorio',
        hora_entrada: 'Campo obligatorio',
        hora_salida: 'Campo obligatorio',
        telefono: 'Campo obligatorio',
        calle: 'Campo obligatorio',
        exterior: 'Campo obligatorio'
    }
});
// <------
// ------> Tooltip
tooltip( tablaPrestadores, btnEditarPrestador );
tooltip( tablaPrestadores, btnEliminarPrestador );
// ------> Restablecer modal 
modalPrestador.on('hidden.bs.modal', function () {
    restablecer_formulario( formPrestador );
    restablecer_card();

    instituciones.val('').trigger('change'); // Restablecer selects principales
    entidades.val('').trigger('change');
    $('.observaciones').text('');
    $('.hr-entrada, .hr-salida').timepicker('setTime', '12:00');
    seleccionar = { escuela: '', programa: '', municipio: '' };

}).modal('hide');