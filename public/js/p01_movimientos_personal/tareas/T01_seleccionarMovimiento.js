const formSeleccionMovimiento = $('#id_form_seleccion_movimiento');
const selectTipoMovimiento = $('#tipo_movimiento_id');
const radiosTipoPlaza = $("[name=tipo_plaza]");
const inputFolioAprobacion = $('#folio_aprobacion');
const contenedorFolioAprobacion = $('#contenedor_folio_aprobacion');
const contenedorSearchEmpleado = $('#contenedor_search_empleado');
const contenedorDatosEmpleado = $('#contenedor_datos_empleado');

selectTipoMovimiento.select2({
    placeholder: "Selecciona una opción"
});

validadorFormSeleccionMovimiento = formSeleccionMovimiento.validate({
    onfocusout: false,
    validClass: "is-valid",
    errorClass: "is-invalid",
    errorPlacement: function(label, element) {
        if (element.hasClass("select2")) {
            element.parent().append(label);
            element.next().find(".select2-selection.select2-selection--single").css("border-color", "#E60035");
        } else if (element.attr("type") == "radio") {
            element.closest(".radio-inline").after(label);
        } else {
            label.insertAfter(element);
        }
    },
    unhighlight: function(element, errorClass, validClass) {
        if ($(element).hasClass("select2")) {
            $(element).next().find(".select2-selection.select2-selection--single").css({"border": "1px solid", "border-color": "#1BC5BD"});
        } else if ($(element).attr("type") == "radio") {
            $(element).closest(".radio-inline").next().remove();
        } else {
            $(element).removeClass("is-invalid").addClass(validClass);
            $(element.form).find("label[for=" + element.id + "]").removeClass(errorClass);      
        }
    },
    submitHandler: function(form) {
        Swal.fire({
            title: "¿Está seguro?",
            text: "Antes de continuar, verifique que los datos ingresados sean correctos. Después de finalizar la tarea, no podrá regresar.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Sí, continuar",
            cancelButtonText: "Cancelar",
            reverseButtons: true
        }).then(function(result) {
            if (result.value) {
                KTApp.blockPage({
                    overlayColor: '#000000',
                    state: 'danger',
                    message: 'Por favor, espere...'
                });
                form.submit();
            }
        });
    }
}); 

radiosTipoPlaza.click(function() {
    // El movimiento y el tipo de plaza ya han sido seleccionados
    if (validadorFormSeleccionMovimiento.check(this), validadorFormSeleccionMovimiento.check(selectTipoMovimiento)) {
        let tipoMovimiento = selectTipoMovimiento.find(':selected').parent().attr('label');
        let movimiento = selectTipoMovimiento.find(':selected').text().trim();
        let tipoPlaza = radiosTipoPlaza.filter(":checked").val();
        
        validadorFormSeleccionMovimiento.resetForm();
        contenedorDatosEmpleado.show();
        if (tipoPlaza == "ESTRUCTURA") {
            if (tipoMovimiento == "ALTAS") {
                contenedorFolioAprobacion.show();
                contenedorSearchEmpleado.hide();
                if (movimiento == "102 - ALTA POR REINGRESO") {
                    $("#contenedor_datos_empleado #numero_empleado").parent().show();
                } else {
                    $("#contenedor_datos_empleado #numero_empleado").parent().hide();
                }
                $("#contenedor_datos_empleado #rfc").parent().show(); 
            } else if (tipoMovimiento == "REANUDACIONES") {
                contenedorFolioAprobacion.show();
                contenedorSearchEmpleado.hide();
                $("#contenedor_datos_empleado #numero_empleado").parent().show();
                $("#contenedor_datos_empleado #rfc").parent().show();
            } else if (tipoMovimiento == "BAJAS") {
                contenedorFolioAprobacion.hide();
                contenedorSearchEmpleado.show();
                $("#contenedor_datos_empleado #numero_empleado").parent().show();
                $("#contenedor_datos_empleado #rfc").parent().hide();
            } 
        } else if (tipoPlaza == "TECNICO_OPERATIVO") {
            if (tipoMovimiento == "ALTAS") {
                contenedorFolioAprobacion.hide();
                contenedorSearchEmpleado.hide();
                if (movimiento == "102 - ALTA POR REINGRESO") {
                    contenedorSearchEmpleado.show();
                    contenedorFolioAprobacion.hide();
                    $("#contenedor_datos_empleado #numero_empleado").parent().show();
                    $("#contenedor_datos_empleado #rfc").parent().hide();
                } else {
                    $("#contenedor_datos_empleado #numero_empleado").parent().hide();
                    $("#contenedor_datos_empleado #rfc").parent().show();
                }
            } else if (tipoMovimiento == "REANUDACIONES") {
                contenedorFolioAprobacion.hide();
                contenedorSearchEmpleado.show();
                $("#contenedor_datos_empleado #numero_empleado").parent().show();
                $("#contenedor_datos_empleado #rfc").parent().hide();
            } else if (tipoMovimiento == "BAJAS") {
                contenedorFolioAprobacion.hide();
                contenedorSearchEmpleado.show();
                $("#contenedor_datos_empleado #numero_empleado").parent().show();
                $("#contenedor_datos_empleado #rfc").parent().hide();
            } 
        }
    }
});

















    
    
   
    
    


    




