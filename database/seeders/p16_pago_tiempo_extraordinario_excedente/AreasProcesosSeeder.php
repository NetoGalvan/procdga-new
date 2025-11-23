<?php

namespace Database\Seeders\p16_pago_tiempo_extraordinario_excedente;

use Illuminate\Database\Seeder;
use App\Models\p16_pago_tiempo_extraordinario_excedente\P16AreasProcesos;
use App\Models\Area;
use App\Models\Proceso;

class AreasProcesosSeeder extends Seeder
{
    public function run()
    {
        P16AreasProcesos::create([
            'area_id' => Area::where("identificador", "3.0")->first()->area_id,
            'proceso_id' => Proceso::where("identificador", "tiempo_extraordinario_excedente")->first()->proceso_id,
            'zona_pagadora' => '300000'
        ]);
        P16AreasProcesos::create([
            'area_id' => Area::where("identificador", "3.1")->first()->area_id,
            'proceso_id' => Proceso::where("identificador", "tiempo_extraordinario_excedente")->first()->proceso_id,
            'zona_pagadora' => '307100'
        ]);
        P16AreasProcesos::create([
            'area_id' => Area::where("identificador", "3.2")->first()->area_id,
            'proceso_id' => Proceso::where("identificador", "tiempo_extraordinario_excedente")->first()->proceso_id,
            'zona_pagadora' => '307100'
        ]);
        P16AreasProcesos::create([
            'area_id' => Area::where("identificador", "3.3")->first()->area_id,
            'proceso_id' => Proceso::where("identificador", "tiempo_extraordinario_excedente")->first()->proceso_id,
            'zona_pagadora' => '307200'
        ]);
        P16AreasProcesos::create([
            'area_id' => Area::where("identificador", "3.4")->first()->area_id,
            'proceso_id' => Proceso::where("identificador", "tiempo_extraordinario_excedente")->first()->proceso_id,
            'zona_pagadora' => '307200'
        ]);
        P16AreasProcesos::create([
            'area_id' => Area::where("identificador", "3.5")->first()->area_id,
            'proceso_id' => Proceso::where("identificador", "tiempo_extraordinario_excedente")->first()->proceso_id,
            'zona_pagadora' => '307300'
        ]);
        P16AreasProcesos::create([
            'area_id' => Area::where("identificador", "3.6")->first()->area_id,
            'proceso_id' => Proceso::where("identificador", "tiempo_extraordinario_excedente")->first()->proceso_id,
            'zona_pagadora' => '307400'
        ]);
        P16AreasProcesos::create([
            'area_id' => Area::where("identificador", "3.7")->first()->area_id,
            'proceso_id' => Proceso::where("identificador", "tiempo_extraordinario_excedente")->first()->proceso_id,
            'zona_pagadora' => '307500'
        ]);
        P16AreasProcesos::create([
            'area_id' => Area::where("identificador", "14.0")->first()->area_id,
            'proceso_id' => Proceso::where("identificador", "tiempo_extraordinario_excedente")->first()->proceso_id,
            'zona_pagadora' => '1400000'
        ]);
        P16AreasProcesos::create([
            'area_id' => Area::where("identificador", "11.5")->first()->area_id,
            'proceso_id' => Proceso::where("identificador", "tiempo_extraordinario_excedente")->first()->proceso_id,
            'zona_pagadora' => '1100000'
        ]);
        P16AreasProcesos::create([
            'area_id' => Area::where("identificador", "11.2")->first()->area_id,
            'proceso_id' => Proceso::where("identificador", "tiempo_extraordinario_excedente")->first()->proceso_id,
            'zona_pagadora' => '1110000'
        ]);
        P16AreasProcesos::create([
            'area_id' => Area::where("identificador", "11.4")->first()->area_id,
            'proceso_id' => Proceso::where("identificador", "tiempo_extraordinario_excedente")->first()->proceso_id,
            'zona_pagadora' => '1120000'
        ]);
        P16AreasProcesos::create([
            'area_id' => Area::where("identificador", "11.3")->first()->area_id,
            'proceso_id' => Proceso::where("identificador", "tiempo_extraordinario_excedente")->first()->proceso_id,
            'zona_pagadora' => '1130000'
        ]);
        P16AreasProcesos::create([
            'area_id' => Area::where("identificador", "11.6")->first()->area_id,
            'proceso_id' => Proceso::where("identificador", "tiempo_extraordinario_excedente")->first()->proceso_id,
            'zona_pagadora' => '1140000'
        ]);
        P16AreasProcesos::create([
            'area_id' => Area::where("identificador", "11.1")->first()->area_id,
            'proceso_id' => Proceso::where("identificador", "tiempo_extraordinario_excedente")->first()->proceso_id,
            'zona_pagadora' => '1150000'
        ]);
        P16AreasProcesos::create([
            'area_id' => Area::where("identificador", "95.0")->first()->area_id,
            'proceso_id' => Proceso::where("identificador", "tiempo_extraordinario_excedente")->first()->proceso_id,
            'zona_pagadora' => '9500000'
        ]);
        P16AreasProcesos::create([
            'area_id' => Area::where("identificador", "95.2")->first()->area_id,
            'proceso_id' => Proceso::where("identificador", "tiempo_extraordinario_excedente")->first()->proceso_id,
            'zona_pagadora' => '9550000'
        ]);
        P16AreasProcesos::create([
            'area_id' => Area::where("identificador", "95.3")->first()->area_id,
            'proceso_id' => Proceso::where("identificador", "tiempo_extraordinario_excedente")->first()->proceso_id,
            'zona_pagadora' => '9560000'
        ]);
        P16AreasProcesos::create([
            'area_id' => Area::where("identificador", "137.8")->first()->area_id,
            'proceso_id' => Proceso::where("identificador", "tiempo_extraordinario_excedente")->first()->proceso_id,
            'zona_pagadora' => '13700000'
        ]);
        P16AreasProcesos::create([
            'area_id' => Area::where("identificador", "138.0")->first()->area_id,
            'proceso_id' => Proceso::where("identificador", "tiempo_extraordinario_excedente")->first()->proceso_id,
            'zona_pagadora' => '13800000'
        ]);
        P16AreasProcesos::create([
            'area_id' => Area::where("identificador", "169.0")->first()->area_id,
            'proceso_id' => Proceso::where("identificador", "tiempo_extraordinario_excedente")->first()->proceso_id,
            'zona_pagadora' => '16900000'
        ]);
        P16AreasProcesos::create([
            'area_id' => Area::where("identificador", "199.0")->first()->area_id,
            'proceso_id' => Proceso::where("identificador", "tiempo_extraordinario_excedente")->first()->proceso_id,
            'zona_pagadora' => '19900000'
        ]);
        P16AreasProcesos::create([
            'area_id' => Area::where("identificador", "44.0")->first()->area_id,
            'proceso_id' => Proceso::where("identificador", "tiempo_extraordinario_excedente")->first()->proceso_id,
            'zona_pagadora' => '4400000'
        ]);
    }
}
