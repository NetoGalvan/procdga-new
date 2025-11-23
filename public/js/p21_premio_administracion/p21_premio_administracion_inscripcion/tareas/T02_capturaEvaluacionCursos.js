$(document).ready(function(){
    $("#fechaEvaluacion").datepicker({
        format: 'dd/mm/yyyy',
        startDate: '0',
        language: 'es',
        autoclose: true,
        daysOfWeekDisabled: [0,6],
        datesDisabled: [
            '01/01/2022','04/02/2022','18/03/2022','01/05/2022','16/09/2022','18/11/2022','25/12/2022',
            '01/01/2023','04/02/2023','18/03/2023','01/05/2023','16/09/2023','18/11/2023','25/12/2023',
            '01/01/2024','05/02/2024','18/03/2024','01/05/2024','16/09/2024','18/11/2024','25/12/2024'
        ]
    });
});

var table = $('#tabla_cursos');

$('#guardarCurso').click(function(){
    agregarFila();
});

formAgregarCurso = $("#form_agregar_curso");

function agregarFila() {

    var rows = [];

    var obj = new Object();
    obj.nombreCurso = $("#nombreCurso").val();
    obj.porcentaje = $("#aplicacionDiario").val();
    obj.comentarioCurso = $("#comentariosAplicacion").val();


    if ( $("#form_agregar_curso").valid() ) {

        rows.push({
            nombre_curso : obj.nombreCurso,
            aplicacion: obj.porcentaje,
            comentarios_oper_pa: obj.comentarioCurso
        });

        table.bootstrapTable('append', rows);
        $("#nombreCurso").val(" ");
        $("#aplicacionDiario").val("-1");
        $("#comentariosAplicacion").val(" ");
        swal.fire({
            "text": "Curso agregado correctamente",
            "icon": "success",
            "allowOutsideClick": false,
            "confirmButtonClass": "btn btn-secondary btn-lg"
        });
    }
}

var validatorCurso = formAgregarCurso.validate({
    onfocusout: false,
    rules: {
        nombreCurso: {
            required: true,
            campoNoVacio: true
        },
        aplicacionDiario: {
            required: true,
            select: '-1'
        },
        comentariosAplicacion: {
            required: true,
            campoNoVacio: true
        },
    },
    messages: {
        nombreCurso: {
            required: 'Campo obligatorio',
            campoNoVacio: "No se puede enviar espacios en blanco"
        },
        aplicacionDiario: {
            required: 'Campo obligatorio'
        },
        comentariosAplicacion: {
            required: 'Campo obligatorio',
            campoNoVacio: "No se puede enviar espacios en blanco"
        }
    },
    errorPlacement: function(label, element) {
        element.addClass('error');
        label.insertAfter(element);
    }

});

//Para guardar el formulario y terminar la tarea
formFinalizarTarea = $("#form_completar_tarea_02");
btnFinalizarTarea = $("#btn_finalizar_T02");

const validatorFormFinalizarTarea = formFinalizarTarea.validate({
    submitHandler: function(form) {
        let tablaCurso = table.bootstrapTable('getData');

        if ( tablaCurso.length > 0 ) {
            $('#data_tabla_cursos').val( JSON.stringify(tablaCurso) );
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
        } else {
            Swal.fire({
                title: "Cursos",
                html: "Debes agregar al menos un curso para poder continuar",
                icon: 'warning',
                confirmButtonColor: '#0BB7AF',
                confirmButtonText: 'Ok'
            });
        }

    }
});

$.validator.addMethod("select", function(value, element, arg){
    return arg !== value;
    }, 'Seleccione una opción');

$.validator.addMethod("digitosTelefono", function(value, element) {
    return this.optional(element) || /^[0-9]{10}$/i.test(value);
});
