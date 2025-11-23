<?php

use App\Http\Controllers\p23_solicitud_expediente\DigitalizacionArchivoController;
use App\Http\Controllers\p23_solicitud_expediente\ReporteDigitalizacionArchivo;

Route::group(['prefix' => 'procesos/digitalizacion-archivo'], function() {

    Route::controller(DigitalizacionArchivoController::class)->group( function() 
    {
        #BEGIN::DESCRIPCIÓN -> procesos/digitalizacion-archivo/ ruta -->
        Route::middleware('role:OPER_DIG_23|SUPER_ADMIN')->group( function() 
        {
            Route::get('descripcion', 'descripcion')->name('digitalizacion.archivo.descripcion');
            Route::post('iniciar-proceso', 'iniciarProceso')->name('digitalizacion.archivo.iniciar.proceso');
        });
        #END::DESCRIPCIÓN <-
    });

    Route::controller(DigitalizacionArchivoController::class)->group( function() 
    {
        Route::middleware('role:OPER_DIG_23|SUPER_ADMIN')->group( function() 
        {
            Route::prefix('{digitalizacion}')->group( function()
            {
                #BEGIN::TAREAS -> procesos/digitalizacion-archivo/{digitalizacion}/{instanciaTarea}/ ruta-->
                Route::prefix('{instanciaTarea}')->group( function()
                {
                    #TAREA 01
                    Route::get('buscar-datos-expediente', "buscarDatosExpediente")->name('digitalizacion.archivos.buscar.datos.expediente');
                    Route::post('buscar-datos-expediente', "buscarDatosExpediente");
                    Route::post('expediente-encontrado/{noExpediente}', "expedienteEncontrado")->name('digitalizacion.archivos.expediente.encontrado');
                    #TAREA 02
                    Route::get('crear-ficha-expediente', "creacionExpediente")->name('digitalizacion.archivos.creacion.expediente');
                    Route::post('crear-ficha-expediente', "creacionExpediente");
                    #TAREA 03 
                    Route::get('actualizacion-expediente', "actualizacionExpediente")->name('digitalizacion.archivos.actualizacion.expediente');
                    Route::post('actualizacion-expediente', "actualizacionExpediente");

                    #CANCELAR PROCESO - TAREA (01 | 02)
                    Route::post('cancelar-proceso-digitalizacion-archivo', "cancelarProceso")->name('cancelar.proceso.digitalizacion.archivo');
                });
                #END::TAREAS
            
                Route::post('guardar-documento-digitalizacion', "guardarDocumento")->name('digitalizacion.archivo.guardar.documento');
            });
        });
    });
});

#BEGIN::REPORTES -> 
Route::group(['prefix' => 'reportes/digitalizacion-archivo'], function() {

    Route::controller(ReporteDigitalizacionArchivo::class)->group( function() 
    {
        Route::middleware('role:OPER_DIG_23|CTRL_EXP_23|SUPER_ADMIN')->group( function() 
        {
            #REPORTE 01
            Route::get('reporte-ejecutivo-detalle-digitalizacion', "reporteEjecutivoDetalleDigitalizacion")->name('reporte.ejecutivo.detalle.digitalizacion');
            Route::post('reporte-ejecutivo-detalle-digitalizacion', "reporteEjecutivoDetalleDigitalizacion");
            Route::post('reporte-ejecutivo-detalle-digitalizacion-pdf/{numero_expediente?}', "descargarReporteEjecutivoDetalleDigitalizacion")->name('descargar.pdf.reporte.ejecutivo.detalle.digitalizacion');
            #REPORTE 02
            Route::get('reporte-ejecutivo-digitalizacion-archivo', "reporteEjecutivoDigitalizacion")->name('reporte.ejecutivo.digitalizacion.archivo');
            Route::post('reporte-ejecutivo-digitalizacion-archivo', "reporteEjecutivoDigitalizacion");
            Route::post('reporte-ejecutivo-digitalizacion-archivo-pdf', "descargarReporteEjecutivoDigitalizacion")->name('descargar.pdf.reporte.ejecutivo.digitalizacion.archivo');
            #REPORTE 03
            Route::get('reporte-ejecutivo-expedientes-digitalizados', "reporteEjecutivoExpedientesDigitalizados")->name('reporte.ejecutivo.expedientes.digitalizados');
            Route::post('reporte-ejecutivo-expedientes-digitalizados', "reporteEjecutivoExpedientesDigitalizados");
            Route::post('descargar-reporte-ejecutivo-expedientes-digitalizados-pdf', "descargarReporteEjecutivoExpedientesDigitalizados")->name('descargar.pdf.reporte.ejecutivo.expedientes.digitalizados');
        });
    });

    // Reporte 4. REPORTE EJECUTIVO CÓDIGOS DE SEGURIDAD PARA SOLICITUD DE EXPEDIENTE
    Route::get('reporte-ejecutivo-codigos-seguridad', [ReporteDigitalizacionArchivo::class, "reporteEjecutivoCodigosSeguridad"])
        ->name('reporte.ejecutivo.codigos.seguridad')
        ->middleware('role:CTRL_EXP_23|SUPER_ADMIN');

    Route::post('reporte-ejecutivo-codigos-seguridad', [ReporteDigitalizacionArchivo::class, "reporteEjecutivoCodigosSeguridad"])
        ->middleware('role:CTRL_EXP_23|SUPER_ADMIN');

    Route::post('descargar-reporte-ejecutivo-codigos-seguridad/{folio?}/{tipo?}', [ReporteDigitalizacionArchivo::class, "descargarReporteEjecutivoCodigosSeguridad"])
    ->name('descargar.pdf.reporte.ejecutivo.codigos.seguridad')
    ->middleware('role:CTRL_EXP_23|SUPER_ADMIN');

    // Reporte 5. REPORTE EJECUTIVO SOLICITUD DE PRÉSTAMO DE ARCHIVO
    Route::get('reporte-ejecutivo-solicitud-prestamo-archivo', [ReporteDigitalizacionArchivo::class, "reporteEjecutivoSolicitudPrestamo"])
        ->name('reporte.ejecutivo.solicitud.prestamo.archivo')
        ->middleware('role:CTRL_EXP_23|SUPER_ADMIN');

    Route::post('reporte-ejecutivo-solicitud-prestamo-archivo', [ReporteDigitalizacionArchivo::class, "reporteEjecutivoSolicitudPrestamo"])
        ->middleware('role:CTRL_EXP_23|SUPER_ADMIN');

    Route::post('descargar-reporte-ejecutivo-solicitud-prestamo-archivo/{folio?}/{tipo?}', [ReporteDigitalizacionArchivo::class, "descargarReporteEjecutivoSolicitudPrestamo"])
    ->name('descargar.pdf.reporte.ejecutivo.solicitud.prestamo.archivo')
    ->middleware('role:CTRL_EXP_23|SUPER_ADMIN');

    // Reporte 6. REPORTE EJECUTIVO DETALLE DE PRÉSTAMO
    Route::get('reporte-ejecutivo-detalle-prestamo', [ReporteDigitalizacionArchivo::class, "reporteEjecutivoDetallePrestamo"])
        ->name('reporte.ejecutivo.detalle.prestamo')
        ->middleware('role:CTRL_EXP_23|SUPER_ADMIN');

    Route::post('reporte-ejecutivo-detalle-prestamo', [ReporteDigitalizacionArchivo::class, "reporteEjecutivoDetallePrestamo"])
        ->middleware('role:CTRL_EXP_23|SUPER_ADMIN');

    Route::post('descargar-reporte-ejecutivo-detalle-prestamo/{folio?}/{tipo?}', [ReporteDigitalizacionArchivo::class, "descargarReporteEjecutivoDetallePrestamo"])
    ->name('descargar.pdf.reporte.ejecutivo.detalle.prestamo')
    ->middleware('role:CTRL_EXP_23|SUPER_ADMIN');

});