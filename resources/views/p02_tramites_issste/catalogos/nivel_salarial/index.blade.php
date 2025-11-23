@extends('layouts.main')

@section('title', 'Niveles Salariales')

@section('subheader')
    @include('layouts.partials.main.subheader', ["subheader" => [
        "titulo_subheader" => "Niveles Salariales",
        "icono_titulo_subheader" => "far fa-folder-open",
        "breadcrumbs" => [
            1 => [
                "activo" => true,
                "titulo" => 'Inicio'
            ]
        ]
    ]])
@endsection

@section('aside_menu')
    @include('layouts.partials.main.aside_menu', ["asideMenu" =>
        [
            "item_seleccionado" => "catalogos",
        ]
    ])
@endsection

@section('contenido')
<div class="card card-custom">
    <div class="card-header">
        <div class="card-title">
        </div>
        <div class="card-toolbar">
            <a href="{{ Route('niveles-salariales.create') }}" class="btn btn-success" href="#" role="button">
                <i class="fas fa-plus"></i> Crear nivel salarial
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive table-bordered">
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-center">Nivel salarial</th>
                        <th class="text-center">Tipo personal</th>
                        <th class="text-center">Sueldo cotizable</th>
                        <th class="text-center">Sueldo sar</th>
                        <th class="text-center">Sueldo total</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($nivelesSalariales as $nivelSalarial)
                        <tr>
                            <td class="text-center">{{ $nivelSalarial->nombre }} </td>
                            <td class="text-center">{{ $nivelSalarial->tipo_personal }} </td>
                            <td class="text-center">{{ $nivelSalarial->sueldo_cotizable }} </td>
                            <td class="text-center">{{ $nivelSalarial->sueldo_sar }} </td>
                            <td class="text-center">{{ $nivelSalarial->sueldo_total }} </td>
                            <td class="text-center">
                                <a
                                    href="{{ Route('niveles-salariales.edit', $nivelSalarial) }}"
                                    class="btn btn-sm btn-primary" role="button">
                                    <i class="fas fa-pencil-alt p-0"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $nivelesSalariales->links() }}
        </div>
    </div>
</div>
@endsection
