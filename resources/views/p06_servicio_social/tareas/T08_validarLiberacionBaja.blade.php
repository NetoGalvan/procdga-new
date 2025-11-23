@extends('layouts.main')

@section('title', 'VALIDAR LIBERACIÓN O BAJA DEL PRESTADOR')

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
                'titulo' => 'VALIDAR LIBERACIÓN O BAJA DEL PRESTADOR'
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

@push('styles')
	<link href="{{ asset('metronic/plugins/custom/bootstraptable/css/bootstrap-table.min.css') }}" type="text/css" rel="stylesheet"/>
@endpush

@section('contenido')
    @include('p06_servicio_social.partials.detalles_proceso', [ 
        "secciones" => [
            "general", 
            "datos_candidato" => ["observaciones"],
            "datos_escolares",
            "prestacion_servicio"
        ] 
    ])

    <form action="{{ route('servicio.social.validar.liberacion.o.baja.prestador', [$servicioSocial, $instanciaTarea]) }}" method="POST" id="formValidarTarea">
        @method('post')
        @csrf

        <div class="card card-custom mt-5 mb-5">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Documentos cargados por el enlace</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="alert alert-custom alert-success" role="alert">
                    <div class="alert-icon"><i class="flaticon-warning"></i></div>
                    <div class="alert-text">
                        <strong>
                            <p class="mb-2 ml-6">Nota:</p>
                            <ul class="mb-0">
                                <li>
                                    Para liberar el servicio, el candidato debe cumplir satisfactoriamente con su tiempo y horas de servicio.
                                </li>
                                <li>
                                    Para dar de baja al candidato debe de existir una "solicitud de baja" generada por el enlace. 
                                </li>
                                <li>
                                    Para validar el abandono del candidato, el enlace debe generar la salicitud de "abandono".
                                </li>
                            </ul>
                        </strong>
                    </div>
                </div>
                <div class="row justify-content-center text-center">
                    <div class="horas-asistencia"></div>
                    <div class="col-md-2">
                        <label class="titulo-dato">Total de horas </label>
                        <div class="total-horas"> {{$servicioSocial->prestador->total_horas}} </div>
                    </div>
                    <div class="col-md-3">
                        <label class="titulo-dato">Horas restantes</label>
                        <div class="horas-restantes">
                            {{$servicioSocial->prestador->total_horas - $servicioSocial->horas_acumuladas}}
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <table width="100%" class="table" id="tabla_documento" data-toggle="table">
                            <thead>
                                <tr>
                                    <th class="text-center"><label class="titulo-dato"> Tipo </label></th>
                                    <th class="w-50"><label class="titulo-dato text-center"> Descripción </label></th>
                                    <th class="text-center"><label class="titulo-dato"> Horas asistencia </label></th>
                                    <th class="text-center w-25"><label class="titulo-dato"> Fecha </label></th>
                                    <th class="text-center"><label class="titulo-dato"> Archivo </label></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($documentosRecibidos as $documento)
                                    <tr>
                                        <td>
                                            @if($documento->tipo_archivo == 'SOLICITAR BAJA')
                                                <span class="badge badge-danger">{{$documento->tipo_archivo}}</span>
                                            @elseif($documento->tipo_archivo == 'SUBIR HORAS')
                                                <span class="badge badge-primary">{{$documento->tipo_archivo}}</span>
                                            @else
                                                <span class="badge badge-secondary">{{$documento->tipo_archivo}}</span>
                                            @endif
                                        </td>
                                        <td>{{ $documento->descripcion }}</td>
                                        <td>
                                            @if($documento->tipo_archivo == 'SUBIR HORAS')
                                                {{ $documento->horas_asistencia }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>{{ $documento->fecha_detalle }}</td>
                                        <td>
                                            @if($documento->tipo_archivo == 'ABANDONO')
                                                N/A
                                            @else
                                                <a class="btn btn-danger abrir-archivo" title="Abrir documento" target="_blank" 
                                                    href="{{asset('/storage\/').$documento->ruta_archivo}}"
                                                >
                                                    <i class="far fa-file-pdf"></i>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-4 mt-10">
                        <select name="validacion" id="validacion" class="form-control selectpicker">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            @foreach ($opcionesValidacion as $validacion)
                                <option value="{{ $validacion }}">{{ $validacion }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="text-center">
                    <button type="button" id="validarTarea" class="btn btn-success"><i class="fas fa-check-square"></i>Finalizar Tarea</button>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
<script src="{{ asset('js/p06_servicio_social/js_general.js') }}"></script>
    <script src="{{ asset('js/p06_servicio_social/general_swal_alert.js') }}"></script>
    <script src="{{ asset('js/p06_servicio_social/tareas/T08_validarLiberacionBaja.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
@endpush
