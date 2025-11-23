<?php

namespace Database\Seeders;

use App\Models\Pais;
use Illuminate\Database\Seeder;

class PaisesSeeder extends Seeder {

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        Pais::create([
            'nombre' => 'ALEMANIA'
        ]);
        Pais::create([
            'nombre' => 'ARABIA SAUDI'
        ]);
        Pais::create([
            'nombre' => 'ARGELIA'
        ]);
        Pais::create([
            'nombre' => 'AUSTRALIA'
        ]);
        Pais::create([
            'nombre' => 'AUSTRIA'
        ]);
        Pais::create([
            'nombre' => 'AZERBAIYAN'
        ]);
        Pais::create([
            'nombre' => 'BAHREIN'
        ]);
        Pais::create([
            'nombre' => 'BELGICA'
        ]);
        Pais::create([
            'nombre' => 'BRUNEI'
        ]); 
        Pais::create([
            'nombre' => 'CAMERUN'
        ]);
        Pais::create([
            'nombre' => 'CANADA'
        ]);
    }
}