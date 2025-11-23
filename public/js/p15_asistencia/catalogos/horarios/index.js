const tablaHorarios = $('#table_horarios');
       
tablaHorarios.bootstrapTable({data: horarios});

function accionesFormatter(value, row) {
    let botones =  `<a
                        href="${row.ruta_editar}"
                        class="btn btn-outline-primary btn-icon"
                        data-toggle="tooltip"
                        title="Editar">
                        <i class="fas fa-edit"></i>
                    </a>`;
    return botones;
}

function diasFormatter(value, row) {
    const semana = ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"];
    let diasLaborales =  '';
    value.split('').forEach(function(dia, indice) {
        if (dia == 1) {
            diasLaborales += `${semana[indice]}, `;
        }
    });
    return diasLaborales.trim().replace(/^,|,$/g, '');
}

function horarioFormatter(value, row) {
    let horario = row.entrada.substring(0, 5);
    if (row.salida) {
       horario += ` - ${row.salida.substring(0, 5)}`;  
    }
    return horario;
}

function intervaloFormatter(value, row) {
    return value ? `${value.inicio.substring(0, 5)} - ${value.final.substring(0, 5)}` : `<span class="badge badge-secondary">N/A<span>`;
}

function aplicaDiasFestivosFormatter(value, row) {
    return value ? "SI" : "NO";
}

function tipoEmpleadoFormatter(value, row) {
    return value.replace(/_/g, " ");
}

function tipoHorarioFormatter(value, row) {
    return value ? `<span class="badge badge-success" style="white-space:nowrap;"><i class="fas fa-lock text-white icon-nm mr-1"></i> BASE</span>` :
        `<span class="badge badge-primary" style="white-space:nowrap;"><i class="fas fa-user-clock text-white icon-nm mr-1"></i> GENERAL</span>`;
}

function activoFormatter(value, row) {
    if (value) {
        return `<span class="badge badge-success"><i class="far fa-check-circle text-white icon-nm mr-1"></i> ACTIVO</span>`;
    } else {
		return `<span class="badge badge-danger"><i class="fas fa-times text-white icon-nm mr-1"></i> INACTIVO</span>`;
	}
}