//BEGIN::Variables
const HTML_observacionesParticulares = $('.correcto-incorrecto').html();
const HTML_nota = $('.nota').html();
const HTML_btnHomework = $('.btn-homework').html();

var HTML_datosIncorrectos = `<h6><strong>DATOS INCORRECTOS</strong></h6>
                        <div>
                            <label class="titulo-dato"><span class="requeridos">* </span>Indique las correcciones que deben hacerse</label>
                            <textarea class="form-control normalizar-texto" placeholder="Correcciones..." id="correcciones" name="correcciones" rows="3"></textarea>
                        </div>`;

var HTML_btnCorreciones = `<button type="button" id="btnRegresoCorrecciones" class="btn btn-warning">
                                <i class="fas fa-times"></i>Regresar para corregir
                           </button>`;
//END::Variables
                           
var configuracion = (color, message, options, nota, btnHomework) => {
    $('.verificacion-datos').attr('class', `switch switch-${color} verificacion-datos`);
    $('.text-verificacion').text(message);

    $('.correcto-incorrecto').html(options);
    $('.nota').html(nota);
    $('.btn-homework').html(btnHomework);
}

$('.interruptorCorrectosIncorrectos').on('change', function(){
    if($(this).is(':checked')){
        configuracion('success', 'Sí, los datos son correctos', HTML_observacionesParticulares, HTML_nota, HTML_btnHomework);
    } else {
        configuracion('danger', 'No, los datos son incorrectos', HTML_datosIncorrectos, '', HTML_btnCorreciones);
    }
});