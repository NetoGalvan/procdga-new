<?php

use App\Http\Controllers\Administrador\AreaController;
use App\Http\Controllers\Administrador\FormatoController;
use App\Http\Controllers\Administrador\LogController;
use App\Http\Controllers\Administrador\RoleController;
use App\Http\Controllers\Administrador\UsuarioController;
use App\Http\Controllers\Administrador\ProcesoController;
use App\Http\Controllers\Administrador\EmpleadoController;
use App\Http\Controllers\Administrador\AsistenciaController;
use App\Http\Controllers\Administrador\UnidadesController;

Route::group([
    'prefix' => 'admin',
    'middleware' => ['role:SUPER_ADMIN']
], function() {

    // Usuarios
    Route::prefix('usuarios')->group(function () {
        Route::get('/', [UsuarioController::class, "index"])->name('usuarios.index');
        Route::get('/crear', [UsuarioController::class, "create"])->name('usuarios.create');
        Route::post('/store', [UsuarioController::class, "store"])->name('usuarios.store');
        Route::get('/{usuario}/editar', [UsuarioController::class, "edit"])->name('usuarios.edit');
        Route::put('/{usuario}', [UsuarioController::class, "update"])->name('usuarios.update');
        Route::get('/getUsuarios', [UsuarioController::class, "getUsuarios"])->name('usuarios.getUsuarios');
    });

    // Unidades
    Route::resource('unidades', UnidadesController::class)->parameters([
        'unidades' => 'unidad',
    ]);

    // Areas
    Route::resource('unidades.areas', AreaController::class)->parameters([
        'unidades' => 'unidad',
    ]);

    // Unidades Administrativas - Áreas
    Route::prefix('unidades')->group(function () {
        Route::get('/{unidadAdmin}/unidad-areas', [UnidadesController::class, "unidadAreas"])->name('unidades.administrativas.areas');
        Route::get('/{unidadAdmin}/crear', [UnidadesController::class, "crearUnidadArea"])->name('unidades.administrativas.crear.unidad.area');
        Route::post('/{unidadAdmin}/guardar', [UnidadesController::class, "guardarUnidadArea"])->name('unidades.administrativas.guardar.unidad.area');
        Route::get('/{unidadAdmin}/{area}/editar', [UnidadesController::class, "editarUnidadArea"])->name('unidades.administrativas.editar.unidad.area');
        Route::post('/{unidadAdmin}/{area}/actualizar', [UnidadesController::class, "actualizarUnidadArea"])->name('unidades.administrativas.actualizar.unidad.area');
    });

    // Roles
    Route::resource('roles', RoleController::class);

    // Formatos
    Route::get('formatos', [FormatoController::class, "index"])->name("formatos.index");
    Route::post('formatos/guardar-atributos', [FormatoController::class, "guardarAtributosFormato"])->name("formatos.guardar.atributos");

    // Logs
    Route::get('logs', [LogController::class, "index"])->name('logs.index');
    Route::get('/getLogs', [LogController::class, "getLogs"])->name('logs.getLogs');

    // Alfabético
    Route::prefix('empleados')->group(function () {
        Route::get('/', [EmpleadoController::class, "index"])->name('alfabetico.index');
        Route::get('/iniciar-proceso', [EmpleadoController::class, "iniciar"])->name('alfabetico.iniciar.proceso');
        Route::get('/{alfabetico}/cargar-alfabetico', [EmpleadoController::class, "cargarAlfabetico"])->name('alfabetico.carga.alfabetico');
        Route::post('/{alfabetico}/cargar-alfabetico', [EmpleadoController::class, "cargarAlfabetico"]);
        Route::post('/{alfabetico}/cargar-alfabetico-guardar-txt', [EmpleadoController::class, "cargarAlfabeticoGuardarTXT"])->name('alfabetico.carga.alfabetico.guardar.txt');
        Route::post('/eliminar-txt-archivo', [EmpleadoController::class, "eliminarTXTArchivo"])->name('alfabetico.carga.alfabetico.eliminar.txt');
        Route::get('/{empleado}/editar-empleado', [EmpleadoController::class, "editarEmpleado"])->name('alfabetico.editar.empleado');
        Route::post('/{empleado}/editar-empleado', [EmpleadoController::class, "editarEmpleado"]);
    });

    // Eventos
    Route::prefix('asistencias')->group(function () {
        Route::get('/', [AsistenciaController::class, "index"])->name('asistencias.index');
        Route::get('/iniciar-proceso', [AsistenciaController::class, "iniciar"])->name('asistencias.iniciar.proceso');
        Route::get('/{asistencia}/cargar-asistencias', [AsistenciaController::class, "cargarAsistencias"])->name('asistencias.carga.asistencias.archivos');
        Route::post('/{asistencia}/cargar-asistencias', [AsistenciaController::class, "cargarAsistencias"]);
        Route::post('cargar-asistencias-eliminar', [AsistenciaController::class, "cargarAsistenciasEliminar"])->name('asistencias.carga.asistencias.archivos.eliminar');
        Route::post('/{asistencia}/{biometrico}/cargar-asistencias-guardar-txt', [AsistenciaController::class, "cargarAsistenciaGuardarTXT"])->name('asistencias.carga.asistencia.guardar.txt');
        Route::post('/eliminar-txt-archivo', [AsistenciaController::class, "eliminarTXTArchivo"])->name('asistencias.carga.asistencia.eliminar.txt');
    });

});

// Obtener datos de empleado apartir del RFC
Route::get('getEmpleados', [EmpleadoController::class, "getEmpleados"])->name('alfabetico.get.empleados');
