<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\UnidadAdministrativa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AreaController extends Controller
{
    public function index(UnidadAdministrativa $unidad)
    {
        $areas = $unidad->areas()
            ->orderByRaw('CAST(identificador AS DECIMAL(10, 4)) ASC')
            ->get();
        return view("administrador.unidades.areas.index", compact("unidad", "areas"));
    }

    public function create(UnidadAdministrativa $unidad)
    {
        $areasPrincipales = $unidad->areas()->where([
            "activo" => true, 
            "tipo" => "AREA_PRINCIPAL"
        ])
        ->orderByRaw('CAST(identificador AS DECIMAL(10, 4)) ASC')
        ->get();
        return view("administrador.unidades.areas.create", compact(
            "unidad",
            "areasPrincipales"
        ));
    }

    public function store(Request $request, UnidadAdministrativa $unidad)
    {
        if ($request->tipo_area == "AREA_PRINCIPAL") {
            $identificadorArea = "$unidad->identificador.$request->identificador";
        } else if ($request->tipo_area == "SUBAREA") {
            $areaPrincipal = Area::where("area_id", $request->area_id)->first();
            if (strpos($areaPrincipal->identificador, '.') !== false) {
                $identificadorArea = "$areaPrincipal->identificador$request->identificador";
            } else {
                $identificadorArea = "$areaPrincipal->identificador.0$request->identificador";
            }
        }

        // Se valida que no exista el Identificador del Área envíado
        if (Area::where("identificador", $identificadorArea)->exists()) {
            return redirect()
                ->back()
                ->with("error", "Ya existe un área con el identificador $identificadorArea, intente con otro.");
        }

        $area = Area::create([
            "unidad_administrativa_id" => $unidad->unidad_administrativa_id,
            "area_principal_id" => $areaPrincipal->area_id ?? null,
            "nombre" => $request->nombre,
            "identificador" => $identificadorArea,
            "tipo" => $request->tipo_area
        ]);

        return redirect()
            ->route('unidades.areas.edit', [$unidad, $area])
            ->with('mensaje', "El área se creó correctamente.");
    }

    public function edit(UnidadAdministrativa $unidad, Area $area)
    {
        $areasPrincipales = $area->unidadAdministrativa->areas()->where([
            "activo" => true, 
            "tipo" => "AREA_PRINCIPAL"
        ])
        ->orderByRaw('CAST(identificador AS DECIMAL(10, 4)) ASC')
        ->get();
        return view("administrador.unidades.areas.edit", compact("unidad", "area", "areasPrincipales"));
    }

    public function update(Request $request, UnidadAdministrativa $unidad, Area $area)
    {
        $request->merge(["activo" => $request->has("activo")]);
        if ($area->tipo == "AREA_PRINCIPAL") {
            Area::where("area_principal_id", $area->area_id)->update(["activo" => $request->activo]);
        }
        $area->update($request->all());
        return redirect()
             ->route('unidades.areas.edit', [$unidad, $area])
             ->with('mensaje', '¡El área se actualizó correctamente!');
    }

    protected function validator(array $data, $area = null)
    {
        $messages = [
            'identificador.unique' => 'El CN ya está registrado',
        ];

        $rulesGenerales =  [
            'nombre' => ['required', 'string', 'max:255'],
            'identificador' => ['required', 'string', 'max:30', Rule::unique('areas')->ignore($area)],
            'unidad_administrativa_id' =>  ['required', 'integer'],
        ];
    
        return Validator::make($data, $rulesGenerales, $messages);
    }

    public function getAreas(Request $request) {
        $areas = Area::activo()
            ->where(function ($query) use ($request) {
                $query->where(DB::raw('upper("nombre")'), "LIKE", "%" . mb_strtoupper((string) $request->searchText) . "%");
            })
            ->with("unidadAdministrativa")
            ->orderByRaw('identificador::FLOAT')
            ->paginate($request->pageSize);

        return $areas;        
    }
}
