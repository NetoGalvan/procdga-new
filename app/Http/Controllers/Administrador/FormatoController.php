<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use App\Models\Formato;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FormatoController extends Controller
{
    public function index() {
        $sizeHeader = "140px";
        $pdf = PDF::loadView('layouts.pdf')->output();
        $pdf = base64_encode($pdf);
        $formato = Formato::where("identificador", "formato_principal")->first();
        return view('administrador.formatos.index', compact('pdf', 'formato'));
    }

    public function guardarAtributosFormato(Request $request) {
        $formato = Formato::where("identificador", "formato_principal")->first();

        if (!empty($request->formato_logo_primario)) {
            $rutaImagen = "images/logos/logo_" .  strtolower($request->tipo_imagen) . "_" . Carbon::now()->timestamp . ".png";
            $seGuardoImagen = Storage::disk('public')->put($rutaImagen, base64_decode(str_replace("data:image/png;base64,", "", $request->formato_logo_primario)));
            if ($seGuardoImagen) {
                if ($request->tipo_imagen == 'PRINCIPAL_HEADER') {
                    $formato->logo_principal = "storage/" . $rutaImagen;
                } else if ($request->tipo_imagen == 'SECUNDARIO_HEADER') {
                    $formato->logo_secundario = "storage/" . $rutaImagen;
                } else if ($request->tipo_imagen == 'FOOTER') {
                    $formato->logo_pie = "storage/" . $rutaImagen;
                } else {
                    return response()->json([ "estatus" => true, "mensaje" => "Error al guardar imagen, no existe la opción seleccionada"]);
                }
            }
        }
        $formato->texto_encabezado = $request->formato_header;
        $formato->texto_pie = $request->formato_footer;
        $formato->save();

        $pdf = PDF::loadView('layouts.pdf')->output();
        $pdf = base64_encode($pdf);

        return response()->json([
            "estatus" => true,
            "formato" => $formato,
            "formatoBase" => $pdf
        ]);
    }
}
