const formSubprocesoAsignacionPremisoEmpleado = $( "#form_subproceso_asignacion_premios_empleado" );
const tablaEmpleadosNomina = $( "#tabla_empleados_nomina" );
const dataEmpleado = $("#data_empleado");
const btnContinuarProceso   = $('#btn_continuar_proceso');
const selectEmpleadosST02 = $("#datos_empleado");
const btnAgregarEmpleado = $("#btn_agregar_empleado");

// Cargar data
$(document).ready(function () {
    // Se valida si existen se carga en la tabla
    if ( empleadosNomina.length > 0 ){
        tablaEmpleadosNomina.bootstrapTable("destroy");
        tablaEmpleadosNomina.bootstrapTable({data: empleadosNomina});
    } else {
        tablaEmpleadosNomina.bootstrapTable();
    }

});

// Formatter tabla
function nombreEmpleadoFormatter(value, row) {
    let nombreEmpleado = `${row.nombre_empleado} ${row.apellido_paterno} ${row.apellido_materno} `;
    return nombreEmpleado;
}
function accionesFormatter(value, row) {
    return `<button type="button" class="btn btn-icon btn-outline-danger" onclick="eliminarEmpleado(${row.p19_nomina_id})"><i class="far fa-trash-alt"></i></button>`;
}
function reporteFormatter(value, row) {
    let acciones = `<a type="button"
            href="${urlImprimirReporteEmpleado}/${row.p19_nomina_id}"
            class="btn btn-outline-danger btn-icon"
            data-toggle="tooltip"
            title="Descargar reporte"
            onclick="descargarReporte(event, this.href)">
            <i class="fas fa-file-pdf"></i>
        </a>`;
    return acciones;
}
function faltaFormatter(value, row) {
    let faltas =  `SIN FALTAS`;
    return faltas;
}
function justificacionesFormatter(value, row) {
    let just =  `SIN JUSTIFICACIONES`;
    return just;
}
function calificaFormatter(value, row) {
    let califica =  `<span class="badge badge-success"><i class="far fa-check-circle icon-nm text-white mr-1"></i> CALIFICA </span>`;
    return califica;
}

function descargarReporte(event, url) {
    event.preventDefault(); // Evita que el enlace se ejecute normalmente

    // Muestra el indicador de carga
    KTApp.blockPage({
        overlayColor: '#000000',
        state: 'danger',
        message: 'Por favor, espere...'
    });

    // Realiza la solicitud de descarga
    $.ajax({
        url: url,
        method: 'GET',
        xhrFields: {
            responseType: 'blob' // Indica que esperamos un archivo
        },
        success: function(data) {
            // Si la solicitud es exitosa, crea un enlace temporal y lo usa para descargar el archivo
            var a = document.createElement('a');
            var url = window.URL.createObjectURL(data);
            a.href = url;
            a.download = 'reporte.pdf'; // Ajusta el nombre del archivo según sea necesario
            document.body.append(a);
            a.click();
            a.remove();
            window.URL.revokeObjectURL(url);
        },
        complete: function() {
            // Oculta el indicador de carga cuando la solicitud se completa
            KTApp.unblockPage();
        }
    });
}

// Evento que detecta cuando seleccionaron un empleado y obtenemos datos para validar su información
selectEmpleadosST02.change( function() {

    // Cada que selecciono oculto y limpio la data del empleado
    dataEmpleado.val('');
    btnAgregarEmpleado.attr('disabled', true);
    // Si el select cambio y tiene dato se desestructura el dato
    if ( this.value ) {
        let { seccion_sindical, nombre_completo, numero_empleado, rfc, unidad_administrativa_nombre } = JSON.parse(this.value);
        // Despues validamos si el empleado cuenta con digito sindical ya que solo los Sindicalizados pueden recibir este incentivo
        if ( seccion_sindical !== "0" )
        {
            // Asignamos la data del empleado a una variable para acceder a ella si cumple con las evaluación de sección sindical
            dataEmpleado.val(this.value);
            btnAgregarEmpleado.attr('disabled', false);
        } else
        {
            Swal.fire({
                title: 'Sin sección sindical',
                html: 'El empleado no cuenta con sección sindical,<br> por tal motivo, No puede ser candidato<br> al premio incentivo del mes',
                icon: 'warning',
                confirmButtonColor: '#0BB7AF',
                confirmButtonText: 'Ok'
            });

        }
    }
});

// Validación del formulario
function validacionForm() {

    const validator = formSubprocesoAsignacionPremisoEmpleado.validate({
        onfocusout: false,
        rules: {
            rfc: {
                RFC: true,
                required: true
            }
        },
        messages: {
            rfc: {
                RFC : 'Ingrese una RFC valido',
                required : 'Este campo debe ser llenado'
            }
        },
    });

    return validator;
}

// Función para agregar al Empleado en la Nomina
function agregarEmpleadoNomina( obj ) {

    let registros = tablaEmpleadosNomina.bootstrapTable('getData')
    // Validamos que los empleados capturados sean igual o menos a los premioS asignados
    if ( premiosSubAreaAutorizados > registros.length ) {
        // Obtenemos la data a guardar del Empleado
        data = { 'data_empleado' : dataEmpleado.val(), 'subproceso' : subproceso, 'comentarios_admin_incen' : $('#comentarios_admin_incen').val(), 'instancia_tarea' : instanciaTarea }

        Swal.fire({
            title: 'Agregar empleado',
            text: "¿Desea agregar al empleado?",
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
                $.ajax({
                    type: "POST",
                    url: urlAgregarEmpleado,
                    data: data,
                    success: function (response) {
                        KTApp.unblockPage();
                        if ( response.estatus ) {
                            Swal.fire({
                                title: '',
                                html: response.mensaje,
                                icon: 'success',
                                confirmButtonColor: '#0BB7AF',
                                confirmButtonText: 'Ok',
                                allowOutsideClick: false,
                            })
                            // Agregamos el nuevo empleado a la tabla
                            tablaEmpleadosNomina.bootstrapTable('insertRow', {
                                index: 0,
                                row: response.EmpleadoNomina
                            })
                        } else {
                            Swal.fire({
                                title: '',
                                html: response.mensaje,
                                icon: 'error',
                                confirmButtonColor: '#0BB7AF',
                                confirmButtonText: 'Ok',
                            })
                        }
                    },
                    error: function (responseText, textStatus, errorThrown) {
                        KTApp.unblockPage();
                        Swal.fire({
                            title: 'Error',
                            html: errorThrown,
                            icon: 'error',
                            confirmButtonColor: '#0BB7AF',
                            confirmButtonText: 'Ok'
                        });
                    }
                });
            }
        })
    } else {
        Swal.fire({
            title: 'Premios Autorizados',
            text: 'Ya capturo el máximo de empleados que esta permitido',
            icon: 'error',
            confirmButtonColor: '#0BB7AF',
            confirmButtonText: 'Ok',
        })
    }


}

// Función para eliminar empleado de la Nomina
function eliminarEmpleado( idEmpleadoNomina ) {

    let data = { 'p19_nomina_id' : idEmpleadoNomina }
    Swal.fire({
        title: 'Eliminar empleado',
        text: "¿Esta seguro de eliminar este empleado?",
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
            $.ajax({
                type: "POST",
                url: urlEliminarEmpleado,
                data: data,
                success: function (response) {
                    KTApp.unblockPage();
                    if ( response.estatus ) {
                        Swal.fire({
                            title: '',
                            text: response.mensaje,
                            icon: 'success',
                            confirmButtonColor: '#0BB7AF',
                            confirmButtonText: 'Ok',
                            allowOutsideClick: false,
                        })
                        // Eliminamos empleado
                        tablaEmpleadosNomina.bootstrapTable('removeByUniqueId', idEmpleadoNomina)
                    } else {
                        Swal.fire({
                            title: '',
                            text: response.mensaje,
                            icon: 'error',
                            confirmButtonColor: '#F64E60',
                            confirmButtonText: 'Ok',
                        })
                    }
                },
                error: function (responseText, textStatus, errorThrown) {
                    KTApp.unblockPage();
                    Swal.fire({
                        title: 'Error',
                        text: errorThrown,
                        icon: 'error',
                        confirmButtonColor: '#F64E60',
                        confirmButtonText: 'Ok'
                    });
                }
            });
        }
    })
}

// Evento que permite Continuar y Finalizar
btnContinuarProceso.click(function (e) {
    e.preventDefault();

    // Informamos si hay premios por capturar, si no continua
    let registros = tablaEmpleadosNomina.bootstrapTable('getData')

    if ( premiosSubAreaAutorizados <= registros.length ) {
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
                formSubprocesoAsignacionPremisoEmpleado.submit();
            }
        })
    } else {
        Swal.fire({
            title: 'Continuar',
            html: "<p>Esta asignado menos premios <br> de los que se le autorizaron <br> ¿Aún así deseas continuar? </p>",
            icon: 'warning',
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
                formSubprocesoAsignacionPremisoEmpleado.submit();
            }
        })
    }

});
