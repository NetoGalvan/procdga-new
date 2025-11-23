<?php

use App\Http\Controllers\p22_reportes_dias_efectivamente_laborados\ReporteDiasEfectivamenteLaboradosController;

Route::group(['prefix' => 'procesos/reportes-dias-efectivamente-laborados'], function()
{
    Route::controller(ReporteDiasEfectivamenteLaboradosController::class)->group( function() 
    {
        Route::middleware('role:ADMN_REP_22|SUPER_ADMIN')->group( function()
        {
            #BEGIN::INICIO -> procesos/reportes-dias-efectivamente-laborados/{reportes}/ ruta -->
            Route::get('descripcion', 'descripcion')->name('reportes.dias.efectivamente.laborados.descripcion');
            Route::post('iniciar-proceso', 'iniciarProceso')->name('reportes.dias.efectivamente.laborados.iniciar.proceso');
            #END::INICIO <-

            #BEGIN::TAREAS -> procesos/reportes-dias-efectivamente-laborados/{reportes}/{instanciaTarea}/ ruta -->
            Route::prefix('{reportes}/{instanciaTarea}')->group( function() {
                #TAREA 01
                Route::get('seleccion-reporte', 'seleccionReporte')->name('reportes.dias.efectivamente.laborados.seleccion.reporte');
                Route::post('seleccion-reporte', 'seleccionReporte')->name('post.p22.seleccionar_reporte');
                Route::post('cancelar-proceso-reporte-dias', 'cancelarProceso')->name('cancelar.proceso.reporte.dias');
                #TAREA 02
                Route::get('revision-concentrado-empleados', 'revisionConcentradoEmpleados')->name('reportes.dias.efectivamente.laborados.revision.concentrado.empleados');
                Route::post('revision-concentrado-empleados', 'revisionConcentradoEmpleados')->name('post.revision.centrado.empleados');
                
                #TAREA 03
                Route::get('generacion-reporte', 'generacionReporte')->name('reportes.dias.efectivamente.laborados.generacion.reporte');
                Route::post('generacion-reporte', 'generacionReporte')->name('post.generacion.reporte');
            });
            #END::TAREAS <-

            #BEGIN::OTHERS -> 
            Route::get('pdf-listado-empleados/{reporte_id}', 'descargarListadoEmpleadosEvaluacion')->name('descargar.pdf.listado.empleados.evaluacion');
            Route::post('agregar-empleado/{reporte_id}', 'tableEmpleadosAgregados')->name('post.agregar_empleado');
            // Descargar reporte multas federales, locales y escalofon
            Route::post('excel-reporte/{reporte}', 'descargarReportes')->name('descargar.excel.reporte');
            // Descargar reporte multas federales
            Route::post('excel-reporte-layout-locales/{p22_reporte_id?}', 'descargarReporteLayout')->name('descargar.excel.layout.locales');
            #END::OTHERS <-
        });         
    });
});