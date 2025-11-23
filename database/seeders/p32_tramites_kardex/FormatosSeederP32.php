<?php

namespace Database\Seeders\p32_tramites_kardex;

use App\Models\Formato;
use Illuminate\Database\Seeder;

class FormatosSeederP32 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Formato::create([
            "identificador" => "formato_kardex_principal",
            "logo_principal" => "images/logos/logo.png",
            "logo_secundario" => "images/logos/logo_anual.png",
            "logo_pie" => "images/logos/logo_ciudad.jpg",
            "texto_encabezado" => "SECRETARÍA DE ADMINISTRACIÓN Y FINANZAS DIRECCIÓN
            GENERAL DE ADMINISTRACIÓN Y FINANZAS DIRECCIÓN DE
            ADMINISTRACIÓN DE CAPITAL HUMANO",
            "texto_pie" => "Viaducto Río de la Piedad #515, planta baja. Col. Granjas México, CP. 08400, Alcaldía Iztacalco Ciudad de México T. 5551342500",
            "activo" => true
        ]);
    }
}
