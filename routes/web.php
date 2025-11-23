<?php

use App\Http\Controllers\Auth\LoginCredencializacionController;
use App\Http\Controllers\Catalogos\CatalogosController;
use App\Http\Controllers\Documentos\DocumentoController;
use App\Http\Controllers\General\ProcesoGeneralController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\p15_asistencia\reportes\CalendarioController;
use App\Http\Utils\procesos\asistencias\AdministrarAsistenciaEmpleado;
use App\Http\Utils\procesos\asistencias\EvaluarAsistenciaEmpleado;
use App\Http\Utils\procesos\asistencias\RecuperarEventos;
use App\Jobs\EnviarMail;
use App\Mail\Prueba;
use App\Models\Area;
use App\Models\Empleado;
use App\Models\historico\lbpm_dga\p12_tramites_incidencias\HistoricoIncidenciaEmpleado;
use App\Models\historico\lbpm_dga\p12_tramites_incidencias\HistoricoTipoIncidencia;
use App\Models\historico\lbpm_dga\p15_asistencia\HistoricoHorario;
use App\Models\historico\lbpm_dga\p15_asistencia\HistoricoHorarioIntervalo;
use App\Models\historico\lbpm_sica\HistoricoBiometrico;
use App\Models\historico\lbpm_sica\HistoricoEvento;
use App\Models\LogLocal;
use App\Models\p12_tramites_incidencias\TipoIncidencia;
use App\Models\p12_tramites_incidencias\TipoJustificacion;
use App\Models\p15_asistencia\Biometrico;
use App\Models\p15_asistencia\Horario;
use App\Models\p15_asistencia\HorarioIntervalo;
use App\Models\User;
use App\Notifications\PruebaNotificacion;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/login');
});

Auth::routes();

// LOGIN Y SERVICIOS CREDENCIALIZACIÓN
Route::group([
	'prefix' => 'credencializacion',
], function() {
    Route::get('/login', [LoginCredencializacionController::class, 'login'])->name('credencializacion.login');
    Route::get('/callback', [LoginCredencializacionController::class, 'callback'])->name('credencializacion.callback');
    Route::get('/getUser', [LoginCredencializacionController::class, 'getUser'])->name('credencializacion.getUser');
});

Route::middleware([
    'auth',
    'verify.password.change',
])->group(function () {
    // ADMINISTRADOR
    require 'administrador/administrador.php';
    // P01 - MOVIMIENTOS DE PERSONAL
    require 'procesos/p01_movimientos_personal/movimientos_personal.php';
    // P02 - TRÁMITES ISSSTE
    require 'procesos/p02_tramites_issste/tramites_issste.php';
    // P06 - SERVICIO SOCIAL
    require 'procesos/p06_servicio_social/servicio_social.php';
    require 'procesos/p06_servicio_social/servicio_social_sub_proceso.php';
    // P07 - PAGO DE PRESTACIONES
    require 'procesos/p07_pago_prestaciones/pago_prestaciones.php';
    // P08 - SOLICITAR SERVICIOS
    require 'procesos/p08_solicita_servicios/solicitud_servicios.php';
    // P11 - SELECCIÓN DE CANDIDATOS DE ESTRUCTURA
    require 'procesos/p11_seleccion_candidatos/seleccion_candidatos.php';
    // P12 - INCIDENCIAS
    require 'procesos/p12_tramites_incidencias/tramites_incidencias.php';
    // P14 - Historial Kardex
    require 'procesos/p14_historial_kardex/historial_kardex.php';
    // P15 - CONTROL DE ASISTENCIA
    require 'procesos/p15_asistencia/asistencia.php';
    // P16 - PAGO DE TIEMPO EXTRAORDINARIO Y EXCEDENTE
    require 'procesos/p16_pago_tiempo_extraordinario_excedente/pago_tiempo_extraordinario_excedente.php';
    // P19 - INCENTIVOS EMPLEADO MES
    require 'procesos/p19_incentivos_empleado_mes/incentivos_empleado_mes.php';
    // P20 - PREMIO DE PUNTUALIDAD Y ASISTENCIA
    require 'procesos/p20_premio_puntualidad_asistencia/premio_puntualidad_asistencia.php';
    // P21 - PREMIO DE ADMINISTRACIÓN
    require 'procesos/p21_premio_administracion/premio_administracion.php';
    require 'procesos/p21_premio_administracion/premio_administracion_inscripcion.php';
    // P22 - REPORTES DÍAS EFECTIVAMENTE LABORADOS
    require 'procesos/p22_reportes_dias_efectivamente_laborados/reportes_dias_efectivamente_laborados.php';
    // P23 - SOLICITUD DE EXPEDIENTE
    require 'procesos/p23_digitalizacion_archivo/solicitud_expediente.php';
    require 'procesos/p23_digitalizacion_archivo/expediente_digitalizacion.php';
    // P31 - VIATINET
    require 'procesos/p31_viatinet/viatinet.php';
    // P32 - TRÁMITES KARDEX
    require 'procesos/p32_tramites_kardex/tramites_kardex.php';

    // GENERALES
    Route::get('home', [HomeController::class, "home"])->name("home");
    Route::post('change-estatus-sidebar', [ProcesoGeneralController::class, "changeEstatusSidebar"])->name('change.estatus.sidebar');
    Route::get('change-password-first-login', [ProcesoGeneralController::class, "changePasswordFirstLogin"])->name('change.password.first.login');
    Route::post('change-password-first-login', [ProcesoGeneralController::class, "changePasswordFirstLogin"]);
    Route::get('tareas', [ProcesoGeneralController::class, "tareas"])->name('tareas');
    Route::get('notificaciones', [ProcesoGeneralController::class, "notificaciones"])->name('notificaciones');
    Route::get('procesos-en-curso', [ProcesoGeneralController::class, 'procesoEnCurso'])->name('procesos.en.curso');
    Route::get('procesos', [ProcesoGeneralController::class, 'procesos'])->name('procesos');
    Route::get('reportes', [ProcesoGeneralController::class, "reportes"])->name('reportes');
    Route::get('catalogos', [ProcesoGeneralController::class, "catalogos"])->name('catalogos');
    Route::get('archivos-externos', [ProcesoGeneralController::class, "archivosExternos"])->name('archivos.externos');
    Route::get('manuales', [ProcesoGeneralController::class, "manuales"])->name('manuales');
    Route::get('lineamientos', [ProcesoGeneralController::class, "lineamientos"])->name('lineamientos');
    Route::get('getDatosCodigoPostal', [CatalogosController::class, "getDatosCodigoPostalV2"])->name('catalogo.codigo.postal.v2');
    Route::get('getTareas/{tipoInstanciaTarea}/{tipoRespuesta}', [ProcesoGeneralController::class, "getTareas"])->name('getTareas');
    Route::get('getProcesosEnCurso', [ProcesoGeneralController::class, "getProcesosEnCurso"])->name('getProcesosEnCurso');
    Route::get('proceso-en-curso-avance/{instancia?}', [ProcesoGeneralController::class, "procesoEnCursoAvance"])->name('proceso.en.curso.avance');

    // DOCUMENTOS
    Route::get('documentos/{documento}/show', [DocumentoController::class, "show"])->name('documentos.show');
    Route::get('documentos/{documento}/download', [DocumentoController::class, "download"])->name('documentos.download');
    Route::delete('documentos/{documento}/destroy', [DocumentoController::class, "destroy"])->name('documentos.destroy');
});

// Prueba correo
Route::get('/prueba', function () {

    // Area::create([
    //     'nombre' => 'Oficina del C. Secretario de Finanzas',
    //     'unidad_administrativa_id' => 3,
    //     'identificador' => 80,
    //     'cn' => 80,
    //     'ou' => 'Oficina del C. Secretario de Finanzas',
    // ]);
    // User::find(1)->notify((new PruebaNotificacion));

    Notification::route("mail", ["jigarcia@finanzas.cdmx.gob.mx"])
        ->notify((new PruebaNotificacion));
/*     EnviarMail::dispatch("pime.cs@gmail.com", new Prueba("DOCUMENTACIÓN - PROCDGA"));
 */
    // Mail::to('edwin170296@gmail.com')->send(new Prueba("DOCUMENTACIÓN - PROCDGA"));
});

/* Route::get('reportes/calendario/prueba',
    [CalendarioController::class, 'prueba']
); */

Route::get('/auth/token', function (Request $request) {
    $token = $request->token;
    if (!$token) {
        // Token no proporcionado, manejar el error.
        return redirect('/login')->withErrors('No se proporcionó token.');
    }

    $client = new Client();

    try {
        // $response = $client->request('GET', 'http://127.0.0.1:8081/api/user', [ PRUEBA
        $response = $client->request('GET', 'https://dev.finanzas.cdmx.gob.mx/erevocacion/public/api/user', [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
            ],
        ]);

        if ($response->getStatusCode() == 200) {
            $userDetails = json_decode($response->getBody()->getContents(), true);
            
            $user = User::where('email', $userDetails['email'])->first();
            

            if (!$user) {
                // Si el usuario no existe en la aplicación hija, redirigir de vuelta a la aplicación padre.
                // return redirect('http://127.0.0.1:8081/user-not-found'); PRUEBA
                return redirect('https://dev.finanzas.cdmx.gob.mx/erevocacion/public/user-not-found');
            }

            // Autenticar al usuario en la aplicación hija.
            Auth::login($user);

            // Redirigir al usuario a la página de inicio de la aplicación hija.
            return redirect()->to('/home');
        } else {
            // El código de estado no es 200, manejar como error de validación.
            return redirect('/login')->withErrors('El token no es válido.');
        }
    } catch (\Exception $e) {
        // Captura de excepciones de Guzzle por errores de red, etc.
        return redirect('/login')->withErrors('Error al validar el token.');
    }

});

Route::get('/evaluarEmpleado', function () {
    try {
        $startTime = microtime(true);
        $empleado = Empleado::where("numero_empleado", 889806)->first();
        $evaluarAsistenciaEmpleado = new EvaluarAsistenciaEmpleado($empleado, "12-04-2024", "17-04-2024");
        $evaluarAsistenciaEmpleado->evaluar();
        $endTime = microtime(true);
        // Calculamos la duración
        $executionTime = $endTime - $startTime;

        dd($executionTime);
    } catch (Exception $e) {
        LogLocal::create([
            "tipo" => "ERROR", 
            "modulo" => "PRUEBA EVALUACIÓN",
            "mensaje" => $e->getMessage(), 
            "datos_extra" => json_encode([
                "file" => $e->getFile(),
                "code" => $e->getCode(),
                "line" => $e->getLine()
            ])
        ]);
        return response()->json([
            "estatus" => false,
            "mensaje" => "No se puede consultar los datos en este momento. Por favor, intente más tarde."
        ]); 
    }
});

Route::get('/recuperarEventos', function () {
    $fechaInicioEvaluacionLocal = Carbon::parse(config("general.asistencia.fecha_inicio_evaluacion"));
    $fechaInicio = Carbon::now()->subMonths(1);
    $fechaFinal = Carbon::now();
    if ($fechaInicio->lessThan($fechaInicioEvaluacionLocal)) {
        $fechaInicio = $fechaInicioEvaluacionLocal->copy();
    }   
    $recuperarEventos = new RecuperarEventos($fechaInicio, $fechaFinal);
    $recuperarEventos->recuperar();
});

Route::get('/getHorasExtraEmpleado', function () {
    try {
        $empleado = Empleado::where("numero_empleado", "889806")->first();
        $administrarAsistencia = new AdministrarAsistenciaEmpleado($empleado, "01-01-2024", "31-01-2024");
        /* $evaluacionesPorFechas = $administrarAsistencia->getEvaluacionesPorFechas(); */
        $incidenciasPorFechas = $administrarAsistencia->getIncidenciasPorFechas();

        dd($incidenciasPorFechas);
        
    } catch (Exception $e) {
        LogLocal::create([
            "tipo" => "ERROR", 
            "modulo" => "PRUEBA HORAS EXTRA",
            "mensaje" => $e->getMessage(), 
            "datos_extra" => json_encode([
                "file" => $e->getFile(),
                "code" => $e->getCode(),
                "line" => $e->getLine()
            ])
        ]);
        return response()->json([
            "estatus" => false,
            "mensaje" => "No se puede consultar los datos en este momento. Por favor, intente más tarde."
        ]); 
    }
});

/*

Route::get('/genera-catalogo-biométricos', function () {
    $biometricos = HistoricoEvento::whereDate("ts_evento", ">=", "01-01-2023")
        ->select("tip")
        ->groupBy("tip")
        ->get();
    
    $nuevoCatalogoBiometricos = collect();
    foreach ($biometricos as $biometrico) {
        $biometricoAux = HistoricoBiometrico::where("ip_biometrico", $biometrico->tip)->first();
        if ($biometricoAux) {
            $nuevoCatalogoBiometricos->push(collect([
                "nombre" =>  $biometricoAux->ubicacion_biometrico,
                "ip" =>  $biometricoAux->ip_biometrico,
                "ubicacion" =>  $biometricoAux->ubicacion_biometrico,
            ]));
        } else {
            $nuevoCatalogoBiometricos->push(collect([
                "nombre" =>  $biometrico->tip,
                "ip" =>  $biometrico->tip,
                "ubicacion" => null
            ]));
        }
    }

    $nuevoCatalogoBiometricos = $nuevoCatalogoBiometricos->sortBy(function ($item) {
        return $item['nombre'];
    })->values();

    // Primera parte: elementos del índice 0 al 15 (16 elementos)
    $biometricosSinNombre = $nuevoCatalogoBiometricos->slice(0, 14);

    // Segunda parte: elementos del índice 16 al 49 (34 elementos)
    $biometricosConNombre = $nuevoCatalogoBiometricos->slice(14);  

    // BUscar los biometricos inactivos 
    $ips = $biometricosConNombre->pluck('ip')->unique()->all();
    $biometricosInactivos = Biometrico::whereNotIn('ip', $ips)->get();

    $biometricos = $biometricosConNombre->merge($biometricosInactivos)->sortBy(function ($item) {
        return strtolower($item['nombre']);
    })->values();

    foreach ($biometricosSinNombre as $biometrico) {
        if ($biometrico instanceof Biometrico) {
            Biometrico::create([
                "nombre" => mb_strtoupper($biometrico->nombre),
                "acceso" => null,
                "ip" => $biometrico->ip,
                "tipo" => "DACTILAR",
                "ubicacion" =>  mb_strtoupper($biometrico->nombre),
                "activo" => false,
            ]);
        } else {
            Biometrico::create([
                "nombre" => mb_strtoupper($biometrico["nombre"]),
                "acceso" => null,
                "ip" => $biometrico["ip"],
                "tipo" => "DACTILAR",
                "ubicacion" =>  mb_strtoupper($biometrico["ubicacion"]),
                "activo" => true
            ]);
        }
    }

});

Route::get('/genera-catalogo-horarios', function () {
    $horarios = HistoricoHorario::where([
            "active" => true, 
            "deleted" => false,
            ["descripcion", "!=", null],
            ["descripcion", "!=", ""],
        ])
        ->has("intervalos")
        ->with("intervalos")
        ->orderBy("t_start")
        ->get();
    foreach ($horarios as $horario) {
        $tiposEmpleados = [
            "SINDICALIZADOS" => "SINDICALIZADO",
            "NO SINDICALIZADOS" => "NO_SINDICALIZADO",
        ]; 
        $tiposIntervalos = [
            "ENTRADA" => "ENTRADA",
            "RETARDO LEVE" => "RETARDO_LEVE",
            "RETARDO GRAVE" => "RETARDO_GRAVE",
            "SALIDA" => "SALIDA"
        ]; 
        $horarioNuevo = Horario::create([
            "entrada" => $horario->t_start,
            "salida" => $horario->t_end,
            "dias" => $horario->dias,
            "es_horario_base" => false,
            "aplica_retardos" => true,
            "dias_festivos_son_laborales" => false,
            "tipo_empleado" => $tiposEmpleados[$horario->descripcion],
            "tipo_asignacion" => "SISTEMA"
        ]);
        foreach ($horario->intervalos as $intervalo) {
            HorarioIntervalo::create([
                "inicio" => $intervalo->t_start,
                "final" => $intervalo->t_end,
                "tipo" => $tiposIntervalos[$intervalo->intervalo],
                "horario_id" => $horarioNuevo->horario_id
            ]);
        }
    }
});

Route::get('/genera-catalogo', function () {
    $tiposIncidencias = HistoricoTipoIncidencia::orderBy("id_justificacion")->get();
    foreach ($tiposIncidencias as $tipoIncidencia) {
        $existeIncidencia = HistoricoIncidenciaEmpleado::where("id_justificacion", $tipoIncidencia->id_justificacion)->exists();
        if ($existeIncidencia) {
            $tipoJustificacion = TipoJustificacion::where("identificador", $tipoIncidencia->tipoJustificacion->identificador)->first();
            TipoIncidencia::create([
                "tipo_incidencia_id" => $tipoIncidencia->id_justificacion,
                "ley" => trim(mb_strtoupper($tipoIncidencia->ley)),
                "tipo_justificacion_id" => $tipoJustificacion->tipo_justificacion_id,
                'articulo' => ($temp = trim(mb_strtoupper($tipoIncidencia->articulo))) ? $temp : null,
                'subarticulo' => ($temp = trim(mb_strtoupper($tipoIncidencia->sub_articulo))) ? $temp : null,
                'descripcion' => ($temp = trim(mb_strtoupper($tipoIncidencia->descripcion))) ? $temp : null,
                'dias' => $tipoIncidencia->dias,
                'anio' => $tipoIncidencia->anio,
                'cada_cuantos_dias' => $tipoIncidencia->cada_cuantos_dias,
                'fecha_inicio' => $tipoIncidencia->fecha_inicio,
                'fecha_final' => $tipoIncidencia->fecha_fin,
                'gasta' => $tipoIncidencia->gasta,
                'tipo_empleado' => $tipoIncidencia->tipo_empleado,
                'activo' => $tipoIncidencia->status == "ACTIVO",
                'tipo_dias' => $tipoIncidencia->tipo_dias,
                'antiguedad' => $tipoIncidencia->antiguedad,
                'sexo' => mb_strtoupper($tipoIncidencia->sexo) == "F" ? "F" : "TODOS",
                'fecha_prescribe' => $tipoIncidencia->fecha_prescribe,
                'observaciones' => ($temp = trim(mb_strtoupper($tipoIncidencia->observaciones))) ? $temp : null,
                'unica_vez' => $tipoIncidencia->unica_vez,
                'intervalo_evaluacion' => $tipoIncidencia->intervalo_evaluacion,
                'aplica_autoincidencia' => $tipoIncidencia->aplicacion_kiosko == true,
                'json_fechas_inhabiles' => $tipoIncidencia->json_fechas_inhabiles
            ]);
        }
    }
    DB::statement("SELECT setval('p12_tipos_incidencias_tipo_incidencia_id_seq', (SELECT MAX(tipo_incidencia_id) FROM p12_tipos_incidencias));");
});
 */