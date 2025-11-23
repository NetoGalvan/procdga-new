<?php

use App\Http\Controllers\p31_viatinet\SolicitudViaticoController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'procesos/viatinet'], function(){
	// Descripción
	Route::get('descripcion',
		[SolicitudViaticoController::class, 'descripcion'])
        ->name('viatinet.descripcion')
        ->middleware('role:SUPER_ADMIN|ENLACE_CAPTURA_VIATICO');
	// Inicializar proceso
	Route::post('inicializar-proceso',
		[SolicitudViaticoController::class, 'inicializarProceso'])
	->name('viatinet.inicializar.proceso')
	->middleware('role:SUPER_ADMIN|ENLACE_CAPTURA_VIATICO');

    // Mostrar tarea 01 - Solicitud de viático
	Route::get('{solicitudViatico}/{instanciaTarea}/solicitud-viatico',
		[SolicitudViaticoController::class, 'solicitudViatico'])
	->name('viatinet.solicitud.viatico')
	->middleware('role:SUPER_ADMIN|ENLACE_CAPTURA_VIATICO');
	// Guardar tarea 01 - Solicitud de viático
	Route::post('{solicitudViatico}/{instanciaTarea}/solicitud-viatico',
		[SolicitudViaticoController::class, 'solicitudViatico'])
	->middleware('role:SUPER_ADMIN|ENLACE_CAPTURA_VIATICO');

    // Mostrar tarea 02 - Agregar comisionados
	Route::get('{solicitudViatico}/{instanciaTarea}/agregar-comisionados',
		[SolicitudViaticoController::class, 'agregarComisionados'])
	->name('viatinet.agregar.comisionados')
	->middleware('role:SUPER_ADMIN|ENLACE_CAPTURA_VIATICO');
	// Guardar tarea 02 - Agregar comisionados
	Route::post('{solicitudViatico}/{instanciaTarea}/agregar-comisionados',
		[SolicitudViaticoController::class, 'agregarComisionados'])
	->middleware('role:SUPER_ADMIN|ENLACE_CAPTURA_VIATICO');

	// Mostrar tarea 03 - Aceptar términos y condiciones
	Route::get('{solicitudViatico}/{instanciaTarea}/terminos-y-condiciones',
		[SolicitudViaticoController::class, 'consultarTerminos'])
	->name('viatinet.consultar.terminos')
	->middleware('role:SUPER_ADMIN|ENLACE_CAPTURA_VIATICO');
	// Guardar tarea 03 - Aceptar términos y condiciones
	Route::post('{solicitudViatico}/{instanciaTarea}/terminos-y-condiciones',
		[SolicitudViaticoController::class, 'consultarTerminos'])
	->middleware('role:SUPER_ADMIN|ENLACE_CAPTURA_VIATICO');

    // Mostrar tarea 04 - Validar solicitud - titular del órgano
	Route::get('{solicitudViatico}/{instanciaTarea}/validar-solicitud-titular-organo',
		[SolicitudViaticoController::class, 'validarSolicitudTitularOrgano'])
	->name('viatinet.revision.organo')
	->middleware('role:SUPER_ADMIN|TITULAR_ORGANO');
	// Guardar tarea 04 - Validar solicitud - titular del órgano
	Route::post('{solicitudViatico}/{instanciaTarea}/validar-solicitud-titular-organo',
		[SolicitudViaticoController::class, 'validarSolicitudTitularOrgano'])
	->middleware('role:SUPER_ADMIN|TITULAR_ORGANO');

    // Mostrar tarea 05 - Validar solicitud - titular del SAF
	Route::get('{solicitudViatico}/{instanciaTarea}/validar-solicitud-titular-saf',
		[SolicitudViaticoController::class, 'validarSolicitudTitularSAF'])
	->name('viatinet.revision.administracion')
	->middleware('role:SUPER_ADMIN|TITULAR_ADMINISTRACION');
	// Guardar tarea 05 - Validar solicitud - titular del SAF
	Route::post('{solicitudViatico}/{instanciaTarea}/validar-solicitud-titular-saf',
		[SolicitudViaticoController::class, 'validarSolicitudTitularSAF'])
	->middleware('role:SUPER_ADMIN|TITULAR_ADMINISTRACION');

    // Mostrar tarea 06 - Autorización solicitud
	Route::get('{solicitudViatico}/{instanciaTarea}/autorizar-solicitud',
		[SolicitudViaticoController::class, 'autorizarSolicitud'])
	->name('viatinet.autorizacion')
	->middleware('role:SUPER_ADMIN|AUTORIZADOR_VIATICO');
	// Guardar tarea 06 - Autorización solicitud
	Route::post('{solicitudViatico}/{instanciaTarea}/autorizar-solicitud',
		[SolicitudViaticoController::class, 'autorizarSolicitud'])
	->middleware('role:SUPER_ADMIN|AUTORIZADOR_VIATICO');

    // Mostrar tarea 07 - Comprobación de gastos
	Route::get('{solicitudViatico}/{instanciaTarea}/comprobacion-gastos',
		[SolicitudViaticoController::class, 'comprobarGastos'])
	->name('viatinet.comprobacion.gastos')
	->middleware('role:SUPER_ADMIN|AUTORIZADOR_VIATICO|ENLACE_CAPTURA_VIATICO');
	// Guardad tarea 07 - Comprobación de gastos
	Route::post('{solicitudViatico}/{instanciaTarea}/comprobacion-gastos',
		[SolicitudViaticoController::class, 'comprobarGastos'])
	->middleware('role:SUPER_ADMIN|AUTORIZADOR_VIATICO|ENLACE_CAPTURA_VIATICO');



	// Guardar documentos
	Route::post('{solicitudViatico}/guardar-documentos',
		[SolicitudViaticoController::class, "guardarDocumentos"])
	->name('viatinet.guardar.documentos')
	->middleware('role:SUPER_ADMIN|ENLACE_CAPTURA_VIATICO');

	// Guardar comisionados
	Route::post('{solicitudViatico}/guardar-comisionados',
		[SolicitudViaticoController::class, "guardarComisionados"])
	->name('viatinet.guardar.comisionados')
	->middleware('role:SUPER_ADMIN|ENLACE_CAPTURA_VIATICO');

	// Eliminar comisionado
	Route::post('{solicitudViatico}/eliminar-comisionados',
		[SolicitudViaticoController::class, "eliminarComisionados"])
	->name('viatinet.eliminar.comisionados')
	->middleware('role:SUPER_ADMIN|ENLACE_CAPTURA_VIATICO');

	// Obtener municipios
	Route::get('getMunicipios', [SolicitudViaticoController::class, 'getMunicipios'])
		->name('viatinet.getMunicipios')
		->middleware('role:SUPER_ADMIN|ENLACE_CAPTURA_VIATICO');

});
