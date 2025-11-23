<?php

namespace Database\Seeders\p06_servicio_social;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use App\Models\p06_servicio_social\P06Escuela;
use App\Models\p06_servicio_social\P06Instituciones;

use App\Models\historico\lbpm_dga\p06_servicio_social\HistoricoPrestador;
use App\Models\historico\lbpm_dga\p06_servicio_social\HistoricoEscuela;

class EscuelaSeeder extends Seeder
{
    public function run()
    {
        $remplazar = ['á' => 'Á', 'é' => 'É', 'í' => 'Í', 'ó' => 'Ó', 'ú' => 'Ú', 'ñ' => 'Ñ'];

        # UNAM -->
        $unam = P06Instituciones::firstWhere('clave_institucion', 'UNAM');
        $escuelasUNAM = [
            'FARQ' => ['FACULTAD DE ARQUITECTURA', 'ESCOLAR, CIUDAD UNIVERSITARIA, COYOACAN'],
            'FCIE' => ['FACULTAD DE CIENCIAS', 'INVEST. CIENTIFICA, CIUDAD UNIVERSITARIA, COYOACAN'],
            'FCPYS' => ['FACULTAD DE CIENCIAS POLÍTICAS Y SOCIALES', 'MARIO DE LA CUEVA, CIUDAD UNIVERSITARIA, COYOACAN'],
            'FCA' => ['FACULTAD DE CONTADURÍA Y ADMINISTRACIÓN', ' CTO. EXTERIOR, CIUDAD UNIVERSITARIA, COYOACAN'],
            'FDER' => ['FACULTAD DE DERECHO', 'ESCOLAR S/N, CIUDAD UNIVERSITARIA, COYOACAN'],
            'FECO' => ['FACULTAD DE ECONOMÍA', 'ESCOLAR, CIUDAD UNIVERSITARIA, COYOACAN'],
            'FING' => ['FACULTAD DE INGENIERÍA', 'ESCOLAR 04360, CIUDAD UNIVERSITARIA, COYOACAN'],
            'FES ACATLAN' => ['FACULTAD DE ESTUDIOS SUPERIORES ACATLÁN', 'STA. CRUZ ACATLÁN, 53150 NAUCALPAN DE JUAREZ'],
            'FES ARAGON' => ['FACULTAD DE ESTUDIOS SUPERIORES ARAGÓN', 'AV. UNIVERSIDAD NACIONAL S/N, BOSQUES DE AREGON, 57171 cdad. NEZAHUALCÓYOTL'],
            'FES CUAUTITLAN' => ['FACULTAD DE ESTUDIOS SUPERIORES CUAUTITLÁN', 'SAN SEBASTION XHALA, 54714 CUAUTITLÁN IZCALLI'],
            'FES IZTACALA' => ['FACULTAD DE ESTUDIOS SUPERIORES IZTACALA', 'AV. DE LOS BARRIOS 1, 54090 TLALNEPANTLA'],
            'FES ZARAGOZA' => ['FACULTAD DE ESTUDIOS SUPERIORES ZARAGOZA', 'AV. GUELATAO 66, IZTAPALAPA, 09230 CDMX'],
            'ENP 1' => ['ESCUELA NACIONAL PREPARATORIA 1 GABINO BARREDA', 'AV. DE LA NORAI, XOCHIMILCO, 16030 CDMX'],
            'ENP 2' => ['ESCUELA NACIONAL PREPARATORIA 2 ERASMO CASTELLANOS QUINTO', 'AV. RIO CHURUBUSCO 1418, IZTACALCO, 08040 CDMX'],
            'ENP 3' => ['ESCUELA NACIONAL PREPARATORIA 3 JUSTO SIERRA', 'EDUARDO MOLINA 1577, CONSTITUCION DE LA rep., GUSTAVO A. MADERO, 07469 CDMX'],
            'ENP 4' => ['ESCUELA NACIONAL PREPARATORIA 4 VIDAL CASTAÑEDA Y NÁJERA', 'AV. OBSERVATORIO 170, MIGUEL HIDALGO, 11860 CDMX'],
            'ENP 5' => ['ESCUELA NACIONAL PREPARATORIA 5 JOSÉ VASCONCELOS', 'CALZ. DEL HUESO 729, COAPA, TLALPAN, 14300 CDMX'],
            'ENP 6' => ['ESCUELA NACIONAL PREPARATORIA 6 ANTONIO CASO', 'CORINA 3-P. B, DEL CARMEN, COYOACAN, 04100 CDMX'],
            'ENP 7' => ['ESCUELA NACIONAL PREPARATORIA 7 EZEQUIEL A. CHÁVEZ', 'CALZ. DE LA VIGA 54-P. B, VENUSTIANO ctraANZA, 15810 CDMX'],
            'ENP 8' => ['ESCUELA NACIONAL PREPARATORIA 8 MIGUEL E. SCHULZ', 'AV. LOMAS DE PLATEROS S/N, ÁLVARO OBREGÓN, 01600 CDMX'],
            'ENP 9' => ['ESCUELA NACIONAL PREPARATORIA 9 PEDRO DE ALBA', 'AV. INSURGENTES NTE. 1698, GUSTAVO A. MADERO, 07300 CDMX'],
            'CCH AZCAPOTZALCO' => ['COLEGIO DE CIENCIAS Y HUMANIDADES AZCAPOTZALCO', 'AV. AQUILES SERDÁN 2060, AZCAPOTZALCO, 02420 CDMX'],
            'CCH NAUCALPAN' => ['COLEGIO DE CIENCIAS Y HUMANIDADES NAUCALPAN', 'CALZ. DE LOS REMEDIOS, 53458 NAUCALPAN DE JUAREZ'],
            'CCH ORIENTE' => ['COLEGIO DE CIENCIAS Y HUMANIDADES ORIENTE', 'AV. CANAL DE SAN JUAN ANILLO PERIFERICO S/N, IZTACALCO, 09210 CDMX'],
            'CCH SUR' => ['COLEGIO DE CIENCIAS Y HUMANIDADES SUR', 'BLVD. CATARATAS 3, JARDINES DEL PEDREGAL, COYOACAN, 01900 CDMX'],
            'CCH VALLEJO' => ['COLEGIO DE CIENCIAS Y HUMANIDADES VALLEJO', 'AV. 100 METROS, MAGDALENA DE LAS SALINAS, GUSTAVO A. MADERO, 07760 CDMX']
        ];
        foreach ($escuelasUNAM as $acronimo => $escuela) {
            P06Escuela::create([
                'institucion_id' => $unam->institucion_id,
                'nombre_escuela' => $escuela[0],
                'acronimo_escuela' => $acronimo,
                'direccion_escuela' => strtr( strtoupper($escuela[1]), $remplazar ),
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        # UNAM <--
        # UAM -->
        $uam = P06Instituciones::firstWhere('clave_institucion', 'UAM');
        $escuelasUAM = [ 
            'UAM AZCAPOTZALCO' => ['UNIVERSIDAD AUTÓNOMA METROPOLITANA AZCAPOTZALCO', 'Av. San Pablo No. 420 Col. Nueva el Rosario, Alcaldía Azcapotzalco, 02128 CDMX'],
            'UAM XOCHIMILCO' => ['UNIVERSIDAD AUTÓNOMA METROPOLITANA XOCHIMILCO', 'calz. del Hueso 1100, col. Villa Quietud, Alcaldía Coyoacán, 04960 CDMX.'],
            'UAM IZTAPALAPA' => ['UNIVERSIDAD AUTÓNOMA METROPOLITANA IZTAPALAPA', 'Av. Ferroctrail San Rafael Atlixco, No. 186, Col. Leyes de Reforma 1 A Sección, Alcaldía Iztapalapa, 09310 cdmx'],
            'UAM CUAJIMALPA' => ['UNIVERSIDAD AUTÓNOMA METROPOLITANA CUAJIMALPA', 'av. Vasco de Quiroga 4871, Col. Santa Fe Cuajimalpa. Alcaldía Cuajimalpa de Morelos, 05348 cdmx'],
            'UAM LERMA' => ['UNIVERSIDAD AUTÓNOMA METROPOLITANA LERMA', 'Av. de las Garzas No. 10, Col. El Panteón, Municipio Lerma de Villada, 52005 edo. de México']
        ];
        foreach ($escuelasUAM as $acronimo => $escuela) {
            P06Escuela::create([
                'institucion_id' => $uam->institucion_id,
                'nombre_escuela' => $escuela[0],
                'acronimo_escuela' => $acronimo,
                'direccion_escuela' => strtr( strtoupper($escuela[1]), $remplazar ),
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        # UAM <--
        # UAEM -->
        $uaem = P06Instituciones::firstWhere('clave_institucion', 'UAEM');
        $escuelasUAEM = [ 
            'UAEM ECATEPEC' => ['UNIVERSIDAD AUTÓNOMA DEL ESTADO DE MÉXICO ECATEPEC', 'José Revuelta 17, Tierra Blanca, 55020 Ecatepec de Morelos, México'],
            'UAEM NEZAHUALCOYOTL' => ['UNIVERSIDAD AUTÓNOMA DEL ESTADO DE MÉXICO NEZAHUALCÓYOTL', 'Av. Bordo de Xochiaca S/N, Benito Juárez, 57000 cdad. Nezahualcóyotl, México'],
            'UAEM TEXCOCO' => ['UNIVERSIDAD AUTÓNOMA DEL ESTADO DE MÉXICO TEXCOCO', '56259 Fracc, El Tejocote, 56259 Texcoco de Mora, México'],
            'UAEM VALLE DE CHALCO' => ['UNIVERSIDAD AUTÓNOMA DEL ESTADO DE MÉXICO VALLE DE CHALCO', 'Av. Hermenegildo Galeana 3, Santiago, 56615 Valle de Chalco Solidaridad, México'],
            'UAEM VALLE DE TEOTIHUACAN' => ['UNIVERSIDAD AUTÓNOMA DEL ESTADO DE MÉXICO VALLE DE TEOTIHUACAN', 'av. Principal S/N Poblado, 55955 Santo Domingo Aztacameca, México']
        ];
        foreach ($escuelasUAEM as $acronimo => $escuela) {
            P06Escuela::create([
                'institucion_id' => $uaem->institucion_id,
                'nombre_escuela' => $escuela[0],
                'acronimo_escuela' => $acronimo,
                'direccion_escuela' => strtr( strtoupper($escuela[1]), $remplazar ),
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        # UAEM <--
        # IPN -->
        $ipn = P06Instituciones::firstWhere('clave_institucion', 'IPN');
        $escuelasIPN = [ 
            'CECYT 1'=> ['CENTRO DE ESTUDIOS CIENTÍFICOS Y TECNOLÓGICOS 1 GONZALO VÁZQUEZ VELA', 'Av. 510 1000, Pueblo de San Juan de Aragón, Gustavo A. Madero, 07480 CDMX'],
            'CECYT 2'=> ['CENTRO DE ESTUDIOS CIENTÍFICOS Y TECNOLÓGICOS 2 MIGUEL BERNARD', 'Av. Río San Joaquín 133, Panteón Frances, Miguel Hidalgo, 11260 CDMX'],
            'CECYT 3'=> ['CENTRO DE ESTUDIOS CIENTÍFICOS Y TECNOLÓGICOS 3 ESTANISLAO RAMÍREZ RUIZ', 'mz. 027, 55118 Ecatepec de Morelos, México'],
            'CECYT 4'=> ['CENTRO DE ESTUDIOS CIENTÍFICOS Y TECNOLÓGICOS 4 LÁZARO CÁRDENAS', 'Av. Constituyentes 813, Belen de las Flores Reacomodo, Álvaro Obregón, 01110 CDMX'],
            'CECYT 5'=> ['CENTRO DE ESTUDIOS CIENTÍFICOS Y TECNOLÓGICOS 5 BENITO JUAREZ GARCIA', 'Emilio, col. Centro, Cuauhtémoc, 06040 CDMX'],
            'CECYT 6'=> ['CENTRO DE ESTUDIOS CIENTÍFICOS Y TECNOLÓGICOS 6 MIGUEL OTHON DE MENDIZABAL', 'C. 4 20, Col. del Gas, Azcapotzalco, 02950 CDMX'],
            'CECYT 7'=> ['CENTRO DE ESTUDIOS CIENTÍFICOS Y TECNOLÓGICOS 7 CUAUHTÉMOC', 'Ermita Iztapalapa 3241, Sta. María Aztahuacan, Iztapalapa 09500 CDMX'],
            'CECYT 8'=> ['CENTRO DE ESTUDIOS CIENTÍFICOS Y TECNOLÓGICOS 8 NARCISO BASSOLS', 'Av. de las Granjas 618, SANTO TOMÁS, Azcapotzalco, 02020 CDMX'],
            'CECYT 9'=> ['CENTRO DE ESTUDIOS CIENTÍFICOS Y TECNOLÓGICOS 9 JUAN DE DIOS BÁTIS', 'Mar Mediterráneo 227, Nextitla, Miguel Hidalgo, 11420 CDMX'],
            'CECYT 10' => ['CENTRO DE ESTUDIOS CIENTÍFICOS Y TECNOLÓGICOS 10 CARLOS VALLEJO MARQUEZ', 'Av. 508 s/n, Pueblo de San Juan de Aragón, Gustavo A. Madero, 07969 CDMX'],
            'CECYT 11' => ['CENTRO DE ESTUDIOS CIENTÍFICOS Y TECNOLÓGICOS 11 WILFRIDO MASSIEU PEREZ', 'Av. de los Maestros 217, Agricultura, Miguel Hidalgo, 11360 CDMX'],
            'CECYT 12' => ['CENTRO DE ESTUDIOS CIENTÍFICOS Y TECNOLÓGICOS 12 JOSÉ MARIA MORELOS Y PAVON', 'P.º de las Jacarandas 196, sta. María Insurgentes, Cuauhtémoc, 06430 CDMX'],
            'CECYT 13' => ['CENTRO DE ESTUDIOS CIENTÍFICOS Y TECNOLÓGICOS 13 RICARDO FLORES MAGON', 'Calz. Taxqueña 1620, Paseos de Taxqueña, Coyoacán, 04250 CDMX'],
            'CECYT 14' => ['CENTRO DE ESTUDIOS CIENTÍFICOS Y TECNOLÓGICOS 14 LUIS ENRRIQUE ERRO', 'Peluqueros S/N, Michoacana, Venustiano ctraanza, 15240 CDMX'],
            'CECYT 15'=> ['CENTRO DE ESTUDIOS CIENTÍFICOS Y TECNOLÓGICOS 15 DIODORO ANTÚNEZ ECHEGARAY', 'cdad. Gaston Melo 41, Tenantitla, Milpa Alta, 12100 San Antonio Tecómitl, CDMX'],
            'IMEP' => ['INSTITUTO MEXICANO DE EDUCACION PROFESIONAL PLANTEL SANTA MARTHA', 'Calz. Ignacio Zaragoza No. 3001, sta. Martha Acatitla, Iztapalapa, 09510 CDMX'],
            'ESIME AZCAPOTZALCO' => ['ESCUELA SUPERIOR DE INGENIERÍA MECÁNICA Y ELÉCTRICA AZCAPOTZALCO', 'Av. de las Granjas 682, STA. Catarina, Azcapotzalco, 02550 CDMX'],
            'ESIME CULHUACAN' => ['ESCUELA SUPERIOR DE INGENIERÍA MECÁNICA Y ELÉCTRICA CULHUACÁN', 'Av. Sta. Ana 1000, San Francisco CULHUACÁN, Coyoacán, 04440 CDMX'],
            'ESIME ZACATENCO' => ['ESCUELA SUPERIOR DE INGENIERÍA MECÁNICA Y ELÉCTRICA ZACATENCO', 'ud. Profesional, Av. Luis Enrique Erro, Adolfo López Mateos S/N, Zacatenco, Gustavo A. Madero, 07738 cdmx'],
            'ESIME TICOMAN' => ['ESCUELA SUPERIOR DE INGENIERÍA MECÁNICA Y ELÉCTRICA TICOMÁN', 'Calz. Ticomán 600, La Purísima TICOMÁN, Gustavo A. Madero, 07340 CDMX'],
            'ESCA TEPEPAN' => ['ESCUELA SUPERIOR DE COMERCIO Y ADMINISTRACIÓN TEPEPAN', '4863 Anillo Periférico, Sur Manuel Gómez Morín, Amp Tepepan, 16020 CDMX'],
            'ESCA SANTO TOMAS' => ['ESCUELA SUPERIOR DE COMERCIO Y ADMINISTRACIÓN SANTO TOMÁS', 'Manuel Carpio 471, Plutarco Elías c.s, Miguel Hidalgo, 11350 CDMX'],
            'ESIA TECAMACHALCO' => ['ESCUELA SUPERIOR DE INGENIERÍA Y ARQUITECTURA TECAMACHALCO', 'Av. Fuente de Los Leones 28, Lomas de Tecamachalco, 53950 Naucalpan de Juárez, México'],
            'ESIA TICOMAN' => ['ESCUELA SUPERIOR DE INGENIERÍA Y ARQUITECTURA TICOMÁN', 'Calz. Ticomán 55, La Laguna TICOMÁN, Gustavo A. Madero, 07340 CDMX'],
            'ESIA ZACATENCO' => ['ESCUELA SUPERIOR DE INGENIERÍA Y ARQUITECTURA ZACATENCO', 'Av. Juan de Dios Bátiz s/n, Adolfo López Mateos, Gustavo A. Madero, 07738 CDMX'],
            'ESE' => ['ESCUELA SUPERIOR DE ECONOMÍA', 'Av. Plan de Agua Prieta 66, Plutarco Elías c.s, Miguel Hidalgo, 11350 CDMX'],
            'ILB CENTRO' => ['INSTITUTO LEONARDO BRAVO PLANTEL CENTRO', 'Ezequiel Montes 115, Tabacalera, Cuauhtémoc, 06030 CDMX'],
            'ILB LA RAZA' => ['INSTITUTO LEONARDO BRAVO PLANTEL LA RAZA', 'C. Tetrazzini 148, Peralvillo, Cuauhtémoc, 06220 Ciudad de México, CDMX'],
            'ESFM' => ['ESCUELA SUPERIOR DE FÍSICA Y MATEMÁTICAS', 'av. ipn s/n Edificio 9 Unidad Profesional "Adolfo López Mateos" Col. San Pedro Zacatenco, Gustavo A. Madero, 07738 cdmx'],
            'ESCOM' => ['ESCUELA SUPERIOR DE CÓMPUTO', 'Av. Juan de Dios Bátiz, Nueva Industrial Vallejo, Gustavo A. Madero, 07320 CDMX'],
            'UPIICSA' => ['UNIDAD PROFESIONAL INTERDICIPLINARIA DE INGENIERÍA Y CIENCIAS SOCIALES Y ADMINISTRATIVAS', 'Av. Té 950, Granjas México, Iztacalco, 08400 CDMX'],
            'CICS SANTO TOMAS' => ['CENTRO INTERDISCIPLINARIO DE CIENCIAS DE LA SALUD  UNIDAD SANTO TOMÁS', 'Av. de los Maestros, Santo Tomás, Miguel Hidalgo, 11340 CDMX']
        ];

        foreach ($escuelasIPN as $acronimo => $escuela) {
            P06Escuela::create([
                'institucion_id' => $ipn->institucion_id,
                'nombre_escuela' => $escuela[0],
                'acronimo_escuela' => $acronimo,
                'direccion_escuela' => strtr( strtoupper($escuela[1]), $remplazar ),
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        # IPN <--
        # TECNM -->
        $tecnm = P06Instituciones::firstWhere('clave_institucion', 'TECNM');
        $escuelasTECNM = [ 
            'ITGAM' => ['INSTITUTO TECNOLÓGICO DE GUSTAVO A. MADERO', 'av. 608 y av. 412 300, Zoológico de San Juan de Aragón, Gustavo A. Madero, 07470 CDMX'],
            'ITGAM II' => ['INSTITUTO TECNOLÓGICO DE GUSTAVO A. MADERO II', 'C. Morelos 193, Loma la Palma, Gustavo A. Madero, 07160 CDMX'],
            'ITIZ I' => ['INSTITUTO TECNOLÓGICO DE IZTAPALAPA', 'Av. Telecomunicaciones, Chinam Pac de Juárez, Iztapalapa, 09208 CDMX'],
            'ITIZ II' => ['INSTITUTO TECNOLÓGICO DE IZTAPALAPA II', 'C. Valle de México 47, miravalle, Iztapalapa, 09696 CDMX'],
            'ITIZ III' => ['INSTITUTO TECNOLÓGICO DE IZTAPALAPA III', 'cdad. Orquídea 71, San Miguel Teotongo, Iztapalapa, 09630 CDMX'],
            'ITT I' => ['INSTITUTO TECNOLÓGICO DE TLÁHUAC', 'Av. Estanislao Ramírez Ruiz 301, Amp. Selene, Tláhuac, 13420 CDMX'],
            'ITT II' => ['INSTITUTO TECNOLÓGICO DE TLÁHUAC II', 'Camino Real 625, Jardines del Llano, Tláhuac, 13550 CDMX'],
            'ITT III' => ['INSTITUTO TECNOLÓGICO DE TLÁHUAC III', 'Canal de Chalco 1088, Villa Centroamericana I, Tláhuac, 13278 CDMX'],
            'ITTLA' => ['INSTITUTO TECNOLÓGICO DE TLALNEPANTLA', 'Av. Instituto Tecnológico s/n, La Comunidad, 54070 Tlalnepantla, México'],
            'ITSCO' => ['INSTITUTO TECNOLÓGICO SUPERIOR DE COSAMALOAPAN', 'Nicolás Bravo, 95390 Cosamaloapan, Veracruz'],
            'ITSTA' => ['INSTITUTO TECNOLÓGICO SUPERIOR DE TANTOYUCA', 'Desviación Lindero Tametate S/N, La Morita, 92100 Tantoyuca, Veracruz'],
            'ITSAO' => ['INSTITUTO TECNOLÓGICO SUPERIOR DE ACATLÁN DE OSORIO', 'ctra. Acatlán - San Juan Ixcaquistla, ud. Tecnológica Acatlán, 74949 Acatlán, Puebla'],
            'ITSCS' => ['INSTITUTO TECNOLÓGICO SUPERIOR DE CIUDAD SERDÁN', 'Av. Instituto, Av. Tecnológico S/N, Col la Gloria, 75520 Cdad. Serdán, Puebla'],
            'TESE' => ['TECNOLÓGICO DE ESTUDIOS SUPERIORES DE ECATEPEC', 'S/D'],
            'TESOEM' => ['TECNOLÓGICO DE ESTUDIOS SUPERIORES DEL ORIENTE DEL ESTADO DE MÉXICO', 'pje. de Isidro S/N, Tecamachalco, 56400 San Isidro, México'],
            'TESCHA' => ['TECNOLÓGICO DE ESTUDIOS SUPERIORES DE CHALCO', 'ctra. Federal México Cuautla s/n La Candelaria Tlapala, 56641 Chalco de Díaz Covarrubias, México'],
            'TESSFP' => ['TECNOLÓGICO DE ESTUDIOS SUPERIORES DE SAN FELIPE DEL PROGRESO', 'av. Instituto Tecnológico S/N, Ejido, Tecnológico, 50640 San Felipe del Progreso, México'],
            'TESI' => ['TECNOLÓGICO DE ESTUDIOS SUPERIORES DE IXTAPALUCA', 'ctra. Coatepec, c.jon San Juan 7, 56580 Ixtapaluca, México'],
            'TESCHI' => ['TECNOLÓGICO DE ESTUDIOS SUPERIORES DE CHIMALHUACÁN', 'C. Primavera S/N, sta. Maria Nativitas, 56335 Chimalhuacán, Méico.'],
            'TESCO' => ['TECNOLÓGICO DE ESTUDIOS SUPERIORES DE COACALCO', 'av, Av. 16 de Septiembre 54, Cabecera municipal, 55700 México']
        ];
        foreach ($escuelasTECNM as $acronimo => $escuela) {
            P06Escuela::create([
                'institucion_id' => $tecnm->institucion_id,
                'nombre_escuela' => $escuela[0],
                'acronimo_escuela' => $acronimo,
                'direccion_escuela' => strtr( strtoupper($escuela[1]), $remplazar ),
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        # TECNM <--
        # COLBACH -->
        $colbach = P06Instituciones::firstWhere('clave_institucion', 'COLBACH');
        $escuelasCOLBACH = [ 
            'COLBACH 2'=> ['COLEGIO DE BACHILLERES PLANTEL 2 CIEN METROS "ELISA ACUÑA ROSSETTI"', 'av. Sur de Los100 Metros., Eje Central Lázaro Cárdenas 600, Gustavo A. Madero, 07700 CDMX'],
            'COLBACH 3'=> ['COLEGIO DE BACHILLERES PLANTEL 3 IZTACALCO', 'Eje 3 Ote 1150, INFONAVIT Iztacalco, Iztacalco, 08900 CDMX'],
            'COLBACH 4'=> ['COLEGIO DE BACHILLERES PLANTEL 4 CULHUACÁN "LÁZARO CÁRDENAS"', 'c. Rosa María Sequeira, Culhuacán, Coyoacán, 04480 CDMX'],
            'COLBACH 7'=> ['COLEGIO DE BACHILLERES PLANTEL 7 IZTAPALAPA', 'av. Guerra de Reforma Axis 6 Ote 40, Av. Guerra de Reforma 7, Leyes de Reforma 3ra Secc, Iztapalapa, 09310 CDMX'],
            'COLBACH 9'=> ['COLEGIO DE BACHILLERES PLANTEL 9 ARAGÓN', 'c. 1527, San Juan de Aragón VI Secc, Gustavo A. Madero, 07920 CDMX'],
            'COLBACH 10' => ['COLEGIO DE BACHILLERES PLANTEL 10 AEROPUERTO', 'Adolfo López Mateos 190, Amp. Aviación, Venustiano ctraanza, 15690 CDMX'],
            'COLBACH 11' => ['COLEGIO DE BACHILLERES PLANTEL 11 NUEVA ATZACOALCO', 'Prof. Claudio Cortes S/N, Amp. Gabriel Hernández, Gustavo A. Madero, 07080 CDMX'],
            'COLBACH 12' => ['COLEGIO DE BACHILLERES PLANTEL 12 NEZAHUALCÓYOTL', 'Av. Gral. Lázaro Cárdenas 12, Benito Juárez, 57809 cdad. Nezahualcóyotl, México'],
            'COLBACH 13' => ['COLEGIO DE BACHILLERES PLANTEL 13 XOCHIMILCO-TEPEPAN "QUIRINO MENDOZA Y CORTÉS"', 'ctra. San Pablo S/N, Amp. Tepepan, Xochimilco, 16020 CDMX'],
            'COLBACH 14' => ['COLEGIO DE BACHILLERES PLANTEL 14 MILPA ALTA "FIDENCIO VILLANUEVA ROJAS"', 'Constitución 3, Villa Milpa Alta, Centro, 12000 CDMX'],
            'COLBACH 16' => ['COLEGIO DE BACHILLERES PLANTEL 16 TLÁHUAC "MANUEL CHAVARRIA CHAVARRIA"', 'Oceano de las Tempestades s/n, San Francisco Tlaltenco, Tláhuac, 13420 CDMX'],
            'COLBACH 19' => ['COLEGIO DE BACHILLERES PLANTEL 19 ECATEPEC', 'R-1, Vía Adolfo López Mateos s/n, Jardines de Cerro Gordo, 55100 Ecatepec de Morelos, México'],
            'COLBACH 20' => ['COLEGIO DE BACHILLERES PLANTEL 20 DEL VALLE "MATÍAS ROMERO"', 'Matías Romero 422, Col. del Valle Centro, Benito Juárez, 03100 CDMX']
        ];
        foreach ($escuelasCOLBACH as $acronimo => $escuela) {
            P06Escuela::create([
                'institucion_id' => $colbach->institucion_id,
                'nombre_escuela' => $escuela[0],
                'acronimo_escuela' => $acronimo,
                'direccion_escuela' => strtr( strtoupper($escuela[1]), $remplazar ),
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        # COLBACH <--
        # DGETI / CETIS -->
        $cetis = P06Instituciones::firstWhere('clave_institucion', 'DGETI');
        $escuelasCETIS = [
            'CETIS 1' => ['CENTRO DE ESTUDIOS TECNOLÓGICOS INDUSTRIAL Y SERVICIOS NO. 1 CORONEL MATILDE GALICIA RIOJA', 'Av. Estanislao Ramírez Ruiz 301, Amp. Selene, Tláhuac, 13430 CDMX'],
            'CETIS 2' => ['CENTRO DE ESTUDIOS TECNOLÓGICOS INDUSTRIAL Y SERVICIOS NO. 2 DAVID ALFARO SIQUEIROS', 'av. Estanislao Ramírez Ruiz 301, Amp. Selene, Tláhuac, 13430 CDMX'],
            'CETIS 3' => ['CENTRO DE ESTUDIOS TECNOLÓGICOS INDUSTRIAL Y SERVICIOS NO. 3 JUANA BELÉN GUTIÉRREZ DE MENDOZA', 'Jose Antonio Torres Xocongo 26, Tránsito, Cuauhtémoc, 06820 CDMX'],
            'CETIS 4' => ['CENTRO DE ESTUDIOS TECNOLÓGICOS INDUSTRIAL Y SERVICIOS NO. 4 AQUILES SERDÁN ALATRISTE', 'Av. de las Granjas 283 Col. Jardín Azpeitia, 02530 CDMX.'],
            'CETIS 5' => ['CENTRO DE ESTUDIOS TECNOLÓGICOS INDUSTRIAL Y SERVICIOS NO. 5 GERTRUDIS BOCANEGRA', 'Petén 963, sta. Cruz Atoyac, Benito Juárez, 03310 CDMX'],
            'CETIS 6' => ['CENTRO DE ESTUDIOS TECNOLÓGICOS INDUSTRIAL Y SERVICIOS NO. 6 IGNACIO MANUEL ALTAMIRANO', 'Cuitláhuac No. 50 esq, Av. Tlahuac, Los Reyes Culhuacan, Iztapalapa, 09840 CDMX'],
            'CETIS 7' => ['CENTRO DE ESTUDIOS TECNOLÓGICOS INDUSTRIAL Y SERVICIOS NO. 7 MIGUEL LERDO DE TEJEDA', 'C. Luis Espinoza, Solidaridad Nacional, Gustavo A. Madero, 07268 CDMX'],
            'CETIS 8' => ['CENTRO DE ESTUDIOS TECNOLÓGICOS INDUSTRIAL Y SERVICIOS NO. 8 RAFAEL DONDÉ PRECIAT', 'Lago Alberto 431, Anáhuac I Secc, Miguel Hidalgo, 11320 Ciudad de México, CDMX'],
            'CETIS 9' => ['CENTRO DE ESTUDIOS TECNOLÓGICOS INDUSTRIAL Y SERVICIOS NO. 9 JOSEFA ORTIZ DE DOMÍNGUEZ', 'C. Mina 1, Guerrero, Cuauhtémoc, 06300 CDMX'],
            'CETIS 10' => ['CENTRO DE ESTUDIOS TECNOLÓGICOS INDUSTRIAL Y SERVICIOS NO. 10', 'Tiziano 223, Alfonso XIII, Álvaro Obregón, 01460 CDMX'],
            'CETIS 11' => ['CENTRO DE ESTUDIOS TECNOLÓGICOS INDUSTRIAL Y SERVICIOS NO. 11 ESCUELA NACIONAL DE ARTES GRÁFICAS', 'Bucareli 117, Juárez, Cuauhtémoc, 06600 CDMX'],
            'CETIS 12' => ['CENTRO DE ESTUDIOS TECNOLÓGICOS INDUSTRIAL Y SERVICIOS NO. 12 BENITO JUÁREZ GRACÍA', 'Av. de los 50 metros S/N, Civac 1RA. Sección, Civac, 62578 Jiutepec, Mor.'],
            'CETIS 13' => ['CENTRO DE ESTUDIOS TECNOLÓGICOS INDUSTRIAL Y SERVICIOS NO. 13 SOR JUANA INES DE LA CRUZ', 'Enrico Martínez 25, Colonia Centro, Centro, Cuauhtémoc, 06040 Centro, CDMX'],
            'CETIS 30' => ['CENTRO DE ESTUDIOS TECNOLÓGICOS INDUSTRIAL Y SERVICIOS NO. 30 EMILIANO ZAPATA', 'Cienfuegos 1017, Residencial Zacatenco, Gustavo A. Madero, 07360 Ciudad de México, CDMX'],
            'CETIS 31' => ['CENTRO DE ESTUDIOS TECNOLÓGICOS INDUSTRIAL Y SERVICIOS NO. 31 LEONA VICARIO', 'C. Jesús Romero Flores S/N, Gabriel Ramos Millán Secc Cuchilla, Iztacalco, 08030 CDMX'],
            'CETIS 32' => ['CENTRO DE ESTUDIOS TECNOLÓGICOS INDUSTRIAL Y SERVICIOS NO. 32 JOSÉ VASCONCELOS', 'Av. Río Churubusco 32, Cuchilla Pantitlán, Venustiano ctraanza, 15670 CDMX'],
            'CETIS 33' => ['CENTRO DE ESTUDIOS TECNOLÓGICOS INDUSTRIAL Y SERVICIOS NO. 33 CARLOS MARÍA DE BUSTAMANTE', 'av. Hacienda de Narvarte 84, Prados del Rosario, Azcapotzalco, 02410 CDMX'],
            'CETIS 39' => ['CENTRO DE ESTUDIOS TECNOLÓGICOS INDUSTRIAL Y SERVICIOS NO. 39', 'Acueducto 5511, Amp Tepepan, Xochimilco, 16030 CDMX'],
            'CETIS 42' => ['CENTRO DE ESTUDIOS TECNOLÓGICOS INDUSTRIAL Y SERVICIOS NO. 42 IGNACIO LÓPEZ RAYÓN', 'av. Mexico s/n, Ixtlahuacan, Iztapalapa, 09690 CDMX'],
            'CETIS 49' => ['CENTRO DE ESTUDIOS TECNOLÓGICOS INDUSTRIAL Y SERVICIOS NO. 49', 'ctra. San Pablo 95, Amp Tepepan, Xochimilco, 16030 CDMX'],
            'CETIS 50' => ['CENTRO DE ESTUDIOS TECNOLÓGICOS INDUSTRIAL Y SERVICIOS NO. 50 CDMX', 'Av. de las Torres #300, San Lorenzo Tezonco, Iztapalapa, 09900 CDMX'],
            'CETIS 51' => ['CENTRO DE ESTUDIOS TECNOLÓGICOS INDUSTRIAL Y SERVICIOS NO. 51 JOSÉ MARIA MORELOS Y PAVÓN', 'Av. Río Churubusco 1, Arenal 4ta Secc, Venustiano ctraanza, 15640 CDMX'],
            'CETIS 52' => ['CENTRO DE ESTUDIOS TECNOLÓGICOS INDUSTRIAL Y SERVICIOS NO. 52 HERMENEGILDO GALEANA', 'Desierto de los Leones 6285, San Bartolo Ameyalco, Álvaro Obregón, 01800 CDMX'],
            'CETIS 53' => ['CENTRO DE ESTUDIOS TECNOLÓGICOS INDUSTRIAL Y SERVICIOS NO. 53 VICENTE RAMÓN GUERRERO SALDAÑA', 'Combate de Celaya S/N, U.H. Vicente Guerrero, Iztapalapa, 09200 CDMX'],
            'CETIS 54' => ['CENTRO DE ESTUDIOS TECNOLÓGICOS INDUSTRIAL Y SERVICIOS NO. 54 GUADALUPE VICTORIA', 'Av. 608 S/N esq, Av. 412, ud. Habitacional, San Juan de Aragón VI Secc, Gustavo A. Madero, 07470 cdmx'],
            'CETIS 55' => ['CENTRO DE ESTUDIOS TECNOLÓGICOS INDUSTRIAL Y SERVICIOS NO. 55 FRANCISCO J. MÚGICA VELÁZQUEZ', 'Av. San Juanico S/N, Amp. Gabriel Hernández, Gustavo A. Madero, 07090 CDMX'],
            'CETIS 56' => ['CENTRO DE ESTUDIOS TECNOLÓGICOS INDUSTRIAL Y SERVICIOS NO. 56 RICARDO FLORES MAGÓN', 'Ote. 95 4401, Nueva Tenochtitlan, Gustavo A. Madero, 07850 CDMX'],
            'CETIS 119' => ['CENTRO DE ESTUDIOS TECNOLÓGICOS INDUSTRIAL Y SERVICIOS NO. 119 GERTRUDIS BOCANEGRA LAZO DE LA VEGA', 'Gob. Ignacio Pichardo Pagaza, Av. Camino a Nva. Aragón, Cd Oriente, 55247 Ecatepec de Morelos, México'],
            'CETIS 152' => ['CENTRO DE ESTUDIOS TECNOLÓGICOS INDUSTRIAL Y SERVICIOS NO. 152 SINDICATO ÚNICO DE TRABAJADORES DE LA INDUSTRIA MILITAR', 'Gral. Sóstenes Rocha 4, Ampliación Daniel Garza, Daniel Garza al Poniente, Miguel Hidalgo, 11830 CDMX'],
            'CETIS 153' => ['CENTRO DE ESTUDIOS TECNOLÓGICOS INDUSTRIAL Y SERVICIOS NO. 153 MIGUEL HIDALGO Y COSTILLA', 'Eje 5 Sur, Av. Leyes de Reforma S/n, Leyes de Reforma 3ra Secc, Iztapalapa, 09310 CDMX'],
            'CETIS 154' => ['CENTRO DE ESTUDIOS TECNOLÓGICOS INDUSTRIAL Y SERVICIOS NO. 154 ADELA VELARDE', 'Cedral s/n, esq. xochitepec, Ejidos de San Pedro Martir, 14640 CDMX'],
            'CETIS 166' => ['CENTRO DE ESTUDIOS TECNOLÓGICOS INDUSTRIAL Y SERVICIOS NO. 166 CARMEN SERDÁN ALATRISTE', 'Av. Río de Los Remedios 454, Santiago Atepetlac, Gustavo A. Madero, 07680 CDMX'],
            'CETIS 167' => ['CENTRO DE ESTUDIOS TECNOLÓGICOS INDUSTRIAL Y SERVICIOS NO. 167 HERMANOS FLORES MAGÓN', 'Independencia 12, Secc III, Milpa Alta, 12300 CDMX']
        ];
        foreach ($escuelasCETIS as $acronimo => $escuela) {
            P06Escuela::create([
                'institucion_id' => $cetis->institucion_id,
                'nombre_escuela' => $escuela[0],
                'acronimo_escuela' => $acronimo,
                'direccion_escuela' => strtr( strtoupper($escuela[1]), $remplazar ),
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        # DGETI CETIS <--
        # CONALEP -->
        $conalep = P06Instituciones::firstWhere('clave_institucion', 'CONALEP');
        $escuelasCONALEP = [
            'CONALEP AEROPUERTO' => ['COLEGIO NACIONAL DE EDUCACIÓN PROFESIONAL TÉCNICA AEROPUERTO', 'Acolhuacan, Arenal 2da Secc, Venustiano ctraanza, 15600 CDMX'],
            'CONALEP ALOB I' => ['COLEGIO NACIONAL DE EDUCACIÓN PROFESIONAL TÉCNICA ÁLVARO OBREGÓN II', 'Prol. 5 de Mayo 615, Mina los Coyotes, Álvaro Obregón, 01620 CDMX'],
            'CONALEP ALOB II' => ['COLEGIO NACIONAL DE EDUCACIÓN PROFESIONAL TÉCNICA ÁLVARO OBREGÓN II', 'Rómulo O\'Farril, Calz. de las Águilas s/n, Álvaro Obregón, 01759 CDMX'],
            'CONALEP ARA' => ['COLEGIO NACIONAL DE EDUCACIÓN PROFESIONAL TÉCNICA ARAGÓN', 'av. 599 130, San Juan de Aragón III Secc, Gustavo A. Madero, 07970 CDMX'],
            'CONALEP AZC' => ['COLEGIO NACIONAL DE EDUCACIÓN PROFESIONAL TÉCNICA AZCAPOTZALCO', 'cdad. de Cecati N-13, Santa Catarina, Azcapotzalco, 02250 Ciudad de México, CDMX'],
            'CONALEP AZT' => ['COLEGIO NACIONAL DE EDUCACIÓN PROFESIONAL TÉCNICA AZTAHUACAN', 'Plan de Ayala 395, Zona Urbana Ejidal Santa María Aztahuacan, Iztapalapa, 09500 CDMX'],
            'CONALEP CMC' => ['COLEGIO NACIONAL DE EDUCACIÓN PROFESIONAL TÉCNICA CENTRO MÉXICO-CANADA', 'Macario Gaxiola, San Pedro Xalpa, Azcapotzalco, 02710 CDMX'],
            'CONALEP CUAU' => ['COLEGIO NACIONAL DE EDUCACIÓN PROFESIONAL TÉCNICA CUAUTITLÁN I', 'Av. Primero de Mayo 2, INFONAVIT Nte, 54720 Cuautitlán Izcalli, México'],
            'CONALEP DSOL' => ['COLEGIO NACIONAL DE EDUCACIÓN PROFESIONAL TÉCNICA DEL SOL', 'av. Aureliano Ramos s/n, El Sol, 57139 Cdad. Nezahualcóyotl, México'],
            'CONALEP ECAT' => ['COLEGIO NACIONAL DE EDUCACIÓN PROFESIONAL TÉCNICA ECATEPEC I' , 'Cerrada Ecatepec I Sn, Cd Cuauhtemoc, 55067 Ecatepec de Morelos, México'],
            'CONALEP ECAT II' => ['COLEGIO NACIONAL DE EDUCACIÓN PROFESIONAL TÉCNICA ECATEPEC II' , 'Sitio de Cuautla 89, Mexico Independiente, 55245 Ecatepec de Morelos, México'],
            'CONALEP GAM I' => ['COLEGIO NACIONAL DE EDUCACIÓN PROFESIONAL TÉCNICA GUSTAVO A. MADERO I', 'ctra. Tenayuca - Chalmita S/n Gustavo A. Madero El Arbolillo II, Barrio Bajo, Cuautepec de Madero, 07280 cdmx'],
            'CONALEP GAM II' => ['COLEGIO NACIONAL DE EDUCACIÓN PROFESIONAL TÉCNICA GUSTAVO A. MADERO II', 'Eduardo Molina MZ45 LT16, Juan González Romero, Gustavo A. Madero, 07420 CDMX'],
            'CONALEP IZTC I' => ['COLEGIO NACIONAL DE EDUCACIÓN PROFESIONAL TÉCNICA IZTACALCO I', 'Calz. Ignacio Zaragoza 1060, Agrícola Pantitlán, Iztacalco, 08100 CDMX'],
            'CONALEP IZTP I' => ['COLEGIO NACIONAL DE EDUCACIÓN PROFESIONAL TÉCNICA IZTAPALAPA I', 'Av. Yucatán No.25, San Sebastián Tecoloxtitla, Iztapalapa, 09520 CDMX'],
            'CONALEP IZTP II' => ['COLEGIO NACIONAL DE EDUCACIÓN PROFESIONAL TÉCNICA IZTAPALAPA II', 'Av. Gral. Antonio León Loyola 147, Tepalcates, Iztapalapa, 09210 CDMX'],
            'CONALEP IZTP III' => ['COLEGIO NACIONAL DE EDUCACIÓN PROFESIONAL TÉCNICA IZTAPALAPA III', 'C. Nautla, San Juan Xalpa, Iztapalapa, 09850 CDMX'],
            'CONALEP IZTP IV' => ['COLEGIO NACIONAL DE EDUCACIÓN PROFESIONAL TÉCNICA IZTAPALAPA IV', 'Damiana S/N, El Molino, Iztapalapa, 09960 CDMX'],
            'CONALEP IZTP V' => ['COLEGIO NACIONAL DE EDUCACIÓN PROFESIONAL TÉCNICA IZTAPALAPA V', 'Ahuehuetes s/n, Santa Martha Acatitla, Iztapalapa, 09530 CDMX'],
            'CONALEP lRLP' => ['COLEGIO NACIONAL DE EDUCACIÓN PROFESIONAL TÉCNICA LOS REYES LA PAZ', 'ctra. Federal México-Texcoco Km. 25.5, Los Reyes, 56400 Los Reyes Acaquilpan, México'],
            'CONALEP MAGCO' => ['COLEGIO NACIONAL DE EDUCACIÓN PROFESIONAL TÉCNICA MAGDALENA CONTRERAS', 'C. Durango 17, San Francisco, La Magdalena Contreras, 10710 CDMX'],
            'CONALEP MA' => ['COLEGIO NACIONAL DE EDUCACIÓN PROFESIONAL TÉCNICA MILPA ALTA' , 'Ignacio Zaragoza S/N, San Pablo Oztotepec, San Juan, Milpa Alta, 12400 San Pablo CDMX'],
            'CONALEP NEZA I' => ['COLEGIO NACIONAL DE EDUCACIÓN PROFESIONAL TÉCNICA NEZAHUALCÓYOTL I', 'Plaza San Pedro San Jacinto y, Villa Madrid Fracc, Plazas de Aragon, 57139 Cdad. Nezahualcóyotl, México'],
            'CONALEP NEZA II' => ['COLEGIO NACIONAL DE EDUCACIÓN PROFESIONAL TÉCNICA NEZAHUALCÓYOTL II', 'Av, Cto. Rey Nezahualcóyotl S/N, Benito Juárez, 57000 Cdad. Nezahualcóyotl, México'],
            'CONALEP NEZA III' => ['COLEGIO NACIONAL DE EDUCACIÓN PROFESIONAL TÉCNICA NEZAHUALCÓYOTL III', 'C. San Bartolo 149, Jose Vicente Villada, 57760 Cdad. Nezahualcóyotl, México'],
            'CONALEP TLAH' => ['COLEGIO NACIONAL DE EDUCACIÓN PROFESIONAL TÉCNICA TLÁHUAC', 'Mar de Los Vapores S/N-Mz.181, Lt. 4, Amp. Selene, Tláhuac, 13430 CDMX'],
            'CONALEP TLNPT I' => ['COLEGIO NACIONAL DE EDUCACIÓN PROFESIONAL TÉCNICA TLALNEPANTLA I', 'Av. Ex-Hacienda de Enmedio Manzana 002, Hab Prado Vallejo, 54172 Tlalnepantla, Méx.'],
            'CONALEP TLPN I' => ['COLEGIO NACIONAL DE EDUCACIÓN PROFESIONAL TÉCNICA TLALPAN I', 'Del Río 1, Cantera Puente de Piedra, Tlalpan, 14050 CDMX'],
            'CONALEP TLPN II' => ['COLEGIO NACIONAL DE EDUCACIÓN PROFESIONAL TÉCNICA TLALPAN II', 'Francisco I. Madero 7, Miguel Hidalgo 3ra Secc, Tlalpan, 14250 CDMX'],
            'CONALEP VDARA' => ['COLEGIO NACIONAL DE EDUCACIÓN PROFESIONAL TÉCNICA VALLE DE ARAGÓN', 'Pdte. Miguel Alemán Valdez 117-A, El Chamizal, 55270 Ecatepec de Morelos, México'],
            'CONALEP VCA I' => ['COLEGIO NACIONAL DE EDUCACIÓN PROFESIONAL TÉCNICA VENUSTIANO ctraANZA I', 'Yunque 33, Artes Gráficas, Venustiano ctraanza, 15830 Ciudad de México, CDMX'],
            'CONALEP VCA II' => ['COLEGIO NACIONAL DE EDUCACIÓN PROFESIONAL TÉCNICA VENUSTIANO ctraANZA II', 'Tenochtitlan S/N, Arenal 3ra Secc, Venustiano ctraanza, 15600 Ciudad de México, CDMX'],
            'CONALEP XOCHI' => ['COLEGIO NACIONAL DE EDUCACIÓN PROFESIONAL TÉCNICA XOCHIMILCO' , 'calz. México-Xochimilco 5722 Xochimilco Tepepan, La Noria, 16020 Ciudad de México']
        ];
        foreach ($escuelasCONALEP as $acronimo => $escuela) {
            P06Escuela::create([
                'institucion_id' => $conalep->institucion_id,
                'nombre_escuela' => $escuela[0],
                'acronimo_escuela' => $acronimo,
                'direccion_escuela' => strtr( strtoupper($escuela[1]), $remplazar ),
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        # CONALEP <--
        # UVM -->
        $uvm = P06Instituciones::firstWhere('clave_institucion', 'UVM');
        $escuelasUVM = [ 
            'UVM COYOACAN-TLALPAN' => ['UNIVERSIDAD DEL VALLE DE MÉXICO CAMPUS COYOACAN-TLALPAN', 'calz. De Tlalpan Número 3016 Y 3058, Colonia Ex Hacienda Coapa, Delegación Coyoacán, C.P. 04980 cdmx'],
            'UVM SAN RAFAEL' => ['UNIVERSIDAD DEL VALLE DE MÉXICO CAMPUS SAN RAFAEL', 'Sadi Carnot No. 57, Col. San Rafael, Cuahtemoc, D. F., C. P. 06470 cdmx'],
            'UVM HISPANO' => ['UNIVERSIDAD DEL VALLE DE MÉXICO CAMPUS HISPANO', 'Via José López Portillo No. 346 Y 352, Col. San Lorenzo Tetlixtac, Coacalco De Berriozabal, edo. de México, C. P. 55700'],
            'UVM TEXCOCO' => ['UNIVERSIDAD DEL VALLE DE MÉXICO CAMPUS TEXCOCO', 'Boulevard Jímenez Cantú No. 2, Col San Martín, Texcoco, edo. de México, C. P. 56140'],
            'UVM TOLUCA' => ['UNIVERSIDAD DEL VALLE DE MÉXICO CAMPUS TOLUCA', 'av. Las Palmas No. 439 Poniente, Col. San Jorge Pueblo Nuevo, Metepec, edo. de México, C. P. 52164.'],
            'UVM LOMAS VERDES' => ['UNIVERSIDAD DEL VALLE DE MÉXICO CAMPUS LOMAS VERDES', 'Paseo De Las Aves No. 1, Colonia San Mateo Nopala, Naucalpan De Juárez, edo. de México, C. P. 53220'],
            'UVM CUERNAVACA' => ['UNIVERSIDAD DEL VALLE DE MÉXICO CAMPUS CUERNAVACA', 'prol. Miguel Hidalgo, N° 504, Col. Campo Sotelo, Temixco, edo. de Morelos, C. P. 62580.'],
            'UVM PUEBLA' => ['UNIVERSIDAD DEL VALLE DE MÉXICO CAMPUS PUEBLA', 'Camino Real A San Andrés Cholula No. 4002, Col. Emiliano Zapata, San Andrés Cholula, Puebla, C. P. 72810']
        ];
        foreach ($escuelasUVM as $acronimo => $escuela) {
            P06Escuela::create([
                'institucion_id' => $uvm->institucion_id,
                'nombre_escuela' => $escuela[0],
                'acronimo_escuela' => $acronimo,
                'direccion_escuela' => strtr( strtoupper($escuela[1]), $remplazar ),
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        # UVM <--
        # UNITEC -->
        $unitec = P06Instituciones::firstWhere('clave_institucion', 'UNITEC');
        $escuelasUNITEC = [ 
            'UNITEC ECATEPEC' => ['UNIVERSIDAD TECNOLOGICA DE MÉXICO CAMPUS ECATEPEC', 'Av. Central 375, Ejidos Tulpetlac, 55107 Ecatepec de Morelos, México'],
            'UNITEC ATIZAPAN' => ['UNIVERSIDAD TECNOLOGICA DE MÉXICO CAMPUS ATIZAPAN', 'Blvrd Calacoaya 7, La Ermita, 52970 Cdad. López Mateos, México'],
            'UNITEC CUITLAHUAC' => ['UNIVERSIDAD TECNOLOGICA DE MÉXICO CAMPUS CUITLÁHUAC', 'c. Nte. 67 2346, San Salvador Xochimanca, Azcapotzalco, 02870 Ciudad de México, CDMX'],
            'UNITEC SUR' => ['UNIVERSIDAD TECNOLOGICA DE MÉXICO CAMPUS SUR', 'Ermita Iztapalapa 557, Granjas Esmeralda, Iztapalapa, 09810 CDMX'],
            'UNITEC LREYES' => ['UNIVERSIDAD TECNOLOGICA DE MÉXICO CAMPUS LOS REYES', 'ctra. Federal México-Puebla Km 17.5, Los Reyes, 56400 Los Reyes Acaquilpan, México'],
            'UNITEC TOLUCA' => ['UNIVERSIDAD TECNOLOGICA DE MÉXICO CAMPUS TOLUCA', 'Av. Paseo Tollocan 701, Delegación sta. Ana Tlapaltitlán, 50071 Santa Ana Tlapaltitlán, México'],
            'UNITEC ONLINE' => ['UNIVERSIDAD TECNOLOGICA DE MÉXICO EN LINEA', '-']
        ]; 
        foreach ($escuelasUNITEC as $acronimo => $escuela) {
            P06Escuela::create([
                'institucion_id' => $unitec->institucion_id,
                'nombre_escuela' => $escuela[0],
                'acronimo_escuela' => $acronimo,
                'direccion_escuela' => strtr( strtoupper($escuela[1]), $remplazar ),
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        # UNITEC <--
        # UNILA -->
        $unila = P06Instituciones::firstWhere('clave_institucion', 'UNILA');
        $escuelasUNILA = [ 
            'UNILA ROMA' => ['UNIVERSIDAD LATINA CAMPUS ROMA', 'Chihuahua 202, Roma Nte., Cuauhtémoc, 06700 CDMX'],
            'UNILA SUR' => ['UNIVERSIDAD LATINA CAMPUS SUR', 'Av. Pedro Henríquez Ureña 173, Los Reyes, Coyoacán, 04330 CDMX'],
            'UNILA CUAUTLA' => ['UNIVERSIDAD LATINA CAMPUS CUAUTLA', 'ctra. Tlayecac - Cuautla 1060, Hermenegildo Galeana, 62741 Cuautla, Morelos'],
            'UNILA CUERNAVACA' => ['UNIVERSIDAD LATINA CAMPUS CUERNAVACA', 'Av. Vicente Guerrero 1806, Col Nogales, Amp. Maravillas, 62228 Cuernavaca, Morelos']
        ]; 
        foreach ($escuelasUNILA as $acronimo => $escuela) {
            P06Escuela::create([
                'institucion_id' => $unila->institucion_id,
                'nombre_escuela' => $escuela[0],
                'acronimo_escuela' => $acronimo,
                'direccion_escuela' => strtr( strtoupper($escuela[1]), $remplazar ),
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        # UNILA <--
        # UNIMEX -->
        $unimex = P06Instituciones::firstWhere('clave_institucion', 'UNIMEX');
        $escuelasUNIMEX = [ 
            'UNIMEX IZCALLI' => ['UNIVERSIDAD MEXICANA PLANTEL IZCALLI', 'Av. del Vidrio 15, Diamante, 54743 Cuautitlán Izcalli, México'],
            'UNIMEX SATELITE' => ['UNIVERSIDAD MEXICANA PLANTEL SATÉLITE', 'Circuito Poetas 37, Cd. Satélite, 53100 Naucalpan de Juárez, México'],
            'UNIMEX POLANCO' => ['UNIVERSIDAD MEXICANA PLANTEL POLANCO', 'Av. Emilio Castelar 83, Polanco, Polanco IV Secc, Miguel Hidalgo, 11550 CDMX']
        ]; 
        foreach ($escuelasUNIMEX as $acronimo => $escuela) {
            P06Escuela::create([
                'institucion_id' => $unimex->institucion_id,
                'nombre_escuela' => $escuela[0],
                'acronimo_escuela' => $acronimo,
                'direccion_escuela' => strtr( strtoupper($escuela[1]), $remplazar ),
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        # UNIMEX <--
        # UPEM -->
        $upem = P06Instituciones::firstWhere('clave_institucion', 'UPEM');
        $escuelasUPEM = [ 
            'UPEM ECATEPEC' => ['UNIVERSIDAD PRIVADA DEL ESTADO DE MÉXICO PLANTEL ECATEPEC', 'Av. Revolución No. 46, Centro, 55000 Ecatepec de Morelos, México'],
            'UPEM IXTAPALUCA' => ['UNIVERSIDAD PRIVADA DEL ESTADO DE MÉXICO PLANTEL IXTAPALUCA', 'Ignacio Zaragoza 55, Jose de la Palma, 56530 Ixtapaluca, México'],
            'UPEM TECAMAC' => ['UNIVERSIDAD PRIVADA DEL ESTADO DE MÉXICO PLANTEL TECÁMAC', 'Av. Miguel Hidalgo 104, Tecámac Centro, Tecámac, 55740 Tecámac de Felipe Villanueva, México'],
            'UPEM TEXCOCO' => ['UNIVERSIDAD PRIVADA DEL ESTADO DE MÉXICO PLANTEL TEXCOCO', 'Chapultepec S/N San Sebastian, Huisnahuac, 56130 Texcoco de Mora, México']
        ]; 
        foreach ($escuelasUPEM as $acronimo => $escuela) {
            P06Escuela::create([
                'institucion_id' => $upem->institucion_id,
                'nombre_escuela' => $escuela[0],
                'acronimo_escuela' => $acronimo,
                'direccion_escuela' => strtr( strtoupper($escuela[1]), $remplazar ),
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        # UPEM <--
        # ULSA -->
        $ulsa = P06Instituciones::firstWhere('clave_institucion', 'ULSA');
        $escuelasULSA = [ 
            'ULSA NEZAHUALCOYOTL' => ['UNIVERSIDAD LA SALLE NEZAHUALCÓYOTL', 'col. Cdad. Jardín Bicentenario, Av. Bordo de Xochiaca s/n-B, Manzana polígono IV, 57205 Cdad. Nezahualcóyotl, Méx.'],
            'ULSA CUERNAVACA' => ['UNIVERSIDAD LA SALLE CUERNAVACA', 'C. Nueva Inglaterra S/N, San Cristobal, 62230 Cuernavaca, Morelor'],
            'ULSA CDMX' => ['UNIVERSIDAD LA SALLE CIUDAD DE MÉXICO', 'Benjamín Franklin No 45, Col. Condesa, Alc Cuauhtémoc, CDMX. CP 06140']
        ]; 
        foreach ($escuelasULSA as $acronimo => $escuela) {
            P06Escuela::create([
                'institucion_id' => $ulsa->institucion_id,
                'nombre_escuela' => $escuela[0],
                'acronimo_escuela' => $acronimo,
                'direccion_escuela' => strtr( strtoupper($escuela[1]), $remplazar ),
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        # ULSA <--
        # DGCFT / CECATI -->
        $cecati = P06Instituciones::firstWhere('clave_institucion', 'DGCFT');
        $escuelasCECATI = [ 
            'CECATI 1' => ['CENTRO DE CAPACITACIÓN PARA EL TRABAJO INDUSTRIAL NO. 1', 'Calz. Azcapotzalco - La Villa 304 Bis, Santa Catarina, Azcapotzalco, 02250 Ciudad de México, CDMX'],
            'CECATI 2' => ['CENTRO DE CAPACITACIÓN PARA EL TRABAJO INDUSTRIAL NO. 2', 'Cda. Canoa 202 Col, Tizapán San Ángel, Loreto y Campamento, Álvaro Obregón, 01090 Álvaro Obregón, CDMX'],
            'CECATI 3' => ['CENTRO DE CAPACITACIÓN PARA EL TRABAJO INDUSTRIAL NO. 3', 'Fray Servando Teresa de Mier, Sur 103 S/N, Aeronáutica Militar, 15960 v. Carranza, CDMX'],
            'CECATI 4' => ['CENTRO DE CAPACITACIÓN PARA EL TRABAJO INDUSTRIAL NO. 4', 'Presa Salinillas, Avenida Irrigacion 391, Miguel Hidalgo, 11200 CDMX'],
            'CECATI 11' => ['CENTRO DE CAPACITACIÓN PARA EL TRABAJO INDUSTRIAL NO. 11', 'Calz. Azcapotzalco - La Villa 304-B, Santa Catarina, Azcapotzalco, 02250 CDMX'],
            'CECATI 12' => ['CENTRO DE CAPACITACIÓN PARA EL TRABAJO INDUSTRIAL NO. 12', 'Atzacoalco 7700, Constitución de la República, Gustavo A. Madero, 07469 CDMX'],
            'CECATI 13' => ['CENTRO DE CAPACITACIÓN PARA EL TRABAJO INDUSTRIAL NO. 13', 'c. Museo, Esq. División del Norte S/N, Col. El Rosario, Alcaldía Coyoacán, 04380 CDMX'],
            'CECATI 14' => ['CENTRO DE CAPACITACIÓN PARA EL TRABAJO INDUSTRIAL NO. 14', 'Plaza Benito Juárez s/n, esq. sur 157, Gabriel Ramos Millán, Iztacalco, 08000 CDMX']
        ]; 
        foreach ($escuelasCECATI as $acronimo => $escuela) {
            P06Escuela::create([
                'institucion_id' => $cecati->institucion_id,
                'nombre_escuela' => $escuela[0],
                'acronimo_escuela' => $acronimo,
                'direccion_escuela' => strtr( strtoupper($escuela[1]), $remplazar ),
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        # DGCFT / CECATI <--
        # DGETA / CBTA, CBTF -->
        $dgeta = P06Instituciones::firstWhere('clave_institucion', 'DGETA');
        $escuelasDGETA = [ 
            'CBTA 35' => ['CENTRO DE BACHILLERATO TECNOLÓGICO AGROPECUARIO NO. 35 LEONA VICARIO','ctra. Federal México-Puebla, Col. San Juan Tlalpizahuac, 56560 México'],
            'CBTA 96' => ['CENTRO DE BACHILLERATO TECNOLÓGICO AGROPECUARIO NO. 96 DR. VALENTÍN GÓMEZ FARÍAS','Av. Independencia Pte. 682, 52680 Xalatlaco, México'],
            'CBTA 150' => ['CENTRO DE BACHILLERATO TECNOLÓGICO AGROPECUARIO NO. 150','ctra. Acambay-bocto, 50300 Villa de Acambay de Ruíz Castañeda, México'],
            'CBTA 180' => ['CENTRO DE BACHILLERATO TECNOLÓGICO AGROPECUARIO NO. 180 CRISTÓBAL HIDALGO Y COSTILLA','CTRA. Luvianos - Zacazonapan, 51445 Villa Luvianos, México'],
            'CBTA 231' => ['CENTRO DE BACHILLERATO TECNOLÓGICO AGROPECUARIO NO. 231','Emilio Carranza 22, San Lorenzo, 56970 Atlautla de Victoria, México'],
            'CBTA 232' => ['CENTRO DE BACHILLERATO TECNOLÓGICO AGROPECUARIO NO. 232','MZ. 004, 50830 Loma del Astillero, México']
        ]; 
        foreach ($escuelasDGETA as $acronimo => $escuela) {
            P06Escuela::create([
                'institucion_id' => $dgeta->institucion_id,
                'nombre_escuela' => $escuela[0],
                'acronimo_escuela' => $acronimo,
                'direccion_escuela' => strtr( strtoupper($escuela[1]), $remplazar ),
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        # DGETA / CBTA, CBTF <--
        # UIN -->
        $uin = P06Instituciones::firstWhere('clave_institucion', 'UIN');
        $escuelasUIN = [ 
            'UIN TLAHUAC' => ['UNIVERSIDAD INSURGENTES PLANTEL TLÁHUAC', 'av. TLÁHUAC no. 1789 col. san lorenzo tezonco, Iztapalapa, CDMX'],
            'UIN CDAD AZTECA' => ['UNIVERSIDAD INSURGENTES PLANTEL CIUDAD AZTECA', 'av. central no. 10, mz. 531 col. ciudad azteca ecatepec de morelos, edo. de MÉXICO'],
            'UIN TOREO' => ['UNIVERSIDAD INSURGENTES PLANTEL TOREO', 'av. ingenieros militares no. 97 col. lomas de sotelo naucalpan, edo. de MÉXICO'],
            'UIN SAN ANGEL' => ['UNIVERSIDAD INSURGENTES PLANTEL SAN ANGEL', 'av. revolucion no. 1836 col. san angel alcaldia ÁLVARO OBREGÓN, CDMX'],
            'UIN SUR I' => ['UNIVERSIDAD INSURGENTES PLANTEL SUR I', 'calz. de tlalpan no. 1064 col. nativitas, benito juarez, CDMX'],
            'UIN SUR II' => ['UNIVERSIDAD INSURGENTES PLANTEL SUR II', 'calz. de tlalpan no. 1148 col. zacahuitzco, benito juarez, CDMX'],
            'UIN CENTRO' => ['UNIVERSIDAD INSURGENTES PLANTEL CENTRO', 'bucareli no. 107, esq. general prim. col. juárez, Cuauhtémoc, cdmx'],
            'UIN ERMITA' => ['UNIVERSIDAD INSURGENTES PLANTEL ERMITA', 'CALZ. ermita Iztapalapa no. 1693 col. 8va. Ampliación de san miguel izatapalapa, CDMX'],
            'UIN CHALCO' => ['UNIVERSIDAD INSURGENTES PLANTEL CHALCO', 'benito juárez no. 21 col. centro chalco, edo de MÉXICO'],
            'UIN COACALCO' => ['UNIVERSIDAD INSURGENTES PLANTEL COACALCO', 'av. JOSÉ lopez portillo no. 299 col. arbol ecatepec de morelos, edo. de MÉXICO'],
            'UIN CUAUTITLAN' => ['UNIVERSIDAD INSURGENTES PLANTEL CUAUTITLÁN', 'c. morelos s/n col. paseo de santa maria Cuautitlán, edo. de MÉXICO'],
            'UIN IZTAPALAPA' => ['UNIVERSIDAD INSURGENTES PLANTEL IZTAPALAPA', 'calz. ermita Iztapalapa no. 4018 esq. eje 5 sur, col. pje. zacatepec, Iztapalapa, CDMX'],
            'UIN NORTE' => ['UNIVERSIDAD INSURGENTES PLANTEL NORTE', 'acueducto no. 13 col. san pedro zacatenco alcaldia gustavo a. madero, CDMX'],
            'UIN TLALPAN' => ['UNIVERSIDAD INSURGENTES PLANTEL TLALPAN', 'Calz. de Tlalpan 390, Viaducto Piedad, Iztacalco, 08200 CDMX'],
            'UIN TLALNEPANTLA' => ['UNIVERSIDAD INSURGENTES PLANTEL TLALNEPANTLA', 'av. via gustavo baz no. 142, col. bellavista tlalnepantla, edo. de MÉXICO'],
            'UIN ONLINE' => ['UNIVERSIDAD INSURGENTES PLANTEL EN LINEA', '-']
        ]; 
        foreach ($escuelasUIN as $acronimo => $escuela) {
            P06Escuela::create([
                'institucion_id' => $uin->institucion_id,
                'nombre_escuela' => $escuela[0],
                'acronimo_escuela' => $acronimo,
                'direccion_escuela' => strtr( strtoupper($escuela[1]), $remplazar ),
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        # UIN <--
        # ETAC -->
        $etac = P06Instituciones::firstWhere('clave_institucion', 'ETAC');
        $escuelasETAC = [ 
            'ETAC CHALCO' => ['UNIVERSIDAD ETAC CAMPUS CHALCO', 'La Parcela 3Z- P1/2, San Marcos Huixtoco, 56643 Chalco Estado de México'],
            'ETAC COACALCO' => ['UNIVERSIDAD ETAC CAMPUS COACALCO', 'Av. Zarzaparrilla 85, Villa de las Flores 55700 Coacalco de Berriozabal, Méx.'],
            'ETAC TLALNEPANTLA' => ['UNIVERSIDAD ETAC CAMPUS TLALNEPANTLA', 'Viveros de Asís 96, Viveros de La Loma, 54080 Tlalnepantla, Méx.']
        ];
        foreach ($escuelasETAC as $acronimo => $escuela) {
            P06Escuela::create([
                'institucion_id' => $etac->institucion_id,
                'nombre_escuela' => $escuela[0],
                'acronimo_escuela' => $acronimo,
                'direccion_escuela' => strtr( strtoupper($escuela[1]), $remplazar ),
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        # ETAC <--
        # ICEL -->
        $icel = P06Instituciones::firstWhere('clave_institucion', 'ICEL');
        $escuelasICEL = [ 
            'ICEL ERMITA' => ['UNIVERSIDAD ICEL CAMPUS ERMITA', 'Av. Ermita Iztapalapa No.1907, Col. Los Ángeles, Iztapalapa, CDMX, C.P. 09710'],
            'ICEL LA VILLA' => ['UNIVERSIDAD ICEL CAMPUS LA VILLA', 'Av. Cantera No. 16, Col. Estanzuela, Gustavo A. Madero, 07060 CDMX'],
            'ICEL TLALPAN' => ['UNIVERSIDAD ICEL CAMPUS TLALPAN', 'Av. Tlalpan No. 2754, Col. Prados Coyoacán, Coyoacán, CDMX, C.P. 04810'],
            'ICEL ZARAGOZA' => ['UNIVERSIDAD ICEL CAMPUS ZARAGOZA', 'Av. Texcoco No. 1532, Col. Santa Martha Acatitla, Iztapalapa, CDMX, C.P. 09510'],
            'ICEL ZONA ROSA' => ['UNIVERSIDAD ICEL CAMPUS ZONA ROSA', 'Liverpool No. 24, Esq. Berlín, Col. Juárez, Cuauhtémoc, CDMX, C.P. 06600'],
            'ICEL ECATEPEC' => ['CAMPUS ICEL ECATEPEC', 'Av. Carlos Hank González No. 67, Col. Olímpica 68, Ecatepec de Morelos, Edo. de México, C.P. 55130'],
            'ICEL ONLINE' => ['UNIVERSIDAD ICEL CAMPUS ONLINE', '-'],
            'ICEL COACALCO' => ['CAMPUS ICEL COACALCO', 'Av. Morelos No. 43, Col. Zacuautitla, Coacalco de Berriozábal, Edo. de México, C.P. 55700.'],
            'ICEL CUAUTITLAN' => ['CAMPUS ICEL CUAUTITLÁN', 'Vidrio No. 11, Col. Centro Urbano, Cuautitlán Izcalli, Edo. de México, C.P. 54760'],
            'ICEL LOMAS VERDES' => ['CAMPUS ICEL LOMAS VERDES', 'Huizache No. 16, Col. Santiago Occipaco, Naucalpan de Juárez, Edo. de México, C.P. 53250'],
            'ICEL CUERNAVACA' => ['CAMPUS ICEL CUERNAVACA', 'Av. Teopanzolco No. 1101, Col. Recursos Hidráulicos, Cuernavaca, Morelos, C.P. 62260.']
        ];

        foreach ($escuelasICEL as $acronimo => $escuela) {
            P06Escuela::create([
                'institucion_id' => $icel->institucion_id,
                'nombre_escuela' => $escuela[0],
                'acronimo_escuela' => $acronimo,
                'direccion_escuela' => strtr( strtoupper($escuela[1]), $remplazar ),
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        # ICEL <--
        # SECTEI -->
        $sectei = P06Instituciones::firstWhere('clave_institucion', 'SECTEI');
        $escuelasSECTEI = [
            'IRC' => ['INSTITUTO DE ESTUDIOS SUPERIORES  ROSARIO CASTELLANOS', '-'], 
            'UPVM' => ['UNIVERSIDAD POLITÉCNICA DEL VALLE DE MÉXICO', 'Av. Mexiquense ,esq, Av. Universidad Politécnica s/n, Los Portales, 54910 Fuentes del Valle, México'],
            'UPP' => ['UNIVERSIDAD POLITÉCNICA DE PACHUCA', 'ctra. Cdad. Sahagún-Pachuca, Ex-Hacienda de Santa Bárbara, 43830 Zempoala, hidalgo'],
            'UPT' => ['UNIVERSIDAD POLITÉCNICA DE TECÁMAC', 'Av. 5 de Mayo Manzana 018, Tecamac, 55740 Tecámac de Felipe Villanueva, México'],
            'UTN' => ['UNIVERSIDAD TECNOLÓGICA DE NEZAHUALCÓYOTL', 'Cto. Rey Nezahualcóyotl Manzana 010, Benito Juárez, 57000 Cdad. Nezahualcóyotl, México'],
            'CBT 1 IXTAPALUCA' => ['CENTRO DE BACHILLERATO TECNOLÓGICO NO. 1 DR. LEOPOLDO RÍO DE LA LOZA, IXTAPALUCA', 'Oyameles 10, Izcalli Ixtapaluca, 56566 Ixtapaluca, México'],
            'CBT 1 NEZAHUALCOYOTL' => ['CENTRO DE BACHILLERATO TECNOLÓGICO NO. 1 REFUGIO ESTEVES REYES, NEZAHUALCÓYOTL', 'C. Dieciocho 271, Esperanza, 57819 Cdad. Nezahualcóyot1l, México'],
            'CBT 2 NEZAHUALCOYOTL' => ['CENTRO DE BACHILLERATO TECNOLÓGICO NO. 2 DR. MAXIMILIANO RUIZ C., NEZAHUALCÓYOTL', 'Tercera av. #27, Evolución, 57700 Cdad. Nezahualcóyotl, México'],
            'CBT 2 TECAMAC' => ['CENTRO DE BACHILLERATO TECNOLÓGICO NO. 2 LIC. CARLOS PICHARDO, TECÁMAC', 'ctra. Federal Pachuca - México San Pedro Pozohuacan, 55744 Tecámac de Felipe Villanueva, México'],
            'CBT 3 TECAMAC' => ['CENTRO DE BACHILLERATO TECNOLÓGICO NO. 3 TECÁMAC', 'C. Maravillas Manzana 026, Santa María, Ozumbilla, 55760 Ojo de Agua, México'],
            'CBT 3 ZUMPANGO' => ['CENTRO DE BACHILLERATO TECNOLÓGICO NO. 3 ZUMPANGO', 'San Judas Tadeo 101, 55630 San Bartolo Cuautlalpan, México'],
            'CBT GVA CUAUTITLÁN' => ['CENTRO DE BACHILLERATO TECNOLÓGICO GABRIEL V. ALCOCER, CUAUTITLÁN', 'Blvd. Francisco I. Madero 30, FRACCIóN EJIDAL TLAXCULPAS, 54800 Cuautitlán, México']
        ];
        foreach ($escuelasSECTEI as $acronimo => $escuela) {
            P06Escuela::create([
                'institucion_id' => $sectei->institucion_id,
                'nombre_escuela' => $escuela[0],
                'acronimo_escuela' => $acronimo,
                'direccion_escuela' => strtr( strtoupper($escuela[1]), $remplazar ),
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        # SECTEI <--
        # SEP -->
        $sep = P06Instituciones::firstWhere('clave_institucion', 'SECTEI');
        $escuelasSEP = [
            'UNEVE' => ['UNIVERSIDAD ESTATAL DE VALLE DE ECATEPEC', 'Av. Central s/n, Valle de Anahuac, 55210 Ecatepec de Morelos, México']
        ];
        foreach ($escuelasSEP as $acronimo => $escuela) {
            P06Escuela::create([
                'institucion_id' => $sep->institucion_id,
                'nombre_escuela' => $escuela[0],
                'acronimo_escuela' => $acronimo,
                'direccion_escuela' => strtr( strtoupper($escuela[1]), $remplazar ),
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        # SEP <--
        # UMB -->
        $umb = P06Instituciones::firstWhere('clave_institucion', 'UMB');
        $escuelasUMB = [ 
            'UMB LA PAZ' => ['UNIVERSIDAD MEXIQUENSE DEL BICENTENARIO UES LA PAZ', 'PJE. SAN ISIDRO SN, 56400 TECAMACHALCO, LA PAZ, EDO. DE MÉXICO'],
            'UMB IXTAPALUCA' => ['UNIVERSIDAD MEXIQUENSE DEL BICENTENARIO UES IXTAPALUCA', 'C. HACIENDA LA ESCONDIDA SN, 56577 SANTA BÁRBARA, IXTAPALUCA, EDO. DE MÉXICO'],
            'UMB ATENCO' => ['UNIVERSIDAD MEXIQUENSE DEL BICENTENARIO UES ATENCO', 'AV. INDEPENDENCIA SN, COLONIA SANTA ISABEL IXTAPAN 56300, ATENCO, EDO. DE MÉXICO'],
            'UMB CHALCO' => ['UNIVERSIDAD MEXIQUENSE DEL BICENTENARIO UES CHALCO', 'ctra. FEDERAL 115 MÉXICO-CUAUTLA, 56641 LA CANDELARIA TLAPALA, CHALCO, EDO. DE MÉXICO']
        ];
        foreach ($escuelasUMB as $acronimo => $escuela) {
            P06Escuela::create([
                'institucion_id' => $umb->institucion_id,
                'nombre_escuela' => $escuela[0],
                'acronimo_escuela' => $acronimo,
                'direccion_escuela' => strtr( strtoupper($escuela[1]), $remplazar ),
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        } 
        # UMB <--
        # UTC -->
        $utc = P06Instituciones::firstWhere('clave_institucion', 'UTC');
        $escuelasUTC = [ 
            'UTC ZONA ROSA' => ['UNIVERSIDAD TRES CULTURAS PLANTEL ZONA ROSA', 'Niza 67, Col. Juárez, Alcaldía, Cuauhtémoc. CDMX'],
            'UTC IZTAPALAPA' => ['UNIVERSIDAD TRES CULTURAS PLANTEL IZTAPALAPA', 'calz. Ermita-Iztapalapa 1729 Col. 8va Ampliación San Miguel, Iztapalapa CDMX'],
            'UTC TOREO' => ['UNIVERSIDAD TRES CULTURAS PLANTEL TOREO', 'Av. Ingenieros Militares 160. Entre c. G. Murillo y esq. Calz. México - Tacuba Miguel Hidalgo CDMX'],
            'UTC TLALPAN' => ['UNIVERSIDAD TRES CULTURAS PLANTEL TLALPAN', 'Tlalpan #639 Colonia Álamos, Alcaldía Benito Júarez CDMX CP03400'],
            'UTC ECATEPEC' => ['UNIVERSIDAD TRES CULTURAS PLANTEL ECATEPEC', 'Via Morelos 230, Col. Santa María Tulpetlac, Ecatepec de Morelos, edo. de México'],
            'UTC NEZA' => ['UNIVERSIDAD TRES CULTURAS PLANTEL NEZA', 'Av. Adolfo López Mateos 355 Col. Evolución Súper 24 cdad. Nezahualcóyotl. EdoMex'],
            'UTC CHALCO' => ['UNIVERSIDAD TRES CULTURAS PLANTEL CHALCO', 'c. Vicente Guerrero Núm. 25, Plaza Chalco 2000, Edificio C Int. 46 Col. Centro Histórico, Municipio de Chalco, edo. de México.']
        ]; 
        foreach ($escuelasUTC as $acronimo => $escuela) {
            P06Escuela::create([
                'institucion_id' => $utc->institucion_id,
                'nombre_escuela' => $escuela[0],
                'acronimo_escuela' => $acronimo,
                'direccion_escuela' => strtr( strtoupper($escuela[1]), $remplazar ),
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        } 
        # UTC <--
        # EBC -->
        $ebc = P06Instituciones::firstWhere('clave_institucion', 'EBC');
        $escuelasEBC = [ 
            'EBC CDMX' => ['ESCUELA BANCARIA Y COMERCIAL CAMPUS CIUDAD DE MÉXICO', 'Liverpool No. 54, Col. Juárez, C.P. 06600, Alc. Cuauhtémoc, Ciudad de México'],
            'EBC CDMX SUR' => ['ESCUELA BANCARIA Y COMERCIAL CAMPUS CIUDAD DE MÉXICO SUR', 'Anillo Periférico 4407, Jardines en la Montaña, Alc. Tlalpan, C.P. 14210, cdmx'],
            'EBC TOLUCA' => ['ESCUELA BANCARIA Y COMERCIAL CAMPUS TOLUCA', 'Blvd. Alfredo del Mazo No. 1002, Col. Zona Industrial, C.P. 50071, Toluca, edo. de México'],
            'EBC TLALNEPANTLA' => ['ESCUELA BANCARIA Y COMERCIAL CAMPUS TLALNEPANTLA', 'Cerro de las Campanas No. 98, Col. S. Andrés Atenco, C.P. 54040, Tlalnepantla, EDO. de México']
        ]; 
        foreach ($escuelasEBC as $acronimo => $escuela) {
            P06Escuela::create([
                'institucion_id' => $ebc->institucion_id,
                'nombre_escuela' => $escuela[0],
                'acronimo_escuela' => $acronimo,
                'direccion_escuela' => strtr( strtoupper($escuela[1]), $remplazar ),
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        } 
        # EBC <--
        # ANAHUAC -->
        $anahuac = P06Instituciones::firstWhere('clave_institucion', 'ANAHUAC');
        $escuelasANAHUAC = [ 
            'ANAHUAC MEX SUR' => ['UNIVERSIDAD ANAHUAC MÉXICO CAMPUS SUR', 'Av. de los Tanques no. 865, Col. Torres de Potrero, Álvaro Obregón, C.P. 01840, Ciudad de México'],
            'ANAHUAC MEX NORTE' => ['UNIVERSIDAD ANAHUAC MÉXICO CAMPUS NORTE', 'Av. Universidad Anáhuac 46, Col. Lomas Anáhuac Huixquilucan, C.P. 52786, edo. de México'],
            'ANAHUAC PUEBLA' => ['UNIVERSIDAD ANAHUAC PUEBLA', 'C. Orión Norte S/N Col. La Vista Country Club San Andrés Cholula, Puebla, México'],
            'ANAHUAC ONLINE' => ['UNIVERSIDAD ANAHUAC ONLINE ', '-'] 
        ];
        foreach ($escuelasANAHUAC as $acronimo => $escuela) {
            P06Escuela::create([
                'institucion_id' => $anahuac->institucion_id,
                'nombre_escuela' => $escuela[0],
                'acronimo_escuela' => $acronimo,
                'direccion_escuela' => strtr( strtoupper($escuela[1]), $remplazar ),
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        } 
        # ANAHUAC <--
        # ULA -->
        $ula = P06Instituciones::firstWhere('clave_institucion', 'ULA');
        $escuelasULA = [ 
            'ULA FLORIDA' => ['UNIVERSIDAD LATINOAMERICANA CAMPUS FLORIDA', 'Iztaccihuatl 178, Florida, Álvaro Obregón, 01030 CDMX'],
            'ULA NORTE' => ['UNIVERSIDAD LATINOAMERICANA CAMPUS NORTE', 'c. Cumbres de Acultzingo 3, Hab los Pirules, 54040 Tlalnepantla, México'],
            'ULA VALLE' => ['UNIVERSIDAD LATINOAMERICANA CAMPUS DEL VALLE', 'C. Gabriel Mancera 1402, Col del Valle Sur, Benito Juárez, 03104 CDMX']
        ];
        foreach ($escuelasULA as $acronimo => $escuela) {
            P06Escuela::create([
                'institucion_id' => $ula->institucion_id,
                'nombre_escuela' => $escuela[0],
                'acronimo_escuela' => $acronimo,
                'direccion_escuela' => strtr( strtoupper($escuela[1]), $remplazar ),
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        } 
        # ULA <--
        # CESCIJUC -->
        $cescijuc = P06Instituciones::firstWhere('clave_institucion', 'CESCIJUC');
        $escuelasCESCIJUC = [ 
            'CESCIJUC BALDERAS' => ['CENTRO DE ESTUDIOS SUPERIORES EN CIENCIAS JURÍDICAS Y CRIMINOLÓGICAS PLANTEL BALDERAS', 'Balderas 138, Colonia Cuauhtémoc, 06070 CDMX'],
            'CESCIJUC NIÑOS HEROES 188' => ['CENTRO DE ESTUDIOS SUPERIORES EN CIENCIAS JURÍDICAS Y CRIMINOLÓGICAS PLANTEL NIÑOS HEROES 188', 'Av. Niños Héroes 188, Doctores, Cuauhtémoc, 06720 CDMX'],
            'CESCIJUC NIÑOS HEROES 222' => ['CENTRO DE ESTUDIOS SUPERIORES EN CIENCIAS JURÍDICAS Y CRIMINOLÓGICAS PLANTEL NIÑOS HEROES 222', 'Av. Niños Héroes 222, Doctores, Cuauhtémoc, 06720 Ciudad de México, CDMX']
        ];
        foreach ($escuelasCESCIJUC as $acronimo => $escuela) {
            P06Escuela::create([
                'institucion_id' => $cescijuc->institucion_id,
                'nombre_escuela' => $escuela[0],
                'acronimo_escuela' => $acronimo,
                'direccion_escuela' => strtr( strtoupper($escuela[1]), $remplazar ),
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        } 
        # CESCIJUC <--
        # ITC -->
        $itc = P06Instituciones::firstWhere('clave_institucion', 'ITC');
        $escuelasITC = [ 
            'ITC CDMX' => ['INSTITUTO TECNOLÓGICO DE LA CONSTRUCCIÓN CAMPUS CIUDAD DE MÉXICO', 'Rómulo O Farril 480, Olivar de los Padres, 01780 CDMX'],
            'ITC EDOMEX' => ['INSTITUTO TECNOLÓGICO DE LA CONSTRUCCIÓN CAMPUS ESTADO DE MÉXICO', 'C. Ali Chumacero #1212, San Lorenzo Coacalco Metepec, Edo. de México']
        ];
        foreach ($escuelasITC as $acronimo => $escuela) {
            P06Escuela::create([
                'institucion_id' => $itc->institucion_id,
                'nombre_escuela' => $escuela[0],
                'acronimo_escuela' => $acronimo,
                'direccion_escuela' => strtr( strtoupper($escuela[1]), $remplazar ),
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        } 
        # ITC <--
        # UJS -->
        $ujs = P06Instituciones::firstWhere('clave_institucion', 'UJS');
        $escuelasUJS = [ 
            'UJS CIEN METROS' => ['UNIVERSIDAD JUSTO SIERRA CAMPUS CIEN METROS', 'Eje Central Lázaro Cárdenas No. 1150, Col. Nueva Industrial Vallejo, Alcaldía Gustavo A. Madero'],
            'UJS ACUEDUCTO' => ['UNIVERSIDAD JUSTO SIERRA CAMPUS ACUEDUCTO', 'Av. Acueducto No. 914, Col. Laguna Ticomán CP 07330, Alcaldía Gustavo A. Madero'],
            'UJS TICOMAN' => ['UNIVERSIDAD JUSTO SIERRA CAMPUS TICOMÁN', 'Calz. Ticomán No. 892, Col. Barrio Candelaría, C.P 07340, Alcaldía Gustavo A. Madero']
        ];
        foreach ($escuelasUJS as $acronimo => $escuela) {
            P06Escuela::create([
                'institucion_id' => $ujs->institucion_id,
                'nombre_escuela' => $escuela[0],
                'acronimo_escuela' => $acronimo,
                'direccion_escuela' => strtr( strtoupper($escuela[1]), $remplazar ),
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        } 
        # UJS <--
        # ALPHA -->
        $alpha = P06Instituciones::firstWhere('clave_institucion', 'ALPHA');
        $escuelasALPHA = [
            'ALPHA CHIMALHUACAN' => ['INSTITUTO ALPHA CHIMALHUACÁN', 'Av. Venustiano Carranza Piso 2, Cabecera Municipal, 56330 Chimalhuacán, México']
        ];
        foreach ($escuelasALPHA as $acronimo => $escuela) {
            P06Escuela::create([
                'institucion_id' => $alpha->institucion_id,
                'nombre_escuela' => $escuela[0],
                'acronimo_escuela' => $acronimo,
                'direccion_escuela' => strtr( strtoupper($escuela[1]), $remplazar ),
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        } 
        # ALPHA <--
        # ICATI -->
        $icati = P06Instituciones::firstWhere('clave_institucion', 'ICATI');
        $escuelasICATI = [
            'EDAYO ECATEPEC' => ['ESCUELA DE ARTES Y OFICIOS ECATEPEC', 'c. Emiliano Zapata núm. 50, col. Sauces Coalición, 55269 Ecatepec de Morelos, edo. de México'],
            'EDAYO IXTAPALUCA' => ['ESCUELA DE ARTES Y OFICIOS IXTAPALUCA', 'C. El Capulín núm. 46, colonia La Venta, 56530 Ixtapaluca, edo de México'],
            'EDAYO CHALCO' => ['ESCUELA DE ARTES Y OFICIOS CHALCO', 'C. Artes y Oficios s/n, col. Ex Hacienda de San Juan, 56600 Chalco, edo de México'],
            'EDAYO TEXCOCO' => ['ESCUELAS DE ARTES Y OFICIOS TEXCOCO', 'c. Miguel Alemán s/n, Fraccionamiento Lomas La Trinidad, 56130 Texcoco, edo. de México.'],
            'EDAYO TEOTIHUACAN' => ['ESCUELAS DE ARTES Y OFICIOS TEOTIHUACÁN', 'av. Monterrey s/n, San Lorenzo Tlalmimilolpan, 55830 Teotihuacán, edo. de México'],
            'EDAYO NAUCALPAN' => ['ESCUELAS DE ARTES Y OFICIOS NAUCALPAN', 'c. Protón s/n, col. Lomas de San Agustín El Torito, 53490 Naucalpan de Juárez, edo. de México.'],
            'EDAYO CUAUTITLAN MEXICO' => ['ESCUELAS DE ARTES Y OFICIOS CUAUTITLÁN MÉXICO', 'AV. Teyahualco s/n, Fraccionamiento sta. Elena, 54850 Cuautitlán, edo. de México.']
        ];
        foreach ($escuelasICATI as $acronimo => $escuela) {
            P06Escuela::create([
                'institucion_id' => $icati->institucion_id,
                'nombre_escuela' => $escuela[0],
                'acronimo_escuela' => $acronimo,
                'direccion_escuela' => strtr( strtoupper($escuela[1]), $remplazar ),
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        } 
        # ICATI <--
        # UNID -->
        $unid = P06Instituciones::firstWhere('clave_institucion', 'UNID');
        $escuelasUNID = [
            'UNID TAXQUEÑA' => ['UNIVERSIDAD INTERAMERICANA PARA EL DESARROLLO CAMPUS TAXQUEÑA', 'Cerro de Jesús 67, Country Club Churubusco, Coyoacán, 04220 CDMX'],
            'UNID CHURUBUSCO' => ['UNIVERSIDAD INTERAMERICANA PARA EL DESARROLLO CAMPUS CHURUBUSCO', 'Calz. de la Viga 1390, Iztapalapa, 09400 CDMX'],
            'UNID TLALNEPANTLA' => ['UNIVERSIDAD INTERAMERICANA PARA EL DESARROLLO CAMPUS TLALNEPANTLA', 'Vía Dr. Gustavo Baz 2160, 54060 Tlalnepantla, México'],
            'UNID VALLE DE CHALCO' => ['UNIVERSIDAD INTERAMERICANA PARA EL DESARROLLO CAMPUS VALLE DE CHALCO', 'Poniente 13 73, Niños Heroes, San Miguel Xico, 56613 Valle de Chalco Solidaridad, México']
        ];
        foreach ($escuelasUNID as $acronimo => $escuela) {
            P06Escuela::create([
                'institucion_id' => $unid->institucion_id,
                'nombre_escuela' => $escuela[0],
                'acronimo_escuela' => $acronimo,
                'direccion_escuela' => strtr( strtoupper($escuela[1]), $remplazar ),
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        } 
        # UNID <--
        # TI -->
        $ti = P06Instituciones::firstWhere('clave_institucion', 'TI');
        $escuelasTI = [
            'TIA' => ['TECNOLÓGICO IBEROAMERICANO ARAGÓN', 'Av. Del Valle Del Yang - Tse 288, Valle de Aragon 1ra Secc, 57100 Cdad. Nezahualcóyotl, México'],
            'TIC' => ['TECNOLÓGICO IBEROAMERICANO COYOACÁN', 'Calz. Ignacio Zaragoza 257, 15900 CDMX']
        ];
        foreach ($escuelasTI as $acronimo => $escuela) {
            P06Escuela::create([
                'institucion_id' => $ti->institucion_id,
                'nombre_escuela' => $escuela[0],
                'acronimo_escuela' => $acronimo,
                'direccion_escuela' => strtr( strtoupper($escuela[1]), $remplazar ),
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        } 
        # TI <--
        #  -->
        $instituciones = P06Instituciones::whereIn('clave_institucion', [
            'BNA', 'UNIREM', 'UMA', 'UMAR', 'UH', 'CEEC', 
            'UNIVDEP', 'CUGS', 'ECCC', 'GVA', 'UDF', 'CUIN', 
            'UTEL', 'ITB', 'IS'
        ])->get();
        $escuelasINST = [
            'BNA' => ['BNA DERECHO', 'BARRA NACIONAL DE ABOGADOS FACULTAD DE DERECHO', 'Calz. de los Leones 144, Los Alpes, Álvaro Obregón, 01010 CDMX'], 
            'UNIREM' => ['UNIREM', 'UNIVERSIDAD DE LA REPÚBLICA MEXICANA', 'Av. Tláhuac 4761, El Vergel, Iztapalapa, 09880 CDMX'], 
            'UMA' => ['UMA CDMX', 'UNIVERSIDAD MARISTA DE LA CIUDAD DE MÉXICO', 'Av. General Leandro Valle 928, 13270 CDMX'], 
            'UMAR' => ['UMAR HUATULCO', 'UNIVERSIDAD DEL MAR CAMPUS HUATULCO', 'Ciudad Universitaria, sta. María Huatulco, OaxACA, México 70989'], 
            'UH' => ['UH DEL VALLE', 'UNIVERSIDAD HUMANITAS CAMPUS DEL VALLE, CDMX', 'Pl. California 212, Col. Del Valle, Benito Juárez, 03100 CDMX'], 
            'CEEC' => ['CEEC CAFETALES', 'CENTRO DE ESTUDIOS CAFETALES', 'Av. Armada de México No. 1394, Col. Residencial Cafetales, 04918 CDMX']
            , 
            'UNIVDEP' => ['UNIVDEP VALLE', 'UNIVERSIDAD DEL DESARROLLO EMPRESARIAL Y PEDAGÓGICO PLANTEL DEL VALLE', 'Miguel Laurent #719, Col. del Valle, 03100 Alcaldía Benito Juárez'], 
            'CUGS' => ['CUGS CUAUHTEMOC', 'UNIVERSIDAD CUGS CAMPUS CUAUHTÉMOC', 'Av. Cuauhtémoc #60. Col. Doctores, 06720 CDMX'], 
            'ECCC' => ['ECCC CDMX', 'ESCUELA COMERICAL CÁMARA DE COMERCIO', 'C. de Chiapas 81, Roma Nte, Cuauhtémoc, 06700 CDMX'], 
            'GVA' => ['GVA CONTADURIA', 'LICENCIATURA EN CONTADURÍA INSTITUTO GVA', 'Versalles #15, segundo piso, Juárez, Cuauhtémoc, 06600 CDMX'], 
            'UDF' => ['UDF STA MARIA', 'UNIVERSIDAD DEL DISTRITO FEDERAL SANTA MARÍA', 'Cedro No. 16, Col. sta. María la Ribera, Alcaldía Cuauhtémoc, 06400 cdmx'],
            'CUIN' => ['CUINMX', 'CENTRO UNIVERSITARIO INTERNACIONAL DE MÉXICO', 'c. Miguel Ocaranza No. 127, Col. Merced Gómez, Álvaro Obregón, 01600 CDMX'],
            'UTEL' => ['UTEL', 'UNIVERSIDAD TECNOLÓGICA LATINOAMERICANA EN LÍNEA', 'Calz. de Tlalpan No. 2148 Oficinas 8 y 9, primer piso Col. Campestre Churubusco Del, Tlalpan, 04200 CDMX'],
            'ITB' => ['USC', 'UNIVERSIDAD SAN CARLOS', 'Vía Morelos 208, Nuevo Laredo, 55080 Ecatepec de Morelos, México'],
            'IS' => ['ISU', 'ISU UNIVERSIDAD', 'C. 25 Sur 702, La Paz, 72160 Heroica Puebla de Zaragoza, Puebla']
        ];
        foreach ($instituciones as $inst) {
            P06Escuela::create([
                'institucion_id' => $inst->institucion_id,
                'nombre_escuela' => $escuelasINST[ $inst->acronimo_institucion ][1],
                'acronimo_escuela' => $escuelasINST[ $inst->acronimo_institucion ][0],
                'direccion_escuela' => strtr( strtoupper( $escuelasINST[ $inst->acronimo_institucion ][2] ), $remplazar ),
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        } 
        #  <--
    }
}
