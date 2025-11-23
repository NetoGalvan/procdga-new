<?php

namespace Database\Seeders\p06_servicio_social;

use Illuminate\Database\Seeder;
use App\Models\p06_servicio_social\P06Prestador;
use App\Models\p06_servicio_social\P06Escuela;
use App\Models\EntidadFederativa;
use App\Models\p06_servicio_social\P06ProgramasInstitucion;

class PrestadorSeeder extends Seeder
{
    public function run()
    {
        $prestador = P06Prestador::create([
            'escuela_id' => P06Escuela::where('acronimo_escuela', 'ENP 6')->first()->escuela_id,
            'programa_id' => P06ProgramasInstitucion::where('clave_programa', 'like','UNAM-%')->first()->programa_id,
            //'entidad_federativa_id' => EntidadFederativa::where('abreviatura', 'MC')->first()->entidad_federativa_id,
            'tipo_prestador' => 'SERVICIO SOCIAL',
            'primer_apellido' => 'ESPARZA',
            'segundo_apellido' => 'ESPARZA',
            'nombre_prestador' => 'EDUARDO PETER',
            'activo' => true,
            'telefono' => '5562352012',
            'email' => 'peter@gmail.com',
            'carrera' => 'SISTEMAS',
            'matricula' => 123520,
            'calle' => 'ZOPILOTE',
            'numero_exterior' => '15',
            'ciudad' => 'CIUDAD NEZAHUALCOYOTL',
            'colonia' => 'EVOLUCIÓN SÊPER 43',
            'cp' => 57750,
            'municipio_id' => 717,
            'horario_tentativo' => '9:00 - 15:00',
            'total_horas' => 480,
            'nombre_funcionario' => 'PEDRO INOJOSA',
            'puesto_funcionario' => 'DIRECTOR INSTITUCIONAL',
            'telefono_funcionario' => 5532698523,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $prestador = P06Prestador::create([
            'escuela_id' => P06Escuela::where('acronimo_escuela', 'CECYT 15')->first()->escuela_id,
            'programa_id' => P06ProgramasInstitucion::where('clave_programa', 'like', 'IPN%')->first()->programa_id,
            //'entidad_federativa_id' => EntidadFederativa::where('abreviatura', 'MC')->first()->entidad_federativa_id,
            'tipo_prestador' => 'SERVICIO SOCIAL',
            'activo' => true,
            'primer_apellido' => 'ESPINOZA',
            'segundo_apellido' => 'RENDON',
            'nombre_prestador' => 'JULIO',
            'telefono' => '5562150210',
            'observaciones' => 'NADA',
            'horario_tentativo' => '9:00 - 15:00',
            'email' => 'julio@gmail.com',
            'carrera' => 'DERECHO',
            'matricula' => 133510,
            'calle' => 'ROSA',
            'numero_exterior' => '50',
            'cp' => 57750,
            'colonia' => 'EVOLUCIÓN SÊPER 43',
            'ciudad' => 'CIUDAD NEZAHUALCOYOTL',
            'municipio_id' => 717,
            'total_horas' => 480,
            'nombre_funcionario' => 'TATIANA LOPEZ',
            'puesto_funcionario' => 'DIRECTORA INSTITUCIONAL',
            'telefono_funcionario' => 553269853,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $prestador = P06Prestador::create([
            'escuela_id' => P06Escuela::where('acronimo_escuela', 'FES ZARAGOZA')->first()->escuela_id,
            'programa_id' => P06ProgramasInstitucion::where('clave_programa', 'like', 'UNAM%')->first()->programa_id,
            //'entidad_federativa_id' => EntidadFederativa::where('abreviatura', 'CDMX')->first()->entidad_federativa_id,
            'tipo_prestador' => 'SERVICIO SOCIAL',
            'activo' => true,
            'primer_apellido' => 'SOLORSANO',
            'segundo_apellido' => 'GUTIERREZ',
            'nombre_prestador' => 'ENRIQUE',
            'telefono' => '5585201002',
            'observaciones' => 'NADA',
            'horario_tentativo' => '9:00 - 15:00',
            'email' => 'quique@gmail.com',
            'carrera' => 'PSICOLOGIA',
            'matricula' => 153510,
            'calle' => 'ALCATRAZ',
            'numero_exterior' => '200',
            'cp' => 57750,
            'colonia' => 'EVOLUCIÓN SÊPER 43',
            'ciudad' => 'CIUDAD NEZAHUALCOYOTL',
            'municipio_id' => 717,
            'total_horas' => 480,
            'nombre_funcionario' => 'DANIEL RAUL',
            'puesto_funcionario' => 'DOCENTE INSTITUCIONAL',
            'telefono_funcionario' => 5552684202,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $prestador = P06Prestador::create([
            'escuela_id' => P06Escuela::where('acronimo_escuela', 'COLBACH 4')->first()->escuela_id,
            'programa_id' => P06ProgramasInstitucion::where('clave_programa', 'like', 'COLBACH%')->first()->programa_id,
            //'entidad_federativa_id' => EntidadFederativa::where('abreviatura', 'CDMX')->first()->entidad_federativa_id,
            'tipo_prestador' => 'SERVICIO SOCIAL',
            'activo' => true,
            'primer_apellido' => 'TORRES',
            'segundo_apellido' => 'TORRES',
            'nombre_prestador' => 'LINDA GABRIELA',
            'telefono' => '5502021454',
            'observaciones' => 'NADA',
            'horario_tentativo' => '9:00 - 15:00',
            'email' => 'linda@gmail.com',
            'carrera' => 'MEDICINA',
            'matricula' => 120020,
            'calle' => 'GAVILAN',
            'numero_exterior' => '120',
            'cp' => 57750,
            'colonia' => 'EVOLUCIÓN SÊPER 43',
            'ciudad' => 'CIUDAD NEZAHUALCOYOTL',
            'municipio_id' => 717,
            'total_horas' => 480,
            'nombre_funcionario' => 'BARRY CRIPKY',
            'puesto_funcionario' => 'DIRECTOR',
            'telefono_funcionario' => 5532620523,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $prestador = P06Prestador::create([
            'escuela_id' => P06Escuela::where('acronimo_escuela', 'CETIS 1')->first()->escuela_id,
            'programa_id' => P06ProgramasInstitucion::where('clave_programa', 'like', 'DGETI%')->first()->programa_id,
            //'entidad_federativa_id' => EntidadFederativa::where('abreviatura', 'CDMX')->first()->entidad_federativa_id,
            'tipo_prestador' => 'SERVICIO SOCIAL',
            'activo' => true,
            'primer_apellido' => 'LOPEZ',
            'segundo_apellido' => 'LOPEZ',
            'nombre_prestador' => 'EDUARDO JUAN',
            'telefono' => '5562565351',
            'observaciones' => 'NADA',
            'horario_tentativo' => '9:00 - 15:00',
            'email' => 'dado@gmail.com',
            'carrera' => 'PSICOLOGIA',
            'matricula' => 100320,
            'calle' => 'PURISIMA',
            'numero_exterior' => '90',
            'cp' => 57750,
            'colonia' => 'EVOLUCIÓN SÊPER 43',
            'ciudad' => 'CIUDAD NEZAHUALCOYOTL',
            'municipio_id' => 717,
            'total_horas' => 480,
            'nombre_funcionario' => 'ANTONIO RAMIREZ',
            'puesto_funcionario' => 'DIRECTOR DE LA DIVISION DE PSICOLOGIA',
            'telefono_funcionario' => 5532005523,
            'created_at' => now(),
            'updated_at' => now()
        ]);

    }
}
