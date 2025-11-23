<?php

use App\Http\Controllers\p19_incentivos_empleado_mes\IncentivosEmpleadoMesController;
use App\Http\Controllers\p19_incentivos_empleado_mes\ReporteIncentivoController;

Route::group(['prefix' => 'procesos/incentivos-empleado-mes'], function(){

    // TAREAS
    Route::get('descripcion', [IncentivosEmpleadoMesController::class, "descripcion"])
        ->name('incentivos.empleado.mes.descripcion')
        ->middleware('role:ADMN_INC_19|SUPER_ADMIN');

    Route::post('iniciar-proceso', [IncentivosEmpleadoMesController::class, "iniciarProceso"])
        ->name('incentivos.empleado.mes.iniciar.proceso')
        ->middleware('role:ADMN_INC_19|SUPER_ADMIN');

	// Mostrar tarea T01
	Route::get('{incentivoEmpleadoMes}/{instanciaTarea}/seleccion-quincena-pago', [IncentivosEmpleadoMesController::class, "seleccionarQuincenaPago"])
        ->name('incentivos.empleado.mes.seleccion.quincena.pago')
        ->middleware('role:ADMN_INC_19|SUPER_ADMIN');

    Route::post('{incentivoEmpleadoMes}/{instanciaTarea}/seleccion-quincena-pago', [IncentivosEmpleadoMesController::class, "seleccionarQuincenaPago"])
        ->middleware('role:ADMN_INC_19|SUPER_ADMIN');

    // Mostrar tarea T02
	Route::get('{incentivoEmpleadoMes}/{instanciaTarea}/asignacion-premios-por-unidad', [IncentivosEmpleadoMesController::class, "asignarPremiosPorUnidad"])
        ->name('incentivos.empleado.mes.asignacion.premios.por.unidad')
        ->middleware('role:ADMN_INC_19|SUPER_ADMIN');

    Route::post('{incentivoEmpleadoMes}/{instanciaTarea}/asignacion-premios-por-unidad', [IncentivosEmpleadoMesController::class, "asignarPremiosPorUnidad"])
        ->middleware('role:ADMN_INC_19|SUPER_ADMIN');

    // Mostrar tarea T03
	Route::get('{incentivoEmpleadoMes}/{instanciaTarea}/revision-solicitudes-premio', [IncentivosEmpleadoMesController::class, "revisionSolicitudesPremio"])
        ->name('incentivos.empleado.mes.revision.solicitudes.premio')
        ->middleware('role:ADMN_INC_19|SUPER_ADMIN');

    Route::post('{incentivoEmpleadoMes}/{instanciaTarea}/revision-solicitudes-premio', [IncentivosEmpleadoMesController::class, "revisionSolicitudesPremio"])
        ->middleware('role:ADMN_INC_19|SUPER_ADMIN');

    // Mostrar tarea T04
	Route::get('{incentivoEmpleadoMes}/{instanciaTarea}/generacion-archivos-pago', [IncentivosEmpleadoMesController::class, "generacionArchivosPago"])
        ->name('incentivos.empleado.mes.generar.archivos.pago')
        ->middleware('role:ADMN_INC_19|SUPER_ADMIN');

    Route::post('{incentivoEmpleadoMes}/{instanciaTarea}/generacion-archivos-pago', [IncentivosEmpleadoMesController::class, "generacionArchivosPago"])
        ->middleware('role:ADMN_INC_19|SUPER_ADMIN');

    // SUBTAREAS

    // Mostrar Subtarea ST01
	Route::get('{subproceso}/{instanciaTarea}/subproceso-distribucion-premios-subareas', [IncentivosEmpleadoMesController::class, "subprocesoDistribucionPremiosSubareas"])
        ->name('incentivos.empleado.mes.subproceso.distribucion.premios.subarea')
        ->middleware('role:OPER_INC_19|SUB_EA|SUPER_ADMIN');

    Route::post('{subproceso}/{instanciaTarea}/subproceso-distribucion-premios-subareas', [IncentivosEmpleadoMesController::class, "subprocesoDistribucionPremiosSubareas"])
        ->middleware('role:OPER_INC_19|SUB_EA|SUPER_ADMIN');

    // Mostrar Subtarea ST02
	Route::get('{subproceso}/{instanciaTarea}/subproceso-asignacion-premios-empleado', [IncentivosEmpleadoMesController::class, "subprocesoAsigancionPremiosEmpleado"])
        ->name('incentivos.empleado.mes.subproceso.asignacion.premios.empleado')
        ->middleware('role:OPER_INC_19|SUB_EA|SUPER_ADMIN');

    Route::post('{subproceso}/{instanciaTarea}/subproceso-asignacion-premios-empleado', [IncentivosEmpleadoMesController::class, "subprocesoAsigancionPremiosEmpleado"])
        ->middleware('role:OPER_INC_19|SUB_EA|SUPER_ADMIN');

    // Método Realiza la Evaluación de Asistencias del Empleado parte de la ST02
    Route::post('subproceso-asignacion-premios-empleado-evaluacion', [IncentivosEmpleadoMesController::class, "subprocesoAsigancionPremiosEmpleadoEvaluacion"])
        ->name('incentivos.empleado.mes.subproceso.asignacion.premios.empleado.evaluacion')
        ->middleware('role:OPER_INC_19|SUB_EA|SUPER_ADMIN');

    // Método Agregar Empleado a la P19Nomina parte de la ST02
    Route::post('subproceso-asignacion-premios-empleado-agregra-empleado', [IncentivosEmpleadoMesController::class, "subprocesoAsigancionPremiosEmpleadoAgregarEmpleado"])
        ->name('incentivos.empleado.mes.subproceso.asignacion.premios.empleado.agregra.empleado')
        ->middleware('role:OPER_INC_19|SUB_EA|SUPER_ADMIN');

    // Método Eliminar Empleado a la P19Nomina parte de la ST02
    Route::post('subproceso-asignacion-premios-empleado-eliminar-empleado', [IncentivosEmpleadoMesController::class, "subprocesoAsigancionPremiosEmpleadoEliminarEmpleado"])
        ->name('incentivos.empleado.mes.subproceso.asignacion.premios.empleado.eliminar.empleado')
        ->middleware('role:OPER_INC_19|SUB_EA|SUPER_ADMIN');

    // Método Generar Reporte Empleado parte de la ST02
    Route::get('subproceso-asignacion-premios-empleado-reporte-empleado/{empleadoNomina?}', [IncentivosEmpleadoMesController::class, "subprocesoAsigancionPremiosEmpleadoGenerarReporteEmpleado"])
        ->name('incentivos.empleado.mes.subproceso.asignacion.premios.empleado.reporte.empleado')
        ->middleware('role:OPER_INC_19|SUB_EA|SUPER_ADMIN');

    // Mostrar Subtarea ST03
	Route::get('{subproceso}/{instanciaTarea}/subproceso-autorizacion-solicitudes', [IncentivosEmpleadoMesController::class, "subprocesoAutorizacionSolicitudes"])
        ->name('incentivos.empleado.mes.subproceso.autorizacion.solicitudes')
        ->middleware('role:OPER_INC_19|SUB_EA|SUPER_ADMIN');

    Route::post('{subproceso}/{instanciaTarea}/subproceso-autorizacion-solicitudes', [IncentivosEmpleadoMesController::class, "subprocesoAutorizacionSolicitudes"])
        ->middleware('role:OPER_INC_19|SUB_EA|SUPER_ADMIN');

    // NOTIFICACIONES

    // Mostrar notificación TNOTA01
	Route::get('{incentivoEmpleadoMes}/{instanciaTarea}/notificacion-listado-solicitantes-premio-incentivo-subea', [IncentivosEmpleadoMesController::class, "notificacionListadoSolicitantesPremioIncentivoSubea"])
        ->name('incentivos.empleado.mes.notificacion.listado.solicitantes.premio.incentivo.subea')
        ->middleware('role:SUB_EA|OPER_INC_19|SUPER_ADMIN');

    Route::post('{incentivoEmpleadoMes}/{instanciaTarea}/notificacion-listado-solicitantes-premio-incentivo-subea', [IncentivosEmpleadoMesController::class, "notificacionListadoSolicitantesPremioIncentivoSubea"])
        ->middleware('role:SUB_EA|OPER_INC_19|SUPER_ADMIN');

    // Mostrar notificación TNOTA02
    Route::get('{incentivoEmpleadoMes}/{instanciaTarea}/notificacion-listado-solicitantes-premio-incentivo-operinc19', [IncentivosEmpleadoMesController::class, "notificacionListadoSolicitantesPremioIncentivoOperinc19"])
        ->name('incentivos.empleado.mes.notificacion.listado.solicitantes.premio.incentivo.operinc19')
        ->middleware('role:SUB_EA|OPER_INC_19|SUPER_ADMIN');

    Route::post('{incentivoEmpleadoMes}/{instanciaTarea}/notificacion-listado-solicitantes-premio-incentivo-operinc19', [IncentivosEmpleadoMesController::class, "notificacionListadoSolicitantesPremioIncentivoOperinc19"])
        ->middleware('role:SUB_EA|OPER_INC_19|SUPER_ADMIN');

    // FORMATOS

    // Ruta para descargar EXCEL de las Incidencias empledos del mes en T04
    Route::get('formato-generacion-concentrado-incentivo-empleados-mes-excel/{incentivoEmpleadoMes}', [IncentivosEmpleadoMesController::class, "generarExcelFormatoGeneracionConcentradoIncentivoEmpleadosMes"])
        ->name('incentivos.empleado.mes.formato.generacion.concentrado.incentivo.empleados.mes.excel')
        ->middleware('role:ADMN_INC_19|SUPER_ADMIN');

    // Ruta para descargar PDF de las Incidencias empledos del mes en T04
    Route::get('formato-generacion-concentrado-incentivo-empleados-mes-pdf/{incentivoEmpleadoMes}', [IncentivosEmpleadoMesController::class, "generarPDFFormatoGeneracionConcentradoIncentivoEmpleadosMes"])
        ->name('incentivos.empleado.mes.formato.generacion.concentrado.incentivo.empleados.mes.pdf')
        ->middleware('role:ADMN_INC_19|SUPER_ADMIN');

    // REPORTES

    // Reporte 1
    Route::get('reporte-ejecutivo-incentivo-empleado-mes', [ReporteIncentivoController::class, "reporteEjecutivoIncentivoEmpleadoMes"])
        ->name('reporte.ejecutivo.incentivo.empleado.mes')
        ->middleware('role:SUB_EA|OPER_INC_19|SUPER_ADMIN');

    Route::post('reporte-ejecutivo-incentivo-empleado-mes', [ReporteIncentivoController::class, "reporteEjecutivoIncentivoEmpleadoMes"])
        ->middleware('role:SUB_EA|OPER_INC_19|SUPER_ADMIN');

    Route::post('reporte-ejecutivo-incentivo-empleado-mes-buscar', [ReporteIncentivoController::class, "reporteEjecutivoIncentivoEmpleadoMesBuscar"])
        ->name('reporte.ejecutivo.incentivo.empleado.mes.buscar')
        ->middleware('role:SUB_EA|OPER_INC_19|SUPER_ADMIN');

	Route::get('reporte-ejecutivo-incentivo-empleado-mes-pdf/{fechaInicio?}/{fechaFinal?}', [ReporteIncentivoController::class, "reporteEjecutivoIncentivoEmpleadoMesDescargar"])
        ->name('reporte.ejecutivo.incentivo.empleado.mes.descargar')
        ->middleware('role:SUB_EA|OPER_INC_19|SUPER_ADMIN');


    Route::get('reporte-relacion-empleados-incentivo-empleado-mes', [ReporteIncentivoController::class, "reporteRelacionEmpleadosIncentivoEmpleadoMes"])
        ->name('reporte.relacion.empleados.incentivo.empleado.mes')
        ->middleware('role:SUB_EA|OPER_INC_19|SUPER_ADMIN');

    Route::post('reporte-relacion-empleados-incentivo-empleado-mes', [ReporteIncentivoController::class, "reporteRelacionEmpleadosIncentivoEmpleadoMes"])
        ->middleware('role:SUB_EA|OPER_INC_19|SUPER_ADMIN');

    Route::post('reporte-relacion-empleados-incentivo-empleado-mes-buscar', [ReporteIncentivoController::class, "reporteRelacionEmpleadosIncentivoEmpleadoMesBuscar"])
        ->name('reporte.relacion.empleados.incentivo.empleado.mes.buscar')
        ->middleware('role:SUB_EA|OPER_INC_19|SUPER_ADMIN');

	Route::get('reporte-relacion-empleados-incentivo-empleado-mes-pdf/{fechaInicio?}/{fechaFinal?}', [ReporteIncentivoController::class, "reporteRelacionEmpleadosIncentivoEmpleadoMesDescargar"])
        ->name('reporte.relacion.empleados.incentivo.empleado.mes.descargar')
        ->middleware('role:SUB_EA|OPER_INC_19|SUPER_ADMIN');


    Route::get('reporte-concentrado-incentivo-empleado-mes', [ReporteIncentivoController::class, "reporteConcentradoIncentivoEmpleadoMes"])
        ->name('reporte.concentrado.incentivo.empleado.mes')
        ->middleware('role:SUB_EA|OPER_INC_19|SUPER_ADMIN');

    Route::post('reporte-concentrado-incentivo-empleado-mes', [ReporteIncentivoController::class, "reporteConcentradoIncentivoEmpleadoMes"])
        ->middleware('role:SUB_EA|OPER_INC_19|SUPER_ADMIN');

    Route::post('reporte-concentrado-incentivo-empleado-mes-buscar', [ReporteIncentivoController::class, "reporteConcentradoIncentivoEmpleadoMesBuscar"])
        ->name('reporte.concentrado.incentivo.empleado.mes.buscar')
        ->middleware('role:SUB_EA|OPER_INC_19|SUPER_ADMIN');

	Route::get('reporte-concentrado-incentivo-empleado-mes-pdf/{fechaInicio?}/{fechaFinal?}', [ReporteIncentivoController::class, "reporteConcentradoIncentivoEmpleadoMesDescargar"])
        ->name('reporte.concentrado.incentivo.empleado.mes.descargar')
        ->middleware('role:SUB_EA|OPER_INC_19|SUPER_ADMIN');

});
