<?php

namespace App\Exports\p15_asistencia;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;

class ReporteFaltasExport extends DefaultValueBinder implements 
    FromCollection,
    ShouldAutoSize,
    WithCustomStartCell,
    WithHeadings,
    WithEvents,
    WithMapping {
    
    use RegistersEventListeners;

    protected $unidadesAdministrativas;
    protected $unidadesEvaluaciones;
    protected $fechaInicio;
    protected $fechaFinal;

    public function __construct($unidadesAdministrativas, 
        $unidadesEvaluaciones,
        $fechaInicio,
        $fechaFinal) {
        $this->unidadesAdministrativas = $unidadesAdministrativas;
        $this->unidadesEvaluaciones = $unidadesEvaluaciones;
        $this->fechaInicio = $fechaInicio;
        $this->fechaFinal = $fechaFinal;
    }

    public function startCell(): string {
        return "A1";
    }

    public function headings(): array {
        return [
            ["REPORTE DE FALTAS PERIODO {$this->fechaInicio->format("d/m/Y")} - {$this->fechaFinal->format("d/m/Y")}"],
            [],
            ["UNIDAD ADMINISTRATIVA", "NOMBRE", "NÚMERO DE EMPLEADO", "FECHA", "EVALUACIÓN"]
        ];
    }

    public function collection()
    {
        return $this->unidadesEvaluaciones;
    }

    public function map($evaluaciones): array
    {
        $data = [];
        foreach ($evaluaciones as $evaluacion) {
            $data[] = [
                $this->unidadesAdministrativas[$evaluacion->unidad_administrativa]["nombre_completo"],
                $evaluacion->nombre_completo,
                $evaluacion->numero_empleado,
                $evaluacion->fecha,
                $evaluacion->evaluacion,

            ];
            
        }
        return $data;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getDelegate()->mergeCells("A1:E2"); 
                $event->sheet->getDelegate()->getStyle("A1")->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 16 
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
                    ]
                ]); 
                $event->sheet->getDelegate()->getStyle("A3:E3")->getFont()->setBold(true); 
                $event->sheet->getDelegate()->getStyle('B4:B' . $event->sheet->getHighestRow())
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
            },
        ];
    }
}
