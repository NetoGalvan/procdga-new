<?php

use App\Http\Controllers\p07_pago_prestaciones\PagoPrestacionController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'procesos/pago-prestaciones'], function(){
    // Descripcion Proceso Pago Prestaciones
    Route::get('descripcion',
        [PagoPrestacionController::class, "descripcion"])
        ->name('pago.prestacion.descripcion')
        ->middleware('role:SUPER_ADMIN|JO_PRES');

    // Inicio Proceso Guardado Pago prestación
    Route::post('inicializarProceso',
        [PagoPrestacionController::class, "inicializarProceso"])
        ->name('pago.prestacion.inicializarProceso')
        ->middleware('role:SUPER_ADMIN|JO_PRES');

    // Mostrar T01 - Esquema de datos
    Route::get('{pagoPrestacion}/{instanciaTarea}/creacion-esquema-datos',
        [PagoPrestacionController::class, "crearEsquemaDatos"])
        ->name('pago.prestacion.esquema.datos')
        ->middleware('role:SUPER_ADMIN|JO_PRES');

    // Guardar T01 - Esquema de datos
    Route::post('{pagoPrestacion}/{instanciaTarea}/creacion-esquema-datos',
        [PagoPrestacionController::class, "crearEsquemaDatos"])
        ->middleware('role:SUPER_ADMIN|JO_PRES');

    // Mostrar T02 - Enviar a aprobación
    Route::get('{pagoPrestacion}/{instanciaTarea}/enviar-aprobacion',
        [PagoPrestacionController::class, "enviarAprobacion"])
        ->name('pago.prestacion.enviar.nomina')
        ->middleware('role:SUPER_ADMIN|JO_PRES');

    // Guardar T02 - Enviar a aprobación
    Route::post('{pagoPrestacion}/{instanciaTarea}/enviar-aprobacion',
        [PagoPrestacionController::class, "enviarAprobacion"])
        ->middleware('role:SUPER_ADMIN|JO_PRES');

    // Mostrar ST01 - Captura de candidatos
    Route::get('{subProcesoPrestacion}/{instanciaTarea}/captura-datos',
        [PagoPrestacionController::class, "capturarCandidatos"])
        ->name('pago.prestacion.capturar.candidatos')
        ->middleware('role:SUPER_ADMIN|JUD_RH');

    // Guardar ST01 - Captura de candidatos
    Route::post('{subProcesoPrestacion}/{instanciaTarea}/captura-datos',
        [PagoPrestacionController::class, "capturarCandidatos"])
        ->middleware('role:SUPER_ADMIN|JUD_RH');

    // Agregar candidato en la tarea ST01
    Route::post('agregar-candidato/{subProcesoPrestacion}',
        [PagoPrestacionController::class, "agregarCandidato"])
        ->name('pago.prestacion.agregar.candidato')
        ->middleware('role:SUPER_ADMIN|JUD_RH');

    // Eliminar candidato en la tarea ST01
    Route::post('eliminar-registro-st01',
        [PagoPrestacionController::class, 'eliminarRegistroST01'])
        ->name('eliminar.registro.st01')
        ->middleware('role:SUPER_ADMIN|JUD_RH');

    // Mostrar ST02 - Aprobar candidatos
    Route::get('{subProcesoPrestacion}/{instanciaTarea}/aprobar-candidatos',
    	[PagoPrestacionController::class, 'aprobarCandidatos'])
        ->name('pago.prestacion.aprobar.candidatos')
        ->middleware('role:SUPER_ADMIN|SUB_EA');

	// Guardar ST02 - Aprobar candidatos
	Route::post('{subProcesoPrestacion}/{instanciaTarea}/aprobar-candidatos',
    	[PagoPrestacionController::class, 'aprobarCandidatos'])
        ->middleware('role:SUPER_ADMIN|SUB_EA');

    // Mostrar T03 - Validar nóminas de las unidades administrativas
    Route::get('{pagoPrestacion}/{instanciaTarea}/validar-nomina-unidades-administrativas',
        [PagoPrestacionController::class, 'validarNominaUnidades'])
        ->name('pago.prestacion.validar.nomina')
        ->middleware('role:SUPER_ADMIN|JUD_PRES');

	// Guardar T03 - Validar nóminas de las unidades administrativas
	Route::post('{pagoPrestacion}/{instanciaTarea}/validar-nomina-unidades-administrativas',
        [PagoPrestacionController::class, 'validarNominaUnidades'])
        ->middleware('role:SUPER_ADMIN|JUD_PRES');

    // Editar candidato en la tarea T03 y T04
    Route::post('editar-candidato',
        [PagoPrestacionController::class, 'editarCandidato'])
        ->name('pago.prestacion.editar.candidato')
        ->middleware('role:SUPER_ADMIN|JUD_PRES|SUB_PRES');

    // Mostrar T04 - Aprobar nóminas de las unidades administrativas
    Route::get('{pagoPrestacion}/{instanciaTarea}/aprobar-nomina-unidades-administrativas',
        [PagoPrestacionController::class, 'aprobarNominaUnidades'])
        ->name('pago.prestacion.aprobar.nomina')
        ->middleware('role:SUPER_ADMIN|SUB_PRES');

    // Guardar T04 - Aprobar nóminas de las unidades administrativas
    Route::post('{pagoPrestacion}/{instanciaTarea}/aprobar-nomina-unidades-administrativas',
        [PagoPrestacionController::class, 'aprobarNominaUnidades'])
        ->middleware('role:SUPER_ADMIN|SUB_PRES');

    // Mostrar T05 - Exportar nómina
    Route::get('{pagoPrestacion}/{instanciaTarea}/exportar-nomina-unidades-administrativas',
        [PagoPrestacionController::class, 'exportarNomina'])
        ->name('pago.prestacion.exportar.nomina')
        ->middleware('role:SUPER_ADMIN|JO_PRES');

    // Guardar T05 - Exportar nómina
    Route::post('{pagoPrestacion}/{instanciaTarea}/exportar-nomina-unidades-administrativas',
        [PagoPrestacionController::class, 'exportarNomina'])
        ->middleware('role:SUPER_ADMIN|JO_PRES');

    // Descargar excel de la nómina
    Route::get('descargar-nomina/{pagoPrestacion}',
        [PagoPrestacionController::class, 'descargarExcelNomina'])
        ->name('pago.prestacion.descargar.nomina')
        ->middleware('role:SUPER_ADMIN|JO_PRES');

});
