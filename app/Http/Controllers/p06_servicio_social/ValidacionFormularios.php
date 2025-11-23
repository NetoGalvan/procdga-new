<?php

namespace App\Http\Controllers\p06_servicio_social;
use Illuminate\Support\Facades\Validator;

trait ValidacionFormularios
{

    public function validarNuevaEscuela($data){
        $validandoDatos = [
            'nombreNuevaEscuela' => 'required',
            'acronimoNuevaEscuela' => 'required',
            'direccionNuevaEscuela' => 'required',
            'nombrePrograma' => 'required',
            'clavePrograma' => 'required',
            'numeroPrograma' => 'required',
        ];

        $message = [
            'nombreNuevaEscuela.required' => 'Campo obligatorio',
            'acronimoNuevaEscuela.required' => 'Campo obligatorio',
            'direccionNuevaEscuela.required' => 'Campo obligatorio',
            'nombrePrograma.required' => 'Campo obligatorio',
            'clavePrograma.required' => 'Campo obligatorio',
            'numeroPrograma.required' => 'Campo obligatorio',
        ];

        $validator = Validator::make($data, $validandoDatos, $message);

        return $validator;
    }

    public function validarT02($data){
        $validandoDatos = [
            'fecha_cita' => ['required', 'regex:/^([0-2][0-9]|3[0-1])(\/|-)(0[1-9]|1[0-2])\2(\d{4})$/'],
            'hora_cita' => 'required',
            // 'nombre_empleado' => 'required|max:30|regex:/^[\pL\s\-]+$/u',
        ];

        $message = [
            'fecha_cita.required' => 'Campo obligatorio',
            'fecha_cita.regex' => 'Formato de fecha incorrecto',

            'hora_cita.required' => 'Campo obligatorio',
        ];

        $validator = Validator::make($data, $validandoDatos, $message);

        return $validator;
    }

}
