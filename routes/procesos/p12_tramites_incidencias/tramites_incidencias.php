<?php

use App\Http\Controllers\p12_tramites_incidencias\TramiteIncidenciaController;
use App\Http\Controllers\p12_tramites_incidencias\catalogos\TipoIncidenciaController;
use App\Http\Controllers\p12_tramites_incidencias\reportes\IncidenciasPorEmpleadoController;
use App\Http\Controllers\p12_tramites_incidencias\reportes\DiasAcumuladosController;
use App\Http\Controllers\p12_tramites_incidencias\reportes\IncidenciasAutorizadasArchivoController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'procesos/incidencias'], function() {
	// DESCRIPCIÓN
	Route::get('descripcion',
        [TramiteIncidenciaController::class, "descripcion"])
        ->name('tramite.incidencia.descripcion')
        ->middleware('role:SUPER_ADMIN|CAPT_KDX|INI_JUST|EMPLEADO_GRAL');

    // INICIALIZAR EL PROCESO INCIDENCIAS
    Route::post('inicializar-proceso',
        [TramiteIncidenciaController::class, "inicializarProceso"])
        ->name('tramite.incidencia.iniciar.proceso')
        ->middleware('role:SUPER_ADMIN|CAPT_KDX|INI_JUST|EMPLEADO_GRAL');

    // TAREAS Y NOTIFICACIONES
    Route::group(['middleware' => 'has.permission.task'], function() {
        // MOSTRAR T01 - Seleccionar Tipo Captura
        Route::get('{tramiteIncidencia}/{instanciaTarea}/seleccionar-tipo-captura',
            [TramiteIncidenciaController::class, "seleccionarTipoCaptura"])
            ->name('tramite.incidencia.seleccionar.tipo.captura')
            ->middleware('role:SUPER_ADMIN|CAPT_KDX|INI_JUST|EMPLEADO_GRAL');
        // Guardar T01 - Seleccionar Tipo Captura
        Route::post('{tramiteIncidencia}/{instanciaTarea}/seleccionar-tipo-captura',
            [TramiteIncidenciaController::class, "seleccionarTipoCaptura"])
            ->middleware('role:SUPER_ADMIN|CAPT_KDX|INI_JUST|EMPLEADO_GRAL');
        // MOSTRAR T02 - ALTA DE INCIDENCIA
        Route::get('{tramiteIncidencia}/{instanciaTarea}/alta-incidencia',
            [TramiteIncidenciaController::class, "altaIncidencia"])
            ->name('tramite.incidencia.alta.incidencia')
            ->middleware('role:SUPER_ADMIN|CAPT_KDX|INI_JUST|EMPLEADO_GRAL');
        // Guardar T02 - ALTA DE INCIDENCIA
        Route::post('{tramiteIncidencia}/{instanciaTarea}/alta-incidencia',
            [TramiteIncidenciaController::class, "altaIncidencia"])
            ->middleware('role:SUPER_ADMIN|CAPT_KDX|INI_JUST|EMPLEADO_GRAL');
        // MOSTRAR T02 - APLICACION DE NOTAS BUENAS
        Route::get('{tramiteIncidencia}/{instanciaTarea}/aplicacion-notas-buenas',
            [TramiteIncidenciaController::class, "aplicacionNotasBuenas"])
            ->name('tramite.incidencia.aplicacion.notas.buenas')
            ->middleware('role:SUPER_ADMIN|INI_JUST|EMPLEADO_GRAL');
        // Guardar T02 - APLICACION DE NOTAS BUENAS
        Route::post('{tramiteIncidencia}/{instanciaTarea}/aplicacion-notas-buenas',
            [TramiteIncidenciaController::class, "aplicacionNotasBuenas"])
            ->middleware('role:SUPER_ADMIN|INI_JUST|EMPLEADO_GRAL');
        // MOSTRAR T02 - CANCELACIÓN INCIDENCIA
        Route::get('{tramiteIncidencia}/{instanciaTarea}/cancelacion-incidencia',
            [TramiteIncidenciaController::class, "cancelacionIncidencia"])
            ->name('tramite.incidencia.cancelacion.incidencia')
            ->middleware('role:SUPER_ADMIN|INI_JUST|EMPLEADO_GRAL');
        // Guardar T02 - CANCELACIÓN INCIDENCIA
        Route::post('{tramiteIncidencia}/{instanciaTarea}/cancelacion-incidencia',
            [TramiteIncidenciaController::class, "cancelacionIncidencia"])
            ->middleware('role:SUPER_ADMIN|INI_JUST|EMPLEADO_GRAL');
        // MOSTRAR T03 - FORMATO DE SOLICITUD
        Route::get('{tramiteIncidencia}/{instanciaTarea}/formato-solicitud',
            [TramiteIncidenciaController::class, "formatoSolicitud"])
            ->name('tramite.incidencia.formato.solicitud')
            ->middleware('role:SUPER_ADMIN|INI_JUST|EMPLEADO_GRAL');
        // GUARDAR T03 - IMPRIMIR FORMATO DE SOLICITUD
        Route::post('{tramiteIncidencia}/{instanciaTarea}/formato-solicitud',
            [TramiteIncidenciaController::class, "formatoSolicitud"])
            ->middleware('role:SUPER_ADMIN|INI_JUST|EMPLEADO_GRAL');
        // MOSTRAR T04 - APROBAR SOLICITUD
        Route::get('{tramiteIncidencia}/{instanciaTarea}/aprobar',
            [TramiteIncidenciaController::class, "aprobarSolicitud"])
            ->name('tramite.incidencia.aprobar.solicitud')
            ->middleware('role:SUPER_ADMIN|SUB_EA');
        // GUARDAR T04 - APROBAR SOLICITUD
        Route::post('{tramiteIncidencia}/{instanciaTarea}/aprobar',
            [TramiteIncidenciaController::class, "aprobarSolicitud"])
            ->middleware('role:SUPER_ADMIN|SUB_EA');
        // MOSTRAR T05 - AUTORIZAR SOLICITUD
        Route::get('{tramiteIncidencia}/{instanciaTarea}/autorizar',
            [TramiteIncidenciaController::class, "autorizarSolicitud"])
            ->name('tramite.incidencia.autorizar.solicitud')
            ->middleware('role:SUPER_ADMIN|CTRL_KDX');
        // MOSTRAR T05 - AUTORIZAR SOLICITUD
        Route::post('{tramiteIncidencia}/{instanciaTarea}/autorizar',
            [TramiteIncidenciaController::class, "autorizarSolicitud"])
            ->middleware('role:SUPER_ADMIN|CTRL_KDX');
        // MOSTRAR T06 - RESPUESTA
        Route::get('{tramiteIncidencia}/{instanciaTarea}/respuesta',
            [TramiteIncidenciaController::class, "respuestaSolicitud"])
            ->name('tramite.incidencia.respuesta.solicitud')
            ->middleware('role:SUPER_ADMIN|CAPT_KDX|INI_JUST|EMPLEADO_GRAL');
        // GUARDAR T06 - RESPUESTA
        Route::post('{tramiteIncidencia}/{instanciaTarea}/respuesta',
            [TramiteIncidenciaController::class, "respuestaSolicitud"])
            ->middleware('role:SUPER_ADMIN|CAPT_KDX|INI_JUST|EMPLEADO_GRAL');

        // INCIDENCIA GRUPAL
        // Mostrar T01 - Tipo de captura
        Route::get('{tramiteIncidencia}/{instanciaTarea}/incidencia-grupal/tipo-captura',
            [TramiteIncidenciaController::class, "incidenciaGrupalTipoCaptura"])
            ->name('tramite.incidencia.grupal.tipo.captura')
            ->middleware('role:SUPER_ADMIN|CAPT_KDX');
        // Guardar T01 - Tipo de captura
        Route::post('{tramiteIncidencia}/{instanciaTarea}/incidencia-grupal/tipo-captura',
            [TramiteIncidenciaController::class, "incidenciaGrupalTipoCaptura"])
            ->middleware('role:SUPER_ADMIN|CAPT_KDX');
        // Mostrar T02 - Alta de incidencia
        Route::get('{tramiteIncidencia}/{instanciaTarea}/incidencia-grupal/alta',
            [TramiteIncidenciaController::class, "incidenciaGrupalAlta"])
            ->name('tramite.incidencia.grupal.alta')
            ->middleware('role:SUPER_ADMIN|CAPT_KDX');
        // Guardar T02 - Alta de incidencia
        Route::post('{tramiteIncidencia}/{instanciaTarea}/incidencia-grupal/alta',
            [TramiteIncidenciaController::class, "incidenciaGrupalAlta"])
            ->middleware('role:SUPER_ADMIN|CAPT_KDX');
        // Mostrar T02 - Cancelacion de incidencia
        Route::get('{tramiteIncidencia}/{instanciaTarea}/incidencia-grupal/cancelacion-incidencia',
            [TramiteIncidenciaController::class, "incidenciaGrupalCancelacionIncidencia"])
            ->name('tramite.incidencia.grupal.cancelacion.incidencia')
            ->middleware('role:SUPER_ADMIN|CAPT_KDX');
        // Guardar T02 - Cancelación de incidencia
        Route::post('{tramiteIncidencia}/{instanciaTarea}/incidencia-grupal/cancelacion-incidencia',
            [TramiteIncidenciaController::class, "incidenciaGrupalCancelacionIncidencia"])
            ->middleware('role:SUPER_ADMIN|CAPT_KDX');
        // Mostrar T03 - Cancelacion de empleados
        Route::get('{tramiteIncidencia}/{instanciaTarea}/incidencia-grupal/cancelacion-empleados',
            [TramiteIncidenciaController::class, "incidenciaGrupalCancelacionEmpleados"])
            ->name('tramite.incidencia.grupal.cancelacion.empleados')
            ->middleware('role:SUPER_ADMIN|CAPT_KDX');
        // Guardar T03 - Cancelación de empleados
        Route::post('{tramiteIncidencia}/{instanciaTarea}/incidencia-grupal/cancelacion-empleados',
            [TramiteIncidenciaController::class, "incidenciaGrupalCancelacionEmpleados"])
            ->middleware('role:SUPER_ADMIN|CAPT_KDX');
        // Mostrar T04 - Autorizar incidencia
        Route::get('{tramiteIncidencia}/{instanciaTarea}/incidencia-grupal/autorizar',
            [TramiteIncidenciaController::class, "incidenciaGrupalAutorizar"])
            ->name('tramite.incidencia.grupal.autorizar')
            ->middleware('role:SUPER_ADMIN|CTRL_KDX');
        // Guardar T04 - Autorizar incidencia
        Route::post('{tramiteIncidencia}/{instanciaTarea}/incidencia-grupal/autorizar',
            [TramiteIncidenciaController::class, "incidenciaGrupalAutorizar"])
            ->middleware('role:SUPER_ADMIN|CTRL_KDX');
        // Mostrar N01 - Respuesta
        Route::get('{tramiteIncidencia}/{instanciaTarea}/incidencia-grupal/respuesta',
            [TramiteIncidenciaController::class, "incidenciaGrupalRespuesta"])
            ->name('tramite.incidencia.grupal.respuesta')
            ->middleware('role:SUPER_ADMIN|CAPT_KDX');
        // Guardar N01 - Respuesta
        Route::post('{tramiteIncidencia}/{instanciaTarea}/incidencia-grupal/respuesta',
            [TramiteIncidenciaController::class, "incidenciaGrupalRespuesta"])
            ->middleware('role:SUPER_ADMIN|CAPT_KDX');
    });


    // FORMATOS
    Route::get('{tramiteIncidencia}/formato-solicitud',
        [TramiteIncidenciaController::class, "descargarFormatoSolicitud"])
        ->name('tramite.incidencia.descargarFormatoSolicitud')
        ->middleware('role:SUPER_ADMIN|INI_JUST|EMPLEADO_GRAL');

    // CATÁLOGOS
    // TIPOS INCIDENCIAS
    Route::get('catalogos/tipos-incidencias', [TipoIncidenciaController::class, "index"])
        ->name("tramite.incidencia.catalogo.tipos.incidencias")
        ->middleware('role:SUPER_ADMIN|CTRL_KDX');
    Route::get('catalogos/tipos-incidencias/create', [TipoIncidenciaController::class, "create"])
        ->name("tramite.incidencia.catalogo.tipos.incidencias.create")
        ->middleware('role:SUPER_ADMIN|CTRL_KDX');
    Route::post('catalogos/tipos-incidencias/store', [TipoIncidenciaController::class, "store"])
        ->name("tramite.incidencia.catalogo.tipos.incidencias.store")
        ->middleware('role:SUPER_ADMIN|CTRL_KDX');
    Route::get('catalogos/tipos-incidencias/{tipoIncidencia}/edit', [TipoIncidenciaController::class, "edit"])
        ->name("tramite.incidencia.catalogo.tipos.incidencias.edit")
        ->middleware('role:SUPER_ADMIN|CTRL_KDX');
    Route::put('catalogos/tipos-incidencias/{tipoIncidencia}/update', [TipoIncidenciaController::class, "update"])
        ->name("tramite.incidencia.catalogo.tipos.incidencias.update")
        ->middleware('role:SUPER_ADMIN|CTRL_KDX');

    // GENERAL
    // INDIVIDUAL
    // Calcular días válidos en un rango de fechas para una incidencia
    Route::get('{tramiteIncidencia}/getFechasPorEstatusIncidencia',
        [TramiteIncidenciaController::class, "getFechasPorEstatusIncidencia"])
        ->name('tramite.incidencia.getFechasPorEstatusIncidencia')
        ->middleware('role:SUPER_ADMIN|CTRL_KDX|CAPT_KDX|INI_JUST|EMPLEADO_GRAL');
    // Traer las tramites de incidencias autorizadas de un empleado
    Route::get('{tramiteIncidencia}/getTramitesIncidenciasEmpleado',
        [TramiteIncidenciaController::class, "getTramitesIncidenciasEmpleado"])
        ->name('tramite.incidencia.getTramitesIncidenciasEmpleado')
        ->middleware('role:SUPER_ADMIN|CTRL_KDX|CAPT_KDX|INI_JUST|EMPLEADO_GRAL');
    // Traer las incidencias autorizadas de un empleado
    Route::get('{tramiteIncidencia}/getIncidenciasEmpleado',
        [TramiteIncidenciaController::class, "getIncidenciasEmpleado"])
        ->name('tramite.incidencia.getIncidenciasEmpleado')
        ->middleware('role:SUPER_ADMIN|CTRL_KDX|CAPT_KDX|INI_JUST|EMPLEADO_GRAL');
    // Traer los trámites de ALTA Y ALTA NB de incidencias autorizadas de un empleado
    Route::get('{tramiteIncidencia}/getTramitesIncidenciasEmpleado',
        [TramiteIncidenciaController::class, "getTramitesIncidenciasEmpleado"])
        ->name('tramite.incidencia.getTramitesIncidenciasEmpleado')
        ->middleware('role:SUPER_ADMIN|CTRL_KDX|CAPT_KDX|INI_JUST|EMPLEADO_GRAL');
    // Traer las notas buenas disponibles de un empleado y
    // las fechas donde haya retardos leves o retardos graves o faltas
    Route::get('{tramiteIncidencia}/getNotasBuenas',
        [TramiteIncidenciaController::class, "getNotasBuenas"])
        ->name('tramite.incidencia.getNotasBuenas')
        ->middleware('role:SUPER_ADMIN|CTRL_KDX|CAPT_KDX|INI_JUST|EMPLEADO_GRAL');
    // Traer a los empleados que cumplan con ciertas condiciones
    Route::get('{tramiteIncidencia}/getEmpleadosCumplenCondicion',
        [TramiteIncidenciaController::class, "getEmpleadosCumplenCondicion"])
        ->name('tramite.incidencia.getEmpleadosCumplenCondicion')
        ->middleware('role:SUPER_ADMIN|CTRL_KDX|CAPT_KDX');
    // GRUPAL
    // Traer las incidencias autorizadas de un empleado
    Route::get('{tramiteIncidencia}/incidencia-grupal/getIncidenciasEmpleado',
        [TramiteIncidenciaController::class, "incidenciaGrupalGetIncidenciasEmpleados"])
        ->name('tramite.incidencia.grupal.getIncidenciasEmpleados')
        ->middleware('role:SUPER_ADMIN|CTRL_KDX|CAPT_KDX');


    // REPORTES
    // Reporte Incidencias por Empleado
    Route::get('reportes/incidencias-por-empleado',
        [IncidenciasPorEmpleadoController::class, "index"])
        ->name('tramite.incidencia.reporte.incidencias.empleado')
        ->middleware('role:SUPER_ADMIN|CTRL_KDX|CAPT_KADX|SUB_EA|INI_JUST|EMPLEADO_GRAL');
    Route::get('reportes/incidencias-por-empleado/buscar',
        [IncidenciasPorEmpleadoController::class, "buscar"])
        ->name('tramite.incidencia.reporte.incidencias.empleado.buscar')
        ->middleware('role:SUPER_ADMIN|CTRL_KDX|CAPT_KADX|SUB_EA|INI_JUST|EMPLEADO_GRAL');
    
    // Reporte de días acumulados
    Route::get('reportes/dias-acumulados',
        [DiasAcumuladosController::class, "index"])
        ->name('tramite.incidencia.reporte.dias.acumulados')
        ->middleware('role:SUPER_ADMIN|CTRL_KDX|CAPT_KADX|SUB_EA|INI_JUST|EMPLEADO_GRAL');
    Route::get('reportes/dias-acumulados/buscar',
        [DiasAcumuladosController::class, "buscar"])
        ->name('tramite.incidencia.reporte.dias.acumulados.buscar')
        ->middleware('role:SUPER_ADMIN|CTRL_KDX|CAPT_KADX|SUB_EA|INI_JUST|EMPLEADO_GRAL');    

    // Reporte Incidencias para archivo
    Route::get('reportes/incidencias-archivo',
        [IncidenciasAutorizadasArchivoController::class, "index"])
        ->name('tramite.incidencia.reporte.incidencias.archivo')
        ->middleware('role:SUPER_ADMIN|INI_JUST');
    Route::get('reportes/incidencias-archivo/buscar',
        [IncidenciasAutorizadasArchivoController::class, "buscar"])
        ->name('tramite.incidencia.reporte.incidencias.archivo.buscar')
        ->middleware('role:SUPER_ADMIN|INI_JUST');
});
