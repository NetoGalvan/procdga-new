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
    <form id="formGenerarDocumentoBajas" action="{{ route('movimiento.personal.bajas.documento.alimentario', [$movimientoPersonal, $instanciaTarea])}}" method="POST"> 
        @csrf
        <div class="card card-custom">
            <div class="card-body">
                @include("p01_movimientos_personal.tareas.partials.datos_general_bajas", [
                    "secciones" => [
                        "general" => ["datos_generales", "tipo_movimiento", "fecha_solicitud", "firmas", "procesamiento"],
                        "plaza" => [],
                        "candidato" => [],
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
                        href="{{ route('movimiento.personal.bajas.descargar.alimentario', $movimientoPersonal) }}">
                        <i class="fas fa-file-download"></i> Descargar alimentario
                    </a>
                    <button type="submit" class="btn btn-success"><i class="fas fa-check-square"></i> Finalizar proceso </button>
                </div>
            </div>
        </div>     
    </form>   
@endsection

@push('scripts')	
    <script src="{{ asset('js/p01_movimientos_personal/tareas/TB04_generarDocumentoBajas.js?v=1.1')}}"></script> 
@endpush
