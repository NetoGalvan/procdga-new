@extends('layouts.main')

@section('title', 'GENERACIÓN DE REPORTES')

@section('aside_menu')
    @include('layouts.partials.main.aside_menu', ["asideMenu" =>
        [
            "item_seleccionado" => "tareas",
        ]
    ])
@endsection

@section('subheader')
    @include('layouts.partials.main.subheader', ["subheader" => [
        "titulo_subheader" => "PROCDGA",
        "icono_titulo_subheader" => "far fa-folder-open",
        "breadcrumbs" => [
            1 => [
                'activo' => false,
                'titulo' => 'Tareas',
                'ruta' => Route('tareas')
            ],
            2 => [
                'activo' => true,
                'titulo' => 'GENERACIÓN DE REPORTES'
            ]
        ]
    ]])
@endsection

@section('contenido')
    @include('p22_reportes_dias_efectivamente_laborados.partials.detalles_proceso', [ 
        "secciones" => ["general", "datos_reporte"] 
    ])
    <form method="POST" id="form_generar_reporte">
    @csrf
    @method('post')
        <div class="row">
            <div class="col-12">
                <div class="card card-custom mt-5">
                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="card-label">Reporte de días efectivamente elaborados</h3>
                        </div>
                    </div>
                    <div class="card-body">  
                        <section class="col-md-12">
                            <div class="alert alert-custom alert-success" role="alert">
                                <div class="alert-icon"><i class="flaticon-warning"></i></div>
                                <div class="alert-text mt-4"><strong>
                                    <p class="font-size-xl">
                                        Nota:
                                        Antes de finalizar con el proceso genere la descarga del reporte correspondiente.
                                    </p></strong>
                                </div>
                            </div>
                            <div class="border border-3 rounded col-md-5 p-8 m-auto text-center">
                                <h6><strong>DESCARGAR</strong></h6>
                                <a class="btn btn-success mt-4 reporte-excel" title="Descargar reporte" 
                                id="descargarReporteExcel" data-reporte={{$reportes->reporte_id}}> 
                                    <i class="fas fa-file-excel"></i> {{ $reportes->tipo_reporte }}
                                </a>
                            </div>
                        </section>
                    </div>
                    <div class="card-footer text-center">
                        <button name="finalizarProceso" class="btn btn-success finalizar-proceso">
                            <i class="fas fa-check-square"></i>Finalizar tarea
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script type="text/javascript">
        var URL_finalizarProceso = "{{route('post.generacion.reporte', [$reportes, $instanciaTarea])}}";

        var URL_descargarReporte = "{{route('descargar.excel.reporte', [ $reportes ])}}";
        var nombreArchivo = "{{$reportes->tipo_reporte.'_'.$reportes->folio.'_'.date_format(now(), 'Y-m-d')}}.xlsx";
    </script>
    <script src="{{ asset('js/p22_reportes_dias_efectivamente_laborados/general_swal_alert.js') }}"></script>
    <script src="{{ asset('js/p22_reportes_dias_efectivamente_laborados/tareas/TRDEL03_generacionReportes.js') }}"></script>
@endpush
