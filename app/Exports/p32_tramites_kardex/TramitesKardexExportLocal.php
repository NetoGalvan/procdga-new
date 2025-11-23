<?php

namespace App\Exports\p32_tramites_kardex;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class TramitesKardexExportLocal implements FromCollection,
                                WithCustomStartCell,
                                WithHeadings,
                                WithStyles,
                                WithMapping,
                                WithColumnWidths
{
    protected $infoServicioQuery;

    public function __construct( $infoServicioQuery )
    {
        $this->infoServicioQuery = $infoServicioQuery;
    }
    
    public function collection()
    {
        return $this->infoServicioQuery;
    }

    public function map($info): array {

        $dataRow = [
            $info->folio,
            mb_strtoupper($info->apellido_paterno),
            mb_strtoupper($info->apellido_materno),
            mb_strtoupper($info->nombre),
            $info->numero_empleado,
            $info->rfc,
            $info->curp,
            $info->created_at,
        ];

        return $dataRow;
    }

    // Indica en que celda iniciará la carga de datos
    public function startCell(): string
    {
        return 'A1';
    }

    // Indicamos los nombres de las cabeceras
    public function headings(): array
    {
        return [
            'FOLIO',
            'APELLIDO PATERNO',
            'APELLIDO MATERNO',
            'NOMBRE DEL EMPLEADO',
            'NÚMERO DE EMPLEADO',
            'RFC',
            'CURP',
            'FECHA DE CREACIÓN',
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

    // Definimos ancho de las columnas
    public function columnWidths(): array
    {
        return [
            'A' => 30,
            'B' => 30,
            'C' => 30,
            'D' => 30,
            'E' => 30,
            'F' => 30,
            'G' => 30,
        ];
    }
}
