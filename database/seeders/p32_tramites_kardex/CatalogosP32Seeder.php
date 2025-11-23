<?php

namespace Database\Seeders\p32_tramites_kardex;

use App\Models\Catalogo;
use App\Models\Proceso;
use Illuminate\Database\Seeder;

class CatalogosP32Seeder extends Seeder
{
    public function run()
    {
        $catalogo = Catalogo::create([
            'nombre' => 'ACTUALIZAR INFORMACIÓN FORMATO',
            'identificador' => 'catalogo_formato_kardex_principal',
            'descripcion' => 'Editar el formato principal del proceso de kardex.',
            'proceso_id' => Proceso::where('identificador', 'tramites_kardex')->first()->proceso_id,
            'ruta' => 'tramite.kardex.catalogo.formato_principal'
        ]);
        $catalogo->attachRoles(["ADMIN_KARDEX"]);
    }
}
