@extends('layouts.main')

@section('title', 'ASIGNACIÓN DE FUNCIONES')

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
                'titulo' => 'ASIGNACIÓN DE FUNCIONES'
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
    @include('p06_servicio_social.partials.detalles_proceso', [
        "secciones" => [
            "general",
            "datos_candidato" => ["horas", "observaciones"],
            "datos_escolares"
        ]
    ])
    <form action="{{ route('servicio.social.asignacion.labores', [$servicioSocial, $instanciaTarea]) }}" method="POST" id="formAsignacionFunciones">
        @method('post')
        @csrf

        <div class="card card-custom mt-5 mb-5">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Programa</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <label class="titulo-dato"> Nombre del programa </label>
                        <span class="valor-dato">  {{ $servicioSocial->prestador->programa->nombre_programa ?? 'N/A' }} </span>
                    </div>
                    <div class="col-md-12 mt-5">
                        <div class="form-group">
                            <label class="titulo-dato" for=""><strong><span class="requeridos">* </span>Actividades a realizar</strong></label>
                            <textarea rows="3" class="form-control normalizar-texto" name="actividades">@if($servicioSocial->actividades != null){{$servicioSocial->actividades}}@endif</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-custom mb-5">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Jefe inmediato</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="titulo-dato" for=""><strong><span class="requeridos">* </span>Nombre jefe</strong></label>
                            <input type="text" class="form-control normalizar-texto solo-texto" name="jefe" value="{{ $servicioSocial->jefe ?? '' }}" placeholder="INGRESE EL NOMBRE DEL JEFE A ASIGNAR">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="titulo-dato" for=""><strong><span class="requeridos">* </span>Puesto jefe</strong></label>
                            <input type="text" class="form-control normalizar-texto solo-texto" name="puesto_jefe" value="{{ $servicioSocial->puesto_jefe ?? '' }}" placeholder="INGRESE EL PUESTO">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="titulo-dato" for=""><strong><span class="requeridos">* </span>Teléfono jefe</strong></label>
                            <input type="text" class="form-control inputmk-10" name="telefono_jefe" minlength="10" 
                                value="{{ $servicioSocial->telefono_jefe ?? '' }}" placeholder="10 DÍGITOS" >
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="titulo-dato" for=""><strong><span class="requeridos">* </span>Teléfono ext jefe</strong></label>
                            <input type="text" class="form-control inputmk-6" name="telefono_ext_jefe" minlength="3" 
                                value="{{ $servicioSocial->telefono_ext_jefe ?? '' }}" placeholder="3 - 6 DÍGITOS" >
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-custom mt-5 mb-5">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Prestación de servicio</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="alert alert-custom alert-success" role="alert">
                    <div class="alert-icon"><i class="flaticon-warning"></i></div>
                    <div class="alert-text">
                          <strong>
                              <p class="mb-2">Instrucciones:</p>
                              <ul class="mb-0">
                                  <li>Establecer el horario que el candidato va a cubrir durante su permanencia</li>
                                  <li>Establecer el lugar donde el candidato ofrecera sus servicios</li>
                              </ul>
                          </strong>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-md-2">
                        <label class="titulo-dato"> Total de horas </label>
                        <span class="valor-dato">  {{ $servicioSocial->prestador->total_horas }} </span>
                    </div>
                    <div class="col-md-5 campo">

                        <label class="titulo-dato"><strong><span class="requeridos">*</span> PERIODO</strong></label>
                        <div class="input-daterange input-group date-picker-range">
                                <input type="text" class="form-control cursor-pointer fecha-inicio" name="fecha_inicio" placeholder="FECHA DE INICIO" value="{{$servicioSocial->fecha_inicio}}" readonly />
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="la la-ellipsis-h"></i></span>
                                </div>
                                <input type="text" class="form-control cursor-pointer fecha-fin" name="fecha_fin" placeholder="FECHA DE FIN" value="{{$servicioSocial->fecha_fin}}" readonly/>
                        </div>
                        <p class="msg"></p>
                        </div>
                    <div class="col-md-5">
                        @php $horario = explode(" - ", $servicioSocial->horario); @endphp
                        <label class="titulo-dato"><strong><span class="requeridos">*</span> HORARIO</strong></label>
                        <div class="input-daterange input-group">
                            <input type="text" class="form-control cursor-pointer time-picker" name="hora_entrada" placeholder="HORA DE ENTRADA" value="{{$horario[0]}}" readonly />
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="la la-ellipsis-h"></i></span>
                            </div>
                            <input type="text" class="form-control cursor-pointer time-picker" name="hora_salida" placeholder="HORA DE SALIDA" value="{{$horario[1]}}" readonly />
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row mt-5">
                    <div class="col-md-4">
                        <label class="titulo-dato"><strong><span class="requeridos">*</span> Área de adscripción</strong></label>
                        <select name="area_adscripcion_id" class="form-control selectpicker area_adscripcion_id">
                            <option value="" {{(!is_null($servicioSocial->area_adscripcion_id)) ? '' : 'selected'}} disabled>SELECCIONE UNA OPCIÓN</option>
                            @foreach ($areasAdscripcion as $area)
                                <option value="{{ $area->area_adscripcion_id }}" {{($area->area_adscripcion_id == $servicioSocial->area_adscripcion_id) ? 'selected' : ''}}>{{ $area->nombre_area_adscripcion }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="titulo-dato">Dirección ejecutiva (Dirección área)</label>
                        <input type="text" class="form-control normalizar-texto solo-texto" name="direccion_ejecutiva" value="{{$servicioSocial->direccion_ejecutiva ?? ''}}" placeholder="ingrese la dir. ejecutiva">
                    </div>
                    <div class="col-md-4">
                        <label class="titulo-dato">Coordinación</label>
                        <input type="text" class="form-control normalizar-texto solo-texto" name="coordinacion" value="{{$servicioSocial->coordinacion}}" placeholder="ingrese la coordinación">
                    </div>
                    <div class="col-md-4">
                        <label class="titulo-dato"><strong><span class="requeridos">*</span> Subdirección</strong></label>
                        <input type="text" class="form-control normalizar-texto solo-texto" name="subdireccion_ua" value="{{$servicioSocial->subdireccion_ua ?? ''}}" placeholder="ingrese la subdirección">
                    </div>
                    <div class="col-md-4">
                        <label class="titulo-dato"><strong><span class="requeridos">*</span> Unidad departamental</strong></label>
                        <input type="text" class="form-control normalizar-texto solo-texto" name="unidad_departamental_ua" value="{{$servicioSocial->unidad_departamental_ua ?? ''}}" placeholder="ingrese la ud. departamental">
                    </div>
                    <div class="col-md-4">
                        <label class="titulo-dato"><strong><span class="requeridos">*</span> Domicilio de adscripción</strong></label>
                        <input type="text" class="form-control normalizar-texto domicilio_ua" name="domicilio_ua" value="{{$servicioSocial->areaAdscripcion->direccion_area_adscripcion ?? ''}}" placeholder="Dir. de adscripción" readonly>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="text-center">
                    <button type="button" id="btnAsignarFunciones" class="btn btn-success"><i class="fas fa-check-square"></i>Finalizar Tarea</button>
                </div>
            </div>
        </div>
    </form>

@endsection

@push('scripts')
    <script>
        var URL_getEscuelas = "{{ route('obtener.domicilio.area.adscripcion') }}";
    </script>
    <script src="{{ asset('js/p06_servicio_social/js_general.js') }}"></script>
    <script src="{{ asset('js/p06_servicio_social/general_swal_alert.js') }}"></script>
    <script src="{{ asset('js/p06_servicio_social/tareas/T04_asignacionFunciones.js') }}"></script>
@endpush
