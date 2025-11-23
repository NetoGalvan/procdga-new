<?php

namespace App\Exports\p16_pago_tiempo_extraordinario_excedente;

// use App\Models\p16_pago_tiempo_extraordinario_excedente\P16HorasPorEmpleado;
// use Illuminate\Contracts\View\View;
// use Maatwebsite\Excel\Concerns\FromView;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class HorasPorEmpleadoExport extends DefaultValueBinder implements FromCollection,
    ShouldAutoSize, 
    WithStrictNullComparison,
    WithCustomStartCell, 
    WithHeadings, 
    WithMapping, 
    WithCustomValueBinder,
    WithStyles, 
    WithEvents {

    use RegistersEventListeners;

    protected $prestadores;
    protected $total_horas;
    protected $total_monto_bruto;
    protected $total_empleados;

    public function __construct( $prestadores, $total_horas, $total_monto_bruto, $total_empleados){
        $this->prestadores = $prestadores;
        $this->total_horas = $total_horas;
        $this->total_monto_bruto = $total_monto_bruto;
        $this->total_empleados = $total_empleados;
    }

    public function startCell(): string {
        return 'A5';
    }

    public function headings(): array{
        return [
            'NÚMERO DE EMPLEADO',
            'NOMBRE DEL EMPLEADO',
            'RFC',
            'SINDICALIZADO',
            'TIPO',
            'NIVEL SALARIAL',
            'HORAS',
            'MONTO BRUTO',
            'OBSERVACIONES',
        ];
    }
        
    public function map($prestadores): array {  
        $dataRow = [
            $prestadores->numero_empleado,
            $prestadores->nombre_empleado . " " . $prestadores->apellido_paterno . " " . $prestadores->apellido_materno,
            $prestadores->rfc,
            $prestadores->sindicalizado,
            $prestadores->tipo,
            $prestadores->nivel_salarial,
            $prestadores->horas,
            $prestadores->monto_bruto,
            $prestadores->observaciones,
        ];

        return $dataRow;
    }
        
    public function collection(){
        return $this->prestadores;
    }

    public function styles(Worksheet $sheet) {
        return [
            5 => [
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
                $event->sheet->setCellValue('A1', "Relación de personal para el pago de tiempo extraordinario y excedente");
                $event->sheet->getDelegate()->mergeCells("A1:D1");
                $event->sheet->styleCells('A1', [
                    'font' => [
                        'bold' => true,
                        'size' => 14
                    ]
                ]);
                $event->sheet->setCellValue('A3', "Total de horas: " . $this->total_horas);
                $event->sheet->styleCells('A3', [
                    'font' => [
                        'bold' => true,
                        'size' => 14
                    ]
                ]);
                $event->sheet->setCellValue('B3', "Importe total aplicado en tiempo extraordinario: " . $this->total_monto_bruto);
                $event->sheet->getDelegate()->mergeCells("B3:D3");
                $event->sheet->styleCells('B3', [
                    'font' => [
                        'bold' => true,
                        'size' => 14
                    ]
                ]);
                $event->sheet->setCellValue('E3', "Total de empleados: " . $this->total_empleados);
                $event->sheet->getDelegate()->mergeCells("E3:F3");
                $event->sheet->styleCells('E3', [
                    'font' => [
                        'bold' => true,
                        'size' => 14
                    ]
                ]);
            }
        ];
    }
}
