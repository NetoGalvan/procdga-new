<?php

namespace App\Exports\p20_premio_puntualidad_asistencia;

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

class LayoutHistorico extends DefaultValueBinder implements FromCollection,
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

    public function __construct($empleados) {
        $this->empleados = $empleados;
    }

    public function startCell(): string {
        return 'A1';
    }

    public function headings(): array {
        return [
            "Número de empleado",
            // "algo 1122",
            "Fecha inicio evaluacion",
            "Fecha fin evaluacion",
            // "algo 000000000(9)",
            // "algo 1",
            // "algo 0000000(7)",
            "Unidad administrativa",
            "Nombre empleado"
        ];
    }

    public function map($empleado): array {  
        $dataRow = [
            "000".$empleado->numero_empleado,
            // 1122,
            $empleado->fecha_inicio_evaluacion,
            $empleado->fecha_fin_evaluacion,
            // "000000000",
            // 1,
            // "0000000",
            $empleado->created_by_ou."00000",
            $empleado->apellido_paterno . " " . $empleado->apellido_materno . " " . $empleado->nombre_empleado,
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
            1 => [
                'font' => [
                    'name', 'Calibri',
                    'bold' => true,
                ]
            ]
        ];
    }
}
