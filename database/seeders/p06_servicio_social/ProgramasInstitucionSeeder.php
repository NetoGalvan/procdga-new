<?php

namespace Database\Seeders\p06_servicio_social;

use Illuminate\Database\Seeder;
use App\Models\p06_servicio_social\P06ProgramasInstitucion;
use App\Models\p06_servicio_social\P06Instituciones;

class ProgramasInstitucionSeeder extends Seeder
{
    public function run()
    {
        $remplazar = ['á' => 'Á', 'é' => 'É', 'í' => 'Í', 'ó' => 'Ó', 'ú' => 'Ú', 'ñ' => 'Ñ'];

        # UNAM -->
        $unam = P06Instituciones::firstWhere('clave_institucion', 'UNAM');
        $programasUNAM = [
            "$unam->clave_institucion-CFMI" => "Ciencias Físico - Matemáticas y de las Ingenierías",
            "$unam->clave_institucion-CBQS" => "Ciencias Biológicas, Químicas y de la Salud",
            "$unam->clave_institucion-CS" => "Ciencias Sociales",
            "$unam->clave_institucion-HA" => "Humanidades y de las Artes"
        ];
        foreach ($programasUNAM as $clave => $programa) {
            P06ProgramasInstitucion::create([
                'institucion_id' => $unam->institucion_id,
                'nombre_programa' => strtr( strtoupper($programa), $remplazar ),
                'clave_programa' => $clave,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        # UNAM <--
        # UAM -->
        $uam = P06Instituciones::firstWhere('clave_institucion', 'UAM');
        $programasUAM = [
            "$uam->clave_institucion-CBI" => "Ciencias Básicas e Ingeniería",
            "$uam->clave_institucion-CSH" => "Ciencias Sociales y Humanidades",
            "$uam->clave_institucion-CAD" => "Ciencias y Artes para el Diseño",
            "$uam->clave_institucion-CBS" => "Ciencias Biológicas y de la Salud",
            "$uam->clave_institucion-CNI" => "Ciencias Naturales e Ingeniería",
            "$uam->clave_institucion-CCD" => "Ciencias de la Comunicación y Diseño"
        ];
        foreach ($programasUAM as $clave => $programa) {
            P06ProgramasInstitucion::create([
                'institucion_id' => $uam->institucion_id,
                'nombre_programa' => strtr( strtoupper($programa), $remplazar ),
                'clave_programa' => $clave,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        # UAM <--
        # UAEM -->
        $uaem = P06Instituciones::firstWhere('clave_institucion', 'UAEM');
        $programasUAEM = [
            "$uaem->clave_institucion-AH" => "Artes y Humanidades",
            "$uaem->clave_institucion-CNEC" => "Ciencias Naturales, Exactas y de la Computación",
            "$uaem->clave_institucion-CSA" => "Ciencias Sociales, Administración",
            "$uaem->clave_institucion-IMC" => "Ingeniería, Manufactura y Construcción",
            "$uaem->clave_institucion-AV" => "Agronomía y Veterinaria",
            "$uaem->clave_institucion-SALUD" => "Salud",
            "$uaem->clave_institucion-EDUC" => "Educación",
            "$uaem->clave_institucion-SERV" => "Servicios"
        ];
        foreach ($programasUAEM as $clave => $programa) {
            P06ProgramasInstitucion::create([
                'institucion_id' => $uaem->institucion_id,
                'nombre_programa' => strtr( strtoupper($programa), $remplazar ),
                'clave_programa' => $clave,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        # UAEM <--
        # IPN -->
        $ipn = P06Instituciones::firstWhere('clave_institucion', 'IPN');
        $programasIPN = [
            "$ipn->clave_institucion-ICFM" => "Ingeniería y Ciencias Físico Matemáticas",
            "$ipn->clave_institucion-CMB" => "Ciencias Médico Biológicas",
            "$ipn->clave_institucion-CSA" => "Ciencias Sociales y Administrativas"
        ];
        foreach ($programasIPN as $clave => $programa) {
            P06ProgramasInstitucion::create([
                'institucion_id' => $ipn->institucion_id,
                'nombre_programa' => strtr( strtoupper($programa), $remplazar ),
                'clave_programa' => $clave,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        # IPN <--
        # TECNM -->
        $tecnm = P06Instituciones::firstWhere('clave_institucion', 'TECNM');
        $programasTECNM = [
            "$tecnm->clave_institucion-ING" => "Ingeniería",
            "$tecnm->clave_institucion-ARQ" => "arquitectura",
            "$tecnm->clave_institucion-CONT" => "contaduria",
            "$tecnm->clave_institucion-GASTR" => "gastronomÍa"
        ];
        foreach ($programasTECNM as $clave => $programa) {
            P06ProgramasInstitucion::create([
                'institucion_id' => $tecnm->institucion_id,
                'nombre_programa' => strtr( strtoupper($programa), $remplazar ),
                'clave_programa' => $clave,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        # TECNM <--
        # COLBACH -->
        $colbach = P06Instituciones::firstWhere('clave_institucion', 'COLBACH');
        $programasCOLBACH = [
            "$colbach->clave_institucion-CONT" => "Contabilidad",
            "$colbach->clave_institucion-TUR" => "Turismo",
            "$colbach->clave_institucion-QUIM" => "Química",
            "$colbach->clave_institucion-RH" => "Recursos Humanos",
            "$colbach->clave_institucion-ARQ" => "Arquitectura",
            "$colbach->clave_institucion-INFORM" => "Informática"
        ];
        foreach ($programasCOLBACH as $clave => $programa) {
            P06ProgramasInstitucion::create([
                'institucion_id' => $colbach->institucion_id,
                'nombre_programa' => strtr( strtoupper($programa), $remplazar ),
                'clave_programa' => $clave,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        # COLBACH <--
        # CETIS -->
        $cetis = P06Instituciones::firstWhere('clave_institucion', 'DGETI');
        $programasCETIS = [
            "$cetis->clave_institucion-FM" => "Físico - matemática",
            "$cetis->clave_institucion-QBE" => "Químico - biológica y Económico",
            "$cetis->clave_institucion-ADTVA" => "administrativa"
        ];
        foreach ($programasCETIS as $clave => $programa) {
            P06ProgramasInstitucion::create([
                'institucion_id' => $cetis->institucion_id,
                'nombre_programa' => strtr( strtoupper($programa), $remplazar ),
                'clave_programa' => $clave,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        # CETIS <--
        # DGETA (CBTA, CBTF) -->
        $dgeta = P06Instituciones::firstWhere('clave_institucion', 'DGETA');
        $programasDGETA = [
            "$dgeta->clave_institucion-OFIMATICA" => "oficina y de informática",
            "$dgeta->clave_institucion-CONT" => "contabilidad",
            "$dgeta->clave_institucion-AGROP" => "agropecuario"
        ];
        foreach ($programasDGETA as $clave => $programa) {
            P06ProgramasInstitucion::create([
                'institucion_id' => $dgeta->institucion_id,
                'nombre_programa' => strtr( strtoupper($programa), $remplazar ),
                'clave_programa' => $clave,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        # DGETA (CBTA, CBTF) <--
        # CONALEP -->
        $conalep = P06Instituciones::firstWhere('clave_institucion', 'CONALEP');
        $programasCONALEP = [
            "$conalep->clave_institucion-FA" => "Contaduría y Administración",
            "$conalep->clave_institucion-TUR" => "Turismo",
            "$conalep->clave_institucion-MI" => "Mantenimiento e Instalación",
            "$conalep->clave_institucion-PT" => "Producción y Transformación",
            "$conalep->clave_institucion-EE" => "Electricidad y Electrónica",
            "$conalep->clave_institucion-SALUD" => "Salud",
            "$conalep->clave_institucion-TT" => "Tecnología y Transporte"


        ];
        foreach ($programasCONALEP as $clave => $programa) {
            P06ProgramasInstitucion::create([
                'institucion_id' => $conalep->institucion_id,
                'nombre_programa' => strtr( strtoupper($programa), $remplazar ),
                'clave_programa' => $clave,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        # CONALEP <--
        # UVM -->
        $uvm = P06Instituciones::firstWhere('clave_institucion', 'UVM');
        $programasUVM = [
            "$uvm->clave_institucion-ING" => "INGENIERÍA",
            "$uvm->clave_institucion-CCS" => "CIENCIAS DE LA SALUD",
            "$uvm->clave_institucion-CS" => "CIENCIAS SOCIALES",
            "$uvm->clave_institucion-DA" => "DISEÑO Y ARQUITECTURA",
            "$uvm->clave_institucion-THG" => "TURISMO, HOSPITALIDAD Y gastronomía",
            "$uvm->clave_institucion-NEG" => "NEGOCIOS",
        ];
        foreach ($programasUVM as $clave => $programa) {
            P06ProgramasInstitucion::create([
                'institucion_id' => $uvm->institucion_id,
                'nombre_programa' => strtr( strtoupper($programa), $remplazar ),
                'clave_programa' => $clave,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        # UVM <--
        # UNITEC -->
        $unitec = P06Instituciones::firstWhere('clave_institucion', 'UNITEC');
        $programasUNITEC = [
            "$unitec->clave_institucion-ING" => "INGENIERÍA",
            "$unitec->clave_institucion-ADMON" => "ADMINISTRACIÓN",
            "$unitec->clave_institucion-COM" => "comercio",
            "$unitec->clave_institucion-CONT" => "contaduria",
            "$unitec->clave_institucion-PEDAG" => "pedagogía",
            "$unitec->clave_institucion-PSICOL" => "psicología",
            "$unitec->clave_institucion-NEG" => "negocios",
        ];
        foreach ($programasUNITEC as $clave => $programa) {
            P06ProgramasInstitucion::create([
                'institucion_id' => $unitec->institucion_id,
                'nombre_programa' => strtr( strtoupper($programa), $remplazar ),
                'clave_programa' => $clave,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        # UNITEC <--
        # UNILA -->
        $unila = P06Instituciones::firstWhere('clave_institucion', 'UNILA');
        $programasUNILA = [
            "$unila->clave_institucion-DCHO" => "derecho",
            "$unila->clave_institucion-ADMON" => "ADMINISTRACIÓN",
            "$unila->clave_institucion-INFORM" => "Informática",
            "$unila->clave_institucion-GASTR" => "gastronomía",
            "$unila->clave_institucion-PEDAG" => "pedagogía",
            "$unila->clave_institucion-PSICOL" => "psicología",
            "$unila->clave_institucion-NEG" => "negocios",
            "$unila->clave_institucion-CONT" => "contaduria",
            "$unila->clave_institucion-CC" => "ciencias de la Comunicación",
        ];
        foreach ($programasUNILA as $clave => $programa) {
            P06ProgramasInstitucion::create([
                'institucion_id' => $unila->institucion_id,
                'nombre_programa' => strtr( strtoupper($programa), $remplazar ),
                'clave_programa' => $clave,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        # UNILA <--
        # UNIMEX -->
        $unimex = P06Instituciones::firstWhere('clave_institucion', 'UNIMEX');
        $programasUNIMEX = [
            "$unimex->clave_institucion-DCHO" => "derecho",
            "$unimex->clave_institucion-ADMON" => "ADMINISTRACIÓN",
            "$unimex->clave_institucion-GASTR" => "gastronomía",
            "$unimex->clave_institucion-PSICOL" => "psicología",
            "$unimex->clave_institucion-CONT" => "contaduria",
            "$unimex->clave_institucion-COM" => "comercio",
        ];
        foreach ($programasUNIMEX as $clave => $programa) {
            P06ProgramasInstitucion::create([
                'institucion_id' => $unimex->institucion_id,
                'nombre_programa' => strtr( strtoupper($programa), $remplazar ),
                'clave_programa' => $clave,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        # UNIMEX <--
        # UPEM -->
        $upem = P06Instituciones::firstWhere('clave_institucion', 'UPEM');
        $programasUPEM = [
            "$upem->clave_institucion-UARH" => "unidad de artes y Humanidades",
            "$upem->clave_institucion-UESA" => "unidad Económico SOCIAL administratiVO",
            "$upem->clave_institucion-UMU" => "unidad MEDICA UPEM"
        ];
        foreach ($programasUPEM as $clave => $programa) {
            P06ProgramasInstitucion::create([
                'institucion_id' => $upem->institucion_id,
                'nombre_programa' => strtr( strtoupper($programa), $remplazar ),
                'clave_programa' => $clave,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        # UPEM <--
        # ULSA -->
        $ulsa = P06Instituciones::firstWhere('clave_institucion', 'ULSA');
        $programasULSA = [
            "$ulsa->clave_institucion-NEG" => "NEGOCIOS",
            "$ulsa->clave_institucion-ADC" => "arquitectura, diseño y comunicación",
            "$ulsa->clave_institucion-SALUD" => "Salud",
            "$ulsa->clave_institucion-CS" => "ciencias sociales",
            "$ulsa->clave_institucion-DCHO" => "derecho",
            "$ulsa->clave_institucion-ING" => "ingeniería",
            "$ulsa->clave_institucion-CQ" => "ciencias quimicas",
            "$ulsa->clave_institucion-MED" => "medicina"
        ];
        foreach ($programasULSA as $clave => $programa) {
            P06ProgramasInstitucion::create([
                'institucion_id' => $ulsa->institucion_id,
                'nombre_programa' => strtr( strtoupper($programa), $remplazar ),
                'clave_programa' => $clave,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        # ULSA <-- 
        # CECATI -->
        $cecati = P06Instituciones::firstWhere('clave_institucion', 'DGCFT');
        $programasCECATI = [
            "$cecati->clave_institucion-ECON" => "económico",
            "$cecati->clave_institucion-PROD" => "productivo",
            "$cecati->clave_institucion-SC" => "social - cultural",
            "$cecati->clave_institucion-EDUC" => "educativo"
        ];
        foreach ($programasCECATI as $clave => $programa) {
            P06ProgramasInstitucion::create([
                'institucion_id' => $cecati->institucion_id,
                'nombre_programa' => strtr( strtoupper($programa), $remplazar ),
                'clave_programa' => $clave,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        # CECATI <--
        # UTC -->
        $utc = P06Instituciones::firstWhere('clave_institucion', 'UTC');
        $programasUTC = [
            "$utc->clave_institucion-AQ" => "arquitectura y diseño",
            "$utc->clave_institucion-GN" => "gerencia y negocios",
            "$utc->clave_institucion-IT" => "Ingenierías y Tecnologías",
            "$utc->clave_institucion-NE" => "negocios y empresariales",
            "$utc->clave_institucion-SALUD" => "salud",
            "$utc->clave_institucion-SJ" => "sociales y jurídicas"
        ];
        foreach ($programasUTC as $clave => $programa) {
            P06ProgramasInstitucion::create([
                'institucion_id' => $utc->institucion_id,
                'nombre_programa' => strtr( strtoupper($programa), $remplazar ),
                'clave_programa' => $clave,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        # UTC <--
        # EBC -->
        $ebc = P06Instituciones::firstWhere('clave_institucion', 'EBC');
        $programasEBC = [
            "$ebc->clave_institucion-CS" => "CIENCIAS SOCIALES"
        ];
        foreach ($programasEBC as $clave => $programa) {
            P06ProgramasInstitucion::create([
                'institucion_id' => $ebc->institucion_id,
                'nombre_programa' => strtr( strtoupper($programa), $remplazar ),
                'clave_programa' => $clave,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        # EBC <--
        # UMB -->
        $umb = P06Instituciones::firstWhere('clave_institucion', 'UMB');
        $programasUMB = [
            "$umb->clave_institucion-DCHO" => "derecho",
            "$umb->clave_institucion-SALUD" => "salud",
            "$umb->clave_institucion-TG" => "turismo y gastronomia",
            "$umb->clave_institucion-CS" => "ciencias sociales",
            "$umb->clave_institucion-ING" => "ingeniería"
        ];
        foreach ($programasUMB as $clave => $programa) {
            P06ProgramasInstitucion::create([
                'institucion_id' => $umb->institucion_id,
                'nombre_programa' => strtr( strtoupper($programa), $remplazar ),
                'clave_programa' => $clave,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        # UMB <--
        # SECTEI -->
        $sectei = P06Instituciones::firstWhere('clave_institucion', 'SECTEI');
        $programasSECTEI = [
            "$sectei->clave_institucion-EE" => "Electricidad - Electrónica",
            "$sectei->clave_institucion-DCHO" => "derecho",
            "$sectei->clave_institucion-EN" => "economía y negocios",
            "$sectei->clave_institucion-CS" => "ciencias sociales",
            "$sectei->clave_institucion-CA" => "CIENCIAS AMBIENTALES",
            "$sectei->clave_institucion-DIS" => "DISEÑO",
            "$sectei->clave_institucion-INFORM" => "INFORMÁTICA"
        ];
        foreach ($programasSECTEI as $clave => $programa) {
            P06ProgramasInstitucion::create([
                'institucion_id' => $sectei->institucion_id,
                'nombre_programa' => strtr( strtoupper($programa), $remplazar ),
                'clave_programa' => $clave,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        # SECTEI <--
        # ANAHUAC -->
        $anahuac = P06Instituciones::firstWhere('clave_institucion', 'ANAHUAC');
        $programasANAHUAC = [
            "$anahuac->clave_institucion-ING" => "INGENIERÍA",
            "$anahuac->clave_institucion-ARQ" => "arquitectura",
            "$anahuac->clave_institucion-ACT" => "actuaría",
            "$anahuac->clave_institucion-DCHO" => "derecho",
            "$anahuac->clave_institucion-ART" => "artes",
            "$anahuac->clave_institucion-CCS" => "Ciencias de la salud",
            "$anahuac->clave_institucion-DIS" => "diseño",
            "$anahuac->clave_institucion-DD" => "dirección del deporte",
            "$anahuac->clave_institucion-CE" => "comunicación y entretenimiento",
            "$anahuac->clave_institucion-EN" => "economía y negocios",
            "$anahuac->clave_institucion-EGRI" => "estudios globales y relaciones internacionales",
            "$anahuac->clave_institucion-EH" => "educación y humanidades",
            "$anahuac->clave_institucion-PSICOL" => "psicología",
            "$anahuac->clave_institucion-RS" => "responsabilidad social",
            "$anahuac->clave_institucion-TG" => "turismo y gastronomía"
        ];
        foreach ($programasANAHUAC as $clave => $programa) {
            P06ProgramasInstitucion::create([
                'institucion_id' => $anahuac->institucion_id,
                'nombre_programa' => strtr( strtoupper($programa), $remplazar ),
                'clave_programa' => $clave,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        # ANAHUAC <--
        # UIN -->
        $uin = P06Instituciones::firstWhere('clave_institucion', 'UIN');
        $programasUIN = [
            "$uin->clave_institucion-AD" => "arquitectura y diseño",
            "$uin->clave_institucion-EA" => "económico administrativo",
            "$uin->clave_institucion-IT" => "informatica y Tecnología",
            "$uin->clave_institucion-CM" => "comunicación y mercadotecnia",
            "$uin->clave_institucion-CS" => "ciencias sociales",
            "$uin->clave_institucion-SI" => "salud e Ingeniería"
        ];
        foreach ($programasUIN as $clave => $programa) {
            P06ProgramasInstitucion::create([
                'institucion_id' => $uin->institucion_id,
                'nombre_programa' => strtr( strtoupper($programa), $remplazar ),
                'clave_programa' => $clave,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        # UIN <--
        # ETAC -->
        $etac = P06Instituciones::firstWhere('clave_institucion', 'ETAC');
        $programasETAC = [
            "$etac->clave_institucion-CS" => "ciencias sociales",
            "$etac->clave_institucion-CCS" => "ciencias de la salud",
            "$etac->clave_institucion-AD" => "arquitectura y diseño",
            "$etac->clave_institucion-EGRI" => "estudios globales y relaciones internacionales",
            "$etac->clave_institucion-ING" => "ingenieria",
            "$etac->clave_institucion-DCHO" => "derecho"
        ];
        foreach ($programasETAC as $clave => $programa) {
            P06ProgramasInstitucion::create([
                'institucion_id' => $etac->institucion_id,
                'nombre_programa' => strtr( strtoupper($programa), $remplazar ),
                'clave_programa' => $clave,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        # ETAC <--
        # ICEL -->
        $icel = P06Instituciones::firstWhere('clave_institucion', 'ICEL');
        $programasICEL = [
            "$icel->clave_institucion-CCS" => "Ciencias de la salud",
            "$icel->clave_institucion-ING" => "ingeniería",
            "$icel->clave_institucion-AD" => "arquitectura y diseño",
            "$icel->clave_institucion-TG" => "turismo y gastronomía",
            "$icel->clave_institucion-CS" => "ciencias sociales"
        ];
        foreach ($programasICEL as $clave => $programa) {
            P06ProgramasInstitucion::create([
                'institucion_id' => $icel->institucion_id,
                'nombre_programa' => strtr( strtoupper($programa), $remplazar ),
                'clave_programa' => $clave,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        # ICEL <--
        # ULA -->
        $ula = P06Instituciones::firstWhere('clave_institucion', 'ULA');
        $programasULA = [
            "$ula->clave_institucion-CCS" => "Ciencias de la salud",
            "$ula->clave_institucion-EP" => "educación y pedagogía",
            "$ula->clave_institucion-DA" => "diseño y arquitectura",
            "$ula->clave_institucion-IT" => "ingeniería y Tecnología",
            "$ula->clave_institucion-CS" => "ciencias sociales y jurídicas",
            "$ula->clave_institucion-NE" => "negocios y empresariales"  
        ];
        foreach ($programasULA as $clave => $programa) {
            P06ProgramasInstitucion::create([
                'institucion_id' => $ula->institucion_id,
                'nombre_programa' => strtr( strtoupper($programa), $remplazar ),
                'clave_programa' => $clave,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        # ULA <--
        # CESCIJUC -->
        $cescijuc = P06Instituciones::firstWhere('clave_institucion', 'CESCIJUC');
        $programasCESCIJUC = [
            "$cescijuc->clave_institucion-CS" => "Ciencias sociales",
            "$cescijuc->clave_institucion-DCHO" => "derecho",
            "$cescijuc->clave_institucion-ING" => "ingeniería"  
        ];
        foreach ($programasCESCIJUC as $clave => $programa) {
            P06ProgramasInstitucion::create([
                'institucion_id' => $cescijuc->institucion_id,
                'nombre_programa' => strtr( strtoupper($programa), $remplazar ),
                'clave_programa' => $clave,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        # CESCIJUC <--
        # ITC -->
        $itc = P06Instituciones::firstWhere('clave_institucion', 'ITC');
        $programasITC = [
            "$itc->clave_institucion-ARQ" => "arquitectura",
            "$itc->clave_institucion-ING" => "ingeniería"  
        ];
        foreach ($programasITC as $clave => $programa) {
            P06ProgramasInstitucion::create([
                'institucion_id' => $itc->institucion_id,
                'nombre_programa' => strtr( strtoupper($programa), $remplazar ),
                'clave_programa' => $clave,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        # ITC <--
        # UNIREM -->
        $unirem = P06Instituciones::firstWhere('clave_institucion', 'UNIREM');
        $programasUNIREM = [
            "$unirem->clave_institucion-AD" => "arquitectura y diseño",
            "$unirem->clave_institucion-CS" => "ciencias sociales",
            "$unirem->clave_institucion-CCS" => "ciencias de la salud",
            "$unirem->clave_institucion-DCHO" => "derecho",
            "$unirem->clave_institucion-ING" => "ingeniería"     
        ];
        foreach ($programasUNIREM as $clave => $programa) {
            P06ProgramasInstitucion::create([
                'institucion_id' => $unirem->institucion_id,
                'nombre_programa' => strtr( strtoupper($programa), $remplazar ),
                'clave_programa' => $clave,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        # UNIREM <--
        # BNA -->
        $bna = P06Instituciones::firstWhere('clave_institucion', 'BNA');
        $programasBNA = [
            "$bna->clave_institucion-DJ" => "derecho y jurídico"  
        ];
        foreach ($programasBNA as $clave => $programa) {
            P06ProgramasInstitucion::create([
                'institucion_id' => $bna->institucion_id,
                'nombre_programa' => strtr( strtoupper($programa), $remplazar ),
                'clave_programa' => $clave,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        # BNA <--
        # UMA -->
        $uma = P06Instituciones::firstWhere('clave_institucion', 'UMA');
        $programasUMA = [
            "$uma->clave_institucion-AD" => "arquitectura y diseño",
            "$uma->clave_institucion-CS" => "ciencias sociales",
            "$uma->clave_institucion-DCHO" => "derecho",
            "$uma->clave_institucion-ING" => "ingeniería",
            "$uma->clave_institucion-ACT" => "actuaría"    
        ];
        foreach ($programasUMA as $clave => $programa) {
            P06ProgramasInstitucion::create([
                'institucion_id' => $uma->institucion_id,
                'nombre_programa' => strtr( strtoupper($programa), $remplazar ),
                'clave_programa' => $clave,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        # UMA <--
        # UMAR -->
        $umar = P06Instituciones::firstWhere('clave_institucion', 'UMAR');
        $programasUMAR = [
            "$umar->clave_institucion-CS" => "ciencias sociales",
            "$umar->clave_institucion-ACT" => "actuaría"
        ];
        foreach ($programasUMAR as $clave => $programa) {
            P06ProgramasInstitucion::create([
                'institucion_id' => $umar->institucion_id,
                'nombre_programa' => strtr( strtoupper($programa), $remplazar ),
                'clave_programa' => $clave,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        # UMAR <--
        # UH -->
        $uh = P06Instituciones::firstWhere('clave_institucion', 'UH');
        $programasUH = [
            "$uh->clave_institucion-ADMON" => "administración",
            "$uh->clave_institucion-ARQ" => "arquitectura",
            "$uh->clave_institucion-AT" => "arte y teatro",
            "$uh->clave_institucion-CP" => "ciencias políticas",
            "$uh->clave_institucion-CONT" => "Contabilidad",
            "$uh->clave_institucion-DCHO" => "derecho",
            "$uh->clave_institucion-DG" => "diseño gráfico",
            "$uh->clave_institucion-EP" => "educación y psicología"
        ];
        foreach ($programasUH as $clave => $programa) {
            P06ProgramasInstitucion::create([
                'institucion_id' => $uh->institucion_id,
                'nombre_programa' => strtr( strtoupper($programa), $remplazar ),
                'clave_programa' => $clave,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        # UH <--
        # UJS -->
        $ujs = P06Instituciones::firstWhere('clave_institucion', 'UJS');
        $programasUJS = [
            "$ujs->clave_institucion-CS" => "ciencias sociales",
            "$ujs->clave_institucion-TG" => "turismo y gastronomía",
            "$ujs->clave_institucion-CCS" => "ciencias de la salud",
            "$ujs->clave_institucion-ING" => "ingeniería",
            "$ujs->clave_institucion-AD" => "arquitectura y diseño"
        ];
        foreach ($programasUJS as $clave => $programa) {
            P06ProgramasInstitucion::create([
                'institucion_id' => $ujs->institucion_id,
                'nombre_programa' => strtr( strtoupper($programa), $remplazar ),
                'clave_programa' => $clave,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        # UJS <--
        # CEEC -->
        $ceec = P06Instituciones::firstWhere('clave_institucion', 'CEEC');
        $programasCEEC = [
            "$ceec->clave_institucion-DCHO" => "derecho",
            "$ceec->clave_institucion-ADMON" => "administración"  
        ];
        foreach ($programasCEEC as $clave => $programa) {
            P06ProgramasInstitucion::create([
                'institucion_id' => $ceec->institucion_id,
                'nombre_programa' => strtr( strtoupper($programa), $remplazar ),
                'clave_programa' => $clave,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        # CEEC <--
        # UNIVDEP -->
        $univdep = P06Instituciones::firstWhere('clave_institucion', 'UNIVDEP');
        $programasUNIVDEP = [
            "$univdep->clave_institucion-EMP" => "empresariales",
            "$univdep->clave_institucion-HUM" => "humanidades"  
        ];
        foreach ($programasUNIVDEP as $clave => $programa) {
            P06ProgramasInstitucion::create([
                'institucion_id' => $univdep->institucion_id,
                'nombre_programa' => strtr( strtoupper($programa), $remplazar ),
                'clave_programa' => $clave,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        # UNIVDEP <--
        # ALPHA -->
        $alpha = P06Instituciones::firstWhere('clave_institucion', 'ALPHA');
        $programasALPHA = [
            "$alpha->clave_institucion-INFORM" => "Informática",
            "$alpha->clave_institucion-SALUD" => "salud"  
        ];
        foreach ($programasALPHA as $clave => $programa) {
            P06ProgramasInstitucion::create([
                'institucion_id' => $alpha->institucion_id,
                'nombre_programa' => strtr( strtoupper($programa), $remplazar ),
                'clave_programa' => $clave,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        # ALPHA <--
        # ICATI -->
        $icati = P06Instituciones::firstWhere('clave_institucion', 'ICATI');
        $programasICATI = [
            "$icati->clave_institucion-EE" => "Electricidad - Electrónica",
            "$icati->clave_institucion-INFORM" => "Informática",
            "$icati->clave_institucion-CONT" => "Contabilidad",
            "$icati->clave_institucion-GASTR" => "gastronomía"
        ];
        foreach ($programasICATI as $clave => $programa) {
            P06ProgramasInstitucion::create([
                'institucion_id' => $icati->institucion_id,
                'nombre_programa' => strtr( strtoupper($programa), $remplazar ),
                'clave_programa' => $clave,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        # ICATI <--
        # CUGS -->
        $cugs = P06Instituciones::firstWhere('clave_institucion', 'CUGS');
        $programasCUGS = [
            "$cugs->clave_institucion-CS" => "ciencias sociales",
            "$cugs->clave_institucion-TG" => "turismo y gastronomía",
            "$cugs->clave_institucion-DIS" => "diseño",
            "$cugs->clave_institucion-EGRI" => "estudios globales y relaciones internacionales",
            "$cugs->clave_institucion-ING" => "ingenieria",
            "$cugs->clave_institucion-DCHO" => "derecho"
        ];
        foreach ($programasCUGS as $clave => $programa) {
            P06ProgramasInstitucion::create([
                'institucion_id' => $cugs->institucion_id,
                'nombre_programa' => strtr( strtoupper($programa), $remplazar ),
                'clave_programa' => $clave,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        # CUGS <--
        # ECCC -->
        $eccc = P06Instituciones::firstWhere('clave_institucion', 'ECCC');
        $programasECCC = [
            "$eccc->clave_institucion-ADMON" => "administración",
            "$eccc->clave_institucion-CONT" => "contador",
            "$eccc->clave_institucion-DCHO" => "derecho"
        ];
        foreach ($programasECCC as $clave => $programa) {
            P06ProgramasInstitucion::create([
                'institucion_id' => $eccc->institucion_id,
                'nombre_programa' => strtr( strtoupper($programa), $remplazar ),
                'clave_programa' => $clave,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        # ECCC <--
        # GVA -->
        $gva = P06Instituciones::firstWhere('clave_institucion', 'GVA');
        $programasGVA = [
            "$gva->clave_institucion-CONT" => "Contaduría"
        ];
        foreach ($programasGVA as $clave => $programa) {
            P06ProgramasInstitucion::create([
                'institucion_id' => $gva->institucion_id,
                'nombre_programa' => strtr( strtoupper($programa), $remplazar ),
                'clave_programa' => $clave,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        # GVA <--
        # UDF -->
        $udf = P06Instituciones::firstWhere('clave_institucion', 'UDF');
        $programasUDF = [
            "$udf->clave_institucion-CS" => "ciencias sicales",
            "$udf->clave_institucion-II" => "ingeniería - Informática",
            "$udf->clave_institucion-DCHO" => "derecho",
            "$udf->clave_institucion-ADMON" => "administración",
            "$udf->clave_institucion-CC" => "ciencias de la Comunicación"
        ];
        foreach ($programasUDF as $clave => $programa) {
            P06ProgramasInstitucion::create([
                'institucion_id' => $udf->institucion_id,
                'nombre_programa' => strtr( strtoupper($programa), $remplazar ),
                'clave_programa' => $clave,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        # UDF <--
        # UNID -->
        $unid = P06Instituciones::firstWhere('clave_institucion', 'UNID');
        $programasUNID = [
            "$unid->clave_institucion-CS" => "ciencias sicales",
            "$unid->clave_institucion-ING" => "ingeniería",
            "$unid->clave_institucion-DCHO" => "derecho",
            "$unid->clave_institucion-ADMON" => "administración",
            "$unid->clave_institucion-CC" => "ciencias de la Comunicación",
            "$unid->clave_institucion-DJ" => "derecho y jurídicas",
            "$unid->clave_institucion-AD" => "arquitectura - diseño"
        ];
        foreach ($programasUNID as $clave => $programa) {
            P06ProgramasInstitucion::create([
                'institucion_id' => $unid->institucion_id,
                'nombre_programa' => strtr( strtoupper($programa), $remplazar ),
                'clave_programa' => $clave,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        # UNID <--
        # UIN -->
        $cuin = P06Instituciones::firstWhere('clave_institucion', 'CUIN');
        $programasCUIN = [
            "$cuin->clave_institucion-ADMON" => "administración",
            "$cuin->clave_institucion-DCHO" => "derecho"
        ];
        foreach ($programasCUIN as $clave => $programa) {
            P06ProgramasInstitucion::create([
                'institucion_id' => $cuin->institucion_id,
                'nombre_programa' => strtr( strtoupper($programa), $remplazar ),
                'clave_programa' => $clave,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        # UIN <--
    }
}
