<?php

namespace Database\Seeders;

use Database\Seeders\p01_movimientos_personal\DatabaseSeederP01;
use Database\Seeders\p02_tramites_issste\DatabaseSeederP02;
use Database\Seeders\p06_servicio_social\DatabaseSeederP06;
use Database\Seeders\p07_pago_prestaciones\DatabaseSeederP07;
use Database\Seeders\p08_solicita_servicios\DatabaseSeederP08;
use Database\Seeders\p11_seleccion_candidatos\DatabaseSeederP11;
use Database\Seeders\p12_tramites_incidencias\DatabaseSeederP12;
use Database\Seeders\p15_asistencia\DatabaseSeederP15;
use Database\Seeders\p16_pago_tiempo_extraordinario_excedente\DatabaseSeederP16;
use Database\Seeders\p19_incentivos_empleado_mes\DatabaseSeederP19;
use Database\Seeders\p20_premio_puntualidad_asistencia\DatabaseSeederP20;
use Database\Seeders\p21_premio_administracion\DatabaseSeederP21;
use Database\Seeders\p22_reportes_dias_efectivamente_laborados\DatabaseSeederP22;
use Database\Seeders\p23_solicitud_expediente\DatabaseSeederP23;
use Database\Seeders\p31_viatinet\DatabaseSeederP31;
use Database\Seeders\p32_tramites_kardex\DatabaseSeederP32;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // GENERALES
        $this->call(DatabaseGeneralSeeder::class);

        // Proceso 01 - Movimientos de personal
        $this->call(DatabaseSeederP01::class);

        // Proceso 02 - Trámites ISSSTE
        $this->call(DatabaseSeederP02::class);

        // Proceso 06 - Servicio Social
        $this->call(DatabaseSeederP06::class);

        // Proceso 07 - Pago Prestaciones
        $this->call(DatabaseSeederP07::class);

        // Proceso 08 - Solicita servicios
        $this->call(DatabaseSeederP08::class);

        // Proceso 11 - Selección de candidatos
        $this->call(DatabaseSeederP11::class);

        // Proceso 12_14 - Incidencias
        $this->call(DatabaseSeederP12::class);

        // Proceso 15 - Control de Asistencia
        $this->call(DatabaseSeederP15::class);

        // Proceso 16 - Pago de tiempo extraordinario y excedente
        $this->call(DatabaseSeederP16::class);

        // Proceso 19 - Incentivos empleado del mes
        $this->call(DatabaseSeederP19::class);

        // Proceso 20 - Premio de puntualidad y asistencia
        $this->call(DatabaseSeederP20::class);

        // Proceso 21 - Premio de administración
        $this->call(DatabaseSeederP21::class);

        // Proceso 22 - Reportes de días efectivamente laborados
        $this->call(DatabaseSeederP22::class);

        // Proceso 23 - Solicitud de expediente y Digitalización de archivo
        $this->call(DatabaseSeederP23::class);

        // Proceso 31 - Viatinet
        $this->call(DatabaseSeederP31::class);

        // Proceso 32 - Trámites Kardex
        $this->call(DatabaseSeederP32::class);
    }
}
