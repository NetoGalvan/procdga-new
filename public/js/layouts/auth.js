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
        } else if (element.parent().hasClass("input-rango-fecha")) {
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