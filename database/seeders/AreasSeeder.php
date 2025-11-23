<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\UnidadAdministrativa;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AreasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 11
        Area::create([
            "area_id" => 1,
            "nombre" => "TESORERÍA DE LA CIUDAD DE MÉXICO",
            "identificador" => "11",
            "area_principal_id" => NULL, 
            "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
            "tipo" => "AREA_PRINCIPAL",
        ]);
        Area::create([
            "area_id" => 2,
            "nombre" => "SUBTESORERÍA DE POLÍTICA FISCAL",
            "identificador" => "11.1",
            "area_principal_id" => NULL, 
            "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
            "tipo" => "AREA_PRINCIPAL"
        ]);
        Area::create([
            "area_id" => 3,
            "nombre" => "SUBTESORERÍA DE ADMINISTRACIÓN TRIBUTARIA",
            "identificador" => "11.2",
            "area_principal_id" => NULL,  
            "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
            "tipo" => "AREA_PRINCIPAL"
        ]);
            Area::create([
                "area_id" => 4,
                "nombre" => "A.T. BENITO JUAREZ",
                "identificador" => "11.201",
                "area_principal_id" => Area::where("identificador", "11.2")->first()->area_id,  
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 5,
                "nombre" => "A.T. CORUÑA",
                "identificador" => "11.202",
                "area_principal_id" => Area::where("identificador", "11.2")->first()->area_id,  
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 6,
                "nombre" => "A.T. AUX. MODULO CENTRAL",
                "identificador" => "11.203",
                "area_principal_id" => Area::where("identificador", "11.2")->first()->area_id,  
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 7,
                "nombre" => "A.T. SAN LAZARO",
                "identificador" => "11.204",
                "area_principal_id" => Area::where("identificador", "11.2")->first()->area_id,   
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 8,
                "nombre" => "A.T. ANAHUAC",
                "identificador" => "11.205",
                "area_principal_id" => Area::where("identificador", "11.2")->first()->area_id,    
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 9,
                "nombre" => "A.T. ARAGON",
                "identificador" => "11.206",
                "area_principal_id" => Area::where("identificador", "11.2")->first()->area_id,  
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 10,
                "nombre" => "A.T. CENTRO MEDICO",
                "identificador" => "11.207",
                "area_principal_id" => Area::where("identificador", "11.2")->first()->area_id,  
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 11,
                "nombre" => "A.T. BOSQUES DE DURAZNOS",
                "identificador" => "11.208",
                "area_principal_id" => Area::where("identificador", "11.2")->first()->area_id,  
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 12,
                "nombre" => "A.T. CIEN METROS",
                "identificador" => "11.209",
                "area_principal_id" => Area::where("identificador", "11.2")->first()->area_id,  
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 13,
                "nombre" => "A.T. CORUÑA",
                "identificador" => "11.210",
                "area_principal_id" => Area::where("identificador", "11.2")->first()->area_id,  
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 14,
                "nombre" => "A.T. MEYEHUALCO",
                "identificador" => "11.211",
                "area_principal_id" => Area::where("identificador", "11.2")->first()->area_id,  
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 15,
                "nombre" => "A.T. MINA",
                "identificador" => "11.212",
                "area_principal_id" => Area::where("identificador", "11.2")->first()->area_id,  
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 16,
                "nombre" => "A.T. PARQUE LIRA",
                "identificador" => "11.213",
                "area_principal_id" => Area::where("identificador", "11.2")->first()->area_id,  
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 17,
                "nombre" => "A.T. SAN ANTONIO",
                "identificador" => "11.214",
                "area_principal_id" => Area::where("identificador", "11.2")->first()->area_id,  
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 18,
                "nombre" => "A.T. SAN BORJA",
                "identificador" => "11.215",
                "area_principal_id" => Area::where("identificador", "11.2")->first()->area_id,  
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 19,
                "nombre" => "A.T. TAXQUEÑA",
                "identificador" => "11.216",
                "area_principal_id" => Area::where("identificador", "11.2")->first()->area_id,  
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 20,
                "nombre" => "A.T. FERRERÍA",
                "identificador" => "11.217",
                "area_principal_id" => Area::where("identificador", "11.2")->first()->area_id,  
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 21,
                "nombre" => "A.T. TEPEYAC",
                "identificador" => "11.218",
                "area_principal_id" => Area::where("identificador", "11.2")->first()->area_id,  
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 22,
                "nombre" => "A.T. TEZONCO",
                "identificador" => "11.219",
                "area_principal_id" => Area::where("identificador", "11.2")->first()->area_id,  
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 23,
                "nombre" => "A.T. TEZONTLE",
                "identificador" => "11.220",
                "area_principal_id" => Area::where("identificador", "11.2")->first()->area_id,  
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 24,
                "nombre" => "A.T. XOCHIMILCO",
                "identificador" => "11.221",
                "area_principal_id" => Area::where("identificador", "11.2")->first()->area_id,  
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 25,
                "nombre" => "A.T. ACOXPA",
                "identificador" => "11.222",
                "area_principal_id" => Area::where("identificador", "11.2")->first()->area_id,  
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 26,
                "nombre" => "A.T. ACOXPA",
                "identificador" => "11.223",
                "area_principal_id" => Area::where("identificador", "11.2")->first()->area_id,  
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 27,
                "nombre" => "A.T. PERISUR",
                "identificador" => "11.224",
                "area_principal_id" => Area::where("identificador", "11.2")->first()->area_id,  
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 28,
                "nombre" => "SUBDIRECCIÓN DE ENLACE ADMINISTRATIVO EN LA SUBTESORERÍA DE ADMINISTRACIÓN TRIBUTARIA",
                "identificador" => "11.225",
                "area_principal_id" => Area::where("identificador", "11.2")->first()->area_id,  
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 29,
                "nombre" => "S.A.T.",
                "identificador" => "11.226",
                "area_principal_id" => Area::where("identificador", "11.2")->first()->area_id,  
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 30,
                "nombre" => "S.A.T.",
                "identificador" => "11.227",
                "area_principal_id" => Area::where("identificador", "11.2")->first()->area_id,  
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 31,
                "nombre" => "S.A.T.",
                "identificador" => "11.228",
                "area_principal_id" => Area::where("identificador", "11.2")->first()->area_id,  
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 32,
                "nombre" => "SAN JERONIMO",
                "identificador" => "11.229",
                "area_principal_id" => Area::where("identificador", "11.2")->first()->area_id,  
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 33,
                "nombre" => "SUBTESORERIA DE ADMON. TRIBUTARIA",
                "identificador" => "11.230",
                "area_principal_id" => Area::where("identificador", "11.2")->first()->area_id,  
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);

        Area::create([
            "area_id" => 34,
            "nombre" => "SUBTESORERÍA DE FISCALIZACIÓN",
            "identificador" => "11.3",
            "area_principal_id" => NULL,  
            "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
            "tipo" => "AREA_PRINCIPAL"
        ]);
            Area::create([
                "area_id" => 35,
                "nombre" => "INICIADOR INCIDENCIAS",
                "identificador" => "11.301",
                "area_principal_id" => Area::where("identificador", "11.3")->first()->area_id,  
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 36,
                "nombre" => "S.E.A EN FISCALIZACIÓN - DIR.REVIS.FISCALES",
                "identificador" => "11.302",
                "area_principal_id" => Area::where("identificador", "11.3")->first()->area_id,  
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 37,
                "nombre" => "S.E.A EN FISCALIZACIÓN - DIR.AUDIT.DIRECTAS",
                "identificador" => "11.303",
                "area_principal_id" => Area::where("identificador", "11.3")->first()->area_id,  
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 38,
                "nombre" => "JUD EN FISCALIZACIÓN - DIR.REVIS.FISCALES",
                "identificador" => "11.304",
                "area_principal_id" => Area::where("identificador", "11.3")->first()->area_id,  
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 39,
                "nombre" => "A.T. SAN BORJA SUBTESORERÍA DE FISCALIZACIÓN",
                "identificador" => "11.305",
                "area_principal_id" => Area::where("identificador", "11.3")->first()->area_id,  
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 40,
                "nombre" => "JUD EN FISCALIZACIÓN - SUBDIR. Y JUD DE ESPECT.PÚBLICOS",
                "identificador" => "11.306",
                "area_principal_id" => Area::where("identificador", "11.3")->first()->area_id,  
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 41,
                "nombre" => "JUD EN FISCALIZACIÓN - DIR.REVIS.FISCALES",
                "identificador" => "11.307",
                "area_principal_id" => Area::where("identificador", "11.3")->first()->area_id,  
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 42,
                "nombre" => "S.E.A. EN FISCALIZACIÓN - DIR.EJECUTIVA DE COBRANZA",
                "identificador" => "11.308",
                "area_principal_id" => Area::where("identificador", "11.3")->first()->area_id,  
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 43,
                "nombre" => "JUD EN FISCALIZACIÓN - DIR. DE PROG.Y CONTROL DE AUDITORIAS",
                "identificador" => "11.309",
                "area_principal_id" => Area::where("identificador", "11.3")->first()->area_id,  
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 44,
                "nombre" => "JUD EN FISCALIZACIÓN - DIR. DE PROG.Y CONTROL DE AUDITORIAS",
                "identificador" => "11.310",
                "area_principal_id" => Area::where("identificador", "11.3")->first()->area_id,  
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 45,
                "nombre" => "JUD EN FISCALIZACIÓN - DIR. DE PROG.Y CONTROL DE AUDITORIAS",
                "identificador" => "11.311",
                "area_principal_id" => Area::where("identificador", "11.3")->first()->area_id,  
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 46,
                "nombre" => "A.T. FERRERÍA SUBTESORERÍA DE FISCALIZACIÓN",
                "identificador" => "11.312",
                "area_principal_id" => Area::where("identificador", "11.3")->first()->area_id,  
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 47,
                "nombre" => "A.T. ANÁHUAC SUBTESORERÍA DE FISCALIZACIÓN",
                "identificador" => "11.313",
                "area_principal_id" => Area::where("identificador", "11.3")->first()->area_id,  
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 48,
                "nombre" => "A.T. ARAGÓN SUBTESORERÍA DE FISCALIZACIÓN",
                "identificador" => "11.314",
                "area_principal_id" => Area::where("identificador", "11.3")->first()->area_id,  
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 49,
                "nombre" => "A.T. TEPEYAC SUBTESORERÍA DE FISCALIZACIÓN",
                "identificador" => "11.315",
                "area_principal_id" => Area::where("identificador", "11.3")->first()->area_id,  
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 50,
                "nombre" => "A.T. PERISUR SUBTESORERÍA DE FISCALIZACIÓN",
                "identificador" => "11.316",
                "area_principal_id" => Area::where("identificador", "11.3")->first()->area_id,  
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 51,
                "nombre" => "A.T. TAXQUEÑA SUBTESORERÍA DE FISCALIZACIÓN",
                "identificador" => "11.317",
                "area_principal_id" => Area::where("identificador", "11.3")->first()->area_id,  
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 52,
                "nombre" => "A.T. TEZONTLE SUBTESORERÍA DE FISCALIZACIÓN",
                "identificador" => "11.318",
                "area_principal_id" => Area::where("identificador", "11.3")->first()->area_id,  
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 53,
                "nombre" => "A.T. SAN JERÓNIMO SUBTESORERÍA DE FISCALIZACIÓN",
                "identificador" => "11.319",
                "area_principal_id" => Area::where("identificador", "11.3")->first()->area_id,  
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 54,
                "nombre" => "A.T. SAN LÁZARO SUBTESORERÍA DE FISCALIZACIÓN",
                "identificador" => "11.320",
                "area_principal_id" => Area::where("identificador", "11.3")->first()->area_id,  
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 55,
                "nombre" => "A.T. PARQUE LIRA SUBTESORERÍA DE FISCALIZACIÓN",
                "identificador" => "11.321",
                "area_principal_id" => Area::where("identificador", "11.3")->first()->area_id,  
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 56,
                "nombre" => "A.T. ACOXPA SUBTESORERÍA DE FISCALIZACIÓN",
                "identificador" => "11.322",
                "area_principal_id" => Area::where("identificador", "11.3")->first()->area_id,  
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 57,
                "nombre" => "A.T. CENTRO MÉDICO SUBTESORERÍA DE FISCALIZACIÓN",
                "identificador" => "11.323",
                "area_principal_id" => Area::where("identificador", "11.3")->first()->area_id,  
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 58,
                "nombre" => "A.T. XOCHIMILCO SUBTESORERÍA DE FISCALIZACIÓN",
                "identificador" => "11.324",
                "area_principal_id" => Area::where("identificador", "11.3")->first()->area_id,  
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 59,
                "nombre" => "A.T. TEZONCO SUBTESORERÍA DE FISCALIZACIÓN",
                "identificador" => "11.325",
                "area_principal_id" => Area::where("identificador", "11.3")->first()->area_id,  
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 60,
                "nombre" => "A.T. CORUÑA SUBTESORERÍA DE FISCALIZACIÓN",
                "identificador" => "11.326",
                "area_principal_id" => Area::where("identificador", "11.3")->first()->area_id,  
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 61,
                "nombre" => "A.T. BENITO JUÁREZ SUBTESORERÍA DE FISCALIZACIÓN",
                "identificador" => "11.327",
                "area_principal_id" => Area::where("identificador", "11.3")->first()->area_id,  
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 62,
                "nombre" => "S.E.A. EN FISCALIZACIÓN - DIR.EJECUTIVA DE COBRANZA",
                "identificador" => "11.328",
                "area_principal_id" => Area::where("identificador", "11.3")->first()->area_id,  
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 63,
                "nombre" => "FISCALIZACION",
                "identificador" => "11.329",
                "area_principal_id" => Area::where("identificador", "11.3")->first()->area_id,  
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 64,
                "nombre" => "S.E.A. EN FISCALIZACIÓN - RD Y COMISIONES SINDICALES",
                "identificador" => "11.330",
                "area_principal_id" => Area::where("identificador", "11.3")->first()->area_id,  
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 65,
                "nombre" => "S.E.A. EN FISCALIZACIÓN - RD Y COMISIONES SINDICALES",
                "identificador" => "11.331",
                "area_principal_id" => Area::where("identificador", "11.3")->first()->area_id,  
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 66,
                "nombre" => "JUD DE ENLACE ADMINISTRATIVO EN LA SUBTESORERÍA DE FISCALIZACIÓN",
                "identificador" => "11.332",
                "area_principal_id" => Area::where("identificador", "11.3")->first()->area_id,  
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 67,
                "nombre" => "JUD EN FISCALIZACIÓN - DIR.REVIS.FISCALES",
                "identificador" => "11.333",
                "area_principal_id" => Area::where("identificador", "11.3")->first()->area_id,  
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 68,
                "nombre" => "A.T. CIEN METROS SUBTESORERÍA DE FISCALIZACIÓN",
                "identificador" => "11.334",
                "area_principal_id" => Area::where("identificador", "11.3")->first()->area_id,  
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 69,
                "nombre" => "JUD EN FISCALIZACIÓN DIRECCIÓN DE AUDITORÍAS DIRECTAS JUD AUDITORIAS 1A 1C 2C 3C",
                "identificador" => "11.335",
                "area_principal_id" => Area::where("identificador", "11.3")->first()->area_id,  
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 70,
                "nombre" => "S.E.A EN FISCALIZACIÓN DIRECCIÓN DE AUDITORÍAS DIRECTAS JUD AUDITORIAS 1B 3A 3B",
                "identificador" => "11.336",
                "area_principal_id" => Area::where("identificador", "11.3")->first()->area_id,  
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 71,
                "nombre" => "JUD EN FISCALIZACIÓN",
                "identificador" => "11.337",
                "area_principal_id" => Area::where("identificador", "11.3")->first()->area_id,  
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 72,
                "nombre" => "JUD EN FISCALIZACIÓN",
                "identificador" => "11.338",
                "area_principal_id" => Area::where("identificador", "11.3")->first()->area_id,  
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 73,
                "nombre" => "S.E.A. EN FISCALIZACIÓN",
                "identificador" => "11.339",
                "area_principal_id" => Area::where("identificador", "11.3")->first()->area_id,  
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 74,
                "nombre" => "S.E.A. EN FISCALIZACIÓN",
                "identificador" => "11.340",
                "area_principal_id" => Area::where("identificador", "11.3")->first()->area_id,  
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 75,
                "nombre" => "S.E.A. EN FISCALIZACIÓN",
                "identificador" => "11.341",
                "area_principal_id" => Area::where("identificador", "11.3")->first()->area_id,  
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 76,
                "nombre" => "S.E.A. EN FISCALIZACIÓN",
                "identificador" => "11.342",
                "area_principal_id" => Area::where("identificador", "11.3")->first()->area_id,  
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 77,
                "nombre" => "S.E.A. EN FISCALIZACIÓN",
                "identificador" => "11.343",
                "area_principal_id" => Area::where("identificador", "11.3")->first()->area_id,  
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 78,
                "nombre" => "S.E.A. EN FISCALIZACIÓN",
                "identificador" => "11.344",
                "area_principal_id" => Area::where("identificador", "11.3")->first()->area_id,  
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 79,
                "nombre" => "S.E.A. EN FISCALIZACIÓN",
                "identificador" => "11.345",
                "area_principal_id" => Area::where("identificador", "11.3")->first()->area_id,  
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 80,
                "nombre" => "S.E.A. EN FISCALIZACIÓN",
                "identificador" => "11.346",
                "area_principal_id" => Area::where("identificador", "11.3")->first()->area_id,  
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
        Area::create([
            "area_id" => 81,
            "nombre" => "SUBTESORERÍA DE CATASTRO Y PADRÓN TERRITORIAL",
            "identificador" => "11.4",
            "area_principal_id" => NULL,  
            "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
            "tipo" => "AREA_PRINCIPAL"
        ]);
        Area::create([
            "area_id" => 82,
            "nombre" => "COORDINACIÓN EJECUTIVA DE VERIFICACIÓN DE COMERCIO EXTERIOR",
            "identificador" => "11.5",
            "area_principal_id" => NULL,  
            "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
            "tipo" => "AREA_PRINCIPAL"
        ]);
        Area::create([
            "area_id" => 83,
            "nombre" => "SUBDIRECCIÓN DE PRESTACIONES Y POLÍTICA LABORAL",
            "identificador" => "11.6",
            "area_principal_id" => NULL,  
            "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "11")->first()->unidad_administrativa_id,
            "tipo" => "AREA_PRINCIPAL"
        ]);

        // 137
        Area::create([
            "area_id" => 84,
            "nombre" => "DIRECCIÓN GENERAL DE ADMINISTRACIÓN",
            "identificador" => "137",
            "area_principal_id" => NULL, 
            "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "137")->first()->unidad_administrativa_id,
            "tipo" => "AREA_PRINCIPAL",
        ]);
            Area::create([
                "area_id" => 85,
                "nombre" => "DIRECCIÓN GENERAL DE ADMINISTRACIÓN",
                "identificador" => "137.001",
                "area_principal_id" => Area::where("identificador", "137")->first()->area_id,   
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "137")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 86,
                "nombre" => "DIRECCIÓN GENERAL DE ADMINISTRACIÓN",
                "identificador" => "137.002",
                "area_principal_id" => Area::where("identificador", "137")->first()->area_id,   
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "137")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 87,
                "nombre" => "DIRECCIÓN GENERAL DE ADMINISTRACIÓN",
                "identificador" => "137.003",
                "area_principal_id" => Area::where("identificador", "137")->first()->area_id,   
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "137")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 88,
                "nombre" => "DIRECCIÓN GENERAL DE ADMINISTRACIÓN",
                "identificador" => "137.004",
                "area_principal_id" => Area::where("identificador", "137")->first()->area_id,   
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "137")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 89,
                "nombre" => "DIRECCIÓN GENERAL DE ADMINISTRACIÓN",
                "identificador" => "137.005",
                "area_principal_id" => Area::where("identificador", "137")->first()->area_id,   
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "137")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 90,
                "nombre" => "DIRECCIÓN GENERAL DE ADMINISTRACIÓN",
                "identificador" => "137.006",
                "area_principal_id" => Area::where("identificador", "137")->first()->area_id,   
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "137")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            
        Area::create([
            "area_id" => 91,
            "nombre" => "SUBSECRETARÍA DE PLANEACIÓN FINANCIERA",
            "identificador" => "137.1",
            "area_principal_id" => NULL,  
            "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "137")->first()->unidad_administrativa_id,
            "tipo" => "AREA_PRINCIPAL"
        ]);

        Area::create([
            "area_id" => 92,
            "nombre" => "DIRECCIÓN GENERAL DE ADMINISTRACIÓN",
            "identificador" => "137.2",
            "area_principal_id" => NULL,  
            "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "137")->first()->unidad_administrativa_id,
            "tipo" => "AREA_PRINCIPAL"
        ]);
            Area::create([
                "area_id" => 93,
                "nombre" => "DIRECCIÓN GENERAL DE ADMINISTRACIÓN",
                "identificador" => "137.201",
                "area_principal_id" => Area::where("identificador", "137.2")->first()->area_id,   
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "137")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 94,
                "nombre" => "DIRECCIÓN GENERAL DE ADMINISTRACIÓN - RECURSOS FINANCIEROS",
                "identificador" => "137.202",
                "area_principal_id" => Area::where("identificador", "137.2")->first()->area_id,   
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "137")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 95,
                "nombre" => "DIRECCIÓN GENERAL DE ADMINISTRACIÓN - DIRECCIÓN DE SERVICIOS GENERALES",
                "identificador" => "137.203",
                "area_principal_id" => Area::where("identificador", "137.2")->first()->area_id,   
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "137")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 96,
                "nombre" => "DIRECCIÓN GENERAL DE ADMINISTRACIÓN - DIRECCIÓN DE RECURSOS MATERIALES",
                "identificador" => "137.204",
                "area_principal_id" => Area::where("identificador", "137.2")->first()->area_id,   
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "137")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 97,
                "nombre" => "DIRECCIÓN GENERAL DE ADMINISTRACIÓN - DIRECCIÓN DE RECURSOS HUMANOS",
                "identificador" => "137.205",
                "area_principal_id" => Area::where("identificador", "137.2")->first()->area_id,   
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "137")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 98,
                "nombre" => "DIRECCIÓN GENERAL DE ADMINISTRACIÓN - SUBDIRECCIÓN DE NÓMINAS Y MOVIMIENTOS DE PERSONAL",
                "identificador" => "137.206",
                "area_principal_id" => Area::where("identificador", "137.2")->first()->area_id,   
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "137")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 99,
                "nombre" => "DIRECCIÓN GENERAL DE ADMINISTRACIÓN - DIRECCIÓN DE SERVICIOS GENERALES",
                "identificador" => "137.207",
                "area_principal_id" => Area::where("identificador", "137.2")->first()->area_id,   
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "137")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 100,
                "nombre" => "DIRECCIÓN GENERAL DE ADMINISTRACIÓN - INCIDENCIAS Y ASISTENCIA DGA",
                "identificador" => "137.208",
                "area_principal_id" => Area::where("identificador", "137.2")->first()->area_id,   
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "137")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
        
        Area::create([
            "area_id" => 101,
            "nombre" => "DIRECCIÓN DE RECURSOS FINANCIEROS",
            "identificador" => "137.3",
            "area_principal_id" => NULL,  
            "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "137")->first()->unidad_administrativa_id,
            "tipo" => "AREA_PRINCIPAL"
        ]);
        Area::create([
            "area_id" => 102,
            "nombre" => "DIRECCIÓN DE SERVICIOS GENERALES",
            "identificador" => "137.4",
            "area_principal_id" => NULL,  
            "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "137")->first()->unidad_administrativa_id,
            "tipo" => "AREA_PRINCIPAL"
        ]);
        Area::create([
            "area_id" => 103,
            "nombre" => "DIRECCIÓN DE RECURSOS MATERIALES",
            "identificador" => "137.5",
            "area_principal_id" => NULL,  
            "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "137")->first()->unidad_administrativa_id,
            "tipo" => "AREA_PRINCIPAL"
        ]);
        Area::create([
            "area_id" => 104,
            "nombre" => "APOYO NORMATIVO D.G.A.",
            "identificador" => "137.6",
            "area_principal_id" => NULL,  
            "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "137")->first()->unidad_administrativa_id,
            "tipo" => "AREA_PRINCIPAL"
        ]);
        Area::create([
            "area_id" => 105,
            "nombre" => "SUBDIRECCIÓN DE PRESTACIONES Y POLITICA LABORAL",
            "identificador" => "137.7",
            "area_principal_id" => NULL,  
            "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "137")->first()->unidad_administrativa_id,
            "tipo" => "AREA_PRINCIPAL"
        ]);
        
        // 138
        Area::create([
            "area_id" => 106,
            "nombre" => "DIRECCIÓN GENERAL DE TECNOLOGIAS Y COMUNICACIONES",
            "identificador" => "138",
            "area_principal_id" => NULL, 
            "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "138")->first()->unidad_administrativa_id,
            "tipo" => "AREA_PRINCIPAL",
        ]);
        Area::create([
            "area_id" => 107,
            "nombre" => "SUBDIRECCIÓN DE PRESTACIONES Y POLÍTICA LABORAL",
            "identificador" => "138.1",
            "area_principal_id" => NULL, 
            "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "138")->first()->unidad_administrativa_id,
            "tipo" => "AREA_PRINCIPAL"
        ]);
        
        // 139
        Area::create([
            "area_id" => 108,
            "nombre" => "UNIDAD DE INTELIGENCIA FINANCIERA EN EL D.F.",
            "identificador" => "139",
            "area_principal_id" => NULL, 
            "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "139")->first()->unidad_administrativa_id,
            "tipo" => "AREA_PRINCIPAL",
        ]);

        // 14
        Area::create([
            "area_id" => 109,
            "nombre" => "SUBSECRETARÍA DE EGRESOS",
            "identificador" => "14",
            "area_principal_id" => NULL, 
            "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "14")->first()->unidad_administrativa_id,
            "tipo" => "AREA_PRINCIPAL",
        ]);
        Area::create([
            "area_id" => 110,
            "nombre" => "DIRECCIÓN GENERAL DE POLÍTICA PRESUPUESTAL",
            "identificador" => "14.1",
            "area_principal_id" => NULL, 
            "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "14")->first()->unidad_administrativa_id,
            "tipo" => "AREA_PRINCIPAL"
        ]);
        Area::create([
            "area_id" => 111,
            "nombre" => "DIRECCIÓN GENERAL DE CONTABILIDAD, NORMATIVIDAD Y CUENTA PÚBLICA",
            "identificador" => "14.2",
            "area_principal_id" => NULL, 
            "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "14")->first()->unidad_administrativa_id,
            "tipo" => "AREA_PRINCIPAL"
        ]);
        Area::create([
            "area_id" => 112,
            "nombre" => "DIRECCIÓN GENERAL DE EGRESOS A",
            "identificador" => "14.3",
            "area_principal_id" => NULL, 
            "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "14")->first()->unidad_administrativa_id,
            "tipo" => "AREA_PRINCIPAL"
        ]);
        Area::create([
            "area_id" => 113,
            "nombre" => "DIRECCIÓN GENERAL DE EGRESOS B",
            "identificador" => "14.4",
            "area_principal_id" => NULL, 
            "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "14")->first()->unidad_administrativa_id,
            "tipo" => "AREA_PRINCIPAL"
        ]);
        Area::create([
            "area_id" => 114,
            "nombre" => "SUBDIRECCIÓN DE PRESTACIONES Y POLÍTICA LABORAL",
            "identificador" => "14.5",
            "area_principal_id" => NULL, 
            "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "14")->first()->unidad_administrativa_id,
            "tipo" => "AREA_PRINCIPAL"
        ]);

        // 160
        Area::create([
            "area_id" => 115,
            "nombre" => "SECRETARIA DE ADMINISTRACIÓN Y FINANZAS - 160",
            "identificador" => "160",
            "area_principal_id" => NULL, 
            "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "160")->first()->unidad_administrativa_id,
            "tipo" => "AREA_PRINCIPAL",
        ]);
        
        // 162
        Area::create([
            "area_id" => 116,
            "nombre" => "COORDINACIÓN DE EVALUACIÓN,MODERNIZACIÓN Y DESARROLLO ADMINISTRATIVO",
            "identificador" => "162",
            "area_principal_id" => NULL, 
            "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "162")->first()->unidad_administrativa_id,
            "tipo" => "AREA_PRINCIPAL",
        ]);
       
        // 169
        Area::create([
            "area_id" => 117,
            "nombre" => "DIRECCIÓN GENERAL DE COMUNICACIÓN CIUDADANA",
            "identificador" => "169",
            "area_principal_id" => NULL, 
            "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "169")->first()->unidad_administrativa_id,
            "tipo" => "AREA_PRINCIPAL",
        ]);
        Area::create([
            "area_id" => 118,
            "nombre" => "SUBDIRECCIÓN DE PRESTACIONES Y POLÍTICA LABORAL",
            "identificador" => "169.1",
            "area_principal_id" => NULL, 
            "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "169")->first()->unidad_administrativa_id,
            "tipo" => "AREA_PRINCIPAL"
        ]);
        
        // 18
        Area::create([
            "area_id" => 119,
            "nombre" => "DIRECCIÓN GENERAL DE PATRIMONIO INMOBILIARIO",
            "identificador" => "18",
            "area_principal_id" => NULL, 
            "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "18")->first()->unidad_administrativa_id,
            "tipo" => "AREA_PRINCIPAL",
        ]);
        Area::create([
            "area_id" => 120,
            "nombre" => "SUBDIRECCIÓN DE PRESTACIONES Y POLÍTICA LABORAL",
            "identificador" => "18.1",
            "area_principal_id" => NULL, 
            "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "18")->first()->unidad_administrativa_id,
            "tipo" => "AREA_PRINCIPAL"
        ]);
        
        // 199
        Area::create([
            "area_id" => 121,
            "nombre" => "SUBSECRETARIA DE ADMINISTRACION Y CAPITAL HUMANO",
            "identificador" => "199",
            "area_principal_id" => NULL, 
            "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "199")->first()->unidad_administrativa_id,
            "tipo" => "AREA_PRINCIPAL",
        ]);
        Area::create([
            "area_id" => 122,
            "nombre" => "SUBDIRECCIÓN DE PRESTACIONES Y POLÍTICA LABORAL",
            "identificador" => "199.1",
            "area_principal_id" => NULL, 
            "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "199")->first()->unidad_administrativa_id,
            "tipo" => "AREA_PRINCIPAL"
        ]);
        
        // 200
        Area::create([
            "area_id" => 123,
            "nombre" => "DIRECCIÓN GENERAL DE ENLACE,COORDICACIÓN FISCAL Y PROGRAMAS FEDERALES",
            "identificador" => "200",
            "area_principal_id" => NULL, 
            "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "200")->first()->unidad_administrativa_id,
            "tipo" => "AREA_PRINCIPAL",
        ]);
        
        // 2020
        Area::create([
            "area_id" => 124,
            "nombre" => "UA PARA USUARIOS EXTERNOS",
            "identificador" => "2020",
            "area_principal_id" => NULL, 
            "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "2020")->first()->unidad_administrativa_id,
            "tipo" => "AREA_PRINCIPAL",
        ]);

        // 3
        Area::create([
            "area_id" => 125,
            "nombre" => "OFICINA DE LA C. SECRETARIA DE ADMINISTRACIÓN Y FINANZAS",
            "identificador" => "3",
            "area_principal_id" => NULL, 
            "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "3")->first()->unidad_administrativa_id,
            "tipo" => "AREA_PRINCIPAL",
        ]);
        Area::create([
            "area_id" => 126,
            "nombre" => "OFICINA DE LA C. SECRETARIA DE ADMINISTRACIÓN Y FINANZAS",
            "identificador" => "3.1",
            "area_principal_id" => NULL,  
            "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "3")->first()->unidad_administrativa_id,
            "tipo" => "AREA_PRINCIPAL"
        ]);
            Area::create([
                "area_id" => 127,
                "nombre" => "OFICINA DE LA C. SECRETARIA DE ADMINISTRACIÓN Y FINANZAS",
                "identificador" => "3.101",
                "area_principal_id" => Area::where("identificador", "3.1")->first()->area_id,    
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "3")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 128,
                "nombre" => "OFICINA DE LA C. SECRETARIA DE ADMINISTRACIÓN Y FINANZAS",
                "identificador" => "3.102",
                "area_principal_id" => Area::where("identificador", "3.1")->first()->area_id,    
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "3")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 129,
                "nombre" => "OFICINA DE LA C. SECRETARIA DE ADMINISTRACIÓN Y FINANZAS",
                "identificador" => "3.103",
                "area_principal_id" => Area::where("identificador", "3.1")->first()->area_id,     
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "3")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 130,
                "nombre" => "OFICINA DE LA C. SECRETARIA DE ADMINISTRACIÓN Y FINANZAS",
                "identificador" => "3.104",
                "area_principal_id" => Area::where("identificador", "3.1")->first()->area_id,     
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "3")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 131,
                "nombre" => "OFICINA DE LA C. SECRETARIA DE ADMINISTRACIÓN Y FINANZAS",
                "identificador" => "3.105",
                "area_principal_id" => Area::where("identificador", "3.1")->first()->area_id,    
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "3")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 132,
                "nombre" => "OFICINA DE LA C. SECRETARIA DE ADMINISTRACIÓN Y FINANZAS",
                "identificador" => "3.106",
                "area_principal_id" => Area::where("identificador", "3.1")->first()->area_id,    
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "3")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 133,
                "nombre" => "OFICINA DE LA C. SECRETARIA DE ADMINISTRACIÓN Y FINANZAS",
                "identificador" => "3.107",
                "area_principal_id" => Area::where("identificador", "3.1")->first()->area_id,    
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "3")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
            Area::create([
                "area_id" => 134,
                "nombre" => "OFICINA DE LA C. SECRETARIA DE ADMINISTRACIÓN Y FINANZAS",
                "identificador" => "3.108",
                "area_principal_id" => Area::where("identificador", "3.1")->first()->area_id,     
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "3")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
        Area::create([
            "area_id" => 135,
            "nombre" => "SUBDIRECCIÓN DE PRESTACIONES Y POLITICA LABORAL",
            "identificador" => "3.2",
            "area_principal_id" => NULL,  
            "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "3")->first()->unidad_administrativa_id,
            "tipo" => "AREA_PRINCIPAL"
        ]);
            Area::create([
                "area_id" => 136,
                "nombre" => "OFICINA DE LA C. SECRETARIA DE ADMINISTRACIÓN Y FINANZAS",
                "identificador" => "3.201",
                "area_principal_id" => Area::where("identificador", "3.2")->first()->area_id,    
                "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "3")->first()->unidad_administrativa_id,
                "tipo" => "SUBAREA"
            ]);
        
        // 44
        Area::create([
            "area_id" => 137,
            "nombre" => "DIRECCIÓN GENERAL DE RECURSOS MATERIALES Y SERVICIOS GENERALES",
            "identificador" => "44",
            "area_principal_id" => NULL, 
            "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "44")->first()->unidad_administrativa_id,
            "tipo" => "AREA_PRINCIPAL",
        ]);
        Area::create([
            "area_id" => 138,
            "nombre" => "SUBDIRECCIÓN DE PRESTACIONES Y POLITICA LABORAL",
            "identificador" => "44.1",
            "area_principal_id" => NULL, 
            "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "44")->first()->unidad_administrativa_id,
            "tipo" => "AREA_PRINCIPAL"
        ]);
        
        // 5
        Area::create([
            "area_id" => 139,
            "nombre" => "SECRETARIA DE ADMINISTRACIÓN Y FINANZAS - OM",
            "identificador" => "5",
            "area_principal_id" => NULL, 
            "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "5")->first()->unidad_administrativa_id,
            "tipo" => "AREA_PRINCIPAL",
        ]);
        
        // 95
        Area::create([
            "area_id" => 140,
            "nombre" => "PROCURADURÍA FISCAL DE LA CIUDAD DE MÉXICO",
            "identificador" => "95",
            "area_principal_id" => NULL, 
            "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "95")->first()->unidad_administrativa_id,
            "tipo" => "AREA_PRINCIPAL",
        ]);
        Area::create([
            "area_id" => 141,
            "nombre" => "CONTRALORÍA INTERNA",
            "identificador" => "95.1",
            "area_principal_id" => NULL, 
            "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "95")->first()->unidad_administrativa_id,
            "tipo" => "AREA_PRINCIPAL"
        ]);
        Area::create([
            "area_id" => 142,
            "nombre" => "SUBDIRECCIÓN DE PRESTACIONES Y POLÍTICA LABORAL",
            "identificador" => "95.2",
            "area_principal_id" => NULL, 
            "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "95")->first()->unidad_administrativa_id,
            "tipo" => "AREA_PRINCIPAL"
        ]);
        
        // 999
        Area::create([
            "area_id" => 143,
            "nombre" => "DIRECCIÓN GENERAL DE ADMINISTRACIÓN",
            "identificador" => "999",
            "area_principal_id" => NULL, 
            "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "999")->first()->unidad_administrativa_id,
            "tipo" => "AREA_PRINCIPAL",
        ]);
        Area::create([
            "area_id" => 144,
            "nombre" => "RECURSOS HUMANOS",
            "identificador" => "999.1",
            "area_principal_id" => NULL,  
            "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "999")->first()->unidad_administrativa_id,
            "tipo" => "AREA_PRINCIPAL"
        ]);
        Area::create([
            "area_id" => 145,
            "nombre" => "RECURSOS HUMANOS",
            "identificador" => "999.11",
            "area_principal_id" => NULL,  
            "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "999")->first()->unidad_administrativa_id,
            "tipo" => "AREA_PRINCIPAL"
        ]);
        Area::create([
            "area_id" => 146,
            "nombre" => "RECURSOS HUMANOS",
            "identificador" => "999.12",
            "area_principal_id" => NULL,  
            "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "999")->first()->unidad_administrativa_id,
            "tipo" => "AREA_PRINCIPAL"
        ]);
        Area::create([
            "area_id" => 147,
            "nombre" => "RECURSOS HUMANOS",
            "identificador" => "999.13",
            "area_principal_id" => NULL,  
            "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "999")->first()->unidad_administrativa_id,
            "tipo" => "AREA_PRINCIPAL"
        ]);
        Area::create([
            "area_id" => 148,
            "nombre" => "RECURSOS HUMANOS",
            "identificador" => "999.14",
            "area_principal_id" => NULL,  
            "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "999")->first()->unidad_administrativa_id,
            "tipo" => "AREA_PRINCIPAL"
        ]);
        Area::create([
            "area_id" => 149,
            "nombre" => "RECURSOS FINANCIEROS",
            "identificador" => "999.2",
            "area_principal_id" => NULL,  
            "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "999")->first()->unidad_administrativa_id,
            "tipo" => "AREA_PRINCIPAL"
        ]);
        Area::create([
            "area_id" => 150,
            "nombre" => "DIRECCIÓN SERVICIOS GENERALES",
            "identificador" => "999.3",
            "area_principal_id" => NULL,  
            "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "999")->first()->unidad_administrativa_id,
            "tipo" => "AREA_PRINCIPAL"
        ]);
        Area::create([
            "area_id" => 151,
            "nombre" => "SERVICIOS GENERALES",
            "identificador" => "999.4",
            "area_principal_id" => NULL,  
            "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "999")->first()->unidad_administrativa_id,
            "tipo" => "AREA_PRINCIPAL"
        ]);
        Area::create([
            "area_id" => 152,
            "nombre" => "SUBDIRECCIÓN DE NÓMINAS Y MOVIMIENTOS DE PERSONAL",
            "identificador" => "999.5",
            "area_principal_id" => NULL,  
            "unidad_administrativa_id" => UnidadAdministrativa::where("identificador", "999")->first()->unidad_administrativa_id,
            "tipo" => "AREA_PRINCIPAL"
        ]);
        DB::statement("SELECT setval(pg_get_serial_sequence('areas', 'area_id'), coalesce(max(area_id), 1), max(area_id) IS NOT null) FROM areas");
    }
}
