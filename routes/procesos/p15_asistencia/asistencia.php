<?php

use App\Http\Controllers\p15_asistencia\catalogos\BiometricoController;
use App\Http\Controllers\p15_asistencia\catalogos\DiaFestivoFechaController;
use App\Http\Controllers\p15_asistencia\catalogos\HorarioController;
use App\Http\Controllers\p15_asistencia\reportes\TarjetaElectronicaCalendarioController;
use App\Http\Controllers\p15_asistencia\reportes\EvaluacionController;
use App\Http\Controllers\p15_asistencia\reportes\EventoAsistenciaController;
use App\Http\Controllers\p15_asistencia\reportes\FaltasController;
use App\Http\Controllers\p15_asistencia\reportes\TarjetaElectronicaController;

Route::group(['prefix' => 'procesos/asistencia'], function(){
    // REPORTES
    // TARJETA ELECTRÓNICA ASISTENCIA
    Route::get('reportes/tarjeta-electronica',
        [TarjetaElectronicaController::class, 'index'])
	->name('asistencia.reporte.tarjeta.electronica')
	->middleware("role:SUPER_ADMIN|CONTROL_ASISTENCIA|SUB_EA|INI_JUST|EMPLEADO_GRAL");
    Route::get('reportes/tarjeta-electronica/buscar',
        [TarjetaElectronicaController::class, 'buscar'])
	->name('asistencia.reporte.tarjeta.electronica.buscar')
	->middleware("role:SUPER_ADMIN|CONTROL_ASISTENCIA|SUB_EA|INI_JUST|EMPLEADO_GRAL");
    // TARJETA ELECTRÓNICA ASISTENCIA - CALENDARIO
    Route::get('reportes/calendario',
        [TarjetaElectronicaCalendarioController::class, 'index'])
	->name('asistencia.reporte.calendario')
	->middleware("role:SUPER_ADMIN|CONTROL_ASISTENCIA|SUB_EA|INI_JUST|EMPLEADO_GRAL");
    Route::get('reportes/calendario/buscar',
        [TarjetaElectronicaCalendarioController::class, 'buscar'])
	->name('asistencia.reporte.calendario.buscar')
	->middleware("role:SUPER_ADMIN|CONTROL_ASISTENCIA|SUB_EA|INI_JUST|EMPLEADO_GRAL");
    // EVENTOS ASISTENCIA
    Route::get('reportes/eventos',
        [EventoAsistenciaController::class, 'index'])
	->name('asistencia.reporte.eventos')
	->middleware("role:SUPER_ADMIN|CONTROL_ASISTENCIA|SUB_EA|INI_JUST|EMPLEADO_GRAL");
    Route::get('reportes/eventos/buscar',
        [EventoAsistenciaController::class, 'buscar'])
	->name('asistencia.reporte.eventos.buscar')
	->middleware("role:SUPER_ADMIN|CONTROL_ASISTENCIA|SUB_EA|INI_JUST|EMPLEADO_GRAL");
    // ASISTENCIAS, INASISTENCIAS Y RETARDOS
    Route::get('reportes/faltas',
        [FaltasController::class, "index"])
        ->name('asistencia.reporte.faltas')
        ->middleware('role:SUPER_ADMIN|CONTROL_ASISTENCIA');
    Route::get('reportes/faltas/buscar',
        [FaltasController::class, "buscar"])
        ->name('asistencia.reporte.faltas.buscar')
        ->middleware('role:SUPER_ADMIN|CONTROL_ASISTENCIA');
    // EVALUACIONES GENERALES
    Route::get('reportes/evaluaciones-empleados',
        [EvaluacionController::class, 'index'])
	->name('asistencia.reporte.evaluaciones')
	->middleware("role:SUPER_ADMIN|CONTROL_ASISTENCIA");

    // CATÁLOGOS
    // HORARIOS
    Route::get('catalogos/horarios', [HorarioController::class, "index"])
        ->name("asistencia.catalogo.horarios")
        ->middleware('role:SUPER_ADMIN|CONTROL_ASISTENCIA');
    Route::get('catalogos/horarios/create', [HorarioController::class, "create"])
        ->name("asistencia.catalogo.horarios.create")
        ->middleware('role:SUPER_ADMIN|CONTROL_ASISTENCIA');
    Route::post('catalogos/horarios/store', [HorarioController::class, "store"])
        ->name("asistencia.catalogo.horarios.store")
        ->middleware('role:SUPER_ADMIN|CONTROL_ASISTENCIA');
    Route::get('catalogos/horarios/{horario}/show', [HorarioController::class, "show"])
        ->name("asistencia.catalogo.horarios.show")
        ->middleware('role:SUPER_ADMIN|CONTROL_ASISTENCIA');
    Route::get('catalogos/horarios/{horario}/edit', [HorarioController::class, "edit"])
        ->name("asistencia.catalogo.horarios.edit")
        ->middleware('role:SUPER_ADMIN|CONTROL_ASISTENCIA');
    Route::post('catalogos/horarios/{horario}/update', [HorarioController::class, "update"])
        ->name("asistencia.catalogo.horarios.update")
        ->middleware('role:SUPER_ADMIN|CONTROL_ASISTENCIA');
    // DIAS FESTIVOS
    Route::get('catalogos/dias-festivos', [DiaFestivoFechaController::class, "index"])
        ->name("asistencia.catalogo.dias.festivos")
        ->middleware('role:SUPER_ADMIN|CONTROL_ASISTENCIA');
    Route::post('catalogos/dias-festivos/store', [DiaFestivoFechaController::class, "store"])
        ->name("asistencia.catalogo.dias.festivos.store")
        ->middleware('role:SUPER_ADMIN|CONTROL_ASISTENCIA');
    Route::post('catalogos/dias-festivos/update', [DiaFestivoFechaController::class, "update"])
        ->name("asistencia.catalogo.dias.festivos.update")
        ->middleware('role:SUPER_ADMIN|CONTROL_ASISTENCIA');
    // BIOMÉTRICOS
    Route::get('catalogos/biometricos', [BiometricoController::class, "index"])
        ->name("asistencia.catalogo.biometricos")
        ->middleware('role:SUPER_ADMIN|CONTROL_ASISTENCIA');
    Route::get('catalogos/biometricos/create', [BiometricoController::class, "create"])
        ->name("asistencia.catalogo.biometricos.create")
        ->middleware('role:SUPER_ADMIN|CONTROL_ASISTENCIA');
    Route::post('catalogos/biometricos/store', [BiometricoController::class, "store"])
        ->name("asistencia.catalogo.biometricos.store")
        ->middleware('role:SUPER_ADMIN|CONTROL_ASISTENCIA');
    Route::get('catalogos/biometricos/{biometrico}/edit', [BiometricoController::class, "edit"])
        ->name("asistencia.catalogo.biometricos.edit")
        ->middleware('role:SUPER_ADMIN|CONTROL_ASISTENCIA');
    Route::post('catalogos/biometricos/{biometrico}/update', [BiometricoController::class, "update"])
        ->name("asistencia.catalogo.biometricos.update")
        ->middleware('role:SUPER_ADMIN|CONTROL_ASISTENCIA');
});

