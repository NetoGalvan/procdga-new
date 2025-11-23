<?php

use App\Http\Controllers\p20_premio_puntualidad_asistencia\PremioPuntualidadAsistenciaController;
use App\Http\Controllers\p20_premio_puntualidad_asistencia\ReportePremioPAController;

Route::group(['prefix' => 'procesos/premio-puntualidad-asistencia'], function(){
	// Descripción
	Route::get('descripcion', [PremioPuntualidadAsistenciaController::class, "descripcion"])
		->name('premio.puntualidad.asistencia.descripcion')
		->middleware('role:ADMIN_PREMIO_PUNTUALIDAD|SUPER_ADMIN');

    Route::post('inicializar-proceso', [PremioPuntualidadAsistenciaController::class, "iniciarProceso"])
        ->name('premio.puntualidad.asistencia.iniciar.proceso')
        ->middleware('role:ADMIN_PREMIO_PUNTUALIDAD|SUPER_ADMIN');

	// Mostrar tarea 01
	Route::get('{premioPuntualidad}/{instanciaTarea}/seleccion-quincena-unidades-administrativas', [PremioPuntualidadAsistenciaController::class, "seleccionQuincena"])
        ->name('seleccion.quincena.unidades.administrativas')
        ->middleware('role:ADMIN_PREMIO_PUNTUALIDAD|SUPER_ADMIN');

    Route::post('{premioPuntualidad}/{instanciaTarea}/seleccion-quincena-unidades-administrativas', [PremioPuntualidadAsistenciaController::class, "seleccionQuincena"])
        ->middleware('role:ADMIN_PREMIO_PUNTUALIDAD|SUPER_ADMIN');

    // Mostrar tarea 02
	Route::get('{premioPuntualidad}/{instanciaTarea}/concentrado-revision-solicitudes', [PremioPuntualidadAsistenciaController::class, "concentradoRevision"])
        ->name('concentrado.revision.solicitudes')
        ->middleware('role:ADMIN_PREMIO_PUNTUALIDAD|SUPER_ADMIN');

    Route::post('{premioPuntualidad}/{instanciaTarea}/concentrado-revision-solicitudes', [PremioPuntualidadAsistenciaController::class, "concentradoRevision"])
        ->middleware('role:ADMIN_PREMIO_PUNTUALIDAD|SUPER_ADMIN');

    Route::get('descarga-reporte-area/{folio?}', [PremioPuntualidadAsistenciaController::class, 'descargaReporte'])
        ->name('premio.puntualidad.asistencia.descarga.reporte.area')
        ->middleware('role:ADMIN_PREMIO_PUNTUALIDAD|SUPER_ADMIN');

    // Mostrar tarea 03
	Route::get('{premioPuntualidad}/{instanciaTarea}/generacion-archivos-pago', [PremioPuntualidadAsistenciaController::class, "generacionArchivosPago"])
        ->name('generacion.archivos.pago')
        ->middleware('role:ADMIN_PREMIO_PUNTUALIDAD|SUPER_ADMIN');

    Route::post('{premioPuntualidad}/{instanciaTarea}/generacion-archivos-pago', [PremioPuntualidadAsistenciaController::class, "generacionArchivosPago"])
        ->middleware('role:ADMIN_PREMIO_PUNTUALIDAD|SUPER_ADMIN');

    // Descargar layout CON nombres
    Route::get('descargar-layout-con-nombres', [PremioPuntualidadAsistenciaController::class, "descargarLayoutConNombres"])
		->name('descargar.excel.layout.con.nombres')
        ->middleware('role:ADMIN_PREMIO_PUNTUALIDAD|SUPER_ADMIN');

    // Descargar layout SIN nombres
    Route::get('descargar-layout-sin-nombres', [PremioPuntualidadAsistenciaController::class, "descargarLayoutSinNombres"])
		->name('descargar.excel.layout.sin.nombres')
        ->middleware('role:ADMIN_PREMIO_PUNTUALIDAD|SUPER_ADMIN');

        // Descargar relación
		Route::get('descargar-relacion-empleados', [PremioPuntualidadAsistenciaController::class, "descargarRelacionEmpleados"])
            ->name('descargar.pdf.relacion.empleados')
            ->middleware('role:ADMIN_PREMIO_PUNTUALIDAD|SUPER_ADMIN');

    // Rutas SUBPROCESO
    // Mostrar tarea 1 - Subproceso
    Route::get('{subproceso}/{instanciaTarea}/captura-instrucciones-proceso', [PremioPuntualidadAsistenciaController::class, "capturaInstrucciones"])
        ->name('captura.instrucciones.proceso')
        ->middleware('role:SUB_EA|SUPER_ADMIN');

    Route::post('{subproceso}/{instanciaTarea}/captura-instrucciones-proceso', [PremioPuntualidadAsistenciaController::class, "capturaInstrucciones"])
        ->middleware('role:SUB_EA|SUPER_ADMIN');

    // Mostrar tarea 2 - Subproceso
    Route::get('{subproceso}/{instanciaTarea}/evaluacion-adicion-empleados', [PremioPuntualidadAsistenciaController::class, "evaluacionAdicion"])
    ->name('evaluacion.adicion.empleados')
    ->middleware('role:OPER_PREMIO_PUNTUALIDAD|SUPER_ADMIN');

    Route::post('{subproceso}/{instanciaTarea}/evaluacion-adicion-empleados', [PremioPuntualidadAsistenciaController::class, "evaluacionAdicion"])
    ->middleware('role:OPER_PREMIO_PUNTUALIDAD|SUPER_ADMIN');

    Route::post('agregar-empleado', [PremioPuntualidadAsistenciaController::class, 'agregarEmpleado'])
        ->name('evaluacion.adicion.empleados.agregar.empleado')
        ->middleware('role:ADMIN_PREMIO_PUNTUALIDAD|SUPER_ADMIN|OPER_PREMIO_PUNTUALIDAD');

    Route::post('evaluar-empleado', [PremioPuntualidadAsistenciaController::class, 'evaluarEmpleado'])
        ->name('evaluacion.adicion.empleados.evaluar.empleado')
        ->middleware('role:ADMIN_PREMIO_PUNTUALIDAD|SUPER_ADMIN|OPER_PREMIO_PUNTUALIDAD');

    Route::post('borrar-empleado-por-area', [PremioPuntualidadAsistenciaController::class, 'borrarEmpleados'])
        ->name('evaluacion.adicion.borrar.empleado')
        ->middleware('role:ADMIN_PREMIO_PUNTUALIDAD|SUPER_ADMIN|OPER_PREMIO_PUNTUALIDAD');

    Route::get('pdf-empleado-agregado/{empleado_id?}', [PremioPuntualidadAsistenciaController::class, "descargarReporteEmpleado"])
        ->name('descargar.pdf.empleado.agregado')
        ->middleware('role:OPER_PREMIO_PUNTUALIDAD|SUPER_ADMIN');

    Route::post('validarEmpleado', [PremioPuntualidadAsistenciaController::class, "validarEmpleado"])
        ->name('validar.empleado.premio')
        ->middleware('role:OPER_PREMIO_PUNTUALIDAD|SUPER_ADMIN');

    // Mostrar tarea 3 - Subproceso
    Route::get('{subproceso?}/{instanciaTarea}/autorizacion-solicitudes', [PremioPuntualidadAsistenciaController::class, "autorizacionSolicitudes"])
    ->name('autorizacion.solicitudes')
    ->middleware('role:SUB_EA|SUPER_ADMIN');

    Route::post('{subproceso}/{instanciaTarea}/autorizacion-solicitudes', [PremioPuntualidadAsistenciaController::class, "autorizacionSolicitudes"])
    ->middleware('role:SUB_EA|SUPER_ADMIN');

    Route::get('descarga-reporte-por-subarea-ppa/{premio_puntualidad_area_id?}', [PremioPuntualidadAsistenciaController::class, 'descargaReporteSubAreaPPA'])
        ->name('premio.puntualidad.asistencia.descarga.reporte.subarea')
        ->middleware('role:SUB_EA|SUPER_ADMIN');

    Route::post('rechazar-tarea-subarea/{subproceso}/{instanciaTarea}', [PremioPuntualidadAsistenciaController::class, 'rechazarTareaSubarea'])
        ->name('premio.puntualidad.rechazar.tarea.subarea')
        ->middleware('role:SUB_EA|SUPER_ADMIN');

    // Rutas de las notificaciones
    Route::get('{premioPuntualidad}/{instanciaTarea}/notificacion-listado-solicitantes', [PremioPuntualidadAsistenciaController::class, "notificacionListadoSolicitantes"])
    ->name('notificacion.listado.solicitantes')
    ->middleware('role:SUB_EA|SUPER_ADMIN|OPER_PREMIO_PUNTUALIDAD');

    // Descartar notificacion
    Route::post('{premioPuntualidad}/{instanciaTarea}/notificacion-listado-solicitantes', [PremioPuntualidadAsistenciaController::class, "notificacionListadoSolicitantes"])
    ->middleware('role:SUB_EA|SUPER_ADMIN|OPER_PREMIO_PUNTUALIDAD');

    // REPORTES

	// Reporte 1. REPORTE EJECUTIVO DE PROCESOS EJECUTADOS PARA PREMIO DE PUNTUALIDAD Y ASISTENCIA
    Route::get('reporte-ejecutivo-premio-puntualidad-y-asistencia', [ReportePremioPAController::class, "reporteEjecutivoPremio"])
			   ->name('reporte.ejecutivo.premio.puntualidad.asistencia')
			   ->middleware('role:ADMIN_PREMIO_PUNTUALIDAD|SUB_EA|OPER_PREMIO_PUNTUALIDAD|SUPER_ADMIN');

    Route::post('reporte-ejecutivo-premio-puntualidad-y-asistencia', [ReportePremioPAController::class, "reporteEjecutivoPremio"])
			   ->middleware('role:ADMIN_PREMIO_PUNTUALIDAD|SUB_EA|OPER_PREMIO_PUNTUALIDAD|SUPER_ADMIN');

    Route::post('reporte-ejecutivo-premio-puntualidad-y-asistencia-buscar', [ReportePremioPAController::class, "reporteEjecutivoPremioBuscar"])
			   ->name('reporte.ejecutivo.premio.puntualidad.asistencia.buscar')
			   ->middleware('role:ADMIN_PREMIO_PUNTUALIDAD|SUB_EA|OPER_PREMIO_PUNTUALIDAD|SUPER_ADMIN');

	Route::get('reporte-ejecutivo-premio-puntualidad-y-asistencia-pdf/{fechaInicio?}/{fechaFinal?}', [ReportePremioPAController::class, "descargarReporteEjecutivoPremio"])
			->name('descargar.pdf.reporte.ejecutivo.premio.puntualidad.asistencia')
			->middleware('role:ADMIN_PREMIO_PUNTUALIDAD|SUB_EA|OPER_PREMIO_PUNTUALIDAD|SUPER_ADMIN');

	// Reporte 2. REIMPRESIÓN RELACIÓN DE EMPLEADOS PREMIO DE PUNTUALIDAD Y ASISTENCIA
    Route::get('reporte-reimpresion-relacion-empleados', [ReportePremioPAController::class, "reporteReimpresionRelacionEmpleados"])
			   ->name('reporte.reimpresion.relacion.empleados')
			   ->middleware('role:ADMIN_PREMIO_PUNTUALIDAD|SUPER_ADMIN');

    Route::post('reporte-reimpresion-relacion-empleados', [ReportePremioPAController::class, "reporteReimpresionRelacionEmpleados"])
			   ->middleware('role:ADMIN_PREMIO_PUNTUALIDAD|SUPER_ADMIN');

    Route::post('reporte-reimpresion-relacion-empleados-buscar', [ReportePremioPAController::class, "reporteReimpresionRelacionEmpleadosBuscar"])
			   ->name('reporte.reimpresion.relacion.empleados.buscar')
			   ->middleware('role:ADMIN_PREMIO_PUNTUALIDAD|SUPER_ADMIN');

	Route::get('reporte-reimpresion-relacion-empleados-pdf/{folio?}', [ReportePremioPAController::class, "descargarReporteReimpresionRelacionEmpleados"])
			->name('descargar.pdf.reporte.reimpresion.relacion.empleados')
			->middleware('role:ADMIN_PREMIO_PUNTUALIDAD|SUPER_ADMIN');

	// Reporte 3. REIMPRESIÓN DE LAYOUT PREMIO PUNTUALIDAD Y ASISTENCIA
    Route::get('reporte-reimpresion-layout', [ReportePremioPAController::class, "reimpresionLayout"])
            ->name('reporte.reimpresion.layout.premio')
            ->middleware('role:ADMIN_PREMIO_PUNTUALIDAD|SUPER_ADMIN');

    Route::post('reporte-reimpresion-layout', [ReportePremioPAController::class, "reimpresionLayout"])
            ->middleware('role:ADMIN_PREMIO_PUNTUALIDAD|SUPER_ADMIN');

	Route::get('descargar-reporte-reimpresion-layout/{folio?}', [ReportePremioPAController::class, "descargarReimpresionLayout"])
			->name('descargar.excel.reimpresion.layout.premio')
            ->middleware('role:ADMIN_PREMIO_PUNTUALIDAD|SUPER_ADMIN');

    Route::post('reporte-reimpresion-layout-buscar', [ReportePremioPAController::class, "reimpresionLayoutBuscar"])
            ->name('reporte.reimpresion.layout.premio.buscar')
            ->middleware('role:ADMIN_PREMIO_PUNTUALIDAD|SUPER_ADMIN');

	// // Reporte 4. OPERADOR REPORTE LISTADO DE SOLICITANTES PREMIO PUNTUALIDAD Y ASISTENCIA
    // Route::get('reporte-operador-listado-solicitantes', [ReportePremioPAController::class, "reporteEjecutivoPPA"])
	// 		   ->name('reporte.operador.listado.solicitantes')
	// 		   ->middleware('role:OPER_PREMIO_PUNTUALIDAD|SUPER_ADMIN');

    // Route::post('reporte-operador-listado-solicitantes', [ReportePremioPAController::class, "reporteEjecutivoPPA"])
	// 		   ->middleware('role:OPER_PREMIO_PUNTUALIDAD|SUPER_ADMIN');

	// Route::get('reporte-operador-listado-solicitantes-pdf', [ReportePremioPAController::class, "notificacionListadoSolicitantes"])
	// 		->name('descargar.pdf.operador.listado.solicitantes')
	// 		->middleware('role:OPER_PREMIO_PUNTUALIDAD|SUPER_ADMIN');

	// Reporte 5. ENLACE REPORTE LISTADO DE SOLICITANTES PREMIO PUNTUALIDAD Y ASISTENCIA
    Route::get('reporte-listado-solicitantes', [ReportePremioPAController::class, "enlaceListadoSolicitantes"])
			   ->name('reporte.enlace.listado.solicitantes')
			   ->middleware('role:SUB_EA|SUPER_ADMIN|OPER_PREMIO_PUNTUALIDAD');

    Route::post('reporte-listado-solicitantes', [ReportePremioPAController::class, "enlaceListadoSolicitantes"])
			   ->middleware('role:SUB_EA|SUPER_ADMIN|OPER_PREMIO_PUNTUALIDAD');

    Route::post('reporte-listado-solicitantes-buscar', [ReportePremioPAController::class, "enlaceListadoSolicitantesBuscar"])
			   ->name('reporte.enlace.listado.solicitantes.buscar')
			   ->middleware('role:SUB_EA|SUPER_ADMIN|OPER_PREMIO_PUNTUALIDAD');

	Route::get('reporte-enlace-listado-solicitantes-pdf/{folio?}', [ReportePremioPAController::class, "descargarEnlaceListadoSolicitantes"])
			->name('descargar.pdf.enlace.listado.solicitantes')
            ->middleware('role:SUB_EA|SUPER_ADMIN|OPER_PREMIO_PUNTUALIDAD');

    Route::post('reporte-listado-solicitantes-tarjeta-electronica', [ReportePremioPAController::class, "enlaceListadoSolicitantesTarjetaElectronica"])
			   ->name('reporte.enlace.listado.solicitantes.tarjeta.electronica')
			   ->middleware('role:SUB_EA|SUPER_ADMIN|OPER_PREMIO_PUNTUALIDAD');

});
