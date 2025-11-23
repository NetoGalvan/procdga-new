<?php

namespace App\Http\Controllers\p31_viatinet;

use App\Models\Documento;
use App\Models\Municipio;
use App\Models\Pais;
use App\Models\TipoDocumento;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

trait ManejadorTareas
{
    public function guardarTareaT01($solicitudViatico, $request) {
        $solicitudViatico->dias = $request->dias;
        $solicitudViatico->fecha_inicio =  $request->fecha_inicio;
        $solicitudViatico->fecha_final =  $request->fecha_final;
        $solicitudViatico->motivo_comision =  $request->motivo_comision;
        
        if ($request->tipo_ambito == "nacional") {
            $municipio = Municipio::where("municipio_id", $request->municipio_id)->first();
            $tipoZonaTarifaria = $municipio->tiposZonasTarifarias()->withPivot("lugar_zona_tarifaria_id")->first();
        } else if ($request->tipo_ambito == "internacional") {
            $pais = Pais::where("pais_id", $request->pais_id)->first();
            $tipoZonaTarifaria = $pais->tiposZonasTarifarias()->withPivot("lugar_zona_tarifaria_id")->first();
        }

        $solicitudViatico->lugar_zona_tarifaria_id = $tipoZonaTarifaria->pivot->lugar_zona_tarifaria_id;

        return $solicitudViatico->save();
    }
    
    public function guardarTareaT06($solicitudViatico, $request) {
            $tipoDocumento = TipoDocumento::where("identificador", "documento_autorizacion")->first();
            $nombreOriginalDocumento = $request->file("file")->getClientOriginalName();
            $nombreDocumento = createSlug(pathinfo($nombreOriginalDocumento, PATHINFO_FILENAME)) . ".pdf";
            $carpeta = "documentos/{$solicitudViatico->folio}";        
            $ruta = Storage::putFileAs($carpeta, $request->file("file"), $nombreDocumento);

            $documento = new Documento();
            $documento->nombre_original = $nombreOriginalDocumento;
            $documento->nombre = $nombreDocumento;
            $documento->disco = "local";
            $documento->ruta = $ruta;
            $documento->fecha_subida = Carbon::now();
            $documento->tipo_documento_id = $tipoDocumento->tipo_documento_id;
            $documento->model()->associate($solicitudViatico);
            $documento->save();

        return $solicitudViatico->save();
    }

 
}
