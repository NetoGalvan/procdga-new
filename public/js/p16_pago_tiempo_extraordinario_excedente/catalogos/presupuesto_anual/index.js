$(document).ready(function(){
    //input de año al asignar presupuesto
    $("#anio_presupuesto").datepicker({
        format: "yyyy",
        viewMode: "years",
        minViewMode: "years",
        startDate: new Date().getFullYear().toString(),
        autoclose : true,
        orientation: "bottom",
        startDate: '2023',
        endDate: '+0y',
    }).on("change", function() {
        $(this).trigger("keyup");
    });
});
//select2 de las unidades administrativas al asignar presupuesto
$('#unidadAdministrativa').select2({
    placeholder: "Selecciona una Unidad Administrativa",
    allowClear: true,
    width: '95%'
});
//después de ocultar el modal de asignar presupuesto
$('#createPresupuestoModal').on('hidden.bs.modal', function (event) {
    limpiaForm();
})
//limpia el form de las validaciones y datos
function limpiaForm(){
    createForm.reset();
    $('#createForm').validate().resetForm();
    $("input").removeClass("is-invalid is-valid");
    $('#unidadAdministrativa').val(null).trigger('change');
}
//columna restante
function restanteFormatter(val, row) {
    return `
        <p class="my-auto">${row.presupuesto_asignado-row.presupuesto_utilizado}</p>
    `;
}
//columna acciones
function accionesFormatter(val, row) {
    return `
        <button onClick="editarPresupuestoModal(${row.presupuesto_id})" class="btn btn-sm btn-primary"><i class="fas fa-edit pr-0"></i></button>
    `;
}
//recargar el datatable segun el año
function anioReload(){
    $.get(reloadCatalogoRoute + '/' + $( "#anioSelect" ).val()).then(function (res) {
        $("#table-presupuesto").bootstrapTable('load', res)
    })
}
//guardar un presupuesto anual
function createCatalogoPresupuesto(){
    $('#btnCreate').deshabilitarBtn();
    var validator = $('#createForm').validate({
        validClass: "is-valid",
        errorClass: "is-invalid",
        rules: {
            unidadAdministrativa: {
                required: true,
            },
            presupuesto_asignado: {
                required: true,
            },
            anio_presupuesto: {
                required: true,
            },
        },
        messages:{
            unidadAdministrativa: {
                required: 'Seleccione una Unidad Administrativa.',
            },
            presupuesto_asignado: {
                required: 'Ingrese un Presupuesto.',
            },
            anio_presupuesto: {
                required: 'Ingrese un año.',
            }
        },
        errorPlacement: function(label, element) {
            label.addClass('invalid-feedback');
            if (element.hasClass("select2")) {
                element.parent().append(label);
                element.next().find(".select2-selection.select2-selection--single").css("border-color", "#E60035");
            } else {
                label.insertAfter(element);
            }
        },
        unhighlight: function(element, errorClass, validClass) {
            if (!$(element).prop("required") && $(element).val() == '') {
                $(element).removeClass(errorClass).removeClass(validClass);
            } else {
                if ($(element).hasClass("select2")) {
                    $(element).next().find(".select2-selection.select2-selection--single").css({"border": "1px solid", "border-color": "#1BC5BD"});
                } else {
                    $(element).removeClass(errorClass).addClass(validClass);
                }
            }
        },
    });
    if (validator.form()) {
        var datos = new FormData(document.getElementById("createForm"));
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: $( "#createForm" ).attr('target'),
            data: datos,
            dataType: 'json',
            processData: false,
            contentType: false
        }).done(function (response) {
            if (response.estatus) {
                anioReload();
                Swal.fire('¡Éxito!',response.mensaje,'success');
                $('#createPresupuestoModal').modal('hide')
            } else {
                Swal.fire('¡Upss!',response.mensaje,'warning');
            }
        }).fail(function(data) {
            if (data.status==422) {//validacion de laravel falló
                Swal.fire('¡Upss!','Alguno de sus campos tiene valores inaceptables. Code-TEECC','info');
            } else {
                Swal.fire('¡Upss!',data.responseText+'Code-TEECC','warning');
            }
        });
    } else {
        validator.focusInvalid();
    }
    $('#btnCreate').habilitarBtn();
    event.preventDefault();
}
//modal editar presupuesto anual
function editarPresupuestoModal(presupuesto_id){
    var datos={'presupuesto_id':presupuesto_id};
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'post',
        url: editCatalogoRoute,
        data: datos,
        dataType: 'html'
    }).done(function (response) {
        $("#editPresupuestoModal").html(response);
        $('#unidadAdministrativaEdit').select2({
            placeholder: "Selecciona una Unidad Administrativa",
            allowClear: true,
            width: '95%'
        });
        $("#anio_presupuesto_edit").datepicker({
            format: "yyyy",
            viewMode: "years",
            minViewMode: "years",
            autoclose : true,
            orientation: "bottom",
        }).on("change", function() {
            $(this).trigger("keyup");
        });
        $("#editPresupuestoModal").modal('show');
    }).fail(function(data) {
        Swal.fire('¡Upss!',data.responseText+'Code-TEECC','warning');
    });
}
//editar un presupuesto anual
function editCatalogoPresupuesto(){
    $('#btnEdit').deshabilitarBtn();
    var validator = $('#editForm').validate({
        validClass: "is-valid",
        errorClass: "is-invalid",
        rules: {
            /* unidadAdministrativaEdit: {
                required: true,
            }, */
            presupuesto_asignado_edit: {
                required: true,
            },
            anio_presupuesto_edit: {
                required: true,
            },
        },
        messages:{
            unidadAdministrativaEdit: {
                required: 'Seleccione una Unidad Administrativa.',
            },
            presupuesto_asignado_edit: {
                required: 'Ingrese un Presupuesto.',
            },
            anio_presupuesto_edit: {
                required: 'Ingrese un año.',
            }
        },
        errorPlacement: function(label, element) {
            label.addClass('invalid-feedback');
            if (element.hasClass("select2")) {
                element.parent().append(label);
                element.next().find(".select2-selection.select2-selection--single").css("border-color", "#E60035");
            } else {
                label.insertAfter(element);
            }
        },
        unhighlight: function(element, errorClass, validClass) {
            if (!$(element).prop("required") && $(element).val() == '') {
                $(element).removeClass(errorClass).removeClass(validClass);
            } else {
                if ($(element).hasClass("select2")) {
                    $(element).next().find(".select2-selection.select2-selection--single").css({"border": "1px solid", "border-color": "#1BC5BD"});
                } else {
                    $(element).removeClass(errorClass).addClass(validClass);
                }
            }
        },
    });
    if (validator.form()) {
        var datos = new FormData(document.getElementById("editForm"));
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: $( "#editForm" ).attr('target'),
            data: datos,
            dataType: 'json',
            processData: false,
            contentType: false
        }).done(function (response) {
            if (response.estatus) {
                $('#table-presupuesto').bootstrapTable('refresh');
                Swal.fire('¡Éxito!',response.mensaje,'success');
                $('#editPresupuestoModal').modal('hide');
            } else {
                Swal.fire('¡Upss!',response.mensaje,'warning');
            }
        }).fail(function(data) {
            if (data.status==422) {//validacion de laravel falló
                Swal.fire('¡Upss!','Alguno de sus campos tiene valores inaceptables. Code-TEECC','info');
            } else {
                Swal.fire('¡Upss!',data.responseText+'Code-TEECC','warning');
            }
        });
    } else {
        validator.focusInvalid();
    }
    $('#btnEdit').habilitarBtn();
    event.preventDefault();
}
