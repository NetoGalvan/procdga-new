<?php

use App\Http\Controllers\p23_solicitud_expediente\SolicitudExpedienteController;

Route::group(['prefix' => 'procesos/solicitud-prestamo-expediente'], function(){

    Route::get('descripcion', [SolicitudExpedienteController::class, "descripcion"])
    ->name('solicitud.prestamo.expedientes.descripcion')
    ->middleware('role:INI_EXP_23|SUPER_ADMIN');

    Route::post('iniciar-proceso', [SolicitudExpedienteController::class, "iniciarProceso"])
    ->name('solicitud.prestamo.expedientes.iniciar.proceso')
    ->middleware('role:INI_EXP_23|SUPER_ADMIN');
    
	// Mostrar tarea 01
	Route::get('{solicitud?}/{instanciaTarea}/solicitud-prestamo-expediente', [SolicitudExpedienteController::class, "solicitudPrestamoExpediente"])
    ->name('solicitud.expediente.solicitud.prestamo.expediente')
    ->middleware('role:INI_EXP_23|SUPER_ADMIN');

    Route::post('{solicitud}/{instanciaTarea}/solicitud-prestamo-expediente', [SolicitudExpedienteController::class, "solicitudPrestamoExpediente"])
    ->middleware('role:INI_EXP_23|SUPER_ADMIN');
        
        Route::post('{solicitud}/{instanciaTarea}/cancelar-proceso-solicitud-expediente', [SolicitudExpedienteController::class, "cancelarProceso"])
                ->name('cancelar.proceso.solicitud.expediente')
                ->middleware('role:INI_EXP_23|SUPER_ADMIN');
        
        Route::post('buscar-expediente-trabajador', [SolicitudExpedienteController::class, "buscarExpedienteTrabajador"])
            ->name('buscar.expediente.trabajador')
            ->middleware('role:INI_EXP_23|SUPER_ADMIN');

    // // Mostrar tarea 02
	// Route::get('{digitalizacion}/creacion-expediente', [SolicitudExpedienteController::class, "creacionExpediente"])
    // ->name('digitalizacion.archivos.creacion.expediente')
    // ->middleware('role:OPER_DIG_23|SUPER_ADMIN');

    // Route::post('{digitalizacion}/creacion-expediente', [SolicitudExpedienteController::class, "creacionExpediente"])
    // ->middleware('role:OPER_DIG_23|SUPER_ADMIN');

    // // Mostrar tarea 03
	// Route::get('{digitalizacion}/actualizacion-expediente', [SolicitudExpedienteController::class, "actualizacionExpediente"])
    // ->name('digitalizacion.archivos.actualizacion.expediente')
    // ->middleware('role:OPER_DIG_23|SUPER_ADMIN');

    // Route::post('{digitalizacion}/actualizacion-expediente', [SolicitudExpedienteController::class, "actualizacionExpediente"])
    // ->middleware('role:OPER_DIG_23|SUPER_ADMIN');

    //     // Guardar documento
    //     Route::post('{digitalizacion}/guardar-documento-digitalizacion',[SolicitudExpedienteController::class, "guardarDocumento"])
    //     ->name('digitalizacion.archivo.guardar.documento')
    //     ->middleware('role:OPER_DIG_23|SUPER_ADMIN');
        
    //     // Descargar expediente
	// 	Route::post('pdf-expediente-actual/{digitalizacion?}', [SolicitudExpedienteController::class, "descargarExpediente"])
	// 	->name('descargar.pdf.expediente.actual')
	// 	->middleware('role:OPER_DIG_23|SUPER_ADMIN');
});