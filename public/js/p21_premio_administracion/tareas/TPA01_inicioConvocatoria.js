const formInicioConvocatoria = $("#frm_inicio_convocatoria");
const btnFinalizarTarea = $("#btn_finalizar_TPA01");
const selectFechaConvocatoria = $("#fecha_convocatoria");
const selectArea = $("#area_id");

$(document).ready(function(){
    $(".fecha_inicio").datepicker({
        format: 'yyyy-mm-dd',
        // startDate: '0',
        language: 'es',
        autoclose: true,
        daysOfWeekDisabled: [0,6],
        datesDisabled: [
            '2022-01-01', '2022-02-04', '2022-03-18', '2022-05-01', '2022-09-16', '2022-11-18', '2022-12-25',
            '2023-01-01', '2023-02-04', '2023-03-18', '2023-05-01', '2023-09-16', '2023-11-18', '2023-12-25',
            '2024-01-01', '2024-02-05', '2024-03-18', '2024-05-01', '2024-09-16', '2024-11-18', '2024-12-25']
    });
    $(".fecha_inicio").datepicker()
    .on('changeDate', function(e){

        var fecha_inicio = $('#fecha_inicio').val();

        var obj = new Object;
        obj.fecha_inicio = fecha_inicio;

        $.ajax({
            type: "POST",
            url: rutaCalcularFecha,
            data: obj,
            asyn:false,
            success: function(data){
                if ( data.estatus ) {
                    $('#fecha_fin').val(data.fecha_fin);
                }else{
                    swal.fire({
                        "text": data.mensaje,
                        "icon": "warning",
                        "confirmButtonColor": '#0abb87',
                        "confirmButtonText": 'Aceptar',
                        "allowOutsideClick": false,
                    });
                };
            }
        });
    })

    selectArea.select2({
        placeholder: "Seleccione opción"
    });

    selectFechaConvocatoria.select2({
        placeholder: "Seleccione opción"
    });

});

const validatorFormFinalizarTarea = formInicioConvocatoria.validate({
    submitHandler: function(form) {
        Swal.fire({
            title: "¿Está seguro?",
            text: "Antes de continuar, verifique que los datos ingresados sean correctos. Después de finalizar la tarea, no podrá regresar.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Sí, continuar",
            cancelButtonText: "Cancelar",
            reverseButtons: true
        }).then((result) => {
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
