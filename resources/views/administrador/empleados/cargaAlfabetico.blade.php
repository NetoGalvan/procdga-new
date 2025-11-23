@extends('layouts.main')

@section('title', 'Administración | Carga de alfabético')

@section('subheader')
    @include('layouts.partials.main.subheader', ["subheader" => [
        "titulo_subheader" => "PROCDGA",
        "icono_titulo_subheader" => "far fa-folder-open",
        "breadcrumbs" => [
            1 => [
                'activo' => false,
                'titulo' => 'Alfabético',
                'ruta' => Route('alfabetico.index')
            ],
            2 => [
                'activo' => true,
                'titulo' => 'Carga de alfabético'
            ]
        ]
    ]])
@endsection

@section('aside_menu')
    @include('layouts.partials.main.aside_menu', ["asideMenu" =>
        [
            "item_seleccionado" => "admin.alfabetico",
        ]
    ])
@endsection

@section('contenido')

        <form
            method="POST"
            id="form_carga_alfabetico"
            action="{{ route('alfabetico.carga.alfabetico', [$alfabetico]) }}"
            enctype="multipart/form-data"
        >
        @method('post')
        @csrf
            @php
                use Carbon\Carbon;
            @endphp
            <div class="card card-custom mb-5">
                <div class="card-header">
                    <div class="card-title">
                        <h3 class="card-label">Alfabético</h3>
                    </div>
                </div>
                <div class="card-body">
                    <div class="alert alert-custom alert-outline-success" role="alert">
                        <div class="alert-icon"><i class="flaticon-warning"></i></div>
                        <div class="alert-text">
                            Debes cargar el archivo correspondiente y seleccionar la quincena.
                        </div>
                    </div>
                    <p> <span class="requeridos">Campos obligatorios (*)</span> </p>
                </div>
            </div>

            <div class="card card-custom mb-5">
                <div class="card-header">
                    <div class="card-title">
                        <h3 class="card-label">Cargar alfabético</h3>
                    </div>
                </div>

                <div class="card-body" >
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="quincena" class="titulo-dato"><strong><span class="text-danger">* </span>Quincena</strong></label>
                            <select name="quincena" id="quincena" class="form-control" required>
                                <option value="">SELECCIONA QUINCENA</option>
                                @foreach (traerQuincenasActual(Carbon::now()->subYear(), Carbon::now()) as $quincena)
                                <option value="{{ $quincena }}">{{ $quincena }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12"  id="contenedor_dropzone_txt" >
                            {{-- Contenedor dropZone --}}
                        </div>
                        <div class="form-group col-md-12" id="contenedor_tabla_txt">
                            {{-- Contenedor tabla TXT --}}
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="text-center">
                        <button type="submit" id="btn_finalizar_seleccion_servicio" class="btn btn-success"><i class="fas fa-check-square"></i> Cargar alfabético </button>
                        {{-- <button type="button" id="btn_cancelar_seleccion_servicio" class="btn btn-danger"><i class="fas fa-times"></i>Cancelar proceso </button> --}}
                    </div>
                </div>

            </div>

        </form>

@endsection

@push('styles')
    <link href="{{ asset('metronic/plugins/custom/bootstraptable/css/bootstrap-table.min.css') }}" type="text/css" rel="stylesheet"/>
@endpush

@push('scripts')
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('metronic/plugins/custom/bootstraptable/js/bootstrap-table-es-SP.js') }}"></script>
    <script src="{{ asset('js/administrador/empleados/cargaAlfabetico.js?ver=1.0') }}"></script>
    <script>
        const archivos = @json($archivos);
        const urlEliminarTXT = @json(route('alfabetico.carga.alfabetico.eliminar.txt'));
        const urlDropZone = @json(route('alfabetico.carga.alfabetico.guardar.txt', [$alfabetico->alfabetico_id]));
    </script>
@endpush
