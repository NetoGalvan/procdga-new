@extends('layouts.main')

@section('title', 'SELECCIÓN DE REPORTE Y PERIODO DE EVALUACIÓN')

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
                'titulo' => 'SELECCIÓN DE REPORTE Y PERIODO DE EVALUACIÓN'
            ]
        ]
    ]])
@endsection

@section('contenido')

    @include('p22_reportes_dias_efectivamente_laborados.partials.detalles_proceso', 
    [ "secciones" => ["general"] ])

    <form method="POST" id="form_seleccionar_reporte">
    @csrf
    @method('post')
        <div class="card card-custom mt-5">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Datos del reporte</h3>
                </div>
            </div>
            <div class="card-body">
                <div>
                    <div class="alert alert-custom alert-success" role="alert">
                        <div class="alert-icon"><i class="flaticon-warning"></i></div>
                        <div class="alert-text">
                            <p class="font-size-xl"><strong>
                                Instrucciones: <br>
                                <ol class="font-size-lg">
                                    <li> Seleccione el tipo de reporte que desea generar.</li>
                                    <li> Seleccione el periodo de evaluación; los periodos están determinados de acuerdo a las reglas de negocio, según el tipo de reporte seleccionado:</li><br>
                                        <ul>
                                            <li><b>Multas federales:</b> Se hará la evaluación por un periodo de 3 (tres) meses a partir del mes de inicio seleccionado.</li>
                                            <li><b>Multas locales:</b> Se hará la evaluación por periodos semestrales: Enero a Junio o Julio a Diciembre.</li>
                                            <li><b>Escalafón:</b> Se hará la evaluación por un periodo de 12 (doce) meses retroactivos al mes que se seleccione.</li>
                                        </ul>
                                </ol>
                            </strong></p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 align-middle">
                        <div class="form-group">
                            <label class="titulo-dato" for=""><strong><span class="requeridos">*</span>Tipo de reporte:</strong></label>
                            <select class="form-control  normalizar-texto" name="tipo_reporte" id="tipo_reporte">
                                <option value="" selected disabled>Seleccione una opción</option>
                                @foreach ($tipo_reporte as $key => $reporte)
                                    <option value="{{ $key }}">{{ $reporte }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6 align-middle">
                        <div class="form-group">
                            <label class="titulo-dato"><strong><span class="requeridos">*</span>Periodo de evaluación:</strong></label>

                            <div class="col-10">
                                <input type="text" class="form-control periodo_evaluacionV2" name="periodo_evaluacion" placeholder="Seleccione una opción" value="" readonly />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-center">
                <button type="button" id="btn_finalizar_TRDEL01" class="btn btn-success">
                    <i class="fas fa-check-square"></i>Finalizar Tarea
                </button>
                <button type="button" class="btn btn-danger" id="btn_cancelar_proceso">
                    <i class="fas fa-trash"></i>Cancelar proceso
                </button>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script type="text/javascript">
        var URL_seleccionarReporte = "{{route('post.p22.seleccionar_reporte', [$reportes, $instanciaTarea])}}";
        var URL_finalizarProceso = "{{route('cancelar.proceso.reporte.dias', [$reportes, $instanciaTarea])}}";
    </script>
    <script src="{{ asset('js/p22_reportes_dias_efectivamente_laborados/general_swal_alert.js') }}"></script>
    <script src="{{ asset('js/p22_reportes_dias_efectivamente_laborados/tareas/TRDEL01_seleccionReporte.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
@endpush

@push('styles')
    <link href="{{ asset('metronic/plugins/custom/bootstraptable/css/bootstrap-table.min.css') }}" type="text/css" rel="stylesheet"/>
@endpush