<?php

use App\Http\Controllers\p08_solicita_servicios\SolicitaServicioController;
use App\Http\Controllers\p08_solicita_servicios\CatalogoVehiculoController;
use App\Http\Controllers\p08_solicita_servicios\ReporteSolicitaServicioController;

Route::group(['prefix' => 'procesos/solicitud-servicios'], function(){
	// Descripción
	Route::get('descripcion/{tipo_servicio}',
        [SolicitaServicioController::class, "descripcion"])
        ->name('solicitud.servicio.descripcion')
        ->middleware('role:SUPER_ADMIN|JUD_RM');

    // Inicializar el proceso Solicitud Servicio
    Route::post('inicializar-proceso/{tipo_servicio}',
        [SolicitaServicioController::class, "inicializarProceso"])
        ->name('solicitud.servicio.inicializar.proceso')
        ->middleware('role:SUPER_ADMIN|JUD_RM');

	// Mostrar T01
	Route::get('{solicitaServicio}/{instanciaTarea}/seleccionar-servicio',
        [SolicitaServicioController::class, "seleccionarServicio"])
        ->name('solicitud.servicio.seleccionar.servicio')
        ->middleware('role:SUPER_ADMIN|JUD_RM');

	// Guardar T01 y crear T02
	Route::post('{solicitaServicio}/{instanciaTarea}/seleccionar-servicio',
        [SolicitaServicioController::class, "seleccionarServicio"])
        ->middleware('role:SUPER_ADMIN|JUD_RM');

    // Guardar imagenes parte de la T01
    Route::post('{solicitaServicio}/seleccionar-servicio-guardar-imagenes',
        [SolicitaServicioController::class, "seleccionarServicioGuardarImagenes"])
        ->name('solicitud.servicio.seleccionar.servicio.guardar.imagenes')
        ->middleware('role:SUPER_ADMIN|JUD_RM');

    // Guardar pdfs parte de la T01
    Route::post('{solicitaServicio}/seleccionar-servicio-guardar-pdfs',
        [SolicitaServicioController::class, "seleccionarServicioGuardarPDFs"])
        ->name('solicitud.servicio.seleccionar.servicio.guardar.pdfs')
        ->middleware('role:SUPER_ADMIN|JUD_RM');

    // Mostrar T02
	Route::get('{solicitaServicio}/{instanciaTarea}/desglose-servicio',
        [SolicitaServicioController::class, "desgloseServicio"])
        ->name('solicitud.servicio.desglose.servicio')
        ->middleware('role:SUPER_ADMIN|JUD_MTTO|JUD_IMPRE|JUD_TRANSPORTE|JUD_TELEFONIA|JUD_LIMPIEZA');

    // Guardar T02 y crear T03
    Route::post('{solicitaServicio}/{instanciaTarea}/desglose-servicio',
        [SolicitaServicioController::class, "desgloseServicio"])
        ->middleware('role:SUPER_ADMIN|JUD_MTTO|JUD_IMPRE|JUD_TRANSPORTE|JUD_TELEFONIA|JUD_LIMPIEZA');

    // Finalizar prematuramente T02
    Route::post('finalizar-prematuramente-desglose-servicio',
        [SolicitaServicioController::class, "finalizarPrematuramenteDesgloseServicio"])
        ->name('solicitud.servicio.finalizar.prematuramente.desglose.servicio')
        ->middleware('role:SUPER_ADMIN|JUD_MTTO|JUD_IMPRE|JUD_TRANSPORTE|JUD_TELEFONIA|JUD_LIMPIEZA');

    // Mostrar T03
	Route::get('{solicitaServicio}/{instanciaTarea}/ejecucion-servicio',
        [SolicitaServicioController::class, "ejecucionServicio"])
        ->name('solicitud.servicio.ejecucion.servicio')
        ->middleware('role:SUPER_ADMIN|JUD_MTTO|JUD_IMPRE|JUD_TRANSPORTE|JUD_TELEFONIA|JUD_LIMPIEZA');

	// Guardar T03 y crear T04
	Route::post('{solicitaServicio}/{instanciaTarea}/ejecucion-servicio',
        [SolicitaServicioController::class, "ejecucionServicio"])
        ->middleware('role:SUPER_ADMIN|JUD_MTTO|JUD_IMPRE|JUD_TRANSPORTE|JUD_TELEFONIA|JUD_LIMPIEZA');

    // Mostrar T04
    Route::get('{solicitaServicio}/{instanciaTarea}/confirmacion-servicio',
        [SolicitaServicioController::class, "confirmacionServicio"])
        ->name('solicitud.servicio.confirmacion.servicio')
        ->middleware('role:SUPER_ADMIN|JUD_RM');

    // Guardar T04 y Finalizar el proceso
    Route::post('{solicitaServicio}/{instanciaTarea}/confirmacion-servicio',
        [SolicitaServicioController::class, "confirmacionServicio"])
        ->middleware('role:SUPER_ADMIN|JUD_RM');



    // Ruta para cargar el catalogo por ajax para el modal de Nueva partida de la T03
    Route::post('{solicitaServicio}/getServicios',
        [SolicitaServicioController::class, "getServicios"])
        ->name('catalogo.servicios')
        ->middleware('role:SUPER_ADMIN|JUD_MTTO|JUD_IMPRE|JUD_TRANSPORTE|JUD_TELEFONIA|JUD_LIMPIEZA');
    // Ruta para borrar por ajax el registro de la tabla de la T03
    Route::post('deleteServicio',
        [SolicitaServicioController::class, "deleteServicio"])
        ->name('delete.servicios')
        ->middleware('role:SUPER_ADMIN|JUD_MTTO|JUD_IMPRE|JUD_TRANSPORTE|JUD_TELEFONIA|JUD_LIMPIEZA');
    // Ruta para Guardar avances por ajax de la T05
    Route::post('guardarAvancesServicio',
        [SolicitaServicioController::class, "guardarAvancesServicio"])
        ->name('guardar.avances.servicios')
        ->middleware('role:SUPER_ADMIN|JUD_MTTO|JUD_IMPRE|JUD_TRANSPORTE|JUD_TELEFONIA|JUD_LIMPIEZA');

    // NOTIFICACIONES

    // Notificación NUEVA Solicitud de Servicio hecha por el JUD_RM y se avisa a los JUDs
	Route::get('{solicitaServicio}/{instanciaTarea}/notificacion-solicitud-servicio-jud',
        [SolicitaServicioController::class, "notificarSolicitudServicioJud"])
        ->name('solicitud.servicio.notificacion.jud')
        ->middleware('role:SUPER_ADMIN|JUD_MTTO|JUD_IMPRE|JUD_TRANSPORTE|JUD_TELEFONIA|JUD_LIMPIEZA');

    Route::post('{solicitaServicio}/{instanciaTarea}/notificacion-solicitud-servicio-jud',
        [SolicitaServicioController::class, "notificarSolicitudServicioJud"])
        ->middleware('role:SUPER_ADMIN|JUD_MTTO|JUD_IMPRE|JUD_TRANSPORTE|JUD_TELEFONIA|JUD_LIMPIEZA');

    // Notificación RECHAZO de Solicitud se envia al JUD_RM cuando en la T02 la Rechaza el JUD correspondiente
	Route::get('{solicitaServicio}/{instanciaTarea}/notificacion-cancelacion-solicitud-servicio-jud',
        [SolicitaServicioController::class, "notificarRechazadaSolicitudServicioJud"])
        ->name('solicitud.servicio.notificacion.rechazada.jud')
        ->middleware('role:SUPER_ADMIN|JUD_RM');

    Route::post('{solicitaServicio}/{instanciaTarea}/notificacion-cancelacion-solicitud-servicio-jud',
        [SolicitaServicioController::class, "notificarRechazadaSolicitudServicioJud"])
        ->middleware('role:SUPER_ADMIN|JUD_RM');

    // Notificación ACEPTADO de Solicitud se envia al JUD_RM cuando en la T02 la Acepta el JUD correspondiente
	Route::get('{solicitaServicio}/{instanciaTarea}/notificacion-aceptado-solicitud-servicio-jud',
        [SolicitaServicioController::class, "notificarAceptadoSolicitudServicioJud"])
        ->name('solicitud.servicio.notificacion.aceptada.jud')
        ->middleware('role:SUPER_ADMIN|JUD_RM');

    Route::post('{solicitaServicio}/{instanciaTarea}/notificacion-aceptado-solicitud-servicio-jud',
        [SolicitaServicioController::class, "notificarAceptadoSolicitudServicioJud"])
        ->middleware('role:SUPER_ADMIN|JUD_RM');

    // Notificación COMPLETADO de Solicitud se envia al JUD_RM cuando en la T03 la Finaliza el JUD correspondiente
	Route::get('{solicitaServicio}/{instanciaTarea}/notificacion-completada-solicitud-servicio-jud',
        [SolicitaServicioController::class, "notificarCompletadaSolicitudServicioJud"])
        ->name('solicitud.servicio.notificacion.completada.jud')
        ->middleware('role:SUPER_ADMIN|JUD_RM');

    Route::post('{solicitaServicio}/{instanciaTarea}/notificacion-completada-solicitud-servicio-jud',
        [SolicitaServicioController::class, "notificarCompletadaSolicitudServicioJud"])
        ->middleware('role:SUPER_ADMIN|JUD_RM');

    // CATÁLOGOS

    // Ruta para GUARDAR y ACTUALIZAR el CATÁLOGO de Vehiculos del p08
    Route::get('catalogo-vehiculo',
        [CatalogoVehiculoController::class, "catalogoVehiculos"])
        ->name('solicitud.servicio.administrar.catalogo.vehiculos')
        ->middleware('role:SUPER_ADMIN|JUD_TRANSPORTE|JUD_RM');

    Route::post('catalogo-vehiculo',
        [CatalogoVehiculoController::class, "catalogoVehiculos"])
        ->middleware('role:SUPER_ADMIN|JUD_TRANSPORTE|JUD_RM');


    // Ruta para busca por ajax el VEHÍCULO para mostrarlo y poder ser EDITARLO
    Route::post('editar-vehiculo',
        [CatalogoVehiculoController::class, "editarVehiculo"])
        ->name('solicitud.servicio.editar.vehiculo')
        ->middleware('role:SUPER_ADMIN|JUD_TRANSPORTE');

    Route::get('editar-vehiculo',
        [CatalogoVehiculoController::class, "editarVehiculo"])
        ->middleware('role:SUPER_ADMIN|JUD_TRANSPORTE');


    // Ruta para ELIMINAR por ID el VEHÍCULO del CATÁLOGO del P08
    Route::post('eliminar-vehiculo',
        [CatalogoVehiculoController::class, "eliminarVehiculo"])
        ->name('solicitud.servicio.eliminar.vehiculo')
        ->middleware('role:SUPER_ADMIN|JUD_TRANSPORTE');

    // Ruta para el CATÁLOGO de VEHÍCULO Y BITÁCORA
    Route::get('catalogo-vehiculo-bitacora-ruta-gas/{vehiculo?}',
        [CatalogoVehiculoController::class, "catalogoVehiculoBitacoraRutaGas"])
        ->name('solicitud.servicio.administrar.catalogo.vehiculo.bitacora.ruta.gas')
        ->middleware('role:SUPER_ADMIN|JUD_TRANSPORTE');

    Route::post('catalogo-vehiculo-bitacora-ruta-gas/{vehiculo?}',
        [CatalogoVehiculoController::class, "catalogoVehiculoBitacoraRutaGas"])
        ->middleware('role:SUPER_ADMIN|JUD_TRANSPORTE');

    // REPORTES

    // Ruta para ver los REPORTES de SOLICITUD DE TODOS LOS SERVICIOS (Todas apuntan a una Método General)
    Route::get('reportes/mantenimiento',
        [ReporteSolicitaServicioController::class, "reporteSolicitudServicio"])
        ->name('solicitud.servicio.reporte.mantenimiento')
        ->middleware('role:SUPER_ADMIN|JUD_MTTO');
    Route::post('reportes/mantenimiento',
        [ReporteSolicitaServicioController::class, "reporteSolicitudServicio"])
        ->middleware('role:SUPER_ADMIN|JUD_MTTO');

    Route::get('reportes/vehiculos',
        [ReporteSolicitaServicioController::class, "reporteSolicitudServicio"])
        ->name('solicitud.servicio.reporte.transporte')
        ->middleware('role:SUPER_ADMIN|JUD_TRANSPORTE');
    Route::post('reportes/vehiculos',
        [ReporteSolicitaServicioController::class, "reporteSolicitudServicio"])
        ->middleware('role:SUPER_ADMIN|JUD_TRANSPORTE');

    Route::get('reportes/reproduccion',
        [ReporteSolicitaServicioController::class, "reporteSolicitudServicio"])
        ->name('solicitud.servicio.reporte.impresiones')
        ->middleware('role:SUPER_ADMIN|JUD_IMPRE');
    Route::post('reportes/reproduccion',
        [ReporteSolicitaServicioController::class, "reporteSolicitudServicio"])
        ->middleware('role:SUPER_ADMIN|JUD_IMPRE');

    Route::get('reportes/telefonia',
        [ReporteSolicitaServicioController::class, "reporteSolicitudServicio"])
        ->name('solicitud.servicio.reporte.telefonia')
        ->middleware('role:SUPER_ADMIN|JUD_TELEFONIA');
    Route::post('reportes/telefonia',
        [ReporteSolicitaServicioController::class, "reporteSolicitudServicio"])
        ->middleware('role:SUPER_ADMIN|JUD_TELEFONIA');

    Route::get('reportes/limpieza_estibas',
        [ReporteSolicitaServicioController::class, "reporteSolicitudServicio"])
        ->name('solicitud.servicio.reporte.limpieza.estibas')
        ->middleware('role:SUPER_ADMIN|JUD_LIMPIEZA');
    Route::post('reportes/limpieza_estibas',
        [ReporteSolicitaServicioController::class, "reporteSolicitudServicio"])
        ->middleware('role:SUPER_ADMIN|JUD_LIMPIEZA');

    // Ruta para mostrar Detalle de los REPORTES de los Servicios por Ajax
    Route::post('reportes-ver-detalle',
        [ReporteSolicitaServicioController::class, "verDetalleReporteSolicitudServicio"])
        ->name('solicitud.servicio.reporte.ver.detalle')
        ->middleware('role:SUPER_ADMIN|JUD_MTTO|JUD_TRANSPORTE|JUD_TELEFONIA|JUD_IMPRE|JUD_LIMPIEZA');
    // Ruta para imprimir el Detalle de los REPORTES de los Servicios en PDF por Ajax
    Route::get('reportes-imprimir-detalle/{solicitudServicio?}/{folio?}',
        [ReporteSolicitaServicioController::class, "imprimirDetalleReporteSolicitudServicio"])
        ->name('solicitud.servicio.reporte.imprimir.detalle')
        ->middleware('role:SUPER_ADMIN|JUD_MTTO|JUD_TRANSPORTE|JUD_TELEFONIA|JUD_IMPRE|JUD_LIMPIEZA');
    // Ruta para FILTRAR REPORTES de SOLICITUD DE SERVICIOS
    Route::post('reportes-filtrar',
        [ReporteSolicitaServicioController::class, "filtrarSolicitudServicio"])
        ->name('solicitud.servicio.reporte.filtrar')
        ->middleware('role:SUPER_ADMIN|JUD_MTTO|JUD_TRANSPORTE|JUD_TELEFONIA|JUD_IMPRE|JUD_LIMPIEZA');
    // Ruta para LIMPIAR FILTRO REPORTES de SOLICITUDES DE SERVICIOS
    Route::get('reportes-limpiar-filtro/{tipo_servicio?}',
        [ReporteSolicitaServicioController::class, "limpiarFiltroSolicitudServicio"])
        ->name('solicitud.servicio.reporte.limpiar.filtro')
        ->middleware('role:SUPER_ADMIN|JUD_MTTO|JUD_TRANSPORTE|JUD_TELEFONIA|JUD_IMPRE|JUD_LIMPIEZA');
    // Ruta para DESCARGAR EL EXCEL de REPORTES de SOLICITUD DE SERVICIOS
    Route::get('reportes-mantenimiento-generar-excel/{tipo_servicio?}/{anio?}/{area_id?}/{estatus?}/{especialidad?}',
        [ReporteSolicitaServicioController::class, "generarExcelReporteSolicitudServicio"])
        ->name('solicitud.servicio.reporte.generar.excel')
        ->middleware('role:SUPER_ADMIN|JUD_MTTO|JUD_TRANSPORTE|JUD_TELEFONIA|JUD_IMPRE|JUD_LIMPIEZA');


    Route::post('buscar-reporte-solicitud-servicio-pdf',
        [ReporteSolicitaServicioController::class, "buscarReporteSolicitudServicio"])
        ->name('solicitud.servicio.buscar.reporte')
        ->middleware('role:SUPER_ADMIN|JUD_MTTO|JUD_TRANSPORTE|JUD_TELEFONIA|JUD_IMPRE|JUD_LIMPIEZA');

    Route::get('buscar-reporte-solicitud-servicio-pdf',
        [ReporteSolicitaServicioController::class, "buscarReporteSolicitudServicio"])
        ->middleware('role:SUPER_ADMIN|JUD_MTTO|JUD_TRANSPORTE|JUD_TELEFONIA|JUD_IMPRE|JUD_LIMPIEZA');

    // Ruta para descargar el detalle en la T03
    Route::get('generar-y-descargar-detalle-servicios/{solicitudServicioId?}', [SolicitaServicioController::class, "generarDescargarDetalleServicios"])
        ->name('solicitud.servicio.generar.descargar.detalle.servicios')
        ->middleware('role:SUPER_ADMIN|JUD_MTTO|JUD_TRANSPORTE|JUD_TELEFONIA|JUD_IMPRE|JUD_LIMPIEZA');
});

