<?php

namespace App\Exports\p02_tramites_issste;

use App\Models\p02_tramites_issste\TramiteIsssteDetalle;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DetallesArchivoIsssteExport implements FromCollection, WithCustomStartCell, WithHeadings, WithStyles
{

    protected $tramiteIssste;
    protected $tipoMovimientoIssste;

    public function __construct( $tramiteIssste, $tipoMovimientoIssste )
    {
        $this->tramiteIssste = $tramiteIssste;
        $this->tipoMovimientoIssste = $tipoMovimientoIssste;

    }

    public function collection()
    {
        // Este metodo makeHidden([]) es usado para ocultar en el Excel los campos que se crean para emparejar los reportes de Actual e Historico
        $detallesIssste = '';
        if ($this->tipoMovimientoIssste->identificador == 'ALTAS') {
            $detallesIssste = $this->tramiteIssste->detallesAlta->makeHidden(["anio", "nombre_unidad", "tipo_movimiento_issste_nombre"]);
        } else if ( $this->tipoMovimientoIssste->identificador == 'BAJAS' ) {
            $detallesIssste = $this->tramiteIssste->detallesBaja->makeHidden(["anio", "nombre_unidad", "tipo_movimiento_issste_nombre"]);
        } else if ( $this->tipoMovimientoIssste->identificador == 'REANUDACIONES' ) {
            $detallesIssste = $this->tramiteIssste->detallesModificacion->makeHidden(["anio", "nombre_unidad", "tipo_movimiento_issste_nombre"]);
        }


        return $detallesIssste;
    }

    // Indica en que celda iniciará la carga de datos
    public function startCell(): string
    {
        return 'A1';
    }

    // Indicamos los nobres de las cabeceras
    public function headings(): array
    {

        // Dependiendo el tipo de Movimiento son los atributos que se muestran, estan alineados con las consultas de TramiteIssste.php
        if ($this->tipoMovimientoIssste->identificador == 'ALTAS') {
            return [
                'APELLIDO PATERNO',
                'APELLIDO MATERNO',
                'NOMBRE',
                'RFC',
                'CURP',
                'FECHA DE NACIMIENTO',
                'SEXO',
                'FECHA DE INGRESO',
                'SUELDO COTIZABLE',
                'TIPO DE NOMBRAMIENTO',
                'CALLE DEL TRABAJADOR',
                'NUM. EXTERIOR',
                'NUM. INTERIOR',
                'COLONIA',
                'CODIGO POSTAL',
                'CLAVE DE RAMO',
                'PAGADURIA',
                'GUIA',
                'FECHA DE RECEPCION',
                'NO. DE SEGURIDAD SOCIAL',
                'ENTIDAD DE NACIMIENTO',
                'SUELDO SAR',
                'SUELDO TOTAL',
                'CLAVE DE COBRO',
                'FECHA DE ALTA ',
                'ID MOVIMIENTO',
                'TIPO DE MOVIMENOT',
                'QNA ISSSTE'
            ];
        }
        if ( $this->tipoMovimientoIssste->identificador == 'BAJAS' ) {
            return [
                'APELLIDO PATERNO',
                'APELLIDO MATERNO',
                'NOMBRE',
                'RFC',
                'CURP',
                'FECHA DE BAJA',
                'CLAVE DE RAMO',
                'PAGADURIA',
                'GUIA',
                'FECHA DE RECEPCION',
                'NO. DE SEGURIDAD SOCIAL',
                'ID MOVIMIENTO',
                'TIPO DE MOVIMENOT',
                'QNA ISSSTE'
            ];
        } else if ( $this->tipoMovimientoIssste->identificador == 'REANUDACIONES' ) {
            return [
                'APELLIDO PATERNO',
                'APELLIDO MATERNO',
                'NOMBRE',
                'RFC',
                'CURP',
                'FECHA DE NACIMIENTO',
                'FECHA DE INGRESO',
                'SUELDO COTIZABLE',
                'TIPO DE NOMBRAMIENTO',
                'CALLE DEL TRABAJADOR',
                'NUM. EXTERIOR',
                'NUM. INTERIOR',
                'COLONIA',
                'CODIGO POSTAL',
                'CLAVE DE RAMO',
                'PAGADURIA',
                'GUIA',
                'FECHA DE RECEPCION',
                'NO. DE SEGURIDAD SOCIAL',
                'ENTIDAD DE NACIMIENTO',
                'SUELDO SAR',
                'SUELDO TOTAL',
                'CLAVE DE COBRO',
                'FECHA DE ALTA ',
                'ID MOVIMIENTO',
                'TIPO DE MOVIMENOT',
                'QNA ISSSTE'
            ];
        }

    }

    // Agregamos los estilos
    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],

            // Styling a specific cell by coordinate.
            // 'B2' => ['font' => ['italic' => true]],

            // Styling an entire column.
            // 'C'  => ['font' => ['size' => 16]],
        ];
    }

}
