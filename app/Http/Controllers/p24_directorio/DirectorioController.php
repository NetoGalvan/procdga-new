<?php

namespace App\Http\Controllers\p24_directorio;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Traits\Servicios\Empleado;

class DirectorioController extends Controller {

    use Empleado;

    public function getEmpleados(Request $request) {
        /* try { */

        $resp = $this->servGetDatosEmpleado($request->searchText);

            /* if ($resp["estatus"]) {
                $plazaEmpleado = Plaza::where("numero_plaza", $resp["empleado"]["numero_plaza"])->first();
                if ($plazaEmpleado) {
                    $resp["empleado"]["plaza"] = $plazaEmpleado;
                } else {
                    new Exception();
                }
            } */
        /* } catch (Exception $e) {
            return [];
        } */
        $resp["empleado"]["id"] = json_encode($resp["empleado"]);
        return response()->json([
            "data" => !$resp["estatus"] ? [] : [$resp["empleado"]]
        ]);
    }

    /* public function getEmpleados(Request $request) {
        $rolesSistema = ["SUPER_ADMIN", "CONTROL_ASISTENCIA", "KARDEX"];
        $rolesUnidad = ["SUB_EA", "OPER_PPA_20", "INI_JUST", "OPER_INC_19", "OPER_PA_21", "ADMN_PA_21", "ADMN_REP_22", "JUD_RH"];

        if (Auth::user()->hasRole($rolesSistema) || Auth::user()->hasRole($rolesUnidad)) {
            $usuarios = User::activo()
                ->where(function ($query) use($rolesSistema, $rolesUnidad) {
                    if (!Auth::user()->hasRole($rolesSistema) && Auth::user()->hasRole($rolesUnidad)) {
                        $query->whereHas("area.unidadAdministrativa", function ($query) {
                            $query->where("unidad_administrativa_id", Auth::user()->area->unidadAdministrativa->unidad_administrativa_id);
                        });
                    }
                })->where(function ($query) use ($request) {
                    $query->where(DB::raw("upper(concat_ws(' ', nombre, apellido_paterno, apellido_materno))"), "LIKE", '%' . mb_strtoupper((string) $request->searchText) . '%')
                        ->orWhere(DB::raw('upper("curp")'), "LIKE", '%' . mb_strtoupper((string) $request->searchText) . '%')
                        ->orWhere(DB::raw('upper("rfc")'), "LIKE", '%' . mb_strtoupper((string) $request->searchText) . '%')
                        ->orWhere(function ($query) use ($request) {
                        if (is_numeric($request->searchText)) {
                            $query->orWhere("numero_empleado", "LIKE", "%$request->searchText%");
                        }
                    });
                })
                ->with("area", "roles")
                ->orderBy('nombre')
                ->orderBy('apellido_paterno')
                ->orderBy('apellido_materno')
                ->get();
        } else {
            $usuarios = [];
        }

        return response()->json([
            "data" => $usuarios
        ]);
    } */

}
