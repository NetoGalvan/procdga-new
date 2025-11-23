<?php

namespace App\Exports\p02_tramites_issste\reportes;

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

class MovimientosISSSTEExport extends DefaultValueBinder implements
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

    protected $registros;

    public function __construct($registros) {
        $this->registros = $registros;
    }

    public function startCell(): string {
        return 'A2';
    }

    public function headings(): array {
        return [
            "Año",
            "Quincena",
            "Tipo de movimiento",
            "Unidad Administrativa",
            "Folio del movimiento",
            "Nombre de Empleado",
            "Apellido Paterno",
            "Apellido Materno"
        ];
    }

    /**
    * @var Invoice $invoice
    */
    public function map($registro): array {
        $dataRow = [
            $registro->anio,
            $registro->qna_procesado,
            $registro->tipo_movimiento_issste_nombre,
            $registro->nombre_unidad,
            $registro->folio_p01,
            $registro->nombre_empleado,
            $registro->apellido_paterno,
            $registro->apellido_materno
        ];

        return $dataRow;
    }

    public function collection() {
        return $this->registros;
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
                $event->sheet->setCellValue('A1', "Trámites gestionados ante el ISSSTE");
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
