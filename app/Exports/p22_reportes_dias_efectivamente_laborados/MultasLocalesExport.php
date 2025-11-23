<?php

namespace App\Exports\p22_reportes_dias_efectivamente_laborados;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;

class MultasLocalesExport extends DefaultValueBinder implements FromCollection,
    ShouldAutoSize, 
    WithStrictNullComparison,
    WithCustomStartCell, 
    WithHeadings, 
    WithMapping, 
    WithCustomValueBinder,
    WithStyles, 
    WithEvents {

    use RegistersEventListeners;

    protected $empleados;
    protected $p22_reporte_id;
    protected $nombre_periodo_evaluacion;

    public function __construct($p22_reporte_id, $empleados, $nombre_periodo_evaluacion) {
        $this->empleados = $empleados;
        $this->p22_reporte_id = $p22_reporte_id;
        $this->nombre_periodo_evaluacion = $nombre_periodo_evaluacion;
    }

    public function startCell(): string {
        return 'A4';
    }

    public function headings(): array {
        return [
            "Núm empleado", 
            "Nombre del empleado", 
            "RFC", 
            "Nivel salarial", 
            "Seccion sindical", 
            "Unidad administrativa",
            "Unidad administrativa",
            // "Sub unidad",
            "Días laborables",
            "Días no laborados",
            "Días efectivamente laborados",
        ];
    }

        /**
    * @var Invoice $invoice
    */
    public function map($empleado): array {  
        $dataRow = [
            $empleado->numero_empleado,
            $empleado->nombre_empleado . " " . $empleado->apellido_paterno . " " . $empleado->apellido_materno,
            $empleado->rfc,
            $empleado->nivel_salarial,
            $empleado->seccion_sindical,
            $empleado->identificador_unidad,
            $empleado->nombre_unidad,
            // $empleado->created_by_ou,
            null,
            null,
            null,
        ];

        return $dataRow;
    }

    public function collection() {
        return $this->empleados;
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
            4 => [
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
                $event->sheet->setCellValue('A1', "Secretaría de Administración y Finanzas de la Ciudad de México");
                $event->sheet->getDelegate()->mergeCells("A1:H1");
                $event->sheet->styleCells('A1', [
                    'font' => [
                        'bold' => true,
                        'size' => 14
                    ]
                ]);
                $event->sheet->setCellValue('A2', "Periodo de evaluación: $this->nombre_periodo_evaluacion");
                $event->sheet->getDelegate()->mergeCells("A2:H2");
                $event->sheet->styleCells('A2', [
                    'font' => [
                        'bold' => true,
                        'size' => 12
                    ]
                ]);
            }
        ];
    }
    
}
