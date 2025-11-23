@extends('layouts.main')

@section('title', 'INICIO DE PROCESO')

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
                'titulo' => 'SERVICIO SOCIAL - INICIO DE PROCESO'
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
    @include('p06_servicio_social.partials.detalles_proceso', [ "secciones" => ["general"] ])
    
    <form method="POST" id="seleccionarPrestador">
    @csrf
    @method('post')
        <div class="card card-custom mt-5" id="candidatos">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Candidatos</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="alert alert-custom alert-success" role="alert">
                    <div class="alert-icon"><i class="flaticon-warning"></i></div>
                    <div class="alert-text">
                          <strong>
                              <p class="mb-2">Instrucciones:</p>
                              <ul class="mb-0">
                                  <li>Seleccione alguno de los candidatos disponibles para entrevistar.</li>
                                  <li>En caso de no encontrar al prestador que desea, solicitar al administrador del catálogo que registre a dicho candidato.</li>
                              </ul>
                          </strong>
                    </div>
                </div>
                <div class="table-responsive">
                    <table width="100%" class="table table-bordered" id="candidatosTable"
                        data-toggle='table'
                        data-pagination="true"
                        data-page-size="5"
                        data-page-number="1"
                        data-page-list="[5,10,all]"
                        data-search="true"
                        data-cache="false"
                    >
                        <thead>
                            <th class="text-center"><label class="titulo-dato">Seleccionar</label></th>
                            <th class="text-center"><label class="titulo-dato">Tipo de prestador</label></th>
                            <th class="text-center"><label class="titulo-dato">Nombre</label></th>
                            <th><label class="titulo-dato">Datos</label></th>
                            <th class="w-25"><label class="titulo-dato text-center">Datos académicos</label></th>
                            <th><label class="titulo-dato text-center">Domicilio</label></th>
                            <th><label class="titulo-dato text-center">Observaciones</label></th>
                        </thead>
                        <tbody>
                            @foreach($queryCandidatos as $candidato)
                            <tr>
                                <td>
                                    <label class="radio radio-lg radio-primary text-white">
                                        <input type="radio" name="seleccion" id="seleccion" data-seleccionar="{{$candidato->prestador_id}}">
                                        <span class="fm-check"></span>.
                                    </label>
                                </td>
                                <td class="text-center">
                                    @if( $candidato->tipo_prestador == 'SERVICIO SOCIAL' )
                                    <span class="badge badge-success badge-sm">{{$candidato->tipo_prestador}}</span>
                                    @else
                                    <span class="badge badge-primary badge-sm">{{$candidato->tipo_prestador}}</span>
                                    @endif
                                </td>
                                <td class="text-center"> {{ $candidato->nombre_prestador_completo }} </td>
                                <td> 
                                    <b>CORREO:</b> {{$candidato->email}} <br> 
                                    <b>TELÉFONO:</b> {{$candidato->telefono ?? 'N/A'}} 
                                </td>
                                <td>
                                    <b>INSTITUCIÓN: </b> {{$candidato->escuela->institucion['nombre_institucion'] ?? 'N/A'}} <br>
                                    <b>ESCUELA: </b> {{$candidato->escuela['nombre_escuela'] ?? 'N/A'}} <br>
                                    <b>CARRERA: </b> {{$candidato->carrera ?? 'N/A'}} <br>
                                    <b>MATRÍCULA: </b> {{$candidato->matricula ?? 'N/A'}}
                                </td>
                                <td>
                                    <b>CALLE: </b> {{$candidato->calle ?? 'N/A'}},
                                    <b>NO. EXTERIOR: </b> {{$candidato->numero_exterior ?? 'N/A'}},
                                    <b>NO. INTERIOR: </b> {{$candidato->numero_interior ?? 'N/A'}},
                                    <b>C.P: </b> {{$candidato->cp ?? 'N/A'}},
                                    <b>COLONIA: </b> {{$candidato->colonia ?? 'N/A'}},
                                    <b>ALCALDÍA: </b> {{$candidato->municipio->nombre ?? 'N/A'}},
                                    <b>CIUDAD: </b> {{$candidato->ciudad ?? 'N/A'}}
                                </td>
                                <td> {{$candidato->observaciones ?? 'N/A'}} </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <div class="text-center">
                    <button id="seleccionarCandidato" name="seleccionar" class="btn btn-success" type="button"><i class="fas fa-check-square"></i>Finalizar tarea</button>
                    <button id="finalizar" name="finalizar" class="btn btn-danger" type="button"><i class="fas fa-times"></i>Cancelar proceso</button>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        URL_seleccionarPrestador = "{{route('servicio.social.seleccionar.prestador', [$servicioSocial, $instanciaTarea] )}}";
        URL_finalizarProceso = "{{route('servicio.social.finalizar.proceso', [$servicioSocial, $instanciaTarea])}}";
    </script>
    <script src="{{ asset('js/p06_servicio_social/general_swal_alert.js') }}"></script>
    <script src="{{ asset('js/p06_servicio_social/tareas/T01_seleccionarPrestador.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/p06_servicio_social/servicioSocial.css') }}" type="text/css">
@endpush
