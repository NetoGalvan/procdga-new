<?php
namespace Database\Seeders\p08_solicita_servicios;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiciosGeneralesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('servicios_generales')->insert(['servicio_general_id' => 1, 'nombre_servicio_general' => 'Servicios y mantenimiento', 'clave' => 'mantenimiento']);
        DB::table('servicios_generales')->insert(['servicio_general_id' => 2, 'nombre_servicio_general' => 'Servicio de reproducción de formatos, guillotina y engargolado', 'clave' => 'reproduccion']);
        DB::table('servicios_generales')->insert(['servicio_general_id' => 3, 'nombre_servicio_general' => 'Servicio de transporte de bienes o personal', 'clave' => 'vehiculos']);
        DB::table('servicios_generales')->insert(['servicio_general_id' => 4, 'nombre_servicio_general' => 'Servicios telefónicos', 'clave' => 'telefonia']);
        DB::table('servicios_generales')->insert(['servicio_general_id' => 5, 'nombre_servicio_general' => 'Servicio de limpieza y estibas', 'clave' => 'limpieza_estibas']);
        /* DB::table('servicios_generales')->insert(['servicio_general_id' => 6, 'nombre_servicio_general' => 'Otros servicios', 'clave' => 'otros']); */
    }
}
