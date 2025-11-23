<?php

namespace App\Http\Controllers\p15_asistencia\catalogos;

use App\Http\Controllers\Controller;
use App\Models\p15_asistencia\DiaFestivo;
use App\Models\p15_asistencia\DiaFestivoFecha;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DiaFestivoFechaController extends Controller
{
    public function index()
    {
        $diasFestivos = DiaFestivo::activo()->get();
        $fechas = DiaFestivoFecha::orderBy("fecha", "DESC")->get();
        return view('p15_asistencia.catalogos.dias_festivos.index', compact("diasFestivos", "fechas"));
    }

    public function store(Request $request)
    {
        if (DiaFestivoFecha::where("fecha", $request->fecha)->exists()) {
            return response()->json([
                "estatus" => false, 
                "mensaje" => "Esta fecha ya fue agregada anteriormente. Intente con otra"
            ]);
        }

        $diaFestivoFecha = DiaFestivoFecha::create($request->all());
       
        return response()->json([
            "estatus" => true, 
            "diaFestivoFecha" => DiaFestivoFecha::find($diaFestivoFecha->dia_festivo_fecha_id),
        ]);
    }
    
    public function update(Request $request)
    {
        if (DiaFestivoFecha::where("dia_festivo_fecha_id", "!=", $request->dia_festivo_fecha_id)
            ->where("fecha", $request->fecha)
            ->exists()) {
            return response()->json([
                "estatus" => false, 
                "mensaje" => "Esta fecha ya fue agregada anteriormente. Intente con otra"
            ]);
        }
        $diaFestivoFecha = DiaFestivoFecha::find($request->dia_festivo_fecha_id);
        $diaFestivoFecha->update($request->all());

        return response()->json([
            "estatus" => true, 
            "diaFestivoFecha" => DiaFestivoFecha::find($diaFestivoFecha->dia_festivo_fecha_id),
        ]);
    }
}
