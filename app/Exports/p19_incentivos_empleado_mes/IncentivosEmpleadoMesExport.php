<?php

namespace App\Exports\p19_incentivos_empleado_mes;

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

class IncentivosEmpleadoMesExport implements FromCollection, WithMapping, WithCustomStartCell, WithHeadings, WithStyles, WithColumnWidths, WithColumnFormatting, WithStrictNullComparison
{
    protected $incentivoEmpleadoMes;
    protected $p19_incentivo_id;

    public function __construct( $incentivoEmpleadoMes, $p19_incentivo_id )
    {
        $this->incentivoEmpleadoMes = $incentivoEmpleadoMes;
        $this->p19_incentivo_id = $p19_incentivo_id;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->incentivoEmpleadoMes->where('p19_incentivo_id', $this->p19_incentivo_id)->get();
    }

    /**
    * @var Invoice $invoice
    * Esta función cacha la colección que regresa el método Collection
    */
    public function map($incentivoEmpleadoMes): array {

        $dataRow = [
            $incentivoEmpleadoMes->folio,
            $incentivoEmpleadoMes->nombre_quincena,
            $incentivoEmpleadoMes->fecha_inicio_pago,
            $incentivoEmpleadoMes->fecha_fin_pago,
            $incentivoEmpleadoMes->numero_documento,
            mb_strtoupper($incentivoEmpleadoMes->creado_por_nombre_completo)
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
            'QUINCENA',
            'FECHA INICIO',
            'FECHA FIN',
            'DOCUMENTO',
            'CREADO POR'
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
        ];
    }

    // Agregamos formato a las columnas
    public function columnFormats(): array
    {
        return [
            'B' =>  NumberFormat::FORMAT_GENERAL,
            'F' =>  NumberFormat::FORMAT_GENERAL,
        ];
    }

}
