<?php
namespace App\Exports;

use App\Models\p07_pago_prestaciones\DetallePrestaciones;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\p07_pago_prestaciones\SubProcesoPrestacion;
use App\Models\p07_pago_prestaciones\PagoPrestacion;
use DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\AfterSheet;
// use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Writer;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromView;
use Auth;
class DetalleExport implements FromCollection, WithHeadings, WithEvents, WithCustomStartCell, ShouldAutoSize
{
    use Exportable, RegistersEventListeners;

    /**
     *
     * @return \Illuminate\Support\Collection
     */
    protected $prestacion = [];
    public function __construct(int $pago_prestacion_id)
    {
        $this->pago_prestacion_id = $pago_prestacion_id;
    }

    public function collection()
    {
        $usuarios = Auth::user();
        $pagoPrestacionPadre = PagoPrestacion::find($this->pago_prestacion_id);

        // dd($pagoPrestacionId);
        $cabeceras = [
            'p07deta.created_at',
            'p07deta.ultima_modificacion_por',
            'p07deta.id_empleado',
            'p07deta.nombre',
            'p07deta.apellido_paterno',
            'p07deta.apellido_materno',
            'p07deta.ua',
            'p07deta.rfc',
            'p07deta.curp',
            'p07deta.id_sindicato',
            'p07deta.campos_adicionales'
        ];
        $subPagoPrestacion = DB::table('p07_detalle_prestaciones AS p07deta')
        ->join('p07_subprocesos AS p07sub','p07sub.subproceso_id','p07deta.subproceso_id')
        ->join('p07_pago_prestaciones AS p07pres','p07pres.pago_prestacion_id','p07sub.pago_prestacion_id')
        ->whereRaw("p07pres.pago_prestacion_id = $this->pago_prestacion_id
                and (p07sub.comentarios_rechazo is null or p07sub.comentarios_rechazo = '') and borrado_por is null or borrado_por = ''")
                ->select(DB::raw("CASE WHEN p07sub.ultima_modificacion > p07sub.fecha_limite THEN 'A DESTIEMPO' ELSE 'A TIEMPO' END AS atiempo, p07deta.ultima_modificacion_por || p07deta.ultima_modificacion modificados"),
                    
                    
                    'p07deta.id_empleado',
                    'p07deta.nombre',
                    'p07deta.apellido_paterno',
                    'p07deta.apellido_materno',
                    'p07deta.ua',
                    'p07deta.rfc',
                    'p07deta.curp',
                    'p07deta.id_sindicato',
                    'p07deta.campos_adicionales')
        ->get();


        $collectionUsuariosPrestaciones = [];
        // dd($subPagoPrestacion);
        

 
        if (count($subPagoPrestacion) > 0) {
//                     dd($usuariosPrestacion);
//                     array_unshift((array)$usuariosPrestacion[0],'1');
//                     dd($usuariosPrestacion);
                    foreach ($subPagoPrestacion as $detalles) {
                        $campoAdicional = ((array) json_decode($detalles->campos_adicionales));
                        // $value->$value

                        // dd($campoAdicional);
                        foreach ($campoAdicional as $key => $campos) {
                            // dd($key);
                            $detalles->$key = $campos;
                        }

                        // dd($detalles);
                        unset($detalles->campos_adicionales);
                        array_push($collectionUsuariosPrestaciones, $detalles);
                    }
                    // dd("llegas");
                    
                    
                    
//                     unset($usuariosPrestacion[0]->campos_adicionales);
                }
//             }
//         } else {
//             $usuariosPrestacion = [];
//         }
        // dd($collectionUsuariosPrestaciones);
        array_push($this->prestacion,$pagoPrestacionPadre);
        array_push($this->prestacion,$usuarios);
//         dd($this->prestacion);
//         dd($collectionUsuariosPrestaciones);
//         $usuariosPrestacionesDetalles = collect($collectionUsuariosPrestaciones[0]);
//         $usuariosPrestacionesDetalles[0]->pull('campos_adicionales');
//         dd($usuariosPrestacionesDetalles);
        return collect($collectionUsuariosPrestaciones);
        // return ['unos'=>'Exportación de pago de prestaciones'];
    }

    public function headings(): array
    {
        $cabeceras = [
            'A Tiempo',
            'Modificado por',
            'No. Empleado',
            'Nombre',
            'Apellido Paterno',
            'Apellido Materno',
            'Unidad Admva.',
            'RFC',
            'CURP',
            'Sección Sindical'
        ];
        $pagoPrestacionPadre = PagoPrestacion::find($this->pago_prestacion_id);
        $pagoPrestacionTablasCabeceras = json_decode($pagoPrestacionPadre->estructura_concurrente);
        foreach ($pagoPrestacionTablasCabeceras as $value) {
            array_push($cabeceras, $value->desc);
        }

        // dd($pagoPrestacionTablasCabeceras);
        // dd($cabeceras);
        return $cabeceras;
    }

    public function registerEvents(): array
    {
        
        return [
            BeforeExport::class => function (BeforeExport $event) {
                // dd($event);
                $event->writer->getProperties()->setCreator('Patrick');
            },
            AfterSheet::class => function (AfterSheet $event) {
//                 dd($this->prestacion);
//                 $event->sheet->getDefaultColumnDimension()->setWidth(18);
                $columna = $event->sheet->getHighestColumn() . '9';
                $event->sheet->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
                $event->sheet->setCellValue('A1', "Exportación de pago de prestaciones");
                $event->sheet->getDelegate()->mergeCells("A1:G1");
                $event->sheet->styleCells('A1', [
                    'font' => [
                        'bold' => true,
                        'size' => 14
                    ]
                ]);
                $event->sheet->setCellValue('A3', "Abajo encontrará los datos para entregar a DGADP relativos a la nómina de prestaciones");
                $event->sheet->getDelegate()->mergeCells("A3:L3");
//                 $event->sheet->getDelegate()->getColumnDimension('B8')->setWidth(12);
                $event->sheet->setCellValue('A5', "PRESTACION: ".$this->prestacion[0]->nombre);
                $event->sheet->getDelegate()->mergeCells("A5:G5");
                $event->sheet->styleCells('A9:' . $columna, [
                    'font' => [
                        'bold' => true,
                        'size' => 12
                    ]
                    
                ]);
                $ultimaFilas = $event->sheet->getHighestRow()+3;
//                 dd($ultimaFilas);
                $event->sheet->setCellValue('A'.$ultimaFilas,"Exportado por: ".$this->prestacion[1]->nombre_usuario." ".now());
                $event->sheet->getDelegate()->mergeCells('A'.$ultimaFilas.":"."G".$ultimaFilas);
            }
        ];
    }

    // public function map($invoice): array
    // {
    // // This example will return 3 rows.
    // // First row will have 2 column, the next 2 will have 1 column
    // return [
    // 'HOLAS'
    // ];
    // }
    public static function beforeWriting(BeforeWriting $event)
    {
        //
    }

    public function startCell(): string
    {
        return 'A9';
    }

//     public function view(): View
//     {
//         $pagoPrestacionPadre = PagoPrestacion::find($this->pago_prestacion_id);

//         // dd($pagoPrestacionId);
//         $subPagoPrestacion = SubProcesoPrestacion::whereRaw("pago_prestacion_id = $this->pago_prestacion_id
//         and (comentarios_rechazo is null or comentarios_rechazo = '')")->get();

//         $pagoPrestacionTablasCabeceras = json_decode($pagoPrestacionPadre->estructura_concurrente);
//         // ->whereRaw("(comentarios_rechazo = '') is not false")->first();
//         $collectionUsuariosPrestaciones = [];
//         // dd($subPagoPrestacion);
//         if (count($subPagoPrestacion) > 0) {
//             foreach ($subPagoPrestacion as $subPagos) {

//                 // dd($subPagos->subproceso_id);
//                 // $usuariosPrestacion = DetallePrestaciones::where([
//                 // 'subproceso_id' => $subPagos->subproceso_id
//                 // ])->whereRaw([
//                 // "(borrado_por = '') is not false"
//                 // ])->get();
//                 $usuariosPrestacion = DB::table('p07_detalle_prestaciones')->where([
//                     'subproceso_id' => $subPagos->subproceso_id
//                 ])
//                     ->whereRaw("borrado_por is null or borrado_por = ''")
//                     ->get();
//                 // dd($usuariosPrestacion);
//                 // dd(count($usuariosPrestacion) > 0?"si":"no");
//                 if (count($usuariosPrestacion) > 0) {
//                     foreach ($usuariosPrestacion as $detalles) {
//                         $campoAdicional = ((array) json_decode($detalles->campos_adicionales));
//                         // $value->$value

//                         // dd($campoAdicional);
//                         foreach ($campoAdicional as $key => $campos) {
//                             // dd($key);
//                             $detalles->$key = $campos;
//                         }

//                         // dd($detalles);
//                     }
//                     // dd("llegas");
//                     array_push($collectionUsuariosPrestaciones, $usuariosPrestacion[0]);
//                 }
//             }
//         } else {
//             $usuariosPrestacion = [];
//         }
//         // dd($collectionUsuariosPrestaciones);
// //         return collect($collectionUsuariosPrestaciones);
        
//         return view('p07_pago_prestaciones.users',compact('collectionUsuariosPrestaciones'));
//     }
}
