const tablaAlfabetico = $("#tabla_alfabetico");
const tablaEmpleados = $("#tabla_empleados");

$(document).ready(function () {
    if ( alfabeticos.length > 0 ){
        tablaAlfabetico.bootstrapTable("destroy");
        tablaAlfabetico.bootstrapTable({data: alfabeticos});
    } else {
        tablaAlfabetico.bootstrapTable();
    }
    if ( empleados.length > 0 ){
        tablaEmpleados.bootstrapTable("destroy");
        tablaEmpleados.bootstrapTable({data: empleados});
    } else {
        tablaEmpleados.bootstrapTable();
    }
});

function quincenaFormatter(value, row) {
    let quincena = value ? value : 'EN PROCESO';
    return quincena;
}
function archivoCargadoFormatter(value, row) {
    let archivo = value ? value : 'EN PROCESO';
    return archivo;
}
function fechaFormatter(value, row) {
    let fecha = value ? value : 'EN PROCESO';
    return fecha;
}
function cantidadEmpleadosFormatter(value, row) {
    let cantidad = value ? value : 'EN PROCESO';
    return cantidad;
}

function estatusFormatter(value, row) {
    if (value == 'EN_PROCESO') {
        return `<span class="badge badge-primary"><i class="fas fa-spinner icon-nm text-white mr-1"></i> EN PROCESO </span>`;
    } else if (value == 'COMPLETADO') {
        return `<span class="badge badge-success"><i class="far fa-check-circle icon-nm text-white mr-1"></i> COMPLETADO </span>`;
	} else {
		return `<span class="badge badge-warning"><i class="far fa-times-circle icon-nm text-secondary mr-1"></i> PENDIENTE </span>`;
	}
}

function estatusEmpleadoFormatter(value, row) {
    if (value) {
        return `<span class="badge badge-success"><i class="far fa-check-circle icon-nm text-white mr-1"></i> ACTIVO </span>`;
	} else {
		return `<span class="badge badge-danger"><i class="far fa-times-circle icon-nm text-white mr-1"></i> INACTIVO </span>`;
	}
}

function cargadoPorFormatter(value, row) {
    let cargadoPor = 'EN PROCESO'
    if (row.archivo_sin_json) {
        cargadoPor = `${row.archivo_sin_json?.cargado_por_usuario.nombre} ${row.archivo_sin_json?.cargado_por_usuario.apellido_paterno} ${row.archivo_sin_json?.cargado_por_usuario.apellido_materno}`;
    }
    return cargadoPor;
}

function accionesFormatter(value, row, index) {
    let { estatus } = row;
    if ( estatus === 'COMPLETADO') {
        return '<div class="d-flex justify-content-center"> <i class="fas fa-check text-success" data-toggle="tooltip" data-placement="top" title="Completado"></i> </div>';
    } else {
        let alfabetico = row.alfabetico_id;
        let rutaFinal = ruta.replace(':alfabetico_js', alfabetico);
        return '<div class="d-flex justify-content-center"> <a type="button" class="btn btn-outline-primary btn-icon" href="' + rutaFinal + '" data-toggle="tooltip" data-placement="top" title="Ver Trámite" ><i class="fas fa-edit"></i></a> </div>';
    }
}

function nombreEmpleadoFormatter(value, row, index) {
    let { nombre, apellido_paterno, apellido_materno } = row;

    if ( nombre ) {
        return `${apellido_paterno ? apellido_paterno : ''} ${apellido_materno ? apellido_materno : ''} ${nombre} `;
    } else {
        return `Pendiente`;
    }
}

function unidadAdministrativaFormatter(value, row, index) {
    return `${row.unidad_administrativa} - ${row.unidad_administrativa_nombre}`
}

function areaFormatter(v) {
    return v ? v : `<span class="badge badge-secondary">N/A</span>`;
}

function accionesEmpleadoFormatter(value, row, index) {
    let empleado = row.empleado_id;
    let rutaFinal = rutaEmpleado.replace(':empleado_js', empleado);
    return '<div class="d-flex justify-content-center"> <a type="button" class="btn btn-outline-primary btn-icon" href="' + rutaFinal + '" data-toggle="tooltip" data-placement="top" title="Ver Trámite" ><i class="fas fa-edit"></i></a> </div>';
}
