var spanTitulo = '&nbsp;&nbsp;&nbsp;&nbsp; <span class="requeridos">* Campos obligatorios</span>';

function tooltip(tabla, btnAccion) {
    tabla.on('mouseover', btnAccion, function(e) {
        $(this).tooltip({ html: true, trigger:'hover' }).tooltip('show');
    });
}

function restablecer_formulario( form ){
    document.getElementById( form.attr('id') ).reset(); // restablecer campos
    form.validate().resetForm(); // restablecer validación

    $.each(form.find('.is-invalid'), function(x, i) { // Limpiar validaciones ( mensajes - class )
        if($(this).attr('name') != undefined) $(`#${ $(this).attr('name') }-error`).remove();
        $(this).attr('class', $(this).attr('class').replace(" is-invalid", "") );
    });

    $.each(form.find('.is-valid'), function(x, i) {
        $(this).attr('class', $(this).attr('class').replace(" is-valid", "") );
    });
}

// BEGIN::BLOQUEAR - DESBLOQUEAR MODAL
//Variables 
var modalContent = $('.content');
var modalBody = $('.body');
var bloquearSpinner = $('.bloquear-spinner');

const classModalContent = modalContent.attr('class'); // overlay overlay-block
const classModalBody = modalBody.attr('class'); // overlay-wrapper
const spinner = `<div class="overlay-layer bg-dark-o-50">
                    <div class="spinner spinner-primary"><div class="ml-10"><b>Espere un momento</b></div></div>
                </div>`;

// --> Bloquear modal
function bloquearModal( ) {
    modalContent.attr('class', classModalContent+' overlay overlay-block');
    modalBody.attr('class', classModalBody+' overlay-wrapper');
    bloquearSpinner.html( spinner );
}

// --> Desbloquear modal
function desbloquearModal( time ) {
    setTimeout(function(){
        modalContent.attr('class', classModalContent);
        modalBody.attr('class', classModalBody);
        bloquearSpinner.html('');
    }, time);
}
// END::BLOQUEAR - DESBLOQUEAR MODAL

// -- MANIPULACION DE CARD ( MODAL PRESTADORES ) -->
// Variables
var activo_class = 'nav-link';
var mostrar_class = 'tab-pane fade';
var btnSiguiente = $('.siguiente');
var btnAtras = $('.atras');

$.each($('a.disabled'), function(i, v) {
    $(this).css({'pointer-events':'none', 'cursor':'not-allowed'});
});

btnSiguiente.click(function(e) {
    var activo = $('.nav-item').find('.active');
    var mostrar = $('.tab-content').find('.show');

    if ( formPrestador.valid() ) {
        activo.attr('class', activo_class);
        mostrar.attr('class', mostrar_class);
        $('.atras').attr('hidden', false);

        if (activo.attr('href') == '#datos_escolares') cambiarClassActivo('#prestacion');
        if (activo.attr('href') == '#prestacion') {
            cambiarClassActivo('#datos_prestador');
            $(this).attr('hidden', true);
            $('.guardar-modificar-prestador').attr('hidden', false);
        }
    }
});

btnAtras.click(function(e) {
    var activo = $('.nav-item').find('.active');
    var mostrar = $('.tab-content').find('.show');

    activo.attr('class', activo_class);
    mostrar.attr('class', mostrar_class);
    $('.siguiente').attr('hidden', false);

    if (activo.attr('href') == '#datos_prestador') {
        cambiarClassActivo('#prestacion');
        $('.guardar-modificar-prestador').attr('hidden', true);
    }

    if (activo.attr('href') == '#prestacion') {
        cambiarClassActivo('#datos_escolares');
        $('.atras').attr('hidden', true);
    }    
});
function cambiarClassActivo(id) {
    var activar = $('.nav-item').find(`[href="${id}"]`);
    var contenido = $('.tab-content').find( id );

    activar.attr('class', `${ activar.attr('class') } active`);
    contenido.attr('class', `${ contenido.attr('class') } active show`);
}

function restablecer_card() {
    var activo = $('.nav-item').find('.active');
    var mostrar = $('.tab-content').find('.show');
    activo.attr('class', activo_class);
    mostrar.attr('class', mostrar_class);
    cambiarClassActivo('#datos_escolares');

    $('.siguiente').attr('hidden', false);
    $('.atras').attr('hidden', true);
    $('.guardar-modificar-prestador').attr('hidden', true);
}
// -- MANIPULACION DE CARD ( MODAL PRESTADORES ) <--
//