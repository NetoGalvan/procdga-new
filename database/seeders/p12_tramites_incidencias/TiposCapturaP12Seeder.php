<?php

namespace Database\Seeders\p12_tramites_incidencias;

use App\Models\p12_tramites_incidencias\TipoCaptura;
use Illuminate\Database\Seeder;

class TiposCapturaP12Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoCaptura::create([
            'nombre' => 'ALTA',
            'identificador' => 'alta',
            'descripcion' => 'Tipo de captura para dar de alta una incidencia',
        ]);
        TipoCaptura::create([
            'nombre' => 'APLICACIÓN DE NOTAS BUENAS',
            'identificador' => 'alta_nb',
            'descripcion' => 'Tipo de captura para dar de alta una incidencia por nota buena',
        ]);
        TipoCaptura::create([
            'nombre' => 'CANCELACIÓN',
            'identificador' => 'cancelacion',
            'descripcion' => 'Tipo de captura para cancelar una incidencia previamente capturada'
        ]);
    }
}
