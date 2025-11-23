<?php

namespace Database\Seeders\p11_seleccion_candidatos;

use Illuminate\Database\Seeder;

class DatabaseSeederP11 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ProcesoP11Seeder::class);
        $this->call(TareasP11Seeder::class);
    }
}
