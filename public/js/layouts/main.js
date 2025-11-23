// PETICIONES AJAX
$.ajaxSetup({
    headers : {
        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
    }
});

// DEFAULT JQUERY VALIDATE
$.validator.setDefaults({
    onfocusout: false,
    validClass: "is-valid",
    errorClass: "is-invalid",
    errorPlacement: function(label, element) {
        if (element.hasClass("select2")) {
            element.parent().append(label);
        } else if (element.closest(".checkbox-inline").length) {
            element.closest(".checkbox-inline").after(label);
        } else if (element.parent().hasClass("input-rango-fecha")) {
            if (!element.parent().next().hasClass("is-invalid")) {
                element.parent().after(label);
            }
        } else if (element.parent().hasClass("input-date-range-current")) {
            if (!element.parent().next().hasClass("is-invalid")) {
                element.parent().after(label);
            }
        } else if (element.parent().parent().hasClass("switch")) {
            element.parent().parent().parent().parent().parent().append(label);
        } else {
            label.insertAfter(element);
        }
    },
    highlight: function(element, errorClass, validClass) {
        if ($(element).hasClass("select2")) {
            $(element).next().find(".select2-selection.select2-selection--single").addClass(errorClass).removeClass(validClass);
        } else {
            $(element).addClass(errorClass).removeClass(validClass);
        }
    },
    unhighlight: function(element, errorClass, validClass) {
        if ($(element).hasClass("select2")) {
            if (validClass.length == 0) {
                $(element).next().find(".select2-selection.select2-selection--single").removeClass("is-valid is-invalid");
            } else {
                $(element).next().find(".select2-selection.select2-selection--single").addClass(validClass).removeClass(errorClass);
            }
        } else {
            if (validClass.length == 0) {
                $(element).removeClass("is-valid").removeClass(errorClass);
            } else {
                $(element).addClass(validClass).removeClass(errorClass);
            }
        }
    },
});

// DATEPICKER Y DATETIMEPICKER
(function ($) {
    $.fn.datepicker.dates['es'] = {
        days: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"],
        daysShort: ["Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb"],
        daysMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
        months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
        monthsShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
        today: "Hoy",
        monthsTitle: "Meses",
        clear: "Borrar",
        weekStart: 1,
        format: "dd/mm/yyyy"
    };
}(jQuery));

(function ($) {
    $.fn.datetimepicker.dates['es'] = {
        days: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo"],
        daysShort: ["Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb", "Dom"],
        daysMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa", "Do"],
        months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
        monthsShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
        today: "Hoy",
        suffix: [],
        meridiem: []
    };
}(jQuery));

$('.input-datetime').datetimepicker({
    language: 'es',
    autoclose : true
}).on("change", function() {
    $(this).trigger("keyup");
});

$('.input-time').timepicker({
    autoclose : true,
    defaultTime: '',
    showMeridian: false,
    minuteStep: 1,
}).on("change", function() {
    $(this).trigger("keyup");
});

$('.input-time-seconds').timepicker({
    autoclose : true,
    defaultTime: '',
    showMeridian: false,
    showSeconds: true,
    minuteStep: 1,
}).on("change", function() {
    $(this).trigger("keyup");
});

$('.input-date').datepicker({
    todayHighlight: true,
    language: 'es',
    format: 'dd-mm-yyyy',
    autoclose : true,
}).on("change", function() {
    $(this).trigger("keyup");
});

$('.input-date-bottom').datepicker({
    todayHighlight: true,
    language: 'es',
    format: 'dd-mm-yyyy',
    orientation: "bottom",
    autoclose : true,
}).on("change", function() {
    $(this).trigger("keyup");
});

$('.input-date-current').datepicker({
    todayHighlight: true,
    language: 'es',
    format: 'dd-mm-yyyy',
    autoclose : true,
    startDate: moment().format("DD-MM-Y"),
}).on("change", function() {
    $(this).trigger("keyup");
});

$('.input-date-current-bottom').datepicker({
    todayHighlight: true,
    language: 'es',
    format: 'dd-mm-yyyy',
    orientation: "bottom",
    autoclose : true,
    startDate: moment().format("DD-MM-Y"),
}).on("change", function() {
    $(this).trigger("keyup");
});

$(".input-year").datepicker({
    format: "yyyy",
    viewMode: "years",
    minViewMode: "years",
    autoclose : true,
}).on("change", function() {
    $(this).trigger("keyup");
});

$(".input-year-current").datepicker({
    format: "yyyy",
    viewMode: "years",
    minViewMode: "years",
    startDate: new Date().getFullYear().toString(),
    autoclose : true,
    orientation: "bottom",
}).on("change", function() {
    $(this).trigger("keyup");
});

$('.input-rango-fecha').datepicker({
    rtl: KTUtil.isRTL(),
    todayHighlight: true,
    format: "dd-mm-yyyy",
    autoclose: true,
    language: "es",
    showOnFocus: true,
    orientation: "bottom left",
}).on("change", function() {
    $(this).find("input").trigger("keyup");
});

$('.input-date-range-current').datepicker({
    rtl: KTUtil.isRTL(),
    todayHighlight: true,
    format: "dd-mm-yyyy",
    autoclose: true,
    language: "es",
    showOnFocus: true,
    orientation: "bottom left",
    endDate: new Date(new Date().setDate(new Date().getDate() - 1)) // Establece la fecha máxima a hoy menos un día
}).on("change", function() {
    $(this).find("input").trigger("keyup");
});


// SELECT2
$(".select2").on('select2:select', function () {
    $(this).trigger("click");
});
$.fn.select2.defaults.set('language', {
	/* inputTooLong: function (args) {
		return "INPUT_TOO_LONG";
	},*/
    maximumSelected: function (args) {
		return "Solo puede seleccionar un elemento";
	},
    errorLoading: function () {
		return "Error al cargar";
	},
	inputTooShort: function (args) {
		return `Por favor escriba ${args.minimum} caracteres`;
	},
	loadingMore: function () {
		return "Cargando más";
	},
	noResults: function () {
		return "No hay resultado";
	},
	searching: function () {
		return "Buscando...";
	}
});

// HABILITAR Y DESHABILITAR BOTON
(function($) {
    $.fn.deshabilitarBtn = function() {
        $(this).addClass("spinner spinner-white spinner-right").prop('disabled', true);
    };
    $.fn.habilitarBtn = function() {
        $(this).removeClass("spinner spinner-white spinner-right").prop('disabled', false);
    };
}(jQuery));

// NORMALIZAR TEXTO
$(".normalizar-texto").keyup(function (e) {
    this.value = this.value.toUpperCase();
});

// REEMPLAZAR ACENTOS
var reemplazarAcentos = function(cadena) {
    var chars={
        "á":"a", "é":"e", "í":"i", "ó":"o", "ú":"u",
        "à":"a", "è":"e", "ì":"i", "ò":"o", "ù":"u", "ñ":"n",
        "Á":"A", "É":"E", "Í":"I", "Ó":"O", "Ú":"U",
        "À":"A", "È":"E", "Ì":"I", "Ò":"O", "Ù":"U", "Ñ":"N"}
    var expr=/[áàéèíìóòúùñ]/ig;
    var res=cadena.replace(expr,function(e){return chars[e]});
    return res;
}

// DESCARGAR ARACHIVOS CREADOS CON JS
function downloadFileBase64(file, nameFile) {
    let url = "data:application/pdf;base64," + file;
    let link = document.createElement('a');
    link.href = url;
    link.download = nameFile;
    link.click();
}

// LLENAR FORMULARIO CON UN JSON
function populate(form, data) {
    $.each(data, function(key, value){
        form.find(`[name="${key}"]`).val(value);
    });
}

// DROPZONE
Dropzone.autoDiscover = false;
Dropzone.prototype.defaultOptions.dictCancelUpload = "Cancelar carga";
Dropzone.prototype.defaultOptions.dictRemoveFile = "Eliminar archivo";
Dropzone.prototype.defaultOptions.dictFileTooBig = "El archivo es demasiado grande ({{filesize}}MB). El Tamaño máximo de archivo es de: {{maxFilesize}}MB.";
Dropzone.prototype.defaultOptions.dictMaxFilesExceeded = "Has revasado el límite de archivos permitidos.";
Dropzone.prototype.defaultOptions.dictInvalidFileType = "No se permite este tipo de archivo.";

// VIEW PDF's
$(document).on("click", ".btn-view-pdf", function(e) {
    e.preventDefault();
    $("#iframe_view_pdf").attr("src", $(this).attr("href"));
    $("#modal_view_pdf").modal("show");
});
$('#modal_view_pdf').on('hidden.bs.modal', function (event) {
    $("#iframe_view_pdf").attr("src", "");
})

// ELIMINAR DOCUMENTO
$(document).on("click", ".btn-eliminar-documento", function (e) {
    e.preventDefault();
    swal.fire({
        title: "¿Está seguro?",
        text: "Esta acción no podrá ser revertida",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: "POST",
                url: $(this).attr("href"),
                async: false,
                data: {
                    "_method": "delete"
                },
                success: (resp) => {
                    if (resp.estatus) {
                        $(this).closest("table").bootstrapTable('removeByUniqueId', resp.documento_id);
                        swal.fire("¡Se ha eliminado el documento con éxito!", "", "success");
                    }
                }
            });
        }
    });
});

$('.date-general').datepicker({
    format : 'dd/mm/yyyy',
    autoclose : true,
    language : 'es',
    ignoreReadonly : true,
    startDate: '0',
    daysOfWeekDisabled: [0,6],
    datesDisabled: ['01/01/2019','04/02/2019','18/03/2019','01/05/2019','16/09/2019', '01/11/2019', '18/11/2019', '25/12/2019']
});

$('.date-general').datepicker()
    .on('changeDate', function(e) {
        $(this).removeClass("error");
        $(this).addClass("valid");
        $(this).next().text("");
});

$('.date-general-anterior').datepicker({
    format : 'dd/mm/yyyy',
    autoclose : true,
    language : 'es',
    ignoreReadonly : true,
    daysOfWeekDisabled: [],
    datesDisabled: ['01/01/2019','04/02/2019','18/03/2019','01/05/2019','16/09/2019', '01/11/2019', '18/11/2019', '25/12/2019']
});

$('.date-general-anterior').datepicker()
    .on('changeDate', function(e) {
        $(this).removeClass("error");
        $(this).addClass("valid");
        $(this).next().text("");
});

$('.date-general-weekend').datepicker({
    format : 'dd/mm/yyyy',
    autoclose : true,
    language : 'es',
    startDate: '0',
    ignoreReadonly : true,
    datesDisabled: ['01/01/2019','04/02/2019','18/03/2019','01/05/2019','16/09/2019', '01/11/2019', '18/11/2019', '25/12/2019']
});

$('.date-general-weekend').datepicker()
    .on('changeDate', function(e) {
        $(this).removeClass("error");
        $(this).addClass("valid");
        $(this).next().text("");
});

// BLOQUEAR RETROCESO EN PÁGINAS
function blockBack() {
    // Bloquear botón de regresar página
    history.pushState(null, null, location.href);
    window.onpopstate = function () {
        history.go(1);
    }
    // Si se lograra regresar página, recargar
    window.addEventListener("pageshow", function ( event ) {
        var historyTraversal = event.persisted || (typeof window.performance != "undefined" && window.performance.navigation.type === 2 );
        if (historyTraversal) {
            window.location.reload();
        }
    });
}

// ASIDE MENÚ
$("#kt_aside_toggle").click(() => {
    asideMinimize = !asideMinimize;
    $.post($("#kt_aside_toggle").data("url"), {"asideMinimize": asideMinimize}, function(resp) {});
});

// NOTIFICACIONES
$.get(rutaTotalNotificaciones, function (resp) {
    if (resp.total != 0) {
        $("#total_notificaciones").addClass("label label-md label-rounded label-danger ml-4").html(resp.total);
    }
});

// ARRAY MESES
var meses = [
    "ENERO", 
    "FEBRERO", 
    "MARZO", 
    "ABRIL", 
    "MAYO", 
    "JUNIO", 
    "JULIO", 
    "AGOSTO", 
    "SEPTIEMBRE", 
    "OCTUBRE", 
    "NOVIEMBRE", 
    "DICIEMBRE"
];;