const inputCP = $(".cp");
const selectColonia = $(".colonia");
const selectEntidadFederativa = $(".entidad-federativa");

selectColonia.select2({
    placeholder: "Seleccionar una colonia",
	tags: true
});

selectEntidadFederativa.select2({
    placeholder: "Seleccionar una entidad"
});

inputCP.focusout(function (e) {
	let selectEntidad = $(this).closest('.contenedor-direccion').find('.entidad-federativa');
	let selectColonia = $(this).closest('.contenedor-direccion').find('.colonia');
	let inputCiudad = $(this).closest('.contenedor-direccion').find('.ciudad');
	let inputMunicipioAlcaldia = $(this).closest('.contenedor-direccion').find('.municipio-alcaldia');
	let cp = $(this).val();
	let url = $(this).data("url");

	selectEntidad.val("").trigger("change");
	inputCiudad.val("");
	inputMunicipioAlcaldia.val("");
	selectColonia.find("option").remove();

	if (cp.length == 5) {
		$.get(url, {cp}, function(response) {
			if (response.status && response.asentamientos.length > 0) {
				selectEntidad.val(response.asentamientos[0].estado_id).trigger("click").trigger("change");
				inputCiudad.val(response.asentamientos[0].ciudad).trigger("keyup");
				inputMunicipioAlcaldia.val(response.asentamientos[0].municipio).trigger("keyup");

				selectColonia.append(new Option("Seleccione una opción", "", false, false));
				response.asentamientos.forEach(asentamiento => {
					var data = {
						id: asentamiento.asentamiento,
						text: asentamiento.asentamiento
					};
					
					var newOption = new Option(data.text, data.id, false, false);
					selectColonia.append(newOption).trigger('change');
				});
			}
		});
	} 
});
