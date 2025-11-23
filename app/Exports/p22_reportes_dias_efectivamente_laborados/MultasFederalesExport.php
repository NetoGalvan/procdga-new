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

class MultasFederalesExport extends DefaultValueBinder implements FromCollection,
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
            // "Clave adscripción", 
            "Num unidad administrativa", 
            "Unidad administrativa", 
            // "Sub unidad administrativa", 
            "Nombre empleado", 
            "RFC",
            "Num empleado",
            "Sección sindical",
            "Nivel salarial",
            "Mes 1 evaluación",
            "Faltas",
            "Lic. Med.",
            "Vac.",
            "Lic. Con sueldo",
            "Notas buenas",
            "Día sind.",
            "Lic. S.S.",
            "Com. Sind.",
            "Cuid. Master",
            "Susp.",
            "Baja",
            "Defunción",
            "Total de días laborables mes 1",
            "Total de días efectivamente laborados mes 1",
            "Mes 2 evaluación",
            "Faltas",
            "Lic. Med.",
            "Vac.",
            "Lic. Con sueldo",
            "Notas buenas",
            "Día sind.",
            "Lic. S.S.",
            "Com. Sind.",
            "Cuid. Master",
            "Susp.",
            "Baja",
            "Defunción",
            "Total de días laborables mes 2",
            "Total de días efectivamente laborados mes 2",
            "Mes 3 evaluación",
            "Faltas",
            "Lic. Med.",
            "Vac.",
            "Lic. Con sueldo",
            "Notas buenas",
            "Día sind.",
            "Lic. S.S.",
            "Com. Sind.",
            "Cuid. Master",
            "Susp.",
            "Baja",
            "Defunción",
            "Total de días laborables mes 3",
            "Total de días efectivamente laborados mes 3",
            "Total de días laborables",
            "Total de días no laborados",
            "Total de días efectivamente laborados"
        ];
    }

        /**
    * @var Invoice $invoice
    */
    public function map($empleado): array {  
        $dataRow = [
            // $empleado->clave_adscripcion,
            $empleado->identificador_unidad,
            $empleado->nombre_unidad,
            // $empleado->created_by_ou,
            $empleado->nombre_empleado . " " . $empleado->apellido_paterno . " " . $empleado->apellido_materno,
            $empleado->rfc,
            $empleado->numero_empleado,
            $empleado->seccion_sindical,
            $empleado->nivel_salarial,
            0, //mes 1 de la evaluacion
            0, //faltas 
            0, //lic. med
            0, //vac
            0, //lic con sueldo
            0, //notas buenas
            0, //dia sind
            0, //lic. s.s.
            0, //com sind
            0, //cuid master
            0, //susp
            0, //baja
            0, //defuncion
            0, //total de dias laborables mes 1
            0, //total de dias efectivamente laborados mes 1
            0, //mes 2 de la evaluacion
            0, //faltas 
            0, //lic. med
            0, //vac
            0, //lic con sueldo
            0, //notas buenas
            0, //dia sind
            0, //lic. s.s.
            0, //com sind
            0, //cuid master
            0, //susp
            0, //baja
            0, //defuncion
            0, //total de dias laborables mes 2
            0, //total de dias efectivamente laborados mes 2
            0, //mes 3 de la evaluacion
            0, //faltas 
            0, //lic. med
            0, //vac
            0, //lic con sueldo
            0, //notas buenas
            0, //dia sind
            0, //lic. s.s.
            0, //com sind
            0, //cuid master
            0, //susp
            0, //baja
            0, //defuncion
            0, //total de dias laborables mes 3
            0, //total de dias efectivamente laborados mes 3
            $empleado->total_dias_laborables,
            $empleado->total_dias_no_laborados,
            $empleado->total_dias_laborados,
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
                $event->sheet->setCellValue('A1', "UNIDAD DEPARTAMENTAL DE RECURSOS HUMANOS, REPORTE DE DÍAS EFECTIVAMENTE LABORADOS DEL PERSONAL DE FIZCALIZACIÓN PARA EFECTOS DE MULTAS FEDERALES");
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
