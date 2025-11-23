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

class EmpleadosAgregadosSubareas extends DefaultValueBinder implements FromCollection,
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

    public function __construct( $empleados ){
        $this->empleados = $empleados;
    }

    public function startCell(): string {
        return 'A3';
    }

    public function headings(): array{
        return [
            'ÁREA',
            'NÚMERO DE EMPLEADO',
            'NOMBRE DEL EMPLEADO',
            'RFC',
            'SECCIÓN SINDICAL',
            'NIVEL SALARIAL'
        ];
    }

    public function map($empleados): array {
        $dataRow = [
            $empleados->areaPremio->area->identificador . " - " . $empleados->areaPremio->area->nombre,
            $empleados->numero_empleado,
            $empleados->nombre_empleado . " " . $empleados->apellido_paterno . " " . $empleados->apellido_materno,
            $empleados->rfc,
            $empleados->seccion_sindical,
            $empleados->nivel_salarial
        ];

        return $dataRow;
    }

    public function collection(){
        return $this->empleados;
    }

    public function styles(Worksheet $sheet) {
        return [
            3 => [
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
                $event->sheet->setCellValue('A1', "Empleados agregados para el premio de puntualidad y asistencia");
                $event->sheet->getDelegate()->mergeCells("A1:C1");
                $event->sheet->styleCells('A1', [
                    'font' => [
                        'bold' => true,
                        'size' => 14
                    ]
                ]);
            }
        ];
    }
}
