<?php

namespace Database\Seeders\p31_viatinet;

use App\Models\Proceso;
use App\Models\TipoDocumento;
use Illuminate\Database\Seeder;

class TiposDocumentosP31Seeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        TipoDocumento::create([
            "nombre" => "Suficiencia presupuestal",
            "identificador" => "suficiencia_presupuestal",
            "proceso_id" => Proceso::where("identificador", "viatinet")->first()->proceso_id,
            "nombre_grupo" => "viatinet_solicitud"
        ]); 
        TipoDocumento::create([
            "nombre" => "Oficio de comisión",
            "identificador" => "oficio_comision",
            "proceso_id" => Proceso::where("identificador", "viatinet")->first()->proceso_id,
            "nombre_grupo" => "viatinet_solicitud"
        ]); 
        TipoDocumento::create([
            "nombre" => "Oficio de solicitud",
            "identificador" => "oficio_solicitud",
            "proceso_id" => Proceso::where("identificador", "viatinet")->first()->proceso_id,
            "nombre_grupo" => "viatinet_solicitud"
        ]); 
        TipoDocumento::create([
            "nombre" => "Documento de autorización",
            "identificador" => "documento_autorizacion",
            "proceso_id" => Proceso::where("identificador", "viatinet")->first()->proceso_id,
            "nombre_grupo" => "autorizacion"
        ]); 
    } 
}