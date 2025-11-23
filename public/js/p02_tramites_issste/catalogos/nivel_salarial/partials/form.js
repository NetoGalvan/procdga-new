const formGuardarNivelSalarial = $('#form_guardar_nivel_salarial');
const btnGuardarNivelSalarial = $('#btn_guardar_nivel_salarial');

validadorFormGuardarNivelSalarial = formGuardarNivelSalarial.validate({
    onfocusout: false,
});

btnGuardarNivelSalarial.click(function() {

    if ( formGuardarNivelSalarial.valid() ) {
        Swal.fire({
            title: "Nivel Salarial",
            text: "¿Deseas guardar este Nivel Salarial?",
            icon: "question",
            showCancelButton: true,
            cancelButtonColor: '#F64E60',
            cancelButtonText: "Cancelar",
            confirmButtonText: "Sí, continuar",
            confirmButtonColor: '#0BB7AF',
            reverseButtons: true,
        }).then(function(result) {
            if (result.value) {
                formGuardarNivelSalarial.submit();
            }
        });
    }

});
