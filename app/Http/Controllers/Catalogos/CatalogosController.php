<?php

namespace App\Http\Controllers\Catalogos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CodigoPostal;

class CatalogosController extends Controller
{
    public function getDatosCodigoPostalV2(Request $request) {
        if (substr($request->cp, 0, 1) == 0) {
            $request->cp = substr($request->cp, 1);
        }

        $asentamientos = CodigoPostal::where("cp", $request->cp)
            ->orderBy("asentamiento")
            ->get();

        return response()->json([
            "status" => true,
            "asentamientos" => $asentamientos
        ]);
    }
}
