<?php

use App\Http\Controllers\p06_servicio_social\sub_proceso\NominaController;

Route::group(['prefix' => 'procesos/servicio-social-nomina'], function(){

    Route::controller(NominaController::class)->group( function() 
    {
        #BEGIN::INICIO -> procesos/servicio-social-nomina/ ruta-->
        Route::middleware('role:PROG_SS|SUPER_ADMIN')->group( function() 
        {
            Route::get('descripcion', 'descripcion')->name('servicio.social.nomina.descripcion');
            Route::post('iniciar-proceso', 'iniciarProceso')->name('servicio.social.nomina.iniciar.proceso');
        });
        #END::INICIO <-

        #BEGIN::TAREAS -> procesos/servicio-social-nomina/{nomina}/{instanciaTarea}/ ruta-->
        Route::prefix('{nomina}/{instanciaTarea}')->group( function()
        {   
            Route::middleware('role:PROG_SS|SUPER_ADMIN')->group( function() 
            {
                #TAREA 01
                Route::get('seleccionar-nomina', 'seleccionarNomina')->name('servicio.social.sub.seleccion.tipo.nomina');
                Route::post('seleccionar-nomina', 'seleccionarNomina');
                #TAREA 03
                Route::get('cierre-nomina', 'cierreDeNomina')->name('servicio.social.sub.cierre.nomina');
                Route::post('cierre-nomina', 'cierreDeNomina');
                Route::post('finalizar-proceso-desde-T03', 'finalizarProcesoDesdeT03')->name('finalizar.proceso.desde.T03');
                #TAREA 04
                Route::get('generacion-nomina-xls', 'generacionNominaXLS')->name('servicio.social.sub.generacion.xls');
                Route::post('generacion-nomina-xls', 'generacionNominaXLS')->name('finalizar.proceso.desde.T04');
                Route::post('descargar-excel-nomina', 'descargarExcelNomina')->name('descargar.nomina.excel');
                //Route::post('finalizar-proceso', 'finalizarProcesoT04')->name('finalizar.proceso.desde.T04');
            });

            Route::middleware('role:SUB_EA|SUPER_ADMIN')->group( function() 
            {   
                #TAREA 02
                Route::get('validar-nomina', 'validacionNomina')->name('servicio.social.sub.validacion.nomina');
                Route::post('validar-nomina', 'validacionNomina');
            });
        });
        #END::TAREAS <-
    });
});
