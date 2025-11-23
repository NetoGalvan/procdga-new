<?php

namespace Database\Seeders\p08_solicita_servicios;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiciosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('servicios')->insert(['nombre_servicio' =>'Plomería', 'servicio_general_id' => 1]);
        DB::table('servicios')->insert(['nombre_servicio' =>'Carpintería', 'servicio_general_id' => 1]);
        DB::table('servicios')->insert(['nombre_servicio' =>'Herrería', 'servicio_general_id' => 1]);
        DB::table('servicios')->insert(['nombre_servicio' =>'Cerrajería', 'servicio_general_id' => 1]);
        DB::table('servicios')->insert(['nombre_servicio' =>'Impermeabilización', 'servicio_general_id' => 1]);
        DB::table('servicios')->insert(['nombre_servicio' =>'Albañilería', 'servicio_general_id' => 1]);
        DB::table('servicios')->insert(['nombre_servicio' =>'Pintura', 'servicio_general_id' => 1]);
        DB::table('servicios')->insert(['nombre_servicio' =>'Electricidad', 'servicio_general_id' => 1]);
        DB::table('servicios')->insert(['nombre_servicio' =>'Aluminio y Vidrio', 'servicio_general_id' => 1]);
        DB::table('servicios')->insert(['nombre_servicio' =>'Ebanistería', 'servicio_general_id' => 1]);
        DB::table('servicios')->insert(['nombre_servicio' =>'Remodelación', 'servicio_general_id' => 1]);
        DB::table('servicios')->insert(['nombre_servicio' =>'Tablaroca', 'servicio_general_id' => 1]);
        DB::table('servicios')->insert(['nombre_servicio' =>'Otros', 'servicio_general_id' => 1]);
        DB::table('servicios')->insert(['nombre_servicio' =>'NO HAY MATERIAL/PERSONA', 'servicio_general_id' =>1]);
        DB::table('servicios')->insert(['nombre_servicio' =>'Impresión', 'servicio_general_id' => 2]);
        DB::table('servicios')->insert(['nombre_servicio' =>'Fotocopiado', 'servicio_general_id' => 2]);
        DB::table('servicios')->insert(['nombre_servicio' =>'Encuadernado', 'servicio_general_id' => 2]);
        DB::table('servicios')->insert(['nombre_servicio' =>'Diseño', 'servicio_general_id' => 2]);
        DB::table('servicios')->insert(['nombre_servicio' =>'Corte en guillotina', 'servicio_general_id' => 2]);
        DB::table('servicios')->insert(['nombre_servicio' =>'Elaboración de separadores', 'servicio_general_id' => 2]);
        DB::table('servicios')->insert(['nombre_servicio' =>'Transporte de personas', 'servicio_general_id' => 3]);
        DB::table('servicios')->insert(['nombre_servicio' =>'Transporte de bienes', 'servicio_general_id' => 3]);
        DB::table('servicios')->insert(['nombre_servicio' =>'Reparaciones de vehículos', 'servicio_general_id' => 3]);
        DB::table('servicios')->insert(['nombre_servicio' =>'Refacciones', 'servicio_general_id' => 3]);
        DB::table('servicios')->insert(['nombre_servicio' =>'Nueva creación', 'servicio_general_id' => 4, 'clave' => 'telefonia_nueva_creacion']);
        DB::table('servicios')->insert(['nombre_servicio' =>'Reubicación', 'servicio_general_id' => 4, 'clave' => 'telefonia_reubicacion']);
        DB::table('servicios')->insert(['nombre_servicio' =>'Reparación de aparato', 'servicio_general_id' => 4, 'clave' => 'telefonia_reparacion']);
        DB::table('servicios')->insert(['nombre_servicio' =>'Verificación de cableado', 'servicio_general_id' => 4, 'clave' => 'telefonia_verificacion']);
        DB::table('servicios')->insert(['nombre_servicio' =>'Sin tono', 'servicio_general_id' => 4, 'clave' => 'telefonia_sin_tono']);
        DB::table('servicios')->insert(['nombre_servicio' =>'Limpieza de baños', 'servicio_general_id' => 5]);
        DB::table('servicios')->insert(['nombre_servicio' =>'Limpieza de oficinas', 'servicio_general_id' => 5]);
        DB::table('servicios')->insert(['nombre_servicio' =>'Limpieza de pasillos', 'servicio_general_id' => 5]);
        DB::table('servicios')->insert(['nombre_servicio' =>'Limpieza profunda (cualquier área)', 'servicio_general_id' => 5]);
        DB::table('servicios')->insert(['nombre_servicio' =>'Limpieza de plantas', 'servicio_general_id' => 5]);
        DB::table('servicios')->insert(['nombre_servicio' =>'Cargar y estibar mobiliario, cajas, paquetes, etc.', 'servicio_general_id' => 5]);
        /* Servicios Pendientes hasta saber quien los responde
        DB::table('servicios')->insert(['nombre_servicio' =>'Remodelación', 'servicio_general_id' => 6]);
        DB::table('servicios')->insert(['nombre_servicio' =>'Extinguidores', 'servicio_general_id' => 6]);
        DB::table('servicios')->insert(['nombre_servicio' =>'Aire acondicionado', 'servicio_general_id' => 6]);
        DB::table('servicios')->insert(['nombre_servicio' =>'Servicio de comedor', 'servicio_general_id' => 6]);
        DB::table('servicios')->insert(['nombre_servicio' =>'Fumigación', 'servicio_general_id' => 6]);
        DB::table('servicios')->insert(['nombre_servicio' =>'Hidrantes', 'servicio_general_id' => 6]);
        DB::table('servicios')->insert(['nombre_servicio' =>'Otros', 'servicio_general_id' =>6]);
        DB::table('servicios')->insert(['nombre_servicio' =>'NO HAY MATERIAL/PERSONA', 'servicio_general_id' =>6]); */
    }

}
