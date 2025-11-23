@extends('layouts.main')

@section('title', 'NUEVO SEGUIMIENTO AGREGADO')

@section('subheader')
    @include('layouts.partials.main.subheader', ["subheader" => [
        "titulo_subheader" => "PROCDGA",
        "icono_titulo_subheader" => "far fa-folder-open",
        "breadcrumbs" => [
            1 => [
                'activo' => false,
				'titulo' => 'Notificaciones disponibles',
				'ruta' => Route('notificaciones')
            ],
            2 => [
                'activo' => true,
                'titulo' => 'NUEVO SEGUIMIENTO AGREGADO'
            ]
        ]
    ]])
@endsection

@section('aside_menu')
    @include('layouts.partials.main.aside_menu', ["asideMenu" =>
        [
            "item_seleccionado" => "notificaciones",
        ]
    ])
@endsection

@section('contenido')
    @include('p06_servicio_social.partials.detalles_proceso_notificaciones', [ 
        "secciones" => [
            "general", 
            "datos_candidato" => ["horas","observaciones"],
            "datos_escolares" => ["genaral"],
        ] 
    ])
{{--
    <div class="row">
        <div class="col-12">
            <div class="card card-custom mb-5">
                <div class="card-header">
                    <div class="card-title">
                        <h3 class="card-label">Nuevo seguimiento agregado al expediente del prestador</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
--}}
    <form action="{{ route('servicio.social.notificacion.nuevo.segumiento', [$servicioSocial, $instanciaTarea]) }}" method="post">
        @method('post')
        @csrf
{{--
        <div class="card card-custom mb-5">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Datos generales</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <label class="titulo-dato"> Unidad administrativa </label>
                        <span class="valor-dato">  {{ $servicioSocial->area->identificador }} - {{ $servicioSocial->area->nombre }} </span>
                    </div>
                    <div class="col-md-6">
                        <label class="titulo-dato"> Folio </label>
                        <span class="valor-dato">  {{ $servicioSocial->instancia->folio }} </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-custom mb-5">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Datos del candidato</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <label class="titulo-dato"> Nombre </label>
                        <span class="valor-dato">  {{ $servicioSocial->prestador->primer_apellido }} {{ $servicioSocial->prestador->segundo_apellido }} {{ $servicioSocial->prestador->nombre_prestador }} </span>
                    </div>
                    <div class="col-md-3">
                        <label class="titulo-dato"> Carrera </label>
                        <span class="valor-dato">  {{ $servicioSocial->prestador->carrera }} </span>
                    </div>
                    <div class="col-md-3">
                        <label class="titulo-dato"> Matrícula </label>
                        <span class="valor-dato">  {{ $servicioSocial->prestador->matricula }} </span>
                    </div>
                    <div class="col-md-3">
                        <label class="titulo-dato"> Horario </label>
                        <span class="valor-dato">  {{ $servicioSocial->horario }} </span>
                    </div>
                    <div class="col-md-6">
                        <label class="titulo-dato"> Institución </label>
                        <span class="valor-dato">  {{ $servicioSocial->prestador->escuela->institucion->nombre_institucion }} </span>
                    </div>
                    <div class="col-md-6">
                        <label class="titulo-dato"> Escuela </label>
                        <span class="valor-dato">  {{ $servicioSocial->prestador->escuela->nombre_escuela }} </span>
                    </div>
                </div>
            </div>
        </div>
--}}
        <div class="card card-custom mt-5">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Seguimientos</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="alert alert-custom alert-success" role="alert">
                    <div class="alert-icon"><i class="flaticon-warning"></i></div>
                    <div class="alert-text">
                        <strong>
                        Nuevo seguimiento agregado al expediente del prestador
                        </strong>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered" id="TablaSeguimientoEventos" data-toggle="table">
                            <thead>
                                <th class="text-center"><label class="titulo-dato text-center"> Fecha </label></th>
                                <th class="w-50"><label class="titulo-dato text-center"> Comentario </label></th>
                                <th class="text-center"><label class="titulo-dato text-center"> Informe </label></th>
                            </thead>
                            <tbody>
                                @foreach ($getSeguimientos as $segui)
                                    <tr>
                                        <td class="text-center align-middle">{{$segui->fecha_comentario}}</td>
                                        <td>{{$segui->comentario}}</td>

                                        <td class="text-center align-middle">
                                            @if ( $segui->informe_mayus == "INFORME UNO" )
                                                <span class="badge badge-success">{{ $segui->informe_mayus }}</span>
                                            @elseif( $segui->informe_mayus == "INFORME DOS" )
                                                <span class="badge badge-primary">{{ $segui->informe_mayus }}</span>
                                            @elseif( $segui->informe_mayus == "INFORME TRES" )
                                                <span class="badge badge-warning">{{ $segui->informe_mayus }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            <div class="card-footer">
                <div class="text-center">
                    <button type="submit" class="btn btn-success btn-sl"><i class="fas fa-trash"></i>Enterado, eliminar notificación</button>
                </div>
            </div>
        </div>

    </form>
@endsection


@push('scripts')
    <script src="{{ asset('js/p06_servicio_social/notificaciones/TANOTA05.js') }}"></script>
    {{-- <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script> --}}
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>

@endpush
