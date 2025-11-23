$(document).ready(function(){
    if (mensajeError) {
        Swal.fire({
            html: mensajeError,
            icon: 'warning',
            confirmButtonColor: '#0BB7AF',
            confirmButtonText: 'Ok'
        });
    }
});

$("#anio").datepicker({
    format: "yyyy",
    viewMode: "years",
    minViewMode: "years",
    startDate: '2022',
    endDate: '+0y',
    autoclose : true,
}).on("change", function() {
    anioReload();
});

//despues de ocultar el modal de asignar sueldo de tecnico operatico
$('#createSueldoModal').on('hidden.bs.modal', function (event) {
    limpiaForm();
})
//limpia el form de las validaciones y datos
function limpiaForm(){
    createForm.reset();
    $("input").removeClass("is-invalid is-valid");
    $("select").removeClass("is-invalid is-valid");
    $('#createForm').validate().resetForm();
}

function tipoFormatter(val, row) {
    if (row.tipo == "BASE_SINDICALIZADO") {
        return `BASE SINDICALIZADO`;
    } else if (row.tipo == "BASE_NO_SINDICALIZADO") {
        return `BASE NO SINDICALIZADO`;
    } else if (row.tipo == "CONFIANZA") {
        return `CONFIANZA`;
    }
}

//columna acciones
function accionesFormatter(val, row) {
    return [

        '<button onClick="editarSueldoModal('+row.tabulador_calcular_tiempo_extra_id+')" class="btn btn-outline-primary btn-icon"><i class="fas fa-edit"></i></button>', ' ',
        '<button onClick="eliminarSueldoModal('+row.tabulador_calcular_tiempo_extra_id+')" class="btn btn-outline-danger btn-icon"><i class="far fa-trash-alt"></i></button>'
    
    ].join('');
}
//recargar el datatables segun el año
function anioReload(){
    
    $.get(reloadCatalogoRoute + '/' + $( "#anio" ).val()).then(function (res) {
        $("#table-sueldos").bootstrapTable('load', res)
    })
}

const formDatosTabulador = $("#createForm");
const btnGuardarTabulador = $("#btnCreate");

btnGuardarTabulador.click(function(e) {
    e.preventDefault();
    if ( $("#createForm").valid() ) {
        swal.fire({
            "title": "Verifique que la información sea correcta",
            "text": "¿Está seguro de continuar?",
            "icon": "question",
            "confirmButtonColor": '#0abb87',
            "confirmButtonText": 'Aceptar',
            "showCancelButton": true,
            "cancelButtonColor": '#fd397a',
            "cancelButtonText": 'Cancelar',
            "allowOutsideClick": false,
        }).then((result) => {
            if (result.value) {
                KTApp.blockPage({
                    overlayColor: '#000000',
                    state: 'danger',
                    message: 'Por favor, espere...'
                });
                formDatosTabulador.submit();
            }
        });
    }
    event.preventDefault();
});
//modal de editar un sueldo
function editarSueldoModal(tabulador_sueldo_tecnico_operativo_id){
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'post',
        url: editCatalogoRoute,
        data: {'id': tabulador_sueldo_tecnico_operativo_id},
        dataType: 'html',
    }).done(function (response) {
        $("#editSueldoModal").html(response);
        $("#editSueldoModal").modal('show')
    }).fail(function(data) {
        Swal.fire('¡Upss!','No pudimos obtener su información. CODE TEECC','warning');
    });
}

const formEditarTabulador = $("#editForm");
const modalEditarTabulador = $("#editSueldoModal");

modalEditarTabulador.on("click", "#btnEdit", function(e) {
    e.preventDefault();
    if ( $("#editForm").valid() ) {
        swal.fire({
            "title": "Verifique que la información sea correcta",
            "text": "¿Está seguro de continuar?",
            "icon": "question",
            "confirmButtonColor": '#0abb87',
            "confirmButtonText": 'Aceptar',
            "showCancelButton": true,
            "cancelButtonColor": '#fd397a',
            "cancelButtonText": 'Cancelar',
            "allowOutsideClick": false,
        }).then((result) => {
            if (result.value) {
                modalEditarTabulador.modal("hide");
                KTApp.blockPage({
                    overlayColor: '#000000',
                    state: 'danger',
                    message: 'Por favor, espere...'
                });
                $("#editForm").submit();
            }
        });
    }
    event.preventDefault();
});

function eliminarSueldoModal(id){

    swal.fire({
        "html": "Esta a punto de eliminar el tabulador. <br><br> ¿Está seguro de continuar?",
        "icon": "question",
        "confirmButtonColor": '#0abb87',
        "confirmButtonText": 'Aceptar',
        "showCancelButton": true,
        "cancelButtonColor": '#fd397a',
        "cancelButtonText": 'Cancelar',
        "allowOutsideClick": false,
    }).then((result) => {

        if (result.value) {

            $.ajax({
                url : urlEliminar,
                type : 'POST',
                data : {id},
                async : false,
                success: function(data){

                    if ( data.estatus ) {
                        Swal.fire({
                            "text": data.mensaje,
                            "icon": "success",
                            "confirmButtonColor": '#0abb87',
                            "confirmButtonText": 'Aceptar',
                            "allowOutsideClick": false,
                        }).then((result) => {
                            window.location.reload(true);
                        });
                    }else{
                        Swal.fire(data.mensaje, "", "warning");
                    };
                }
            });
        }
    });
}