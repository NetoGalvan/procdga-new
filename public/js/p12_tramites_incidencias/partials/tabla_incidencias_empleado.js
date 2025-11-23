function indiceFormatter(value, row, index) {
    return index + 1;
}
function tipoCapturaFormatter(value, row) {
    let tipoCaptura = `<div class="text-nowrap">`;
    if (value === "alta") {
        tipoCaptura += `<span class="badge badge-primary">ALTA<span>`;
    } else if (value === "alta_nb") {
        tipoCaptura += `<span class="badge badge-success">ALTA NB<span>`;
    }
    tipoCaptura += `</div">`;
    return tipoCaptura;
}
function fechaInicioFormatter(value, row) {
    return value ? moment(value).format("DD-MM-Y") : `<span class="badge badge-secondary">N/A</span>`;
}
function fechaFinalFormatter(value, row) {
    return value ? moment(value).format("DD-MM-Y") : `<span class="badge badge-secondary">N/A</span>`;
}
function fechasFormatter(value, row) {
    let fechas = `<div class="text-nowrap">`;
    if (["nota_buena_inasistencia", "nota_buena_retardo_leve", "nota_buena_retardo_grave"].includes(row.tipo_incidencia.tipo_justificacion.identificador)) {
        value.forEach(fecha => {
            fechas += `${moment(fecha).format("DD-MM-Y")} <br>`;
        });
    } else {
        fechas += `<strong>Inicio:</strong> ${moment(row.fecha_inicio).format("DD-MM-Y")} <br> 
            <strong>Final:</strong> ${moment(row.fecha_final).format("DD-MM-Y")}`;
    }
    fechas += `</div>`; 
    return fechas;
}
function notasBuenasFormatter(value, row) {
    if (value.length > 0) {
        tabla = `<table class="font-size-10 w-100"><tbody>`
        value.forEach((notaBuena) => {
            tabla += `<tr>
                <td><div class="text-nowrap">
                    <strong>Periodo:</strong> ${notaBuena.periodo} <br> 
                    <strong>Tipo:</strong> ${notaBuena.tipo.replace(/_/g, " ")} 
                </div></td>
            </tr>`;
        });            
        tabla += `</tbody></table>`; 
        return tabla;
    } 
    return `<span class="badge badge-secondary">N/A</span>`;
}
function horarioFormatter(value, row) {
    if (row.tipo_incidencia.tipo_justificacion.identificador == "cambio_horario") {
        let horario = `<div class="text-nowrap font-size-10">
            <strong>Entrada:</strong> ${row.horario.entrada.substring(0, 5)} <br>
            <strong>Salida:</strong> ${row.horario.salida ? row.horario.salida.substring(0, 5) : `<span class="badge badge-secondary">N/A</span>`}<br>`;  
        let dias = `<strong>Días loborales: </strong>`;
        row.horario.dias_formato_string.forEach((dia, index) => {
            if (row.horario.dias_formato_string.length > 2 && index == 1) {
                dias += `${dia}<br>`;
            } else {
                dias += `${dia} `;
            }
        });
        horario += dias.trim();
        if (row.horario.dias_festivos_son_laborales) {
            horario += `<br> Días Festivos`;
        }
        horario += `<br><strong>Tipo empleado:</strong> ${row.horario.tipo_empleado.replace(/_/g, " ")}</div>`;
        return horario;
    }    
    return `<span class="badge badge-secondary">N/A</span>`;
}
function numeroDocumentoFormatter(value, row) {
    let documento = `<div class="text-nowrap">`;
    documento += value ?? `<span class="badge badge-secondary">N/A</span>`;
    documento += `</div>`; 
    return documento;
}
function totalDiasFormatter(value, row) {
    return value ?? `<span class="badge badge-secondary">N/A</span>`;
}
function tipoJustificacionFormatter(value, row) {
    let tipoIncidencia = value.nombre;
    return tipoIncidencia;
}
function descripcionFormatter(value, row) {
    return value ??`<span class="badge badge-secondary">N/A</span>`;
}
function articuloFormatter(value, row) {
    return value ??`<span class="badge badge-secondary">N/A</span>`;
}
function subarticuloFormatter(value, row) {
    return value ??`<span class="badge badge-secondary">N/A</span>`;
}
function unicaVezFormatter(value, row) {
    return value ? `<span class="badge badge-success">SÍ<span>` : `<span class="badge badge-danger">NO<span>`;
}
function diasFormatter(value, row) {
    return value ? `<span class="badge badge-success">${value} días<span>` : `<span class="badge badge-secondary">N/A</span>`;
}
function anioFormatter(value, row) {
    return value ? `<span class="badge badge-success">${value}<span>` : `<span class="badge badge-secondary">N/A</span>`;
}
function intervaloEvaluacionFormatter(value, row) {
    return value.replace(/_/g, " ");
}
function tipoEmpleadoFormatter(value, row) {
    return value.replace(/_/g, " ");
}
function unidadAdministrativaFormatter(value, row) {
    return `${row.unidad_administrativa} ${row.unidad_administrativa_nombre}`;
}
function sexoFormatter(value, row) {
    if (value == "M") return "MASCULINO";
    if (value == "F") return "FEMENINO";
    return value;
}
function folioCancelacionFormatter(value, row) {
    return value ??`<span class="badge badge-secondary">N/A</span>`;
}
function observacionesReporteFormatter(value, row) {
    return value ??`<span class="badge badge-secondary">N/A</span>`;
}
function estatusFormatter(value, row) {
    let estatus = `<div class="text-nowrap">`;
    if (value === "AUTORIZADO") {
        estatus += `<span class="badge badge-success"><i class="fas fa-check icon-nm text-white"></i> AUTORIZADO<span>`;
    } else if (value === "CANCELADO") {
        estatus += `<span class="badge badge-danger"><i class="fas fa-times icon-nm text-white"></i> CANCELADO<span>`;
    }
    estatus += `</div">`;
    return estatus;
}