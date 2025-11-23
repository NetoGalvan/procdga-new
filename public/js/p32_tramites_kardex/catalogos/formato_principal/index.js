
const inputLogoPrimario = $("#logo_primario");
const contenedorCropper = $("#contenedor_cropper");

inputLogoPrimario.change(function() {
    var oFReader = new FileReader();
    oFReader.readAsDataURL(this.files[0]);
    oFReader.onload = function (oFREvent) {
        // Replace url
        inputLogoPrimario
            .parent()
            .after(`
                <div class="mt-4" id="contenedor_cropper">
                    <img id="img_logo_primario" src="${this.result}" style="max-width:100%" alt=""/>
                </div>`);

        // Start cropper
        cropper = new Cropper($("#img_logo_primario")[0], {
            /* aspectRatio: "free", */
            movable: false,
            /* zoomable: false, */
            rotatable: false,
            /* scalable: false, */
            crop: function(e) {}
        });
    };
});

tinymce.init({
	selector: '#formato_header',
    force_br_newlines : true,
    force_p_newlines : false,
    forced_root_block : false,
	statusbar: false,
    toolbar: false,
    menubar: false,
	language : 'es_MX',
});

tinymce.init({
	selector: '#formato_footer',
    force_br_newlines : true,
    force_p_newlines : false,
    forced_root_block : false,
	statusbar: false,
    toolbar: false,
    menubar: false,
	language : 'es_MX',
});


$("#guardar_atributos_formato").click(function(e) {
    e.preventDefault();

    let thisBtn = $(this);
    let imagenSeleccionada = $("#img_logo_primario").length > 0 ? cropper.getCroppedCanvas().toDataURL("image/png") : "";
    let tipoImagen = $('#tipo_imagen').val();

    if ( imagenSeleccionada && !tipoImagen ) {
        Swal.fire("Debe seleccionar la posición donde se colocará la imagen", "", "warning");
    }
    else if ( !imagenSeleccionada && tipoImagen ) {
        Swal.fire("Debe seleccionar una imagen", "", "warning");
    } else {
        Swal.fire({
            title: "Formato",
            text: "¿Esta seguro de actualizar el formato?",
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
                let request = {};
                request["formato_logo_primario"] = imagenSeleccionada;
                request["formato_header"] = tinymce.get("formato_header").getContent();
                request["formato_footer"] = tinymce.get("formato_footer").getContent();
                request["tipo_imagen"] = tipoImagen;
                $.post(thisBtn.data("url"), request, function(resp) {
                    if (resp.estatus) {
                        Swal.fire("El formato general se ha actualizado correctamente", "", "success");
                        $("#contenedor_cropper").remove();
                        $(".custom-file-label").text('ELEGIR ARCHIVO');
                        $("#formato_base").attr("src", `data:application/pdf;base64,${resp.formatoBase}`);
                        $("#tipo_imagen").val("");
                    } else {
                        Swal.fire(resp.mensaje, "", "warning");
                    }
                })
                .fail(function(jqXHR, textStatus, errorThrown) {
                    Swal.fire("Error", "Ocurrió un error al actualizar el formato", "error");
                })
                .always(function() {
                    KTApp.unblockPage();
                });;

            }
        });
    }

});
