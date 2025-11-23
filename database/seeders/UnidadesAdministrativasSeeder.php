<?php

namespace Database\Seeders;

use App\Models\UnidadAdministrativa;
use Illuminate\Database\Seeder;

class UnidadesAdministrativasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UnidadAdministrativa::create([
            "nombre" => "TESORERÍA DE LA CIUDAD DE MÉXICO",
            "identificador" => "11",
            "dependencia_id" => 1,
        ]);
        UnidadAdministrativa::create([
            "nombre" => "DIRECCIÓN GENERAL DE ADMINISTRACIÓN",
            "identificador" => "137",
            "dependencia_id" => 1,
        ]);
        UnidadAdministrativa::create([
            "nombre" => "DIRECCIÓN GENERAL DE TECNOLOGIAS Y COMUNICACIONES",
            "identificador" => "138",
            "dependencia_id" => 1,
        ]);
        UnidadAdministrativa::create([
            "nombre" => "UNIDAD DE INTELIGENCIA FINANCIERA EN EL D.F.",
            "identificador" => "139",
            "dependencia_id" => 1,
        ]);
        UnidadAdministrativa::create([
            "nombre" => "SUBSECRETARÍA DE EGRESOS",
            "identificador" => "14",
            "dependencia_id" => 1,
        ]);
        UnidadAdministrativa::create([
            "nombre" => "SECRETARIA DE ADMINISTRACIÓN Y FINANZAS - 160",
            "identificador" => "160",
            "dependencia_id" => 1,
        ]);
        UnidadAdministrativa::create([
            "nombre" => "COORDINACIÓN DE EVALUACIÓN,MODERNIZACIÓN Y DESARROLLO ADMINISTRATIVO",
            "identificador" => "162",
            "dependencia_id" => 1,
        ]);
        UnidadAdministrativa::create([
            "nombre" => "DIRECCIÓN GENERAL DE COMUNICACIÓN CIUDADANA",
            "identificador" => "169",
            "dependencia_id" => 1,
        ]);
        UnidadAdministrativa::create([
            "nombre" => "DIRECCIÓN GENERAL DE PATRIMONIO INMOBILIARIO",
            "identificador" => "18",
            "dependencia_id" => 1,
        ]);
        UnidadAdministrativa::create([
            "nombre" => "SUBSECRETARIA DE ADMINISTRACION Y CAPITAL HUMANO",
            "identificador" => "199",
            "dependencia_id" => 1,
        ]);
        UnidadAdministrativa::create([
            "nombre" => "DIRECCIÓN GENERAL DE ENLACE,COORDICACIÓN FISCAL Y PROGRAMAS FEDERALES",
            "identificador" => "200",
            "dependencia_id" => 1,
        ]);
        UnidadAdministrativa::create([
            "nombre" => "UA PARA USUARIOS EXTERNOS",
            "identificador" => "2020",
            "dependencia_id" => 1,
        ]);
        UnidadAdministrativa::create([
            "nombre" => "OFICINA DE LA C. SECRETARIA DE ADMINISTRACIÓN Y FINANZAS",
            "identificador" => "3",
            "dependencia_id" => 1,
        ]);
        UnidadAdministrativa::create([
            "nombre" => "DIRECCIÓN GENERAL DE RECURSOS MATERIALES Y SERVICIOS GENERALES",
            "identificador" => "44",
            "dependencia_id" => 1,
        ]);
        UnidadAdministrativa::create([
            "nombre" => "SECRETARIA DE ADMINISTRACIÓN Y FINANZAS - OM",
            "identificador" => "5",
            "dependencia_id" => 1,
        ]);
        UnidadAdministrativa::create([
            "nombre" => "PROCURADURÍA FISCAL DE LA CIUDAD DE MÉXICO",
            "identificador" => "95",
            "dependencia_id" => 1,
        ]);
        UnidadAdministrativa::create([
            "nombre" => "DIRECCIÓN GENERAL DE ADMINISTRACIÓN",
            "identificador" => "999",
            "dependencia_id" => 1,
        ]);
    }
}
