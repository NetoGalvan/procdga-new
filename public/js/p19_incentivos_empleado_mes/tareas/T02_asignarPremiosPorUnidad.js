const formAsignarPremiosUnidad  = $("#form_asignar_premios_unidad");
const validator                 = $("#form_asignar_premios_unidad").validate();
const tablaAsignarPremiosUnidad = $('#tabla_asignar_premios_unidad');
const btnFinalizarProceso       = $('#btn_finalizar_proceso');
const btnCancelarProceso        = $("#btn_cancelar");
const btnContinuarProceso       = $('#btn_continuar_proceso');
const premiosAprobados          = incentivoEmpleadoMes.premios_aprobados;
const inputPremiosAsignados     = $('#premios_asignados_total');

// Cargar data
$(document).ready(function () {

    operacion(0);

    // Se valida si existen se carga en la tabla
    if ( areasUnidades.length > 0 ){
        tablaAsignarPremiosUnidad.bootstrapTable("destroy");
        tablaAsignarPremiosUnidad.bootstrapTable({data: areasUnidades});

        // Agregamos reglas de validación a los inputs de cantidad de premios asignados
        $.each( areasUnidades, function(index, value) {
            $( "#premios_asignados_"+value.area_id ).rules( "add", {
                required: true,
                messages: {
                    required: "Captura cantidad",
                }
            });
        });

        // Agregamos evento Change a los inputs de cantidad de premios asignados
        $.each( areasUnidades, function(index, value) {
            $("#premios_asignados_"+value.area_id).on("input", function() {

                // Obtenemos sus valores
                const inputsCantidad = areasUnidades.map(area => {
                    let inputsCan =+ $("#premios_asignados_"+area.area_id).val();
                    return inputsCan;
                });
                // Realizamos al suma de los campos
                const premiosAsignados = inputsCantidad.reduce((a, b) => {
                    return a + b;
                });

                operacion(premiosAsignados);
             });
        });



    } else {
        tablaAsignarPremiosUnidad.bootstrapTable();
    }

});

function operacion(premiosAsignados) {
    $('.premios-autorizados').html(`<span class="badge badge-success">Premios Autorizados: ${premiosAprobados}</span>`);
    $('.premios-asignados').html(`${premiosAprobados < premiosAsignados ? `<span class="badge badge-danger">Premios Asignados: ${premiosAsignados}</span>` : `<span class="badge badge-success">Premios Asignados: ${premiosAsignados}</span>`}`);
    $('.premios-restantes').html(`${premiosAprobados < premiosAsignados ? `<span class="badge badge-danger">Premios Restantes: ${premiosAprobados - premiosAsignados}</span>` : `<span class="badge badge-success">Premios Restantes: ${premiosAprobados - premiosAsignados}</span>`}`);
    inputPremiosAsignados.val(premiosAsignados);
}

// Formatters de la tabla
function aplicaFormatter(value, row){
    return '<select class="form-control form-control-sm data-input-aplica text-uppercase" name="aplica_'+row.area_id+'" id="aplica_'+row.area_id+'" ><option class="text-uppercase" value="SI"> SI </option> <option class="text-uppercase" value="NO"> NO </option></select>';
}
function cantidadPremiosFormatter(value, row){
    return '<input class="form-control form-control-sm normalizar-texto" type="number" min="0" name="premios_asignados_'+row.area_id+'" id="premios_asignados_'+row.area_id+'" value="0" >';
}


// Evento que permite Continuar y Finalizar con la T01
btnContinuarProceso.click(function (e) {
    e.preventDefault();

    // Valida los inputs
    const esValido =  formAsignarPremiosUnidad.valid();

    if ( esValido ) {

        // Valida la cantidad de cantidades capturadas
        const esMayor = premiosAprobados >=  inputPremiosAsignados.val();
        if ( esMayor ) {
            let arregloAreas = tablaAsignarPremiosUnidad.bootstrapTable('getData');
            $('#arreglo_areas').val(JSON.stringify(arregloAreas));

            Swal.fire({
                title: 'Continuar',
                text: "¿Esta seguro(a) de continuar con este proceso?",
                icon: 'question',
                showCancelButton: true,
                cancelButtonColor: '#F64E60',
                cancelButtonText: 'No',
                confirmButtonColor: '#0BB7AF',
                confirmButtonText: 'Si'
            }).then((result) => {
                if (result.isConfirmed) {
                    KTApp.blockPage({
                        overlayColor: '#000000',
                        state: 'danger',
                        message: 'Por favor, espere...'
                    });
                    formAsignarPremiosUnidad.submit();
                }
            })
        } else {
            Swal.fire({
                title: "Continuar",
                text: "La cantidad ''Asignada'' es mayor a la ''Autorizada'', por favor verifique que las cantidades sean correctas para poder continuar",
                icon: 'warning',
                confirmButtonColor: '#0BB7AF',
                confirmButtonText: 'Entendido'
            });
        }
    } else {
        Swal.fire({
            title: "Continuar",
            text: "Para continuar, debes capturar la información",
            icon: 'warning',
            confirmButtonColor: '#0BB7AF',
            confirmButtonText: 'Entendido'
        });
    }

});

btnCancelarProceso.click(function() {
    swal.fire({
        title: "¿Está seguro de cancelar el proceso?",
        text: "El folio se cancelará y no podrá continuar.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, CANCELAR proceso",
        cancelButtonText: "No, regresar",
        reverseButtons: true
    }).then((result) => {
        if (result.value) {
            KTApp.blockPage({
                overlayColor: '#000000',
                state: 'danger',
                message: 'Por favor, espere...'
            });
            $("#form_asignar_premios_unidad").append(`<input type="hidden" name="accion" value="cancelar">`);
            $("#form_asignar_premios_unidad")[0].submit();
        }
    });
});
