<?php
Route::group(['prefix' => 'procesos/seleccion-candidatos'], function(){

            Route::get('descripcion-seleccion',
                    'App\Http\Controllers\p11_seleccion_candidatos\SeleccionCandidatosController@vistaSeleccionDescripcion')->name(
                    'seleccion.candidatos.descripcion');
            // Inicializa el proceso
            Route::post('guardar-seleccion-candidatos',
                    'App\Http\Controllers\p11_seleccion_candidatos\SeleccionCandidatosController@guardarSeleccionCandidatos')->name(
                    'seleccion.candidatos.guardar.seleccion');
            // Muestra la T01
            Route::get('solicitud-cita-examen/{candidatoEstructura}',
                    'App\Http\Controllers\p11_seleccion_candidatos\SeleccionCandidatosController@vistaCitaExamenPsicometrico')->name(
                    'seleccion.candidatos.cita.examen');

            Route::post('consulta-rfc/{rfc}', 'App\Http\Controllers\p11_seleccion_candidatos\SeleccionCandidatosController@consultarRfc')->name(
                    'seleccion.candidatos.consultar.rfcs');
            // Consulta con el RFC y No Empleado los datos del Candidato en la BD o en el SERVICIO
            Route::post('consulta-datos-empleado-candidatos',
                    'App\Http\Controllers\p11_seleccion_candidatos\SeleccionCandidatosController@consultaDatosEmpleados')->name(
                    'seleccion.candidatos.consultar.empleados.candidatos');
            // Finaliza el PROCESO desde la T01
            Route::get('finalizar-seleccion-candidatos/{seleccionCandidatoEstructura}',
                    'App\Http\Controllers\p11_seleccion_candidatos\SeleccionCandidatosController@finalizarProcesoSeleccionCandidatos')->name(
                    'seleccion.candidatos.finalizar.proceso');
            // Guarda la información y Finaliza la T01
            Route::post('guardar-candidatos/{candidatoEstructura}',
                    'App\Http\Controllers\p11_seleccion_candidatos\SeleccionCandidatosController@guardarCandidatos')->name(
                    'seleccion.candidatos.guardar.candidatos');

            Route::get('validacion-propuestas/{candidatoEstructura}',
                    'App\Http\Controllers\p11_seleccion_candidatos\SeleccionCandidatosController@vistaValidacionPropuestas')->name(
                    'seleccion.candidatos.validacion.propuestas');

            Route::post('guardar-propuestas/{candidatoEstructura}',
                    'App\Http\Controllers\p11_seleccion_candidatos\SeleccionCandidatosController@guardarValidacionPropuestas')->name(
                    'seleccion.candidatos.guardar.validacion.propuestas');

            Route::get('notificacion-fecha-cita/{seleccionCandidatoId}',
                    'App\Http\Controllers\p11_seleccion_candidatos\SeleccionCandidatosController@vistaNotificacionFechaCita')->name(
                    'seleccion.candidatos.notificacion.citas');

            Route::post('notificacion-fecha-cita/{candidatoEstructura}',
                    'App\Http\Controllers\p11_seleccion_candidatos\SeleccionCandidatosController@guardarNotificacionExamen')->name(
                    'seleccion.candidatos.guardar.notificacion.citas');

            Route::get('notificacion-rechazo-candidatos/{seleccionCandidatoId}',
                    'App\Http\Controllers\p11_seleccion_candidatos\SeleccionCandidatosController@vistaNotificacionRechazoCandidatos')->name(
                    'seleccion.candidatos.notificacion.rechazo.candidatos');

            Route::post('notificacion-rechazo-candidatos-guardar/{candidatoEstructura}',
                    'App\Http\Controllers\p11_seleccion_candidatos\SeleccionCandidatosController@guardarNotificacionRechazoCandidatosGuardar')->name(
                    'seleccion.candidatos.guardar.notificaciones.rechazo');

            Route::get('notificacion-rechazo-candidatos-srio/{seleccionCandidatoId}',
                    'App\Http\Controllers\p11_seleccion_candidatos\SeleccionCandidatosController@vistaNotificacionRechazoCandidatosSrios')->name(
                    'seleccion.candidatos.notificacion.rechazo.candidatosSrios');

            Route::post('notificacion-rechazo-candidatos-srios-guardar/{candidatoEstructura}',
                    'App\Http\Controllers\p11_seleccion_candidatos\SeleccionCandidatosController@guardarNotificacionRechazoCandidatosGuardarSrios')->name(
                    'seleccion.candidatos.guardar.notificaciones.rechazorios');

            Route::get('notificacion-rechazo-validaciones/{seleccionCandidatoId}',
                    'App\Http\Controllers\p11_seleccion_candidatos\SeleccionCandidatosController@vistaNotificacionRechazoValidaciones')->name(
                    'seleccion.candidatos.notificacion.rechazos');

            Route::post('notificacion-rechazo-validaciones-guardar/{candidatoEstructura}',
                    'App\Http\Controllers\p11_seleccion_candidatos\SeleccionCandidatosController@guardarNotificacionRechazoValidaciones')->name(
                    'seleccion.candidatos.notificacion.rechazos.guardar');

            Route::get('asignacion-fecha-examen/{candidatoEstructura}',
                    'App\Http\Controllers\p11_seleccion_candidatos\SeleccionCandidatosController@vistaAsignacionFechaExamen')->name(
                    'seleccion.candidatos.asignacion.fecha.examen.psicometricos');

            Route::post('guardar-asignacion-fecha-examen/{candidatoEstructura}',
                    'App\Http\Controllers\p11_seleccion_candidatos\SeleccionCandidatosController@guardarFechaExamen')->name(
                    'seleccion.candidatos.guardar.asignacion.fecha.examen');

            Route::post('datos-candidato/{seleccionCandidatoId}/{CandidatoId}',
                    'App\Http\Controllers\p11_seleccion_candidatos\SeleccionCandidatosController@datosDelCandidato')->name(
                    'seleccion.candidatos.datos.candidato');

            Route::get('captura-resultados-examenes/{candidatoEstructura}',
                    'App\Http\Controllers\p11_seleccion_candidatos\SeleccionCandidatosController@vistaCapturaResultados')->name(
                    'seleccion.candidatos.vista.captura.resultados');

            Route::post('datos-empleados/{candidatoEstructura}',
                    'App\Http\Controllers\p11_seleccion_candidatos\SeleccionCandidatosController@guardarDatosEmpleados')->name(
                    'seleccion.candidatos.guardar.datos.empleados');

            Route::post('datos-empleados-evaluacion/{candidatoEstructura}',
                    'App\Http\Controllers\p11_seleccion_candidatos\SeleccionCandidatosController@guardarDatosEvaluacion')->name(
                    'seleccion.candidatos.guardar.datos.eval');

            Route::post('datos-empleados-guardar/{candidatoEstructura}',
                    'App\Http\Controllers\p11_seleccion_candidatos\SeleccionCandidatosController@guardarResultadosExamenEvaluacion')->name(
                    'seleccion.candidatos.guardar.datos.empleados.evaluacion');

            Route::get('seleccion-candidato-plaza-ocupar/{seleccionCandidatoId}',
                    'App\Http\Controllers\p11_seleccion_candidatos\SeleccionCandidatosController@vistaSeleccionCandidatoOcuparPlaza')->name(
                    'seleccion.candidatos.candidato.ocupar.plaza');

            Route::post('candidato-plaza-ocupar-guardar/{candidatoEstructura}',
                    'App\Http\Controllers\p11_seleccion_candidatos\SeleccionCandidatosController@guardarCandidatoPlazaOcupar')->name(
                    'seleccion.candidatos.guardar.candidato.ocupar.plaza');

            Route::get('seleccion-candidato-comentarios-candidato/{seleccionCandidatoId}',
                    'App\Http\Controllers\p11_seleccion_candidatos\SeleccionCandidatosController@vistaSeleccionCandidatosComentarios')->name(
                    'seleccion.candidatos.candidato.comentarios');

            Route::post('seleccion-candidato-comentarios-guardar/{candidatoEstructura}',
                    'App\Http\Controllers\p11_seleccion_candidatos\SeleccionCandidatosController@guardarComentariosDga')->name(
                    'seleccion.candidatos.guardar.candidato.comentarios.dga');

            Route::get('candidato-asignacion-autorizaciones/{seleccionCandidatoId}',
                    'App\Http\Controllers\p11_seleccion_candidatos\SeleccionCandidatosController@vistaSeleccionCandidatosAutorizaciones')->name(
                    'seleccion.candidatos.candidatos.autorizaciones');

            Route::post('candidato-asignacion-candidatos-autorizaciones-guardar/{candidatoEstructura}',
                    'App\Http\Controllers\p11_seleccion_candidatos\SeleccionCandidatosController@guardarAutorizaciones')->name(
                    'seleccion.candidatos.guardar.autorizaciones');

            Route::get('candidato-asignacion-fecha-ingreso/{seleccionCandidatoId}',
                    'App\Http\Controllers\p11_seleccion_candidatos\SeleccionCandidatosController@vistaSeleccionCandidatosFechaIngresos')->name(
                    'seleccion.candidatos.candidatos.fecha.ingresos');

            Route::get('candidato-asignacion-fecha-ingreso1/{seleccionCandidatoId}',
                    'App\Http\Controllers\p11_seleccion_candidatos\SeleccionCandidatosController@vistaSeleccionCandidatosFechaIngresos1')->name(
                    'seleccion.candidatos.candidatos.fecha.ingresos1');

            Route::post('seleccion-candidato-fecha-ingresos-guardar/{candidatoEstructura}/{candidatoSeleccionado}',
                    'App\Http\Controllers\p11_seleccion_candidatos\SeleccionCandidatosController@guardarFechasIngresos')->name(
                    'seleccion.candidatos.guardar.fecha.ingresos');

            Route::get('generacion-numero-validacion/{seleccionCandidatoId}',
                    'App\Http\Controllers\p11_seleccion_candidatos\SeleccionCandidatosController@vistaSeleccionGeneracionNumeroValidacion')->name(
                    'seleccion.candidatos.candidatos.generacion.numero.validacion');

            Route::post('guardar-numero-validacion/{candidatoEstructura}',
                    'App\Http\Controllers\p11_seleccion_candidatos\SeleccionCandidatosController@guardarNumerovalidacion')->name(
                    'seleccion.candidatos.guardar.numero.validacion');

});




