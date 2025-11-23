<?php

namespace Database\Seeders;

use App\Models\Dependencia;
use Illuminate\Database\Seeder;

class DependenciasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Dependencia::create([
            'nombre' => 'Secretaría de Finanzas',
            'identificador' => "secretaria_finanzas"
        ]);
    }
}
