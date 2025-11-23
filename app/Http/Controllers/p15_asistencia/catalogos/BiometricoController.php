<?php

namespace App\Http\Controllers\p15_asistencia\catalogos;

use App\Http\Controllers\Controller;
use App\Models\Catalogo;
use App\Models\p15_asistencia\Biometrico;
use App\Models\p15_asistencia\DiaFestivo;
use App\Models\p15_asistencia\DiaFestivoFecha;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\View;

class BiometricoController extends Controller
{
    public function __construct()
    {
        $catalogo = Catalogo::where("identificador", "catalogo_biometricos")->first();
        View::share("catalogo", $catalogo);
    }

    public function index()
    {
        $biometricos = Biometrico::activo()->orderBy("nombre")->get();
        return view('p15_asistencia.catalogos.biometricos.index', compact("biometricos"));
    }

    public function create()
    {
        return view('p15_asistencia.catalogos.biometricos.create');
    }

    public function store(Request $request)
    {
        $biometrico = Biometrico::create($request->all());
        return redirect()->route("asistencia.catalogo.biometricos.edit", $biometrico)
            ->with("success", "Se guardó correctamente el registro");
    }
    
    public function edit(Biometrico $biometrico)
    {
        return view('p15_asistencia.catalogos.biometricos.edit', compact("biometrico"));
    }

    public function update(Request $request, Biometrico $biometrico)
    {  
        $biometrico->update($request->all());
        return redirect()->back()->with("success", "Se guardó correctamente el registro");
    }

    
}
