<?php

namespace Database\Seeders;

use App\Models\TipoAmbito;
use Illuminate\Database\Seeder;

class TiposAmbitosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoAmbito::create([
            'nombre' => 'Nacional',
            'identificador' => "nacional"
        ]);
        
        TipoAmbito::create([
            'nombre' => 'Internacional',
            'identificador' => "internacional"
        ]);
    }
}
