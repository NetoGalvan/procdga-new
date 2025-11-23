const formFinalizarTarea = $("#form_carga_alfabetico");
let dropzoneCargarAlfabetico = null;
const contenedorTablaTXT = $('#contenedor_tabla_txt');
const contenedorDropzoneTXT = $('#contenedor_dropzone_txt');
const btnCancelarProceso = $('#btn_cancelar_seleccion_servicio');
const selectQuincena = $("#quincena");

$(document).ready(function () {

    // Si existe el Archivo se carga en la tabla
    controlaDropZoneYTablaTXT(archivos);

    selectQuincena.select2({
        placeholder: "Selecciona una opción"
    });
});

function eliminarTXTFormatter(value, row) {
    return '<div class="d-flex justify-content-center"> <button type="button" class="btn btn-outline-danger btn-icon" onclick="eliminarTXTArchivo('+row.archivo_id+')" data-toggle="tooltip" data-placement="top" title="Eliminar" > <i class="fas fa-trash-alt"></i> </button> </div>'
}

function eliminarTXTArchivo(archivo_id) {
    Swal.fire({
        title: 'Eliminar',
        text: "¿Esta seguro(a) de eliminar este archivo?",
        icon: 'question',
        showCancelButton: true,
        cancelButtonColor: '#F64E60',
        cancelButtonText: 'No',
        confirmButtonColor: '#0BB7AF',
        confirmButtonText: 'Si'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: urlEliminarTXT,
                data: { archivo_id },
                success: function (response) {
                    if ( response.estatus ) {
                        // Si se elimino correctamente se manda falso para indicar que no hay archivo
                        controlaDropZoneYTablaTXT(false);
                        Swal.fire({
                            text: response.mensaje,
                            icon: 'success',
                            confirmButtonColor: '#0BB7AF',
                            confirmButtonText: 'Ok'
                        })
                    }
                    else {
                        Swal.fire({
                            html: response.mensaje,
                            icon: 'warning',
                            confirmButtonColor: '#0BB7AF',
                            confirmButtonText: 'Ok'
                        });
                    }
                }
            });
        }
    })
}

const validatorFormFinalizarTarea = formFinalizarTarea.validate({
    submitHandler: function(form) {
        let existeArchivo = document.querySelector('table');
        if ( existeArchivo ) {
            Swal.fire({
                title: "¿Está seguro?",
                text: "Antes de continuar, verifique que los datos ingresados sean correctos. Después de finalizar, no podrá regresar.",
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
                title: "Archivo",
                html: "!Debes cargar un archivo, para finalizar carga¡",
                icon: 'warning',
                confirmButtonColor: '#0BB7AF',
                confirmButtonText: 'Ok'
            });
        }
    }
});

btnCancelarProceso.click(function (e) {
    e.preventDefault();
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
            $("#form_carga_alfabetico").append(`<input type="hidden" name="accion" value="cancelar">`);
            $("#form_carga_alfabetico")[0].submit();
        }
    });
});


function inicializardropZone() {
    // Url para cargar alfabético en la DB
    const urlCargarAlfabetico = $('#id_dropzone_cargar_alfabetico').data('url');
    dropzoneCargarAlfabetico = new Dropzone('#id_dropzone_cargar_alfabetico', {
        headers : {
            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        },
        url: urlCargarAlfabetico,
        method: 'POST',
        paramName: "file",
        uploadMultiple: true,
        maxFiles: 1,
        parallelUploads: 1,
        acceptedFiles: ".txt",
        maxFilesize: 10,
        dictMaxFilesExceeded: "Solo puedes subir 1 archivo",
        addRemoveLinks: true,
        // autoProcessQueue: false,
        autoProcessQueue: true,
        accept: function(file, done) {
            done();
            KTApp.blockPage({
                overlayColor: '#000000',
                state: 'danger',
                message: 'Por favor, espere...'
            });
        }
    });

    dropzoneCargarAlfabetico.on("error", function(file, error, xhr) {
        dropzoneCargarAlfabetico.removeFile(file)
        Swal.fire({
            title: "",
            html: error,
            icon: 'warning',
            confirmButtonColor: '#0BB7AF',
            confirmButtonText: 'Ok'
        });
    });

    dropzoneCargarAlfabetico.on("removedfile", function(file) {
        Swal.fire({
            title: "",
            html: "Se elimino el archivo correctamente",
            icon: 'warning',
            confirmButtonColor: '#0BB7AF',
            confirmButtonText: 'Ok'
        });
    });

    dropzoneCargarAlfabetico.on("sending", function(file, xhr, formData) {
        /* formData.append("nombre_documento", 'NOMBRE');
        formData.append("tipo_documento_expediente", 'TIPODOC'); */
    });

    dropzoneCargarAlfabetico.on("success", function(file, response) {
        if (response.estatus) {
            controlaDropZoneYTablaTXT(response.archivo);
            Swal.fire({
                title: "",
                html: response.mensaje,
                icon: 'success',
                confirmButtonColor: '#0BB7AF',
                confirmButtonText: 'Ok'
            });
        } else {
            dropzoneCargarAlfabetico.removeFile(file);
            file.status = Dropzone.QUEUED
            file.upload.progress = 0;
            file.upload.bytesSent = 0;
            Swal.fire({
                title: "",
                html: response.mensaje,
                icon: 'warning',
                confirmButtonColor: '#0BB7AF',
                confirmButtonText: 'Ok'
            });
        }
    });

    dropzoneCargarAlfabetico.on("complete", function(file, response) {
        KTApp.unblockPage();
    });
}

// Metodo para validar si muestra el DropZone o la tabla
function controlaDropZoneYTablaTXT(archivos) {
    // Si existe archivo se renderiza tabla y se remueve el dropzone
    if ( archivos ){
        contenedorDropzoneTXT.html(``);
        contenedorTablaTXT.html(`
            <div class="table-responsive">
                <table id="table_alfabetico" class="text-center" data-toggle="table" data-toolbar="#toolbar">
                    <thead>
                        <tr>
                            <th data-field="archivo_id" data-width="50"><label class="titulo-dato">Id</label></th>
                            <th data-field="nombre_archivo"><label class="titulo-dato">Archivo</label></th>
                            <th data-field="fecha_carga"><label class="titulo-dato">Fecha de carga</label></th>
                            <th data-field="cantidad_empleados"><label class="titulo-dato">Cantidad empleados</label></th>
                            <th data-formatter="eliminarTXTFormatter"><label class="titulo-dato">Acciones</label></th>
                        </tr>
                    </thead>
                </table>
            </div>
        `);
        $('#table_alfabetico').bootstrapTable("destroy");
        $('#table_alfabetico').bootstrapTable({data: [archivos]});
    } else {
        // Si no existe ningun archivo se renderiza el dropzone y se remueve la tabla
        contenedorTablaTXT.html(``);
        contenedorDropzoneTXT.html(`
            <div
                class="dropzone dropzone-default dropzone-success"
                id="id_dropzone_cargar_alfabetico"
                enctype="multipart/form-data"
                data-url="${urlDropZone}">
                <div class="dropzone-msg dz-message needsclick">
                    <h3 class="dropzone-msg-title"> <i class="fas fa-upload" aria-hidden="true"></i> Cargar alfabético</h3>
                    <span class="dropzone-msg-desc">Sólo se acepta un archivo en formato .txt</span>
                </div>
            </div>
        `)
        inicializardropZone();
    }
}
