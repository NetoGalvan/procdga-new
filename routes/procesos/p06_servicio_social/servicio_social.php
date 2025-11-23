<?php
use App\Http\Controllers\p06_servicio_social\ServicioSocialController;
use App\Http\Controllers\p06_servicio_social\ReporteServicioSocialController;
use App\Http\Controllers\p06_servicio_social\ControlNotificacionesController;
use App\Http\Controllers\p06_servicio_social\ControlDocumentosController;

use App\Http\Controllers\p06_servicio_social\catalogos\CatPrestadorController;
use App\Http\Controllers\p06_servicio_social\catalogos\CatAreasAdscripcionController;
use App\Http\Controllers\p06_servicio_social\catalogos\CatProgramasInstitucionController;
use App\Http\Controllers\p06_servicio_social\catalogos\CatInstitucionController;
use App\Http\Controllers\p06_servicio_social\catalogos\CatEscuelaController;

Route::group(['prefix' => 'procesos/servicio-social'], function()
{
    Route::controller(ServicioSocialController::class)->group( function() 
    {
        #BEGIN::DESCRIPCIÓN -> procesos/servicio-social/ ruta -->
    	Route::middleware('role:SUB_EA|SUPER_ADMIN')->group( function() 
        {
			Route::get('descripcion', 'descripcion')->name('servicio.social.descripcion');
			Route::post('iniciar-proceso', 'iniciarProceso')->name('servicio.social.iniciar.proceso');
    	});
        #END::DESCRIPCIÓN <-
    });

	Route::prefix('{servicioSocial}')->group( function() 
    {
        Route::prefix('{instanciaTarea}')->group( function() 
        {
            Route::controller(ServicioSocialController::class)->group( function() 
            {
                #BEGIN::TAREAS -> procesos/servicio-social/{servicioSocial}/{instanciaTarea}/ ruta-->
        		Route::middleware('role:SUB_EA|SUPER_ADMIN')->group( function() 
                {
    				#TAREA 01
    				Route::get('seleccionar-prestador', 'seleccionarPrestador')->name('servicio.social.seleccionar.prestador');
    				Route::post('seleccionar-prestador',  "seleccionarPrestador")->name('post.seleccionar.prestador');
    				#TAREA 02
                    Route::get('asignar-datos-entrevista', 'asignarDatosEntrevista')->name('servicio.social.asignar.datos.entrevista');
                    Route::post('asignar-datos-entrevista', 'asignarDatosEntrevista');
                    #TAREA 03
                    Route::get('captura-resultado-entrevista', 'capturaResultadoEntrevista')->name('servicio.social.captura.resultado.entrevista');
                    Route::post('captura-resultado-entrevista', 'capturaResultadoEntrevista');
                    #TAREA 04
                    Route::get('asignacion-funciones-fechas-horarios', 'asignacionLabores')->name('servicio.social.asignacion.labores');
                    Route::post('asignacion-funciones-fechas-horarios', 'asignacionLabores');
                    #TAREA 06
                    Route::get('registrar-eventos', 'registrarEventos')->name('servicio.social.registrar.eventos');
                    Route::post('registrar-eventos', 'registrarEventos')->name('servicio.social.registrar.eventos.1');
                    Route::post('decision-baja-prestador', 'decisionDarDeBaja')->name('decision.baja.prestador');
                    #FROM::T01 - T02
                    Route::post('finalizar-proceso', 'finalizarProceso')->name('servicio.social.finalizar.proceso');
        		});
                Route::middleware('role:PROG_SS|SUPER_ADMIN')->group(function() 
                {
                    #TAREA 05
                    Route::get('impresion-carta-inicio', 'impresionCartaInicio')->name('servicio.social.impresion.carta.inicio');
                    Route::post('impresion-carta-inicio', 'impresionCartaInicio')->name('post.servicio.social.impresion.carta.inicio');
                    Route::post('regresar-para-corregir', 'regresarCorrecciones')->name('servicio.social.regresar.correcciones');
                    #TAREA 07
                    Route::get('impresion-carta-finalizacion', 'impresionCartaFinalizacion')->name('servicio.social.impresion.carta.fin');
                    Route::post('impresion-carta-finalizacion', 'impresionCartaFinalizacion')->name('servicio.social.impresion.carta.fin.1');
                    #TAREA 08
                    Route::get('validacion-prestador', 'validarLiberacionBaja')->name('servicio.social.validar.liberacion.o.baja.prestador');
                    Route::post('validacion-prestador', 'validarLiberacionBaja');
                });
                #END::TAREAS <-
            });

            #BEGIN::NOTIFICACIONES -> procesos/servicio-social/{servicioSocial}/{instanciaTarea}/notificacion/ ruta-->
            Route::controller(ControlNotificacionesController::class)->group( function() 
            {
                Route::prefix('notificacion')->group( function() 
                {
                    Route::middleware('role:SUB_EA|SUPER_ADMIN')->group( function() 
                    {
                        #NT 01 -> Cita de entrevista
                        Route::get('cita-entrevista', 'citaEntrevista')->name('servicio.social.notificacion.cita.examen.candidato');
                        Route::post('cita-entrevista', 'citaEntrevista');

                        #NT 02 -> Carta de aceptación
                        Route::get('carta-aceptacion', 'cartaAceptacion')->name('servicio.social.notificacion.carta.aceptacion');
                        Route::post('carta-aceptacion', 'cartaAceptacion');

                        #NT 03 -> Carta de termino
                        Route::get('carta-terminacion', 'cartaTermino')->name('servicio.social.notificacion.carta.termino');
                        Route::post('carta-terminacion', 'cartaTermino');

                        #NT 06 -> Monitoreo
                        Route::get('tiempo-faltante', 'tiempoFaltanteCartaInicio')->name('servicio.social.notificacion.monitoreo.carta.inicio');
                        Route::post('tiempo-faltante', 'tiempoFaltanteCartaInicio');
                    });
                    Route::middleware('role:PROG_SS|SUPER_ADMIN')->group(function() 
                    {
                        #NT 04 -> Candidato dado de baja
                        Route::get('baja-del-candidato', 'bajaDelCandidato')->name('servicio.social.notificacion.baja.candidato');
                        Route::post('baja-del-candidato', 'bajaDelCandidato');

                        #NT 05 -> Nuevo seguimiento agregado
                        Route::get('nuevo-seguimiento', 'nuevoSeguimiento')->name('servicio.social.notificacion.nuevo.segumiento');
                        Route::post('nuevo-seguimiento', 'nuevoSeguimiento');
                    });
                });
            });
            #END::NOTIFICACIONES <-
        });   

        Route::controller(ControlDocumentosController::class)->group( function() 
        {
            #BEGIN::DOCUMENTOS -> procesos/servicio-social/{servicioSocial}/ ruta-->
            Route::middleware('role:PROG_SS|SUPER_ADMIN')->group(function() 
            {
                #Ficha del Prestdor PDF
                Route::get('ficha-del-prestador', 'fichaPrestador')->name('servicio.social.imprimir.ficha.prestador');
                #Carta de Aceptación PDF
                Route::get('carta-de-aceptacion', 'cartaAceptacion')->name('servicio.social.imprimir.carta.aceptacion');
                #Carta de Termino PDF
                Route::get('carta-de-finalizacion', 'cartaFinalizacion')->name('servicio.social.imprimir.carta.finalizacion');
            });
            Route::middleware('role:SUB_EA|SUPER_ADMIN')->group(function() 
            {
                #Cargar documentos e Informes
                Route::post('documentos', 'registrarDocumentos')->name('ss.registrar.documentos');
                Route::post('informes', 'registrarInformes')->name('ss.registrar.informes');
                #Guardar documentos (SUBIR HORAS / SOLICITUD DE BAJA)
                Route::post('guardar-documento-servicio-social', 'guardarDocumento')->name('servicio.social.guardar.documento');
            });
            #END::DOCUMENTOS <-
        });
	});
    
    #FROM::T04
    Route::get('getDomicilioAreaAds', [ServicioSocialController::class, 'getDomicilioAreaAds'])->name('obtener.domicilio.area.adscripcion');
/*
    # -----
    // Empiezan las rutas del catalogo areas de adscripcion
    Route::get('catalogo-area-adscripcion', [CatAreasAdscripcionController::class, "catalogoAreasAdscripcion"])
    ->name('servicio.social.catalogo.areas.adscripcion')
    ->middleware('role:PROG_SS|SUPER_ADMIN');

    Route::post('catalogo-area-adscripcion', [CatAreasAdscripcionController::class, "catalogoAreasAdscripcion"])
    ->middleware('role:PROG_SS|SUPER_ADMIN');

    Route::post('editar-area-adscripcion', [CatAreasAdscripcionController::class, "editarAreasAdscripcion"])
    ->name('servicio.social.editar.area.adscripcion')
    ->middleware('role:PROG_SS|SUPER_ADMIN');

    Route::post('eliminar-area-adscripcion', [CatAreasAdscripcionController::class, "eliminarAreasAdscripcion"])
    ->name('servicio.social.eliminar.area.adscripcion')
    ->middleware('role:PROG_SS|SUPER_ADMIN');

    Route::get('recuperar-programas-por-institucion/{institucion_id?}', [CatAreasAdscripcionController::class, "recuperarProgramas"])
    ->name('servicio.social.recuperar.programas.por.institucion')
    ->middleware('role:PROG_SS|SUPER_ADMIN');
    // Terminan las rutas del catalogo areas de adscripcion
*/
});

#BEGIN::CATALOGOS -> catalogos/servicio-social/ ruta-->
Route::prefix('catalogos/servicio-social')->group( function()
{
    Route::middleware('role:PROG_SS|SUPER_ADMIN')->group( function()
    {   
        #BEGIN::CAT PRESTADORES
        Route::controller(CatPrestadorController::class)->group( function()
        {
            Route::get('prestadores', "catalogoPrestador")->name('servicio.social.catalogo.prestadores');
            Route::post('prestadores', "catalogoPrestador");
            Route::post('modal-datos-prestador/{prestador_id?}', "modalPrestador")->name('ss.modal.prestador');
            Route::post('guardar-editar-prestador/{prestador_id?}', "prestador")->name('ss.guardar.editar.prestador');
            Route::delete('eliminar-prestador/{prestador_id?}', "eliminarPrestador")->name('ss.eliminar.prestador');
                # --> Obtener las escuelas y programas a partir de la institucion
                Route::get('getEscuelasProgramas', "getEscuelasProgramas")->name('obtener.escuelas.programas');
                # --> Obtener las escuelas y programas a partir de la entidad federativa
                Route::get('getAlcaldiasMunicipios', "getAlcaldiasMunicipios")->name('obtener.alcaldias_municipios');
        });
        #END::CAT PRESTADORES
        #BEGIN::CAT INSTITUCIONES
        Route::controller(CatInstitucionController::class)->group( function()
        {
            Route::get('catalogo-institucion', 'catalogoInstituciones')->name('servicio.social.catalogo.instituciones');
            Route::post('catalogo-institucion', 'catalogoInstituciones');
            Route::post('modal-datos-institucion/{clave_institucion?}', "modalDatosInstitucion")->name('ss.modal.datos.institucion');
            Route::post('guardar-editar-institucion/{clave_institucion?}', 'institucion')->name('ss.guardar.editar.institucion');
            Route::post('eliminar-institucion/{clave_institucion?}', 'eliminarInstitucion')->name('ss.eliminar.institucion');
        });
        #END::CAT INSTITUCIONES
        #BEGIN::CAT ESCUELAS
        Route::controller(CatEscuelaController::class)->group( function()
        {
            Route::post('catalogo-escuelas/{clave_institucion?}', "catalogoEscuelas")->name('ss.modal_principal.catalogo_escuelas');
            Route::post('modal-datos-escuela/{acronimo_escuela?}', "modalDatosEscuela")->name('ss.modal.datos.escuela');
            Route::post('guardar-editar-escuela/{clave_institucion?}/{acronimo_escuela?}', "escuela")->name('ss.guardar.editar.escuela');
            Route::post('eliminar-escuela/{acronimo_escuela?}', "eliminarEscuela")->name('ss.eliminar.escuela');
        });
        #END::CAT ESCUELAS
        #BEGIN::CAT PROGRAMAS DE INSTITUCIONES
        Route::controller(CatProgramasInstitucionController::class)->group( function()
        {
            Route::post('catalogo-programas-instituciones/{clave_institucion?}', "catalogoProgramas")->name('ss.modal_principal.catalogo_programas');
            Route::post('modal-datos-programa-instituciones/{clave_programa?}', "modalDatosPrograma")->name('ss.modal.datos.programa.institucion');
            Route::post('guardar-editar-programa-instituciones/{clave_institucion?}/{clave_programa?}', "programa")->name('ss.guardar.editar.programa.institucion');
            Route::post('eliminar-programa-instituciones/{clave_programa?}', "eliminarPrograma")->name('ss.eliminar.programa.institucion');
        });
        #END::CAT PROGRAMAS DE INSTITUCIONES
        #BEGIN::CAT ÁREAS DE ADSCRIPCIÓN
        Route::controller(CatAreasAdscripcionController::class)->group( function()
        {
            Route::get('areas-adscripcion', "catalogoAreasAdscripcion")->name('servicio.social.catalogo.areas.adscripcion');
            Route::post('areas-adscripcion', "catalogoAreasAdscripcion");
            Route::post('modal-datos-area-adscripcion/{nombre_area?}/{direccion_area?}', "modalDatosAreaAdscripcion")->name('ss.modal.datos.area_adscripcion');
            Route::post('guardar-editar-area-adscripcion/{nombre_area?}/{direccion_area?}', "AreaAdscripcion")->name('ss.guardar.editar.area_adscripcion');
            Route::post('eliminar-area-adscripcion/{nombre_area?}/{direccion_area?}', "eliminarAreaAdscripcion")->name('ss.eliminar.area_adscripcion');
        });
        #END::CAT ÁREAS DE ADSCRIPCIÓN
    });
});
#END::CATALOGOS <-

#BEGIN::REPORTES -> reportes/servicio-social/ ruta-->
Route::controller(ReporteServicioSocialController::class)->group( function()
{
    Route::prefix('reportes/servicio-social')->group( function()
    {
        Route::middleware('role:SUB_EA|PROG_SS|SUPER_ADMIN')->group( function()
        {
            #REPORTE 01
            Route::get('datos-personales-prestador', 'reporteDatosPersonalesPrestador')->name('reporte.datos.personales.prestador');
            Route::post('datos-personales-prestador', 'reporteDatosPersonalesPrestador');
            Route::get('datos-personales-prestador-pdf/{folio?}', 'descargarReportePrestador')->name('descargar.pdf.reporte.datos.prestador');
            #REPORTE 02
            Route::get('prestadores-por-udAdministrativa', 'reportePrestadoresPorUnidadAdministrativa')->name('reporte.prestadores.por.unidad.administrativa');
            Route::post('prestadores-por-udAdministrativa', 'reportePrestadoresPorUnidadAdministrativa');
            #REPORTE 03
            Route::get('reporte-nomina-servicio-social', 'reporteNominaServiciosocial')->name('reporte.nomina.servicio.social');
            Route::post('reporte-nomina-servicio-social', 'reporteNominaServiciosocial');
            Route::post('reporte-nomina-servicio-social-pdf', 'descargarReporteEjecutivoNomina')->name('descargar.pdf.reporte.ejecutivo.nomina');
            #REPORTE 04
            Route::get('nomina-prestadores', 'reporteNominaPrestadoresExcel')->name('reporte.nomina.prestadores.servicio.social.excel');
            Route::post('nomina-prestadores', 'reporteNominaPrestadoresExcel');
            Route::get('nomina-prestadores-excel', 'descargarReporteNominaPrestadoresExcel')->name('descargar.reporte.nomina.prestadores.excel');
        });

        Route::middleware('role:PROG_SS|SUPER_ADMIN')->group( function()
        {
            #REPORTE 05
            Route::get('instituciones-escuelas-y-programas', 'reporteInstitucionesEscuelasProgramas')->name('reporte.instituciones.escuelas.programas');
            Route::post('instituciones-escuelas-y-programas', 'reporteInstitucionesEscuelasProgramas');
            #REPORTE 06
            Route::get('reimpresion-cartas-servicio-social', 'reimpresionCartaServicio')->name('reimpresion.cartas');
            Route::post('reimpresion-cartas-servicio-social', 'reimpresionCartaServicio');
            Route::post('reimpresion-cartas-servicio-social-pdf', 'descargarCartas')->name('descargar.reimpresion.cartas');
        });
    });
});
#END::REPORTES <-