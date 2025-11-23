<?php

namespace Database\Seeders;

use App\Models\EntidadFederativa;
use Illuminate\Database\Seeder;

class EntidadesFederativasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        EntidadFederativa::create(['abreviatura' => 'AG','nombre' => 'AGUASCALIENTES']);
        EntidadFederativa::create(['abreviatura' => 'BC', 'nombre' => 'BAJA CALIFORNIA']);
        EntidadFederativa::create(['abreviatura' => 'BS', 'nombre' => 'BAJA CALIFORNIA SUR']);
        EntidadFederativa::create(['abreviatura' => 'CC', 'nombre' => 'CAMPECHE']);
        EntidadFederativa::create(['abreviatura' => 'CS', 'nombre' => 'CHIAPAS']);
        EntidadFederativa::create(['abreviatura' => 'CH', 'nombre' => 'CHIHUAHUA']);
        EntidadFederativa::create(['abreviatura' => 'CL', 'nombre' => 'COAHUILA']);
        EntidadFederativa::create(['abreviatura' => 'CM', 'nombre' => 'COLIMA']);
        EntidadFederativa::create(['abreviatura' => 'CDMX', 'nombre' => 'CIUDAD DE MÉXICO']);
        EntidadFederativa::create(['abreviatura' => 'DG', 'nombre' => 'DURANGO']);
        EntidadFederativa::create(['abreviatura' => 'GT', 'nombre' => 'GUANAJUATO']);
        EntidadFederativa::create(['abreviatura' => 'GR', 'nombre' => 'GUERRERO']);
        EntidadFederativa::create(['abreviatura' => 'HG', 'nombre' => 'HIDALGO']);
        EntidadFederativa::create(['abreviatura' => 'JC', 'nombre' => 'JALISCO']);
        EntidadFederativa::create(['abreviatura' => 'MC', 'nombre' => 'ESTADO DE MÉXICO']);
        EntidadFederativa::create(['abreviatura' => 'MN', 'nombre' => 'MICHOACÁN']);
        EntidadFederativa::create(['abreviatura' => 'MS', 'nombre' => 'MORELOS']);
        EntidadFederativa::create(['abreviatura' => 'NT', 'nombre' => 'NAYARIT']);
        EntidadFederativa::create(['abreviatura' => 'NL', 'nombre' => 'NUEVO LEÓN']);
        EntidadFederativa::create(['abreviatura' => 'OC', 'nombre' => 'OAXACA']);
        EntidadFederativa::create(['abreviatura' => 'PL', 'nombre' => 'PUEBLA']);
        EntidadFederativa::create(['abreviatura' => 'QT', 'nombre' => 'QUERÉTARO']);
        EntidadFederativa::create(['abreviatura' => 'QR', 'nombre' => 'QUINTANA ROO']);
        EntidadFederativa::create(['abreviatura' => 'SP', 'nombre' => 'SAN LUÍs POTOSÍ']);
        EntidadFederativa::create(['abreviatura' => 'SL', 'nombre' => 'SINALOA']);
        EntidadFederativa::create(['abreviatura' => 'SR', 'nombre' => 'SONORA']);
        EntidadFederativa::create(['abreviatura' => 'TC', 'nombre' => 'TABASCO']);
        EntidadFederativa::create(['abreviatura' => 'TS', 'nombre' => 'TAMAULIPAS']);
        EntidadFederativa::create(['abreviatura' => 'TL', 'nombre' => 'TLAXCALA']);
        EntidadFederativa::create(['abreviatura' => 'VZ', 'nombre' => 'VERACRUZ']);
        EntidadFederativa::create(['abreviatura' => 'YN', 'nombre' => 'YUCATÁN']);
        EntidadFederativa::create(['abreviatura' => 'ZS', 'nombre' => 'ZACATECAS']);
    }
}
