<?php

namespace Database\Seeders\p06_servicio_social;

use Illuminate\Database\Seeder;
use App\Models\p06_servicio_social\P06AreasAdscripcion;

class CatAreasAdscripcionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        P06AreasAdscripcion::create([
            'nombre_area_adscripcion' => 'ADMINISTRACIÓN DE SERVIDORES Y REDES',
            'direccion_area_adscripcion' => 'DONEC CONDIMENTUM DOLOR ERAT, ET MOLESTIE LIBERO PHARETRA A.',
            'activo' => true,
            'created_at' => now(),
            'updated_at' => now() 
        ]);

        P06AreasAdscripcion::create([
            'nombre_area_adscripcion' => 'DEPARTAMENTO DE RECURSOS HUMANOS',
            'direccion_area_adscripcion' => 'SIT AMET LECTUS SAPIEN. DUIS MATTIS LIGULA NON LIGULA LUCTUS DAPIBUS.',
            'activo' => true,
            'created_at' => now(),
            'updated_at' => now() 
        ]);

        P06AreasAdscripcion::create([
            'nombre_area_adscripcion' => 'COORDINACIÓN DE NORMATIVIDAD',
            'direccion_area_adscripcion' => 'SUSPENDISSE VENENATIS, IPSUM EGET SUSCIPIT EGESTAS, ARCU LIGULA TINCIDUNT.',
            'activo' => true,
            'created_at' => now(),
            'updated_at' => now() 
        ]);

        P06AreasAdscripcion::create([
            'nombre_area_adscripcion' => 'COORDINACIÓN DE DESARROLLOS ADMINISTRATIVOS',
            'direccion_area_adscripcion' => 'QUISQUE NEC ALIQUAM LACUS. SED EGESTAS DIAM VULPUTATE TURPIS VULPUTATE.',
            'activo' => true,
            'created_at' => now(),
            'updated_at' => now() 
        ]);
    }
}
