const contenedorCamposAdicionales = $("#contenedor_campos_adicionales");
const tablaCandidatos = $("#table_reg_candidatos");
const modalEditarCandidato = $("#modal_editar_candidato");
const btnEditarCandidato = $("#btn_editar_candidato");
const formEditarCandidato = $("#form_editar_candidato");
const inputCandidatoPrestacionId = $("#candidato_prestacion_id");
const inputNumeroEmpleado = $("#numero_empleado");
const inputNombreEmpleado = $("#nombre_empleado");
const inputApellidoPaterno = $("#apellido_paterno");
const inputApellidoMaterno = $("#apellido_materno");
const inputUnidadAdministrativa = $("#nombre_unidad");
const inputSeccionSindical = $("#seccion_sindical");
const inputRFC = $("#rfc");
const inputCURP = $("#curp");


validadorFormEditarCandidato = formEditarCandidato.validate({
	onfocusout: false,
	errorPlacement: function(label, element) {
		element.addClass('error');
		label.insertAfter(element);
	},
	onsubmit: false
});

function addClassesToFiledsCustom() {
    $('.input-date').datepicker({
        format : 'dd/mm/yyyy',
        autoclose : true,
        language : 'es'
    }).on('changeDate', function() {
        validadorFormEditarCandidato.element(this);
    });
    $(".normalizar-texto").on("change keyup input", function (e) {
        this.value = this.value.toUpperCase();
    });
}

function unidadAdministrativaFormatter(value, row) {
	let { area } = row;
	return area.nombre.toUpperCase();
}

function usuarioCapturaFormatter(value, row) {
	let { usuario_capturo } = row;
	return `${usuario_capturo?.nombre.toUpperCase()} ${usuario_capturo?.apellido_paterno.toUpperCase()} ${usuario_capturo?.apellido_materno.toUpperCase()}`;
}

function usuarioAutorizacionFormatter(value, row) {
	let { usuario_autorizo } = row;
	return `${usuario_autorizo?.nombre.toUpperCase()} ${usuario_autorizo?.apellido_paterno.toUpperCase()} ${usuario_autorizo?.apellido_materno.toUpperCase()}`;
}

function accionesFormatter(value, row) {
    btnEditar = `<a href="#" class="btn btn-icon btn-light btn-hover-primary btn-sm mx-3 btn-editar">
        <span class="svg-icon svg-icon-md svg-icon-primary">
            <!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Communication/Write.svg-->
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <rect x="0" y="0" width="24" height="24"></rect>
                    <path d="M12.2674799,18.2323597 L12.0084872,5.45852451 C12.0004303,5.06114792 12.1504154,4.6768183 12.4255037,4.38993949 L15.0030167,1.70195304 L17.5910752,4.40093695 C17.8599071,4.6812911 18.0095067,5.05499603 18.0083938,5.44341307 L17.9718262,18.2062508 C17.9694575,19.0329966 17.2985816,19.701953 16.4718324,19.701953 L13.7671717,19.701953 C12.9505952,19.701953 12.2840328,19.0487684 12.2674799,18.2323597 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.701953, 10.701953) rotate(-135.000000) translate(-14.701953, -10.701953)"></path>
                    <path d="M12.9,2 C13.4522847,2 13.9,2.44771525 13.9,3 C13.9,3.55228475 13.4522847,4 12.9,4 L6,4 C4.8954305,4 4,4.8954305 4,6 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,13 C20,12.4477153 20.4477153,12 21,12 C21.5522847,12 22,12.4477153 22,13 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,6 C2,3.790861 3.790861,2 6,2 L12.9,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
                </g>
            </svg>
            <!--end::Svg Icon-->
        </span>
    </a>`;
    return btnEditar;
}

window.operateEvents = {
    'click .btn-editar': function (e, value, row, index) {
        inputCandidatoPrestacionId.val(row.candidato_prestacion_id);
        inputNumeroEmpleado.val(row.numero_empleado);
        inputNombreEmpleado.val(row.nombre_empleado);
        inputApellidoPaterno.val(row.apellido_paterno);
        inputApellidoMaterno.val(row.apellido_materno);
        inputUnidadAdministrativa.val(row.unidad_administrativa.identificador_unidad);
        inputSeccionSindical.val(row.seccion_sindical);
        inputRFC.val(row.rfc);
        inputCURP.val(row.curp);
        let estructuraConcurrente = row.subproceso.estructura_concurrente;

        contenedorCamposAdicionales.empty();
        for (let clave in estructuraConcurrente) {
            let nameInput = estructuraConcurrente[clave].name;
            let descInput = estructuraConcurrente[clave].desc;
            contenedorCamposAdicionales.append(`
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="${nameInput}" class="titulo-dato"><span class="requeridos">* </span> ${descInput} </label>
                        <input
                            class="form-control form-control-sm ${nameInput.lastIndexOf("fec") != -1 ? 'input-date' : 'normalizar-texto'}"
                            type="text"
                            name="${nameInput}"
                            id="${nameInput}"
                            value="${row.campos_adicionales[nameInput]}" />
                    </div>
                </div>
            `);
        }

        btnEditarCandidato.off('click');
        btnEditarCandidato.click(function() {
            estructuraConcurrente.forEach(field => {
                $(`#${field.name}`).rules("add", {required: true});
            });
            if (validadorFormEditarCandidato.form()) {
                Swal.fire({
                    title: "¿Está seguro de continuar?",
                    text: "Asegurese de que los datos ingresados son correctos",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Sí, continuar",
                    cancelButtonText: "Cancelar",
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {
                        var data = formEditarCandidato.serialize();
                        $.ajax({
                            type: "POST",
                            url: $(this).data("url"),
                            data: data,
                            success: function (response) {
                                if (response.status) {
                                    tablaCandidatos.bootstrapTable('updateByUniqueId', {
                                        id: response.candidato.candidato_prestacion_id,
                                        row: response.candidato
                                    })
                                    Swal.fire("Candidato editado con éxito", "", "success");
                                } else {
                                    Swal.fire(response.mensaje, "", "error");
                                }
                                modalEditarCandidato.modal("hide");
                            }
                        });
                    }
                });
            }
        });

        modalEditarCandidato.modal("show");
        addClassesToFiledsCustom();
    }
}

tablaCandidatos.bootstrapTable({data: candidatos});

const formFinalizarTarea = $("#form_finalizar_tarea");
formFinalizarTarea.validate({
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
