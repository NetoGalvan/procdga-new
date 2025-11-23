@extends('layouts.main')

@section('title', 'Directorio - T01 Cargar Alfabético')

@section('breadcrumbs')
    @include('componentes.breadcrumbs', ['breadcrumbs' =>   [
                                                            [
                                                                'activo' => false,
                                                                'titulo' => 'Tareas disponibles',
                                                                'ruta' => Route('tareas')
                                                            ],
                                                            [
                                                                'activo' => true,
                                                                'titulo' => 'Directorio - T01 Cargar Alfabético'
                                                            ],
                                                        ]
                                    ])
@endsection

@section('contenido')
    <div class="container">

        <div class="titulo-tarea mb-4">
            <h4 class="mb-3">Directorio - Carga de alfabético</h4>
            <div class="alert alert-info" role="alert">
                <h5>Folio: {{ $directorio->folio }}</h5>
            </div>
        </div>

        <form method="POST" id="form_carga_alfabetico" enctype="multipart/form-data" action="{{ route('directorio.carga.alfabetico', ['directorio' => $directorio->p24_directorio_id]) }}">
        @method('post')
        @csrf
            <div class="card shadow-sm px-5 py-4 bg-white rounded">
                <h5>Instrucciones</h5>
                <div class="titulo-tarea">
                    <div class="alert alert-info" role="alert">
                            <p>Puede realizar una carga del archivo ALFABETICO para uso dentro del sistema PROCDGA.</p>

                            <p>Es importante que tome en cuenta las siguientes instrucciones:</p>

                            <p>1. EL ARCHIVO DEBE SER LAYOUT: DGADP debió de hacerle llegar un archivo ZIP que contiene el layout a utilizar. Extráigalo y envíelo sin cambios, sin modificaciones</p>
                            <p>2. SÓLO PUEDE SUBIR UN ARCHIVO A LA VEZ: Si hubo alguna equivocación, haga click en el botón CANCELAR ESTE PROCESO y vuelva a empezar.</p>
                    </div>
                </div>

                <hr>
                @if (!$directorio->is_auth)
                    <div>
                        <div class="row mt-2">

                            <div class="col-md-3 form-group">
                                <label for=""><span class="requeridos">* </span>Año</label>
                                <select name="alfa_anio" id="alfa_anio" class="form-control form-control-sm" >
                                    <option value="">Selecionar año</option>
                                    <option value ="2018">2018</option>
                                    <option value ="2019">2019</option>
                                    <option value ="2020">2020</option>
                                    <option value ="2021">2021</option>
                                    <option value ="2022">2022</option>
                                    <option value ="2023">2023</option>
                                </select>
                                @error('alfa_anio')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 form-group">
                                <label for=""><span class="requeridos">* </span>Quincena</label>
                                <select name="alfa_qna" id="alfa_qna" class="form-control form-control-sm" >
                                    <option value="">Selecionar quincena</option>
                                    <option value ="Q01">Q01</option>
                                    <option value ="Q02">Q02</option>
                                    <option value ="Q03">Q03</option>
                                    <option value ="Q04">Q04</option>
                                    <option value ="Q05">Q05</option>
                                    <option value ="Q06">Q06</option>
                                    <option value ="Q07">Q07</option>
                                    <option value ="Q08">Q08</option>
                                    <option value ="Q09">Q09</option>
                                    <option value ="Q10">Q10</option>
                                    <option value ="Q11">Q11</option>
                                    <option value ="Q12">Q12</option>
                                    <option value ="Q13">Q13</option>
                                    <option value ="Q14">Q14</option>
                                    <option value ="Q15">Q15</option>
                                    <option value ="Q16">Q16</option>
                                    <option value ="Q17">Q17</option>
                                    <option value ="Q18">Q18</option>
                                    <option value ="Q19">Q19</option>
                                    <option value ="Q20">Q20</option>
                                    <option value ="Q21">Q21</option>
                                    <option value ="Q22">Q22</option>
                                    <option value ="Q23">Q23</option>
                                    <option value ="Q24">Q24</option>
                                </select>
                                @error('alfa_qna')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 form-group">
                                <label for=""><span class="requeridos">* </span>Archivo</label>
                                <input type="file" accept="text/plain" name="sube_archivo" id="sube_archivo" class="form-control form-control-sm">
                                @error('sube_archivo')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mt-2">

                            <div class="col-md-12 form-group">
                                <p>IMPORTANTE</p>
                                <p>¿DESEA USTED QUE ESTE ALFABETICO SEA EL AUTORITATIVO?</p>
                                <p>Revise con cuidado las fechas de año y quincena que está seleccionando, así como el archivo que seleccione en su computadora.</p>
                            </div>

                            <div class="col-md-12 form-group">
                                <label><input type="checkbox" id="is_auth" name="is_auth" value="true"> ¿Sobreescribir el alfabetico actual con este archivo? </label><br>
                            </div>

                            <div class="col-md-12 form-group">
                                <button  type="submit" id="btn_carga_alfabetico" class="btn btn-primary btn-success btn-sm">Cargar</button>
                            </div>

                        </div>
                    </div>
                @endif
            </div>

            @if ( $directorio->is_auth )
                <div class="card shadow-sm mt-3 px-5 py-4 bg-white rounded ">
                    <h5>Alfabeticos preparados para cargar en esta tarea</h5>
                    <hr>
                    <div id="archivo">
                        <p><h6>ARCHIVO EN PROCESO</h6></p>
                        <p><b>Archivo:</b> {{$directorio->temp_file}}, (<b>nombre original:</b> {{$directorio->original_file}}). </p>
                        <p><b>Subido el:</b> {{$directorio->updated_at}} </p>
                        <p><b>Codificación:</b> {{$directorio->temp_charset}} </p>
                        <p><b>Año:</b> {{$directorio->temp_anio}}, <b> Quincena:</b> {{$directorio->temp_qna}}, ES EL NUEVO ALFABETICO? <b> {{ ($directorio->is_auth) ? 'SI' : 'NO' }} </b></p>
                    </div>
                </div>
            @endif

            @if( !empty($lineasAlfabeticoCargado) )
                <div class="card shadow-sm mt-3 px-5 py-4 bg-white rounded ">
                    <div class="table-responsive">
                        <table id="dtHorizontalExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%" >
                            <thead>
                                <tr>
                                    <th scope="col">id_sector</th>
                                    <th scope="col">id_unidad_adm</th>
                                    <th scope="col">id_empleado</th>
                                    <th scope="col">apellido_1</th>
                                    <th scope="col">apellido_2</th>
                                    <th scope="col">nombre</th>
                                    <th scope="col">nombre_completo</th>
                                    <th scope="col">id_legal</th>
                                    <th scope="col">curp</th>
                                    <th scope="col">fec_nac</th>
                                    <th scope="col">id_sexo</th>
                                    <th scope="col">id_subunidad</th>
                                    <th scope="col">id_direccion_adm</th>
                                    <th scope="col">id_subdireccion</th>
                                    <th scope="col">id_jud</th>
                                    <th scope="col">id_ofcina</th>
                                    <th scope="col">id_tipo_nomina</th>
                                    <th scope="col">id_universo</th>
                                    <th scope="col">id_nivel_salarial</th>
                                    <th scope="col">id_puesto</th>
                                    <th scope="col">n_puesto</th>
                                    <th scope="col">id_sindicato</th>
                                    <th scope="col">sit_emp</th>
                                    <th scope="col">id_plaza</th>
                                    <th scope="col">fec_alta_empleado</th>
                                    <th scope="col">fec_antguedad</th>
                                    <th scope="col">id_turno</th>
                                    <th scope="col">id_zona_pagadora</th>
                                    <th scope="col">numero_ss</th>
                                    <th scope="col">dias_lab</th>
                                    <th scope="col">id_reg_issste</th>
                                    <th scope="col">no_cta_bancaria</th>
                                    <th scope="col">banco</th>
                                    <th scope="col">percepciones</th>
                                    <th scope="col">deducciones</th>
                                    <th scope="col">liquido</th>
                                    <th scope="col">hijos</th>
                                </tr>
                            </thead>
                            @foreach ($lineasAlfabeticoCargado as $itemEmpleado)
                                <tbody>
                                    <tr>
                                        <td>{{ $itemEmpleado[0] }}</td>
                                        <td>{{ $itemEmpleado[1] }}</td>
                                        <td>{{ $itemEmpleado[2] }}</td>
                                        <td>{{ $itemEmpleado[3] }}</td>
                                        <td>{{ $itemEmpleado[4] }}</td>
                                        <td>{{ $itemEmpleado[5] }}</td>
                                        <td>{{ $itemEmpleado[6] }}</td>
                                        <td>{{ $itemEmpleado[7] }}</td>
                                        <td>{{ $itemEmpleado[8] }}</td>
                                        <td>{{ $itemEmpleado[9] }}</td>
                                        <td>{{ $itemEmpleado[10] }}</td>
                                        <td>{{ $itemEmpleado[11] }}</td>
                                        <td>{{ $itemEmpleado[12] }}</td>
                                        <td>{{ $itemEmpleado[13] }}</td>
                                        <td>{{ $itemEmpleado[14] }}</td>
                                        <td>{{ $itemEmpleado[15] }}</td>
                                        <td>{{ $itemEmpleado[16] }}</td>
                                        <td>{{ $itemEmpleado[17] }}</td>
                                        <td>{{ $itemEmpleado[18] }}</td>
                                        <td>{{ $itemEmpleado[19] }}</td>
                                        <td>{{ $itemEmpleado[20] }}</td>
                                        <td>{{ $itemEmpleado[21] }}</td>
                                        <td>{{ $itemEmpleado[22] }}</td>
                                        <td>{{ $itemEmpleado[23] }}</td>
                                        <td>{{ $itemEmpleado[24] }}</td>
                                        <td>{{ $itemEmpleado[25] }}</td>
                                        <td>{{ $itemEmpleado[26] }}</td>
                                        <td>{{ $itemEmpleado[27] }}</td>
                                        <td>{{ $itemEmpleado[28] }}</td>
                                        <td>{{ $itemEmpleado[29] }}</td>
                                        <td>{{ $itemEmpleado[30] }}</td>
                                        <td>{{ $itemEmpleado[31] }}</td>
                                        <td>{{ $itemEmpleado[32] }}</td>
                                        <td>{{ $itemEmpleado[33] }}</td>
                                        <td>{{ $itemEmpleado[34] }}</td>
                                        <td>{{ $itemEmpleado[35] }}</td>
                                        <td>{{ $itemEmpleado[36] }}</td>
                                    </tr>
                                </tbody>
                            @endforeach
                        </table>
                    </div>
                </div>
            @endif


            <div class="card shadow-sm mt-3 px-5 py-4 bg-white rounded ">
                <h5>Listado de alfabeticos procesados anteriormente</h5>
                <hr>

                <table id="listado_alfabetico" class="table table-striped">
                    <thead>
                        <tr>
                        <th data-field="alfa_anio">Año</th>
                        <th data-field="alfa_qna">Quincena</th>
                        <th data-field="datos_alfa">Datos de alfabético</th>
                        </tr>
                    </thead>
                </table>

            </div>

            {{-- OPCIÓN PARA CARGAR ALFABETICO CON UN SERVICIO --}}
            {{-- <div class="row mt-2">
                <div class="col-md-12 form-group">
                    <button  type="button" id="btn_alfabetico" class="btn btn-primary btn-success btn-sm">Cargar alfabético</button>
                </div>
                <div class="error-alfabetico"  style="padding-right: 15px; padding-left: 15px;">
                </div>
            </div>

            <table id="alfabetico" class="table table-striped"
                data-toggle="table"
                data-toolbar="#toolbar"
                data-height="428"
                data-url="json/data1.json">
            <thead>
            <tr>
                <th data-field="id" style="display:none" >Id</th>
                <th data-field="id_empleado">No. empleado</th>
                <th data-field="nombre">Nombre</th>
            </tr>
            </thead>
            </table> --}}
            {{-- FIN OPCIÓN PARA CARGAR ALFABETICO CON UN SERVICIO --}}


            @if ( $directorio->is_auth )
                <div class="text-center my-5">
                    <button type="submit" class="btn btn-success btn-sl">Finalizar tarea</button>

                    <button id="bnt-cancelar-carga" type="button" class="btn btn-danger btn-sl">Cancelar Proceso</button>
                </div>
            @endif
            @if ( !$directorio->is_auth )
                <div class="text-center my-5">
                        <button id="bnt-cancelar-carga" type="button" class="btn btn-danger btn-sl">Cancelar Proceso</button>
                </div>
            @endif
        </form>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/p24_carga_alfabetico/T01_cargaAlfabetico.css') }}" />
@endpush

@push('scripts')
    <script src="{{ asset('js/directorio/T01_cargaAlfabetico.js') }}"></script>
    <script type="text/javascript">
        var jsonListaAlfabeticos = @json($listaAlfabeticos);
    </script>
@endpush
