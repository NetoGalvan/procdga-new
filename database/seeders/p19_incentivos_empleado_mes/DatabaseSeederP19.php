<?php

namespace Database\Seeders\p19_incentivos_empleado_mes;

use Illuminate\Database\Seeder;
use Database\Seeders\p19_incentivos_empleado_mes\ProcesoP19Seeder;
use Database\Seeders\p19_incentivos_empleado_mes\SubProcesoP19Seeder;
use Database\Seeders\p19_incentivos_empleado_mes\UsersP19Seeder;
use Database\Seeders\p19_incentivos_empleado_mes\TareasP19Seeder;
use Database\Seeders\p19_incentivos_empleado_mes\ReportesP19Seeder;
use Database\Seeders\p19_incentivos_empleado_mes\ManualesP19Seeder;

class DatabaseSeederP19 extends Seeder
{
    public function run()
    {
        $this->call(ProcesoP19Seeder::class);
        $this->call(TareasP19Seeder::class);
        $this->call(ReportesP19Seeder::class);
        $this->call(ManualesP19Seeder::class);
    }
}
