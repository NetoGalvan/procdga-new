<?php

namespace App\Exports\p07_pago_prestaciones;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class NominaExport implements
    FromCollection,
    ShouldAutoSize,
    WithStrictNullComparison,
    WithCustomStartCell,
    WithHeadings,
    WithMapping,
    WithStyles,
    WithEvents {

    use RegistersEventListeners;

    protected $pagoPrestacion;

    public function __construct($pagoPrestacion) {
        $this->pagoPrestacion = $pagoPrestacion;
    }

    public function startCell(): string {
        return 'A9';
    }

    public function headings(): array {
        $campos = [
            "A Tiempo",
            "Modificado por",
            "No. Empleado",
            "Nombre",
            "Apellido Paterno",
            "Apellido Materno",
            "Unidad Admva.",
            "RFC",
            "CURP",
            "Sección Sindical"
        ];

        foreach ($this->pagoPrestacion->estructura_concurrente as $campo) {
            $campos[] = $campo->desc;
        }

        return $campos;
    }

    /**
    * @var Invoice $invoice
    */
    public function map($candidato): array {
        $dataRow = [
            $candidato->subproceso->completado_a_tiempo ? "A TIEMPO" : "DESTIEMPO",
            $candidato->usuarioCapturo->nombre . ' ' . $candidato->usuarioCapturo->apellido_paterno . ' ' . $candidato->usuarioCapturo->apellido_materno,
            $candidato->numero_empleado,
            $candidato->nombre_empleado,
            $candidato->apellido_paterno,
            $candidato->apellido_materno,
            $candidato->identificador_unidad,
            $candidato->rfc,
            $candidato->curp,
            $candidato->seccion_sindical
        ];

        foreach ($candidato->campos_adicionales as $campo) {
            $dataRow[] = $campo;
        }

        return $dataRow;
    }

    public function collection() {
        $arrayCandidatos = collect();
        foreach ($this->pagoPrestacion->subprocesos()->where("estatus", "COMPLETADO")->get() as $key => $subproceso) {
            $candidatos = $subproceso
                ->candidatos()
                ->get();
            foreach ($candidatos as $key => $candidato) {
                $candidato->area;
                $candidato->usuarioCapturo;
                $candidato->usuarioAutorizo;
                $arrayCandidatos->add($candidato);
            }
        }
        return $arrayCandidatos;
    }

    public function styles(Worksheet $sheet) {
        return [
            9 => [
                'font' => [
                    'name', 'Calibri',
                    'bold' => true,
                    'size' => 10
                ]
            ]
        ];
    }

    public function registerEvents(): array {

        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
                $event->sheet->getDelegate()->getParent()->getDefaultStyle()->getFont()->setName('Calibri');
                $event->sheet->getDelegate()->getParent()->getDefaultStyle()->getFont()->setSize(10);

                $ultimaFila = $event->sheet->getHighestRow() + 2;
                for ($i = 1; $i < $ultimaFila; $i++) {
                    $event->sheet->getDelegate()->getRowDimension($i + 1)->setRowHeight(15);
                }

                $event->sheet->setCellValue('A1', "Exportación de pago de prestaciones");
                $event->sheet->getDelegate()->mergeCells("A1:G1");
                $event->sheet->styleCells('A1', [
                    'font' => [
                        'bold' => true,
                        'size' => 18
                    ]
                ]);

                $event->sheet->setCellValue('A3', "Abajo encontrará los datos para entregar a DGADP relativos a la nómina de prestaciones");
                $event->sheet->getDelegate()->mergeCells("A3:L3");

                $event->sheet->setCellValue('A5', "PRESTACION: " . $this->pagoPrestacion->tipoPrestacion->nombre);
                $event->sheet->getDelegate()->mergeCells("A5:G5");

                $event->sheet->setCellValue('A7', "FOLIO: " . $this->pagoPrestacion->instancia->folio);
                $event->sheet->getDelegate()->mergeCells("A7:G7");

                $event->sheet->setCellValue("A{$ultimaFila}", "Exportado por " . Auth::user()->nombre_usuario . " " . Carbon::now()->format('d/m/Y H:i'));
                $event->sheet->getDelegate()->mergeCells("A{$ultimaFila}:G{$ultimaFila}");

                $event->sheet->setShowGridlines(false);
            }
        ];
    }


}

