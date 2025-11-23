const formSubprocesoDistribuirPremiosSubAreas  = $("#form_subproceso_distribuir_premios_subareas");
const validator                     = $("#form_subproceso_distribuir_premios_subareas").validate();
const tablaDistribuirPremiosSubArea = $('#tabla_subproceso_distribuir_premios_subarea');
const btnContinuarProceso           = $('#btn_continuar_proceso');
const premiosAprobados              = subproceso.premios_aprobados;
const inputPremiosAsignados         = $('#premios_asignados_total');

// Cargar data
$(document).ready(function () {

    operacion(0);

    // Se valida si existen se carga en la tabla
    if ( subAreas.length > 0 ){
        tablaDistribuirPremiosSubArea.bootstrapTable("destroy");
        tablaDistribuirPremiosSubArea.bootstrapTable({data: subAreas});

        // Agregamos reglas de validación a los inputs de cantidad de premios asignados
        $.each( subAreas, function(index, value) {
            $( "#premios_asignados_"+value.area_id ).rules( "add", {
                required: true,
                messages: {
                    required: "Captura cantidad",
                }
            });
        });

        // Agregamos evento Change a los inputs de cantidad de premios asignados
        $.each( subAreas, function(index, value) {
            $("#premios_asignados_"+value.area_id).on("input", function() {

                // Obtenemos sus valores
                const inputsCantidad = subAreas.map(area => {
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
        tablaDistribuirPremiosSubArea.bootstrapTable();
    }

});

function operacion(premiosAsignados) {
    $('.premios-autorizados').html(`<span class="badge badge-success">Premios Autorizados: ${premiosAprobados}</span>`);
    $('.premios-asignados').html(`${premiosAprobados < premiosAsignados ? `<span class="badge badge-danger">Premios Asignados: ${premiosAsignados}</span>` : `<span class="badge badge-success">Premios Asignados: ${premiosAsignados}</span>`}`);
    $('.premios-restantes').html(`${premiosAprobados < premiosAsignados ? `<span class="badge badge-danger">Premios Restantes: ${premiosAprobados - premiosAsignados}</span>` : `<span class="badge badge-success">Premios Restantes: ${premiosAprobados - premiosAsignados}</span>`}`);
    inputPremiosAsignados.val(premiosAsignados);
}

// Formatters de la tabla
function cantidadPremiosFormatter(value, row){
    return '<input class="form-control form-control-sm normalizar-texto" type="number" min="0" name="premios_asignados_'+row.area_id+'" id="premios_asignados_'+row.area_id+'" value="0" >';
}

// Evento que permite Continuar y Finalizar con la T01
btnContinuarProceso.click(function (e) {
    e.preventDefault();

    // Valida los inputs
    const esValido =  formSubprocesoDistribuirPremiosSubAreas.valid();

    if ( esValido ) {

        // Valida la cantidad de cantidades capturadas
        const esMayor = premiosAprobados >=  inputPremiosAsignados.val();
        if ( esMayor ) {
            let arregloSubAreas = tablaDistribuirPremiosSubArea.bootstrapTable('getData');
            $('#arreglo_sub_areas').val(JSON.stringify(arregloSubAreas));

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
                    formSubprocesoDistribuirPremiosSubAreas.submit();
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


