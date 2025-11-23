var formFinalizarTarea = $('#form_finalizar_tarea');

validadorFormFinalizarTarea = formFinalizarTarea.validate({    
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
                form.submit();
            }
        });
    }
}); 


$('#btn_guardar_avances').click(function (e) {
    var datos = formFinalizarTarea.serialize();
    swal.fire({
        text: "¿Guardar los avances?",
        icon: 'warning',
        showCancelButton: true,
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, continuar',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Manda la petición para guardar los avances
            $.ajax({
                type: "post",
                url: urlGuardarAvanceRevisionDeFolios,
                data: datos,
                success: function (response) {
                    if ( response.estatus ) {
                        Swal.fire({
                            text: response.mensaje,
                            icon: 'success',
                            confirmButtonColor: '#0BB7AF',
                            confirmButtonText: 'Ok'
                        })
                    } else {
                        Swal.fire({
                            text: response.mensaje,
                            icon: 'error',
                            confirmButtonColor: '#0BB7AF',
                            confirmButtonText: 'Ok'
                        })
                    }
                }
            });
        }
    })
});