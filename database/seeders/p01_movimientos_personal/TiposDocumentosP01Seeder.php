<?php

namespace Database\Seeders\p01_movimientos_personal;

use App\Models\Proceso;
use App\Models\TipoDocumento;
use Illuminate\Database\Seeder;

class TiposDocumentosP01Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoDocumento::create([
            "nombre" => "Carta Compromiso de entrega de documentos. Debidamente firmado por la persona contratada.",
            "proceso_id" => Proceso::where("identificador", "movimientos_personal")->first()->proceso_id,
            "nombre_grupo" => "movimientos_personal"
        ]);
        TipoDocumento::create([
            "nombre" => "Formato de solicitud de empleo, totalmente requisitado con foto",
            "proceso_id" => Proceso::where("identificador", "movimientos_personal")->first()->proceso_id,
            "nombre_grupo" => "movimientos_personal"
        ]);
        TipoDocumento::create([
            "nombre" => "Original del acta de nacimiento",
            "proceso_id" => Proceso::where("identificador", "movimientos_personal")->first()->proceso_id,
            "nombre_grupo" => "movimientos_personal"
        ]);
        TipoDocumento::create([
            "nombre" => "Curriculum Vitae (actualizado). Formato del PROCDGA y el personal",
            "proceso_id" => Proceso::where("identificador", "movimientos_personal")->first()->proceso_id,
            "nombre_grupo" => "movimientos_personal"
        ]);
        TipoDocumento::create([
            "nombre" => "Copia de la Visa FM-3 expedida por la Secretaría de Gobernación, en caso de que el aspirante sea extranjero",
            "proceso_id" => Proceso::where("identificador", "movimientos_personal")->first()->proceso_id,
            "nombre_grupo" => "movimientos_personal"
        ]);
        TipoDocumento::create([
            "nombre" => "Copia de la credencial para votar con fotografía o del comprobante de su solicitud",
            "proceso_id" => Proceso::where("identificador", "movimientos_personal")->first()->proceso_id,
            "nombre_grupo" => "movimientos_personal"
        ]);
        TipoDocumento::create([
            "nombre" => "Copia del documento en donde conste la clave del Registro Federal de Contribuyentes (RFC)",
            "proceso_id" => Proceso::where("identificador", "movimientos_personal")->first()->proceso_id,
            "nombre_grupo" => "movimientos_personal"
        ]);
        TipoDocumento::create([
            "nombre" => "Copia del documento donde conste la Clave Única del Registro de Población (CURP).",
            "proceso_id" => Proceso::where("identificador", "movimientos_personal")->first()->proceso_id,
            "nombre_grupo" => "movimientos_personal"
        ]);
        TipoDocumento::create([
            "nombre" => "Copia del documento que acredite su nivel máximo de estudios.",
            "proceso_id" => Proceso::where("identificador", "movimientos_personal")->first()->proceso_id,
            "nombre_grupo" => "movimientos_personal"
        ]);
        TipoDocumento::create([
            "nombre" => "Copia del comprobante de domicilio (menos el recibo de luz).",
            "proceso_id" => Proceso::where("identificador", "movimientos_personal")->first()->proceso_id,
            "nombre_grupo" => "movimientos_personal"
        ]);
        TipoDocumento::create([
            "nombre" => "Escrito en el que manifieste bajo protesta de decir verdad que no tiene otro empleo en el GDF y que no ha celebrado contrato alguno como prestador de servicios con el mismo GDF.",
            "proceso_id" => Proceso::where("identificador", "movimientos_personal")->first()->proceso_id,
            "nombre_grupo" => "movimientos_personal"
        ]);
        TipoDocumento::create([
            "nombre" => "Escrito en el que manifieste que da su autorización para que el área de Recursos Humanos consulte en la CGDF si se encuentra inhabilitado para ocupar un empleo en el servicio público y que en el caso de que se encuentre inhabilitado, quedará enterado de que no podrá ingresar a laborar en el GDF.",
            "proceso_id" => Proceso::where("identificador", "movimientos_personal")->first()->proceso_id,
            "nombre_grupo" => "movimientos_personal"
        ]);
        TipoDocumento::create([
            "nombre" => "Escrito en el que se manifieste si tiene otro empleo fuera de la APDF y si en dicho empleo se aplica el crédito al salario que establece la LISR.",
            "proceso_id" => Proceso::where("identificador", "movimientos_personal")->first()->proceso_id,
            "nombre_grupo" => "movimientos_personal"
        ]);
        TipoDocumento::create([
            "nombre" => "Escrito de manifestación del empleado de no haber sido sujeto de jubilación mediante incorporación a programas de retiro con apoyo económico.",
            "proceso_id" => Proceso::where("identificador", "movimientos_personal")->first()->proceso_id,
            "nombre_grupo" => "movimientos_personal"
        ]);
        TipoDocumento::create([
            "nombre" => "Formato de propuesta del movimiento con Visto Bueno del C. Secretario de Finanzas (sólo estructura).",
            "proceso_id" => Proceso::where("identificador", "movimientos_personal")->first()->proceso_id,
            "nombre_grupo" => "movimientos_personal"
        ]);
        TipoDocumento::create([
            "nombre" => "Acuse de recibido de notificación donde se le informe que debe presentar declaración de Situación Patrimonial (sólo estructura).",
            "proceso_id" => Proceso::where("identificador", "movimientos_personal")->first()->proceso_id,
            "nombre_grupo" => "movimientos_personal"
        ]);
        TipoDocumento::create([
            "nombre" => "Acuse de entrega del documento con las funciones del área a la que se incorpora el personal contratado (sólo estructura).",
            "proceso_id" => Proceso::where("identificador", "movimientos_personal")->first()->proceso_id,
            "nombre_grupo" => "movimientos_personal"
        ]);
        TipoDocumento::create([
            "nombre" => "Formato del Seguro de Vida Institucional debidamente requisitado y firmado (designación de beneficiarios)",
            "proceso_id" => Proceso::where("identificador", "movimientos_personal")->first()->proceso_id,
            "nombre_grupo" => "movimientos_personal"
        ]);
        TipoDocumento::create([
            "nombre" => "Formato de Cédula de análisis de puesto (sólo estructura).",
            "proceso_id" => Proceso::where("identificador", "movimientos_personal")->first()->proceso_id,
            "nombre_grupo" => "movimientos_personal"
        ]);
        TipoDocumento::create([
            "nombre" => "Formato de Cédula básica de información personal.",
            "proceso_id" => Proceso::where("identificador", "movimientos_personal")->first()->proceso_id,
            "nombre_grupo" => "movimientos_personal"
        ]);
        TipoDocumento::create([
            "nombre" => "En caso de haber laborado en el GDF, 1 copia de su último talón de pago.",
            "proceso_id" => Proceso::where("identificador", "movimientos_personal")->first()->proceso_id,
            "nombre_grupo" => "movimientos_personal"
        ]);
        TipoDocumento::create([
            "nombre" => "En caso de contar con licencia sin goce de sueldo entregar 1 copia (sólo estructura).",
            "proceso_id" => Proceso::where("identificador", "movimientos_personal")->first()->proceso_id,
            "nombre_grupo" => "movimientos_personal"
        ]);
        TipoDocumento::create([
            "nombre" => "En caso de venir de otra dependencia del GDF, 1 copia de su baja.",
            "proceso_id" => Proceso::where("identificador", "movimientos_personal")->first()->proceso_id,
            "nombre_grupo" => "movimientos_personal"
        ]);
        TipoDocumento::create([
            "nombre" => "Constancia de no inhabilitación expedida por la Secretaría de la Función Pública.",
            "proceso_id" => Proceso::where("identificador", "movimientos_personal")->first()->proceso_id,
            "nombre_grupo" => "movimientos_personal"
        ]);
        TipoDocumento::create([
            "nombre" => "Carta de obligaciones de los servidores públicos.",
            "proceso_id" => Proceso::where("identificador", "movimientos_personal")->first()->proceso_id,
            "nombre_grupo" => "movimientos_personal"
        ]);         
    }
}
