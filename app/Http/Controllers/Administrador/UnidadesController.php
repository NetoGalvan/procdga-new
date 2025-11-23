<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Dependencia;
use App\Models\UnidadAdministrativa;
use Illuminate\Http\Request;

class UnidadesController extends Controller
{
    public function index()
    {
        $unidades = UnidadAdministrativa::activo()
            ->whereHas("dependencia", function ($query) {
                $query->where('identificador', 'secretaria_finanzas');
            })
            ->orderBy("identificador")
            ->get();
        return view("administrador.unidades.index", compact('unidades'));
    }

    public function create()
    {
        $dependencia = Dependencia::where('activo', true)->where('identificador', 'secretaria_finanzas')->first();
        return view("administrador.unidades.create", compact('dependencia'));
    }

    public function store(Request $request)
    {
        if (UnidadAdministrativa::where("identificador", $request->identificador)->exists()) {
            return redirect()->back()
                ->withInput()
                ->with("error", "Ya existe una unidad administrativa con ese identificador");
        }
        $unidad = UnidadAdministrativa::create([
            "nombre" => $request->nombre,
            "identificador" => $request->identificador,
            "dependencia_id" => $request->dependencia_id,
        ]);

        $area = Area::create([
            "unidad_administrativa_id" => $unidad->unidad_administrativa_id,
            "area_principal_id" => null,
            "nombre" => $request->nombre,
            "identificador" => $request->identificador,
            "tipo" => "AREA_PRINCIPAL"
        ]);

        return redirect()
            ->route("unidades.edit", $unidad)
            ->with("mensaje", "¡La Unidad Administrativa fue creada correctamente!");
    }

    public function edit(UnidadAdministrativa $unidad)
    {
        $dependencia = Dependencia::where('activo', true)->where('identificador', 'secretaria_finanzas')->first();
        return view("administrador.unidades.edit", compact("dependencia", "unidad"));
    }

    public function update(Request $request, UnidadAdministrativa $unidad)
    {            
        $unidad->update($request->all());
        $unidad->areas()->where("identificador", $unidad->identificador)->update([
            'nombre' => $request->nombre
        ]);
        return redirect()
            ->route('unidades.edit', $unidad)
            ->with('mensaje', '¡La Unidad Administrativa se actualizó correctamente!');

    }
}
