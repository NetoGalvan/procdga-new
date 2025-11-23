<?php

namespace Database\Seeders\p32_tramites_kardex;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TiposTramitesKardexSeeder extends Seeder
{
    public function run()
    {
        DB::table('p32_tipos_tramite_kardex')->insert(['nombre' => 'Hojas de servicio', 'clave' => 'hojas_de_servicio', 'activo' => true]);
        DB::table('p32_tipos_tramite_kardex')->insert(['nombre' => 'Comprobantes de servicio', 'clave' => 'comprobantes_de_servicio', 'activo' => true]);
        DB::table('p32_tipos_tramite_kardex')->insert(['nombre' => 'Hojas de evaluación', 'clave' => 'hojas_de_evaluacion', 'activo' => false]);
    }
}
