<?php

namespace Database\Seeders\p15_asistencia;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class P15HorariosIntervalosTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('p15_horarios_intervalos')->delete();
        
        \DB::table('p15_horarios_intervalos')->insert(array (
            0 => 
            array (
                'horario_intervalo_id' => 1,
                'inicio' => '07:30:00',
                'final' => '08:10:00',
                'tipo' => 'ENTRADA',
                'horario_id' => 1,
                'created_at' => '2024-04-17 14:02:40',
                'updated_at' => '2024-04-17 14:02:40',
            ),
            1 => 
            array (
                'horario_intervalo_id' => 2,
                'inicio' => '08:11:00',
                'final' => '08:20:00',
                'tipo' => 'RETARDO_LEVE',
                'horario_id' => 1,
                'created_at' => '2024-04-17 14:02:40',
                'updated_at' => '2024-04-17 14:02:40',
            ),
            2 => 
            array (
                'horario_intervalo_id' => 3,
                'inicio' => '08:21:00',
                'final' => '08:30:00',
                'tipo' => 'RETARDO_GRAVE',
                'horario_id' => 1,
                'created_at' => '2024-04-17 14:02:40',
                'updated_at' => '2024-04-17 14:02:40',
            ),
            3 => 
            array (
                'horario_intervalo_id' => 4,
                'inicio' => '15:00:00',
                'final' => '15:30:00',
                'tipo' => 'SALIDA',
                'horario_id' => 1,
                'created_at' => '2024-04-17 14:02:40',
                'updated_at' => '2024-04-17 14:02:40',
            ),
            4 => 
            array (
                'horario_intervalo_id' => 5,
                'inicio' => '07:30:00',
                'final' => '08:30:00',
                'tipo' => 'ENTRADA',
                'horario_id' => 2,
                'created_at' => '2024-04-17 14:02:40',
                'updated_at' => '2024-04-17 14:02:40',
            ),
            5 => 
            array (
                'horario_intervalo_id' => 6,
                'inicio' => '15:00:00',
                'final' => '15:30:00',
                'tipo' => 'SALIDA',
                'horario_id' => 2,
                'created_at' => '2024-04-17 14:02:40',
                'updated_at' => '2024-04-17 14:02:40',
            ),
            6 => 
            array (
                'horario_intervalo_id' => 7,
                'inicio' => '08:30:00',
                'final' => '09:30:00',
                'tipo' => 'ENTRADA',
                'horario_id' => 3,
                'created_at' => '2024-04-17 14:02:40',
                'updated_at' => '2024-04-17 14:02:40',
            ),
            7 => 
            array (
                'horario_intervalo_id' => 8,
                'inicio' => '19:00:00',
                'final' => '19:30:00',
                'tipo' => 'SALIDA',
                'horario_id' => 3,
                'created_at' => '2024-04-17 14:02:40',
                'updated_at' => '2024-04-17 14:02:40',
            ),
            8 => 
            array (
                'horario_intervalo_id' => 9,
                'inicio' => '08:30:00',
                'final' => '09:30:00',
                'tipo' => 'ENTRADA',
                'horario_id' => 4,
                'created_at' => '2024-04-17 14:02:40',
                'updated_at' => '2024-04-17 14:02:40',
            ),
            9 => 
            array (
                'horario_intervalo_id' => 10,
                'inicio' => '19:00:00',
                'final' => '19:30:00',
                'tipo' => 'SALIDA',
                'horario_id' => 4,
                'created_at' => '2024-04-17 14:02:40',
                'updated_at' => '2024-04-17 14:02:40',
            ),
            10 => 
            array (
                'horario_intervalo_id' => 11,
                'inicio' => '01:30:00',
                'final' => '02:10:00',
                'tipo' => 'ENTRADA',
                'horario_id' => 5,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            11 => 
            array (
                'horario_intervalo_id' => 12,
                'inicio' => '02:10:00',
                'final' => '02:20:00',
                'tipo' => 'RETARDO_LEVE',
                'horario_id' => 5,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            12 => 
            array (
                'horario_intervalo_id' => 13,
                'inicio' => '02:20:00',
                'final' => '02:30:00',
                'tipo' => 'RETARDO_GRAVE',
                'horario_id' => 5,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            13 => 
            array (
                'horario_intervalo_id' => 14,
                'inicio' => '08:00:00',
                'final' => '08:30:00',
                'tipo' => 'SALIDA',
                'horario_id' => 5,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            14 => 
            array (
                'horario_intervalo_id' => 15,
                'inicio' => '02:30:00',
                'final' => '03:10:00',
                'tipo' => 'ENTRADA',
                'horario_id' => 6,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            15 => 
            array (
                'horario_intervalo_id' => 16,
                'inicio' => '03:10:00',
                'final' => '03:20:00',
                'tipo' => 'RETARDO_LEVE',
                'horario_id' => 6,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            16 => 
            array (
                'horario_intervalo_id' => 17,
                'inicio' => '03:20:00',
                'final' => '03:30:00',
                'tipo' => 'RETARDO_GRAVE',
                'horario_id' => 6,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            17 => 
            array (
                'horario_intervalo_id' => 18,
                'inicio' => '09:00:00',
                'final' => '09:30:00',
                'tipo' => 'SALIDA',
                'horario_id' => 6,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            18 => 
            array (
                'horario_intervalo_id' => 19,
                'inicio' => '02:30:00',
                'final' => '03:10:00',
                'tipo' => 'ENTRADA',
                'horario_id' => 7,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            19 => 
            array (
                'horario_intervalo_id' => 20,
                'inicio' => '03:10:00',
                'final' => '03:20:00',
                'tipo' => 'RETARDO_LEVE',
                'horario_id' => 7,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            20 => 
            array (
                'horario_intervalo_id' => 21,
                'inicio' => '03:20:00',
                'final' => '03:30:00',
                'tipo' => 'RETARDO_GRAVE',
                'horario_id' => 7,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            21 => 
            array (
                'horario_intervalo_id' => 22,
                'inicio' => '15:00:00',
                'final' => '15:30:00',
                'tipo' => 'SALIDA',
                'horario_id' => 7,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            22 => 
            array (
                'horario_intervalo_id' => 23,
                'inicio' => '04:00:00',
                'final' => '04:10:00',
                'tipo' => 'ENTRADA',
                'horario_id' => 8,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            23 => 
            array (
                'horario_intervalo_id' => 24,
                'inicio' => '04:10:00',
                'final' => '04:20:00',
                'tipo' => 'RETARDO_LEVE',
                'horario_id' => 8,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            24 => 
            array (
                'horario_intervalo_id' => 25,
                'inicio' => '04:20:00',
                'final' => '04:30:00',
                'tipo' => 'RETARDO_GRAVE',
                'horario_id' => 8,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            25 => 
            array (
                'horario_intervalo_id' => 26,
                'inicio' => '16:00:00',
                'final' => '16:30:00',
                'tipo' => 'SALIDA',
                'horario_id' => 8,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            26 => 
            array (
                'horario_intervalo_id' => 27,
                'inicio' => '04:30:00',
                'final' => '05:10:00',
                'tipo' => 'ENTRADA',
                'horario_id' => 9,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            27 => 
            array (
                'horario_intervalo_id' => 28,
                'inicio' => '05:10:00',
                'final' => '05:20:00',
                'tipo' => 'RETARDO_LEVE',
                'horario_id' => 9,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            28 => 
            array (
                'horario_intervalo_id' => 29,
                'inicio' => '05:20:00',
                'final' => '05:30:00',
                'tipo' => 'RETARDO_GRAVE',
                'horario_id' => 9,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            29 => 
            array (
                'horario_intervalo_id' => 30,
                'inicio' => '17:00:00',
                'final' => '17:30:00',
                'tipo' => 'SALIDA',
                'horario_id' => 9,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            30 => 
            array (
                'horario_intervalo_id' => 31,
                'inicio' => '05:30:00',
                'final' => '06:10:00',
                'tipo' => 'ENTRADA',
                'horario_id' => 10,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            31 => 
            array (
                'horario_intervalo_id' => 32,
                'inicio' => '06:10:00',
                'final' => '06:20:00',
                'tipo' => 'RETARDO_LEVE',
                'horario_id' => 10,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            32 => 
            array (
                'horario_intervalo_id' => 33,
                'inicio' => '06:20:00',
                'final' => '06:30:00',
                'tipo' => 'RETARDO_GRAVE',
                'horario_id' => 10,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            33 => 
            array (
                'horario_intervalo_id' => 34,
                'inicio' => '13:00:00',
                'final' => '13:30:00',
                'tipo' => 'SALIDA',
                'horario_id' => 10,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            34 => 
            array (
                'horario_intervalo_id' => 35,
                'inicio' => '05:30:00',
                'final' => '06:10:00',
                'tipo' => 'ENTRADA',
                'horario_id' => 11,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            35 => 
            array (
                'horario_intervalo_id' => 36,
                'inicio' => '06:10:00',
                'final' => '06:20:00',
                'tipo' => 'RETARDO_LEVE',
                'horario_id' => 11,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            36 => 
            array (
                'horario_intervalo_id' => 37,
                'inicio' => '06:20:00',
                'final' => '06:30:00',
                'tipo' => 'RETARDO_GRAVE',
                'horario_id' => 11,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            37 => 
            array (
                'horario_intervalo_id' => 38,
                'inicio' => '12:00:00',
                'final' => '12:30:00',
                'tipo' => 'SALIDA',
                'horario_id' => 11,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            38 => 
            array (
                'horario_intervalo_id' => 39,
                'inicio' => '05:30:00',
                'final' => '06:30:00',
                'tipo' => 'ENTRADA',
                'horario_id' => 12,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            39 => 
            array (
                'horario_intervalo_id' => 40,
                'inicio' => '00:00:00',
                'final' => '00:00:00',
                'tipo' => 'RETARDO_LEVE',
                'horario_id' => 12,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            40 => 
            array (
                'horario_intervalo_id' => 41,
                'inicio' => '00:00:00',
                'final' => '00:00:00',
                'tipo' => 'RETARDO_GRAVE',
                'horario_id' => 12,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            41 => 
            array (
                'horario_intervalo_id' => 42,
                'inicio' => '13:00:00',
                'final' => '13:30:00',
                'tipo' => 'SALIDA',
                'horario_id' => 12,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            42 => 
            array (
                'horario_intervalo_id' => 43,
                'inicio' => '06:30:00',
                'final' => '07:10:00',
                'tipo' => 'ENTRADA',
                'horario_id' => 13,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            43 => 
            array (
                'horario_intervalo_id' => 44,
                'inicio' => '07:10:00',
                'final' => '07:20:00',
                'tipo' => 'RETARDO_LEVE',
                'horario_id' => 13,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            44 => 
            array (
                'horario_intervalo_id' => 45,
                'inicio' => '07:20:00',
                'final' => '07:30:00',
                'tipo' => 'RETARDO_GRAVE',
                'horario_id' => 13,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            45 => 
            array (
                'horario_intervalo_id' => 46,
                'inicio' => '14:00:00',
                'final' => '14:30:00',
                'tipo' => 'SALIDA',
                'horario_id' => 13,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            46 => 
            array (
                'horario_intervalo_id' => 47,
                'inicio' => '06:30:00',
                'final' => '07:10:00',
                'tipo' => 'ENTRADA',
                'horario_id' => 14,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            47 => 
            array (
                'horario_intervalo_id' => 48,
                'inicio' => '07:10:00',
                'final' => '07:20:00',
                'tipo' => 'RETARDO_LEVE',
                'horario_id' => 14,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            48 => 
            array (
                'horario_intervalo_id' => 49,
                'inicio' => '07:20:00',
                'final' => '07:30:00',
                'tipo' => 'RETARDO_GRAVE',
                'horario_id' => 14,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            49 => 
            array (
                'horario_intervalo_id' => 50,
                'inicio' => '13:00:00',
                'final' => '13:30:00',
                'tipo' => 'SALIDA',
                'horario_id' => 14,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            50 => 
            array (
                'horario_intervalo_id' => 51,
                'inicio' => '06:30:00',
                'final' => '07:30:00',
                'tipo' => 'ENTRADA',
                'horario_id' => 15,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            51 => 
            array (
                'horario_intervalo_id' => 52,
                'inicio' => '00:00:00',
                'final' => '00:00:00',
                'tipo' => 'RETARDO_LEVE',
                'horario_id' => 15,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            52 => 
            array (
                'horario_intervalo_id' => 53,
                'inicio' => '00:00:00',
                'final' => '00:00:00',
                'tipo' => 'RETARDO_GRAVE',
                'horario_id' => 15,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            53 => 
            array (
                'horario_intervalo_id' => 54,
                'inicio' => '14:00:00',
                'final' => '14:30:00',
                'tipo' => 'SALIDA',
                'horario_id' => 15,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            54 => 
            array (
                'horario_intervalo_id' => 55,
                'inicio' => '06:30:00',
                'final' => '07:10:00',
                'tipo' => 'ENTRADA',
                'horario_id' => 16,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            55 => 
            array (
                'horario_intervalo_id' => 56,
                'inicio' => '07:10:00',
                'final' => '07:20:00',
                'tipo' => 'RETARDO_LEVE',
                'horario_id' => 16,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            56 => 
            array (
                'horario_intervalo_id' => 57,
                'inicio' => '07:20:00',
                'final' => '07:30:00',
                'tipo' => 'RETARDO_GRAVE',
                'horario_id' => 16,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            57 => 
            array (
                'horario_intervalo_id' => 58,
                'inicio' => '19:00:00',
                'final' => '19:30:00',
                'tipo' => 'SALIDA',
                'horario_id' => 16,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            58 => 
            array (
                'horario_intervalo_id' => 59,
                'inicio' => '06:30:00',
                'final' => '07:30:00',
                'tipo' => 'ENTRADA',
                'horario_id' => 17,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            59 => 
            array (
                'horario_intervalo_id' => 60,
                'inicio' => '00:00:00',
                'final' => '00:00:00',
                'tipo' => 'RETARDO_LEVE',
                'horario_id' => 17,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            60 => 
            array (
                'horario_intervalo_id' => 61,
                'inicio' => '00:00:00',
                'final' => '00:00:00',
                'tipo' => 'RETARDO_GRAVE',
                'horario_id' => 17,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            61 => 
            array (
                'horario_intervalo_id' => 62,
                'inicio' => '15:00:00',
                'final' => '15:30:00',
                'tipo' => 'SALIDA',
                'horario_id' => 17,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            62 => 
            array (
                'horario_intervalo_id' => 63,
                'inicio' => '07:30:00',
                'final' => '08:10:00',
                'tipo' => 'ENTRADA',
                'horario_id' => 18,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            63 => 
            array (
                'horario_intervalo_id' => 64,
                'inicio' => '00:00:00',
                'final' => '00:00:00',
                'tipo' => 'RETARDO_LEVE',
                'horario_id' => 18,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            64 => 
            array (
                'horario_intervalo_id' => 65,
                'inicio' => '00:00:00',
                'final' => '00:00:00',
                'tipo' => 'RETARDO_GRAVE',
                'horario_id' => 18,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            65 => 
            array (
                'horario_intervalo_id' => 66,
                'inicio' => '20:00:00',
                'final' => '20:30:00',
                'tipo' => 'SALIDA',
                'horario_id' => 18,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            66 => 
            array (
                'horario_intervalo_id' => 67,
                'inicio' => '07:30:00',
                'final' => '08:10:00',
                'tipo' => 'ENTRADA',
                'horario_id' => 19,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            67 => 
            array (
                'horario_intervalo_id' => 68,
                'inicio' => '08:10:00',
                'final' => '08:20:00',
                'tipo' => 'RETARDO_LEVE',
                'horario_id' => 19,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            68 => 
            array (
                'horario_intervalo_id' => 69,
                'inicio' => '08:20:00',
                'final' => '08:30:00',
                'tipo' => 'RETARDO_GRAVE',
                'horario_id' => 19,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            69 => 
            array (
                'horario_intervalo_id' => 70,
                'inicio' => '14:00:00',
                'final' => '14:30:00',
                'tipo' => 'SALIDA',
                'horario_id' => 19,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            70 => 
            array (
                'horario_intervalo_id' => 71,
                'inicio' => '07:30:00',
                'final' => '08:30:00',
                'tipo' => 'ENTRADA',
                'horario_id' => 20,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            71 => 
            array (
                'horario_intervalo_id' => 72,
                'inicio' => '00:00:00',
                'final' => '00:00:00',
                'tipo' => 'RETARDO_LEVE',
                'horario_id' => 20,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            72 => 
            array (
                'horario_intervalo_id' => 73,
                'inicio' => '00:00:00',
                'final' => '00:00:00',
                'tipo' => 'RETARDO_GRAVE',
                'horario_id' => 20,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            73 => 
            array (
                'horario_intervalo_id' => 74,
                'inicio' => '15:00:00',
                'final' => '15:30:00',
                'tipo' => 'SALIDA',
                'horario_id' => 20,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            74 => 
            array (
                'horario_intervalo_id' => 75,
                'inicio' => '07:30:00',
                'final' => '08:10:00',
                'tipo' => 'ENTRADA',
                'horario_id' => 21,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            75 => 
            array (
                'horario_intervalo_id' => 76,
                'inicio' => '08:10:00',
                'final' => '08:20:00',
                'tipo' => 'RETARDO_LEVE',
                'horario_id' => 21,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            76 => 
            array (
                'horario_intervalo_id' => 77,
                'inicio' => '08:20:00',
                'final' => '08:30:00',
                'tipo' => 'RETARDO_GRAVE',
                'horario_id' => 21,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            77 => 
            array (
                'horario_intervalo_id' => 78,
                'inicio' => '15:00:00',
                'final' => '15:30:00',
                'tipo' => 'SALIDA',
                'horario_id' => 21,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            78 => 
            array (
                'horario_intervalo_id' => 79,
                'inicio' => '07:30:00',
                'final' => '08:10:00',
                'tipo' => 'ENTRADA',
                'horario_id' => 22,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            79 => 
            array (
                'horario_intervalo_id' => 80,
                'inicio' => '08:10:00',
                'final' => '08:20:00',
                'tipo' => 'RETARDO_LEVE',
                'horario_id' => 22,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            80 => 
            array (
                'horario_intervalo_id' => 81,
                'inicio' => '08:20:00',
                'final' => '08:30:00',
                'tipo' => 'RETARDO_GRAVE',
                'horario_id' => 22,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            81 => 
            array (
                'horario_intervalo_id' => 82,
                'inicio' => '11:30:00',
                'final' => '12:00:00',
                'tipo' => 'SALIDA',
                'horario_id' => 22,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            82 => 
            array (
                'horario_intervalo_id' => 83,
                'inicio' => '07:30:00',
                'final' => '08:30:00',
                'tipo' => 'ENTRADA',
                'horario_id' => 23,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            83 => 
            array (
                'horario_intervalo_id' => 84,
                'inicio' => '00:00:00',
                'final' => '00:00:00',
                'tipo' => 'RETARDO_LEVE',
                'horario_id' => 23,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            84 => 
            array (
                'horario_intervalo_id' => 85,
                'inicio' => '00:00:00',
                'final' => '00:00:00',
                'tipo' => 'RETARDO_GRAVE',
                'horario_id' => 23,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            85 => 
            array (
                'horario_intervalo_id' => 86,
                'inicio' => '14:00:00',
                'final' => '14:30:00',
                'tipo' => 'SALIDA',
                'horario_id' => 23,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            86 => 
            array (
                'horario_intervalo_id' => 87,
                'inicio' => '08:00:00',
                'final' => '08:30:00',
                'tipo' => 'ENTRADA',
                'horario_id' => 24,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            87 => 
            array (
                'horario_intervalo_id' => 88,
                'inicio' => '00:00:00',
                'final' => '00:00:00',
                'tipo' => 'RETARDO_LEVE',
                'horario_id' => 24,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            88 => 
            array (
                'horario_intervalo_id' => 89,
                'inicio' => '00:00:00',
                'final' => '00:00:00',
                'tipo' => 'RETARDO_GRAVE',
                'horario_id' => 24,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            89 => 
            array (
                'horario_intervalo_id' => 90,
                'inicio' => '15:00:00',
                'final' => '15:30:00',
                'tipo' => 'SALIDA',
                'horario_id' => 24,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            90 => 
            array (
                'horario_intervalo_id' => 91,
                'inicio' => '08:00:00',
                'final' => '08:30:00',
                'tipo' => 'ENTRADA',
                'horario_id' => 25,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            91 => 
            array (
                'horario_intervalo_id' => 92,
                'inicio' => '00:00:00',
                'final' => '00:00:00',
                'tipo' => 'RETARDO_LEVE',
                'horario_id' => 25,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            92 => 
            array (
                'horario_intervalo_id' => 93,
                'inicio' => '00:00:00',
                'final' => '00:00:00',
                'tipo' => 'RETARDO_GRAVE',
                'horario_id' => 25,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            93 => 
            array (
                'horario_intervalo_id' => 94,
                'inicio' => '16:00:00',
                'final' => '16:30:00',
                'tipo' => 'SALIDA',
                'horario_id' => 25,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            94 => 
            array (
                'horario_intervalo_id' => 95,
                'inicio' => '07:30:00',
                'final' => '08:30:00',
                'tipo' => 'ENTRADA',
                'horario_id' => 26,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            95 => 
            array (
                'horario_intervalo_id' => 96,
                'inicio' => '00:00:00',
                'final' => '00:00:00',
                'tipo' => 'RETARDO_LEVE',
                'horario_id' => 26,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            96 => 
            array (
                'horario_intervalo_id' => 97,
                'inicio' => '00:00:00',
                'final' => '00:00:00',
                'tipo' => 'RETARDO_GRAVE',
                'horario_id' => 26,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            97 => 
            array (
                'horario_intervalo_id' => 98,
                'inicio' => '15:00:00',
                'final' => '15:30:00',
                'tipo' => 'SALIDA',
                'horario_id' => 26,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            98 => 
            array (
                'horario_intervalo_id' => 99,
                'inicio' => '07:30:00',
                'final' => '08:30:00',
                'tipo' => 'ENTRADA',
                'horario_id' => 27,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            99 => 
            array (
                'horario_intervalo_id' => 100,
                'inicio' => '08:10:00',
                'final' => '08:20:00',
                'tipo' => 'RETARDO_LEVE',
                'horario_id' => 27,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            100 => 
            array (
                'horario_intervalo_id' => 101,
                'inicio' => '08:20:00',
                'final' => '08:30:00',
                'tipo' => 'RETARDO_GRAVE',
                'horario_id' => 27,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            101 => 
            array (
                'horario_intervalo_id' => 102,
                'inicio' => '20:00:00',
                'final' => '20:30:00',
                'tipo' => 'SALIDA',
                'horario_id' => 27,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            102 => 
            array (
                'horario_intervalo_id' => 103,
                'inicio' => '07:30:00',
                'final' => '08:30:00',
                'tipo' => 'ENTRADA',
                'horario_id' => 28,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            103 => 
            array (
                'horario_intervalo_id' => 104,
                'inicio' => '00:00:00',
                'final' => '00:00:00',
                'tipo' => 'RETARDO_LEVE',
                'horario_id' => 28,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            104 => 
            array (
                'horario_intervalo_id' => 105,
                'inicio' => '00:00:00',
                'final' => '00:00:00',
                'tipo' => 'RETARDO_GRAVE',
                'horario_id' => 28,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            105 => 
            array (
                'horario_intervalo_id' => 106,
                'inicio' => '16:00:00',
                'final' => '16:30:00',
                'tipo' => 'SALIDA',
                'horario_id' => 28,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            106 => 
            array (
                'horario_intervalo_id' => 107,
                'inicio' => '08:30:00',
                'final' => '09:30:00',
                'tipo' => 'ENTRADA',
                'horario_id' => 29,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            107 => 
            array (
                'horario_intervalo_id' => 108,
                'inicio' => '00:00:00',
                'final' => '00:00:00',
                'tipo' => 'RETARDO_LEVE',
                'horario_id' => 29,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            108 => 
            array (
                'horario_intervalo_id' => 109,
                'inicio' => '00:00:00',
                'final' => '00:00:00',
                'tipo' => 'RETARDO_GRAVE',
                'horario_id' => 29,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            109 => 
            array (
                'horario_intervalo_id' => 110,
                'inicio' => '16:00:00',
                'final' => '16:30:00',
                'tipo' => 'SALIDA',
                'horario_id' => 29,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            110 => 
            array (
                'horario_intervalo_id' => 111,
                'inicio' => '08:30:00',
                'final' => '09:30:00',
                'tipo' => 'ENTRADA',
                'horario_id' => 30,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            111 => 
            array (
                'horario_intervalo_id' => 112,
                'inicio' => '00:00:00',
                'final' => '00:00:00',
                'tipo' => 'RETARDO_LEVE',
                'horario_id' => 30,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            112 => 
            array (
                'horario_intervalo_id' => 113,
                'inicio' => '00:00:00',
                'final' => '00:00:00',
                'tipo' => 'RETARDO_GRAVE',
                'horario_id' => 30,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            113 => 
            array (
                'horario_intervalo_id' => 114,
                'inicio' => '17:00:00',
                'final' => '17:30:00',
                'tipo' => 'SALIDA',
                'horario_id' => 30,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            114 => 
            array (
                'horario_intervalo_id' => 115,
                'inicio' => '08:30:00',
                'final' => '09:30:00',
                'tipo' => 'ENTRADA',
                'horario_id' => 31,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            115 => 
            array (
                'horario_intervalo_id' => 116,
                'inicio' => '00:00:00',
                'final' => '00:00:00',
                'tipo' => 'RETARDO_LEVE',
                'horario_id' => 31,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            116 => 
            array (
                'horario_intervalo_id' => 117,
                'inicio' => '00:00:00',
                'final' => '00:00:00',
                'tipo' => 'RETARDO_GRAVE',
                'horario_id' => 31,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            117 => 
            array (
                'horario_intervalo_id' => 118,
                'inicio' => '18:00:00',
                'final' => '18:30:00',
                'tipo' => 'SALIDA',
                'horario_id' => 31,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            118 => 
            array (
                'horario_intervalo_id' => 119,
                'inicio' => '08:30:00',
                'final' => '09:30:00',
                'tipo' => 'ENTRADA',
                'horario_id' => 32,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            119 => 
            array (
                'horario_intervalo_id' => 120,
                'inicio' => '00:00:00',
                'final' => '00:00:00',
                'tipo' => 'RETARDO_LEVE',
                'horario_id' => 32,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            120 => 
            array (
                'horario_intervalo_id' => 121,
                'inicio' => '00:00:00',
                'final' => '00:00:00',
                'tipo' => 'RETARDO_GRAVE',
                'horario_id' => 32,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            121 => 
            array (
                'horario_intervalo_id' => 122,
                'inicio' => '15:00:00',
                'final' => '15:30:00',
                'tipo' => 'SALIDA',
                'horario_id' => 32,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            122 => 
            array (
                'horario_intervalo_id' => 123,
                'inicio' => '08:30:00',
                'final' => '09:30:00',
                'tipo' => 'ENTRADA',
                'horario_id' => 33,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            123 => 
            array (
                'horario_intervalo_id' => 124,
                'inicio' => '00:00:00',
                'final' => '00:00:00',
                'tipo' => 'RETARDO_LEVE',
                'horario_id' => 33,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            124 => 
            array (
                'horario_intervalo_id' => 125,
                'inicio' => '00:00:00',
                'final' => '00:00:00',
                'tipo' => 'RETARDO_GRAVE',
                'horario_id' => 33,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            125 => 
            array (
                'horario_intervalo_id' => 126,
                'inicio' => '19:00:00',
                'final' => '19:30:00',
                'tipo' => 'SALIDA',
                'horario_id' => 33,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            126 => 
            array (
                'horario_intervalo_id' => 127,
                'inicio' => '08:30:00',
                'final' => '09:10:00',
                'tipo' => 'ENTRADA',
                'horario_id' => 34,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            127 => 
            array (
                'horario_intervalo_id' => 128,
                'inicio' => '09:10:00',
                'final' => '09:20:00',
                'tipo' => 'RETARDO_LEVE',
                'horario_id' => 34,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            128 => 
            array (
                'horario_intervalo_id' => 129,
                'inicio' => '09:20:00',
                'final' => '09:30:00',
                'tipo' => 'RETARDO_GRAVE',
                'horario_id' => 34,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            129 => 
            array (
                'horario_intervalo_id' => 130,
                'inicio' => '15:00:00',
                'final' => '15:30:00',
                'tipo' => 'SALIDA',
                'horario_id' => 34,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            130 => 
            array (
                'horario_intervalo_id' => 131,
                'inicio' => '08:30:00',
                'final' => '09:10:00',
                'tipo' => 'ENTRADA',
                'horario_id' => 35,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            131 => 
            array (
                'horario_intervalo_id' => 132,
                'inicio' => '09:10:00',
                'final' => '09:20:00',
                'tipo' => 'RETARDO_LEVE',
                'horario_id' => 35,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            132 => 
            array (
                'horario_intervalo_id' => 133,
                'inicio' => '09:20:00',
                'final' => '09:30:00',
                'tipo' => 'RETARDO_GRAVE',
                'horario_id' => 35,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            133 => 
            array (
                'horario_intervalo_id' => 134,
                'inicio' => '18:00:00',
                'final' => '18:30:00',
                'tipo' => 'SALIDA',
                'horario_id' => 35,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            134 => 
            array (
                'horario_intervalo_id' => 135,
                'inicio' => '08:30:00',
                'final' => '09:10:00',
                'tipo' => 'ENTRADA',
                'horario_id' => 36,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            135 => 
            array (
                'horario_intervalo_id' => 136,
                'inicio' => '09:10:00',
                'final' => '09:20:00',
                'tipo' => 'RETARDO_LEVE',
                'horario_id' => 36,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            136 => 
            array (
                'horario_intervalo_id' => 137,
                'inicio' => '09:20:00',
                'final' => '09:30:00',
                'tipo' => 'RETARDO_GRAVE',
                'horario_id' => 36,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            137 => 
            array (
                'horario_intervalo_id' => 138,
                'inicio' => '16:00:00',
                'final' => '16:30:00',
                'tipo' => 'SALIDA',
                'horario_id' => 36,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            138 => 
            array (
                'horario_intervalo_id' => 139,
                'inicio' => '08:30:00',
                'final' => '09:10:00',
                'tipo' => 'ENTRADA',
                'horario_id' => 37,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            139 => 
            array (
                'horario_intervalo_id' => 140,
                'inicio' => '09:10:00',
                'final' => '09:20:00',
                'tipo' => 'RETARDO_LEVE',
                'horario_id' => 37,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            140 => 
            array (
                'horario_intervalo_id' => 141,
                'inicio' => '09:20:00',
                'final' => '09:30:00',
                'tipo' => 'RETARDO_GRAVE',
                'horario_id' => 37,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            141 => 
            array (
                'horario_intervalo_id' => 142,
                'inicio' => '21:00:00',
                'final' => '21:30:00',
                'tipo' => 'SALIDA',
                'horario_id' => 37,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            142 => 
            array (
                'horario_intervalo_id' => 143,
                'inicio' => '08:30:00',
                'final' => '09:30:00',
                'tipo' => 'ENTRADA',
                'horario_id' => 38,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            143 => 
            array (
                'horario_intervalo_id' => 144,
                'inicio' => '00:00:00',
                'final' => '00:00:00',
                'tipo' => 'RETARDO_LEVE',
                'horario_id' => 38,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            144 => 
            array (
                'horario_intervalo_id' => 145,
                'inicio' => '00:00:00',
                'final' => '00:00:00',
                'tipo' => 'RETARDO_GRAVE',
                'horario_id' => 38,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            145 => 
            array (
                'horario_intervalo_id' => 146,
                'inicio' => '21:00:00',
                'final' => '21:30:00',
                'tipo' => 'SALIDA',
                'horario_id' => 38,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            146 => 
            array (
                'horario_intervalo_id' => 147,
                'inicio' => '09:30:00',
                'final' => '10:10:00',
                'tipo' => 'ENTRADA',
                'horario_id' => 39,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            147 => 
            array (
                'horario_intervalo_id' => 148,
                'inicio' => '10:10:00',
                'final' => '10:20:00',
                'tipo' => 'RETARDO_LEVE',
                'horario_id' => 39,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            148 => 
            array (
                'horario_intervalo_id' => 149,
                'inicio' => '10:20:00',
                'final' => '10:30:00',
                'tipo' => 'RETARDO_GRAVE',
                'horario_id' => 39,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            149 => 
            array (
                'horario_intervalo_id' => 150,
                'inicio' => '17:00:00',
                'final' => '17:30:00',
                'tipo' => 'SALIDA',
                'horario_id' => 39,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            150 => 
            array (
                'horario_intervalo_id' => 151,
                'inicio' => '09:30:00',
                'final' => '10:10:00',
                'tipo' => 'ENTRADA',
                'horario_id' => 40,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            151 => 
            array (
                'horario_intervalo_id' => 152,
                'inicio' => '10:10:00',
                'final' => '10:20:00',
                'tipo' => 'RETARDO_LEVE',
                'horario_id' => 40,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            152 => 
            array (
                'horario_intervalo_id' => 153,
                'inicio' => '10:20:00',
                'final' => '10:30:00',
                'tipo' => 'RETARDO_GRAVE',
                'horario_id' => 40,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            153 => 
            array (
                'horario_intervalo_id' => 154,
                'inicio' => '16:00:00',
                'final' => '16:30:00',
                'tipo' => 'SALIDA',
                'horario_id' => 40,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            154 => 
            array (
                'horario_intervalo_id' => 155,
                'inicio' => '09:30:00',
                'final' => '10:30:00',
                'tipo' => 'ENTRADA',
                'horario_id' => 41,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            155 => 
            array (
                'horario_intervalo_id' => 156,
                'inicio' => '00:00:00',
                'final' => '00:00:00',
                'tipo' => 'RETARDO_LEVE',
                'horario_id' => 41,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            156 => 
            array (
                'horario_intervalo_id' => 157,
                'inicio' => '00:00:00',
                'final' => '00:00:00',
                'tipo' => 'RETARDO_GRAVE',
                'horario_id' => 41,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            157 => 
            array (
                'horario_intervalo_id' => 158,
                'inicio' => '19:00:00',
                'final' => '19:30:00',
                'tipo' => 'SALIDA',
                'horario_id' => 41,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            158 => 
            array (
                'horario_intervalo_id' => 159,
                'inicio' => '09:30:00',
                'final' => '10:30:00',
                'tipo' => 'ENTRADA',
                'horario_id' => 42,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            159 => 
            array (
                'horario_intervalo_id' => 160,
                'inicio' => '00:00:00',
                'final' => '00:00:00',
                'tipo' => 'RETARDO_LEVE',
                'horario_id' => 42,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            160 => 
            array (
                'horario_intervalo_id' => 161,
                'inicio' => '00:00:00',
                'final' => '00:00:00',
                'tipo' => 'RETARDO_GRAVE',
                'horario_id' => 42,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            161 => 
            array (
                'horario_intervalo_id' => 162,
                'inicio' => '17:00:00',
                'final' => '17:30:00',
                'tipo' => 'SALIDA',
                'horario_id' => 42,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            162 => 
            array (
                'horario_intervalo_id' => 163,
                'inicio' => '09:30:00',
                'final' => '10:30:00',
                'tipo' => 'ENTRADA',
                'horario_id' => 43,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            163 => 
            array (
                'horario_intervalo_id' => 164,
                'inicio' => '10:10:00',
                'final' => '10:20:00',
                'tipo' => 'RETARDO_LEVE',
                'horario_id' => 43,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            164 => 
            array (
                'horario_intervalo_id' => 165,
                'inicio' => '00:00:00',
                'final' => '00:00:00',
                'tipo' => 'RETARDO_GRAVE',
                'horario_id' => 43,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            165 => 
            array (
                'horario_intervalo_id' => 166,
                'inicio' => '18:00:00',
                'final' => '18:30:00',
                'tipo' => 'SALIDA',
                'horario_id' => 43,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            166 => 
            array (
                'horario_intervalo_id' => 167,
                'inicio' => '09:30:00',
                'final' => '10:10:00',
                'tipo' => 'ENTRADA',
                'horario_id' => 44,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            167 => 
            array (
                'horario_intervalo_id' => 168,
                'inicio' => '10:10:00',
                'final' => '10:20:00',
                'tipo' => 'RETARDO_LEVE',
                'horario_id' => 44,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            168 => 
            array (
                'horario_intervalo_id' => 169,
                'inicio' => '10:20:00',
                'final' => '10:30:00',
                'tipo' => 'RETARDO_GRAVE',
                'horario_id' => 44,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            169 => 
            array (
                'horario_intervalo_id' => 170,
                'inicio' => '22:00:00',
                'final' => '22:30:00',
                'tipo' => 'SALIDA',
                'horario_id' => 44,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            170 => 
            array (
                'horario_intervalo_id' => 171,
                'inicio' => '09:30:00',
                'final' => '10:30:00',
                'tipo' => 'ENTRADA',
                'horario_id' => 45,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            171 => 
            array (
                'horario_intervalo_id' => 172,
                'inicio' => '00:00:00',
                'final' => '00:00:00',
                'tipo' => 'RETARDO_LEVE',
                'horario_id' => 45,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            172 => 
            array (
                'horario_intervalo_id' => 173,
                'inicio' => '00:00:00',
                'final' => '00:00:00',
                'tipo' => 'RETARDO_GRAVE',
                'horario_id' => 45,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            173 => 
            array (
                'horario_intervalo_id' => 174,
                'inicio' => '22:00:00',
                'final' => '22:30:00',
                'tipo' => 'SALIDA',
                'horario_id' => 45,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            174 => 
            array (
                'horario_intervalo_id' => 175,
                'inicio' => '10:30:00',
                'final' => '11:30:00',
                'tipo' => 'ENTRADA',
                'horario_id' => 46,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            175 => 
            array (
                'horario_intervalo_id' => 176,
                'inicio' => '00:00:00',
                'final' => '00:00:00',
                'tipo' => 'RETARDO_LEVE',
                'horario_id' => 46,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            176 => 
            array (
                'horario_intervalo_id' => 177,
                'inicio' => '00:00:00',
                'final' => '00:00:00',
                'tipo' => 'RETARDO_GRAVE',
                'horario_id' => 46,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            177 => 
            array (
                'horario_intervalo_id' => 178,
                'inicio' => '18:00:00',
                'final' => '18:30:00',
                'tipo' => 'SALIDA',
                'horario_id' => 46,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            178 => 
            array (
                'horario_intervalo_id' => 179,
                'inicio' => '10:30:00',
                'final' => '11:30:00',
                'tipo' => 'ENTRADA',
                'horario_id' => 47,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            179 => 
            array (
                'horario_intervalo_id' => 180,
                'inicio' => '00:00:00',
                'final' => '00:00:00',
                'tipo' => 'RETARDO_LEVE',
                'horario_id' => 47,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            180 => 
            array (
                'horario_intervalo_id' => 181,
                'inicio' => '00:00:00',
                'final' => '00:00:00',
                'tipo' => 'RETARDO_GRAVE',
                'horario_id' => 47,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            181 => 
            array (
                'horario_intervalo_id' => 182,
                'inicio' => '19:00:00',
                'final' => '19:30:00',
                'tipo' => 'SALIDA',
                'horario_id' => 47,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            182 => 
            array (
                'horario_intervalo_id' => 183,
                'inicio' => '10:30:00',
                'final' => '11:10:00',
                'tipo' => 'ENTRADA',
                'horario_id' => 48,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            183 => 
            array (
                'horario_intervalo_id' => 184,
                'inicio' => '11:10:00',
                'final' => '11:20:00',
                'tipo' => 'RETARDO_LEVE',
                'horario_id' => 48,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            184 => 
            array (
                'horario_intervalo_id' => 185,
                'inicio' => '11:20:00',
                'final' => '11:30:00',
                'tipo' => 'RETARDO_GRAVE',
                'horario_id' => 48,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            185 => 
            array (
                'horario_intervalo_id' => 186,
                'inicio' => '18:00:00',
                'final' => '18:30:00',
                'tipo' => 'SALIDA',
                'horario_id' => 48,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            186 => 
            array (
                'horario_intervalo_id' => 187,
                'inicio' => '11:10:00',
                'final' => '11:20:00',
                'tipo' => 'RETARDO_LEVE',
                'horario_id' => 49,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            187 => 
            array (
                'horario_intervalo_id' => 188,
                'inicio' => '11:20:00',
                'final' => '11:30:00',
                'tipo' => 'RETARDO_GRAVE',
                'horario_id' => 49,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            188 => 
            array (
                'horario_intervalo_id' => 189,
                'inicio' => '18:00:00',
                'final' => '18:10:00',
                'tipo' => 'SALIDA',
                'horario_id' => 49,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            189 => 
            array (
                'horario_intervalo_id' => 190,
                'inicio' => '10:30:00',
                'final' => '11:10:00',
                'tipo' => 'ENTRADA',
                'horario_id' => 49,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            190 => 
            array (
                'horario_intervalo_id' => 191,
                'inicio' => '11:30:00',
                'final' => '19:30:00',
                'tipo' => 'ENTRADA',
                'horario_id' => 50,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            191 => 
            array (
                'horario_intervalo_id' => 192,
                'inicio' => '12:10:00',
                'final' => '12:20:00',
                'tipo' => 'RETARDO_LEVE',
                'horario_id' => 50,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            192 => 
            array (
                'horario_intervalo_id' => 193,
                'inicio' => '12:20:00',
                'final' => '12:30:00',
                'tipo' => 'RETARDO_GRAVE',
                'horario_id' => 50,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            193 => 
            array (
                'horario_intervalo_id' => 194,
                'inicio' => '19:00:00',
                'final' => '19:30:00',
                'tipo' => 'SALIDA',
                'horario_id' => 50,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            194 => 
            array (
                'horario_intervalo_id' => 195,
                'inicio' => '11:30:00',
                'final' => '12:30:00',
                'tipo' => 'ENTRADA',
                'horario_id' => 51,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            195 => 
            array (
                'horario_intervalo_id' => 196,
                'inicio' => '12:10:00',
                'final' => '12:20:00',
                'tipo' => 'RETARDO_LEVE',
                'horario_id' => 51,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            196 => 
            array (
                'horario_intervalo_id' => 197,
                'inicio' => '12:20:00',
                'final' => '12:30:00',
                'tipo' => 'RETARDO_GRAVE',
                'horario_id' => 51,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            197 => 
            array (
                'horario_intervalo_id' => 198,
                'inicio' => '19:00:00',
                'final' => '19:30:00',
                'tipo' => 'SALIDA',
                'horario_id' => 51,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            198 => 
            array (
                'horario_intervalo_id' => 199,
                'inicio' => '11:30:00',
                'final' => '12:30:00',
                'tipo' => 'ENTRADA',
                'horario_id' => 52,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            199 => 
            array (
                'horario_intervalo_id' => 200,
                'inicio' => '00:00:00',
                'final' => '00:00:00',
                'tipo' => 'RETARDO_LEVE',
                'horario_id' => 52,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            200 => 
            array (
                'horario_intervalo_id' => 201,
                'inicio' => '00:00:00',
                'final' => '00:00:00',
                'tipo' => 'RETARDO_GRAVE',
                'horario_id' => 52,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            201 => 
            array (
                'horario_intervalo_id' => 202,
                'inicio' => '20:00:00',
                'final' => '20:30:00',
                'tipo' => 'SALIDA',
                'horario_id' => 52,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            202 => 
            array (
                'horario_intervalo_id' => 203,
                'inicio' => '11:30:00',
                'final' => '12:30:00',
                'tipo' => 'ENTRADA',
                'horario_id' => 53,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            203 => 
            array (
                'horario_intervalo_id' => 204,
                'inicio' => '00:00:00',
                'final' => '00:00:00',
                'tipo' => 'RETARDO_LEVE',
                'horario_id' => 53,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            204 => 
            array (
                'horario_intervalo_id' => 205,
                'inicio' => '00:00:00',
                'final' => '00:00:00',
                'tipo' => 'RETARDO_GRAVE',
                'horario_id' => 53,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            205 => 
            array (
                'horario_intervalo_id' => 206,
                'inicio' => '19:00:00',
                'final' => '19:30:00',
                'tipo' => 'SALIDA',
                'horario_id' => 53,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            206 => 
            array (
                'horario_intervalo_id' => 207,
                'inicio' => '12:30:00',
                'final' => '13:30:00',
                'tipo' => 'ENTRADA',
                'horario_id' => 54,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            207 => 
            array (
                'horario_intervalo_id' => 208,
                'inicio' => '00:00:00',
                'final' => '00:00:00',
                'tipo' => 'RETARDO_LEVE',
                'horario_id' => 54,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            208 => 
            array (
                'horario_intervalo_id' => 209,
                'inicio' => '00:00:00',
                'final' => '00:00:00',
                'tipo' => 'RETARDO_GRAVE',
                'horario_id' => 54,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            209 => 
            array (
                'horario_intervalo_id' => 210,
                'inicio' => '20:00:00',
                'final' => '20:30:00',
                'tipo' => 'SALIDA',
                'horario_id' => 54,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            210 => 
            array (
                'horario_intervalo_id' => 211,
                'inicio' => '12:30:00',
                'final' => '13:00:00',
                'tipo' => 'ENTRADA',
                'horario_id' => 55,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            211 => 
            array (
                'horario_intervalo_id' => 212,
                'inicio' => '13:10:00',
                'final' => '13:20:00',
                'tipo' => 'RETARDO_LEVE',
                'horario_id' => 55,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            212 => 
            array (
                'horario_intervalo_id' => 213,
                'inicio' => '13:20:00',
                'final' => '13:30:00',
                'tipo' => 'RETARDO_GRAVE',
                'horario_id' => 55,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            213 => 
            array (
                'horario_intervalo_id' => 214,
                'inicio' => '21:00:00',
                'final' => '21:30:00',
                'tipo' => 'SALIDA',
                'horario_id' => 55,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            214 => 
            array (
                'horario_intervalo_id' => 215,
                'inicio' => '13:30:00',
                'final' => '14:10:00',
                'tipo' => 'ENTRADA',
                'horario_id' => 56,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            215 => 
            array (
                'horario_intervalo_id' => 216,
                'inicio' => '14:10:00',
                'final' => '14:20:00',
                'tipo' => 'RETARDO_LEVE',
                'horario_id' => 56,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            216 => 
            array (
                'horario_intervalo_id' => 217,
                'inicio' => '14:20:00',
                'final' => '14:30:00',
                'tipo' => 'RETARDO_GRAVE',
                'horario_id' => 56,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            217 => 
            array (
                'horario_intervalo_id' => 218,
                'inicio' => '20:00:00',
                'final' => '20:30:00',
                'tipo' => 'SALIDA',
                'horario_id' => 56,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            218 => 
            array (
                'horario_intervalo_id' => 219,
                'inicio' => '13:30:00',
                'final' => '14:30:00',
                'tipo' => 'ENTRADA',
                'horario_id' => 57,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            219 => 
            array (
                'horario_intervalo_id' => 220,
                'inicio' => '00:00:00',
                'final' => '00:00:00',
                'tipo' => 'RETARDO_LEVE',
                'horario_id' => 57,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            220 => 
            array (
                'horario_intervalo_id' => 221,
                'inicio' => '00:00:00',
                'final' => '00:00:00',
                'tipo' => 'RETARDO_GRAVE',
                'horario_id' => 57,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            221 => 
            array (
                'horario_intervalo_id' => 222,
                'inicio' => '21:00:00',
                'final' => '21:30:00',
                'tipo' => 'SALIDA',
                'horario_id' => 57,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            222 => 
            array (
                'horario_intervalo_id' => 223,
                'inicio' => '13:30:00',
                'final' => '14:30:00',
                'tipo' => 'ENTRADA',
                'horario_id' => 58,
                'created_at' => '2024-04-17 14:04:15',
                'updated_at' => '2024-04-17 14:04:15',
            ),
            223 => 
            array (
                'horario_intervalo_id' => 224,
                'inicio' => '14:10:00',
                'final' => '14:20:00',
                'tipo' => 'RETARDO_LEVE',
                'horario_id' => 58,
                'created_at' => '2024-04-17 14:04:16',
                'updated_at' => '2024-04-17 14:04:16',
            ),
            224 => 
            array (
                'horario_intervalo_id' => 225,
                'inicio' => '14:20:00',
                'final' => '14:30:00',
                'tipo' => 'RETARDO_GRAVE',
                'horario_id' => 58,
                'created_at' => '2024-04-17 14:04:16',
                'updated_at' => '2024-04-17 14:04:16',
            ),
            225 => 
            array (
                'horario_intervalo_id' => 226,
                'inicio' => '22:00:00',
                'final' => '22:30:00',
                'tipo' => 'SALIDA',
                'horario_id' => 58,
                'created_at' => '2024-04-17 14:04:16',
                'updated_at' => '2024-04-17 14:04:16',
            ),
            226 => 
            array (
                'horario_intervalo_id' => 227,
                'inicio' => '13:30:00',
                'final' => '14:10:00',
                'tipo' => 'ENTRADA',
                'horario_id' => 59,
                'created_at' => '2024-04-17 14:04:16',
                'updated_at' => '2024-04-17 14:04:16',
            ),
            227 => 
            array (
                'horario_intervalo_id' => 228,
                'inicio' => '14:10:00',
                'final' => '14:20:00',
                'tipo' => 'RETARDO_LEVE',
                'horario_id' => 59,
                'created_at' => '2024-04-17 14:04:16',
                'updated_at' => '2024-04-17 14:04:16',
            ),
            228 => 
            array (
                'horario_intervalo_id' => 229,
                'inicio' => '14:20:00',
                'final' => '14:30:00',
                'tipo' => 'RETARDO_GRAVE',
                'horario_id' => 59,
                'created_at' => '2024-04-17 14:04:16',
                'updated_at' => '2024-04-17 14:04:16',
            ),
            229 => 
            array (
                'horario_intervalo_id' => 230,
                'inicio' => '21:00:00',
                'final' => '21:30:00',
                'tipo' => 'SALIDA',
                'horario_id' => 59,
                'created_at' => '2024-04-17 14:04:16',
                'updated_at' => '2024-04-17 14:04:16',
            ),
            230 => 
            array (
                'horario_intervalo_id' => 231,
                'inicio' => '13:30:00',
                'final' => '14:30:00',
                'tipo' => 'ENTRADA',
                'horario_id' => 60,
                'created_at' => '2024-04-17 14:04:16',
                'updated_at' => '2024-04-17 14:04:16',
            ),
            231 => 
            array (
                'horario_intervalo_id' => 232,
                'inicio' => '00:00:00',
                'final' => '00:00:00',
                'tipo' => 'RETARDO_LEVE',
                'horario_id' => 60,
                'created_at' => '2024-04-17 14:04:16',
                'updated_at' => '2024-04-17 14:04:16',
            ),
            232 => 
            array (
                'horario_intervalo_id' => 233,
                'inicio' => '00:00:00',
                'final' => '00:00:00',
                'tipo' => 'RETARDO_GRAVE',
                'horario_id' => 60,
                'created_at' => '2024-04-17 14:04:16',
                'updated_at' => '2024-04-17 14:04:16',
            ),
            233 => 
            array (
                'horario_intervalo_id' => 234,
                'inicio' => '20:00:00',
                'final' => '20:30:00',
                'tipo' => 'SALIDA',
                'horario_id' => 60,
                'created_at' => '2024-04-17 14:04:16',
                'updated_at' => '2024-04-17 14:04:16',
            ),
            234 => 
            array (
                'horario_intervalo_id' => 235,
                'inicio' => '14:30:00',
                'final' => '15:30:00',
                'tipo' => 'ENTRADA',
                'horario_id' => 61,
                'created_at' => '2024-04-17 14:04:16',
                'updated_at' => '2024-04-17 14:04:16',
            ),
            235 => 
            array (
                'horario_intervalo_id' => 236,
                'inicio' => '00:00:00',
                'final' => '00:00:00',
                'tipo' => 'RETARDO_LEVE',
                'horario_id' => 61,
                'created_at' => '2024-04-17 14:04:16',
                'updated_at' => '2024-04-17 14:04:16',
            ),
            236 => 
            array (
                'horario_intervalo_id' => 237,
                'inicio' => '00:00:00',
                'final' => '00:00:00',
                'tipo' => 'RETARDO_GRAVE',
                'horario_id' => 61,
                'created_at' => '2024-04-17 14:04:16',
                'updated_at' => '2024-04-17 14:04:16',
            ),
            237 => 
            array (
                'horario_intervalo_id' => 238,
                'inicio' => '21:00:00',
                'final' => '21:30:00',
                'tipo' => 'SALIDA',
                'horario_id' => 61,
                'created_at' => '2024-04-17 14:04:16',
                'updated_at' => '2024-04-17 14:04:16',
            ),
            238 => 
            array (
                'horario_intervalo_id' => 239,
                'inicio' => '14:30:00',
                'final' => '15:10:00',
                'tipo' => 'ENTRADA',
                'horario_id' => 62,
                'created_at' => '2024-04-17 14:04:16',
                'updated_at' => '2024-04-17 14:04:16',
            ),
            239 => 
            array (
                'horario_intervalo_id' => 240,
                'inicio' => '15:10:00',
                'final' => '15:20:00',
                'tipo' => 'RETARDO_LEVE',
                'horario_id' => 62,
                'created_at' => '2024-04-17 14:04:16',
                'updated_at' => '2024-04-17 14:04:16',
            ),
            240 => 
            array (
                'horario_intervalo_id' => 241,
                'inicio' => '15:20:00',
                'final' => '15:30:00',
                'tipo' => 'RETARDO_GRAVE',
                'horario_id' => 62,
                'created_at' => '2024-04-17 14:04:16',
                'updated_at' => '2024-04-17 14:04:16',
            ),
            241 => 
            array (
                'horario_intervalo_id' => 242,
                'inicio' => '22:00:00',
                'final' => '22:30:00',
                'tipo' => 'SALIDA',
                'horario_id' => 62,
                'created_at' => '2024-04-17 14:04:16',
                'updated_at' => '2024-04-17 14:04:16',
            ),
            242 => 
            array (
                'horario_intervalo_id' => 243,
                'inicio' => '14:30:00',
                'final' => '15:10:00',
                'tipo' => 'ENTRADA',
                'horario_id' => 63,
                'created_at' => '2024-04-17 14:04:16',
                'updated_at' => '2024-04-17 14:04:16',
            ),
            243 => 
            array (
                'horario_intervalo_id' => 244,
                'inicio' => '15:10:00',
                'final' => '15:20:00',
                'tipo' => 'RETARDO_LEVE',
                'horario_id' => 63,
                'created_at' => '2024-04-17 14:04:16',
                'updated_at' => '2024-04-17 14:04:16',
            ),
            244 => 
            array (
                'horario_intervalo_id' => 245,
                'inicio' => '15:20:00',
                'final' => '15:30:00',
                'tipo' => 'RETARDO_GRAVE',
                'horario_id' => 63,
                'created_at' => '2024-04-17 14:04:16',
                'updated_at' => '2024-04-17 14:04:16',
            ),
            245 => 
            array (
                'horario_intervalo_id' => 246,
                'inicio' => '21:30:00',
                'final' => '22:00:00',
                'tipo' => 'SALIDA',
                'horario_id' => 63,
                'created_at' => '2024-04-17 14:04:16',
                'updated_at' => '2024-04-17 14:04:16',
            ),
            246 => 
            array (
                'horario_intervalo_id' => 247,
                'inicio' => '14:30:00',
                'final' => '15:30:00',
                'tipo' => 'ENTRADA',
                'horario_id' => 64,
                'created_at' => '2024-04-17 14:04:16',
                'updated_at' => '2024-04-17 14:04:16',
            ),
            247 => 
            array (
                'horario_intervalo_id' => 248,
                'inicio' => '00:00:00',
                'final' => '00:00:00',
                'tipo' => 'RETARDO_LEVE',
                'horario_id' => 64,
                'created_at' => '2024-04-17 14:04:16',
                'updated_at' => '2024-04-17 14:04:16',
            ),
            248 => 
            array (
                'horario_intervalo_id' => 249,
                'inicio' => '00:00:00',
                'final' => '00:00:00',
                'tipo' => 'RETARDO_GRAVE',
                'horario_id' => 64,
                'created_at' => '2024-04-17 14:04:16',
                'updated_at' => '2024-04-17 14:04:16',
            ),
            249 => 
            array (
                'horario_intervalo_id' => 250,
                'inicio' => '22:00:00',
                'final' => '22:30:00',
                'tipo' => 'SALIDA',
                'horario_id' => 64,
                'created_at' => '2024-04-17 14:04:16',
                'updated_at' => '2024-04-17 14:04:16',
            ),
            250 => 
            array (
                'horario_intervalo_id' => 251,
                'inicio' => '14:30:00',
                'final' => '15:10:00',
                'tipo' => 'ENTRADA',
                'horario_id' => 65,
                'created_at' => '2024-04-17 14:04:16',
                'updated_at' => '2024-04-17 14:04:16',
            ),
            251 => 
            array (
                'horario_intervalo_id' => 252,
                'inicio' => '15:10:00',
                'final' => '15:20:00',
                'tipo' => 'RETARDO_LEVE',
                'horario_id' => 65,
                'created_at' => '2024-04-17 14:04:16',
                'updated_at' => '2024-04-17 14:04:16',
            ),
            252 => 
            array (
                'horario_intervalo_id' => 253,
                'inicio' => '15:20:00',
                'final' => '15:30:00',
                'tipo' => 'RETARDO_GRAVE',
                'horario_id' => 65,
                'created_at' => '2024-04-17 14:04:16',
                'updated_at' => '2024-04-17 14:04:16',
            ),
            253 => 
            array (
                'horario_intervalo_id' => 254,
                'inicio' => '21:00:00',
                'final' => '21:30:00',
                'tipo' => 'SALIDA',
                'horario_id' => 65,
                'created_at' => '2024-04-17 14:04:16',
                'updated_at' => '2024-04-17 14:04:16',
            ),
            254 => 
            array (
                'horario_intervalo_id' => 255,
                'inicio' => '15:00:00',
                'final' => '15:40:00',
                'tipo' => 'ENTRADA',
                'horario_id' => 66,
                'created_at' => '2024-04-17 14:04:16',
                'updated_at' => '2024-04-17 14:04:16',
            ),
            255 => 
            array (
                'horario_intervalo_id' => 256,
                'inicio' => '15:40:00',
                'final' => '15:50:00',
                'tipo' => 'RETARDO_LEVE',
                'horario_id' => 66,
                'created_at' => '2024-04-17 14:04:16',
                'updated_at' => '2024-04-17 14:04:16',
            ),
            256 => 
            array (
                'horario_intervalo_id' => 257,
                'inicio' => '15:50:00',
                'final' => '16:00:00',
                'tipo' => 'RETARDO_GRAVE',
                'horario_id' => 66,
                'created_at' => '2024-04-17 14:04:16',
                'updated_at' => '2024-04-17 14:04:16',
            ),
            257 => 
            array (
                'horario_intervalo_id' => 258,
                'inicio' => '22:00:00',
                'final' => '22:30:00',
                'tipo' => 'SALIDA',
                'horario_id' => 66,
                'created_at' => '2024-04-17 14:04:16',
                'updated_at' => '2024-04-17 14:04:16',
            ),
            258 => 
            array (
                'horario_intervalo_id' => 259,
                'inicio' => '15:30:00',
                'final' => '16:30:00',
                'tipo' => 'ENTRADA',
                'horario_id' => 67,
                'created_at' => '2024-04-17 14:04:16',
                'updated_at' => '2024-04-17 14:04:16',
            ),
            259 => 
            array (
                'horario_intervalo_id' => 260,
                'inicio' => '00:00:00',
                'final' => '00:00:00',
                'tipo' => 'RETARDO_LEVE',
                'horario_id' => 67,
                'created_at' => '2024-04-17 14:04:16',
                'updated_at' => '2024-04-17 14:04:16',
            ),
            260 => 
            array (
                'horario_intervalo_id' => 261,
                'inicio' => '00:00:00',
                'final' => '00:00:00',
                'tipo' => 'RETARDO_GRAVE',
                'horario_id' => 67,
                'created_at' => '2024-04-17 14:04:16',
                'updated_at' => '2024-04-17 14:04:16',
            ),
            261 => 
            array (
                'horario_intervalo_id' => 262,
                'inicio' => '22:00:00',
                'final' => '22:30:00',
                'tipo' => 'SALIDA',
                'horario_id' => 67,
                'created_at' => '2024-04-17 14:04:16',
                'updated_at' => '2024-04-17 14:04:16',
            ),
            262 => 
            array (
                'horario_intervalo_id' => 263,
                'inicio' => '15:30:00',
                'final' => '19:20:00',
                'tipo' => 'ENTRADA',
                'horario_id' => 68,
                'created_at' => '2024-04-17 14:04:16',
                'updated_at' => '2024-04-17 14:04:16',
            ),
            263 => 
            array (
                'horario_intervalo_id' => 264,
                'inicio' => '19:20:00',
                'final' => '19:27:00',
                'tipo' => 'RETARDO_LEVE',
                'horario_id' => 68,
                'created_at' => '2024-04-17 14:04:16',
                'updated_at' => '2024-04-17 14:04:16',
            ),
            264 => 
            array (
                'horario_intervalo_id' => 265,
                'inicio' => '19:27:00',
                'final' => '19:28:00',
                'tipo' => 'RETARDO_GRAVE',
                'horario_id' => 68,
                'created_at' => '2024-04-17 14:04:16',
                'updated_at' => '2024-04-17 14:04:16',
            ),
            265 => 
            array (
                'horario_intervalo_id' => 266,
                'inicio' => '19:29:00',
                'final' => '19:30:00',
                'tipo' => 'SALIDA',
                'horario_id' => 68,
                'created_at' => '2024-04-17 14:04:16',
                'updated_at' => '2024-04-17 14:04:16',
            ),
            266 => 
            array (
                'horario_intervalo_id' => 267,
                'inicio' => '15:30:00',
                'final' => '16:10:00',
                'tipo' => 'ENTRADA',
                'horario_id' => 69,
                'created_at' => '2024-04-17 14:04:16',
                'updated_at' => '2024-04-17 14:04:16',
            ),
            267 => 
            array (
                'horario_intervalo_id' => 268,
                'inicio' => '16:10:00',
                'final' => '16:20:00',
                'tipo' => 'RETARDO_LEVE',
                'horario_id' => 69,
                'created_at' => '2024-04-17 14:04:16',
                'updated_at' => '2024-04-17 14:04:16',
            ),
            268 => 
            array (
                'horario_intervalo_id' => 269,
                'inicio' => '16:20:00',
                'final' => '16:30:00',
                'tipo' => 'RETARDO_GRAVE',
                'horario_id' => 69,
                'created_at' => '2024-04-17 14:04:16',
                'updated_at' => '2024-04-17 14:04:16',
            ),
            269 => 
            array (
                'horario_intervalo_id' => 270,
                'inicio' => '22:00:00',
                'final' => '22:30:00',
                'tipo' => 'SALIDA',
                'horario_id' => 69,
                'created_at' => '2024-04-17 14:04:16',
                'updated_at' => '2024-04-17 14:04:16',
            ),
            270 => 
            array (
                'horario_intervalo_id' => 271,
                'inicio' => '15:30:00',
                'final' => '16:10:00',
                'tipo' => 'ENTRADA',
                'horario_id' => 70,
                'created_at' => '2024-04-17 14:04:16',
                'updated_at' => '2024-04-17 14:04:16',
            ),
            271 => 
            array (
                'horario_intervalo_id' => 272,
                'inicio' => '16:10:00',
                'final' => '16:20:00',
                'tipo' => 'RETARDO_LEVE',
                'horario_id' => 70,
                'created_at' => '2024-04-17 14:04:16',
                'updated_at' => '2024-04-17 14:04:16',
            ),
            272 => 
            array (
                'horario_intervalo_id' => 273,
                'inicio' => '16:20:00',
                'final' => '16:30:00',
                'tipo' => 'RETARDO_GRAVE',
                'horario_id' => 70,
                'created_at' => '2024-04-17 14:04:16',
                'updated_at' => '2024-04-17 14:04:16',
            ),
            273 => 
            array (
                'horario_intervalo_id' => 274,
                'inicio' => '22:00:00',
                'final' => '22:30:00',
                'tipo' => 'SALIDA',
                'horario_id' => 70,
                'created_at' => '2024-04-17 14:04:16',
                'updated_at' => '2024-04-17 14:04:16',
            ),
            274 => 
            array (
                'horario_intervalo_id' => 275,
                'inicio' => '17:30:00',
                'final' => '18:10:00',
                'tipo' => 'ENTRADA',
                'horario_id' => 71,
                'created_at' => '2024-04-17 14:04:16',
                'updated_at' => '2024-04-17 14:04:16',
            ),
            275 => 
            array (
                'horario_intervalo_id' => 276,
                'inicio' => '18:10:00',
                'final' => '18:20:00',
                'tipo' => 'RETARDO_LEVE',
                'horario_id' => 71,
                'created_at' => '2024-04-17 14:04:16',
                'updated_at' => '2024-04-17 14:04:16',
            ),
            276 => 
            array (
                'horario_intervalo_id' => 277,
                'inicio' => '18:20:00',
                'final' => '18:30:00',
                'tipo' => 'RETARDO_GRAVE',
                'horario_id' => 71,
                'created_at' => '2024-04-17 14:04:16',
                'updated_at' => '2024-04-17 14:04:16',
            ),
            277 => 
            array (
                'horario_intervalo_id' => 278,
                'inicio' => '23:50:00',
                'final' => '23:59:00',
                'tipo' => 'SALIDA',
                'horario_id' => 71,
                'created_at' => '2024-04-17 14:04:16',
                'updated_at' => '2024-04-17 14:04:16',
            ),
            278 => 
            array (
                'horario_intervalo_id' => 279,
                'inicio' => '20:30:00',
                'final' => '21:10:00',
                'tipo' => 'ENTRADA',
                'horario_id' => 72,
                'created_at' => '2024-04-17 14:04:16',
                'updated_at' => '2024-04-17 14:04:16',
            ),
            279 => 
            array (
                'horario_intervalo_id' => 280,
                'inicio' => '21:10:00',
                'final' => '21:20:00',
                'tipo' => 'RETARDO_LEVE',
                'horario_id' => 72,
                'created_at' => '2024-04-17 14:04:16',
                'updated_at' => '2024-04-17 14:04:16',
            ),
            280 => 
            array (
                'horario_intervalo_id' => 281,
                'inicio' => '21:20:00',
                'final' => '21:30:00',
                'tipo' => 'RETARDO_GRAVE',
                'horario_id' => 72,
                'created_at' => '2024-04-17 14:04:16',
                'updated_at' => '2024-04-17 14:04:16',
            ),
            281 => 
            array (
                'horario_intervalo_id' => 282,
                'inicio' => '03:00:00',
                'final' => '03:30:00',
                'tipo' => 'SALIDA',
                'horario_id' => 72,
                'created_at' => '2024-04-17 14:04:16',
                'updated_at' => '2024-04-17 14:04:16',
            ),
        ));
        
        DB::statement("SELECT setval('p15_horarios_intervalos_horario_intervalo_id_seq', (SELECT MAX(horario_intervalo_id) FROM p15_horarios_intervalos));");
    }
}