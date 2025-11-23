const formFinalizarTarea = $("#form_finalizar_tarea");
const btnFinalizarTarea = $("#finalizarTarea");
const tablaPresupuestoAreas = $("#tabla_presupuesto_areas");

$(document).ready(function(){
    if (mensajeError) {
        Swal.fire({
            html: mensajeError,
            icon: 'warning',
            confirmButtonColor: '#0BB7AF',
            confirmButtonText: 'Ok'
        });
    }

    // Inicializa la tabla
    if ( subAreas.length > 0 ){
        tablaPresupuestoAreas.bootstrapTable("destroy");
        tablaPresupuestoAreas.bootstrapTable({data: subAreas});
    } else {
        tablaPresupuestoAreas.bootstrapTable();
    }

    // Detecta el cambio en los inputs
    let   inputClass = $('.presu_subarea');

    inputClass.on('blur', function() {
        let inputPresupuesto = $(this);
        let presupuestoArea = inputPresupuesto.val();
        // Encuentra el renglón que contiene el campo de entrada
        let renglon = $(this).closest('tr');
        let renglonIndex = renglon.index();
        let infoArea = tablaPresupuestoAreas.bootstrapTable('getData')[renglonIndex];

        let data = {
            "area_id" : infoArea.area_id,
            "presupuesto" : presupuestoArea,
            "subproceso_id" : subProceso.subproceso_pago_tiempo_extra_excedente_id,
            "presupuesto_total" : presupuestoTotal,
        };
        $.ajax({
            type: "POST",
            url: urlAsignarPresupuesto,
            data: data,
            success: function (response) {
                if ( response.estatus ) {
                    /* Swal.fire({
                        title: "",
                        html: response.mensaje,
                        icon: 'success',
                        confirmButtonColor: '#0BB7AF',
                        confirmButtonText: 'Ok'
                    }); */
                } else {
                    inputPresupuesto.val(0);

                    Swal.fire({
                        title: "",
                        html: response.mensaje,
                        icon: 'warning',
                        confirmButtonColor: '#0BB7AF',
                        confirmButtonText: 'Ok'
                    });
                }
            },
            error: function (error) {
                Swal.fire({
                    html: response.mensaje,
                    icon: 'warning',
                    confirmButtonColor: '#0BB7AF',
                    confirmButtonText: 'Ok'
                });
            },
        });


    });
});

function areasFormatter(value, row) {
    let { identificador, nombre} = row;
    return `${identificador} - ${nombre}`;
}

function presupuestoFormatter(value, row) {
    let {area_id, presupuesto_sub_area} = row;
    return `<div class="input-group">
                <div class="input-group-prepend"><span class="input-group-text"><i class="la la-usd"></i></span></div>
                <input type="number" id="${area_id}" name="presu_subarea[]" class="form-control presupuesto presu_subarea" placeholder="" value="${presupuesto_sub_area ? presupuesto_sub_area : 0 }"  />
            </div>`;
}

let validator = $('#asignarPresupuestoForm').validate({
    validClass: "is-valid",
    errorClass: "is-invalid",
    rules: {
        "presu_subarea[]": {
            required: true,
        }
    },
    messages:{
        "presu_subarea[]": {
            required: 'Ingrese el presupuesto para esta área',
        }
    }
});

btnFinalizarTarea.click(function(e) {
    e.preventDefault();
    let inputsPresupuesto = $('.presu_subarea');
    let sumaPresupuestos = 0;
    inputsPresupuesto.each(function() {
        sumaPresupuestos += parseFloat($(this).val());
    });

    if ( sumaPresupuestos > 0 ) {
        swal.fire({
            title: "¿Está seguro?",
            text: "Antes de continuar, verifique que los datos ingresados sean correctos. Después de finalizar la tarea, no podrá regresar.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Sí, continuar",
            cancelButtonText: "Cancelar",
            reverseButtons: true,
            allowOutsideClick: false,
        }).then((result) => {
            if (result.value) {
                KTApp.blockPage({
                    overlayColor: '#000000',
                    state: 'danger',
                    message: 'Por favor, espere...'
                });
                formFinalizarTarea.submit();
            }
        });
    } else {
        Swal.fire("¡Atención!", "Debes agregar presupuesto a al menos una subárea.", "warning");
    }
});
