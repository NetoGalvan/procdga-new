<?php

namespace Database\Seeders\p06_servicio_social;

use Illuminate\Database\Seeder;
use App\Models\p06_servicio_social\P06Instituciones;

class CatalogoInstitucionSeeder extends Seeder
{
    public function run()
    {
        P06Instituciones::create([
            'nombre_institucion' => 'UNIVERSIDAD NACIONAL AUTONOMA DE MÉXICO',
            'acronimo_institucion' => 'UNAM',
            'clave_institucion' => 'UNAM',
            'activo' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        P06Instituciones::create([
            'nombre_institucion' => 'INSTITUTO POLITECNICO NACIONAL',
            'acronimo_institucion' => 'IPN',
            'clave_institucion' => 'IPN',
            'activo' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        P06Instituciones::create([
            'nombre_institucion' => 'UNIVERSIDAD AUTONOMA DE MÉXICO',
            'acronimo_institucion' => 'UAM',
            'clave_institucion' => 'UAM',
            'activo' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        P06Instituciones::create([
            'nombre_institucion' => 'UNIVERSIDAD AUTONOMA DEL ESTADO DE MÉXICO',
            'acronimo_institucion' => 'UAEM',
            'clave_institucion' => 'UAEM',
            'activo' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        P06Instituciones::create([
            'nombre_institucion' => 'TECNOLOGICO NACIONAL DE MÉXICO',
            'acronimo_institucion' => 'TECNM',
            'clave_institucion' => 'TECNM',
            'activo' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        P06Instituciones::create([
            'nombre_institucion' => 'BARRA NACIONAL DE ABOGADOS',
            'acronimo_institucion' => 'BNA',
            'clave_institucion' => 'BNA',
            'activo' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        P06Instituciones::create([
            'nombre_institucion' => 'COLEGIO DE BACHILLERES',
            'acronimo_institucion' => 'COLBACH',
            'clave_institucion' => 'COLBACH',
            'activo' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        P06Instituciones::create([
            'nombre_institucion' => 'DIRECCIÓN GENERAL DE EDUCACIÓN TECNOLÓGICA INDUSTRIAL', # (CETIS, CBTIS)
            'acronimo_institucion' => 'DGETI',
            'clave_institucion' => 'DGETI',
            'activo' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        P06Instituciones::create([
            'nombre_institucion' => 'COLEGIO NACIONAL DE EDUCACIÓN PROFESIONAL TECNICA',
            'acronimo_institucion' => 'CONALEP',
            'clave_institucion' => 'CONALEP',
            'activo' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        P06Instituciones::create([
            'nombre_institucion' => 'UNIVERSIDAD DEL VALLE DE MÉXICO',
            'acronimo_institucion' => 'UVM',
            'clave_institucion' => 'UVM',
            'activo' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        P06Instituciones::create([
            'nombre_institucion' => 'UNIVERSIDAD TECNOLOGICA DE MÉXICO',
            'acronimo_institucion' => 'UNITEC',
            'clave_institucion' => 'UNITEC',
            'activo' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        P06Instituciones::create([
            'nombre_institucion' => 'UNIVERSIDAD MEXICANA',
            'acronimo_institucion' => 'UNIMEX',
            'clave_institucion' => 'UNIMEX',
            'activo' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        P06Instituciones::create([
            'nombre_institucion' => 'UNIVERSIDAD INSURGENTES',
            'acronimo_institucion' => 'UIN',
            'clave_institucion' => 'UIN',
            'activo' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        P06Instituciones::create([
            'nombre_institucion' => 'UNIVERSIDAD LA SALLE MÉXICO',
            'acronimo_institucion' => 'ULSA',
            'clave_institucion' => 'ULSA',
            'activo' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        P06Instituciones::create([
            'nombre_institucion' => 'UNIVERSIDAD LATINA',
            'acronimo_institucion' => 'UNILA',
            'clave_institucion' => 'UNILA',
            'activo' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        P06Instituciones::create([
            'nombre_institucion' => 'DIRECCIÓN GENERAL DE CENTROS DE FORMACION PARA EL TRABAJO', # (CECATI)
            'acronimo_institucion' => 'DGCFT',
            'clave_institucion' => 'DGCFT',
            'activo' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        P06Instituciones::create([
            'nombre_institucion' => 'DIRECCIÓN GENERAL DE EDUCACIÓN TECNOLÓGICA AGROPECUARIA', # (CBTA, CBTF)
            'acronimo_institucion' => 'DGETA',
            'clave_institucion' => 'DGETA',
            'activo' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        P06Instituciones::create([
            'nombre_institucion' => 'UNIVERSIDAD PRIVADA DEL ESTADO DE MÉXICO',
            'acronimo_institucion' => 'UPEM',
            'clave_institucion' => 'UPEM',
            'activo' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        P06Instituciones::create([
            'nombre_institucion' => 'UNIVERSIDAD TRES CULTURAS',
            'acronimo_institucion' => 'UTC',
            'clave_institucion' => 'UTC',
            'activo' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        P06Instituciones::create([
            'nombre_institucion' => 'UNIVERSIDAD INTERNATIONAL COLLEGE FOR EXPERIENCED LEARNING',
            'acronimo_institucion' => 'ICEL',
            'clave_institucion' => 'ICEL',
            'activo' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        P06Instituciones::create([
            'nombre_institucion' => 'UNIVERSIDAD ESTUDIOS TECNOLOGICOS Y AVANZADOS PARA LA COMUNIDAD',
            'acronimo_institucion' => 'ETAC',
            'clave_institucion' => 'ETAC',
            'activo' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        P06Instituciones::create([
            'nombre_institucion' => 'SECRETARIA DE EDUCACIÓN, CIENCIA, TECNOLOGIA E INNOVACION', # (UP, UT, CBT, BT, IRC)
            'acronimo_institucion' => 'SECTEI',
            'clave_institucion' => 'SECTEI',
            'activo' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        P06Instituciones::create([
            'nombre_institucion' => 'SECRETARIA DE EDUCACIÓN PÚBLICA', # (UNEVE)
            'acronimo_institucion' => 'SEP',
            'clave_institucion' => 'SEP',
            'activo' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        P06Instituciones::create([
            'nombre_institucion' => 'UNIVERSIDAD MEXIQUENSE DEL BICENTENARIO',
            'acronimo_institucion' => 'UMB',
            'clave_institucion' => 'UMB',
            'activo' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        P06Instituciones::create([
            'nombre_institucion' => 'RED DE UNIVERSIDADES ANAHUAC',
            'acronimo_institucion' => 'ANAHUAC',
            'clave_institucion' => 'ANAHUAC',
            'activo' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        P06Instituciones::create([
            'nombre_institucion' => 'UNIVERSIDAD DE LA REPUBLICA MEXICANA',
            'acronimo_institucion' => 'UNIREM',
            'clave_institucion' => 'UNIREM',
            'activo' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        P06Instituciones::create([
            'nombre_institucion' => 'UNIVERSIDAD CUM LAUDE UBI GLORIA SEMPER',
            'acronimo_institucion' => 'CUGS',
            'clave_institucion' => 'CUGS',
            'activo' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        P06Instituciones::create([
            'nombre_institucion' => 'ESCUELA COMERCIAL CAMARA DE COMERCIO',
            'acronimo_institucion' => 'ECCC',
            'clave_institucion' => 'ECCC',
            'activo' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        P06Instituciones::create([
            'nombre_institucion' => 'INSTITUTO GENERADOR DE VALOR AGREGADO',
            'acronimo_institucion' => 'GVA',
            'clave_institucion' => 'GVA',
            'activo' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        P06Instituciones::create([
            'nombre_institucion' => 'UNIVERSIDAD DEL DISTRITO FEDERAL',
            'acronimo_institucion' => 'UDF',
            'clave_institucion' => 'UDF',
            'activo' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        P06Instituciones::create([
            'nombre_institucion' => 'ESCUELA BANCARIA Y COMERCIAL',
            'acronimo_institucion' => 'EBC',
            'clave_institucion' => 'EBC',
            'activo' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        P06Instituciones::create([
            'nombre_institucion' => 'UNIVERSIDAD INTERAMERICANA PARA EL DESARROLLO',
            'acronimo_institucion' => 'UNID',
            'clave_institucion' => 'UNID',
            'activo' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        P06Instituciones::create([
            'nombre_institucion' => 'UNIVERSIDAD HUMANITAS',
            'acronimo_institucion' => 'UH',
            'clave_institucion' => 'UH',
            'activo' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        P06Instituciones::create([
            'nombre_institucion' => 'RED DE UNIVERSIDADES MARISTAS',
            'acronimo_institucion' => 'UMA',
            'clave_institucion' => 'UMA',
            'activo' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        P06Instituciones::create([
            'nombre_institucion' => 'UNIVERSIDAD DEL MAR',
            'acronimo_institucion' => 'UMAR',
            'clave_institucion' => 'UMAR',
            'activo' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    
        P06Instituciones::create([
            'nombre_institucion' => 'INSTITUTO DE CAPACITACIÓN Y ADIESTRAMIENTO PARA EL TRABAJO INDUSTRIAL (EDAYO)',
            'acronimo_institucion' => 'ICATI',
            'clave_institucion' => 'ICATI',
            'activo' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        P06Instituciones::create([
            'nombre_institucion' => 'UNIVERSIDAD LATINOAMERICANA',
            'acronimo_institucion' => 'ULA',
            'clave_institucion' => 'ULA',
            'activo' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        P06Instituciones::create([
            'nombre_institucion' => 'CENTRO DE ESTUDIOS SUPERIORES EN CIENCIAS JURÍDICAS Y CRIMINOLÓGICAS',
            'acronimo_institucion' => 'CESCIJUC',
            'clave_institucion' => 'CESCIJUC',
            'activo' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        P06Instituciones::create([
            'nombre_institucion' => 'UNIVERSIDAD JUSTO SIERRA',
            'acronimo_institucion' => 'UJS',
            'clave_institucion' => 'UJS',
            'activo' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        P06Instituciones::create([
            'nombre_institucion' => 'TECNOLÓGICO IBEROAMERICANO',
            'acronimo_institucion' => 'TI',
            'clave_institucion' => 'TI',
            'activo' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        P06Instituciones::create([
            'nombre_institucion' => 'UNIVERSIDAD TECNOLÓGICA LATINOAMERICANA EN LÍNEA',
            'acronimo_institucion' => 'UTEL',
            'clave_institucion' => 'UTEL',
            'activo' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        P06Instituciones::create([
            'nombre_institucion' => 'INSTITUTO TÉCNICO Y BANCARIO SAN CARLOS',
            'acronimo_institucion' => 'ITB',
            'clave_institucion' => 'ITB',
            'activo' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        P06Instituciones::create([
            'nombre_institucion' => 'INSTITUTO SUIZO',
            'acronimo_institucion' => 'IS',
            'clave_institucion' => 'IS',
            'activo' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        P06Instituciones::create([
            'nombre_institucion' => 'CENTRO DE ESTUDIOS CAFETALES, S.C.',
            'acronimo_institucion' => 'CEEC',
            'clave_institucion' => 'CEEC',
            'activo' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        P06Instituciones::create([
            'nombre_institucion' => 'INSTITUTO ALPHA',
            'acronimo_institucion' => 'ALPHA',
            'clave_institucion' => 'ALPHA',
            'activo' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        P06Instituciones::create([
            'nombre_institucion' => 'UNIVERSIDAD DEL DESARROLLO EMPRESARIAL Y PEDAGÓGICO',
            'acronimo_institucion' => 'UNIVDEP',
            'clave_institucion' => 'UNIVDEP',
            'activo' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        P06Instituciones::create([
            'nombre_institucion' => 'INSTITUTO TECNOLÓGICO DE LA CONSTRUCCIÓN',
            'acronimo_institucion' => 'ITC',
            'clave_institucion' => 'ITC',
            'activo' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        P06Instituciones::create([
            'nombre_institucion' => 'CENTRO UNIVERSITARIO INTERNACIONAL',
            'acronimo_institucion' => 'CUIN',
            'clave_institucion' => 'CUIN',
            'activo' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
