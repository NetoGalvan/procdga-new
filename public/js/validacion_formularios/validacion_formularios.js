//Detecta la validación para el select
/* jQuery.validator.setDefaults({
    debug: true,
    success: "valid"
});
 */
//Función que recibe el valor capturado y evalua su estructura se correcta con Homoclave
function rfcValido(rfc, aceptarGenerico = true) {
    const re = /^([A-ZÑ&]{3,4}) ?(?:- ?)?(\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])) ?(?:- ?)?([A-Z\d]{2})([A\d])$/;
    var validado = rfc.match(re);

    if (!validado) //Coincide con el formato general
        return false;

    //Separar el dígito verificador del resto del RFC
    const digitoVerificador = validado.pop(),
        rfcSinDigito = validado.slice(1).join(''),
        len = rfcSinDigito.length,

    //Obtener el digito esperado
        diccionario = "0123456789ABCDEFGHIJKLMN&OPQRSTUVWXYZ Ñ",
        indice = len + 1;
    var suma, digitoEsperado;

    if (len == 12) suma = 0
    else suma = 481; //Ajuste para persona moral

    for(var i=0; i<len; i++)
        suma += diccionario.indexOf(rfcSinDigito.charAt(i)) * (indice - i);
        digitoEsperado = 11 - suma % 11;
        if (digitoEsperado == 11) digitoEsperado = 0;
        else if (digitoEsperado == 10) digitoEsperado = "A";

        //El dígito verificador coincide con el esperado?
        // o es un RFC Genérico (ventas a público general)?
        if ((digitoVerificador != digitoEsperado)
            && (!aceptarGenerico || rfcSinDigito + digitoVerificador != "XAXX010101000"))
            return false;
        else if (!aceptarGenerico && rfcSinDigito + digitoVerificador == "XEXX010101000")
            return false;
    return rfcSinDigito + digitoVerificador;
}

 // Funciones Personalizadas jquery validator para hacer la validación

 // Función que valida que el RFC este correcto, es ayudado por el metodo "rfcValido"
 $.validator.addMethod("RFC", function (value, element) {
    if (value !== '') {
        return rfcValido(value);
    } else {
        return false;
    }
}, "El RFC no es correcto");



// Función que valida que el CURP sea correcto
$.validator.addMethod("CURP", function (value, element) {
    var patt = new RegExp("^[A-Z][A,E,I,O,U,X][A-Z]{2}[0-9]{2}[0-1][0-9][0-3][0-9][M,H][A-Z]{2}[B,C,D,F,G,H,J,K,L,M,N,Ñ,P,Q,R,S,T,V,W,X,Y,Z]{3}[0-9,A-Z][0-9]$");
    return this.optional(element) || patt.test(value);
}, "La CURP no es correcta");

// Función que evalua que los campos de texto no acepten numeros
$.validator.addMethod("soloLetras", function(value, element) {
    return this.optional(element) || /^[a-zA-ZÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ.,\s]+$/i.test(value);
}, "No acepta números");

// Función que evalua que los campos de texto no esten vacios
$.validator.addMethod("campoNoVacio", function(value, element) {
    var length = $.trim(value).length;
    // element.val($.trim(value));
    return length > 0;
}, "No dejes espacios vacios");


// Función que evalua que los campos de tinyMCE no esten vacios
$.validator.addMethod("tinyMCE", function(value, element) {

    contenidoTinyMCE = tinyMCE.get( $(element).attr('id')).getContent({format: 'text'});
    var length = $.trim(contenidoTinyMCE).length;
    // element.val($.trim(value));
    return length > 0;
});

$.validator.addMethod("exactlength", function(value, element, param) {
    return this.optional(element) || value.length == param;
}, $.validator.format("Por favor, introducir exactamente {0} dígitos."));


