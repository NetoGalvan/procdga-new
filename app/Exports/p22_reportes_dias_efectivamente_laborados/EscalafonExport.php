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

class EscalafonExport extends DefaultValueBinder implements FromCollection,
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
    protected $nombreConcursante;
    protected $nombre_periodo_evaluacion;
    protected $identificador_unidad;
    protected $nombre_unidad;

    public function __construct($nombreConcursante, $empleados, $nombre_periodo_evaluacion, $identificador_unidad, $nombre_unidad) {
        $this->empleados = $empleados;
        $this->nombreConcursante = $nombreConcursante;
        $this->nombre_periodo_evaluacion = $nombre_periodo_evaluacion;
        $this->identificador_unidad = $identificador_unidad;
        $this->nombre_unidad = $nombre_unidad;
    }

    public function startCell(): string {
        return 'A6';
    }

    public function headings(): array {
        return [

        ];
    }

    public function map($empleado): array {  
        $dataRow = [
            
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
            6 => [
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
                $event->sheet->setCellValue('A1', "SUBCOMISIÓN MIXTA DE ESCALAFÓN EN LA SECRETARIA DE FINANZAS");
                $event->sheet->getDelegate()->mergeCells("A1:BA1");
                $event->sheet->styleCells('A1', [
                    'font' => [
                        'bold' => true,
                        'size' => 14
                    ]
                ]);
                $event->sheet->setCellValue('A2', "RECORD ANUAL DE DISCIPLINA Y PUNTUALIDAD PARA CONCURSO ESCALAFONARIO");
                $event->sheet->getDelegate()->mergeCells("A2:BA2");
                $event->sheet->styleCells('A2', [
                    'font' => [
                        'bold' => true,
                        'size' => 12
                    ]
                ]);
                $event->sheet->setCellValue('A3', "NOMBRE DEL CONCURSANTE: $this->nombreConcursante");
                $event->sheet->getDelegate()->mergeCells("A3:BA3");
                $event->sheet->styleCells('A3', [
                    'font' => [
                        'bold' => true,
                        'size' => 11
                    ]
                ]);
                $event->sheet->setCellValue('A4', "UNIDAD DE ADSCRIPCIÓN: $this->identificador_unidad - $this->nombre_unidad");
                $event->sheet->getDelegate()->mergeCells("A4:BA4");
                $event->sheet->styleCells('A4', [
                    'font' => [
                        'bold' => true,
                        'size' => 10
                    ]
                ]);
                $event->sheet->setCellValue('A5', "Periodo de evaluación: $this->nombre_periodo_evaluacion");
                $event->sheet->getDelegate()->mergeCells("A5:BA5");
                $event->sheet->styleCells('A5', [
                    'font' => [
                        'bold' => true,
                        'size' => 10
                    ]
                ]);
                $event->sheet->setCellValue('A6', "CONCEPTO");
                $event->sheet->getDelegate()->mergeCells("A6:D6");
                $event->sheet->styleCells('A6', [
                    'font' => [
                        'bold' => true,
                        'size' => 10
                    ]
                ]);
                $event->sheet->setCellValue('E6', "CALIF");
                $event->sheet->getDelegate()->mergeCells("E6:F6");
                $event->sheet->styleCells('E6', [
                    'font' => [
                        'bold' => true,
                        'size' => 10
                    ]
                ]);
                $event->sheet->setCellValue('A7', "NOTAS BUENAS");
                $event->sheet->getDelegate()->mergeCells("A7:D7");
                $event->sheet->styleCells('A7', [
                    'font' => [
                        'bold' => true,
                        'size' => 10
                    ]
                ]);
                $event->sheet->setCellValue('A8', "NOTAS MALAS");
                $event->sheet->getDelegate()->mergeCells("A8:D8");
                $event->sheet->styleCells('A8', [
                    'font' => [
                        'bold' => true,
                        'size' => 10
                    ]
                ]);
                $event->sheet->setCellValue('A9', "INASISTENCIAS");
                $event->sheet->getDelegate()->mergeCells("A9:D9");
                $event->sheet->styleCells('A9', [
                    'font' => [
                        'bold' => true,
                        'size' => 10
                    ]
                ]);

                $event->sheet->setCellValue('A24', "I - INASISTENCIA");
                $event->sheet->getDelegate()->mergeCells("A24:I24");
                $event->sheet->styleCells('A24', [
                    'font' => [
                        'bold' => true,
                        'size' => 10
                    ]
                ]);
                $event->sheet->setCellValue('J24', "RL - RETARDO LEVE");
                $event->sheet->getDelegate()->mergeCells("J24:U24");
                $event->sheet->styleCells('J24', [
                    'font' => [
                        'bold' => true,
                        'size' => 10
                    ]
                ]);
                $event->sheet->setCellValue('V24', "RG - RETARDO GRAVE");
                $event->sheet->getDelegate()->mergeCells("V24:AF24");
                $event->sheet->styleCells('V24', [
                    'font' => [
                        'bold' => true,
                        'size' => 10
                    ]
                ]);
                $event->sheet->setCellValue('AG24', "OE - OMISIÓN ENTRADA");
                $event->sheet->getDelegate()->mergeCells("AG24:AQ24");
                $event->sheet->styleCells('AG24', [
                    'font' => [
                        'bold' => true,
                        'size' => 10
                    ]
                ]);
                $event->sheet->setCellValue('AR24', "OS - OMISIÓN SALIDA");
                $event->sheet->getDelegate()->mergeCells("AR24:BA24");
                $event->sheet->styleCells('AR24', [
                    'font' => [
                        'bold' => true,
                        'size' => 10
                    ]
                ]);
                $event->sheet->setCellValue('A25', "E - INCAPACIDAD");
                $event->sheet->getDelegate()->mergeCells("A25:I25");
                $event->sheet->styleCells('A25', [
                    'font' => [
                        'bold' => true,
                        'size' => 10
                    ]
                ]);
                $event->sheet->setCellValue('A26', "NOTA: EL RECORD DE DISCIPLINA Y PUNTUALIDAD DEBERÁ SER LLENADO RETROACTIVO A UN AÑO(12 MESES ANTERIORES A LA FECHA DE PUBLICACIÓN DE LA CONV. DEL CONCURSO ESCALAFONARIO)ASI MISMO ");
                $event->sheet->getDelegate()->mergeCells("A26:BA26");
                $event->sheet->styleCells('A26', [
                    'font' => [
                        'bold' => true,
                        'size' => 10
                    ]
                ]);
                $event->sheet->setCellValue('A27', "_______________________________________");
                $event->sheet->getDelegate()->mergeCells("A27:M27");
                $event->sheet->styleCells('A27', [
                    'font' => [
                        'bold' => true,
                        'size' => 10
                    ]
                ]);
                $event->sheet->setCellValue('N27', "_______________________________________");
                $event->sheet->getDelegate()->mergeCells("N27:AB27");
                $event->sheet->styleCells('N27', [
                    'font' => [
                        'bold' => true,
                        'size' => 10
                    ]
                ]);
                $event->sheet->setCellValue('A28', "SUBDIRECCIÓN DE PRESTACIONES Y CAPACITACIÓN");
                $event->sheet->getDelegate()->mergeCells("A28:M28");
                $event->sheet->styleCells('A28', [
                    'font' => [
                        'bold' => true,
                        'size' => 10
                    ]
                ]);
                $event->sheet->setCellValue('N28', "SUBDIRECCIÓN DE PRESTACIONES Y CAPACITACIÓN");
                $event->sheet->getDelegate()->mergeCells("N28:AB28");
                $event->sheet->styleCells('N28', [
                    'font' => [
                        'bold' => true,
                        'size' => 10
                    ]
                ]);
                $event->sheet->setCellValue('A29', "SUBDIRECCIÓN DE PRESTACIONES Y CAPACITACIÓN");
                $event->sheet->getDelegate()->mergeCells("A29:M29");
                $event->sheet->styleCells('A29', [
                    'font' => [
                        'bold' => true,
                        'size' => 10
                    ]
                ]);
                $event->sheet->setCellValue('N29', "SUBDIRECCIÓN DE PRESTACIONES Y CAPACITACIÓN");
                $event->sheet->getDelegate()->mergeCells("N29:AB29");
                $event->sheet->styleCells('N29', [
                    'font' => [
                        'bold' => true,
                        'size' => 10
                    ]
                ]);
            }
        ];
    }
    
}
