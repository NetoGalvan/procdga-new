<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class MigrateMultipleFolders extends Command
{
    protected $signature = 'migrate:multiple {type}';

    protected $description = 'Run migrations from multiple folders';

    public function handle()
    {
        $type = $this->argument("type");

        $folders = [
            'database/migrations',
            'database/migrations/p01_movimientos_personal',
            'database/migrations/p02_tramites_issste',
            'database/migrations/p06_servicio_social',
            'database/migrations/p07_pago_prestaciones',
            'database/migrations/p08_solicita_servicios',
            'database/migrations/p11_seleccion_candidatos',
            'database/migrations/p15_asistencia',
            'database/migrations/p12_tramites_incidencias',
            'database/migrations/p16_pago_tiempo_extraordinario_excedente',
            'database/migrations/p19_incentivos_empleado_mes',
            'database/migrations/p20_premio_puntualidad_asistencia',
            'database/migrations/p21_premio_administracion',
            'database/migrations/p22_reportes_dias_efectivamente_laborados',
            'database/migrations/p23_solicitud_expediente',
            'database/migrations/p31_viatinet',
            'database/migrations/p32_tramites_kardex',
        ];

        if ($type == "run") {
            foreach ($folders as $folder) {
                Artisan::call('migrate', ['--path' => $folder]);
                $this->info("Migration created successfully:" . $folder);
            }
        } else if ($type == "rollback") {
            foreach (array_reverse($folders) as $folder) {
                Artisan::call('migrate:rollback', ['--path' => $folder]);
                $this->info("migration rollback successfully:" . $folder);
            }
        }
    }
}
