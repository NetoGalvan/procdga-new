<?php

namespace Database\Seeders\p07_pago_prestaciones;

use Illuminate\Database\Seeder;
use App\Models\Proceso;
use Illuminate\Support\Facades\DB;

class CatalogoPagoPrestaciones extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('catalogos')->insert([
            'proceso_id' => Proceso::where('identificador', 'pago_prestaciones')->first()->proceso_id,
            'nombre' => 'Recuperación de nóminas anteriores de prestaciones',
            'descripcion' => 'Recuperar archivos Excel generados con anterioridad',
            'created_at' => now(),
            'updated_at' => now(),
            'activo' => true,
            'ruta' => 'pago.prestacion.catalogo.recuperacion.nomina'
        ]);
    }
}
