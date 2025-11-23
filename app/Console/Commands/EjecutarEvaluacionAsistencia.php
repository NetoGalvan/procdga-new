<?php

namespace App\Console\Commands;

use App\Http\Utils\procesos\asistencias\EvaluarAsistenciaEmpleado;
use App\Http\Utils\procesos\asistencias\RecuperarEventos;
use App\Models\Empleado;
use App\Models\LogLocal;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class EjecutarEvaluacionAsistencia extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "evaluacion:asistencia";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Ejecuta la tarea de evaluación de asistencia de empleados";

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info("Ejecutando la evaluación de asistencia de empleados...");

        $fechaInicioEvaluacionLocal = Carbon::parse(config("general.asistencia.fecha_inicio_evaluacion"));
        if (Carbon::now()->lessThan($fechaInicioEvaluacionLocal)) {
            return false;
        }
        $fechaInicio = Carbon::now()->subMonths(1);
        $fechaFinal = Carbon::now();
        if ($fechaInicio->lessThan($fechaInicioEvaluacionLocal)) {
            $fechaInicio = $fechaInicioEvaluacionLocal->copy();
        }            
        try {
            LogLocal::create([
                "tipo" => "INFO", 
                "modulo" => "RECUPERACIÓN DE EVENTOS EN ARCHIVOS",
                "mensaje" => "Inicia recuperación de archivos para el periodo: {$fechaInicio->format("d-m-Y")} al {$fechaFinal->format("d-m-Y")}", 
            ]);

            DB::beginTransaction();

            $recuperarEventos = new RecuperarEventos($fechaInicio->copy(), $fechaFinal->copy());
            $recuperarEventos->recuperar();

            DB::commit();

            LogLocal::create([
                "tipo" => "INFO", 
                "modulo" => "RECUPERACIÓN DE EVENTOS EN ARCHIVOS",
                "mensaje" => "Finaliza recuperación de archivos para el periodo: {$fechaInicio->format("d-m-Y")} al {$fechaFinal->format("d-m-Y")}", 
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            LogLocal::create([
                "tipo" => "ERROR", 
                "modulo" => "RECUPERACIÓN DE EVENTOS EN ARCHIVOS",
                "mensaje" => $e->getMessage(), 
                "datos_extra" => json_encode([
                    "file" => $e->getFile(),
                    "code" => $e->getCode(),
                    "line" => $e->getLine()
                ])
            ]);
            return;
        }

        try {
            LogLocal::create([
                "tipo" => "INFO", 
                "modulo" => "EVALUACIÓN DE ASISTENCIAS",
                "mensaje" => "Inicia evaluación de asistencias para el periodo: {$fechaInicio->format("d-m-Y")} al {$fechaFinal->format("d-m-Y")}", 
            ]);

            $empleados = Empleado::activo()
                /* ->where(function($query) {
                    $query->where("nivel_salarial", "<", 20)
                        ->orWhere("nivel_salarial", ">", 48);
                }) */
                ->orderBy("empleado_id")->get(); 
            
            DB::beginTransaction();
            
            foreach ($empleados as $empleado) {
                $evaluarAsistenciaEmpleado = new EvaluarAsistenciaEmpleado($empleado, $fechaInicio->copy(), $fechaFinal->copy());
                $evaluarAsistenciaEmpleado->evaluar();
            }

            DB::commit();

            LogLocal::create([
                "tipo" => "INFO", 
                "modulo" => "EVALUACIÓN DE ASISTENCIAS",
                "mensaje" => "Finaliza evaluación de asistencias para el periodo: {$fechaInicio->format("d-m-Y")} al {$fechaFinal->format("d-m-Y")}", 
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            LogLocal::create([
                "tipo" => "ERROR", 
                "modulo" => "EVALUACIÓN DE ASISTENCIAS",
                "mensaje" => $e->getMessage(), 
                "datos_extra" => json_encode([
                    "file" => $e->getFile(),
                    "code" => $e->getCode(),
                    "line" => $e->getLine()
                ])
            ]);
        }

        $this->info("Finaliza la evaluación de asistencia de empleados...");
    }
}
