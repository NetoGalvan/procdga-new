<?php

use App\Http\Controllers\p32_tramites_kerdex\TramitesKardexController;
use App\Http\Controllers\p32_tramites_kerdex\ReportesTramitesKardex;

Route::group(['prefix' => 'procesos/tramites-kardex'], function(){

    // TAREAS
    Route::get('descripcion', [TramitesKardexController::class, "descripcion"])
        ->name('tramites.kardex.descripcion')
        ->middleware('role:CAPTURA_KARDEX|SUPER_ADMIN');

    Route::post('iniciar-proceso', [TramitesKardexController::class, "iniciarProceso"])
        ->name('tramites.kardex.iniciar.proceso')
        ->middleware('role:CAPTURA_KARDEX|SUPER_ADMIN');

	// Mostrar tarea T01
	Route::get('{tramiteKardex}/{instanciaTarea}/seleccion-solicitud-tramite-kardex', [TramitesKardexController::class, "seleccionarSolicitudTramiteKardex"])
        ->name('tramites.kardex.solicitud.tramites')
        ->middleware('role:CAPTURA_KARDEX|SUPER_ADMIN');

    Route::post('{tramiteKardex}/{instanciaTarea}/seleccion-solicitud-tramite-kardex', [TramitesKardexController::class, "seleccionarSolicitudTramiteKardex"])
        ->middleware('role:CAPTURA_KARDEX|SUPER_ADMIN');

    // Mostrar tarea T02
	Route::get('{tramiteKardex}/{instanciaTarea}/asignacion-tramites-kardex', [TramitesKardexController::class, "asignacionTramitesKardex"])
        ->name('tramites.kardex.asigancion.tramites')
        ->middleware('role:ADMIN_KARDEX|SUPER_ADMIN');

    Route::post('{tramiteKardex}/{instanciaTarea}/asignacion-tramites-kardex', [TramitesKardexController::class, "asignacionTramitesKardex"])
        ->middleware('role:ADMIN_KARDEX|SUPER_ADMIN');

    // Mostrar tarea T03 HOJAS DE SERVICIO
	Route::get('{tramiteKardex}/{instanciaTarea}/generacion-documento-tramite-kardex-hojas-servicio', [TramitesKardexController::class, "generacionDocumentoTramiteKardexHojasServicio"])
        ->name('tramites.kardex.generacion.documento.hojas.servicio')
        ->middleware('role:TECNICO_OPERATIVO_KARDEX|SUPER_ADMIN');

    Route::post('{tramiteKardex}/{instanciaTarea}/generacion-documento-tramite-kardex-hojas-servicio', [TramitesKardexController::class, "generacionDocumentoTramiteKardexHojasServicio"])
        ->middleware('role:TECNICO_OPERATIVO_KARDEX|SUPER_ADMIN');

    // Mostrar tarea T03 COMPROBANTES DE SERVICIO
	Route::get('{tramiteKardex}/{instanciaTarea}/generacion-documento-tramite-kardex-comprobante-servicio', [TramitesKardexController::class, "generacionDocumentoTramiteKardexComprobantesServicio"])
        ->name('tramites.kardex.generacion.documento.comprobantes.servicio')
        ->middleware('role:TECNICO_OPERATIVO_KARDEX|SUPER_ADMIN');

    Route::post('{tramiteKardex}/{instanciaTarea}/generacion-documento-tramite-kardex-comprobante-servicio', [TramitesKardexController::class, "generacionDocumentoTramiteKardexComprobantesServicio"])
        ->middleware('role:TECNICO_OPERATIVO_KARDEX|SUPER_ADMIN');

    // Guardar seguimientos parte de T03
    Route::post('guardar-seguimientos', [TramitesKardexController::class, "guardarSeguimientos"])
        ->name('tramites.kardex.guardar.seguimientos')
        ->middleware('role:TECNICO_OPERATIVO_KARDEX|SUPER_ADMIN');

    // Eliminar seguimientos parte de T03
    Route::post('eliminar-seguimientos', [TramitesKardexController::class, "eliminarSeguimientos"])
        ->name('tramites.kardex.eliminar.seguimientos')
        ->middleware('role:TECNICO_OPERATIVO_KARDEX|SUPER_ADMIN');

    // Guardar detalles parte de T03
    Route::post('guardar-detalles', [TramitesKardexController::class, "guardarDetalles"])
        ->name('tramites.kardex.guardar.detalles')
        ->middleware('role:TECNICO_OPERATIVO_KARDEX|SUPER_ADMIN');

    // Eliminar detalles parte de T03
    Route::post('eliminar-detalles', [TramitesKardexController::class, "eliminarDetalles"])
        ->name('tramites.kardex.eliminar.detalles')
        ->middleware('role:TECNICO_OPERATIVO_KARDEX|SUPER_ADMIN');

    // Mostrar tarea T04
	Route::get('{tramiteKardex}/{instanciaTarea}/descargar-documento-tramite-kardex', [TramitesKardexController::class, "descargarDocumentoTramiteKardex"])
        ->name('tramites.kardex.descargar.documento')
        ->middleware('role:ADMIN_KARDEX|SUPER_ADMIN');

    Route::post('{tramiteKardex}/{instanciaTarea}/descargar-documento-tramite-kardex', [TramitesKardexController::class, "descargarDocumentoTramiteKardex"])
        ->middleware('role:ADMIN_KARDEX|SUPER_ADMIN');

    // Descargar seguimientos parte de T04
    Route::get('{tramiteKardex}/descargar-documento-tramite-kardex-seguimientos', [TramitesKardexController::class, "descargarDocumentoTramiteKardexSeguimientos"])
        ->name('tramites.kardex.descargar.documento.seguimientos')
        ->middleware('role:ADMIN_KARDEX|SUPER_ADMIN');

    // Descargar detalles parte de T04
    Route::get('{tramiteKardex}/descargar-documento-tramite-kardex-detalles', [TramitesKardexController::class, "descargarDocumentoTramiteKardexDetalles"])
        ->name('tramites.kardex.descargar.documento.detalles')
        ->middleware('role:ADMIN_KARDEX|SUPER_ADMIN');

    // Mostrar vista de la sección TRAMITES (listado)
	Route::get('tramite-kardex-detalles-proceso', [TramitesKardexController::class, "tramiteKardexDetallesProcesoListado"])
        ->name('tramites.kardex.detalles.proceso')
        ->middleware('role:CAPTURA_KARDEX|TECNICO_OPERATIVO_KARDEX|ADMIN_KARDEX|SUPER_ADMIN');

    Route::post('tramite-kardex-detalles-proceso', [TramitesKardexController::class, "tramiteKardexDetallesProcesoListado"])
        ->middleware('role:CAPTURA_KARDEX|TECNICO_OPERATIVO_KARDEX|ADMIN_KARDEX|SUPER_ADMIN');

    // Mostrar vista de la sección TRAMITES (Ver detalle del trámite)
	Route::get('{tramiteKardex?}/tramite-kardex-ver-detalles-proceso', [TramitesKardexController::class, "tramiteKardexVerDetallesProceso"])
        ->name('tramites.kardex.ver.detalles.proceso')
        ->middleware('role:CAPTURA_KARDEX|TECNICO_OPERATIVO_KARDEX|ADMIN_KARDEX|SUPER_ADMIN');

    Route::post('{tramiteKardex?}/tramite-kardex-ver-detalles-proceso', [TramitesKardexController::class, "tramiteKardexVerDetallesProceso"])
        ->middleware('role:CAPTURA_KARDEX|TECNICO_OPERATIVO_KARDEX|ADMIN_KARDEX|SUPER_ADMIN');


    Route::get('catalogos/formato-principal', [TramitesKardexController::class, "indexFormatoPrincipal"])
        ->name("tramite.kardex.catalogo.formato_principal")
        ->middleware('role:SUPER_ADMIN|SUPER_ADMIN');
    
    Route::post('catalogos/formato-principal/guardar', [TramitesKardexController::class, "guardarAtributosFormatoPrincipal"])
        ->name("tramite.kardex.catalogo.formato_principal.guardar")
        ->middleware('role:SUPER_ADMIN|SUPER_ADMIN');
});

Route::group(['prefix' => 'reportes/tramites-kardex'], function(){

    // Reporte 1. REPORTE EJECUTIVO DETALLE DE DIGITALIZACIÓN
    Route::get('reportes', [ReportesTramitesKardex::class, "reportesTramitesKardex"])
        ->name('reporte.procesos.tramites.kardex')
        ->middleware('role:ADMIN_KARDEX|SUPER_ADMIN');

    Route::post('reportes', [ReportesTramitesKardex::class, "reportesTramitesKardex"])
        ->middleware('role:ADMIN_KARDEX|SUPER_ADMIN');

    Route::post('reportes-filtrar', [ReportesTramitesKardex::class, "filtrarTramites"])
        ->name('tramites.kardex.reporte.filtrar')
        ->middleware('role:ADMIN_KARDEX|SUPER_ADMIN');

    Route::get('reportes-imprimir-detalles/{folio?}/{tipo?}', [ReportesTramitesKardex::class, "descargarDetalles"])
        ->name('descargar.reporte.detalles')
        ->middleware('role:ADMIN_KARDEX|SUPER_ADMIN');

    Route::get('reportes-imprimir-seguimientos/{folio?}/{tipo?}', [ReportesTramitesKardex::class, "descargarSeguimientos"])
        ->name('descargar.reporte.seguimientos')
        ->middleware('role:ADMIN_KARDEX|SUPER_ADMIN');

    Route::get('reportes-generar-excel/{fecha_de?}/{fecha_a?}/{folio?}/{tipo_tramite?}/{estatus_historico?}/{estatus_local?}/{buscar_en?}', [ReportesTramitesKardex::class, "generarExcelReporteHojasServicio"])
        ->name('descargar.reporte.general.kardex.excel')
        ->middleware('role:ADMIN_KARDEX|SUPER_ADMIN');
});