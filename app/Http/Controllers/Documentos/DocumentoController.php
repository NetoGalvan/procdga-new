<?php

namespace App\Http\Controllers\Documentos;

use App\Http\Controllers\Controller;
use App\Models\Documento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentoController extends Controller
{
    public function show(Documento $documento) {
        return response()->make(Storage::get($documento->ruta), 200, [
            "Content-Type" => "application/pdf",
        ]);
    }
    
    public function download(Documento $documento) {
        return Storage::download($documento->ruta);
    }
    
    public function destroy(Documento $documento) {
        $documento->delete();
        Storage::delete($documento->ruta);

        return response()->json([
            "estatus" => true,
            "documento_id" => $documento->documento_id
        ]);
    }
}
