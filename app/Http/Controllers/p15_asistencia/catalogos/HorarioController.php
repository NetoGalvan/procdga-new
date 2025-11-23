<?php

namespace App\Http\Controllers\p15_asistencia\catalogos;

use App\Http\Controllers\Controller;
use App\Models\p15_asistencia\Horario;
use App\Models\p15_asistencia\HorarioIntervalo;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Input\Input;
use Throwable;

class HorarioController extends Controller
{
    public function index()
    {
        $horarios = Horario::where([
                "tipo_asignacion" => "SISTEMA"
            ])
            ->whereIn("tipo_empleado", ["SINDICALIZADO", "NO_SINDICALIZADO"])
            ->with("intervalos")
            ->orderBy("es_horario_base", "DESC")
            ->orderBy("tipo_empleado", "DESC")
            ->orderBy("entrada")
            ->get();

        foreach($horarios as $horario) {
            $horario->intervalosAux = $horario->intervalos->keyBy('tipo');
        }
        return view('p15_asistencia.catalogos.horarios.index', compact('horarios'));
    }

    public function create()
    {
        return view('p15_asistencia.catalogos.horarios.create');
    }

    public function store(Request $request)
    {
        try {
            $diasSemana = ["domingo", "lunes", "martes", "miercoles", "jueves", "viernes", "sabado"];
            $diasHorario = "";    
            foreach ($diasSemana as $dia) {
                if (in_array($dia, $request->dias_laborales)) {
                    $diasHorario .= "1";
                } else {
                    $diasHorario .= "0";
                }
            }
            $request->merge([
                "es_horario_base" => $request->has("es_horario_base"),
                "aplica_retardos" => $request->has("aplica_retardos"),
                "dias_festivos_son_laborales" => $request->has("dias_festivos_son_laborales"),
                "dias" => $diasHorario
            ]);

            // Comprobar si existe horario
            $horario = Horario::where([
                "entrada" => $request->entrada,
                "salida" => $request->salida,
                "dias" => $diasHorario,
                "tipo_empleado" => $request->tipo_empleado,
            ])->first();    
            
            // Si existe el horario, comprobar que los intervalos sean diferentes
            if ($horario) {
                $intervalosIguales = true;
                foreach ($request->intervalos as $tipo => $intervalo) {
                    if ($horario->intervalos()->where([
                        "tipo" => $tipo,
                        "inicio" => $intervalo["inicio"],
                        "final" => $intervalo["final"]
                    ])->exists()) {
                        continue;
                    }
                    $intervalosIguales = false;
                    break; 
                }
                if ($intervalosIguales) {
                    return redirect()->back()->with("error", "El horario ya existe, modifique sus valores.")->withInput();
                }
            }

            DB::beginTransaction();

            $horario = Horario::create($request->all());

            foreach ($request->intervalos as $tipo => $intervalo) {
                if (is_null($intervalo["inicio"])) continue;
                HorarioIntervalo::create([
                    "inicio" => $intervalo["inicio"],
                    "final" => $intervalo["final"],
                    "tipo" => $tipo,
                    "horario_id" => $horario->horario_id
                ]);
            }

            if ($horario->es_horario_base) {
                Horario::where("horario_id", "!=", $horario->horario_id)->where([
                    "es_horario_base" => true,
                    "tipo_empleado" => $horario->tipo_empleado
                ])->update([
                    "activo" => false
                ]);
            }

            DB::commit();
            return redirect()->route("asistencia.catalogo.horarios")
                ->with("success", "Se agregó correctamente el horario");
        } catch (Throwable $e) {
            DB::rollback();
            return redirect()->back()->with("error", "Error al crear el horario, intente más tarde.")->withInput();
        } 
    }

    public function show(Horario $horario)
    {
        return view('p15_asistencia.catalogos.horarios.show', compact("horario"));
    }

    public function edit(Horario $horario)
    {
        return view('p15_asistencia.catalogos.horarios.edit', compact("horario"));
    }

    public function update(Request $request, Horario $horario)
    {
        if (!$horario->es_horario_base) {
            $horario->update([
                "activo" => $request->has("activo"),
            ]);
            return redirect()->back()->with("success", "Se guardó correctamente el horario");
        }
        return redirect()->back()->with("error", "El horario es de base y no se puede modificar directamente");
    }
}
