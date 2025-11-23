<?php

use App\Http\Controllers\p16_pago_tiempo_extraordinario_excedente\TiempoExtraExcedenteController;
use App\Http\Controllers\p16_pago_tiempo_extraordinario_excedente\SubprocesoTiempoExtraExcedenteController;
use App\Http\Controllers\p16_pago_tiempo_extraordinario_excedente\P16CatalogosController;
use App\Http\Controllers\p16_pago_tiempo_extraordinario_excedente\ReportesPagoTiempoExtra;

Route::group(['prefix' => 'procesos/tiempo-extraordinario-excedente'], function(){
// DESCRIPCIÓN
    //Descripción del proceso
	Route::get('descripcion',[TiempoExtraExcedenteController::class, 'descripcion'])
        ->name('tiempo.extraordinario.excedente.descripcion')
        ->middleware('role:ADMIN_TIEMPO_EXTRA|SUPER_ADMIN');
    //Inicializar p16 y tarea 1
    Route::post('inicializar-proceso',[TiempoExtraExcedenteController::class, 'inicializarProceso'])
        ->name('tiempo.extraordinario.excedente.inicializar.proceso')
        ->middleware('role:ADMIN_TIEMPO_EXTRA|SUPER_ADMIN');
// TAREA 1
    //GET - Vista de la tarea 1
    //POST - 1.4 finaliza tarea
    Route::match(['get', 'post'],'{pago}/{instanciaTarea}/asignar-presupuesto-por-area',[TiempoExtraExcedenteController::class, 'asignarPresupuestoPorAreas'])
        ->name('tiempo.extraordinario.excedente.presupuesto.por.area')
        ->middleware('role:ADMIN_TIEMPO_EXTRA|SUPER_ADMIN');
    //1.1 almacenar tipo y periodo de presupuesto
    Route::post('tipo-periodo', [TiempoExtraExcedenteController::class, 'guardaTipoPeriodo'])
        ->name('tiempo.extraordinario.excedente.guardar.tipo.periodo')
        ->middleware('role:ADMIN_TIEMPO_EXTRA|SUPER_ADMIN');
    //1.2 obtener areas por unidad administrativa
    Route::post('areas-en-catalogo', [TiempoExtraExcedenteController::class, 'areasEnCatalogos'])
        ->name('tiempo.extraordinario.excedente.areas.en.catalogos')
        ->middleware('role:ADMIN_TIEMPO_EXTRA|SUPER_ADMIN');
    //1.3 guardar los presupustos asignados por area
    Route::post('asignar-presupuesto', [TiempoExtraExcedenteController::class, 'asignarPresupuesto'])
        ->name('tiempo.extraordinario.excedente.asignar.presupuesto')
        ->middleware('role:ADMIN_TIEMPO_EXTRA|SUPER_ADMIN');
    Route::post('eliminar-unidad', [TiempoExtraExcedenteController::class, 'eliminarUnidad'])
        ->name('tiempo.extraordinario.excedente.eliminar.unidad')
        ->middleware('role:ADMIN_TIEMPO_EXTRA|SUPER_ADMIN');
//SUBPROCESO 1.1
    Route::match(['GET','POST'],'{subPago}/{instanciaTarea}/asignar-presupuesto-areas',[SubprocesoTiempoExtraExcedenteController::class, 'asignarPresupuestoSub'])
        ->name('tiempo.extraordinario.excedente.asignacion.presupuesto.areas')
        ->middleware('role:SUB_EA|SUPER_ADMIN');
    Route::post('asignar-presupuesto-sub-areas', [SubprocesoTiempoExtraExcedenteController::class, 'asignarPresupuestoSubAreas'])
        ->name('tiempo.extraordinario.excedente.asignar.presupuesto.sub.areas')
        ->middleware('role:SUB_EA|SUPER_ADMIN');
//SUBPROCESO 1.2
    Route::match(['GET','POST'],'{subPago}/{instanciaTarea}/asignar-horas-por-empleado',[SubprocesoTiempoExtraExcedenteController::class, 'asignarHorasEmpleado'])
        ->name('tiempo.extraordinario.excedente.horas.por.empleado')
        ->middleware('role:OPER_TIEMPO_EXTRA|SUPER_ADMIN');
    Route::post('agregar-empleado', [SubprocesoTiempoExtraExcedenteController::class, 'agregarEmpleado'])
        ->name('tiempo.extraordinario.excedente.agregar.empleado')
        ->middleware('role:ADMIN_TIEMPO_EXTRA|SUPER_ADMIN|OPER_TIEMPO_EXTRA');
    Route::post('guardar-datos-empleado-automaticamente', [SubprocesoTiempoExtraExcedenteController::class, 'guardarDatosAutomaticamente'])
        ->name('tiempo.extraordinario.excedente.guardar.empleado.automaticamente')
        ->middleware('role:ADMIN_TIEMPO_EXTRA|SUPER_ADMIN|OPER_TIEMPO_EXTRA');
    Route::post('guardar-observaciones-empleado-automaticamente', [SubprocesoTiempoExtraExcedenteController::class, 'guardarObservacionesAutomaticamente'])
        ->name('tiempo.extraordinario.excedente.guardar.observaciones.automaticamente')
        ->middleware('role:ADMIN_TIEMPO_EXTRA|SUPER_ADMIN|OPER_TIEMPO_EXTRA');
    Route::post('borrar-empleado-por-area', [SubprocesoTiempoExtraExcedenteController::class, 'borrarEmpleados'])
        ->name('tiempo.extraordinario.excedente.borrar.empleado')
        ->middleware('role:ADMIN_TIEMPO_EXTRA|SUPER_ADMIN|OPER_TIEMPO_EXTRA');
    Route::post('calcular-monto-bruto', [SubprocesoTiempoExtraExcedenteController::class, 'calcularMontoBruto'])
        ->name('tiempo.extraordinario.excedente.calcular.monto.bruto')
        ->middleware('role:ADMIN_TIEMPO_EXTRA|SUPER_ADMIN|OPER_TIEMPO_EXTRA');
    Route::post('validarEmpleadoP16', [SubprocesoTiempoExtraExcedenteController::class, "validarEmpleado"])
        ->name('validar.empleado.premio.p16')
        ->middleware('role:OPER_TIEMPO_EXTRA|SUPER_ADMIN');
// SUBPROCESO 1.3
    Route::match(['GET','POST'],'{subPago}/{instanciaTarea}/revision-horas-sub-areas',[SubprocesoTiempoExtraExcedenteController::class, 'revisionHorasSubarea'])
        ->name('tiempo.extraordinario.excedente.revision.sub.areas')
        ->middleware('role:SUB_EA|SUPER_ADMIN');
    Route::get('descarga-reporte-por-subarea/{subarea_id?}', [SubprocesoTiempoExtraExcedenteController::class, 'descargaReporteSubArea'])
        ->name('tiempo.extraordinario.excedente.descarga.reporte.subarea')
        ->middleware('role:SUB_EA|SUPER_ADMIN');
    Route::get('descarga-reporte-general-subareas', [SubprocesoTiempoExtraExcedenteController::class, 'descargaReporteGeneralSubareas'])
        ->name('tiempo.extraordinario.excedente.descarga.reporte.general.subareas')
        ->middleware('role:SUB_EA|SUPER_ADMIN');
    Route::post('rechazar-tarea-subarea/{subPago}/{instanciaTarea}', [SubprocesoTiempoExtraExcedenteController::class, 'rechazarTareaSubarea'])
        ->name('tiempo.extraordinario.excedente.rechazar.tarea.subarea')
        ->middleware('role:SUB_EA|SUPER_ADMIN');
// TAREA 2
    Route::match(['GET','POST'],'{pago}/{instanciaTarea}/revisar-horas-por-empleado',[TiempoExtraExcedenteController::class, 'revisarHorasEmpleado'])
        ->name('tiempo.extraordinario.excedente.revision.por.empleado')
        ->middleware('role:ADMIN_TIEMPO_EXTRA|SUPER_ADMIN');
    Route::get('descarga-reporte/{folio?}', [TiempoExtraExcedenteController::class, 'descargaReporte'])
        ->name('tiempo.extraordinario.excedente.descarga.reporte')
        ->middleware('role:ADMIN_TIEMPO_EXTRA|SUPER_ADMIN');
    Route::get('descarga-reporte-general', [TiempoExtraExcedenteController::class, 'descargaReporteGeneral'])
        ->name('tiempo.extraordinario.excedente.descarga.reporte.general')
        ->middleware('role:ADMIN_TIEMPO_EXTRA|SUPER_ADMIN');

// Catálogo presupuesto anual
    Route::group(['prefix'=>'catalogo-presupuesto-anual'],function(){
        //Index
        Route::get('/',[P16CatalogosController::class, 'catalogoAnualVista'])
            ->name('tiempo.extraordinario.excedente.catalogo.anual')
            ->middleware('role:ADMIN_TIEMPO_EXTRA|SUPER_ADMIN');
        // Data for Datatable
        Route::get('/presupuestos/{year?}', [P16CatalogosController::class, 'catalogoAnualData'])
            ->name('tiempo.extraordinario.excedente.catalogo.anual.data')
            ->middleware('role:ADMIN_TIEMPO_EXTRA|SUPER_ADMIN');
        // Create
        Route::post('/create',[P16CatalogosController::class, 'catalogoAnualCreate'])
            ->name('tiempo.extraordinario.excedente.catalogo.anual.create')
            ->middleware('role:ADMIN_TIEMPO_EXTRA|SUPER_ADMIN');
        // Edit Modal
        Route::post('/edit', [P16CatalogosController::class, 'catalogoAnualModalEdit'])
            ->name('tiempo.extraordinario.excedente.catalogo.anual.modal.edit')
            ->middleware('role:ADMIN_TIEMPO_EXTRA|SUPER_ADMIN');
        // Edit
        Route::post('/update', [P16CatalogosController::class, 'catalogoAnualEdit'])
            ->name('tiempo.extraordinario.excedente.catalogo.anual.edit')
            ->middleware('role:ADMIN_TIEMPO_EXTRA|SUPER_ADMIN');
    });
// Catálogo tabulador de sueldos
    Route::group(['prefix' => 'catalogo-tabulador-sueldos'], function () {
        //Index
        Route::get('/', [P16CatalogosController::class, 'catalogoTabuladoresVista'])
            ->name('tiempo.extraordinario.excedente.catalogo.tabuladores')
            ->middleware('role:ADMIN_TIEMPO_EXTRA|SUPER_ADMIN');
        // Data for Datatable
        Route::get('/presupuestos/{year?}', [P16CatalogosController::class, 'catalogoTabuladoresData'])
            ->name('tiempo.extraordinario.excedente.catalogo.tabuladores.data')
            ->middleware('role:ADMIN_TIEMPO_EXTRA|SUPER_ADMIN');
        // Create
        Route::post('/create', [P16CatalogosController::class, 'catalogoTabuladoresCreate'])
            ->name('tiempo.extraordinario.excedente.catalogo.tabuladores.create')
            ->middleware('role:ADMIN_TIEMPO_EXTRA|SUPER_ADMIN');
        // Edit Modal
        Route::post('/edit', [P16CatalogosController::class, 'catalogoTabuladoresModalEdit'])
            ->name('tiempo.extraordinario.excedente.catalogo.tabuladores.modal.edit')
            ->middleware('role:ADMIN_TIEMPO_EXTRA|SUPER_ADMIN');
        // Edit
        Route::post('/update', [P16CatalogosController::class, 'catalogoTabuladoresEdit'])
            ->name('tiempo.extraordinario.excedente.catalogo.tabuladores.edit')
            ->middleware('role:ADMIN_TIEMPO_EXTRA|SUPER_ADMIN');
        Route::post('/eliminar-tabulador', [P16CatalogosController::class, 'eliminarTabulador'])
            ->name('tiempo.extraordinario.excedente.eliminar.tabulador')
            ->middleware('role:ADMIN_TIEMPO_EXTRA|SUPER_ADMIN');
    });
});

Route::group(['prefix' => 'reportes/pago-tiempo-extra'], function(){
    // Reporte 1. REPORTE DE EMPLEADOS INCLUIDOS EN EL PAGO DE TIEMPO EXTRA Y EXCEDENTE
    Route::get('reporte-empleados-incluidos-pago', [ReportesPagoTiempoExtra::class, "reporteEmpleadosIncluidosPago"])
    ->name('reporte.empleados.incluidos')
    ->middleware('role:ADMIN_TIEMPO_EXTRA|SUB_EA|SUPER_ADMIN');

    Route::post('reporte-empleados-incluidos-pago', [ReportesPagoTiempoExtra::class, "reporteEmpleadosIncluidosPago"])
        ->middleware('role:ADMIN_TIEMPO_EXTRA|SUB_EA|SUPER_ADMIN');

    Route::get('reporte-empleados-incluidos-pago-pdf/{folio?}', [ReportesPagoTiempoExtra::class, "descargarReporteEmpleadosIncluidosPago"])
    ->name('descargar.pdf.reporte.empleados.incluidos')
    ->middleware('role:ADMIN_TIEMPO_EXTRA|SUB_EA|SUPER_ADMIN');

    Route::post('reporte-empleados-incluidos-pago-buscar', [ReportesPagoTiempoExtra::class, "reporteEmpleadosIncluidosPagoBuscar"])
    ->name('reporte.empleados.incluidos.buscar')
    ->middleware('role:ADMIN_TIEMPO_EXTRA|SUB_EA|SUPER_ADMIN');

    // Reporte 2. REPORTE EJECUTIVO DE PROCESOS EJECUTADOS PARA PAGO DE TIEMPO EXTRA Y EXCEDENTE
    Route::get('reporte-ejecutivo-procesos-ejecutados', [ReportesPagoTiempoExtra::class, "reporteEjecutivoProcesosEjecutados"])
    ->name('reporte.ejecutivo.procesos.ejecutados')
    ->middleware('role:ADMIN_TIEMPO_EXTRA|SUB_EA|SUPER_ADMIN');

    Route::post('reporte-ejecutivo-procesos-ejecutados', [ReportesPagoTiempoExtra::class, "reporteEjecutivoProcesosEjecutados"])
        ->middleware('role:ADMIN_TIEMPO_EXTRA|SUB_EA|SUPER_ADMIN');

    Route::get('reporte-ejecutivo-procesos-ejecutados-pdf/{fechaInicio?}/{fechaFinal?}', [ReportesPagoTiempoExtra::class, "descargarReporteEjecutivoProcesosEjecutados"])
    ->name('descargar.pdf.reporte.ejecutivo.procesos.ejecutados')
    ->middleware('role:ADMIN_TIEMPO_EXTRA|SUB_EA|SUPER_ADMIN');

    Route::post('reporte-ejecutivo-procesos-ejecutados-buscar', [ReportesPagoTiempoExtra::class, "reporteEjecutivoProcesosEjecutadosBuscar"])
    ->name('reporte.ejecutivo.procesos.ejecutados.buscar')
    ->middleware('role:ADMIN_TIEMPO_EXTRA|SUB_EA|SUPER_ADMIN');
});
