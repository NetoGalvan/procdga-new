<?php

namespace App\Exports\p08_solicitud_servicios;

use App\Models\p08_solicita_servicios\P08SolicitaServicio;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class SolicitudServiciosExport implements FromCollection, WithMapping, WithCustomStartCell, WithHeadings, WithStyles, WithColumnWidths, WithColumnFormatting, WithStrictNullComparison
{

    protected $solicitudesServicio;

    public function __construct( $solicitudesServicio )
    {
        $this->solicitudesServicio = $solicitudesServicio;
    }

    public function collection()
    {
        return $this->solicitudesServicio;
    }

    /**
    * @var Invoice $invoice
    */
    public function map($servicio): array {

        $dataRow = [
            mb_strtoupper($servicio->nombre_servicio_general),
            $servicio->folio,
            $servicio->estatus == 'EN_PROCESO' ? 'EN PROCESO' : $servicio->estatus,
            $servicio->area->identificador . ' - ' . mb_strtoupper($servicio->area->nombre),
            mb_strtoupper($servicio->sub_area),
            $servicio->fecha_solicitud,
            mb_strtoupper($servicio->contacto_servicio),
            $servicio->telefono_servicio,
            mb_strtoupper($servicio->direccion_servicio),
            strip_tags($servicio->texto_solicitud)
        ];

        $detalles = count($servicio->detalles);
        $detalleCadena = '';
        $detalleAsignadoA = '';
        $detalleConfirmadoPor = '';
        if ( $detalles > 0 ) {
            foreach ($servicio->detalles as $i => $detalle) {
                $detalleCadena .=  (mb_strtoupper($detalle->tipo_servicio) ? mb_strtoupper($detalle->tipo_servicio) : mb_strtoupper($detalle->nombre_servicio)) . ($detalles == ($i+1) ? '' : ', ');
                $detalleAsignadoA .=  (mb_strtoupper($detalle->asignado_a)) . ($detalles == ($i+1) ? '' : ', ');
                $detalleConfirmadoPor .=  (mb_strtoupper($detalle->confirmado_por)) . ($detalles == ($i+1) ? '' : ', ');
            }
        } else {
            $detalleCadena = 'NO HAY DETALLES';
            $detalleAsignadoA = 'NO HAY ASIGNACIONES';
            $detalleConfirmadoPor = 'NO HAY CONFIRMACIONES';
        }
        $dataRow[] = $detalleCadena;
        $dataRow[] = $detalleAsignadoA;
        $dataRow[] = $detalleConfirmadoPor;
        $dataRow[] = $servicio->comentario_privado ? $servicio->comentario_privado : 'SIN COMENTARIOS';

        return $dataRow;
    }

    // Indica en que celda iniciará la carga de datos
    public function startCell(): string
    {
        return 'A1';
    }

    // Indicamos los nobres de las cabeceras
    public function headings(): array
    {
        return [
            'TIPO DE SERVICIO',
            'FOLIO',
            'ESTATUS',
            'ÁREA',
            'SUBÁREA',
            'FECHA SOLICITUD',
            'NOMBRE DEL CONTACTO',
            'TELÉFONO DE CONTACTO',
            'DIRECCIÓN DEL CONTACTO',
            'DESCRIPCIÓN DEL SERVICIO',
            'DETALLE DE LOS SERVICIOS',
            'ASIGANDO A',
            'CONFIRMADO POR',
            'COMENTARIOS ADICIONALES',
        ];
    }

    // Agregamos los estilos
    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 40,
            'B' => 20,
            'C' => 20,
            'D' => 60,
            'E' => 40,
            'F' => 25,
            'G' => 25,
            'H' => 25,
            'I' => 80,
            'J' => 80,
            'K' => 80,
            'L' => 80,
            'M' => 80,
            'N' => 100,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'H' =>  NumberFormat::FORMAT_GENERAL,
            'J' =>  NumberFormat::FORMAT_GENERAL,
            'K' =>  NumberFormat::FORMAT_GENERAL,
        ];
    }

}
