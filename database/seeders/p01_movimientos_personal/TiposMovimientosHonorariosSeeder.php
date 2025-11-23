<?php

namespace Database\Seeders\p01_movimientos_personal;

use App\Models\p01_movimientos_personal\TipoMovimientoHonorarios;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TiposMovimientosHonorariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoMovimientoHonorarios::create([
            'codigo' => '101',
            'contrato' => 'A', 
            'descripcion' => 'ALTA DE NUEVO INGRESO',
            'tipo' => 'ALTAS',
            'identificador' => '101'
        ]);
        TipoMovimientoHonorarios::create([
            'codigo' => '201',
            'contrato' => 'Z', 
            'descripcion' => 'BAJA ANTICIPADA',
            'tipo' => 'BAJAS',
            'identificador' => '201'
        ]);
        TipoMovimientoHonorarios::create([
            'codigo' => '301',
            'contrato' => 'R1', 
            'descripcion' => 'RECONTRATACION',
            'tipo' => 'RECONTRATACIONES',
            'identificador' => '301'
        ]);
    }
}
