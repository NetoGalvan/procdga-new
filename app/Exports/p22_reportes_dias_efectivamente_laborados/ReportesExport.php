<?php

namespace App\Exports\p22_reportes_dias_efectivamente_laborados;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

use App\Models\p22_reportes_dias_efectivamente_laborados\P22Reportes;

use Carbon\Carbon;

class ReportesExport implements FromView, WithEvents
{
    use Exportable;
    
    public $empleados;
    public $reporte;
    public $tipoReporte;

    public function __construct($reporte, $empleados, $tipoReporte)
    {
        $this->empleados = $empleados;
        $this->reporte = $reporte;
        $this->tipoReporte = $tipoReporte;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $alphabet       = $event->sheet->getHighestDataColumn();
                $totalRow       = $event->sheet->getHighestDataRow();
                $cellRange      = 'A1:'.$alphabet.$totalRow;

                $event->sheet->getDelegate()->getStyle($cellRange)->getAlignment()->setWrapText(true);
                $event->sheet->getDelegate()->getStyle($cellRange)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                $event->sheet->getDelegate()->getStyle($cellRange)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            }
        ];
    }

    public function view(): View
    {
        $empleados = $this->empleados;
        $reporte = $this->reporte;
        $tipo_reporte = $this->tipoReporte;

        $fechas = [];
        $ruta_vista = null;

        $caracteres = ['','I', 'E', 'RL', 'RG', 'OE', 'OS'];

        switch ( $reporte->tipo_reporte ) {
            case $tipo_reporte['RMF']:

                $fechas = $this->rangoFechas($reporte->fecha_inicio_evaluacion, 3);
                $ruta_vista = 'p22_reportes_dias_efectivamente_laborados.formatos.excel_reporte_multas_federales';
            break;
            
            case $tipo_reporte['RML']:
                $ruta_vista = 'p22_reportes_dias_efectivamente_laborados.formatos.excel_reporte_multas_locales';
            break;

            case $tipo_reporte['RE']:
                $fechas = $this->rangoFechas($reporte->fecha_inicio_evaluacion, 12);
                $ruta_vista = 'p22_reportes_dias_efectivamente_laborados.formatos.excel_reporte_escalafon';
            break;
        }


        return view( $ruta_vista, compact('empleados', 'reporte', 'fechas', 'caracteres') );
    }

    public function rangoFechas($nuevaFecha, $cantidadMeses){
        $meses = [
            1=>"ENERO", 2=>"FEBRERO", 3=>"MARZO", 
            4=>"ABRIL", 5=>"MAYO", 6=>"JUNIO",
            7=>"JULIO", 8=>"AGOSTO", 9=>"SEPTIEMBRE",
            10=>"OCTUBRE",11=>"NOVIEMBRE",12=>"DICIEMBRE"
        ];

        $fechas = [];

        $particionFecha= explode('-', $nuevaFecha);
        $numero_mes = intval($particionFecha[1]);
        $año = intval($particionFecha[0]);

        for ($x=0; $x < $cantidadMeses; $x++) { 
            if ( $numero_mes > 12 ) {
                array_push($fechas, ($meses[ $numero_mes-12 ] . ' DEL ' . ($año+1)) );
            } else {
                array_push($fechas, ($meses[ $numero_mes ] . ' DEL ' . $año) );
            }

            $numero_mes += 1;
        }

        return $fechas;
    }
}
