<?php

namespace App\Http\Middleware;

use App\Models\InstanciaTarea;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HasPermissionTask
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Roles de usuario por ámbito
        $roles = Auth::user()->roles->groupBy("tipo")
        ->map(function ($type) {
            return $type->pluck('id')->toArray();
        });

        $instanciaTarea = InstanciaTarea::where("instancia_tarea_id", $request->instanciaTarea->instancia_tarea_id)
            ->whereIn('estatus', ["NUEVO", "EN_CORRECCION", "NOTIFICACION_NO_LEIDO", "NOTIFICACION_LEIDO"])
            ->where(function ($query) use ($roles) {
                if (!Auth::user()->hasRole("SUPER_ADMIN")) {
                    $query->where(function ($query) use ($roles) {
                            $query->where("asignado_al_usuario", Auth::user()->id)
                                ->whereIn("asignado_al_rol", $roles["USUARIO"] ?? []);
                        })
                        ->orWhere(function ($query) use ($roles) {
                            $query->where("pertenece_al_area", Auth::user()->area_id)
                                ->whereIn("asignado_al_rol", $roles["AREA"] ?? []);
                        })
                        ->orWhere(function ($query) use ($roles) {
                            $query->where(function ($query) {
                                    $query->where("pertenece_al_area", Auth::user()->area_id)
                                        ->orWhereHas("perteneceAlArea.areaPrincipal", function ($query) {
                                            $query->where("area_id", Auth::user()->area_id);
                                        });
                                })
                                ->whereIn('asignado_al_rol', $roles["AREA_PRINCIPAL"] ?? []);
                        })
                        ->orWhere(function ($query) use ($roles) {
                            $query->where("pertenece_unidad_administrativa", Auth::user()->area->unidadAdministrativa->unidad_administrativa_id)
                                ->whereIn('asignado_al_rol', $roles["UNIDAD_ADMINISTRATIVA"] ?? []);
                        })
                        ->orWhere(function ($query) use ($roles) {
                            $query->where("pertenece_dependencia", Auth::user()->area->unidadAdministrativa->dependencia->dependencia_id)
                                ->whereIn('asignado_al_rol', $roles["DEPENDENCIA"] ?? []);
                        })
                        ->orWhere(function ($query) use ($roles) {
                            $query->whereIn('asignado_al_rol', $roles["GOBIERNO"] ?? []);
                        });
                }
            })
            ->first();

        if ($instanciaTarea) {
            return $next($request);
        } 

        return redirect(RouteServiceProvider::HOME); 
    }
}