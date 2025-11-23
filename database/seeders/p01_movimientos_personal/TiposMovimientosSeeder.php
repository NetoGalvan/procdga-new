<?php

namespace Database\Seeders\p01_movimientos_personal;

use App\Models\p01_movimientos_personal\TipoMovimiento;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TiposMovimientosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        TipoMovimiento::create([
            'codigo' => '101',
            'descripcion' => 'ALTA DE NUEVO INGRESO',
            'tipo' => 'ALTAS',
            'identificador' => '101',
        ]);
        TipoMovimiento::create([
            'codigo' => '102',
            'descripcion' => 'ALTA POR REINGRESO',
            'tipo' => 'ALTAS',
            'identificador' => '102',
        ]);
        TipoMovimiento::create([
            'codigo' => '113',
            'descripcion' => 'INCORPORACIÓN CON LICENCIA',
            'tipo' => 'ALTAS',
            'identificador' => '113'
        ]);
        TipoMovimiento::create([
            'codigo' => '114',
            'descripcion' => 'RECONTRATACIÓN INTERINATO',
            'tipo' => 'ALTAS',
            'identificador' => '114'
        ]);
        TipoMovimiento::create([
            'codigo' => '601',
            'descripcion' => 'PROMOCIÓN ASCENDENTE',
            'tipo' => 'ALTAS',
            'identificador' => '601',
        ]);
        TipoMovimiento::create([
            'codigo' => '602',
            'descripcion' => 'PROMOCIÓN DESCENDENTE',
            'tipo' => 'ALTAS',
            'identificador' => '602',
        ]);
        TipoMovimiento::create([
            'codigo' => '603',
            'descripcion' => 'MOVIMIENTO HORIZONTAL',
            'tipo' => 'ALTAS',
            'identificador' => '603',
        ]);
        TipoMovimiento::create([
            'codigo' => '604',
            'descripcion' => 'CAMBIO ASCENDENTE CONTRATO INTERINO',
            'tipo' => 'ALTAS',
            'identificador' => '604',
        ]);
        TipoMovimiento::create([
            'codigo' => '605',
            'descripcion' => 'CAMBIO DESCENDENTE CONTRATO INTERINO',
            'tipo' => 'ALTAS',
            'identificador' => '605',
        ]);
        TipoMovimiento::create([
            'codigo' => '606',
            'descripcion' => 'CAMBIO HORIZONTAL CONTRATO INTERINO',
            'tipo' => 'ALTAS',
            'identificador' => '606',
        ]);
        TipoMovimiento::create([
            'codigo' => '201',
            'descripcion' => 'BAJA POR RENUNCIA',
            'tipo' => 'BAJAS',
            'identificador' => '201',
        ]);
        TipoMovimiento::create([
            'codigo' => '202',
            'descripcion' => 'BAJA POR DEFUNCIÓN',
            'tipo' => 'BAJAS',
            'identificador' => '202',
        ]);
        TipoMovimiento::create([
            'codigo' => '203',
            'descripcion' => 'BAJA JUBILACIÓN',
            'tipo' => 'BAJAS',
            'identificador' => '203'
        ]);
        TipoMovimiento::create([
            'codigo' => '204',
            'descripcion' => 'BAJA POR ABANDONO DE EMPLEO',
            'tipo' => 'BAJAS',
            'identificador' => '204'
        ]);
        TipoMovimiento::create([
            'codigo' => '205',
            'descripcion' => 'BAJA RESOLUCIÓN ADMIN. O  LAUDO SIN INHAB',
            'tipo' => 'BAJAS',
            'identificador' => '205'
        ]);
        TipoMovimiento::create([
            'codigo' => '206',
            'descripcion' => 'BAJA INCOMPATIBILIDAD DE EMPLEOS',
            'tipo' => 'BAJAS',
            'identificador' => '206'
        ]);
        TipoMovimiento::create([
            'codigo' => '207',
            'descripcion' => 'BAJA TERMINO DE NOMBRAMIENTO PROVISIONAL',
            'tipo' => 'BAJAS',
            'identificador' => '207'
        ]);
        TipoMovimiento::create([
            'codigo' => '208',
            'descripcion' => 'BAJA TERMINO DE INTERINATO O BECA',
            'tipo' => 'BAJAS',
            'identificador' => '208',
        ]);
        TipoMovimiento::create([
            'codigo' => '209',
            'descripcion' => 'BAJA TERMINO DE CONTRATO DE HONORARIOS',
            'tipo' => 'BAJAS',
            'identificador' => '209',
        ]);
        TipoMovimiento::create([
            'codigo' => '210',
            'descripcion' => 'BAJA RESCISIÓN DE CONTRATO DE HONORARIOS',
            'tipo' => 'BAJAS',
            'identificador' => '210',
        ]);
        TipoMovimiento::create([
            'codigo' => '211',
            'descripcion' => 'CANCELACIÓN ALTAS INSUBSIST NOMBRAMIENTO',
            'tipo' => 'BAJAS',
            'identificador' => '211',
        ]);
        TipoMovimiento::create([
            'codigo' => '212',
            'descripcion' => 'BAJA INCAPACIDAD FÍSICA Y/O MENTAL PERMANENTE',
            'tipo' => 'BAJAS',
            'identificador' => '212',
        ]);
        TipoMovimiento::create([
            'codigo' => '213',
            'descripcion' => 'BAJA ACUMULACIÓN DE FALTAS O NOTAS MALAS',
            'tipo' => 'BAJAS',
            'identificador' => '213'
        ]);
        TipoMovimiento::create([
            'codigo' => '214',
            'descripcion' => 'BAJA CONVENIR AL BUEN SERVICIO',
            'tipo' => 'BAJAS',
            'identificador' => '214'
        ]);
        TipoMovimiento::create([
            'codigo' => '215',
            'descripcion' => 'BAJA SENTENCIA JUD O ADMIN CON INHABILITACION',
            'tipo' => 'BAJAS',
            'identificador' => '215'
        ]);
        TipoMovimiento::create([
            'codigo' => '216',
            'descripcion' => 'BAJA SENTENCIA JUD O ADMIN SIN INHABILITACION',
            'tipo' => 'BAJAS',
            'identificador' => '216'
        ]);
        TipoMovimiento::create([
            'codigo' => '217',
            'descripcion' => 'BAJA SUPRESIÓN DE PUESTO DE CONFIANZA',
            'tipo' => 'BAJAS',
            'identificador' => '217',
        ]);
        TipoMovimiento::create([
            'codigo' => '218',
            'descripcion' => 'BAJA TÉRMINO ANTICIPADO DE BECA',
            'tipo' => 'BAJAS',
            'identificador' => '218'
        ]);
        TipoMovimiento::create([
            'codigo' => '219',
            'descripcion' => 'BAJA POR RETIRO VOLUNTARIO', 
            'tipo' => 'BAJAS',
            'identificador' => '219'
        ]);
        TipoMovimiento::create([
            'codigo' => '220',
            'descripcion' => 'BAJA DETERMINACIÓN DE CONSEJO DE HONOR Y JUSTICIA',
            'tipo' => 'BAJAS',
            'identificador' => '220'
        ]);
        TipoMovimiento::create([
            'codigo' => '221',
            'descripcion' => 'BAJA POR PENSIÓN',
            'tipo' => 'BAJAS',
            'identificador' => '221'
        ]);
        TipoMovimiento::create([
            'codigo' => '222',
            'descripcion' => 'BAJA RESOLUCIÓN ADMIN O LAUDO C/INHABILITACION',
            'tipo' => 'BAJAS',
            'identificador' => '222'
        ]);
        TipoMovimiento::create([
            'codigo' => '301',
            'descripcion' => 'LICENCIA CON SUELDO PREJUBILATORIA',
            'tipo' => 'BAJAS',
            'identificador' => '301'
        ]);
        TipoMovimiento::create([
            'codigo' => '303',
            'descripcion' => 'LICENCIA SIN SUELDO LIMITADA',
            'tipo' => 'BAJAS',
            'identificador' => '303'
        ]);
        TipoMovimiento::create([
            'codigo' => '305',
            'descripcion' => 'LICENCIA SIN SUELDO ILIMITADA',
            'tipo' => 'BAJAS',
            'identificador' => '305'
        ]);
        TipoMovimiento::create([
            'codigo' => '313',
            'descripcion' => 'PRÓRROGA DE LICENCIA SIN SUELDO LIMITADA',
            'tipo' => 'BAJAS',
            'identificador' => '313'
        ]);
        
        TipoMovimiento::create([
            'codigo' => '801',
            'descripcion' => 'SUSPENSIÓN DE PAGO POR BAJA PREVENTIVA',
            'tipo' => 'BAJAS',
            'identificador' => '801'
        ]);
        TipoMovimiento::create([
            'codigo' => '804',
            'descripcion' => 'SUSPENSIÓN DE PAGO POR ENFERMEDAD CONTAGIOSA',
            'tipo' => 'BAJAS',
            'identificador' => '804',
        ]);
        TipoMovimiento::create([
            'codigo' => '821',
            'descripcion' => 'SUSPENSIÓN DE PAGO POR SANCIÓN ADMINISTRATIVA',
            'tipo' => 'BAJAS',
            'identificador' => '821'
        ]);
        TipoMovimiento::create([
            'codigo' => '831',
            'descripcion' => 'SUSPENSIÓN DE PAGO POR PROCESO JUDICIAL',
            'tipo' => 'BAJAS',
            'identificador' => '831',
        ]);
        TipoMovimiento::create([
            'codigo' => '401',
            'descripcion' => 'REANUDACION LABORES TÉRMINO LICENCIA CON SUELDO',
            'tipo' => 'REANUDACIONES',
            'identificador' => '401'
        ]);
        TipoMovimiento::create([
            'codigo' => '402',
            'descripcion' => 'REANUDACIÓN LABORES TÉRMINO LICENCIA MEDIO SUELDO',
            'tipo' => 'REANUDACIONES',
            'identificador' => '402',
        ]);
        TipoMovimiento::create([
            'codigo' => '403',
            'descripcion' => 'REANUDACIÓN LABORES TÉRMINO LICENCIA SIN SUELDO',
            'tipo' => 'REANUDACIONES',
            'identificador' => '403'
        ]);
        TipoMovimiento::create([
            'codigo' => '404',
            'descripcion' => 'REANUDACIÓN TERMINO ANTICIPADO LICENCIA Y SUSPENSIÓN',
            'tipo' => 'REANUDACIONES',
            'identificador' => '404'
        ]);
        TipoMovimiento::create([
            'codigo' => '411',
            'descripcion' => 'REANUDACIÓN PAGO INSUBSIS DE BAJA PREVEN',
            'tipo' => 'REANUDACIONES',
            'identificador' => '411'
        ]);
        TipoMovimiento::create([
            'codigo' => '421',
            'descripcion' => 'REANUDACIÓN PAGO TÉRMINO DE SUSPENSIÓN',
            'tipo' => 'REANUDACIONES',
            'identificador' => '421'
        ]);
        TipoMovimiento::create([
            'codigo' => '422',
            'descripcion' => 'REANUDACIÓN PAGO INSUBSISTENCIA DE SUSPENSIÓN',
            'tipo' => 'REANUDACIONES',
            'identificador' => '422'
        ]);
        TipoMovimiento::create([
            'codigo' => '431',
            'descripcion' => 'REANUDACIÓN PAGO RESOLUCIÓN JUDICIAL',
            'tipo' => 'REANUDACIONES',
            'identificador' => '431'
        ]);
        TipoMovimiento::create([
            'codigo' => '433',
            'descripcion' => 'REUBICACIÓN INDIVIDUAL',
            'tipo' => 'REANUDACIONES',
            'identificador' => '433'
        ]);
        TipoMovimiento::create([
            'codigo' => '502',
            'descripcion' => 'REINSTALACIÓN POR LAUDO O SENTENCIA JUDICIAL', 
            'tipo' => 'REANUDACIONES',
            'identificador' => '502'
        ]);
    }
}
