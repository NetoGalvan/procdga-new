<?php

namespace Database\Seeders\p07_pago_prestaciones;

use Illuminate\Database\Seeder;
use Database\Seeders\p07_pago_prestaciones\ProcesoPagoPrestacionesSeeder;
use Database\Seeders\p07_pago_prestaciones\SubProcesoPagoPrestacionesSeeder;
use Database\Seeders\p07_pago_prestaciones\TareasProcesoPagoPrestacionesSeeder;
use Database\Seeders\p07_pago_prestaciones\TiposDePrestacionesSeeder;
use Database\Seeders\p07_pago_prestaciones\CatalogoPagoPrestaciones;
use Database\Seeders\p07_pago_prestaciones\UsersP07Seeder;

class DatabaseSeederP07 extends Seeder
{
    public function run()
    {
        $this->call(ProcesoPagoPrestacionesSeeder::class);
        $this->call(TareasProcesoPagoPrestacionesSeeder::class);
        $this->call(TiposDePrestacionesSeeder::class);
        $this->call(CatalogoPagoPrestaciones::class);
    }
}
