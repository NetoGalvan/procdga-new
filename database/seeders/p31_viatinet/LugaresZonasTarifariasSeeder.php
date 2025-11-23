<?php

namespace Database\Seeders\p31_viatinet;

use App\Models\Municipio;
use App\Models\p31_viatinet\TipoZonaTarifaria;
use App\Models\Pais;
use Illuminate\Database\Seeder;

class LugaresZonasTarifariasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $municipios = Municipio::all();

        foreach ($municipios as $municipio) {
            $indices = [1, 2, 3];
            $indice = array_rand($indices);
            $indiceRandom = $indices[$indice];

            $zonaTarifariaNacional = TipoZonaTarifaria::activo()->whereHas("tipoAmbito", function ($query) use ($indiceRandom) {
                $query->where("identificador", "nacional")
                    ->where("tipo_zona_tarifaria_id", $indiceRandom);
            })->first();

            $municipio->tiposZonasTarifarias()->save($zonaTarifariaNacional);
        }

        $paises = Pais::all();

        foreach ($paises as $pais) {
            $indices = [4, 5];
            $indice = array_rand($indices);
            $indiceRandom = $indices[$indice];

            $zonaTarifariaInternacional = TipoZonaTarifaria::activo()->whereHas("tipoAmbito", function ($query) use ($indiceRandom) {
                $query->where("identificador", "internacional")
                    ->where("tipo_zona_tarifaria_id", $indiceRandom);
            })->first();

            $pais->tiposZonasTarifarias()->save($zonaTarifariaInternacional);
        }
    }
}
