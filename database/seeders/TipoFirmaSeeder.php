<?php

namespace Database\Seeders;

use App\Models\TipoFirma;
use Illuminate\Database\Seeder;

class TipoFirmaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoFirma::create([
            'nombre' => 'eFirma',
            'clave' => 'e_firma',
            'activo' => true
        ]);

        TipoFirma::create([
            'nombre' => 'Firma Digital',
            'clave' => 'firma_digital',
            'activo' => true
        ]);

        TipoFirma::create([
            'nombre' => 'Firma Autógrafa',
            'clave' => 'firma_autografa',
            'activo' => true
        ]);
        
        TipoFirma::create([
            'nombre' => 'Contraseña',
            'clave' => 'contraseña',
            'activo' => true
        ]);
    }
    
}
