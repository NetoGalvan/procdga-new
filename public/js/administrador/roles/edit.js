formGuardar = $("#form_guardar");

validadorFormGuardar = formGuardar.validate({
    submitHandler: function(form) {    
        KTApp.blockPage({
            overlayColor: '#000000',
            state: 'primary',
            message: 'Por favor, espere...'
        });
        form.submit();
    }
});