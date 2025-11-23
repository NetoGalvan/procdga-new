@extends('layouts.main')

@section('title', $instanciaTarea->tarea->nombre)

@section('subheader')
    @include('layouts.partials.main.subheader', ["subheader" => [
        "titulo_subheader" => "PROCDGA",
        "icono_titulo_subheader" => "far fa-folder-open",
        "breadcrumbs" => [
            1 => [
                'activo' => false,
                'titulo' => 'Tareas Disponibles',
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

@push('styles')
	<link href="{{ asset('metronic/plugins/custom/bootstraptable/css/bootstrap-table.min.css') }}" type="text/css" rel="stylesheet"/>
@endpush

@section('contenido')
    <div class="card card-custom">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">Detalle del proceso</h3>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 form-group">
                    <label class="titulo-dato"> Folio </label>
                    <span class="valor-dato">  {{ $pago->folio }} </span>
                </div>
            </div>
        </div>
    </div>
    <form id="form_agregar_presupuesto_area">
        <div class="card card-custom mt-8">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">
                        Agregar presupuesto por area
                    </h3>
                </div>
            </div>
            <div class="card-body">
                <div class="alert alert-custom alert-success" role="alert">
                    <div class="alert-icon mr-4"><i class="flaticon-warning"></i></div>
                    <div class="alert-text">
                        <strong>
                            <p class="mb-2">Instrucciones:</p>
                            <ul class="mb-2">
                                <li>Seleccione una área a la que desee agregar un presupuesto.</li>
                                <li>Agregue un presupuesto a la área seleccionada.</li>
                            </ul>
                            <p class="mb-0">
                                Nota: La convocatoria solo se enviará a las áreas que hayan sido agregadas en esta tabla.
                            </p>
                        </strong>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label class="titulo-dato"><strong><span class="text-danger">* </span>Area</strong></label>
                        <select class="form-control" name="area_id" autocomplete="off" required>
                            <option value="">Seleccionar una opción</option>
                            @foreach ($areas as $unidadA)
                                <option value="{{ $unidadA->area_id }}">{{ $unidadA->identificador }} - {{ $unidadA->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 form-group">
                        <label class="titulo-dato"><strong><span class="text-danger">* </span>Presupuesto</strong></label>
                        <input type="number" min="1" name="presupuesto" class="form-control" autocomplete="off" required/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 form-group">
                        <button type="
                        " class="btn btn-primary">
                            <i class="fas fa-plus"></i> Agregar
                        </button>
                    </div>
                    <div class="col-12">
                        <div class="table-responsive">
                            <table
                                id="tabla_presupuestos_por_area"
                                class="text-center"
                                data-toggle="table"
                                data-unique-id="area_id">
                                <thead>
                                    <tr>
                                        <th data-field="area_id" data-visible="false"><label class="titulo-dato">ID</label></th>
                                        <th data-field="nombre_area"><label class="titulo-dato">Área</label></th>
                                        <th data-field="presupuesto"><label class="titulo-dato">Presupuesto</label></th>
                                        <th data-field="acciones" data-formatter="accionesFormatter" data-events="operateEvents"><label class="titulo-dato">Acciones</label></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <form id="form_finalizar_tarea" method="POST" action="{{ route('tiempo.extraordinario.excedente.presupuesto.por.area', [$pago, $instanciaTarea]) }}">
        @csrf
        <input type="hidden" name="areas_presupuesto" />
        <div class="card card-custom mt-8">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">
                        Completar la información del proceso
                    </h3>
                </div>
            </div>
            <div class="card-body">
                <div class="alert alert-custom alert-success" role="alert">
                    <div class="alert-icon mr-4"><i class="flaticon-warning"></i></div>
                    <div class="alert-text">
                        <strong>
                            <p class="mb-2">Instrucciones:</p>
                            <ul class="mb-2">
                                <li>Seleccione la quincena correspondiente al proceso en curso.</li>
                                <li>Establezca la fecha límite para que las áreas envíen su información.</li>
                            </ul>
                        </strong>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label class="titulo-dato"><strong><span class="text-danger">* </span>Quincena</strong></label>
                        <select name="quincena" class="form-control" required>
                            <option value="">Seleccione una quincena</option>
                            @php
                                use Carbon\Carbon;
                            @endphp
                            @foreach (traerQuincenasActual(Carbon::now()->subMonths(3), Carbon::now()->subDays(15)) as $quincena)
                                <option value="{{ $quincena }}">{{ $quincena }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 form-group">
                        <label class="titulo-dato"><strong><span class="text-danger">* </span>Tipo</strong></label>
                        <select name="tipo" id="tipo" class="form-control" required>
                            <option value="NORMAL">NORMAL</option>
                            <option value="EXTEMPORANEA">EXTEMPORÁNEA</option>
                        </select>
                    </div>
                    <div class="col-md-4 form-group">
                        <label class="titulo-dato"><strong><span class="text-danger">* </span>Fecha limite</strong></label>
                        <input type="text" class="form-control input-date-current" name="fecha_limite" autocomplete="off" required>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="text-center">
                    <button type="submit" class="btn btn-success"><i class="fas fa-check-square"></i> Finalizar tarea</button>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
    <script>
        const formFinalizarTarea = $("#form_finalizar_tarea");
        const validatorFormFinalizarTarea = formFinalizarTarea.validate({
            submitHandler: function(form) {
                let areasAgregadas = tablaPresupuestoArea.bootstrapTable('getData');
                if (areasAgregadas.length == 0) {
                    Swal.fire("Para continuar, debe agregar al menos una área", "", "error");
                    return;
                }
                $("[name=areas_presupuesto]").val(JSON.stringify(areasAgregadas));
                Swal.fire({
                    title: "¿Está seguro?",
                    text: "Antes de continuar, verifique que los datos ingresados sean correctos. Después de finalizar la tarea, no podrá regresar.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Sí, continuar",
                    cancelButtonText: "Cancelar",
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {
                        KTApp.blockPage({
                            overlayColor: '#000000',
                            state: 'danger',
                            message: 'Por favor, espere...'
                        });
                        form.submit();
                    }
                });
            }
        });

        const tablaPresupuestoArea = $("#tabla_presupuestos_por_area");
        const formAgregarPresupuestoArea = $("#form_agregar_presupuesto_area");
        const validatorFormAgregarPresupuestoArea = formAgregarPresupuestoArea.validate({
            submitHandler: function (form) {
                let areaId = formAgregarPresupuestoArea.find("[name=area_id]").val();
                let areasAgregadas = tablaPresupuestoArea.bootstrapTable('getData');
                let existeArea = areasAgregadas.some(function (areaAgregada) {
                    return areaAgregada.area_id === areaId;
                });
                if (existeArea) {
                    swal.fire("La unidad administrativa que intenta agregar ya se encuentra dentro de la tabla.", "", "error");
                    return false;
                }
                tablaPresupuestoArea.bootstrapTable("insertRow", {
                    index: 0,
                    row: {
                        "area_id": formAgregarPresupuestoArea.find("[name=area_id]").val(),
                        "nombre_area": formAgregarPresupuestoArea.find("[name=area_id]").find("option:selected").text(),
                        "presupuesto": formAgregarPresupuestoArea.find("[name=presupuesto]").val(),
                    }
                });
                formAgregarPresupuestoArea.trigger("reset");
                validatorFormAgregarPresupuestoArea.resetForm();
            }
        });

        function accionesFormatter(value,row){
            return '<button type="button" class="btn btn-outline-danger btn-icon btn-eliminar-area"><i class="fas fa-trash-alt"></i></button>';
        }

        window.operateEvents = {
            'click .btn-eliminar-area' : function(e, value, row, index) {
                tablaPresupuestoArea.bootstrapTable('removeByUniqueId', row.area_id);
                swal.fire("La area se eliminó correctamente.", "", "success");
            }
        }
    </script>
    {{-- <script src="{{ asset('js/p16_pago_tiempo_extraordinario_excedente/tareas/T01_asignarPresupuestoAreas.js?v=1.0.9') }}"></script> --}}
@endpush
