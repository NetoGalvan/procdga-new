<?php
namespace App\Http\Controllers\General;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Catalogo;
use App\Models\historico\lbpm_dga\p12_tramites_incidencias\HistoricoEmpleadoKardex;
use App\Models\Tramite;
use App\Models\Instancia;
use App\Models\InstanciaTarea;
use App\Models\Lineamiento;
use App\Models\Manual;
use App\Models\Reporte;
use App\Models\Tarea;
use App\Models\p08_solicita_servicios\ServicioGeneral;
use App\Models\Proceso;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProcesoGeneralController extends Controller {

    public function changeEstatusSidebar(Request $request) {
        $asideMinimize = $request->input('asideMinimize') === "true";
        $request->session()->put('asideMinimize', $asideMinimize);

        return response()->json([
            "estatus" => true,
            "asideMinimize" => $asideMinimize
        ]);
    }

    public function changePasswordFirstLogin(Request $request) {
        if ($request->isMethod('post')) {
            $request->validate([
                'password' => 'required|confirmed|min:8',
            ],
            [
                'password.confirmed' => 'Las contraseñas no coinciden',
                'password.min' => 'La contraseña debe contener al menos 8 caracteres',
            ]);
            $user = Auth::user();
            $user->password = Hash::make($request->password);
            $user->change_password = true;
            if ($user->save()) {
                return redirect()->route('tareas')->with("mensaje", "¡Bienvenido al sistema PROCDGA! Tu contraseña ha sido actualizada correctamente");
            }
        }
        return view('auth.passwords.reset_first_login');
    }
    
	public function tareas() {
		return view('general.tareas');
	}

    public function notificaciones() {
		return view('general.notificaciones');
  	}

    public function procesoEnCurso() {
		return view('general.proceso_en_curso');
	}

    public function getTareas(Request $request, $tipoInstanciaTarea, $tipoRespuesta) {
        // Roles de usuario por ámbito
        $roles = Auth::user()->roles->groupBy("tipo")
        ->map(function ($type) {
            return $type->pluck('id')->toArray();
        });

        // Estatus 
        $estatus = $tipoInstanciaTarea == "TAREA" ? ["NUEVO", "EN_CORRECCION"] : ["NOTIFICACION_NO_LEIDO", "NOTIFICACION_LEIDO"];
        $respuestaSonRegistros = $tipoRespuesta == "REGISTROS";

        $tareas = InstanciaTarea::whereHas('tarea', function (Builder $query) use ($tipoInstanciaTarea) {
                $query->where("tipo", $tipoInstanciaTarea);
            })
            ->whereIn("estatus", $estatus)
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
            })->where(function ($query) use ($request) {
                if (!is_null($request->searchText)) {
                    $query->whereHas("instancia.proceso", function ($query) use ($request) {
                            $query->where(DB::raw('upper("nombre")'), "LIKE", "%" . mb_strtoupper((string) $request->searchText) . "%");
                        })->orWhereHas("instancia.model", function ($query) use ($request) {
                            $query->where(DB::raw('upper("folio")'), "LIKE", "%" . mb_strtoupper((string) $request->searchText) . "%");
                        })->orWhereHas("tarea", function ($query) use ($request) {
                            $query->where(DB::raw('upper("nombre")'), "LIKE", "%" . mb_strtoupper((string) $request->searchText) . "%");
                        })->orWhereHas("creadoPorArea", function ($query) use ($request) {
                            $query->where(DB::raw("upper(concat_ws(' ', identificador, nombre))"), "LIKE", '%' . mb_strtoupper((string) $request->searchText) . '%');
                        });
                }
            })
            ->with("instancia.model", "instancia.proceso", "asignadoAlRol", "creadoPorUsuario", "creadoPorArea", "tarea")
            ->when($respuestaSonRegistros, function ($query) use ($request) {
                return $query->orderBy("created_at", "desc")->paginate($request->pageSize);
            }, function ($query) {
                $count = $query->count();
                return response()->json(['total' => $count]);
            });

        return $tareas;
    }

    public function getProcesosEnCurso(Request $request) {
        $roles = Auth::user()->roles->groupBy("tipo")
            ->map(function ($type) {
                return $type->pluck('id')->toArray();
            });
        $procesosEnCurso = InstanciaTarea::whereHas('tarea', function (Builder $query) {
            $query->where("tipo", "TAREA");
        })
        ->where([
            "es_primer_tarea" => true, 
        ])
        ->whereHas("tarea.proceso", function ($query) {
            $query->where("tipo", "PROCESO");
        })
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
        })->where(function ($query) use ($request) {
            if (!is_null($request->searchText)) {
                $query->whereHas("instancia.proceso", function ($query) use ($request) {
                        $query->where(DB::raw('upper("nombre")'), "LIKE", "%" . mb_strtoupper((string) $request->searchText) . "%");
                    })->orWhereHas("instancia.model", function ($query) use ($request) {
                        $query->where(DB::raw('upper("folio")'), "LIKE", "%" . mb_strtoupper((string) $request->searchText) . "%");
                    })->orWhereHas("tarea", function ($query) use ($request) {
                        $query->where(DB::raw('upper("nombre")'), "LIKE", "%" . mb_strtoupper((string) $request->searchText) . "%");
                    })->orWhereHas("creadoPorArea", function ($query) use ($request) {
                        $query->where(DB::raw("upper(concat_ws(' ', identificador, nombre))"), "LIKE", '%' . mb_strtoupper((string) $request->searchText) . '%');
                    });
            }
        })
        ->with("instancia.model", "instancia.proceso", "asignadoAlRol", "creadoPorUsuario", "creadoPorArea", "tarea")
        ->orderBy("created_at", "desc")
        ->paginate($request->pageSize);

        return $procesosEnCurso;
    }

    public function procesoEnCursoAvance(Instancia $instancia) {
        $tareasLlevadasACabo = $instancia
            ->instanciasTareas()
            ->whereHas('tarea', function (Builder $query) {
                $query->where('tipo', 'TAREA');
            })
            ->with("tarea", "asignadoAlRol", "creadoPorUsuario", "creadoPorArea", "autorizadoPorUsuario", "autorizadoPorArea")
            ->orderBy("instancia_tarea_id")
            ->get();
        return $tareasLlevadasACabo;
    }

    public function procesos() {
        $procesos = Proceso::activo()->where([
            "tipo" => "PROCESO"
        ])->where(function ($query) {
            if (!Auth::user()->hasRole("SUPER_ADMIN")) {
                $query->whereHas("roles", function($query) {
                    $query->where("proceso_role.inicializa_proceso", true)
                        ->whereIn("proceso_role.role_id", Auth::user()->roles->pluck("id"));
                });
            }
        })
        ->orderBy("numero_proceso")
        ->get();

        $servicios = [];
        try {
            $servicios = ServicioGeneral::where('activo', true)->get();
        } catch(Exception $e) {

        }

		return view('general.procesos', compact('procesos', 'servicios'));
	}

    public function reportes() {
        $reportesPorProceso = Reporte::where('reportes.activo', true)->whereHas('roles', function (Builder $query) {
            if (!Auth::user()->hasRole("SUPER_ADMIN")) {
                $query->whereIn("reporte_role.role_id", Auth::user()->roles->pluck("id"));
            }
        })
        ->whereHas('proceso', function (Builder $query) {
            $query->where('activo', true); 
        })
        ->orderBy("reporte_id")
        ->get()
        ->groupBy("proceso.numero_proceso");

        return view('general.reportes', compact('reportesPorProceso'));
    }

    public function catalogos() {
        $catalogosPorProceso = Catalogo::activo()->whereHas('roles', function (Builder $query) {
            if (!Auth::user()->hasRole("SUPER_ADMIN")) {
                $query->whereIn("catalogo_role.role_id", Auth::user()->roles->pluck("id"));
            }
        })
        ->whereHas('proceso', function (Builder $query) {
            $query->where('activo', true); 
        })
        ->get()
        ->sortBy("proceso.numero_proceso")
        ->groupBy("proceso.numero_proceso");

        return view('general.catalogos', compact('catalogosPorProceso'));
    }

    public function archivosExternos() {
        return view('general.archivos_externos');
    }

    public function manuales() {
        $manuales = Manual::activo()->whereHas('proceso', function (Builder $query) {
            $query->where('activo', true); 
        })->get();
		return view('general.manuales', compact('manuales'));
	}
    
    public function lineamientos() {
        $lineamientos = Lineamiento::activo()->get();
		return view('general.lineamientos', compact('lineamientos'));
	}
}
