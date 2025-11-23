@extends('layouts.main')

@section('title', 'SELECCIÓN DE TIPO DE NÓMINA')

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
                'titulo' => 'SELECCIÓN DE TIPO DE NÓMINA'
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
    <form method="POST" id="id_form_finalizar_T01_seleccion_nomina">
    @csrf
    @method('post')
        <div class="row">
            <div class="col-12">
                <div class="card card-custom">
                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="card-label">Selección de tipo de nómina</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div>
                            <div class="alert alert-custom alert-success" role="alert">
                                <div class="alert-icon"><i class="flaticon-warning"></i></div>
                                <div class="alert-text">
                                    <p class="font-size-lg"><strong>
                                        Instrucciones: <br>
                                        Seleccionar el tipo de nómina que desea enviar a validación por los usuarios con el rol de SUB_EA. <br>
                                        Las nóminas posibles son:
                                        <ul class="font-size-lg">
                                            <li>
                                                Nómina parcial: En este tipo de nómina solamente podrá seleccionar a los prestadores que ya hayan recibido su carta de termino de servicio.
                                            </li>
                                            <li>
                                                Nómina completa: Este tipo de nómina le permite seleccionar al total de prestadores de servicio social.
                                                <br>
                                                Esto incluye a los que ya han sido liberados y a los que aún estan realizando su servicio.
                                            </li>

                                        </ul>
                                    </strong></p>
                                    <p class="font-size-lg"><strong>
                                        Nota: <br>
                                        En cualquier caso, sólo se seleccionarán a aquellos prestadores que sean de servicio social y que no hayan abandonado.
                                    </strong></p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group campo">
                                    <label for="" class="titulo-dato"><strong><span class="requeridos">* </span>Seleccione el tipo de nómina que desea validar</strong></label>
                                    <div class="radio-inline">
                                        <label class="radio radio-lg text-center">
                                            <input type="radio" class="tipo-nomina" name="tipo_nomina" id="nomina" value="PARCIAL" />
                                            <span></span>
                                            &nbsp; Nómina Parcial
                                        </label>
                                        <label class="radio radio-lg">
                                            <input type="radio" class="tipo-nomina" name="tipo_nomina" id="nomina2" value="COMPLETA" />
                                            <span></span>
                                            &nbsp; Nómina Completa
                                        </label>
                                    </div>
                                    <p class="msg"></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="correo" class="titulo-dato"><strong><span class="requeridos">* </span>Nombre breve de la nómina</strong></label>
                                    <input type="text" class="form-control normalizar-texto" name="nombreNomina"
                                    autocomplete="off" id="nombreNomina" placeholder="Ej: Enero 2023 nómina parcial">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group campo">
                                    <label for="correo" class="titulo-dato"><strong><span class="requeridos">* </span>Seleccione un rango de fechas</strong></label>
                                    <div class="input-daterange input-group" id="rango_de_fecha">
                                        <input type="text" class="form-control fecha-inicio" name="fecha_inicio" autocomplete="off" placeholder="FECHA INICIO" />
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                        <input type="text" class="form-control fecha-fin" name="fecha_fin" autocomplete="off" placeholder="FECHA FIN" />
                                    </div>
                                    <p class="msg"></p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="correo" class="titulo-dato"><strong><span class="requeridos">* </span>Observaciones</strong></label>
                                    <textarea name="observacionesNomina" id="observacionesNomina" class="form-control normalizar-texto" rows="4" placeholder="Notas, comentarios, fechas, etc..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                            <button id="finalizarT01SeleccionNomina" name="finalizarT01Nomina" class="btn btn-success btn-md" type="submit">
                                <i class="fas fa-check-square"></i>Finalizar tarea
                            </button>

                            <button id="finalizarSubProceso" name="finalizarSubProceso" class="btn btn-danger mx-2">
                                <i class="fas fa-trash"></i>Cancelar
                            </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
@push('scripts')
<script type="text/javascript">
    var URL_seleccionarTipoNomina = "{{ route('servicio.social.sub.seleccion.tipo.nomina', [$nomina, $instanciaTarea] ) }}";
    var URL_finalizarProceso = "{{ route('finalizar.proceso.desde.T03', [$nomina->nomina_id, $instanciaTarea]) }}";
</script>
<script src="{{ asset('js/p06_servicio_social/general_swal_alert.js') }}"></script>
<script src="{{ asset('js/p06_servicio_social/sub_proceso/T01_seleccionNomina.js') }}"></script>
@endpush
