@extends('layouts.main')

@section('title', 'GENERACIÓN DE NÓMINA XLS')

@section('subheader')
    @include('layouts.partials.main.subheader', ["subheader" => [
        "titulo_subheader" => "PROCDGA",
        "icono_titulo_subheader" => "far fa-folder-open",
        "breadcrumbs" => [
            1 => [
                'activo' => false,
				'titulo' => 'Tareas disponibles',
				'ruta' => Route('tareas')
            ],
            2 => [
                'activo' => true,
                'titulo' => 'GENERACIÓN DE NÓMINA XLS'
            ]
        ]
    ]])
@endsection

@section('aside_menu')
    @include('layouts.partials.main.aside_menu', ["asideMenu" =>
        [
            "item_seleccionado" => "tareas",
        ]
    ])
@endsection

@section('contenido')
<form method="POST" id="form_generar_nomina">
@csrf
@method('post')
    <div class="row">
        <div class="col-12">
            <div class="card card-custom mb-5">
                <div class="card-header">
                    <div class="card-title">
                        <h3 class="card-label">Archivo de nómina de prestadores de servicio social</h3>
                    </div>
                </div>
                <div class="card-body">
                        
                    <div class="row d-flex col-md-12 justify-content-center">
                        <div class="alert alert-custom alert-success" role="alert">
                            <div class="alert-icon"><i class="flaticon-warning"></i></div>
                            <div class="alert-text">
                                <p class="font-size-lg"><strong>
                                    Nota: <br>
                                    Antes de finalizar genere la descarga de la nómina de prestadores de servicio social - {{ $nomina->descripcion }}
                                </strong></p>
                            </div>
                        </div>
                        <div class="border border-3 rounded col-md-5 p-8">
                            <h6><strong>DESCARGAR</strong></h6>
                            
                            <a class="btn btn-success ml-4 mt-4 nomina-excel" title="Descargar Archivo" 
                            id="descargarNominaExcel" > 
                                <i class="fas fa-file-excel"></i> {{ $nomina->descripcion }}
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <button id="finalizarSubProceso" name="finalizarSubProceso" class="btn btn-success">
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
        var URL_descargarNominaExcel = "{{ route('descargar.nomina.excel', [$nomina->nomina_id, $instanciaTarea]) }}";
        var URL_finalizarProceso = "{{ route('finalizar.proceso.desde.T04', [$nomina->nomina_id, $instanciaTarea]) }}";

        var nombreArchivoExcel = `nomina_{{$nomina->descripcion}}.xlsx`;
    </script>
    <script src="{{ asset('js/p06_servicio_social/general_swal_alert.js') }}"></script>
    <script src="{{ asset('js/p06_servicio_social/sub_proceso/T04_generacion_excel.js') }}"></script>
@endpush
