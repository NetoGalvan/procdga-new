<?php

use App\Http\Controllers\p21_premio_administracion\PremioAdministracionController;

Route::group(['prefix' => 'procesos/premio-administracion'], function(){
	// Descripción
	Route::get('descripcion',
		'App\Http\Controllers\p21_premio_administracion\PremioAdministracionController@descripcion')
		->name('premio.administracion.descripcion')
		->middleware('role:ADMN_PA_21|SUPER_ADMIN');

    Route::post('inicializar-proceso',
        'App\Http\Controllers\p21_premio_administracion\PremioAdministracionController@inicializarProceso'
		)->name('premio.administracion.inicializar.proceso')
		->middleware('role:ADMN_PA_21|SUPER_ADMIN');

	// Mostrar tarea 01
	Route::get('{premioAdministracion?}/{instanciaTarea}/inicio-convocatoria',
		'App\Http\Controllers\p21_premio_administracion\PremioAdministracionController@inicioConvocatoria')
		->name('premio.administracion.inicio.convocatoria')
		->middleware('role:ADMN_PA_21|SUPER_ADMIN');

	// Guardar tarea 01 y crear tarea 02
	Route::post('{premioAdministracion}/{instanciaTarea}/inicio-convocatoria',
		'App\Http\Controllers\p21_premio_administracion\PremioAdministracionController@inicioConvocatoria')
		->middleware('role:ADMN_PA_21|SUPER_ADMIN');

	Route::post('/calcular-fecha',
	'App\Http\Controllers\p21_premio_administracion\PremioAdministracionController@calcularFechaFin')
	->name('calcular.fecha.fin')
	->middleware('role:ADMN_PA_21|SUPER_ADMIN');

	// Mostrar tarea 02
	Route::get('{premioAdministracion}/{instanciaTarea}/eliminacion-solicitudes',
		'App\Http\Controllers\p21_premio_administracion\PremioAdministracionController@eliminacionSolicitudes')
		->name('premio.administracion.eliminacion.solicitudes')
		->middleware('role:AUTZ_PA_21|SUPER_ADMIN');

	// Guardar tarea 02 y crear tarea 03
	Route::post('{premioAdministracion}/{instanciaTarea}/eliminacion-solicitudes',
		'App\Http\Controllers\p21_premio_administracion\PremioAdministracionController@eliminacionSolicitudes')
		->middleware('role:AUTZ_PA_21|SUPER_ADMIN');

    // Guardar avance T02
    Route::post('{premioAdministracion}/guardar-avance-eliminacion-solicitudes',
		'App\Http\Controllers\p21_premio_administracion\PremioAdministracionController@guardarAvanceEliminacionSolicitudes')
		->name('premio.administracion.guardar.avance.eliminacion.solicitudes')
		->middleware('role:AUTZ_PA_21|SUPER_ADMIN');

    Route::post('pdf-lista-candidatos-inscritos/{premio?}',
		'App\Http\Controllers\p21_premio_administracion\PremioAdministracionController@descargarListaCandidatos')
		->name('descargar.pdf.lista.candidatos')
		->middleware('role:AUTZ_PA_21|SUPER_ADMIN');

	// Mostrar tarea 03
	Route::get('{premioAdministracion}/{instanciaTarea}/asignacion-premios',
		'App\Http\Controllers\p21_premio_administracion\PremioAdministracionController@asignacionPremios')
		->name('premio.administracion.asignacion.premios')
		->middleware('role:ADMN_PA_21|SUPER_ADMIN');

	// Guardar tarea 03 y crea tarea 4
	Route::post('{premioAdministracion}/{instanciaTarea}/asignacion-premios',
		'App\Http\Controllers\p21_premio_administracion\PremioAdministracionController@asignacionPremios')
		->middleware('role:ADMN_PA_21|SUPER_ADMIN');

    Route::post('{premioAdministracion}/asignacion-premios-guardar-candidatos',
		'App\Http\Controllers\p21_premio_administracion\PremioAdministracionController@asignacionPremiosGuardarCandidatos')
		->name('premio.administracion.asignacion.premios.guardar.candidatos')
		->middleware('role:ADMN_PA_21|SUPER_ADMIN');

    Route::post('{premioAdministracion}/asignacion-premios-guardar-nuevo-candidato',
		'App\Http\Controllers\p21_premio_administracion\PremioAdministracionController@asignacionPremiosGuardarNuevoCandidato')
		->name('premio.administracion.asignacion.premios.guardar.nuevo.candidato')
		->middleware('role:ADMN_PA_21|SUPER_ADMIN');

		Route::get('/tabla-candidatos-premio/{p21_premio_id?}',
		'App\Http\Controllers\p21_premio_administracion\PremioAdministracionController@obtenerCandidatosTabla')
		->name('candidatos.tabla.asignacion.premios')
		->middleware('role:ADMN_PA_21|SUPER_ADMIN');

		Route::post('validarEmpleadoConvocatoria', [PremioAdministracionController::class, "validarEmpleadoConvocatoria"])
        ->name('validar.empleado.premio.convocatoria')
        ->middleware('role:ADMN_PA_21|SUPER_ADMIN');

		Route::post('/guardar-puntaje-premio/{premioAdministracion?}',
			'App\Http\Controllers\p21_premio_administracion\PremioAdministracionController@guardarPuntajePremio')
			->name('guardar.pp.candidato')
			->middleware('role:ADMN_PA_21|SUPER_ADMIN');

		Route::post('pdf-listado-candidatos-finales/{premio?}',
		'App\Http\Controllers\p21_premio_administracion\PremioAdministracionController@descargarListadoCandidatosFinales')
		->name('descargar.pdf.listado.candidatos.finales')
		->middleware('role:ADMN_PA_21|SUPER_ADMIN|AUTZ_PA_21');

		Route::get('pdf-cedula-de-desempeno-actualizada/{rfc?}/{premio?}',
			'App\Http\Controllers\p21_premio_administracion\PremioAdministracionController@descargarCedulaDesempenoActualizada')
			->name('descargar.pdf.cedula.desempeno.actualizada')
			->middleware('role:ADMN_PA_21|SUPER_ADMIN');

		Route::get('pdf-cedula-de-cursos-actualizada/{rfc?}/{premio_id?}',
		'App\Http\Controllers\p21_premio_administracion\PremioAdministracionController@descargarCedulaCursosActualizada')
		->name('descargar.pdf.cedula.cursos.actualizada')
		->middleware('role:ADMN_PA_21|SUPER_ADMIN');


	// Mostrar tarea 04
	Route::get('{premioAdministracion}/{instanciaTarea}/recepcion-inconformidades',
	'App\Http\Controllers\p21_premio_administracion\PremioAdministracionController@recepcionInconformidades')
	->name('premio.administracion.recepcion.inconformidades')
	->middleware('role:AUTZ_PA_21|SUPER_ADMIN');

	// Guardar tarea 04 y vuelve a crear la 03
	Route::post('{premioAdministracion}/{instanciaTarea}/recepcion-inconformidades',
		'App\Http\Controllers\p21_premio_administracion\PremioAdministracionController@recepcionInconformidades')
		->middleware('role:AUTZ_PA_21|SUPER_ADMIN');

    Route::post('{premioAdministracion}/guardar-recepcion-inconformidades',
        'App\Http\Controllers\p21_premio_administracion\PremioAdministracionController@guardarRecepcionInconformidades')
        ->name('premio.administracion.guardar.recepcion.inconformidades')
        ->middleware('role:AUTZ_PA_21|SUPER_ADMIN');

		Route::post('pdf-listado-candidatos-finales-inconformidades/{premio?}',
		'App\Http\Controllers\p21_premio_administracion\PremioAdministracionController@descargarListadoCandidatosFinalesInconformidades')
		->name('descargar.pdf.listado.candidatos.finales.inconformidades')
		->middleware('role:AUTZ_PA_21|SUPER_ADMIN');

	// Notificaciones

    // TNOTA01 - Inicio de proceso
	Route::get('{premioAdministracion}/{instanciaTarea}/notificacion-inicio-de-proceso',
    'App\Http\Controllers\p21_premio_administracion\PremioAdministracionController@notificarInicioProceso'
	)->name('premio.administracion.notificacion.inicio.proceso')
	->middleware('role:OPER_PA_21|SUPER_ADMIN');

    // Descartar notificacion inicio de proceso
    Route::post('{premioAdministracion}/{instanciaTarea}/notificacion-inicio-de-proceso',
	'App\Http\Controllers\p21_premio_administracion\PremioAdministracionController@notificarInicioProceso')
	->middleware('role:OPER_PA_21|SUPER_ADMIN');

    // TNOTA02 - Listado de ganadores
	Route::get('{premioAdministracion}/{instanciaTarea}/notificacion-listado-de-ganadores',
    'App\Http\Controllers\p21_premio_administracion\PremioAdministracionController@notificarListadoFinalGanadores'
	)->name('premio.administracion.notificacion.listado.ganadores')
	->middleware('role:OPER_PA_21|AUTZ_PA_21|SUPER_ADMIN');

    // Descartar notificacion listado de ganadores
    Route::post('{premioAdministracion}/{instanciaTarea}/notificacion-listado-de-ganadores',
	'App\Http\Controllers\p21_premio_administracion\PremioAdministracionController@notificarListadoFinalGanadores')
	->middleware('role:OPER_PA_21|AUTZ_PA_21|SUPER_ADMIN');


	// REPORTES

	// Reporte 1. Reporte ejecutivo premio de administración
    Route::get('reporte-ejecutivo-premio-administración',
			   'App\Http\Controllers\p21_premio_administracion\ReportePremioAdministracionController@reporteEjecutivo')
			   ->name('reporte.ejecutivo.premio.administracion')
			   ->middleware('role:ADMN_PA_21|SUPER_ADMIN');

    Route::post('reporte-ejecutivo-premio-administración',
			   'App\Http\Controllers\p21_premio_administracion\ReportePremioAdministracionController@reporteEjecutivo')
			   ->middleware('role:ADMN_PA_21|SUPER_ADMIN');

    Route::post('reporte-ejecutivo-premio-administración-buscar',
			   'App\Http\Controllers\p21_premio_administracion\ReportePremioAdministracionController@reporteEjecutivoBuscar')
			   ->name('reporte.ejecutivo.premio.administracion.buscar')
			   ->middleware('role:ADMN_PA_21|SUPER_ADMIN');

	Route::get('reporte-ejecutivo-premio-administracion-pdf/{fechaInicio?}/{fechaFinal?}',
			'App\Http\Controllers\p21_premio_administracion\ReportePremioAdministracionController@descargarReporteEjecutivoPremioAdministracion')
			->name('descargar.pdf.reporte.ejecutivo.premio.administracion')
			->middleware('role:ADMN_PA_21|SUPER_ADMIN');

	// Reporte 2. Listado de candidatos Premio de administración de una convocatoria	// Para el rol ADMN_PA_21, OPER_PA_21 y AUTZ_PA_21
	Route::get('reporte-listado-candidatos-por-convocatoria',
			   'App\Http\Controllers\p21_premio_administracion\ReportePremioAdministracionController@reporteListadoPorConvocatoria')
			->name('reporte.listado.candidatos.convocatoria.premio.administracion')
			->middleware('role:ADMN_PA_21|OPER_PA_21|AUTZ_PA_21|SUPER_ADMIN');

    Route::post('reporte-listado-candidatos-por-convocatoria',
			   'App\Http\Controllers\p21_premio_administracion\ReportePremioAdministracionController@reporteListadoPorConvocatoria')
			   ->middleware('role:ADMN_PA_21|OPER_PA_21|AUTZ_PA_21|SUPER_ADMIN');

    Route::post('reporte-listado-candidatos-por-convocatoria-buscar',
			   'App\Http\Controllers\p21_premio_administracion\ReportePremioAdministracionController@reporteListadoPorConvocatoriaBuscar')
			->name('reporte.listado.candidatos.convocatoria.premio.administracion.buscar')
			->middleware('role:ADMN_PA_21|OPER_PA_21|AUTZ_PA_21|SUPER_ADMIN');

	Route::get('reporte-listado-candidatos-por-convocatoria-pdf/{folio?}',
			'App\Http\Controllers\p21_premio_administracion\ReportePremioAdministracionController@descargarReporteListadoPorConvocatoria')
			->name('descargar.pdf.reporte.listado.candidatos.convocatoria.premio.administracion')
			->middleware('role:ADMN_PA_21|OPER_PA_21|AUTZ_PA_21|SUPER_ADMIN');

});
