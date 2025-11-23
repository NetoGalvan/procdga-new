@extends('layouts.main')

@section('title', 'Directorio - T02 Completar datos de plazas nuevas')

@section('breadcrumbs')
    @include('componentes.breadcrumbs', ['breadcrumbs' =>   [
                                                            [
                                                                'activo' => false,
                                                                'titulo' => 'Tareas disponibles',
                                                                'ruta' => Route('tareas')
                                                            ],
                                                            [
                                                                'activo' => true,
                                                                'titulo' => 'Directorio - T02 Completar datos de plazas nuevas'
                                                            ],
                                                        ]
                                    ])
@endsection

@section('contenido')
    <div class="container">

        <div class="titulo-tarea mb-4">
            <h4 class="mb-3">Directorio - Completar datos de plazas nuevas</h4>
            <div class="alert alert-info" role="alert">
                <h5>Folio: {{ $directorio->folio }}</h5>
            </div>
        </div>

        <form method="POST" id="form_completar_datos_plazas_nuevas" enctype="multipart/form-data" action="{{ route('directorio.completa.datos.plazas.nuevas', ['directorio' => $directorio->p24_directorio_id]) }}">
        @method('post')
        @csrf


            {{-- Prueba servcio plaza --}}
            <div class="row">
                <div class="col-10 col-sm-6 col-md-4 col-lg-4 form-group">
                    <label for="plaza_id" class="titulo-dato"><span class="requeridos">* </span>Plaza</label>
                    <input type="number" class="form-control form-control-sm @error('plaza_id') error @enderror"
                    name="plaza_id" id="plaza_id" placeholder="No. Plaza">
                </div>
                <div id="x"></div>
            </div>
            <div class="row">
                <div class="col-10 col-sm-6 col-md-4 col-lg-4 form-group">
                    <label for="universo_id" class="titulo-dato"><span class="requeridos">* </span>Universo</label>
                    <input type="text" class="form-control form-control-sm @error('universo_id') error @enderror"
                    name="universo_id" id="universo_id" placeholder="No. Plaza">
                </div>
            </div>
            <div class="row">
                <div class="col-10 col-sm-6 col-md-4 col-lg-4 form-group">
                    <label for="nivel_salarial" class="titulo-dato"><span class="requeridos">* </span>Nivel salarial</label>
                    <input type="text" class="form-control form-control-sm @error('nivel_salarial') error @enderror"
                    name="nivel_salarial" id="nivel_salarial" placeholder="Nivel salarial">
                </div>
            </div>
            <div class="col-md-12 form-group">
                <button data-url="{{ Route('get.plaza') }}" type="button" id="btn_plaza" class="btn btn-primary btn-success btn-sm">Buscar plaza</button>
            </div>
            {{-- Fin prueba servcio plaza --}}

            <div class="card shadow-sm px-5 py-4 bg-white rounded">
                <h5>Instrucciones</h5>
                <div class="titulo-tarea">
                    <div class="alert alert-info" role="alert">
                            <p>Se muestra un resumen de los cambios que se realizarán al catálogo de plazas.</p>
                            <p>Adicionalmente se muestran las <b>PLAZAS NUEVAS</b> para que se les capture la información faltante, si se tiene en este momento.</p>
                            <p>Por <b>PUESTO FUNCIONAL</b> se entiende la descripción <b>corta</b>, de unas cuantas palabras que describen las funciones particulares de esta plaza actualmente.</p>
                            <p>El resto de la información que se muestra no es editable.</p>
                            <p>Cuando termine, oprima el botón de <b>"Continuar"</b>.</p>
                    </div>
                </div>
                <hr>

                <div class="card shadow-sm mt-3 px-5 py-4 bg-white rounded ">
                    <h5>Campos que definen una plaza</h5>
                    <hr>
                    <ul>
                        <li>plaza_id</li>
                        <li>id_unidad_adm</li>
                        <li>id_subunidad</li>
                        <li>id_direccion_adm</li>
                        <li>id_subdireccion</li>
                        <li>id_jud</li>
                        <li>id_oficina</li>
                        <li>id_puesto</li>
                        <li>id_nivel_salarial</li>
                        <li>id_universo</li>
                        <li>n_puesto</li>
                        <li>descripcion_puesto</li>
                        <li>estatus_empleado</li>
                        <li>folio</li>
                        <li>oficio_dictaminacion</li>
                        <li>updated_at</li>
                    </ul>
                </div>
            </div>


            <div class="card shadow-sm mt-3 px-5 py-4 bg-white rounded ">
                <div class="table-responsive">
                    <table id="dtHorizontalExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%" >
                        <thead>
                            <tr>
                                <th scope="col">ID plaza</th>
                                <th scope="col">clave de adscripción</th>
                                <th scope="col">nombre_completo</th>
                                <th scope="col">ID puesto</th>
                                <th scope="col">nombre puesto</th>
                                <th scope="col">ID nivel salarial</th>
                                <th scope="col">ID universo</th>
                                <th scope="col">Situación plaza</th>
                                <th scope="col">Puesto funcional</th>
                                <th scope="col">Oficio de dictaminación</th>
                            </tr>
                        </thead>
                        @foreach ($lineasAlfabeticoCargado as $itemEmpleado)
                            <tbody>
                                <tr>
                                    <td>{{ $itemEmpleado[23] }}</td>
                                    <td>{{ $itemEmpleado[25] }}</td>
                                    <td>{{ $itemEmpleado[6] }}</td>
                                    <td>{{ $itemEmpleado[19] }}</td>
                                    <td>{{ $itemEmpleado[20] }}</td>
                                    <td>{{ $itemEmpleado[21] }}</td>
                                    <td>{{ $itemEmpleado[17] }}</td>
                                    <td>{{ $itemEmpleado[11] }}</td>
                                    <td> <input type="text" class="form-control form-control-sm"> </td>
                                    <td> <input type="text" class="form-control form-control-sm"></td>
                                </tr>
                            </tbody>
                        @endforeach
                    </table>
                </div>
            </div>

            <div class="text-center my-5">
                <button type="button" class="btn btn-success btn-sl">Finalizar tarea</button>
            </div>

        </form>
    </div>
@endsection

@push('styles')
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('css/p24_carga_alfabetico/T01_cargaAlfabetico.css') }}" /> --}}
@endpush

@push('scripts')
    <script src="{{ asset('js/directorio/T02_completaDatosPlazasNuevas.js') }}"></script>
@endpush
