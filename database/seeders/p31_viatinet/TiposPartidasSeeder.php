<?php

namespace Database\Seeders\p31_viatinet;

use App\Models\p31_viatinet\TipoPartida;
use Illuminate\Database\Seeder;

class TiposPartidasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoPartida::create([
            'nombre' => 'Pasajes aéreos nacionales',
            'identificador' => 'pasajes_aereos_nacionales',
            'numero' => '3711',
            'descripcion' => 'Asignaciones destinadas a cubrir los gastos de transportación aérea dentro del país,
            por cualesquiera de los medios usuales, de servidores públicos cuando el desempeño de sus labores o comisiones lo requiera y
            según los tabuladores aprobados en cada caso. Se excluye el alquiler de los medios de transporte',
            'tipo_ambito_id' => 1,
        ]);

        TipoPartida::create([
            'nombre' => 'Pasajes aéreos internacionales',
            'identificador' => 'pasajes_aereos_internacionales',
            'numero' => '3712',
            'descripcion' => 'Asignaciones destinadas a cubrir los gastos de transportación aérea fuera del
            país, por cualesquiera de los medios usuales, de servidores públicos cuando el desempeño de sus labores o comisiones lo
            requiera y según los tabuladores aprobados en cada caso. Se excluye el alquiler de los medios de transporte.',
            'tipo_ambito_id' => 2,
        ]);

        TipoPartida::create([
            'nombre' => 'Pasajes terrestres nacionales',
            'identificador' => 'pasajes_terrestres_nacionales',
            'numero' => '3721',
            'descripcion' => ' Asignaciones destinadas a cubrir los gastos de transportación terrestre de personal
            nacional, por vía terrestre urbana y suburbana, y ferroviario, cuando el desempeño de sus labores o comisiones lo requiera y
            según los tabuladores aprobados en cada caso. Se excluye el alquiler de los medios de transporte y las erogaciones previstas en
            la partida3722.',
            'tipo_ambito_id' => 1,
        ]);

        TipoPartida::create([
            'nombre' => 'Pasajes terrestres internacionales',
            'identificador' => 'pasajes_terrestres_internacionales',
            'numero' => '3724',
            'descripcion' => ' Asignaciones destinadas a cubrir los gastos de transportación terrestre de
            personal internacional, por vía terrestre urbana y suburbana, y ferroviario, cuando el desempeño de sus labores o comisiones lo
            requiera y según los tabuladores aprobados en cada caso.',
            'tipo_ambito_id' => 2,
        ]);

        TipoPartida::create([
            'nombre' => 'Viáticos en el país',
            'identificador' => 'viaticos_nacionales',
            'numero' => '3751',
            'descripcion' => 'Asignaciones destinadas a cubrir los gastos por concepto de alimentación, hospedaje y
            arrendamiento de vehículos en el desempeño de comisiones temporales dentro del país, derivado de la realización de labores en
            campo o de supervisión e inspección, en lugares distintos a los de su adscripción. Esta partida aplica las cuotas diferenciales que
            señalen los tabuladores respectivos. Excluye los gastos de pasajes.',
            'tipo_ambito_id' => 1,
        ]);

        TipoPartida::create([
            'nombre' => 'Viáticos en el extranjero',
            'identificador' => 'viaticos_internacionales',
            'numero' => '3761',
            'descripcion' => 'o. Asignaciones destinadas a cubrir los gastos por concepto de alimentación, hospedaje y
            arrendamiento de vehículos en el desempeño de comisiones temporales fuera del país, derivado de la realización de labores en
            campo o de supervisión e inspección, en lugares distintos a los de su adscripción. Esta partida aplica las cuotas diferenciales que
            señalen los tabuladores respectivos. Excluye los gastos de pasajes.',
            'tipo_ambito_id' => 2,
        ]);

        TipoPartida::create([
            'nombre' => 'Servicios integrales de traslado y viáticos',
            'identificador' => 'servicios_integrales',
            'numero' => '3781',
            'descripcion' => 'Asignaciones destinadas a cubrir las erogaciones que realicen las
            unidades responsables del gasto por la contratación con personas físicas y morales de servicios diversos cuya desagregación no
            es realizable en forma específica para cada una de las partidas de gasto de este concepto, por tratarse de una combinación de
            servicios relacionados cuya prestación se estipula en forma integral y que en términos del costo total resulta en condiciones
            menos onerosas para las unidades responsables del gasto.
            '
        ]);
    }
}
