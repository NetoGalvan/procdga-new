@extends('layouts.main')

@section('title', "MOVIMIENTOS DE PERSONAL - {$instanciaTarea->tarea->nombre}")

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
                'titulo' => "MOVIMIENTOS DE PERSONAL - {$instanciaTarea->tarea->nombre}"
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
    <form action="{{ route('movimiento.personal.altas.documento.alimentario', [$movimientoPersonal, $instanciaTarea])}}" method="POST" id="formGenerarDocumentoAltas"> 
        @csrf
        <div class="card card-custom">
            <div class="card-body">
                @include("p01_movimientos_personal.tareas.partials.datos_general", [
                    "secciones" => [
                        "general" => ["tipo_movimiento", "fecha_Solicitud", "procesamiento"],
                        "plaza" => [],
                        "candidato" => ["datos_psicometrico", "datos_adicionales", "datos_direccion"],
                        "movimiento" => []
                    ]
                ])
            </div>
        </div>  
        <div class="card card-custom mt-8">
            <div class="card-footer">
                <div class="text-center">
                    <a 
                        type="button"
                        id="btn_descargar_pdf"
                        class="btn btn-primary mr-2" 
                        href="{{ route('movimiento.personal.altas.descargar.alimentario', $movimientoPersonal) }}">
                        <i class="fas fa-file-download"></i> Descargar alimentario
                    </a>
                    <button type="submit" class="btn btn-success"><i class="fas fa-check-square"></i> Finalizar proceso </button>
                </div>
            </div>
        </div> 
    </form>
@endsection

@push('scripts')	
    <script src="{{ asset('js/p01_movimientos_personal/tareas/TA08_generarDocumentoAltas.js?v=1.0')}}"></script> 
@endpush