<?php

use App\Http\Controllers\p02_tramites_issste\catalogos\NivelSalarialController;
use App\Http\Controllers\p02_tramites_issste\reportes\MovimientosISSSTEController;
use App\Http\Controllers\p02_tramites_issste\reportes\ProcesosTramiteISSSTEController;
use App\Http\Controllers\p02_tramites_issste\TramitesIsssteController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'procesos/tramites-issste'], function() {
	// Descripción
	Route::get('descripcion',
		[TramitesIsssteController::class, "descripcion"])
        ->name('tramites.issste.descripcion')
        ->middleware('role:SUPER_ADMIN|JUD_PRES');

    // Inicializar proceso Trámites ISSSTE
	Route::post('inicializar-proceso',
		[TramitesIsssteController::class, "inicializarProceso"])
        ->name('tramites.issste.inicializar.proceso')
        ->middleware('role:SUPER_ADMIN|JUD_PRES');

    // Mostrar T01 - Revisión de folios
	Route::get('{tramiteIssste}/{instanciaTarea}/revision-folios',
		[TramitesIsssteController::class, "revisarFolios"])
        ->name('tramites.issste.revision.folios')
        ->middleware('role:SUPER_ADMIN|JUD_PRES');

    // Guardar la T01 y crear la T02 - Respuesta del ISSSTE
	Route::post('{tramiteIssste}/{instanciaTarea}/revision-folios',
		[TramitesIsssteController::class, "revisarFolios"])
        ->middleware('role:SUPER_ADMIN|JUD_PRES');

	// Guardar Avances de la T01 vía Ajax
	Route::post('{tramiteIssste}/guaradar-avance-en-revision-folios',
		[TramitesIsssteController::class, "guardarAvanceEnrevisarFolios"])
        ->name('tramites.issste.guardar.avance.en.revision.folios')
        ->middleware('role:SUPER_ADMIN|JUD_PRES');

    // Mostrar T02 - Respuesta del ISSSTE
	Route::get('{tramiteIssste}/{instanciaTarea}/respuesta-del-issste',
		[TramitesIsssteController::class, "respuestaDelIssste"])
        ->name('tramites.issste.respuesta.issste')
        ->middleware('role:SUPER_ADMIN|JUD_PRES');

	// Guardar la T02 y crear la T03 - Corrección de folios rechazados por el ISSSTE
	Route::post('{tramiteIssste}/{instanciaTarea}/respuesta-del-issste',
		[TramitesIsssteController::class, "respuestaDelIssste"])
        ->middleware('role:SUPER_ADMIN|JUD_PRES');

    // Mostrar TR03 - Corrección de folios rechazados por el ISSSTE
	Route::get('{tramiteIssste}/{instanciaTarea}/corregir-folios-rechazados-por-issste',
		[TramitesIsssteController::class, "corregirFoliosRechazadosPorIssste"])
        ->name('tramites.issste.corregir.folios')
        ->middleware('role:SUPER_ADMIN|JUD_PRES');

	// Guardar la T02 y crear la T03 - Corrección de folios rechazados por el ISSSTE
	Route::post('{tramiteIssste}/{instanciaTarea}/corregir-folios-rechazados-por-issste',
		[TramitesIsssteController::class, "corregirFoliosRechazadosPorIssste"])
        ->middleware('role:SUPER_ADMIN|JUD_PRES');

    // Guardar Avances de la TR03 vía Ajax
	Route::post('{tramiteIssste}/guaradar-avance-en-correccion-de-folios',
		[TramitesIsssteController::class, "guardarAvanceEnCorreccionDeFolios"])
        ->name('tramites.issste.guardar.avance.en.correccion.de.folios')
        ->middleware('role:SUPER_ADMIN|JUD_PRES');

	// Archivos Issste
	Route::get('archivos-para-issste',
		[TramitesIsssteController::class, "archivosParaIssste"])
	    ->name('archivos.para.issste')
        ->middleware('role:SUPER_ADMIN|JUD_PRES');

	// Descarga el Excel de Archivos (Catálogo de Archivos para ISSSTE)
	Route::get('descargar-archivo-para-issste/{tramiteIssste?}/{tipoMovimientoIssste?}',
		[TramitesIsssteController::class, "descargarArchivosParaIssste"])
        ->name('descargar.archivos.para.issste')
        ->middleware('role:SUPER_ADMIN|JUD_PRES');

	// CATÁLOGOS
    Route::resource('niveles-salariales', NivelSalarialController::class)->parameters([
		"niveles-salariales" => "nivelSalarial"
	]);

	// REPORTES

	// Movimientos ante el ISSSTE
	Route::get('reportes/movimientos-issste',
		[MovimientosISSSTEController::class, "index"])
	    ->name('tramites.issste.reporte.movimientos')
	    ->middleware('role:SUPER_ADMIN|JUD_PRES');

	Route::get('reportes/movimientos-issste/buscar',
		[MovimientosISSSTEController::class, "buscar"])
	    ->name('tramites.issste.reporte.movimientos.buscar')
        ->middleware('role:SUPER_ADMIN|JUD_PRES');

	// Procesos trámites ISSSTE
    Route::get('reportes/procesos',
		[ProcesosTramiteISSSTEController::class, "index"])
	    ->name('tramites.issste.reporte.procesos')
	    ->middleware('role:SUPER_ADMIN|JUD_PRES');
    
	Route::get('reportes/procesos/buscar',
		[ProcesosTramiteISSSTEController::class, "buscar"])
	    ->name('tramites.issste.reporte.procesos.buscar')
	    ->middleware('role:SUPER_ADMIN|JUD_PRES');
});
