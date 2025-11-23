// AGREGAR FECHA
const formAgregarFecha = $("#form_agregar_fecha");
const selectDiaFestivo = formAgregarFecha.find("[name=descripcion]");
selectDiaFestivo.select2({
    placeholder: "Descripción",
    tags: true,
});
var validatorFormAgregarFecha = formAgregarFecha.validate({
    submitHandler: function(form) {
        KTApp.blockPage({
            overlayColor: '#000000',
            state: 'danger',
            message: 'Por favor, espere...'
        });
        $.post($(form).attr("action"), $(form).serialize())
            .done(function (resp) {
                if (resp.estatus) {
                    tablaFechas.bootstrapTable('insertRow', {
                        index: 0,
                        row: resp.diaFestivoFecha
                    });
                    swal.fire("Se agregó correctamente", "", "success");
                    selectDiaFestivo.val("").trigger("change");
                    formAgregarFecha.trigger("reset");
                    validatorFormAgregarFecha.resetForm();
                    $('[data-toggle="tooltip"]').tooltip();
                } else {
                    swal.fire(resp.mensaje, "", "error");
                }
            }).fail(function(jqXHR, textStatus, error) {
                swal.fire("", error, "error");
            }).always(function() {
                KTApp.unblockPage();
            }); 
    }
});
// EDITAR FECHA
const formEditarFecha = $("#form_editar_fecha");
const selectEditarDiaFestivo = formEditarFecha.find("[name=descripcion]");
const modalEditarFecha = $("#modal_editar_fecha");
modalEditarFecha.on('shown.bs.modal', function (e) {
    let fechaDiaFestivo = modalEditarFecha.data("fechaDiaFestivo");

    let existeDescripcion = false;
    diasFestivos.forEach((item, index) => {
        if (item.nombre == fechaDiaFestivo.descripcion) {
            existeDescripcion = true;
        }
    });

    var data = [];
    if (!existeDescripcion) {
        data.push({ 
            id: fechaDiaFestivo.descripcion,
            text: fechaDiaFestivo.descripcion
        });
    }
    diasFestivos.forEach(item => {
        data.push({ 
            id: item.nombre,
            text: item.nombre
        });
    });
    selectEditarDiaFestivo.empty().trigger("change");
    selectEditarDiaFestivo.html(`<option value=""> Selecciona una opción </option>`);
    selectEditarDiaFestivo.select2({
        placeholder: "Descripción",
        tags: true,
        data: data,
    });
    selectEditarDiaFestivo.val(fechaDiaFestivo.descripcion).trigger("change"); 
    formEditarFecha.find("[name=dia_festivo_fecha_id]").val(fechaDiaFestivo.dia_festivo_fecha_id);
    formEditarFecha.find("[name=fecha]").val(moment(fechaDiaFestivo.fecha).format("DD-MM-Y")).trigger("change");
});
modalEditarFecha.on('hidden.bs.modal', function (e) {
    selectEditarDiaFestivo.val("").trigger("change");
    formEditarFecha.trigger("reset");
    validatorFormEditarFecha.resetForm();
});
var validatorFormEditarFecha = formEditarFecha.validate({
    submitHandler: function(form) {
        KTApp.blockPage({
            overlayColor: '#000000',
            state: 'danger',
            message: 'Por favor, espere...'
        });
        $.post($(form).attr("action"), $(form).serialize())
            .done(function (resp) {
                if (resp.estatus) {
                    tablaFechas.bootstrapTable('updateByUniqueId', {
                        id: resp.diaFestivoFecha.dia_festivo_fecha_id,
                        row: resp.diaFestivoFecha
                    });
                    swal.fire("Se editó correctamente", "", "success");
                    modalEditarFecha.modal("hide");
                    selectEditarDiaFestivo.val("").trigger("change");
                    formEditarFecha.trigger("reset");
                    validatorFormEditarFecha.resetForm();
                } else {
                    swal.fire(resp.mensaje, "", "error");
                }
            }).fail(function(jqXHR, textStatus, error) {
                swal.fire("", error, "error");
            }).always(function() {
                KTApp.unblockPage();
            }); 
    }
});
// CONFIGURACIÓN TABLA
const tablaFechas = $("#tabla_fechas");
function fechaFormatter(value, row) {
    return moment(value).format("DD-MM-Y")
}
function accionesFormatter(value, row) {
    return `<button class="btn btn-outline-primary btn-icon editar-fecha" data-toggle="tooltip" title="Editar fecha">
        <i class="fas fa-edit"></i>
    </button>`;
}  
var operateEventsAcciones = {
    'click .editar-fecha': function (e, value, row, index) {
        modalEditarFecha.data("fechaDiaFestivo", row);
        modalEditarFecha.modal("show");
    }
}
tablaFechas.bootstrapTable({data: fechas});