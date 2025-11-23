@extends('layouts.main')

@section('title', $instanciaTarea->tarea->nombre)

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
                'titulo' => $instanciaTarea->tarea->nombre
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

    <form method="POST" id="form_seleccionar_quincena_pago" action="{{ route('incentivos.empleado.mes.seleccion.quincena.pago', [$incentivoEmpleadoMes->p19_incentivo_id, $instanciaTarea->instancia_tarea_id]) }}">
        @method('POST')
        @csrf

        <div class="card card-custom mb-5">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Incentivo empleado del mes</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-custom alert-success" role="alert">
                            <div class="alert-icon"><i class="flaticon-warning"></i></div>
                            <div class="alert-text">
                                <ul>
                                    <li>Seleccione la quincena de pago del premio incentivo empleado del mes</li>
                                    <li>Elija las áreas que desea incluir en el proceso</li>
                                    <li>Captura todos los campos relacionados al proceso de premio incentivo empleado del mes</li>
                                </ul>
                            </div>
                        </div>
                        <p> <span class="requeridos">Campos obligatorios (*)</span> </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-custom mb-5">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Seleccionar quincena de pago</h3>
                </div>
            </div>
            <div class="card-body" >

                <div class="row mb-6">
                    <div class="col-md-4">
                        <label class="titulo-dato"> Folio: </label>
                        <span class="valor-dato"> <b> {{ $incentivoEmpleadoMes->folio }} </b> </span>
                    </div>
                </div>

                <div class="row">

                    <div class="col-md-4 form-group">
                        <label for="fecha_data" class="titulo-dato"><span class="requeridos">* <b> </span>Quincena de pago </b> </label>
                        <select class="form-control normalizar-texto" name="fecha_data" id="fecha_data" required>
                            <option value=""> Seleccione una opción </option>
                            @php
                            use Carbon\Carbon;
                            @endphp
                            @foreach (traerQuincenasActual(Carbon::now()->addDays(15), Carbon::now()->addMonths(3)) as $quincena)
                                <option class="normalizar-texto" value="{{ $quincena }}">{{ $quincena }}</option>
                            @endforeach
                        </select>
                        @error('fecha_data')
                        <label id="fecha_data-error" class="error" for="fecha_data">{{ $message }}</label>
                        @enderror
                    </div>


                    <div class="col-md-4 form-group">
                        <label for="fecha_evaluacion" class="titulo-dato"><span class="requeridos">* </span>Mes de evaluación</label>
                        <select class="form-control text-uppercase" name="fecha_evaluacion" id="fecha_evaluacion" required>
                            <option value=""> Seleccione una opción </option>
                            @foreach ($mesesAnioObjeto as $key => $mesesAnio)
                                <option value="{{$key}}"> {{$mesesAnio}} </option>
                            @endforeach
                        </select>
                    </div>


                    <div class="col-md-4 form-group">
                        <label for="numero_documento" class="titulo-dato"><span class="requeridos">* <b> </span>Documento de DGADP </b> </label>
                        <input type="text" class="form-control normalizar-texto @error('numero_documento') error @enderror"
                            name="numero_documento" id="numero_documento"  placeholder="Ingresar Documento" required campoNoVacio="true"/>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="premios_aprobados" class="titulo-dato"><span class="requeridos">* <b> </span>Premios autorizados por DGADP </b> </label>
                        <input type="text" class="form-control normalizar-texto @error('premios_aprobados') error @enderror"
                            name="premios_aprobados" id="premios_aprobados"  placeholder="Ingresar cantidad de premios" min="1" number="true" required campoNoVacio="true"/>
                    </div>
                    <div class="col-md-12 form-group">
                        <label for="comentarios_opera_incen" class="titulo-dato"><span class="requeridos">* <b> </span>Instrucciones para áreas </b> </label>
                        <textarea class="form-control normalizar-texto" name="comentarios_opera_incen" id="comentarios_opera_incen" required campoNoVacio="true"></textarea>
                    </div>
                </div>

            </div>
            <div class="card-footer">
                <div class="text-center">
                    <button type="submit" class="btn btn-success"><i class="fas fa-check-square"></i> Finalizar tarea </button>
                    <button type="button" class="btn btn-danger" id="btn_cancelar"><i class="fas fa-times"></i> Cancelar proceso </button>
                </div>
            </div>
        </div>

    </form>

@endsection

@push('styles')

@endpush

@push('scripts')
    <script>
        const incentivoEmpleadoMes  = @Json($incentivoEmpleadoMes);
        const instanciaTarea        = @Json($instanciaTarea);
        const urlTareas = @Json( route('tareas') );
    </script>
    <script src="{{ asset('js/p19_incentivos_empleado_mes/tareas/T01_seleccionarQuincenaPago.js?v=1.0') }}"></script>
@endpush
