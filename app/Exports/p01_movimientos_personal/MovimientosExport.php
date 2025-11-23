<?php

namespace App\Exports\p01_movimientos_personal;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MovimientosExport extends DefaultValueBinder implements 
    FromCollection, 
    ShouldAutoSize, 
    WithStrictNullComparison,
    WithCustomStartCell, 
    WithHeadings, 
    WithMapping, 
    WithCustomValueBinder,
    WithStyles, 
    WithEvents {
    
    use RegistersEventListeners;

    protected $movimientos;
    protected $tipoMovimiento;

    public function __construct($tipoMovimiento, $movimientos) {
        $this->movimientos = $movimientos;
        $this->tipoMovimiento = $tipoMovimiento;
    }

    public function startCell(): string {
        return 'A2';
    }

    public function headings(): array {
        return [
            "Folio", 
            "ID Unidad Administrativa", 
            "Unidad Administrativa", 
            "ID Sociedad", 
            "Fecha de Nacimiento", 
            "Nombre del Empleado",
            "Apellido Paterno",
            "Apellido Materno",
            "RFC",
            "Homoclave",
            "Número S.S.",
            "CURP",
            "Número de Expediente",
            "Número de Empleado",
            "Nacionalidad",
            "Estado Civil",
            "Sexo",
            "Calle",
            "Núm. Interior",
            "Núm. Exterior",
            "Colonia",
            "Entidad",
            "C.P.",
            "Teléfono",
            "Fecha de Inicio",
            "Fecha de Fin",
            "Contrato SAR",
            "Código de Movimiento",
            "Pagaduría",
            "Modo de Pago",
            "Banco",
            "Agencia",
            "Número de Cuenta",
            "Modo de depósito",
            "Registra Asistencia",
            "Contrato Interno",
            "Tipo de Salario",
            "Turno",
            "Grado",
            "Zona Pagadora",
            "Número de Plaza",
            "Situación de Plaza",
            "Situación de Empleado",
            "Código de Puesto",
            "Nivel",
            "Universo",
            "Denominación de Puesto",
            "Fecha de elaboración",
            "Quincena Procesado",
            "Año Procesado",
            "Fecha fin de contrato",
            "Régimen ISSSTE",
            "Centro de trabajo",
            "Delegación"
        ];
    }

    /**
    * @var Invoice $invoice
    */
    public function map($candidato): array {  
        $dataRow = [
            $candidato->folio,
            $candidato->area->unidadAdministrativa->identificador,
            $candidato->area->unidadAdministrativa->nombre,
            $candidato->sociedad_id,
            $candidato->fecha_nacimiento,
            $candidato->nombre_empleado,
            $candidato->apellido_paterno,
            $candidato->apellido_materno,
            $candidato->rfc,
            substr($candidato->rfc, -3),
            $candidato->numero_seguridad_social,
            $candidato->curp,
            $candidato->numero_expediente,
            $candidato->numero_empleado,
            $candidato->nacionalidad,
            $candidato->estadoCivil->nombre ?? "",
            substr($candidato->sexo->nombre ?? "", 0, 1),
            $candidato->calle,
            $candidato->numero_interior,
            $candidato->numero_exterior,
            $candidato->colonia,
            $candidato->entidadFederativaDomicilio->nombre ?? "",
            $candidato->cp,
            $candidato->telefono,
            $candidato->fecha_propuesta_inicio,
            $candidato->fecha_fin,
            $candidato->contrato_sar,
            $candidato->tipoMovimiento->codigo ?? "",
            $candidato->pagaduria,
            $candidato->tipoPago->abreviatura ?? "",
            $candidato->banco->nombre ?? "",
            $candidato->agencia,
            $candidato->numero_cuenta_bancaria,
            $candidato->modo_deposito,
            $candidato->asistencia,
            $candidato->contrato_interno,
            $candidato->tipo_salario,
            $candidato->turno->nombre ?? "",
            $candidato->grado,
            $candidato->zonaPagadora->identificador ?? "",
            $candidato->numero_plaza,
            $candidato->situacionPlaza->nombre ?? "",
            $candidato->situacionEmpleado->nombre ?? "",
            $candidato->codigo_puesto,
            $candidato->nivelSalarial->nombre ?? "",
            $candidato->universo->nombre ?? "",
            $candidato->denominacion_puesto,
            $candidato->fecha_elaboracion,
            $candidato->qna_procesado,
            $candidato->anio_procesado,
            $candidato->fecha_fin_contrato,
            $candidato->regimenIssste->nombre ?? "",
            $candidato->centro_trabajo,
            $candidato->municipio_alcaldia,
        ];

        return $dataRow;
    }

    public function collection() {
        return $this->movimientos;
    }

    public function bindValue(Cell $cell, $value)
    {
        if (is_numeric($value)) {
            $cell->setValueExplicit($value, DataType::TYPE_STRING);

            return true;
        }

        return parent::bindValue($cell, $value);
    }

    public function styles(Worksheet $sheet) {
        return [
            2 => [
                'font' => [
                    'name', 'Calibri',
                    'bold' => true,
                ]
            ]
        ];
    }

    public function registerEvents(): array {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
                $event->sheet->setCellValue('A1', "Reporte Agregado de Movimientos de Personal - $this->tipoMovimiento");
                $event->sheet->getDelegate()->mergeCells("A1:BB1");
                $event->sheet->styleCells('A1', [
                    'font' => [
                        'bold' => true,
                        'size' => 18
                    ]
                ]);
            }
        ];
    }

}
