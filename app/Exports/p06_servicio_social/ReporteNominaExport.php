<?php
namespace App\Exports\p06_servicio_social;

use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ReporteNominaExport implements FromView, WithEvents
{
    use Exportable;
    
    public $nomina;
    public $nominaDetalle;

    public function __construct($nomina, $nominaDetalle) {
        $this->nominaDetalle = $nominaDetalle;
        $this->nomina = $nomina;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                # ------ Obtener rango desde la primera a la yultima celda
                $ultimaColumna = $event->sheet->getHighestDataColumn();
                $ultimaFila = $event->sheet->getHighestDataRow();
                $todasLasCeldas = 'A1:'.$ultimaColumna.$ultimaFila;
                # ------ Registrar los eventos para los estilos
                # ------ General (Fuente, alineacion vertical y horizontal centrado, ajustar texto)
                $sheet = $this->sheet_config($event, $todasLasCeldas, true);

                $sheet->applyFromArray([ 'font' => ['name' => 'Century Gothic', 'size' => 10] ]);
                $sheet->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                $sheet->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getAlignment()->setWrapText(true);
                # ------ Tamaño de fuente
                $this->sheet_config($event, "A1:F1")->applyFromArray([ 'font' => ['size' => 16] ]);
                # ------ Alinear a la izquierda
                $rangoCeldas = ["A2:F4", "B8:D$ultimaFila", "H8:H$ultimaFila", "J8:J$ultimaFila"];
                foreach($rangoCeldas as $celdas) $this->sheet_config($event, $celdas)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                # ------ Bordes / Color de las celdas
                $this->sheet_config($event, "A6:".$ultimaColumna."7")->getFill()->applyFromArray([ 'fillType' => 'solid',  'color' => ['rgb' => 'E6B8B7'] ]);
                $this->sheet_config($event, "A6:".$ultimaColumna."7")->applyFromArray([
                    'borders' => [ 'allBorders' => [
                                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                        'color' => ['argb' => '000000'],
                                    ],
                    ]
                ]);
            }
        ];
    }

    public function view(): View
    {
        return view('p06_servicio_social.Formatos.excel_reporte_nomina', ['nomina_detalle' => $this->nominaDetalle, 'nomina' => $this->nomina]);
    }

    public function sheet_config($event, $rangoCeldas, $todo = false) { // $todo (true o por defecto => false)
        if ( $todo ) {
            return $event->sheet->getDelegate()->getStyle($rangoCeldas);
        }
        return $event->sheet->getDelegate()->getStyle($rangoCeldas);
    }
}