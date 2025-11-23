<?php

use App\Http\Controllers\p21_premio_administracion\PremioAdministracionInscripcionController;

Route::group(['prefix' => 'procesos/premio-administracion-inscripcion'], function(){
	// Descripción
	Route::get('descripcion-inscripcion',
		'App\Http\Controllers\p21_premio_administracion\PremioAdministracionInscripcionController@descripcion')
		->name('premio.administracion.inscripcion.descripcion')
		->middleware('role:OPER_PA_21|SUPER_ADMIN');

    Route::post('inicializar-proceso-inscripcion',
		'App\Http\Controllers\p21_premio_administracion\PremioAdministracionInscripcionController@inicializarProceso')
		->name('premio.administracion.inscripcion.inicializar.proceso')
		->middleware('role:OPER_PA_21|SUPER_ADMIN');

	// Mostrar tarea 01
	Route::get('{inscripcion?}/{instanciaTarea}/busqueda-generacion-formatos',
		'App\Http\Controllers\p21_premio_administracion\PremioAdministracionInscripcionController@busquedaGeneracionFormatos')
		->name('inscripcion.premio.administracion.busqueda.generacion.formatos')
		->middleware('role:OPER_PA_21|SUPER_ADMIN');

	// Guardar tarea 01 y crear tarea 02
	Route::post('{inscripcion}/{instanciaTarea}/busqueda-generacion-formatos',
		'App\Http\Controllers\p21_premio_administracion\PremioAdministracionInscripcionController@busquedaGeneracionFormatos')
		->middleware('role:OPER_PA_21|SUPER_ADMIN');

		Route::post('validarEmpleadoInscripcion', [PremioAdministracionInscripcionController::class, "validarEmpleadoInscripcion"])
        ->name('validar.empleado.premio.inscripcion')
        ->middleware('role:OPER_PA_21|ADMN_PA_21|SUPER_ADMIN');

		Route::post('/cancelar-proceso-inscripcion',
			'App\Http\Controllers\p21_premio_administracion\PremioAdministracionInscripcionController@cancelarProceso')
			->name('cancelar.proceso.inscripcion')
			->middleware('role:OPER_PA_21|SUPER_ADMIN');

		Route::get('pdf-propuesta-de-candidato/{rfc?}',
			'App\Http\Controllers\p21_premio_administracion\PremioAdministracionInscripcionController@descargarPropuestaCandidato')
			->name('descargar.pdf.propuesta.candidato')
			->middleware('role:ADMN_PA_21|OPER_PA_21|SUPER_ADMIN');

		Route::get('pdf-cedula-de-desempeno/{rfc?}',
			'App\Http\Controllers\p21_premio_administracion\PremioAdministracionInscripcionController@descargarCedulaDesempeno')
			->name('descargar.pdf.cedula.desempeno')
			->middleware('role:ADMN_PA_21|OPER_PA_21|SUPER_ADMIN');

		Route::get('pdf-cedula-de-cursos/{rfc?}',
			'App\Http\Controllers\p21_premio_administracion\PremioAdministracionInscripcionController@descargarCedulaCursos')
			->name('descargar.pdf.cedula.cursos')
			->middleware('role:ADMN_PA_21|OPER_PA_21|SUPER_ADMIN');

		Route::get('pdf-control-puntualidad-y-asistencia/{rfc?}',
			'App\Http\Controllers\p21_premio_administracion\PremioAdministracionInscripcionController@descargarControlPuntualidadAsistencia')
			->name('descargar.pdf.puntualidad.asistencia')
			->middleware('role:ADMN_PA_21|OPER_PA_21|SUPER_ADMIN');

	// Mostrar tarea 02
	Route::get('{inscripcion}/{instanciaTarea}/captura-evaluacion-cursos',
		'App\Http\Controllers\p21_premio_administracion\PremioAdministracionInscripcionController@capturaEvaluacionCursos')
		->name('inscripcion.premio.administracion.captura.evaluacion.cursos')
		->middleware('role:OPER_PA_21|SUPER_ADMIN');

	// Guardar tarea 02 y crear tarea 03
	Route::post('{inscripcion}/{instanciaTarea}/captura-evaluacion-cursos',
		'App\Http\Controllers\p21_premio_administracion\PremioAdministracionInscripcionController@capturaEvaluacionCursos')
		->middleware('role:OPER_PA_21|SUPER_ADMIN');

	// Mostrar tarea 03
	Route::get('{inscripcion}/{instanciaTarea}/validacion-cursos',
		'App\Http\Controllers\p21_premio_administracion\PremioAdministracionInscripcionController@validacionCursos')
		->name('inscripcion.premio.administracion.validacion.cursos')
		->middleware('role:OPER_CAP_21|SUPER_ADMIN');

	// Guardar tarea 03 y crea tarea 4
	Route::post('{inscripcion}/{instanciaTarea}/validacion-cursos',
		'App\Http\Controllers\p21_premio_administracion\PremioAdministracionInscripcionController@validacionCursos')
		->middleware('role:OPER_CAP_21|SUPER_ADMIN');

});
