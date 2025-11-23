<?php

use App\Http\Controllers\p01_movimientos_personal\MovimientoPersonalController;
use App\Http\Controllers\p01_movimientos_personal\reportes\ReporteMovimientosController;
use Illuminate\Support\Facades\Route;

Route::group([
	'prefix' => 'procesos/movimientos-personal',
], function() {
	// DESCRIPCIÓN
	Route::get('descripcion',
		[MovimientoPersonalController::class, "descripcion"])
	->name('movimiento.personal.descripcion')
	->middleware('role:SUPER_ADMIN|SUB_EA');

	Route::post('inicializar-proceso',
		[MovimientoPersonalController::class, "inicializarProceso"])
	->name('movimiento.personal.inicializar.proceso')
	->middleware('role:SUPER_ADMIN|SUB_EA');

	Route::get('{movimientoPersonal}/{instanciaTarea}/seleccionar-movimiento',
		[MovimientoPersonalController::class, "seleccionarMovimiento"])
	->name('movimiento.personal.seleccionar.movimiento')
	->middleware(['role:SUPER_ADMIN|SUB_EA', 'has.permission.task']);

	Route::post('{movimientoPersonal}/{instanciaTarea}/seleccionar-movimiento',
	    [MovimientoPersonalController::class, "seleccionarMovimiento"])
	->middleware('role:SUPER_ADMIN|SUB_EA');

	// INICIA PROCESO DE ALTA
	Route::get('{movimientoPersonal}/{instanciaTarea}/capturar-propuesta',
		[MovimientoPersonalController::class, "capturarPropuesta"])
	->name('movimiento.personal.altas.capturar.propuesta')
	->middleware('role:SUPER_ADMIN|SUB_EA');

	Route::post('{movimientoPersonal}/{instanciaTarea}/capturar-propuesta',
		[MovimientoPersonalController::class, "capturarPropuesta"])
	->middleware('role:SUPER_ADMIN|SUB_EA');

	Route::get('{movimientoPersonal}/{instanciaTarea}/cita-examen-psicometrico',
		[MovimientoPersonalController::class, "crearCitaExamen"])
	->name('movimiento.personal.altas.cita.psicometrico')
	->middleware('role:SUPER_ADMIN|COO_EVAL');

	Route::post('{movimientoPersonal}/{instanciaTarea}/cita-examen-psicometrico',
		[MovimientoPersonalController::class, "crearCitaExamen"])
	->middleware('role:SUPER_ADMIN|COO_EVAL');

	Route::get('{movimientoPersonal}/{instanciaTarea}/notificacion-cita-psicometrico',
		[MovimientoPersonalController::class, "notificarCitaExamen"])
	->name('movimiento.personal.altas.notificacion.cita.psicometrico')
	->middleware('role:SUPER_ADMIN|SUB_EA');

	Route::post('{movimientoPersonal}/{instanciaTarea}/notificacion-cita-psicometrico',
		[MovimientoPersonalController::class, "notificarCitaExamen"])
	->middleware('role:SUPER_ADMIN|SUB_EA');

	Route::get('{movimientoPersonal}/{instanciaTarea}/asignar-calificacion-psicometrico',
		[MovimientoPersonalController::class, "asignarCalificacionExamen"])
	->name('movimiento.personal.altas.psicometrico.calificacion')
	->middleware('role:SUPER_ADMIN|COO_EVAL');

	Route::post('{movimientoPersonal}/{instanciaTarea}/asignar-calificacion-psicometrico',
		[MovimientoPersonalController::class, "asignarCalificacionExamen"])
	->middleware('role:SUPER_ADMIN|COO_EVAL');

	Route::get('{movimientoPersonal}/{instanciaTarea}/alimentario-altas',
		[MovimientoPersonalController::class, "capturarAlimentarioAltas"])
	->name('movimiento.personal.altas.alimentario')
	->middleware('role:SUPER_ADMIN|SUB_EA');

	Route::post('{movimientoPersonal}/{instanciaTarea}/alimentario-altas',
		[MovimientoPersonalController::class, "capturarAlimentarioAltas"])
	->middleware('role:SUPER_ADMIN|SUB_EA');

	Route::get('{movimientoPersonal}/{instanciaTarea}/lista-documentacion',
		[MovimientoPersonalController::class, "listarDocumentacion"])
	->name('movimiento.personal.altas.lista.documentacion')
	->middleware('role:SUPER_ADMIN|SUB_EA');

	Route::post('{movimientoPersonal}/{instanciaTarea}/lista-documentacion',
		[MovimientoPersonalController::class, "listarDocumentacion"])
	->middleware('role:SUPER_ADMIN|SUB_EA');

	Route::post('{movimientoPersonal}/descargar-lista-documentacion',
		[MovimientoPersonalController::class, "descargarListaDocumentacion"])
	->name('movimiento.personal.altas.descargar.lista.documentacion')
	->middleware('role:SUPER_ADMIN|SUB_EA');

	Route::get('{movimientoPersonal}/{instanciaTarea}/finalizacion-altas', 
		[MovimientoPersonalController::class, "finalizarMovimientoAltas"])
	->name('movimiento.personal.altas.procesamiento.sun')
	->middleware('role:SUPER_ADMIN|JUD_MP');

	Route::post('{movimientoPersonal}/{instanciaTarea}/finalizacion-altas', 
		[MovimientoPersonalController::class, "finalizarMovimientoAltas"])
	->middleware('role:SUPER_ADMIN|JUD_MP');
	
	Route::get('{movimientoPersonal}/{instanciaTarea}/documento-alimentario-altas',
		[MovimientoPersonalController::class, "generarDocumentoAltas"])
	->name('movimiento.personal.altas.documento.alimentario')
	->middleware('role:SUPER_ADMIN|SUB_EA');
	
	Route::post('{movimientoPersonal}/{instanciaTarea}/documento-alimentario-altas',
		[MovimientoPersonalController::class, "generarDocumentoAltas"])
	->middleware('role:SUPER_ADMIN|SUB_EA');
	
	Route::get('{movimientoPersonal}/documento-alimentario-alta-PDF',
				[MovimientoPersonalController::class, "descargarAlimentarioAltas"])
	->name('movimiento.personal.altas.descargar.alimentario')
	->middleware('role:SUPER_ADMIN|SUB_EA');
	// FINALIZA PROCESO DE ALTA

	// INCIA PROCESO DE REANUDACION
	Route::get('{movimientoPersonal}/{instanciaTarea}/capturar-alimentario-reanudaciones', 
		[MovimientoPersonalController::class, "capturarAlimentarioReanudaciones"])
	->name('movimiento.personal.reanudaciones.alimentario')
	->middleware('role:SUPER_ADMIN|SUB_EA');

	Route::post('{movimientoPersonal}/{instanciaTarea}/capturar-alimentario-reanudaciones', 
		[MovimientoPersonalController::class, "capturarAlimentarioReanudaciones"])
	->middleware('role:SUPER_ADMIN|SUB_EA');

	Route::get('{movimientoPersonal}/{instanciaTarea}/finalizacion-reanudaciones', 
		[MovimientoPersonalController::class, "finalizarMovimientoReanudaciones"])
	->name('movimiento.personal.reanudaciones.procesamiento.sun')
	->middleware('role:SUPER_ADMIN|JUD_MP');
	
	Route::post('{movimientoPersonal}/{instanciaTarea}/finalizacion-reanudaciones', 
		[MovimientoPersonalController::class, "finalizarMovimientoReanudaciones"])
	->middleware('role:SUPER_ADMIN|JUD_MP');

	Route::get('{movimientoPersonal}/{instanciaTarea}/documento-alimentario-reanudaciones', 
		[MovimientoPersonalController::class, "generarDocumentoReanudaciones"])
	->name('movimiento.personal.reanudaciones.documento.alimentario')
	->middleware('role:SUPER_ADMIN|SUB_EA');
	
	Route::post('{movimientoPersonal}/{instanciaTarea}/documento-alimentario-reanudaciones', 
		[MovimientoPersonalController::class, "generarDocumentoReanudaciones"])
	->middleware('role:SUPER_ADMIN|SUB_EA');
	
	Route::get('{movimientoPersonal}/descargar-documento-alimentario-reanudaciones',
		[MovimientoPersonalController::class, "descargarAlimentarioReanudaciones"])
	->name('movimiento.personal.reanudaciones.descargar.alimentario')
	->middleware('role:SUPER_ADMIN|SUB_EA');
	// FINALIZA PROCESO DE REANUDACIÓN

	// INCIA PROCESO DE BAJA
	Route::get('{movimientoPersonal}/{instanciaTarea}/capturar-alimentario-bajas', 
		[MovimientoPersonalController::class, "capturarAlimentarioBajas"])
	->name('movimiento.personal.bajas.alimentario')
	->middleware('role:SUPER_ADMIN|SUB_EA');

	Route::post('{movimientoPersonal}/{instanciaTarea}/capturar-alimentario-bajas', 
		[MovimientoPersonalController::class, "capturarAlimentarioBajas"])
	->middleware('role:SUPER_ADMIN|SUB_EA');

	Route::get('{movimientoPersonal}/{instanciaTarea}/finalizacion-bajas', 
		[MovimientoPersonalController::class, "finalizarMovimientoBajas"])
	->name('movimiento.personal.bajas.procesamiento.sun')
	->middleware('role:SUPER_ADMIN|JUD_MP');

	Route::post('{movimientoPersonal}/{instanciaTarea}/finalizacion-bajas', 
		[MovimientoPersonalController::class, "finalizarMovimientoBajas"])
	->middleware('role:SUPER_ADMIN|JUD_MP');

	Route::get('{movimientoPersonal}/{instanciaTarea}/documento-alimentario-bajas', 
		[MovimientoPersonalController::class, "generarDocumentoBajas"])
	->name('movimiento.personal.bajas.documento.alimentario')
	->middleware('role:SUPER_ADMIN|SUB_EA');

	Route::post('{movimientoPersonal}/{instanciaTarea}/documento-alimentario-bajas', 
		[MovimientoPersonalController::class, "generarDocumentoBajas"])
	->middleware('role:SUPER_ADMIN|SUB_EA');
	
	Route::get('{movimientoPersonal}/descargar-documento-alimentario-bajas',
		[MovimientoPersonalController::class, "descargarAlimentarioBajas"])
	->name('movimiento.personal.bajas.descargar.alimentario')
	->middleware('role:SUPER_ADMIN|SUB_EA');
	// FINALIZA PROCESO DE BAJA

	// ARCHIVOS DEL SUN 
	Route::get('generar-archivos-sun', 
		[MovimientoPersonalController::class, "generarArchivosSun"])
	->name('movimiento.personal.archivos.sun')
	->middleware("role:SUPER_ADMIN|JUD_MP");
	
	Route::get('descargar-archivos-sun/{tipoMovimiento}', 
		[MovimientoPersonalController::class, "descargarArchivosSun"])
	->name('movimiento.personal.descargar.archivos.sun')
	->middleware("role:SUPER_ADMIN|JUD_MP");

	// REPORTES
	// Movimientos de personal
	Route::get('reportes/movimientos', 
		[ReporteMovimientosController::class, "index"])
	->name('movimiento.personal.reporte.movimientos')
	->middleware("role:SUPER_ADMIN|JUD_MP|SUB_EA");
	
	Route::get('reportes/movimientos/buscar', 
		[ReporteMovimientosController::class, "buscar"])
	->name('movimiento.personal.reporte.movimientos.buscar')
	->middleware("role:SUPER_ADMIN|JUD_MP|SUB_EA");
	
	Route::get('reportes/descargar-alimentario/{movimientoPersonal}', 
		[ReporteMovimientosController::class, "descargarAlimentario"])
	->name('movimiento.personal.reportes.descargar.alimentario')
	->middleware("role:SUPER_ADMIN|JUD_MP|SUB_EA");

	// Mostrar tarea 09
	/* Route::get('{movimientoPersonal}/documentacion',
				[MovimientoPersonalController::class, "subirDocumentacion'
	)->name('subir.documentacion');
	
	Route::post('{movimientoPersonal}/documentacion',
				[MovimientoPersonalController::class, "subirDocumentacion'
	); */
});

