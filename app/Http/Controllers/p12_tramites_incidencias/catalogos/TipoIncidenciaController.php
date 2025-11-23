<?php

namespace App\Http\Controllers\p12_tramites_incidencias\catalogos;

use App\Http\Controllers\Controller;
use App\Models\p12_tramites_incidencias\TipoIncidencia;
use App\Models\p12_tramites_incidencias\tipoJustificacion;
use Illuminate\Http\Request;

class TipoIncidenciaController extends Controller
{
    public function index()
    {
        $tiposIncidencias = TipoIncidencia::with("tipoJustificacion")
            ->orderBy("tipo_justificacion_id")
            ->orderBy("activo", "DESC")
            ->orderBy("tipo_empleado")
            ->orderBy("sexo")
            ->get();
        return view('p12_tramites_incidencias.catalogos.tipos_incidencias.index', compact("tiposIncidencias"));
    }
    
    public function create()
    {
        $tipoModulo = "create";
        $tiposJustificaciones = tipoJustificacion::activo()->get();
        $intervalos = ["ENTRADA", "RETARDO_LEVE", "RETARDO_GRAVE", "SALIDA", "TODO_EL_DIA"];
        $tiposEmpleados = ["TODOS", "SINDICALIZADO", "NO_SINDICALIZADO"];
        $sexos = ["TODOS", "M", "F"];
        $tiposDias = ["NATURALES", "HABILES"];

        return view('p12_tramites_incidencias.catalogos.tipos_incidencias.create', compact(
            "tipoModulo",
            "tiposJustificaciones", 
            "intervalos",
            "tiposEmpleados",
            "sexos",
            "tiposDias"
        ));
    }
    
    public function store(Request $request)
    {
        $request->merge(["aplica_autoincidencia" => $request->has("aplica_autoincidencia")]);
        $tipoIncidencia = TipoIncidencia::create($request->all());
       
        return redirect()->route("tramite.incidencia.catalogo.tipos.incidencias.edit", $tipoIncidencia)->with("success", "Se creó correctamente.");
    }
    
    public function edit(Request $request, TipoIncidencia $tipoIncidencia)
    {
        $tipoModulo = "edit";
        $tiposJustificaciones = tipoJustificacion::activo()->get();
        $intervalos = ["ENTRADA", "RETARDO_LEVE", "RETARDO_GRAVE", "SALIDA", "TODO_EL_DIA"];
        $tiposEmpleados = ["TODOS", "SINDICALIZADO", "NO_SINDICALIZADO"];
        $sexos = ["TODOS", "M", "F"];
        $tiposDias = ["NATURALES", "HABILES"];

        return view('p12_tramites_incidencias.catalogos.tipos_incidencias.edit', compact(
            "tipoModulo",
            "tiposJustificaciones", 
            "tipoIncidencia", 
            "intervalos",
            "tiposEmpleados",
            "sexos",
            "tiposDias"
        ));
    }

    public function update(Request $request, TipoIncidencia $tipoIncidencia)
    {
        $request->merge(["aplica_autoincidencia" => $request->has("aplica_autoincidencia")]);
        $request->merge(["activo" => $request->has("activo")]);
        $tipoIncidencia->update($request->all());
       
        return redirect()->back()->with("success", "Se guardó correctamente.");
    }
}
