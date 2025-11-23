<?php

namespace App\Exports\p01_movimientos_personal;

use App\Models\p01_movimientos_personal\MovimientoPersonal;
use App\Models\historico\lbpm_dga\HistoricoMovimientoPersonal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

class ReporteMovimientosExport extends DefaultValueBinder implements 
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

    protected $movimientosPersonal;

    public function __construct($movimientosPersonal) {
        $this->movimientosPersonal = $movimientosPersonal;
    }

    public function startCell(): string {
        return 'A2';
    }

    public function headings(): array {
        return [
            "Código de Movimiento",
            "Qna",
            "Unidad Administrativa",
            "Folio",
            "Nombre de Empleado",
            "Apellido Paterno",
            "Apellido Materno",
            "Número de Empleado",
            "Código de Puesto",
            "Número de Plaza",
            "Teléfono celular",
            "Email"
        ];
    }

    /**
    * @var Invoice $invoice
    */
    public function map($candidato): array {  
        $dataRow = [
            $candidato->tipoMovimiento->codigo . " - " . $candidato->tipoMovimiento->descripcion,
            $candidato->qna_procesado,
            $candidato->area->unidadAdministrativa->nombre,
            $candidato->folio,
            $candidato->nombre_empleado,
            $candidato->apellido_paterno,
            $candidato->apellido_materno,
            $candidato->numero_empleado,
            $candidato->codigo_puesto,
            $candidato->numero_plaza,
            $candidato->telefono_celular,
            $candidato->email,
        ];

        return $dataRow;
    }

    public function collection() {
        return $this->movimientosPersonal;
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
                $event->sheet->setCellValue('A1', "Reporte de movimientos de personal");
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
