<?php

namespace App\Exports\p06_servicio_social;

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

class NominaServSocExport extends DefaultValueBinder implements FromCollection,
    ShouldAutoSize,
    WithStrictNullComparison,
    WithCustomStartCell,
    WithHeadings,
    WithMapping,
    WithCustomValueBinder,
    WithStyles,
    WithEvents {

    use RegistersEventListeners;

    protected $ss;
    protected $descripcion;
    protected $tipo;

    public function __construct( $ss, $descripcion, $tipo){
        $this->ss = $ss;
        $this->descripcion = $descripcion;
        $this->tipo = $tipo;
    }

    public function startCell(): string {
        return 'A4';
    }

    public function headings(): array{
        return [
            'NOMBRE DEL PRESTADOR',
            'TIPO DE PRESTADOR',
            'CARRERA',
            'ESTATUS DE SERVICIO',
            'FOLIO',
            'NOMBRE ÁREA',
            'NOMBRE ESCUELA',
            'FECHA DE INICIO',
            'FECHA DE FIN',
            'FECHA DE CARTA DE INICIO',
            'FECHA DE CARTA FIN',
            'ACTIVIDADES',
            'FECHA DE PAGO',
            'FECHA DE PAGO PARCIAL',
            'TOTAL PAGADO',
            'ESTATUS DE PAGO',
            'FECHA DE CIERRE',
            'MESES A PAGAR',
            'CORTE'
        ];
    }

    public function map($ss): array {
        $dataRow = [
            $ss->prestador->nombre_prestador . " " . $ss->prestador->primer_apellido . " " . $ss->prestador->segundo_apellido,
            $ss->prestador->tipo_prestador,
            $ss->prestador->carrera,
            $ss->estatus,
            $ss->folio,
            $ss->nombre_area,
            $ss->prestador->escuela->nombre_escuela,
            $ss->fecha_inicio,
            $ss->fecha_fin,
            $ss->fecha_carta_inicio,
            $ss->fecha_carta_fin,
            $ss->actividades,
            null,
            null,
            null,
            null,
            $ss->nominaDetalle->fecha_cerrado,
            $ss->nominaDetalle->meses_pagar,
            $ss->nominaDetalle->tipo_pago,
        ];

        return $dataRow;
    }

    public function collection(){
        return $this->ss;
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
                $event->sheet->setCellValue('A1', "NÓMINA: $this->descripcion");
                $event->sheet->getDelegate()->mergeCells("A1:D1");
                $event->sheet->styleCells('A1', [
                    'font' => [
                        'bold' => true,
                        'size' => 14
                    ]
                ]);
                $event->sheet->setCellValue('A2', "Periodo de evaluación: $this->tipo");
                $event->sheet->getDelegate()->mergeCells("A2:D2");
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
