@extends('layouts.main')

@section('title', 'REVISIÓN Y CONCENTRADO DE EMPLEADOS')

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
                'titulo' => 'REVISIÓN Y CONCENTRADO DE EMPLEADOS'
            ]
        ]
    ]])
@endsection

@section('contenido')

    @include('p22_reportes_dias_efectivamente_laborados.partials.detalles_proceso', 
    [ "secciones" => ["general", "datos_reporte"] ])

    <div class="card card-custom mt-5">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">Revisión y centrado de empleados</h3>
            </div>
        </div>
        <div class="card-body">
            <section class="mb-8 col-md-12">
                <div class="alert alert-custom alert-success" role="alert">
                    <div class="alert-icon"><i class="flaticon-warning"></i></div>
                    <div class="alert-text">
                    <strong>
                        <p class="font-size-xl">
                            Instrucciones: <br>
                        </p>
                        <p class="font-size-lg">
                            Agregar empleados.<br>
                            <ul class="font-size-lg">
                                <li>Ingrese el nombre, rfc o número del empleado.</li>
                                <li>Seleccione el botón " Agregar ".</li>
                                <li>Si los datos del empleado aparecen incompletos, deberá completar los de forma manual sobre el reporte generado.</li>
                            </ul>
                        </p>
                    </strong>
                    </div>
                </div>
            </section>
            <form method="POST" id="form_rev_cent_empleados">
            @csrf
            @method('post')
                <section class="col-md-12">
                    <div>
                        @include("componentes.busqueda_empleado", [
                            "existeEmpleado" => false,
                        ])
                        <br>
                        <button type="button" id="btn_buscar_empleado" name="btn_buscar_empleado" class="btn btn-primary btn-sm mt-5 btn_agregar_empleado" ><i class="fas fa-plus"></i> Agregar </button>
                    </div>
                    <div class="form-group mt-6">
                        <table class="table table-bordered table-general" id="tabla_buscar_empleado" {{--data-toolbar="#toolbar" data-unique-id="id"--}}
                            data-toggle='table'
                            data-ajax='showEmpleadosAgregados'
                            data-cache='false'
                        >
                            <thead>
                                <tr>
                                    <th data-field="empleado.numero_empleado" class="text-center"><label class="titulo-dato"> Número de empleado </label></th>
                                    <th data-field="empleado.nombre_completo"{{--data-formatter="nombreCompletoFormatter"--}} class="text-center"><label class="titulo-dato"> Nombre </label></th>
                                    <th data-field="empleado.rfc" class="text-center"><label class="titulo-dato"> RFC </label></th>
                                    <th data-field="empleado.unidad_administrativa_nombre" class="text-center"><label class="titulo-dato"> Unidad administrativa </label></th>
                                    <th data-field="empleado.nivel_salarial" class="text-center"><label class="titulo-dato"> Nivel salarial </label></th>
                                    <th data-field="empleado.seccion_sindical" class="text-center"><label class="titulo-dato"> Sección sindical </label></th>
                                    <th data-field="p22_reporte_detalle_id" data-formatter="eliminarFormatter" class="text-center"><label class="titulo-dato"> Acciones </label></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
{{--
                    <div class="border border-3 rounded col-md-5 p-8 m-auto text-center">
                        <h6><strong>DESCARGAR</strong></h6>
                        <a class="btn btn-danger mt-4" target="_blank" 
                            href="{{route('descargar.pdf.listado.empleados.evaluacion', $reportes->p22_reporte_id)}}" 
                        > 
                            <i class="far fa-file-pdf"></i> Listado de empleados
                        </a>
                    </div>
--}}
                </section>
            </form>
        </div>
        <div class="card-footer text-center">
                <button type="button" id="btn_finalizar_TRDEL02" class="btn btn-success">
                    <i class="fas fa-check-square"></i>Finalizar Tarea
                </button>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        var URL_finalizarRevisionCentradoEmpleados = "{{route('post.revision.centrado.empleados', [$reportes, $instanciaTarea])}}";
        var URL_agregarEmpleado = "{{route('post.agregar_empleado', [$reportes->p22_reporte_id])}}";
        var URL_removerEmpleado = "{{route('post.agregar_empleado', [$reportes->p22_reporte_id])}}";
    </script>
    <script src="{{ asset('js/p22_reportes_dias_efectivamente_laborados/general_swal_alert.js') }}"></script>
    <script src="{{ asset('js/p22_reportes_dias_efectivamente_laborados/tareas/TRDEL02_revisionConcentradoEmpleados.js') }}"></script>
    <script src="{{ asset('js/componentes/busqueda_empleado.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
@endpush

@push('styles')
    <link href="{{ asset('metronic/plugins/custom/bootstraptable/css/bootstrap-table.min.css') }}" type="text/css" rel="stylesheet"/>
@endpush
