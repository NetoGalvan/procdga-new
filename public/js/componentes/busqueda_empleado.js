const selectEmpleados = $("#datos_empleado");
const rutaGetEmpleados = selectEmpleados.attr('ruta-get-empleados');

selectEmpleados.select2({
    placeholder: `Ingresar RFC o Número de empleado`,
    allowClear: true,
    maximumSelectionLength: 1,
    minimumInputLength: 4,
    maximumInputLength: 13,
    ajax: {
        url: rutaGetEmpleados,
        dataType: 'json',
        delay: 250,
        data: function (params) {
            return {
                searchText: params.term.toUpperCase(),
            };
        },
        processResults: function (data, params) {
            return {
                results: data.data,
            };
        },
        cache: true
    },
    escapeMarkup: function (markup) {
        return markup;
    }, 
    templateResult:  function (data) {
        if (data.text) {
            return data.text;
        } else {
            var state = `${data.nombre_completo} || ${data.rfc}`;

            if (data.numero_empleado !== null) {
                state += ` || ${data.numero_empleado}`
            }
            return state;
        }        
    },
    templateSelection: function (data) {
        if (data.nombre_completo) {
            var state = `${data.nombre_completo} || ${data.rfc}`;

            if (data.numero_empleado !== null) {
                state += ` || ${data.numero_empleado}`
            }

            return state;
        }
        return data.text;
    }
});