<?php

namespace App\Exports\p06_servicio_social;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\models\p06_servicio_social\P06Nomina;
use App\Models\p06_servicio_social\P06ServicioSocial;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;

class HistoricoNominaExport implements FromCollection, WithCustomStartCell, WithHeadings, WithStyles, ShouldAutoSize
{

    protected $historicoNomina;

    public function __construct( $historicoNomina){
        $this->historicoNomina = $historicoNomina;
    }

    public function collection()
    {

        try {

            $datosNomina = $this->historicoNomina;
            $detalleNomina = [];

            foreach ($datosNomina as $key => $historico) {
                
                foreach ($historico->nominaDetalle as $key => $nom) {
                    
                    $detalleNomina[$key]['nombre_prestador'] = $nom->servicioSocial->nombre_prestador;
                    $detalleNomina[$key]['apellido_paterno'] = $nom->servicioSocial->apellido_paterno;
                    $detalleNomina[$key]['apellido_materno'] = $nom->servicioSocial->apellido_materno;
                    $detalleNomina[$key]['tipo_prestador'] = $nom->servicioSocial->tipo_prestador;
                    $detalleNomina[$key]['carrera'] = $nom->servicioSocial->carrera;
                    $detalleNomina[$key]['work_estatus'] = $nom->servicioSocial->work_status;
                    
                    $detalleNomina[$key]['folio'] = $nom->servicioSocial->folio;
                    $detalleNomina[$key]['unidad_administrativa'] = $nom->servicioSocial->unidad_administrativa;
                    $detalleNomina[$key]['nombre_escuela'] = $nom->servicioSocial->nombre_escuela;
                    $detalleNomina[$key]['nombre_programa'] = $nom->servicioSocial->nombre_programa;
                    $detalleNomina[$key]['clave_programa'] = $nom->servicioSocial->clave_programa;
                    $detalleNomina[$key]['numero_programa'] = $nom->servicioSocial->numero_programa;
                    $detalleNomina[$key]['fecha_inicio'] = $nom->servicioSocial->fecha_inicio;
                    $detalleNomina[$key]['fecha_fin'] = $nom->servicioSocial->fecha_fin;
                    $detalleNomina[$key]['fecha_carta_inicio'] = $nom->servicioSocial->fecha_carta_inicio;
                    $detalleNomina[$key]['fecha_carta_fin'] = $nom->servicioSocial->fecha_carta_fin;
                    $detalleNomina[$key]['actividades'] = $nom->servicioSocial->actividades;
                    $detalleNomina[$key]['fecha_pago'] = $nom->servicioSocial->fecha_pago;
                    $detalleNomina[$key]['fecha_pago_parcial'] = $nom->servicioSocial->fecha_pago_parcial;
                    $detalleNomina[$key]['total_pagado'] = $nom->servicioSocial->total_pagado;
                    $detalleNomina[$key]['payment_status'] = $nom->servicioSocial->payment_status;
    
                    $detalleNomina[$key]['fecha_cerrado'] = $nom->fecha_cerrado;
                    $detalleNomina[$key]['meses_pagar'] = $nom->meses_pagar;
                    $detalleNomina[$key]['tipo_pago'] = $nom->tipo_pago;
                }

            }
            return collect($detalleNomina);
        } catch (\Throwable $th) {
            
        }
    }

    public function startCell(): string{
        return 'A2';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            'A2' => ['font' => ['bold' => true]],
            'B2' => ['font' => ['bold' => true]],
            'C2' => ['font' => ['bold' => true]],
            'D2' => ['font' => ['bold' => true]],
            'E2' => ['font' => ['bold' => true]],
            'F2' => ['font' => ['bold' => true]],
            'G2' => ['font' => ['bold' => true]],
            'H2' => ['font' => ['bold' => true]],
            'I2' => ['font' => ['bold' => true]],
            'J2' => ['font' => ['bold' => true]],
            'K2' => ['font' => ['bold' => true]],
            'L2' => ['font' => ['bold' => true]],
            'M2' => ['font' => ['bold' => true]],
            'N2' => ['font' => ['bold' => true]],
            'O2' => ['font' => ['bold' => true]],
            'P2' => ['font' => ['bold' => true]],
            'Q2' => ['font' => ['bold' => true]],
            'R2' => ['font' => ['bold' => true]],
            'S2' => ['font' => ['bold' => true]],
            'T2' => ['font' => ['bold' => true]],
            'U2' => ['font' => ['bold' => true]],
            'V2' => ['font' => ['bold' => true]],
            'W2' => ['font' => ['bold' => true]],
            'X2' => ['font' => ['bold' => true]],

        ];
    }

    public function headings(): array{

        return [

            'NOMBRE DEL PRESTADOR',
            'APELLIDO PATERNO',
            'APELLIDO MATERNO',
            'TIPO DE PRESTADOR',
            'CARRERA',
            'ESTATUS DE SERVICIO',

            'FOLIO DE SERVICIO SOCIAL',
            'UNIDAD ADMINISTRATIVA',
            'NOMBRE DE LA ESCUELA',
            'NOMBRE PROGRAMA',
            'CLAVE PROGRAMA',
            'NUMERO PROGRAMA',
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

    // public function registerEvents(): array {
    //     return [
    //         AfterSheet::class => function (AfterSheet $event) {
                
    //             $event->sheet->setCellValue('A1', "Nómina de prestadores tipo $this->tipo de servicio social: $this->descripcion, fecha de cierre de la nómina: $this->cierre  ");
    //             // $event->sheet->setCellValue('A2', "Nómina de prestadores tipo  - $this->historicoNomina ");
    //             $event->sheet->getDelegate()->mergeCells("A1:X2");
    //             $event->sheet->styleCells('A1', [
    //                 'font' => [
    //                     'bold' => true,
    //                     'size' => 18
    //                 ]
    //             ]);
    //         }
    //     ];
    // }
}
