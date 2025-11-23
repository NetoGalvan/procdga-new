<?php

Route::group(['prefix' => 'procesos/historial-kardex'], function(){
    // Descripción
	Route::get('descripcion','App\Http\Controllers\p14_historial_kardex\HistorialKardexController@descripcion')
        ->name('historial.kardex.descripcion');
    //inicialización de proceso
    Route::post('inicializar-proceso', 'App\Http\Controllers\p14_historial_kardex\HistorialKardexController@inicializarProceso')
        ->name('historial.kardex.t01');
    //búsqueda de historial T02
    Route::get('busqueda-historial/{historialKardex}', 'App\Http\Controllers\p14_historial_kardex\HistorialKardexController@vistaBusquedaHistorial')
        ->name('historial.kardex.t02');
    Route::post('busqueda-historial', 'App\Http\Controllers\p14_historial_kardex\HistorialKardexController@busquedaHistorial')
        ->name('historial.kardex.busqueda');
    //creacion de historial T3A
    Route::post('creacion-historial', 'App\Http\Controllers\p14_historial_kardex\HistorialKardexController@creacionHistorial')
        ->name('historial.kardex.creacion');
    //edicion de historial T3B
    Route::post('edicion-historial', 'App\Http\Controllers\p14_historial_kardex\HistorialKardexController@edicionHistorial')
        ->name('historial.kardex.edicion');
    //Notificacion T4B
    Route::post('notificacion', 'App\Http\Controllers\p14_historial_kardex\HistorialKardexController@notificacion')
    ->name('historial.kardex.notificacion');
});
